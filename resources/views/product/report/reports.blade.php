@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-10 offset-md-1">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Reporte</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                                    <label for="client" class="control-label">Cliente</label>

                                    <span id="error-client" class="has-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                                    <label for="nit" class="control-label">NIT</label>
                                    {{ Form::text('nit', 'CF', ['class' => 'form-control underlined', 'placeholder' => 'NIT', 'id' => 'nit']) }}
                                    <span id="error-nit" class="has-error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('wholesale_apply') ? ' has-error' : '' }}">
                            <label for="wholesale-apply" class="control-label">Venta al por mayor</label>
                            {{ Form::select('wholesale_apply[]', ['', 'Y' => 'Sí', 'N' => 'No'], null, ['id' => 'wholesale-apply', 'class' => 'form-control chosen-select', 'data-placeholder' => 'Seleccione una opción']) }}
                            @if ($errors->has('wholesale_apply'))
                                <span class="has-error" id="error-wholesale-apply">
                                    {{ ucfirst($errors->first('wholesale_apply')) }}
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="control-label">Descripción</label>
                            {{ Form::text('description', null, ['class' => 'form-control underlined', 'placeholder' => 'Descripción', 'id' => 'description']) }}
                            <span id="error-description" class="has-error"></span>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </article>
@endsection