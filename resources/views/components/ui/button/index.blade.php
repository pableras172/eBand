@props([
    'variant' => 'primary', // primary, secondary, success, danger, outline, ghost
    'size' => 'md', // sm, md, lg
    'icon' => null,
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-full transition-all duration-200 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none select-none';

$variants = [
    'primary'   => 'bg-blue-600 hover:bg-blue-500 text-white font-semibold shadow-lg shadow-blue-900/30 border border-blue-500/40 focus:ring-blue-500',
    'secondary' => 'bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold shadow-md shadow-amber-950/40 border border-amber-400/40 focus:ring-amber-500',
    'success'   => 'bg-emerald-600 hover:bg-emerald-500 text-white font-semibold shadow-lg shadow-emerald-950/40 border border-emerald-400/30 focus:ring-emerald-500',
    'danger'    => 'bg-rose-600 hover:bg-rose-500 text-white font-semibold shadow-lg shadow-rose-950/40 border border-rose-400/30 focus:ring-rose-500',
    'outline'   => 'bg-slate-900/80 hover:bg-slate-800 text-slate-200 border border-slate-700/80 hover:border-blue-400/60 focus:ring-slate-500',
    'ghost'     => 'bg-transparent hover:bg-slate-800/70 text-slate-300 hover:text-white border border-transparent focus:ring-slate-500',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-xs gap-1.5 min-h-[36px]',
    'md' => 'px-4 py-2 text-sm gap-2 min-h-[44px]',
    'lg' => 'px-6 py-3 text-base gap-2.5 min-h-[48px]',
];

$variantClass = $variants[$variant] ?? $variants['primary'];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => "$baseClasses $variantClass $sizeClass"]) }}>
    @if ($icon)
        <span class="material-symbols-outlined text-[18px] shrink-0">{{ $icon }}</span>
    @endif
    {{ $slot }}
</button>
