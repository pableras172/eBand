<?php

namespace App\Exports;

use App\Models\InventoryItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryItemsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(private readonly ?int $year = null) {}

    /**
     * @return Collection<int, InventoryItem>
     */
    public function collection(): Collection
    {
        $query = InventoryItem::query()->with(['category', 'responsables']);

        if ($this->year) {
            $query->where('year', $this->year);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Año',
            'Nombre',
            'Categoría',
            'Cantidad',
            'Valor unitario',
            'Valor total',
            'Estado',
            'Responsables',
            'Fecha compra',
            'Observaciones',
        ];
    }

    /**
     * @param  InventoryItem  $item
     */
    public function map($item): array
    {
        return [
            $item->id,
            $item->year,
            $item->nombre,
            $item->category?->nombre,
            $item->cantidad,
            $item->valor_unitario,
            $item->valor_total,
            $item->estado,
            $item->responsables->pluck('name')->join(', '),
            $item->purchase_date?->format('Y-m-d'),
            $item->observaciones,
        ];
    }
}
