@extends('layouts.app')


@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-10 offset-md-1">


                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Nuevo Movimiento Efectivo</h3>
                        </div>
                        <form action="{{ url('product/movements-cash/new') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('document') ? ' has-error' : '' }}">
                                <label for="document" class="control-label">Tipo de movimiento</label>
                                {{ Form::select('document', $documents, null, ['id' => 'document', 'data-placeholder' => 'Seleccione un tipo', 'class' => 'form-control chosen-select']) }}
                                @if ($errors->has('document'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('document')) }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="control-label">Descripción</label>
                                {{ Form::text('description', null, ['id' => 'description', 'placeholder' => 'Descripción', 'class' => 'form-control underlined']) }}
                                @if ($errors->has('description'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('description')) }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="control-label">Monto</label>
                                {{ Form::text('amount', null, ['id' => 'amount', 'placeholder' => 'Monto', 'class' => 'form-control underlined']) }}
                                @if ($errors->has('amount'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('amount')) }}
                                    </span>
                                @endif
                            </div>

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