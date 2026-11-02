<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Actividad;
use App\Models\ActividadInscripcion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActividadInscritosExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(private readonly Actividad $actividad) {}

    /**
     * @return Collection<int, ActividadInscripcion>
     */
    public function collection(): Collection
    {
        return ActividadInscripcion::query()
            ->where('actividad_id', $this->actividad->id)
            ->with(['user', 'items.opcion'])
            ->orderBy('fecha_inscripcion', 'asc')
            ->get();
    }

    /**
     * @return list<string>
     */
    public function headings(): array
    {
        return [
            'ID',
            'Músico',
            'Email',
            'Asistencia',
            'Fecha Inscripción',
            'Opciones y Menús',
            'Total (€)',
            'Estado Pago',
            'Método Pago',
            'Fecha Pago',
            'Observaciones / Alergias',
        ];
    }

    /**
     * @param  ActividadInscripcion  $row
     * @return list<mixed>
     */
    public function map($row): array
    {
        $opcionesDesglose = $row->items->map(function ($item): string {
            $nombreOpcion = $item->opcion->titulo ?? 'Opción';

            return "{$item->cantidad}x {$nombreOpcion}";
        })->implode(', ');

        return [
            $row->id,
            $row->nombre_completo,
            $row->user->email ?? '-',
            $row->asiste ? 'Asiste' : 'No asistirá (No voy)',
            $row->fecha_inscripcion ? $row->fecha_inscripcion->format('d/m/Y H:i') : '',
            $opcionesDesglose,
            number_format((float) $row->total, 2, ',', ''),
            $row->pagado ? 'Pagado' : 'Pendiente',
            $row->metodo_pago ? ucfirst($row->metodo_pago) : '',
            $row->fecha_pago ? $row->fecha_pago->format('d/m/Y H:i') : '',
            $row->observaciones_alergias ?? '',
        ];
    }
}
