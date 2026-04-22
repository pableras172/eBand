<?php

namespace App\Livewire\Inventory;

use App\Models\InventoryItem;
use Livewire\Component;

class InventoryShow extends Component
{
    public InventoryItem $item;

    public function mount(): void
    {
        $this->authorize('view', $this->item);
    }

    public function render()
    {
        return view('livewire.inventory.inventory-show', [
            'item' => $this->item->loadMissing(['category', 'responsables', 'movements.user']),
        ]);
    }
}
