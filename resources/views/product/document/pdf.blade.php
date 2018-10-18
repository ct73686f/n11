<html>
<head>
    <title>Movimiento</title>
    <style type="text/css">
        @page { margin-top: 0px; margin-bottom: 0px; }

        * {
            font-family: "Courier New", Courier, monospace;
            font-size: 12px;
            font-weight: bold;
            margin:0;
            padding:0;
        }

        #page-wrap {
            width: 190px;
            margin: 0 10px;
        }
        .center-justified {
            text-align: justify;
            margin: 0 auto;
            width: 30em;
        }

        table {
            border-spacing: 0;
        }
        table.outline-table {
            border: 1px solid;
            border-spacing: 0;
        }
        tr.border-bottom td, td.border-bottom {
            border-bottom: 1px solid;
        }
        tr.border-top td, td.border-top {
            border-top: 1px solid;
        }
        tr.border-right td, td.border-right {
            border-right: 1px solid;
        }
        tr.border-right td:last-child {
            border-right: 0px;
        }
        tr.center td, td.center {
            text-align: center;
            vertical-align: text-top;
        }
        td.pad-left {
            padding-left: 5px;
        }
        tr.right-center td, td.right-center {
            text-align: right;
            padding-right: 50px;
        }
        tr.right td, td.right {
            text-align: right;
        }
        tr.left td, td.left {
            text-align: left;
        }

        .logo {
            width: 80px;
            height: auto;
        }
    </style>
</head>
<body>
<div id="page-wrap">
    <table width="100%" style="padding: 0; margin: 0;">
        <tbody>
        <tr>
            <td style="padding: 0; text-align: center;">
                <img class="logo" src="{{ url('img/logo.png') }}">
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 20px 0px;">
                <strong>Número:</strong> {{ $document->id }}<br>
                <strong>Fecha:</strong> {{ $document->created_at->format('d/m/Y H:i A') }}<br>
            </td>
        </tr>
        <tr>
            <td >&nbsp;</td>
        </tr>
        <tr>
            <td>
                <div>
                    <strong>Tipo de Salida:</strong><br>{{ $document->output_type }} <br>
                    <strong>Monto a pagar: </strong> Q. {{ number_format($total, 2, '.', ',') }}
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table width="100%" class="outline-table">
        <tbody>
        <tr class="border-bottom border-right">
            <td colspan="4"><strong>Detalles</strong></td>
        </tr>
        <tr>
            <td width="10%" class="border-bottom border-right left"><strong>Cnt</strong></td>
            <td width="40%" class="border-bottom border-right left"><strong>Descripción</strong></td>
            <td width="25%" class="border-bottom border-right right"><strong>Precio</strong></td>
            <td width="25%" class="border-bottom right"><strong>Subtotal</strong></td>
        </tr>
        @foreach ($document->movements as $movement)
            @foreach ($movement->details as $detail)
                <tr>
                    <td class="border-right left">{{ $detail->quantity }}</td>
                    <td class="border-right left">{{ $detail->product->description }}</td>
                    <td class="border-right right">{{ number_format($detail->price, 2, '.', ',') }}</td>
                    <td class="right">{{ $detail->sub_total }}</td>
                </tr>
            @endforeach
        @endforeach

        <tr class="border-right">
            <td class="pad-left border-top left">&nbsp;</td>
            <td class="pad-left border-top left">&nbsp;</td>
            <td style="vertical-align: middle;" class="center border-top right"><strong>Total</strong></td>
            <td class="right border-top">{{ number_format($total, 2, '.', ',') }}</td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table>
        <tbody>
        <tr>
            <td>
                <strong>Descripción:</strong> <br> {{ $document->description }}
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>