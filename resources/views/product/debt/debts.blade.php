@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/debts/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-money"></i> <span>Agregar cuenta por pagar</span>
    </a>
    <div class="btn-group">
        <button type="button" class="btn btn-sm header-btn"><i class="fa fa-ellipsis-v"></i> <span>Mostrar</span>
        </button>
        <button type="button" class="btn btn-sm header-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
            <?php $params = []; $params['pages'] = 10; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/debts') . '?' . $params }}">10 cuentas por pagar</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/debts') . '?' . $params }}">20 cuentas por pagar</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/debts') . '?' . $params }}">30 cuentas por pagar</a>
        </div>
    </div>
@endsection

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="card-title-block">
                                <h3 class="title">Cuentas por Pagar</h3>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section class="example">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>@sortablelink('id', '#')</th>
                                            <th>@sortablelink('provider_id', 'Proveedor')</th>
                                            <th>@sortablelink('payment_date', 'Fecha de pago')</th>
                                            <th>@sortablelink('amount', 'Monto')</th>
                                            <th>@sortablelink('status', 'Status cuenta')</th>
                                            <th>@sortablelink('created_at', 'Creado en')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($debts as $debt)
                                            <tr>
                                                <td>{{ $debt->id }}</td>
                                                <td>{{ $debt->provider->name }}</td>
                                                <td>{{ $debt->payment_date }}</td>
                                                <td>{{ $debt->amount }}</td>
                                                <td>{{ $debt->status }}</td>
                                                <td>{{ $debt->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/debts/edit', ['id' => $debt->id]) }}"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/debts/delete', ['id' => $debt->id]) }}"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $debts->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
                                    </nav>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
