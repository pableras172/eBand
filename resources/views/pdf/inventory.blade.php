<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 6px;
        }

        .meta {
            margin-bottom: 12px;
            color: #4b5563;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Inventario {{ $year ? '('.$year.')' : '' }}</h1>
    <p class="meta">Generado el {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Año</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Valor total</th>
                <th>Estado</th>
                <th>Responsables</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->year }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->category?->nombre ?? '-' }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>€{{ number_format($item->valor_total, 2, ',', '.') }}</td>
                    <td>{{ ucfirst($item->estado) }}</td>
                    <td>{{ $item->responsables->pluck('name')->join(', ') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay items para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
