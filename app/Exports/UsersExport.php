<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(
        private readonly ?int $instrumentId = null,
        private readonly ?string $nombre = null,
        private readonly ?string $activo = null,
        private readonly bool $soloPadres = false,
    ) {}

    /**
     * @return Collection<int, User>
     */
    public function collection(): Collection
    {
        $query = User::query()
            ->with(['roles', 'instrument', 'hijos'])
            ->orderBy('name', 'asc');

        if ($this->instrumentId) {
            $query->where('instrument_id', $this->instrumentId);
        }

        if ($this->soloPadres) {
            $query->whereHas('hijos');
        }

        if ($this->nombre) {
            $query->where('name', 'like', '%'.$this->nombre.'%');
        }

        if ($this->activo !== null && $this->activo !== '') {
            $query->where('activo', (int) $this->activo);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Email',
            'Telefon',
            'DNI',
            'Instrument',
            'Actiu',
            'Foraster',
            'Percentaje',
            'Data Alta',
            'Roles',
        ];
    }

    /**
     * @param  User  $user
     */
    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->telefono,
            $user->dni,
            $user->instrument?->name,
            $user->activo ? 'Sí' : 'No',
            $user->forastero ? 'Sí' : 'No',
            $user->porcentaje,
            $user->fechaAlta,
            $user->roles->pluck('title')->join(', '),
        ];
    }
}
