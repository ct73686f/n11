@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-10 offset-md-1">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Nueva venta de mercaderia</h3>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                                    <label for="nit" class="control-label">NIT</label>
                                    {{ Form::text('nit', 'CF', ['class' => 'form-control underlined', 'placeholder' => 'NIT', 'id' => 'nit']) }}
                                    <span id="error-nit" class="has-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                                    <label for="client" class="control-label">Cliente</label>
                                    {{ Form::text('client', 'Consumidor Final', ['class' => 'form-control underlined', 'placeholder' => 'Cliente', 'id' => 'client']) }}
                                    <span id="error-client" class="has-error"></span>
                                </div>
                            </div>                            
                        </div>

                        <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
                            <label for="discount" class="control-label">Descuento</label>
                            {{ Form::text('discount', '0.00', ['class' => 'form-control underlined inputmask', 'placeholder' => 'Descuento', 'id' => 'discount', 'data-inputmask' => "'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'prefix': 'Q. ', 'placeholder': '0'"]) }}
                            <span id="error-discount" class="has-error"></span>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="control-label">Descripción</label>
                            {{ Form::text('description', null, ['class' => 'form-control underlined', 'placeholder' => 'Descripción', 'id' => 'description']) }}
                            <span id="error-description" class="has-error"></span>
                        </div>
                    </div>

                    <div class="card card-block" id="details-block">
                        <div class="title-block">
                            <h3 class="title">Detalle de Venta</h3>
                        </div>

                        <div class="form-group{{ $errors->has('product') || $errors->has('quantity') ? ' has-error' : '' }}">
                            <form id="get-product-form">
                                {{ csrf_field() }}
                                <div class="row form-group">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sel-product" class="control-label">Producto</label>
                                            <select name="sel_product" id="sel-product"
                                                    class="form-control chosen-select search"
                                                    data-placeholder="Seleccione un producto">
                                                <option value=""></option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}"
                                                            data-barcode="{{ $product->barcode->code }}">{{ $product->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="barcode" class="control-label">Código de barra</label>
                                            {{ Form::text('barcode', null, ['id' => 'barcode', 'placeholder' => 'Ingrese el código de barra', 'class' => 'form-control underlined']) }}
                                            <span id="error-barcode" class="has-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('wholesale_apply') ? ' has-error' : '' }}">
                                            <label for="wholesale-apply" class="control-label">Venta al por mayor</label>
                                            {{ Form::select('temp_wholesale', [ 'N' => 'No','Y' => 'Sí'], null, ['id' => 'wholesale-apply', 'class' => 'form-control chosen-select', 'data-placeholder' => 'Seleccione una opción']) }}
                                            @if ($errors->has('wholesale_apply'))
                                                <span class="has-error" id="error-wholesale-apply">{{ ucfirst($errors->first('wholesale_apply')) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="quantity" class="control-label">Cantidad</label>
                                            {{ Form::text('quantity', null, ['id' => 'quantity', 'class' => 'form-control underlined', 'disabled' => 'disabled', 'placelholder' => 'Cantidad']) }}
                                            <span id="error-quantity" class="has-error"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <form id="invoice-form" role="form" method="POST" action="{{ url('product/movements/new') }}"
                              novalidate>
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="card-title-block">
                                                <h3 class="title">Productos</h3>
                                            </div>
                                            <section class="example form-group">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Código</th>
                                                            <th>Descripción</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio</th>
                                                            <th>Precio por mayor</th>
                                                            <th>Sub Total</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="invoice-products">

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <label>Sub Total: <span id="product-sub-total"></span></label><br>
                                                <!--<label>Recargo: <span id="product-surcharge"></span></label><br>-->
                                                <label>Total: <span id="product-total"></span></label>
                                                <span id="error-product" class="has-error"></span>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="title-block">
                                <h3 class="title">Media Pago</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('credit') ? ' has-error' : '' }}">
                                        <label for="credit" class="control-label">Crédito</label>
                                        {{ Form::text('credit', null, ['class' => 'form-control underlined', 'placeholder' => 'Crédito', 'id' => 'credit']) }}
                                        <span id="error-credit" class="has-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('cash') ? ' has-error' : '' }}">
                                        <label for="cash" class="control-label">Efectivo</label>
                                        {{ Form::text('cash', null, ['class' => 'form-control underlined', 'placeholder' => 'Efectivo', 'id' => 'cash']) }}
                                        <span id="error-cash" class="has-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('card') ? ' has-error' : '' }}"
                                         id="card-calculate-wrapper">
                                        <label for="card" class="control-label">Tarjeta</label>

                                        {{ Form::text('card', null, ['class' => 'form-control underlined',
                                        'data-html' => 'true',
                                        'data-toggle' => 'popover',
                                        'data-placement' => 'top',
                                        'data-content' => '
                                         <form id="charge-calculator-form">
                                            <h6>Usted esta ingresando un monto en tarjeta de credito el cual tiene un recargo adicional</h6>
                                            
                                            <div class="form-group">
                                                <div>
                                                    <label>
                                                        <input class="radio rounded" value="6" name="charge" checked="checked" type="radio">
                                                        <span>Normal 6%</span>
                                                    </label>
                                                    <label>
                                                        <input class="radio rounded" value="10" name="charge" type="radio">
                                                        <span>Servicio a domicilio 10%</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button onclick="$(&#39;#card&#39;).popover(&#39;hide&#39;);" type="button" class="btn btn-secondary">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Aplicar</button>
                                            </div>
                                         </form>
                                        ',
                                        'data-trigger' => 'manual',
                                        'placeholder' => 'Tarjeta', 'id' => 'card']) }}
                                        <span id="error-card" class="has-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('check') ? ' has-error' : '' }}">
                                        <label for="check" class="control-label">Cheque</label>
                                        {{ Form::text('check', null, ['class' => 'form-control underlined', 'placeholder' => 'Cheque', 'id' => 'check']) }}
                                        <span id="error-check" class="has-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('deposit') ? ' has-error' : '' }}">
                                        <label for="deposit" class="control-label">Deposito</label>
                                        {{ Form::text('deposit', null, ['class' => 'form-control underlined', 'placeholder' => 'Deposito', 'id' => 'deposit']) }}
                                        <span id="error-deposit" class="has-error"></span>
                                    </div>
                                </div>
                            </div>

                            <div id="product-ids"></div>
                            <input type="hidden" id="invoice-desc" name="description">
                            <input type="hidden" id="client-name" name="client">
                            <input type="hidden" id="client-nit" name="nit">
                            <input type="hidden" id="invoice-discount" name="discount">
                            <input type="hidden" id="invoice-card-surcharge" name="surcharge" value="0">
                            <input type="hidden" id="invoice-credit" name="credit">
                            <input type="hidden" id="invoice-cash" name="cash">
                            <input type="hidden" id="invoice-card" name="card">
                            <input type="hidden" id="invoice-check" name="check">
                            <input type="hidden" id="invoice-deposit" name="deposit">
                            <iframe id="pdf-iframe" style="opacity: 0; visibility: hidden; height: 0;"></iframe>


                            <div class="form-group">
                                <a href="{{ url('product/invoices') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </article>
@endsection
@section('page-script')
    <script src="js/jquery.inputmask.bundle.min.js"></script>
    <script>
        $(function () {
            //$('.inputmask').inputmask();
            var $form                = $('#invoice-form');
            var $inputs              = $('#invoice-form input, #invoice-form select, #invoice-form button');
            var $productForm         = $('#get-product-form');
            var $description         = $('#description');
            var $discount            = $('#discount');
            var $nit                 = $('#nit');
            var product              = 0;
            var total                = 0;
            var totalOverall         = 0;
            var surcharge            = 0;
            var $productSubTotal     = $('#product-sub-total');
            var $productSurcharge    = $('#product-surcharge');
            var $productTotal        = $('#product-total');
            var $barcode             = $('#barcode');
            var $client              = $('#client');
            var $clientName          = $('#client-name');
            var $clientNit           = $('#client-nit');
            var $invoiceDesc         = $('#invoice-desc');
            var $credit              = $('#credit');
            var $cash                = $('#cash');
            var $card                = $('#card');
            var $check               = $('#check');
            var $deposit             = $('#deposit');
            var $wholesaleApply      = $('#wholesale-apply');
            //var $paymentBlock        = $('#payment-block');
            var $detailsBlock        = $('#details-block');
            var $selProduct          = $('#sel-product');
            var $product             = $('#product');
            var productCount         = 0;
            var productsTotal        = [];
            var productObjects       = [];
            var $productIds          = $('#product-ids');
            var $quantity            = $('#quantity');
            var $invoiceSubcharge    = $('#invoice-card-surcharge');
            var $invoiceProducts     = $('#invoice-products');
            var $invoiceDiscount     = $('#invoice-discount');
            var $invoiceCredit       = $('#invoice-credit');
            var $invoiceCash         = $('#invoice-cash');
            var $invoiceCard         = $('#invoice-card');
            var $invoiceCheck        = $('#invoice-check');
            var $invoiceDeposit      = $('#invoice-deposit');
            var $errorBarcode        = $('#error-barcode');
            var $errorClient         = $('#error-client');
            var $errorNit            = $('#error-nit');
            var $errorDescription    = $('#error-description');
            var $errorProduct        = $('#error-product');
            var $errorQuantity       = $('#error-quantity');
            var $errorCredit         = $('#error-credit');
            var $errorCash           = $('#error-cash');
            var $errorCard           = $('#error-card');
            var $errorCheck          = $('#error-check');
            var $errorDeposit        = $('#error-deposit');
            var $errorDiscount       = $('#error-discount');
            var $errorWholesaleApply = $('#error-wholesale-apply');

            $card.on('focus', function () {
                $card.popover('show');
            });

            $(document).on('submit', '#charge-calculator-form', function (e) {
                e.preventDefault();

                $errorCard.html('').parent('.form-group').removeClass('has-error');

                var $this      = $(this);
                var charge     = parseInt($this.find('input[name=charge]:checked').val());
                var cardValue  = $card.val();
                var cardTotal  = 0;

                if ( $.isNumeric(cardValue) ) {
                    cardValue = parseFloat(cardValue);
                    cardTotal = ( charge / 100 ) * cardValue;
                    surcharge = cardTotal;
                    $invoiceSubcharge.val(addCommas(surcharge.toFixed(2)));
                    cardTotal += cardValue;
                    cardTotal = parseFloat(cardTotal).toFixed(2);
                    $card.val(addCommas(cardTotal));
                    $card.popover('hide');

                    $errorDiscount.html('').parent('.form-group').removeClass('has-error');
                    var discount = $discount.val();
                    if ($.isNumeric(discount)) {
                        var tempTotal = parseFloat(total);
                        if (tempTotal > 0) {
                            total = parseFloat(total);
                            totalOverall = (total - parseFloat($discount.val())) + parseFloat(surcharge);
                            totalOverall = totalOverall.toFixed(2);
                            total = total.toFixed(2);
                            $productSubTotal.html(addCommas(total));
                            $productTotal.html(addCommas(totalOverall));
                        }
                    } else {
                        $errorDiscount.html('Debe ingresar un valor númerico').parent('.form-group').addClass('has-error');
                    }
                } else {
                    $errorCard.html('Debe ingresar un valor númerico').parent('.form-group').addClass('has-error');
                }
            });

            $selProduct.chosen().change(function () {
                var $this = $(this);
                var code  = $this.find(':selected').data('barcode');
                $this.blur();
                $barcode.val(code).focus();

                $.ajax({
                    url: '{{ url('product/api/product-barcode') }}',
                    type: 'GET',
                    data: {code: code},
                    success: function (res) {
                        product = res.id;
                        $barcode.attr('disabled', true);
                        $selProduct.val('').trigger('chosen:updated');
                        $quantity.removeAttr('disabled').focus();
                    },
                    error: function (res) {
                        console.log(res);
                        var errors = res.responseJSON;

                        $errorBarcode.html(errors.error).parent('.form-group').addClass('has-error');
                    }
                });

            });

            $wholesaleApply.chosen().change(function () {
                //var sel = $(this).val();
                $(this).blur();
                //$quantity.focus();
                setTimeout(function() { $quantity.focus(); }, 100);
                //$invoiceWholesale.val(sel);

                /*if (sel == 'Y' || sel == 'N') {
                    //$paymentBlock.fadeIn(500);
                    $detailsBlock.fadeIn(500, function () {
                    });
                }*/

            });

            $barcode.on('keypress', function (e) {
                if (e.which == 13) {
                    $errorBarcode.html('').parent('.form-group').removeClass('has-error');

                    $.ajax({
                        url: '{{ url('product/api/product-barcode') }}',
                        type: 'GET',
                        data: {code: $(this).val()},
                        success: function (res) {
                            product = res.id;
                            $barcode.attr('disabled', true);
                            $quantity.removeAttr('disabled').focus();
                        },
                        error: function (res) {
                            console.log(res);
                            var errors = res.responseJSON;

                            $errorBarcode.html(errors.error).parent('.form-group').addClass('has-error');
                        }
                    });
                }
            });

            $nit.on('keypress', function (e) {
                if (e.which == 13) {
                    $errorNit.html('').parent('.form-group').removeClass('has-error');

                    $.ajax({
                        url: '{{ url('product/api/search-client') }}',
                        type: 'GET',
                        data: {query: $(this).val()},
                        success: function (res) {
                            if (res.client) {
                                $client.val(res.client);
                            }
                        }
                    });
                }
            });

            $quantity.on('keypress', function (e) {
                if (e.which === 13) {
                    $productForm.submit();
                }
            });

            $discount.on('keypress', function (e) {
                if (e.which === 13) {
                    $errorDiscount.html('').parent('.form-group').removeClass('has-error');
                    var discount = $discount.val();

                    if ($.isNumeric(discount)) {
                        var tempTotal = parseFloat(total);
                        if (tempTotal > 0) {
                            total = parseFloat(total);
                            totalOverall = (total - parseFloat($discount.val())) + parseFloat(surcharge);
                            totalOverall = totalOverall.toFixed(2);
                            total = total.toFixed(2);
                            $productSubTotal.html(addCommas(total));
                            $productTotal.html(addCommas(totalOverall));
                        }
                    } else {
                        $errorDiscount.html('Debe ingresar un valor númerico').parent('.form-group').addClass('has-error');
                    }
                }
            });

            $invoiceProducts.on('click', '.product-remove', function (e) {
                e.preventDefault();
                var index     = $(this).data('index');
                var prodIndex = productObjects[index].id;
                productObjects[index].product.remove();
                productObjects[index].row.remove();
                total = parseFloat(total) - parseFloat(productObjects[index].total);
                totalOverall = total - parseFloat($discount.val());
                totalOverall = totalOverall.toFixed(2);
                total = total.toFixed(2);
                $productSubTotal.html(addCommas(total));
                $productTotal.html(addCommas(totalOverall));
                productsTotal[prodIndex] = parseInt(productsTotal[prodIndex]) - parseInt(productObjects[index].qty);

                productObjects[index] = null;
            });

            $productForm.on('submit', function (e) {
                e.preventDefault();
                $errorQuantity.html('').parent('.form-group').removeClass('has-error');
                $errorProduct.html('').parent('.form-group').removeClass('has-error');
                $errorDiscount.html('').parent('.form-group').removeClass('has-error');

                var discount = $discount.val();

                if ($.isNumeric(discount)) {
                    $.ajax({
                        url: '{{ url('product/invoices/product') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product: product,
                            quantity: $quantity.val(),
                            wholesale: $wholesaleApply.val()
                        },
                        beforeSend: function () {
                            $(this).attr('disabled', true);
                        },
                        success: function (res) {
                            var totalScope   = $quantity.val();
                            var totalCurrent = 0;

                            if (typeof productsTotal[product] !== 'undefined' && productsTotal[product] !== null) {
                                totalScope   = parseInt($quantity.val()) + parseInt(productsTotal[product]);
                                totalCurrent = parseInt(productsTotal[product]);
                            }

                            $errorQuantity.html('').parent('.form-group').removeClass('has-error');

                            $.ajax({
                                url: '{{ url('product/invoices/product-total') }}',
                                type: 'GET',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: product,
                                    total: totalScope,
                                    total_current: totalCurrent
                                },
                                success: function (prodres) {
                                    if (prodres.valid) {

                                        var inputProduct = $(
                                            '<input type="hidden" name="product[]" value="' + product + '">' +
                                            '<input type="hidden" name="quantity[]" value="' + $quantity.val() + '">' +
                                            '<input type="hidden" name="wholesale_apply[]" value="' + $wholesaleApply.val() + '">'
                                        );
                                        $productIds.append(inputProduct);
                                        total = parseFloat(total) + parseFloat(res.sub_total);
                                        totalOverall = (total - parseFloat($discount.val())) + parseFloat(surcharge);
                                        totalOverall = totalOverall.toFixed(2);
                                        total = total.toFixed(2);
                                        $productSubTotal.html(addCommas(total));
                                        $productTotal.html(addCommas(totalOverall));
                                        var view = $(res.view);
                                        view.find('a').attr('data-index', productCount);
                                        productObjects[productCount] = {
                                            row: view,
                                            product: inputProduct,
                                            total: parseFloat(res.sub_total),
                                            id: product,
                                            qty: $quantity.val()
                                        };
                                        $invoiceProducts.append(view);

                                        if (typeof productsTotal[product] === 'undefined' || !productsTotal[product]) {
                                            productsTotal[product] = parseInt($quantity.val());
                                        } else {
                                            productsTotal[product] += parseInt($quantity.val());
                                        }

                                        $quantity.val('').attr('disabled', true);
                                        $barcode.val('').removeAttr('disabled').focus();
                                        //$wholesaleApply.val('').removeAttr('disabled').focus();
                                        productCount++;

                                    } else {
                                        if (prodres.quantity) {
                                            $errorQuantity.html(prodres.quantity).parent('.form-group').addClass('has-error');
                                        }

                                        $(this).removeAttr('disabled');
                                    }
                                }
                            });


                        },
                        error: function (res) {
                            var errors = res.responseJSON;

                            if (errors.quantity) {
                                $errorQuantity.html(errors.quantity).parent('.form-group').addClass('has-error');
                            }

                            $(this).removeAttr('disabled');
                        }
                    });
                } else {
                    $(this).blur();
                    $errorDiscount.html('Debe ingresar un valor númerico').parent('.form-group').addClass('has-error');
                    $('html, body').animate({
                        scrollTop: ($discount.position().top - 400)
                    }, 500, function() {
                        $discount.focus();
                    });
                }
            });

            $form.on('submit', function (e) {
                e.preventDefault();
                $errorProduct.html('').parent('.form-group').removeClass('has-error');
                $errorClient.html('').parent('.form-group').removeClass('has-error');
                $errorNit.html('').parent('.form-group').removeClass('has-error');
                $errorDescription.html('').parent('.form-group').removeClass('has-error');
                $errorCredit.html('').parent('.form-group').removeClass('has-error');
                $errorCash.html('').parent('.form-group').removeClass('has-error');
                $errorCard.html('').parent('.form-group').removeClass('has-error');
                $errorCheck.html('').parent('.form-group').removeClass('has-error');
                $errorDeposit.html('').parent('.form-group').removeClass('has-error');
                $errorDiscount.html('').parent('.form-group').removeClass('has-error');

                $clientName.val($client.val());
                $invoiceDesc.val($description.val());
                $invoiceDiscount.val($discount.val());
                $invoiceCash.val($cash.val());
                $invoiceCredit.val($credit.val());
                $invoiceCard.val($card.val());
                $invoiceCheck.val($check.val());
                $invoiceDeposit.val($deposit.val());
                $clientNit.val($nit.val());

                if (!$.isNumeric($invoiceSubcharge.val())) {
                    //$invoiceSubcharge(0);
                }

                $.ajax({
                    url: '{{ url('product/invoices/new') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    beforeSend: function () {
                        $inputs.attr('disabled', true);
                    },
                    success: function (res) {
                        $inputs.removeAttr('disabled');


                        /*$('#pdf-iframe').attr("src", res.url).load(function () {
                            document.getElementById('pdf-iframe').contentWindow.print();
                        });*/

                        window.open(res.url);
                        window.location.href = '{{  url('product/invoices') }}';
                    },
                    error: function (res) {
                        var errors = res.responseJSON;

                        if (errors.client) {
                            $errorClient.html(errors.client).parent('.form-group').addClass('has-error');
                        }

                        if (errors.nit) {
                            $errorNit.html(errors.nit[0]).parent('.form-group').addClass('has-error');
                        }

                        if (errors.description) {
                            $errorDescription.html(errors.description).parent('.form-group').addClass('has-error');
                        }

                        if (errors.credit) {
                            $errorCredit.html(errors.credit).parent('.form-group').addClass('has-error');
                        }

                        if (errors.cash) {
                            $errorCash.html(errors.cash).parent('.form-group').addClass('has-error');
                        }

                        if (errors.card) {
                            $errorCard.html(errors.card).parent('.form-group').addClass('has-error');
                        }

                        if (errors.check) {
                            $errorCheck.html(errors.check).parent('.form-group').addClass('has-error');
                        }

                        if (errors.deposit) {
                            $errorDeposit.html(errors.deposit).parent('.form-group').addClass('has-error');
                        }

                        if (errors.product) {
                            $errorProduct.html(errors.product).parent('.form-group').addClass('has-error');
                        }

                        if (errors.discount) {
                            $errorDiscount.html(errors.discount).parent('.form-group').addClass('has-error');
                        }

                        $inputs.removeAttr('disabled');
                    }

                })
            });

        });
    </script>
@endsection