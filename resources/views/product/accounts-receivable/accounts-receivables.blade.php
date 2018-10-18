@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/accounts-receivables/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-money"></i> <span>Agregar cuenta por cobrar</span>
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
            <a class="dropdown-item" href="{{ url('product/accounts-receivables') . '?' . $params }}">10 cuentas por cobrar</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/accounts-receivables') . '?' . $params }}">20 cuentas por cobrar</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/accounts-receivables') . '?' . $params }}">30 cuentas por cobrar</a>
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
                                <h3 class="title">Cuentas por Cobrar</h3>
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
                                            <th>@sortablelink('invoice_id', 'Venta de mercaderia')</th>
                                            <th>@sortablelink('client_id', 'Cliente')</th>
                                            <th>@sortablelink('payment_date', 'Fecha de pago')</th>
                                            <th>@sortablelink('total', 'Total')</th>
                                            <th>@sortablelink('status', 'Pagado')</th>
                                            <th>@sortablelink('created_at', 'Creado en')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($accountsReceivables as $receivable)
                                            <tr>
                                                <td>{{ $receivable->id }}</td>
                                                <td>{{ $receivable->invoice->description }}</td>
                                                <td>{{ $receivable->client->full_name }}</td>
                                                <td>{{ $receivable->payment_date }}</td>
                                                <td>{{ $receivable->total }}</td>
                                                <td>{{ $receivable->status }}</td>
                                                <td>{{ $receivable->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/accounts-receivables/edit', ['id' => $receivable->id]) }}"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/accounts-receivables/delete', ['id' => $receivable->id]) }}"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $accountsReceivables->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
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
