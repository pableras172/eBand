<?php

namespace App\Http\Controllers;

use App\Exports\InventoryItemsExport;
use App\Models\InventoryItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class InventoryExportController extends Controller
{
    public function excel()
    {
        $this->authorize('create', InventoryItem::class);

        $year = request()->integer('year') ?: null;

        return Excel::download(new InventoryItemsExport($year), 'inventario.xlsx');
    }

    public function pdf()
    {
        $this->authorize('create', InventoryItem::class);

        $year = request()->integer('year') ?: null;

        $items = InventoryItem::query()
            ->with(['category', 'responsables'])
            ->when($year, function ($query, $selectedYear): void {
                $query->where('year', $selectedYear);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.inventory', [
            'items' => $items,
            'year' => $year,
        ]);

        return $pdf->download('inventario.pdf');
    }
}
