@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block">
                        <section class="section">
                            <form role="form" method="POST" action="{{ url('product/payment-methods/delete', ['id' => $paymentMethod->id]) }}" novalidate>
                                {{ csrf_field() }}
                                <h6>¿Confirma que desea eliminar el medio de pago {{ $paymentMethod->description }}?</h6>
                                <br>
                                <div class="form-group">
                                    <a href="{{ url('product/payment-methods') }}" class="btn btn-secondary">Cancelar</a>
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
