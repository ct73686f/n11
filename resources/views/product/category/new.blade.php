@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block sameheight-item">
                        <div class="title-block">
                            <h3 class="title">Nueva categoría</h3>
                        </div>
                        <form role="form" method="POST" action="{{ url('product/categories/new') }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="name" class="control-label">Descripción</label>
                                <input id="name" class="form-control underlined" type="text" placeholder="Descripción" name="description" value="{{ old('description') }}" required>
                                @if ($errors->has('description'))
                                    <span class="has-error">
                                        {{ $errors->first('description') }}
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
