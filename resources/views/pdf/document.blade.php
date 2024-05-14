<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Lista</title>
    <style type="text/css">
        .fondoNegro {
            background-color: #7E7E7E;
            color: white;
            padding: 8px;
            font-size: 18px;
            font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
            font-weight: bold;
        }
        .usuario {
            margin-bottom: 10px;
            list-style: none; /* Eliminar los puntos de la lista */
        }
        .nombre {
            font-weight: bold;
        }
        .car-img {
            width: 20px;
            vertical-align: middle;
        }
        .columna {
            width: 30%;
            float: left;
            margin-right: 10px; /* Espacio entre columnas */
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
                    <h1>{{__('Llista')}}</h1>
            </tr>
        </tbody>
    </table>
    <table width="700px" align="center" cellpadding="5" style="">
        <tbody>
            <tr>
                <th colspan="6" class="fondoNegro">{{ $actuacion->descripcion }}</th>
            </tr>
            <tr>
                <th width="100px" align="left" valign="middle" class="fondoNegro">{{__('Població')}}</th>
                <td width="120px" align="center" valign="middle">{{ $actuacion->contrato->poblacion }}</td>
                <th width="50px" align="left" valign="middle" class="fondoNegro">{{__('Numero musics')}}</th>
                <td width="50px" align="center" valign="middle">{{ $actuacion->musicos }}</td>
                <th width="50px" align="left" valign="middle" class="fondoNegro">{{__('Cantitat de cotxes')}}</th>
                <td width="50px" align="center">{{ $actuacion->coches }}</td>
            </tr>            
        </tbody>
    </table>
    <div>
        <div><h2>{{__('Observacions')}}</h2></div>
        <div>{{ $actuacion->observaciones}}</div>    
    </div>
    <hr width="700px">
    <?php
        $path = '../public/imagenes/car.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $carBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>

    <?php
        $usuariosPorColumna = ceil(count($usuarios) / 3); // calcular cuántos usuarios por columna
        $contadorUsuarios = 0;
        $contadorColumnas = 0;
    ?>

    @foreach ($usuarios as $usuario)
        @if ($contadorUsuarios % $usuariosPorColumna === 0)
            <div class="columna">
        @endif

        <ul>
            @if ($loop->first || $usuario->instrument->name != $usuarios[$loop->index - 1]->instrument->name)
                <li class="fondoNegro">{{ $usuario->instrument->name }}</li>
            @endif
            <li class="usuario" @if ($loop->index % 2 != 0) style="background-color:#f0f0f0;padding-top: 5px;padding-bottom: 5px;" @endif>
                <span class="nombre" >{{ $usuario->name }}</span>
                @if ($usuario->pivot->coche)
                    <img src="{{$carBase64}}" class="car-img" />
                @endif
            </li>
        </ul>

        @php $contadorUsuarios++; @endphp

        @if ($contadorUsuarios % $usuariosPorColumna === 0 || $loop->last)
            </div>
        @endif

        @if ($contadorUsuarios % $usuariosPorColumna === 0)
            @php $contadorColumnas++; @endphp
        @endif

        @if ($contadorColumnas == 3)
            @break
        @endif
    @endforeach

</body>

</html>
