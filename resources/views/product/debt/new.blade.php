@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-10 offset-md-1">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Nueva Cuenta por Pagar</h3>
                        </div>
                        <form method="POST" action="{{ url('product/debts/new') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('provider') ? ' has-error' : '' }}">
                                        <label for="provider" class="control-label">Proveedor</label>
                                        {{ Form::select('provider', $providers, null, ['class' => 'form-control chosen-select', 'data-placeholder' => 'Seleccionar un proveedor', 'id' => 'provider']) }}
                                        @if ($errors->has('provider'))
                                            <span class="has-error">
                                            {{ ucfirst($errors->first('provider')) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('payment_date') ? ' has-error' : '' }}">
                                        <label for="payment-date" class="control-label">Fecha de pago</label>
                                        {{ Form::text('payment_date', null, ['class' => 'form-control underlined datepicker', 'placeholder' => 'Fecha de pago', 'id' => 'payment-date']) }}
                                        @if ($errors->has('payment_date'))
                                            <span class="has-error">
                                            {{ ucfirst($errors->first('payment_date')) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <label for="amount" class="control-label">Monto</label>
                                        {{ Form::text('amount', null, ['class' => 'form-control underlined', 'placeholder' => 'Monto', 'id' => 'amount']) }}
                                        @if ($errors->has('amount'))
                                            <span class="has-error">
                                        {{ ucfirst($errors->first('amount')) }}
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                        <label for="status" class="control-label">Status Cuenta</label>
                                        {{ Form::select('status', ['Y' => 'Activa', 'N' => 'Inactiva'], null, ['class' => 'form-control chosen-select', 'id' => 'status']) }}
                                        <span id="error-status" class="has-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="{{ url('product/debts') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </article>
@endsection