<html>
<head>
    <title>Reporte Efectivo del Mes</title>
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
                <h2>Reporte de Efectivo del Mes</h2><br>
                <strong>Fecha:</strong> {{ $date }}<br>
                <strong>Fecha Generada:</strong> {{ date('d/m/Y') }}<br>
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
    <table width="100%" class="outline-table">
        <tbody>
        <tr class="border-bottom border-right grey">
            <td colspan="4"><strong>Resumen Medias de Pago</strong></td>
        </tr>
        <tr class="border-bottom border-right center">
            <td width="45%"><strong>Efectivo</strong></td>
            <td width="25%"><strong>Tarjeta</strong></td>
            <td width="30%"><strong>Cheque</strong></td>
            <td width="30%"><strong>Deposito</strong></td>
        </tr>
        <tr class="border-right">
            <td class="center">{{ number_format($cash_total, 2) }}</td>
            <td class="center">{{ number_format($card_total, 2) }}</td>
            <td class="center">{{ number_format($check_total, 2) }}</td>
            <td class="center">{{ number_format($deposit_total, 2) }}</td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table width="100%" class="outline-table">
        <tbody>
        <tr class="border-bottom border-right grey">
            <td colspan="3"><strong>Resumen Totales</strong></td>
        </tr>
        <tr class="border-bottom border-right center">
            <td width="45%"><strong>Ventas</strong></td>
            <td width="25%"><strong>Cuentas por cobrar</strong></td>
            <td width="30%"><strong>Total</strong></td>
        </tr>

        <tr class="border-right">
            <td class="center">{{ number_format($invoices_total, 2) }}</td>
            <td class="center">{{ number_format($accounts_receivables_total, 2) }}</td>
            <td class="center">{{ number_format($total, 2) }}</td>
        </tr>

        </tbody>
    </table>
    <p>&nbsp;</p>
</div>
</body>
</html>