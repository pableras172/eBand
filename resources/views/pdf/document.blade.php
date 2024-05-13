<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Lista</title>
    <style type="text/css">
        .fondoNegro {
            background-color: #7E7E7E;
            color: white;
            padding: 10px;
            font-size: 20px;
            font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
            font-weight: bold;
        }
    </style>    
</head>

<body
    style="font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif;">
    <table width="700px" align="center">
        <?php
            $path = '../public/imagenes/logo.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>
        <tbody>
            <tr>
                <td width="50%">
                    <img alt="" src="{{$base64}}"
                        width="125" />
                </td>
                <th width="50%" align="right">
                    <h1>Actuació</h1>
            </tr>
        </tbody>
    </table>
    <table width="700px" align="center" cellpadding="5" style="">
        <tbody>
            <tr>
                <th colspan="6" class="fondoNegro">{{ $actuacion->descripcion }}</th>
            </tr>
            <tr>
                <th width="100px" align="left" valign="middle" class="fondoNegro">Municipio</th>
                <td width="120px" align="center" valign="middle">{{ $actuacion->contrato->poblacion }}</td>
                <th width="50px" align="left" valign="middle" class="fondoNegro">Músicos</th>
                <td width="50px" align="center" valign="middle">{{ $actuacion->musicos }}</td>
                <th width="50px" align="left" valign="middle" class="fondoNegro">Cotxes</th>
                <td width="50px" align="center">{{ $actuacion->coches }}</td>
            </tr>            
        </tbody>
    </table>
    <div>
    <div><h2>Observaciones</h2></div>
    <div>{{ $actuacion->observaciones}}</div>    
    </div>
    <hr width="700px">
        <?php
            $path = '../public/imagenes/car.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $carBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        ?>

@php
    $columnas = 5; // número de columnas
    $maxCeldasPorFila = 5; // máximo de celdas por fila
    $usuariosPorColumna = ceil(count($usuarios) / $columnas); // calcular cuántos usuarios por columna
    $filaImpar = true; // variable para controlar el color de fondo de las filas
@endphp

<table width="100%" cellpadding="5">
    <tbody>
        @foreach ($usuarios->groupBy('instrument_id') as $instrumento => $usuariosDelInstrumento)
            <tr>
                <th bgcolor="#65949C" colspan="{{ $columnas }}" align="center" valign="middle" nowrap="nowrap" scope="col">
                    {{ $usuariosDelInstrumento->first()->instrument->name }}
                    ({{ $usuariosDelInstrumento->where('seleccionado', true)->count() }})</th>
            </tr>

            @php $usersChunked = $usuariosDelInstrumento->sortBy('name')->sortBy('forastero')->chunk($usuariosPorColumna); @endphp

            @foreach ($usersChunked as $chunk)
                <tr @if ($filaImpar) bgcolor="#f2f2f2" @endif>
                    @php $celdasEnFila = 0; @endphp

                    @foreach ($chunk as $user)
                        @if (!$user->seleccionado)
                            @continue
                        @endif

                        <td style="text-align: center; vertical-align: middle; white-space: nowrap;">
                            {{ $user->name }}
                            @if ($user->coche)
                                <img src="{{$carBase64}}" width="20px" />
                            @endif
                        </td>

                        @php $celdasEnFila++; @endphp
                        @if ($celdasEnFila == $maxCeldasPorFila)
                            @php $celdasEnFila = 0; @endphp
                            </tr><tr @if ($filaImpar) bgcolor="#f2f2f2" @endif>
                        @endif
                    @endforeach

                    @if ($celdasEnFila < $maxCeldasPorFila)
                        @for ($i = $celdasEnFila; $i < $maxCeldasPorFila; $i++)
                            <td style="text-align: center; vertical-align: middle; white-space: nowrap;"></td>
                        @endfor
                    @endif

                    @php $filaImpar = !$filaImpar; @endphp
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>




    
    
</body>

</html>
