@extends('layouts.app_login')

@section('content')

    <div class="auth">
        <div class="auth-container">
            <div class="card">
                <header class="auth-header">
                    <h1 class="auth-title">
                        <img class="logo" src="img/logo.png" title="BH Developers" alt="BHD Logo">
                    </h1>
                </header>
                <div class="auth-content">
                    <p class="text-xs-center">INICIAR SESION</p>
                    <form id="login-form" method="POST" action="{{ url('/login') }}" novalidate="">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control underlined"
                                   name="email" id="email" placeholder="Correo" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="has-error">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control underlined"
                                   name="password" id="password" placeholder="Contraseña" required>
                            @if ($errors->has('password'))
                                <span class="has-error">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="remember">
                                <input class="checkbox" checked="checked" name="remember" id="remember" type="checkbox">
                                <span>Recordarme</span>
                            </label>
                            <a href="{{ url('/password/reset') }}" class="forgot-btn pull-right">¿Olvidaste tu contraseña?</a></div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Iniciar sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
