<?php

namespace App\Livewire\Inventory;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InventoryCreate extends Component
{
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
        /** @var User $user */
        $user = Auth::user();

        $this->availableUsers = $user->can('create', InventoryItem::class) ?
            User::all()->pluck('name', 'id')->toArray() : [];
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
        $this->authorize('create', InventoryItem::class);

        $validated = $this->validate();
        $validated['year'] = now()->year;

        $item = InventoryItem::create($validated);

        // Asignar responsables
        if (! empty($this->responsables)) {
            $item->responsables()->attach($this->responsables);
        }

        // Crear movimiento de registro
        InventoryMovement::create([
            'inventory_item_id' => $item->id,
            'user_id' => Auth::id(),
            'tipo' => 'compra',
            'descripcion' => 'Item registrado en el inventario',
        ]);

        session()->flash('message', 'Item creado exitosamente.');
        $this->redirect(route('inventory.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.inventory.inventory-create', [
            'categories' => InventoryCategory::all(),
        ]);
    }
}
