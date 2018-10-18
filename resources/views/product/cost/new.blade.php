@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block sameheight-item">
                        <div class="title-block">
                            <h3 class="title">Nuevo costo</h3>
                        </div>
                        <form role="form" method="POST" action="{{ url('product/costs/new') }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('product') ? ' has-error' : '' }}">
                                <label for="product" class="control-label">Producto</label>
                                {{ Form::select('product', $products, null, ['id' => 'product', 'class' => 'form-control chosen-select', 'data-placeholder' => 'Seleccione las categorias']) }}
                                @if ($errors->has('product'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('product')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('unit_price') ? ' has-error' : '' }}">
                                <label for="unit-price" class="control-label">Precio unitario</label>
                                {{ Form::text('unit_price', null, ['class' => 'form-control underlined', 'placeholder' => 'Precio unitario', 'id' => 'unit-price']) }}
                                @if ($errors->has('unit_price'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('unit_price'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('unit_cost') ? ' has-error' : '' }}">
                                <label for="unit-cost" class="control-label">Costo unitario</label>
                                {{ Form::text('unit_cost', null, ['class' => 'form-control underlined', 'placeholder' => 'Costo unitario', 'id' => 'unit-cost']) }}
                                @if ($errors->has('unit_cost'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('unit_cost'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('wholesale_price') ? ' has-error' : '' }}">
                                <label for="wholesale-price" class="control-label">Precio por mayor</label>
                                {{ Form::text('wholesale_price', null, ['class' => 'form-control underlined', 'placeholder' => 'Precio por mayor', 'id' => 'wholesale-price']) }}
                                @if ($errors->has('wholesale_price'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('wholesale_price'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <a href="{{ url('product/costs') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
