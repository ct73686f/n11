<html>
<head>
    <title>Venta de Mercaderia</title>
    <style type="text/css">
        @page { margin-left: 10px; margin-top: 0px; margin-bottom: 0px;   }

        * {
            font-family: "Courier New", Courier, monospace;
            font-size: 12px;  /*12*/
            font-weight: bold;
            margin:0
            padding:0;
        }

        #page-wrap {
            width: 700px;  /*190*/
            margin: 0 50px;  /*10*/

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
            <td style="padding: 5px 0 0 0; text-align: center;">
                <br>Novedades 2132<br>Calz. San Juan 14-06, C.C. Montserrat, Kiosko No. 2<br>Tel.: 4801-6094, 4256-8587
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 20px 0px; font-size: 15px; color: #FF0000;">
                <strong>Número:</strong> {{ $invoice->id }}<br>    
                <strong>Fecha:</strong> {{ $invoice->created_at->format('d/m/Y H:i A') }}           
            </td>
        </tr>
<!--         <tr>
            <td >&nbsp;</td>
        </tr> -->

        <tr>
            <td>
                <div>
                    <strong>Nombre:</strong> {{ $invoice->client->full_name }} <br>
                    <strong>Código:</strong> {{ $invoice->nit }} <br><br>
                    <table width="100%">
                        <tr>
                            <td width="40%"><strong>Sub Total</strong></td>
                            <td>{{ number_format($invoice->total, 2) }}</td>
                        </tr>
                        <tr>
                            <td width="40%"><strong>Descuento</strong></td>
                            <td>{{ number_format($invoice->discount, 2) }}</td>
                        </tr>
                       <!--- <tr>
                            <td width="40%"><strong>Recargo</strong></td>
                            <td>{{ number_format($invoice->surcharge, 2) }}</td>
                        </tr>  -->
                        <tr>
                            <td width="40%"><strong>Total</strong></td>
                            <td>{{ number_format((($invoice->total - $invoice->discount) + $invoice->surcharge), 2, '.', ',') }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table width="100%">
        <tbody>
        <tr>
            <td><strong>Media Pago</strong></td>
        </tr>
        <tr>
            <td colspan="4" style="padding-bottom: 5px; ">
                <div style="border: 0.5px dotted #000;"></div>
            </td>
        </tr>

        @foreach ($invoice->paymentMethods as $paymentMethod)
            <tr >
                <td class="center"><strong>{{ $paymentMethod->description }}:</strong> {{ number_format($paymentMethod->amount, 2, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table width="100%" class="outline-table">
        <tbody>
        <tr class="border-bottom border-right">
            <td colspan="4"><strong>Detalles</strong></td>
        </tr>
        <tr>
            <td width="10%" class="border-bottom border-right center"><strong>Cnt</strong></td>
            <td width="40%" class="border-bottom border-right center"><strong>Descripción</strong></td>
            <td width="25%" class="border-bottom border-right right"><strong>Precio</strong></td>
            <td width="25%" class="border-bottom right"><strong>Subtotal</strong></td>
        </tr>

        @foreach ($invoice->invoiceDetails as $invoiceDetail)
            <tr>
                <td class="border-right center">{{ $invoiceDetail->quantity }}</td>
                <td class="border-right left">{{ $invoiceDetail->product->description }}</td>
                <td class="border-right right">{{ number_format($invoiceDetail->unit_price, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($invoiceDetail->sub_total, 2, '.', ',') }}</td>
            </tr>
        @endforeach

        <tr class="">
            <td class="pad-left border-top left">&nbsp;</td>
            <td class="pad-left border-top left">&nbsp;</td>
            <td style="vertical-align: middle;" class="center border-top right border-right"><strong>Total</strong></td>
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
                <strong>Descripción:</strong>  {{ $invoice->description }}
            </td>
        </tr>
            <td style="text-align: justify; padding: 8px 0px; font-size: 8px;">
                GARANTÍA: Términos y condiciones: La siguiente garantía será valida únicamente con este documento y documento de identificación del comprador. Todos nuestros productos tienen 15 días de garantía por desperfectos de fabricación. Todo producto será verificado en servicio técnico antes de cualquier cambio o reparación en un lapso de 3 días hábiles. La garantía no cuenta con servicio a domicilio, cambios inmediatos o devoluciones. Para Servicio Técnico Su equipo permanecerá únicamente 15 días en nuestra tienda. Luego no nos hacemos responsables.
            </td>

        </tbody>
    </table>
</div>
</body>
</html>