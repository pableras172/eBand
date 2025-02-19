@props([
    'forCrud' => false,
    'width' => null // Nueva opción para definir el ancho de la columna
])

@php
$allClasses = [
    'px-5 py-3 text-xs font-medium text-left uppercase' => true,
    'max-w-xs truncate' => $forCrud,
];

if ($width) {
    $allClasses["w-[$width]"] = true; // Aplicar ancho si se define
}

$classes = join(' ', array_keys(array_filter($allClasses)));
@endphp

<td {!! $attributes->merge(['class' => $classes]) !!}>
    {{ $slot }}
</td>