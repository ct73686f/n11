@extends('layouts.app_login')

<!-- Main Content -->
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
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="text-xs-center">REINICIAR CONTRASEÑA</p>
                    <p class="text-muted text-xs-center">
                        <small>Ingrese su dirección de correo para reiniciar su contraseña.</small>
                    </p>
                    <form id="reset-form" method="POST" action="{{ url('/password/email') }}" novalidate="">
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
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Reiniciar contraseña</button>
                        </div>
                        <div class="form-group clearfix"><a class="pull-left" href="{{ url('/login') }}">Iniciar sesión</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
