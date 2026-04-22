<?php

namespace App\Livewire\Inventory;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $selectedCategory = null;

    public ?string $selectedState = null;

    public ?int $selectedYear = null;

    public array $states = ['nuevo', 'usado', 'desperfectos', 'dañado'];

    public bool $isAdmin = false;

    public function mount(): void
    {
        $this->authorize('viewAny', InventoryItem::class);

        /** @var User $user */
        $user = Auth::user();

        $this->isAdmin = $user->hasRole('SuperAdmin') || $user->hasRole('Admin');
        $years = $this->getYears();
        $currentYear = now()->year;

        $this->selectedYear = in_array($currentYear, $years, true) ? $currentYear : ($years[0] ?? null);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedState(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedYear(): void
    {
        $this->resetPage();
    }

    public function getCategories(): Collection
    {
        return InventoryCategory::all();
    }

    public function getYears(): array
    {
        return $this->baseQuery()
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
    }

    protected function baseQuery(): Builder
    {
        $query = InventoryItem::query();

        if (! $this->isAdmin) {
            $query->whereHas('responsables', function (Builder $builder): void {
                $builder->where('users.id', Auth::id());
            });
        }

        return $query;
    }

    protected function filteredQuery(): Builder
    {
        $query = $this->baseQuery();

        if ($this->selectedYear) {
            $query->where('year', $this->selectedYear);
        }

        if ($this->selectedCategory) {
            $query->where('inventory_category_id', $this->selectedCategory);
        }

        if ($this->selectedState) {
            $query->where('estado', $this->selectedState);
        }

        if ($this->search) {
            $query->where(function (Builder $builder): void {
                $builder->where('nombre', 'like', '%'.$this->search.'%')
                    ->orWhere('observaciones', 'like', '%'.$this->search.'%');
            });
        }

        return $query;
    }

    public function render()
    {
        $items = $this->filteredQuery()
            ->with(['category', 'responsables', 'movements'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.inventory.inventory-index', [
            'items' => $items,
            'categories' => $this->getCategories(),
            'years' => $this->getYears(),
            'isAdmin' => $this->isAdmin,
        ]);
    }
}
