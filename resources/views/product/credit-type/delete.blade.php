@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block">
                        <section class="section">
                            <form role="form" method="POST" action="{{ url('product/credit-types/delete', ['id' => $creditType->id]) }}" novalidate>
                                {{ csrf_field() }}
                                <h6>¿Confirma que desea eliminar el tipo de credito {{ $creditType->first_name . ' ' . $creditType->description }}?</h6>
                                <br>
                                <div class="form-group">
                                    <a href="{{ url('product/credit-types') }}" class="btn btn-secondary">Cancelar</a>
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
