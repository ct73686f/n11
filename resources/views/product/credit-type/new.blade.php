@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Nuevo tipo de credito</h3>
                        </div>
                        <form role="form" method="POST" action="{{ url('product/credit-types/new') }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="control-label">Descripción</label>
                                {{ Form::text('description', null, ['class' => 'form-control underlined', 'placeholder' => 'Descripción', 'id' => 'description']) }}
                                @if ($errors->has('description'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('description')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                                <label for="term" class="control-label">Plazos</label>
                                {{ Form::text('term', null, ['class' => 'form-control underlined', 'placeholder' => 'Plazos', 'id' => 'term']) }}
                                @if ($errors->has('term'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('term')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="control-label">Cantidad</label>
                                {{ Form::text('amount', null, ['class' => 'form-control underlined', 'placeholder' => 'Cantidad', 'id' => 'amount']) }}
                                @if ($errors->has('amount'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('amount')) }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <a href="{{ url('product/credit-types') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
