@extends('layouts.app')


@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-10 offset-md-1">


                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Nuevo Movimiento Inventario</h3>
                        </div>
                        <div class="form-group{{ $errors->has('document') ? ' has-error' : '' }}">
                            <label for="document" class="control-label">Tipo de movimiento</label>
                            {{ Form::select('document', $documents, null, ['id' => 'document', 'data-placeholder' => 'Seleccione un tipo', 'class' => 'form-control chosen-select']) }}
                            <span id="error-document" class="has-error"></span>
                        </div>
                        <div class="form-group">
                            <label for="invoice-number" class="control-label">No. Factura</label>
                            {{ Form::text('invoice_number', null, ['id' => 'invoice-number', 'placeholder' => 'No. Factura', 'class' => 'form-control underlined']) }}
                            <span id="error-invoice-number" class="has-error"></span>
                        </div>
                    </div>

                    <div class="card card-block" id="details-block" style="display: none;">
                        <div class="title-block">
                            <h3 class="title">Detalle Movimiento</h3>
                        </div>

                        <div class="form-group{{ $errors->has('product') || $errors->has('quantity') ? ' has-error' : '' }}">
                            <form id="get-product-form">
                                {{ csrf_field() }}
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sel-product" class="control-label">Producto</label>
                                            <select name="sel_product" id="sel-product"
                                                    class="form-control chosen-select"
                                                    data-placeholder="Seleccione un producto">
                                                <option value=""></option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}"
                                                            data-barcode="{{ $product->barcode->code }}">{{ $product->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="barcode" class="control-label">Producto</label>
                                            {{ Form::text('barcode', null, ['id' => 'barcode', 'placeholder' => 'Ingrese el código de barra', 'class' => 'form-control underlined']) }}
                                            <span id="error-barcode" class="has-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="quantity" class="control-label">Cantidad</label>
                                            {{ Form::text('quantity', null, ['id' => 'quantity', 'disabled' => 'disabled', 'class' => 'form-control underlined', 'placeholder' => 'Cantidad']) }}
                                            <span id="error-quantity" class="has-error"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <form id="movement-form" role="form" method="POST" action="{{ url('product/movements/new') }}" novalidate>
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
                                                            <th>Costo</th>
                                                            <th>Sub Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="movement-products">

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <label>Total: <span id="product-total"></span></label>
                                                <span id="error-product" class="has-error"></span>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="product-ids">

                            </div>
                            <input type="hidden" id="document-id" name="document">
                            <input type="hidden" id="movement-invoice-number" name="invoice_number">


                            <div class="form-group">
                                <a href="{{ url('product/movements') }}" class="btn btn-secondary">Cancelar</a>
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
        $(function () {
            var $form             = $('#movement-form');
            var $inputs           = $('#movement-form input, #movement-form select, #movement-form button');
            var $productForm      = $('#get-product-form');
            var $document         = $('#document');
            var $documentId       = $('#document-id');
            var $invoiceNumber    = $('#movement-invoice-number');
            var $detailsBlock     = $('#details-block');
            var $selProduct          = $('#sel-product');
            var outputType        = 0;
            var product           = 0;
            var total             = 0;
            var $productTotal     = $('#product-total');
            var $productIds       = $('#product-ids');
            var $barcode          = $('#barcode');
            var $quantity         = $('#quantity');
            var $movementProducts = $('#movement-products');
            var $errorDocument    = $('#error-document');
            var $errorBarcode     = $('#error-barcode');
            var $errorProduct     = $('#error-product');
            var $errorQuantity    = $('#error-quantity');

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

            $barcode.on('keypress', function(e) {
                if(e.which == 13) {
                    $errorBarcode.html('').parent('.form-group').removeClass('has-error');

                    $.ajax({
                        url: '{{ url('product/api/product-barcode') }}',
                        type: 'GET',
                        data: { code: $(this).val() },
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

            $quantity.on('keypress', function(e) {
                if(e.which == 13) {
                    $productForm.submit();
                }
            });

            $document.chosen().change(function () {
                $documentId.val($(this).val());
                $.ajax({
                    url: '{{ url('product/api/get-output-type') }}',
                    type: 'GET',
                    data: { _token: '{{ csrf_token() }}', id: $(this).val() },
                    success: function (res) {
                        outputType = res.output_type;
                        $detailsBlock.fadeIn(500);
                    }
                });
            });

            $productForm.on('submit', function (e) {
                e.preventDefault();
                $errorQuantity.html('').parent('.form-group').removeClass('has-error');
                $errorProduct.html('').parent('.form-group').removeClass('has-error');

                $.ajax({
                    url: '{{ url('product/movements/product') }}',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}', product: product, quantity: $quantity.val(), output_type: outputType },
                    beforeSend: function () {
                        $(this).attr('disabled', true);
                    },
                    success: function (res) {
                        $productIds.append('<input type="hidden" name="product[]" value="' + product + '"><input type="hidden" name="quantity[]" value="' + $quantity.val() + '">');
                        $movementProducts.append(res.view);
                        total = parseFloat(total) + parseFloat(res.sub_total);
                        total = total.toFixed(2);
                        $productTotal.html(total);
                        $quantity.val('').attr('disabled', true);
                        $barcode.val('').removeAttr('disabled').focus();
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
                $invoiceNumber.val($('#invoice-number').val());
                $errorDocument.html('').parent('.form-group').removeClass('has-error');
                $errorProduct.html('').parent('.form-group').removeClass('has-error');

                $.ajax({
                    url: '{{ url('product/movements/new') }}',
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


                        if (errors.document) {
                            $errorDocument.html(errors.document).parent('.form-group').addClass('has-error');
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