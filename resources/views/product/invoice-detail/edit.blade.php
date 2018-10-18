@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block sameheight-item">
                        <div class="title-block">
                            <h3 class="title">Editar factura</h3>
                        </div>
                        <form role="form" method="POST" action="{{ url('product/invoices/edit', ['id' => $invoice->id]) }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="control-label">Descripción</label>
                                {{ Form::text('description', $invoice->description, ['class' => 'form-control underlined', 'placeholder' => 'Descripción', 'id' => 'description']) }}
                                @if ($errors->has('description'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('description'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('payment_method') ? ' has-error' : '' }}">
                                <label for="payment-method" class="control-label">Medio de pago</label>
                                {{ Form::text('payment_method', $invoice->paymentMethod->description, ['class' => 'form-control underlined', 'placeholder' => 'Medio de pago', 'id' => 'payment-method']) }}
                                @if ($errors->has('payment_method'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('payment_method'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('credit_type') ? ' has-error' : '' }}">
                                <label for="credit-type" class="control-label">Tipo de credito</label>
                                {{ Form::text('credit_type', $invoice->creditType->description, ['class' => 'form-control underlined', 'placeholder' => 'Tipo de credito', 'id' => 'credit-type']) }}
                                @if ($errors->has('credit_type'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('credit_type'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                                <label for="term" class="control-label">Plazos</label>
                                {{ Form::text('term', $invoice->creditType->term, ['class' => 'form-control underlined', 'placeholder' => 'Plazos', 'id' => 'term']) }}
                                @if ($errors->has('term'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('term'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="control-label">Cantidad Plazos</label>
                                {{ Form::text('amount', $invoice->creditType->amount, ['class' => 'form-control underlined', 'placeholder' => 'Cantidad Plazos', 'id' => 'amount']) }}
                                @if ($errors->has('amount'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('amount'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                                <label for="start_date" class="control-label">Fecha Inicial</label>
                                {{ Form::text('start_date', $invoice->client->credit->start_date, ['class' => 'form-control underlined', 'placeholder' => 'Fecha Inicial', 'id' => 'start_date']) }}
                                @if ($errors->has('start_date'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('start_date'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                                <label for="end_date" class="control-label">Fecha Final</label>
                                {{ Form::text('end_date', $invoice->client->credit->end_date, ['class' => 'form-control underlined', 'placeholder' => 'Fecha Final', 'id' => 'end_date']) }}
                                @if ($errors->has('end_date'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('end_date'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                                <label for="nit" class="control-label">NIT</label>
                                {{ Form::text('nit', $invoice->nit, ['class' => 'form-control underlined', 'placeholder' => 'NIT', 'id' => 'nit']) }}
                                @if ($errors->has('nit'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('nit'))  }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('total') ? ' has-error' : '' }}">
                                <label for="total" class="control-label">Total</label>
                                {{ Form::text('total', $invoice->total, ['class' => 'form-control underlined', 'placeholder' => 'Total', 'id' => 'total']) }}
                                @if ($errors->has('total'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('total'))  }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <a href="{{ url('product/invoices') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
