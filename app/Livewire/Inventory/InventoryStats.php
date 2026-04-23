<?php

namespace App\Livewire\Inventory;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class InventoryStats extends Component
{
    public function mount(): void
    {
        $this->authorize('viewAny', InventoryItem::class);

        /** @var User $user */
        $user = Auth::user();

        abort_unless($user->hasRole('SuperAdmin') || $user->hasRole('Admin'), 403);
    }

    /**
     * @return array{
     *   totalValue: float,
     *   categories: array<int, array{
     *     id: int,
     *     nombre: string,
     *     totalValue: float,
     *     percentage: float,
     *     items: array<int, array{nombre: string, value: float}>
     *   }>
     * }
     */
    public function getStatsData(): array
    {
        $categories = InventoryCategory::query()
            ->with(['items'])
            ->get();

        $totalValue = InventoryItem::query()
            ->get()
            ->sum(fn (InventoryItem $item): float => $item->valor_total);

        $categoryData = $categories->map(function (InventoryCategory $category) use ($totalValue): array {
            $categoryTotal = $category->items->sum(fn (InventoryItem $item): float => $item->valor_total);
            $percentage = $totalValue > 0 ? round(($categoryTotal / $totalValue) * 100, 1) : 0;

            $items = $category->items->map(fn (InventoryItem $item): array => [
                'nombre' => $item->nombre,
                'value' => $item->valor_total,
            ])->values()->all();

            return [
                'id' => $category->id,
                'nombre' => $category->nombre,
                'totalValue' => $categoryTotal,
                'percentage' => $percentage,
                'items' => $items,
            ];
        })->filter(fn (array $cat): bool => $cat['totalValue'] > 0)
            ->sortByDesc('totalValue')
            ->values()
            ->all();

        return [
            'totalValue' => $totalValue,
            'categories' => $categoryData,
        ];
    }

    public function render(): View
    {
        $stats = $this->getStatsData();

        return view('livewire.inventory.inventory-stats', [
            'stats' => $stats,
        ]);
    }
}
