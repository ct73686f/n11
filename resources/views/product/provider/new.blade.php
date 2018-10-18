@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block sameheight-item">
                        <div class="title-block">
                            <h3 class="title">Nuevo proveedor</h3>
                        </div>
                        <form role="form" method="POST" action="{{ url('product/providers/new') }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="control-label">Nombre</label>
                                <input id="name" class="form-control underlined" type="text" placeholder="Nombre" name="name" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('name')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone" class="control-label">Teléfono</label>
                                <input id="phone" class="form-control underlined" type="text" placeholder="Teléfono" name="phone" value="{{ old('phone') }}" required>
                                @if ($errors->has('phone'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('phone')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="control-label">Dirección</label>
                                <input id="address" class="form-control underlined" type="text" placeholder="Dirección" name="address" value="{{ old('address') }}" required>
                                @if ($errors->has('address'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('address')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">Correo</label>
                                <input id="email" class="form-control underlined" type="text" placeholder="Correo" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('email')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('contact') ? ' has-error' : '' }}">
                                <label for="contact" class="control-label">Contacto</label>
                                <input id="contact" class="form-control underlined" type="text" placeholder="Contacto" name="contact" value="{{ old('contact') }}" required>
                                @if ($errors->has('contact'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('contact')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                                <label for="website" class="control-label">Sitio Web</label>
                                <input id="website" class="form-control underlined" type="text" placeholder="Sitio Web" name="website" value="{{ old('website') }}" required>
                                @if ($errors->has('website'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('website')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('additional_info') ? ' has-error' : '' }}">
                                <label for="additional_info" class="control-label">Información Adicional</label>
                                <input id="additional_info" class="form-control underlined" type="text" placeholder="Información Adicional" name="additional_info" value="{{ old('additional_info') }}" required>
                                @if ($errors->has('additional_info'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('additional_info')) }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <a href="{{ url('product/providers') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
