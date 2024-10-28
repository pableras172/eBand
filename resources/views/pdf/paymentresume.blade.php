<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payment Resume</title>
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
            width: 100%;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body style="font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif;">
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
                    <img alt="" src="{{$base64}}" width="125" />
                </td>
                <th width="50%" align="right">
                    <h1>{{__('Pagaments')}}</h1>
                </th>
            </tr>
        </tbody>
    </table>
    <table width="700px" align="center" cellpadding="5" style="">
        <tbody>
            <tr>
                <th colspan="4" class="fondoNegro">{{ $paymentresume->descripcion }}</th>
            </tr>
            <tr>
                <th align="left" valign="middle" class="fondoNegro">{{__('Fecha pago')}}</th>
                <td align="center" valign="middle">{{ \Carbon\Carbon::parse($paymentresume->created_at)->format('d/m/Y') }}</td>
            </tr>
        </tbody>
    </table>
    <hr width="700px">

    <table width="700px">
        <thead>
            <tr>
                <th>{{ __('Descripción') }}</th>
                <th>{{ __('Nombre') }}</th>
                <th>{{ __('Total Pago') }}</th>
                <th width="100px">{{ __('Firma') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paymentresume->payments as $payment)
                <tr @if ($loop->index % 2 != 0) style="background-color:#f0f0f0;" @endif>
                    <td>{{ $payment->descripcion }}</td>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->totalPago }}</td>
                    <td height="75px"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
