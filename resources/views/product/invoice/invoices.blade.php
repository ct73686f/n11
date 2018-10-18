@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/invoices/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-list-alt"></i> <span>Agregar venta de mercaderia</span>
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
            <a class="dropdown-item" href="{{ url('product/invoices') . '?' . $params }}">10 ventas de mercaderia</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/invoices') . '?' . $params }}">20 ventas de mercaderia</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/invoices') . '?' . $params }}">30 ventas de mercaderia</a>
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
                                <h3 class="title">Ventas de mercaderia</h3>
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
                                            <th>@sortablelink('description', 'Descripción')</th>
                                            <th>@sortablelink('user_id', 'Usuario')</th>
                                            <th>@sortablelink('client_id', 'Cliente')</th>
                                            <th>@sortablelink('nit', 'NIT')</th>
                                            <th>@sortablelink('discount', 'Descuento')</th>
                                            <th>@sortablelink('total', 'Total')</th>
                                            <th>@sortablelink('created_at', 'Creado en')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->id }}</td>
                                                <td>{{ $invoice->description }}</td>
                                                <td>{{ $invoice->user->name }}</td>
                                                <td>{{ $invoice->client->full_name }}</td>
                                                <td>{{ $invoice->nit }}</td>
                                                <td>{{ number_format($invoice->discount, 2) }}</td>
                                                <td>{{ number_format($invoice->total, 2) }}</td>
                                                <td>{{ $invoice->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/invoices/view', ['id' => $invoice->id]) }}"><i class="fa fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/invoices/pdf', ['id' => $invoice->id]) }}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $invoices->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
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
