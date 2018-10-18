@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Nuevo inventario</h3>
                        </div>
                        <form id="inventory-form" role="form" method="POST" action="{{ url('product/inventories/new') }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('provider') ? ' has-error' : '' }}">
                                <label for="provider" class="control-label">Proveedor</label>
                                {{ Form::select('provider', $providers, null, ['id' => 'provider', 'data-placeholder' => 'Seleccione un proveedor', 'class' => 'form-control chosen-select']) }}
                                <span id="error-provider" class="has-error"></span>
                            </div>
                            <div class="form-group{{ $errors->has('product') ? ' has-error' : '' }}">
                                <label for="product" class="control-label">Producto</label>
                                <select name="product" disabled data-placeholder="Seleccione un producto" id="product"
                                        class="form-control chosen-select"></select>
                                <span id="error-product" class="has-error"></span>
                            </div>
                            <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                                <label for="cost" class="control-label">Costo</label>
                                <select name="cost" disabled data-placeholder="Seleccione un costo" id="cost"
                                        class="form-control chosen-select"></select>
                                <span id="error-cost" class="has-error"></span>
                            </div>
                            <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                <label for="quantity" class="control-label">Cantidad</label>
                                {{ Form::text('quantity', null, ['id' => 'quantity', 'class' => 'form-control underlined', 'placelholder' => 'Cantidad']) }}
                                <span id="error-quantity" class="has-error"></span>
                            </div>

                            <div class="form-group">
                                <a href="{{ url('product/inventories') }}" class="btn btn-secondary">Cancelar</a>
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
            var $provider      = $('#provider');
            var $product       = $('#product');
            var $cost          = $('#cost');
            var $form          = $('#inventory-form');
            var $inputs        = $('#inventory-form input, #inventory-form select, #inventory-form button');
            var $errorProvider = $('#error-provider');
            var $errorProduct  = $('#error-product');
            var $errorCost     = $('#error-cost');
            var $errorQuantity = $('#error-quantity');

            $provider.chosen().change(function () {
                $.get('{{ url('product/api/provider-products') }}', {id: $(this).val()}, function (data) {
                    $product.empty();
                    $cost.empty().attr('disabled', true).trigger("chosen:updated");

                    if (data.length) {
                        $.each(data, function (index, element) {
                            if (element.id != undefined) {
                                $product.append("<option value='" + element.id + "'>" + element.description + "</option>");
                            } else {
                                $product.append("<option value=''></option>");
                            }

                        });

                        $product.removeAttr('disabled').trigger("chosen:updated");
                    }
                });
            });

            $product.chosen().change(function () {
                $.get('{{ url('product/api/product-costs') }}', {id: $(this).val()}, function (data) {
                    $cost.empty().attr('disabled', true).trigger("chosen:updated");

                    if (data.length) {
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

            $form.on('submit', function (e) {
                e.preventDefault();

                $errorProvider.html('').parent('.form-group').addClass('has-error');
                $errorProduct.html('').parent('.form-group').addClass('has-error');
                $errorCost.html('').parent('.form-group').addClass('has-error');
                $errorQuantity.html('').parent('.form-group').addClass('has-error');


                $.ajax({
                    url: '{{ url('product/inventories/new') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    beforeSend: function () {
                        $inputs.attr('disabled', true);
                    },
                    success: function (res) {
                        $inputs.removeAttr('disabled');
                        window.location.href = '{{ url('product/inventories') }}';
                    },
                    error: function (res) {
                        var errors = res.responseJSON;


                        if (errors.provider) {
                            $errorProvider.html(errors.provider).parent('.form-group').addClass('has-error');
                        }

                        if (errors.product) {
                            $errorProduct.html(errors.product).parent('.form-group').addClass('has-error');
                        }

                        if (errors.cost) {
                            $errorCost.html(errors.cost).parent('.form-group').addClass('has-error');
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