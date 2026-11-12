@props([
    'variant' => 'default', // default, elevated, hero, well
    'padded' => true,
])

@php
$baseClasses = 'rounded-2xl border border-slate-800 transition-all';
$variants = [
    'default'  => 'bg-slate-900/90 shadow-xl shadow-black/40',
    'elevated' => 'bg-slate-800/80 shadow-lg shadow-black/30',
    'hero'     => 'bg-gradient-to-b from-slate-900/95 to-slate-950/95 shadow-xl shadow-black/50',
    'well'     => 'bg-slate-950/80 border-slate-800/80',
];
$paddingClasses = $padded ? 'p-4 sm:p-5' : '';
@endphp

<div {{ $attributes->merge(['class' => "$baseClasses " . ($variants[$variant] ?? $variants['default']) . " $paddingClasses"]) }}>
    {{ $slot }}
</div>
