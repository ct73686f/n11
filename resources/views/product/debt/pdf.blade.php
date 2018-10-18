<html>
<head>
    <title>Factura</title>
    <style type="text/css">
        #page-wrap {
            width: 700px;
            margin: 0 auto;
        }
        .center-justified {
            text-align: justify;
            margin: 0 auto;
            width: 30em;
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
        .grey {
            background:grey;
        }

        .logo {
            width: 600px;
        }
    </style>
</head>
<body>
<div id="page-wrap">
    <table width="100%">
        <tbody>
        <tr>
            <td style="padding: 40px 20px 0 20px; text-align: center;">
                <img class="logo" width="100%" height="auto" src="{{ url('img/logo.png') }}">
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 40px 0px;">
                <h2>Factura</h2><br>
                <strong>Factura Número:</strong> {{ $invoice->id }}<br>
                <strong>Fecha:</strong> {{ $invoice->created_at->format('d/m/Y H:i A') }}<br>
            </td>
        </tr>
        <tr>
            <td >&nbsp;</td>
        </tr>
        <tr>
            <td>
                <div>
                    <strong>Factura a:</strong> {{ $invoice->client->full_name }}
                    <strong>Monto a pagar: </strong>Q. {{ $invoice->total }}
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table width="100%" class="outline-table">
        <tbody>
        <tr class="border-bottom border-right grey">
            <td colspan="5"><strong>Detalles</strong></td>
        </tr>
        <tr class="border-bottom border-right center">
            <td width="35%"><strong>Producto</strong></td>
            <td width="20%"><strong>Precio Unitario</strong></td>
            <td width="20%"><strong>Costo Unitario</strong></td>
            <td width="15%"><strong>Cantidad</strong></td>
            <td width="30%"><strong>Subtotal</strong></td>
        </tr>

        @foreach ($invoice->invoiceDetails as $invoiceDetail)
            <tr class="border-right">
                <td class="pad-left">{{ $invoiceDetail->product->description }}</td>
                <td class="right">Q. {{ $invoiceDetail->unit_price }}</td>
                <td class="right">Q. {{ $invoiceDetail->unit_cost }}</td>
                <td class="right">{{ $invoiceDetail->quantity }}</td>
                <td class="right">Q. {{ $invoiceDetail->sub_total }}</td>
            </tr>
        @endforeach
        <tr class="border-right">
            <td class="pad-left border-top">&nbsp;</td>
            <td class="pad-left border-top">&nbsp;</td>
            <td class="pad-left border-top">&nbsp;</td>
            <td style="vertical-align: middle;" class="center border-top"><strong>Total</strong></td>
            <td class="right border-top">{{ $invoice->total }}</td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table>
        <tbody>
        <tr>
            <td>
                Ningún humano estuvo involucrado en la creación de esta factura, por lo que no se necesita firma
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>