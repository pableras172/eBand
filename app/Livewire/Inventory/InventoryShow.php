<?php

namespace App\Livewire\Inventory;

use App\Models\InventoryItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InventoryShow extends Component
{
    public InventoryItem $item;

    public bool $isAdmin = false;

    public bool $confirmingDeletion = false;

    public function mount(): void
    {
        $this->authorize('view', $this->item);

        /** @var User $user */
        $user = Auth::user();
        $this->isAdmin = $user->hasRole('SuperAdmin') || $user->hasRole('Admin');
    }

    public function confirmDelete(): void
    {
        $this->confirmingDeletion = true;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeletion = false;
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->item);

        $this->item->delete();

        session()->flash('message', __('Material eliminat correctament de l\'inventari.'));
        $this->redirect(route('inventory.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.inventory.inventory-show', [
            'item' => $this->item->loadMissing(['category', 'responsables', 'movements.user']),
            'isAdmin' => $this->isAdmin,
        ]);
    }
}
