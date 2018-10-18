@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-10 offset-md-1">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Venta #{{ $invoice->id }}</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                                    <label for="client" class="control-label">Cliente</label>
                                    <p>
                                        {{ $invoice->client->full_name }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                                    <label for="nit" class="control-label">NIT</label>
                                    <p>
                                        {{ $invoice->nit }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description" class="control-label">Descripción</label>
                                    <p>
                                        {{ $invoice->description }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description" class="control-label">Total</label>
                                    <p>
                                        {{ $invoice->total }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Detalle de Venta</h3>
                        </div>
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
                                                        <th>Sub Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="movement-products">
                                                    @foreach($invoice->invoiceDetails as $detail)
                                                        <tr>
                                                            <td>{{ $detail->id }}</td>
                                                            <td>{{ $detail->product->id }}</td>
                                                            <td>{{ $detail->product->description }}</td>
                                                            <td>{{ $detail->quantity }}</td>
                                                            <td>{{ $detail->unit_price }}</td>
                                                            <td>{{ $detail->sub_total }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <span id="error-product" class="has-error"></span>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <a href="{{ url('product/invoices') }}" class="btn btn-secondary">Regresar a facturas</a>
                            <a class="btn btn-primary" target="_blank" href="{{ url('product/invoices/pdf', ['id' => $invoice->id]) }}">Imprimir PDF</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </article>
@endsection
@section('page-script')
    <script>
        $(function () {
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
                        window.location.href = '{{ url('product/movements') }}';
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

        });
    </script>
@endsection