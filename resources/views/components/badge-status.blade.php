@props([
    'status' => 'available', // available, pending, unavailable, instrument, priority, neutral
    'size' => 'md', // sm, md, lg
    'dot' => false,
])

@php
$normalized = strtolower(trim((string) $status));

$map = [
    'available'   => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/25',
    'si'          => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/25',
    'confirmado'  => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/25',
    '1'           => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/25',

    'pending'     => 'bg-amber-500/15 text-amber-400 border-amber-500/25',
    'duda'        => 'bg-amber-500/15 text-amber-400 border-amber-500/25',

    'unavailable' => 'bg-rose-500/15 text-rose-400 border-rose-500/25',
    'no'          => 'bg-rose-500/15 text-rose-400 border-rose-500/25',
    'ausente'     => 'bg-rose-500/15 text-rose-400 border-rose-500/25',
    '0'           => 'bg-rose-500/15 text-rose-400 border-rose-500/25',

    'priority'    => 'bg-rose-600/90 text-white border-rose-400/30 shadow-sm shadow-rose-950/40',
    'obligatorio' => 'bg-rose-600/90 text-white border-rose-400/30 shadow-sm shadow-rose-950/40',

    'instrument'  => 'bg-slate-800/90 text-slate-300 border-slate-700/60',
    'neutral'     => 'bg-slate-900/80 text-slate-400 border-slate-800',
];

$variantClasses = $map[$normalized] ?? $map['neutral'];

$sizes = [
    'sm' => 'px-2 py-0.5 text-[11px] gap-1',
    'md' => 'px-2.5 py-1 text-xs gap-1.5',
    'lg' => 'px-3 py-1.5 text-sm gap-2',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];

$dotColors = [
    'available'   => 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]',
    'si'          => 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]',
    'confirmado'  => 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]',
    '1'           => 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]',

    'pending'     => 'bg-amber-400 shadow-[0_0_6px_rgba(251,191,36,0.8)]',
    'duda'        => 'bg-amber-400 shadow-[0_0_6px_rgba(251,191,36,0.8)]',

    'unavailable' => 'bg-rose-400 shadow-[0_0_6px_rgba(251,113,133,0.8)]',
    'no'          => 'bg-rose-400 shadow-[0_0_6px_rgba(251,113,133,0.8)]',
    'ausente'     => 'bg-rose-400 shadow-[0_0_6px_rgba(251,113,133,0.8)]',
    '0'           => 'bg-rose-400 shadow-[0_0_6px_rgba(251,113,133,0.8)]',

    'priority'    => 'bg-white',
    'obligatorio' => 'bg-white',
    'neutral'     => 'bg-slate-400',
];
$dotClass = $dotColors[$normalized] ?? 'bg-slate-400';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-medium rounded-full border tracking-wide $variantClasses $sizeClasses"]) }}>
    @if ($dot)
        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $dotClass }}"></span>
    @endif
    {{ $slot }}
</span>
