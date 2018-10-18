@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block sameheight-item">
                        <div class="title-block">
                            <h3 class="title">Editar producto</h3>
                        </div>
                        <form role="form" enctype="multipart/form-data" method="POST" action="{{ url('product/products/edit', ['id' => $product->id]) }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="control-label">Descripción</label>
                                {{ Form::text('description', $product->description, ['class' => 'form-control underlined', 'placeholder' => 'Descripción', 'id' => 'description']) }}
                                @if ($errors->has('description'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('description')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image" class="control-label">Descripción</label>
                                {{ Form::file('image', ['class' => 'form-control underlined', 'id' => 'image']) }}
                                @if ($errors->has('image'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('image')) }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('provider') ? ' has-error' : '' }}">
                                <label for="provider" class="control-label">Proveedor(es)</label>
                                {{ Form::select('provider[]', $providers, $product->providers->pluck('id')->toArray(), ['multiple' => true, 'id' => 'provider', 'class' => 'form-control chosen-select', 'data-placeholder' => 'Seleccione a los proveedores']) }}
                                @if ($errors->has('provider'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('provider')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                <label for="category" class="control-label">Categoría(s)</label>
                                {{ Form::select('category[]', $categories, $product->categories->pluck('id')->toArray(), ['multiple' => true, 'id' => 'category', 'class' => 'form-control chosen-select', 'data-placeholder' => 'Seleccione las categorias']) }}
                                @if ($errors->has('category'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('category')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('bar_code') ? ' has-error' : '' }}">
                                <label for="bar-code" class="control-label">Código(s) de Barra</label>
                                {{ Form::text('bar_code', $product->barcodes->pluck('code')->implode(', '), ['class' => 'form-control underlined multi-values', 'placeholder' => 'Código Barra', 'id' => 'bar-code', 'data-default' => 'Agregar código de barra']) }}
                                @if ($errors->has('bar_code'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('bar_code'))  }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('unit_price') ? ' has-error' : '' }}">
                                <label for="unit-price" class="control-label">Precio unitario</label>
                                {{ Form::text('unit_price', $product->cost->unit_price, ['class' => 'form-control underlined', 'placeholder' => 'Precio unitario', 'id' => 'unit-price']) }}
                                @if ($errors->has('unit_price'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('unit_price'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('unit_cost') ? ' has-error' : '' }}">
                                <label for="unit-cost" class="control-label">Costo unitario</label>
                                {{ Form::text('unit_cost', $product->cost->unit_cost, ['class' => 'form-control underlined', 'placeholder' => 'Costo unitario', 'id' => 'unit-cost']) }}
                                @if ($errors->has('unit_cost'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('unit_cost'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('wholesale_price') ? ' has-error' : '' }}">
                                <label for="wholesale-price" class="control-label">Precio por mayor</label>
                                {{ Form::text('wholesale_price', $product->cost->wholesale_price, ['class' => 'form-control underlined', 'placeholder' => 'Precio por mayor', 'id' => 'wholesale-price']) }}
                                @if ($errors->has('wholesale_price'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('wholesale_price'))  }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <a href="{{ url('product/products') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
