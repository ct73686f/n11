@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block sameheight-item">
                        <div class="title-block">
                            <h3 class="title">Nuevo usuario</h3>
                        </div>
                        <form role="form" method="POST" action="{{ url('admin/users/new') }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="control-label">Nombre</label>
                                <input id="name" class="form-control underlined" type="text" placeholder="Nombre" name="name" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <span class="has-error">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">Correo</label>
                                <input id="email" class="form-control underlined" type="email" placeholder="Correo" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="has-error">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="role" class="control-label">Rol</label>
                                <select id="role" name="role" class="form-control">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == old('role') ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="control-label">Contraseña</label>
                                <input id="password" class="form-control underlined" type="password" placeholder="Contraseña" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="has-error">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password-confirm') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="control-label">Confirmar contraseña</label>
                                <input id="password-confirm" class="form-control underlined" type="password" placeholder="Confirmar contraseña" name="password_confirmation" required>
                                @if ($errors->has('password-confirm'))
                                    <span class="has-error">
                                        {{ $errors->first('password-confirm') }}
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
