@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Nuevo detalle factura</h3>
                        </div>
                        <form id="invoice-detail-form" role="form" method="POST" action="{{ url('product/invoice-details/new') }}" novalidate>
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('invoice') ? ' has-error' : '' }}">
                                <label for="invoice" class="control-label">Factura</label>
                                {{ Form::select('invoice', $invoices, null, ['class' => 'form-control chosen-select', 'id' => 'invoice']) }}
                                <span id="error-invoice" class="has-error"></span>
                            </div>
                            <div class="form-group{{ $errors->has('product') ? ' has-error' : '' }}">
                                <label for="product" class="control-label">Producto</label>
                                {{ Form::select('product', $products, null, ['class' => 'form-control chosen-select', 'data-placeholder' => 'Seleccione un producto', 'id' => 'product']) }}
                                <span id="error-product" class="has-error"></span>
                            </div>
                            <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                                <label for="cost" class="control-label">Costo</label>
                                <select name="cost" disabled data-placeholder="Seleccione un costo" id="cost"
                                        class="form-control chosen-select"></select>
                                <span id="error-cost" class="has-error"></span>
                            </div>

                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="control-label">Precio</label>
                                <select name="price" disabled data-placeholder="Seleccione un precio" id="price"
                                        class="form-control chosen-select"></select>
                                <span id="error-price" class="has-error"></span>
                            </div>
                            <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                <label for="quantity" class="control-label">Cantidad</label>
                                {{ Form::text('quantity', null, ['class' => 'form-control underlined', 'placeholder' => 'Cantidad', 'id' => 'quantity']) }}
                                @if ($errors->has('quantity'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('quantity'))  }}
                                    </span>
                                @endif
                            </div>
                            
                          
                            <div class="form-group">
                                <a href="{{ url('product/categories') }}" class="btn btn-secondary">Cancelar</a>
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
            var $product       = $('#product');
            var $cost          = $('#cost');
            var $price         = $('#price');
            var $form          = $('#invoice-detail-form');
            var $inputs        = $('#invoice-detail-form input, #invoice-detail-form select, #invoice-detail-form button');
            var priceValues    = [];
            var $errorInvoice  = $('#error-invoice');
            var $errorProduct  = $('#error-product');
            var $errorCost     = $('#error-cost');
            var $errorPrice    = $('#error-price');
            var $errorQuantity = $('#error-quantity');

            $product.chosen().change(function () {
                $.get('{{ url('product/api/product-costs') }}', {id: $(this).val()}, function (data) {
                    $cost.empty().attr('disabled', true).trigger("chosen:updated");
                    $price.empty().attr('disabled', true).trigger("chosen:updated");

                    if (data.length) {
                        priceValues = data;
                        $.each(data, function (index, element) {
                            if (element.id != undefined) {
                                $cost.append("<option value='" + element.id + "'>" + element.cost_value + "</option>");
                            } else {
                                $cost.append("<option value=''></option>");
                            }

                        });

                        $cost.removeAttr('disabled').trigger("chosen:updated");
                    }
                });
            });

            $cost.chosen().change(function () {
                $price.empty().attr('disabled', true).trigger("chosen:updated");

                var index  = $cost.prop('selectedIndex');
                var prices = priceValues[index];
                if (prices && prices.price_values.length) {

                    $.each(prices.price_values, function (index, element) {
                        if (element.id != undefined) {
                            $price.append("<option value='" + element.id + "'>" + element.name + "</option>");
                        } else {
                            $price.append("<option value=''></option>");
                        }

                    });

                    $price.removeAttr('disabled').trigger("chosen:updated");
                }
            });

            $form.on('submit', function (e) {
                e.preventDefault();

                $errorInvoice.html('').parent('.form-group').addClass('has-error');
                $errorProduct.html('').parent('.form-group').addClass('has-error');
                $errorCost.html('').parent('.form-group').addClass('has-error');
                $errorPrice.html('').parent('.form-group').addClass('has-error');
                $errorQuantity.html('').parent('.form-group').addClass('has-error');


                $.ajax({
                    url: '{{ url('product/invoice-details/new') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    beforeSend: function () {
                        $inputs.attr('disabled', true);
                    },
                    success: function (res) {
                        console.log(res);
                        $inputs.removeAttr('disabled');
                        window.location.href = '{{ url('product/invoice-details') }}';
                    },
                    error: function (res) {
                        var errors = res.responseJSON;

                        if (errors.invoice) {
                            $errorInvoice.html(errors.invoice).parent('.form-group').addClass('has-error');
                        }

                        if (errors.product) {
                            $errorProduct.html(errors.product).parent('.form-group').addClass('has-error');
                        }

                        if (errors.cost) {
                            $errorCost.html(errors.cost).parent('.form-group').addClass('has-error');
                        }

                        if (errors.price) {
                            $errorPrice.html(errors.price).parent('.form-group').addClass('has-error');
                        }

                        if (errors.quantity) {
                            $errorQuantity.html(errors.quantity).parent('.form-group').addClass('has-error');
                        }

                        $inputs.removeAttr('disabled');
                    }

                })
            });

        });
    </script>
@endsection