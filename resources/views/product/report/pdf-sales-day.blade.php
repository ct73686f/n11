<html>
<head>
    <title>Reporte Ventas del Día</title>
    <style type="text/css">
        #page-wrap {
            width: 700px;
            margin: 0 auto;
            font-family: Courier;
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
            width: 200px;
            height: auto;
        }
    </style>
</head>
<body>
<div id="page-wrap">
    <table width="100%">
        <tbody>
        <tr>
            <td width="30%">
                <img class="logo" src="{{ url('img/logo.png') }}">
            </td>
            <td width="70%">
                <h2>Reporte de Ventas del Día</h2><br>
                <strong>Fecha:</strong> {{ $date }}<br>
                <strong>Fecha Generada:</strong> {{ date('d/m/Y') }}<br>
                <strong>Media Pago:</strong> {{ $type }}<br>
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="center-justified">
                    &nbsp;
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table width="100%" class="outline-table" style="font-size: 12px;">
        <tbody>
        <tr class="border-bottom border-right grey">
            <td colspan="5" style="color: #fff; font-size: 16px;"><strong>Resumen Ventas</strong></td>
        </tr>
        <tr class="border-bottom border-right center">
            <td><strong>Número</strong></td>
            <td><strong>Descripcíón</strong></td>
            <td><strong>Cliente</strong></td>
            <td><strong>NIT</strong></td>
            <td><strong>Sub Total</strong></td>
        </tr>
        @foreach ($invoices as $invoice)
            <tr class="border-right">
                <td class="center border-bottom">{{ $invoice->id }}</td>
                <td class="center border-bottom">{{ $invoice->description }}</td>
                <td class="center border-bottom">{{ $invoice->client->full_name }}</td>
                <td class="center border-bottom">{{ $invoice->client->nit }}</td>
                <td class="right-center border-bottom">{{ number_format($invoice->totalWithDiscount, 2) }}</td>
            </tr>
        @endforeach
        <tr class="border-right">
            <td class="center">&nbsp;</td>
            <td class="center">&nbsp;</td>
            <td class="center">&nbsp;</td>
            <td class="center">Total</td>
            <td class="right-center">{{ number_format($total, 2) }}</td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
</div>
</body>
</html>