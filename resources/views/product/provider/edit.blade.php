@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block sameheight-item">
                        <div class="title-block">
                            <h3 class="title">Editar proveedor</h3>
                        </div>
                        <form role="form" method="POST" action="{{ url('product/providers/edit', ['id' => $provider->id]) }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="control-label">Nombre</label>
                                <input id="name" class="form-control underlined" type="text" placeholder="Nombre" name="name" value="{{ is_null(old('name')) ? $provider->name : old('name') }}" required>
                                @if ($errors->has('name'))
                                    <span class="has-error">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone" class="control-label">Teléfono</label>
                                <input id="phone" class="form-control underlined" type="text" placeholder="Teléfono" name="phone" value="{{ is_null(old('phone')) ? $provider->phone : old('phone') }}" required>
                                @if ($errors->has('phone'))
                                    <span class="has-error">
                                        {{ $errors->first('phone') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="control-label">Dirección</label>
                                <input id="address" class="form-control underlined" type="text" placeholder="Dirección" name="address" value="{{ is_null(old('address')) ? $provider->address : old('address') }}" required>
                                @if ($errors->has('address'))
                                    <span class="has-error">
                                        {{ $errors->first('address') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">Correo</label>
                                <input id="email" class="form-control underlined" type="text" placeholder="Correo" name="email" value="{{ is_null(old('email')) ? $provider->email : old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="has-error">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('contact') ? ' has-error' : '' }}">
                                <label for="contact" class="control-label">Contacto</label>
                                <input id="contact" class="form-control underlined" type="text" placeholder="Contacto" name="contact" value="{{ is_null(old('contact')) ? $provider->contact : old('contact') }}" required>
                                @if ($errors->has('contact'))
                                    <span class="has-error">
                                        {{ $errors->first('contact') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                                <label for="website" class="control-label">Sitio Web</label>
                                <input id="website" class="form-control underlined" type="text" placeholder="Sitio Web" name="website" value="{{ is_null(old('website')) ? $provider->website : old('website') }}" required>
                                @if ($errors->has('website'))
                                    <span class="has-error">
                                        {{ $errors->first('website') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('additional_info') ? ' has-error' : '' }}">
                                <label for="additional_info" class="control-label">Información Adicional</label>
                                <input id="additional_info" class="form-control underlined" type="text" placeholder="Información Adicional" name="additional_info" value="{{ is_null(old('additional_info')) ? $provider->additional_info : old('additional_info') }}" required>
                                @if ($errors->has('additional_info'))
                                    <span class="has-error">
                                        {{ $errors->first('additional_info') }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <a href="{{ url('admin/users') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
