@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card card-block sameheight-item">
                        <section class="section">
                            <form role="form" method="POST" action="{{ url('admin/users/delete', ['id' => $user->id]) }}" novalidate>
                                {{ csrf_field() }}
                                <h6>¿Confirma que desea eliminar al usuario {{ $user->name }}?</h6>
                                <br>
                                <div class="form-group">
                                    <a href="{{ url('admin/users') }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Aceptar</button>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
