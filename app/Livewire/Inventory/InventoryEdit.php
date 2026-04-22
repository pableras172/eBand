<?php

namespace App\Livewire\Inventory;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InventoryEdit extends Component
{
    public InventoryItem $item;

    public ?int $inventory_category_id = null;

    public string $nombre = '';

    public int $cantidad = 1;

    public float $valor_unitario = 0;

    public string $estado = 'nuevo';

    public ?string $observaciones = null;

    public float $depreciation_rate = 0;

    public ?string $purchase_date = null;

    public array $responsables = [];

    public array $availableUsers = [];

    public function mount(): void
    {
        $this->authorize('update', $this->item);

        $this->inventory_category_id = $this->item->inventory_category_id;
        $this->nombre = $this->item->nombre;
        $this->cantidad = $this->item->cantidad;
        $this->valor_unitario = $this->item->valor_unitario;
        $this->estado = $this->item->estado;
        $this->observaciones = $this->item->observaciones;
        $this->depreciation_rate = $this->item->depreciation_rate;
        $this->purchase_date = $this->item->purchase_date?->format('Y-m-d');
        $this->responsables = $this->item->responsables->pluck('id')->toArray();
        $this->availableUsers = User::all()->pluck('name', 'id')->toArray();
    }

    protected function rules(): array
    {
        return [
            'inventory_category_id' => 'required|exists:inventory_categories,id',
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'valor_unitario' => 'required|numeric|min:0',
            'estado' => 'required|in:nuevo,usado,desperfectos,dañado',
            'observaciones' => 'nullable|string',
            'depreciation_rate' => 'nullable|numeric|min:0|max:100',
            'purchase_date' => 'nullable|date',
            'responsables' => 'nullable|array',
            'responsables.*' => 'exists:users,id',
        ];
    }

    public function save(): void
    {
        $this->authorize('update', $this->item);

        $validated = $this->validate();

        $this->item->update($validated);

        // Actualizar responsables
        $this->item->responsables()->sync($this->responsables);

        // Crear movimiento de actualización
        InventoryMovement::create([
            'inventory_item_id' => $this->item->id,
            'user_id' => Auth::id(),
            'tipo' => 'actualizacion',
            'descripcion' => 'Item actualizado en el inventario',
        ]);

        session()->flash('message', 'Item actualizado exitosamente.');
        $this->redirect(route('inventory.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.inventory.inventory-edit', [
            'categories' => InventoryCategory::all(),
        ]);
    }
}
