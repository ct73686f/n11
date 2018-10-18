@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-10 offset-md-1">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Nueva Cuenta por Cobrar</h3>
                        </div>
                        <form method="POST" action="{{ url('product/accounts-receivables/new') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('invoice') ? ' has-error' : '' }}">
                                        <label for="invoice" class="control-label">Venta de mercaderia</label>
                                        {{ Form::select('invoice', $invoices, null, ['class' => 'form-control chosen-select', 'data-placeholder' => 'Seleccionar venta de mercaderia', 'id' => 'invoice']) }}
                                        @if ($errors->has('invoice'))
                                            <span class="has-error">
                                            {{ ucfirst($errors->first('invoice')) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Cliente</label>
                                        <p id="client"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Total</label>
                                        <p id="total"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('payment_date') ? ' has-error' : '' }}">
                                        <label for="payment-date" class="control-label">Fecha de pago</label>
                                        {{ Form::text('payment_date', null, ['class' => 'form-control underlined datepicker', 'placeholder' => 'Fecha de pago', 'id' => 'payment-date']) }}
                                        @if ($errors->has('payment_date'))
                                            <span class="has-error">
                                            {{ ucfirst($errors->first('payment_date')) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <label for="amount" class="control-label">Monto Plazos</label>
                                        {{ Form::text('amount', null, ['class' => 'form-control underlined', 'placeholder' => 'Monto Plazos', 'id' => 'amount']) }}
                                        @if ($errors->has('amount'))
                                            <span class="has-error">
                                        {{ ucfirst($errors->first('amount')) }}
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                        <label for="status" class="control-label">Pagado</label>
                                        {{ Form::select('status', ['Y' => 'Sí', 'N' => 'No'], null, ['class' => 'form-control chosen-select', 'id' => 'status']) }}
                                        <span id="error-status" class="has-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="{{ url('product/accounts-receivables') }}" class="btn btn-secondary">Cancelar</a>
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
    <script>
        $(function() {
            var $invoice = $('#invoice');
            var $client  = $('#client');
            var $total   = $('#total');

            $invoice.chosen().change(function () {
                $.ajax({
                    url: '{{ url('product/api/invoice-client') }}',
                    type: 'GET',
                    data: { id: $(this).val() },
                    success: function (res) {
                        $client.html(res.client_name);
                        $total.html(res.total);
                    },
                    error: function (res) {

                    }
                });
            });
        });
        /*$(function () {
            var $form             = $('#invoice-form');
            var $inputs           = $('#invoice-form input, #invoice-form select, #invoice-form button');
            var $productForm      = $('#get-product-form');
            var $description      = $('#description');
            var $nit              = $('#nit');
            var $client           = $('#client');
            var $clientId         = $('#client-id');
            var $clientNit        = $('#client-nit');
            var $invoiceDesc      = $('#invoice-desc');
            var $product          = $('#product');
            var $productIds       = $('#product-ids');
            var $quantity         = $('#quantity');
            var $invoiceProducts  = $('#invoice-products');
            var $errorClient      = $('#error-client');
            var $errorNit         = $('#error-nit');
            var $errorDescription = $('#error-description');
            var $errorProduct     = $('#error-product');
            var $errorQuantity    = $('#error-quantity');

            $quantity.on('keypress', function (e) {
                if (e.which == 13) {
                    $productForm.submit();
                }
            });

            $client.chosen().change(function () {
                $clientId.val($(this).val());
            });

            $productForm.on('submit', function (e) {
                e.preventDefault();
                $errorQuantity.html('').parent('.form-group').removeClass('has-error');
                $errorProduct.html('').parent('.form-group').removeClass('has-error');

                $.ajax({
                    url: '{{ url('product/movements/product') }}',
                    type: 'POST',
                    data: $productForm.serialize(),
                    beforeSend: function () {
                        $(this).attr('disabled', true);
                    },
                    success: function (res) {
                        $productIds.append('<input type="hidden" name="product[]" value="' + $product.val() + '"><input type="hidden" name="quantity[]" value="' + $quantity.val() + '">');
                        $invoiceProducts.append(res);
                        $quantity.val('');
                    },
                    error: function (res) {
                        var errors = res.responseJSON;

                        if (errors.quantity) {
                            $errorQuantity.html(errors.quantity).parent('.form-group').addClass('has-error');
                        }

                        $(this).removeAttr('disabled');
                    }
                });
            });

            $form.on('submit', function (e) {
                e.preventDefault();
                $errorProduct.html('').parent('.form-group').removeClass('has-error');
                $errorClient.html('').parent('.form-group').removeClass('has-error');
                $errorNit.html('').parent('.form-group').removeClass('has-error');
                $errorDescription.html('').parent('.form-group').removeClass('has-error');
                $invoiceDesc.val($description.val());
                $clientNit.val($nit.val());

                $.ajax({
                    url: '{{ url('product/invoices/new') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    beforeSend: function () {
                        $inputs.attr('disabled', true);
                    },
                    success: function (res) {
                        $inputs.removeAttr('disabled');
                        window.location.href = '{{ url('product/invoices') }}';
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

                        if (errors.product) {
                            $errorProduct.html(errors.product).parent('.form-group').addClass('has-error');
                        }

                        $inputs.removeAttr('disabled');
                    }

                })
            });

        });*/
    </script>
@endsection