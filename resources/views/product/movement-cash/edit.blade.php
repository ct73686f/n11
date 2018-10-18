@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block sameheight-item">
                        <div class="title-block">
                            <h3 class="title">Editar documento</h3>
                        </div>
                        <form role="form" enctype="multipart/form-data" method="POST" action="{{ url('product/documents/edit', ['id' => $document->id]) }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="control-label">Descripción</label>
                                {{ Form::text('description', $document->description, ['class' => 'form-control underlined', 'placeholder' => 'Descripción', 'id' => 'description']) }}
                                @if ($errors->has('description'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('description')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('output_type') ? ' has-error' : '' }}">
                                <label for="output-type" class="control-label">Tipo de salida</label>
                                {{ Form::select('output_type', ['E' => 'Entrada de productos', 'S' => 'Salida de productos'], $document->raw_output_type, ['id' => 'output-type', 'class' => 'form-control chosen-select']) }}
                                @if ($errors->has('output_type'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('output_type')) }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <a href="{{ url('product/documents') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
