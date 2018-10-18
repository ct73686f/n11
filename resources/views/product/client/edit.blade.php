@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-block sameheight-item">
                        <div class="title-block">
                            <h3 class="title">Editar documento</h3>
                        </div>
                        <form role="form" enctype="multipart/form-data" method="POST" action="{{ url('product/clients/edit', ['id' => $client->id]) }}" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first-name" class="control-label">Nombre</label>
                                {{ Form::text('first_name', $client->first_name, ['class' => 'form-control underlined', 'placeholder' => 'Nombre', 'id' => 'first-name']) }}
                                @if ($errors->has('first_name'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('first_name')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last-name" class="control-label">Apellido</label>
                                {{ Form::text('last_name', $client->last_name, ['class' => 'form-control underlined', 'placeholder' => 'Apellido', 'id' => 'last-name']) }}
                                @if ($errors->has('last_name'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('last_name')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="control-label">Dirección</label>
                                {{ Form::text('address', $client->address, ['class' => 'form-control underlined', 'placeholder' => 'Dirección', 'id' => 'address']) }}
                                @if ($errors->has('address'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('address')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                                <label for="nit" class="control-label">NIT</label>
                                {{ Form::text('nit', $client->nit, ['class' => 'form-control underlined', 'placeholder' => 'NIT', 'id' => 'nit']) }}
                                @if ($errors->has('nit'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('nit')) }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone" class="control-label">Teléfono</label>
                                {{ Form::text('phone', $client->phone, ['class' => 'form-control underlined', 'placeholder' => 'Teléfono', 'id' => 'phone']) }}
                                @if ($errors->has('phone'))
                                    <span class="has-error">
                                        {{ ucfirst($errors->first('phone')) }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <a href="{{ url('product/clients') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
