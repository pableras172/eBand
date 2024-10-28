@props([
    'forCrud' => false
])

@php
$allClasses = [
    'px-4 py-2 text-xs font-medium text-center uppercase' => true,
    'cursor-pointer' => $forCrud,
];

$classes = join(' ', array_keys(array_filter($allClasses)));
@endphp

<th {!! $attributes->merge(['class' => $classes]) !!}>
    {{ $slot }}
</th>