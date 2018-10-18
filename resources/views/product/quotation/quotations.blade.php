@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/quotations/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-list-alt"></i> <span>Agregar cotización</span>
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
            <a class="dropdown-item" href="{{ url('product/quotations') . '?' . $params }}">10 Cotizaciones</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/quotations') . '?' . $params }}">20 Cotizaciones</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/quotations') . '?' . $params }}">30 Cotizaciones</a>
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
                                <h3 class="title">Cotizaciones</h3>
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
                                            <th>@sortablelink('total', 'Total')</th>
                                            <th>@sortablelink('created_at', 'Creado en')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($quotations as $quotation)
                                            <tr>
                                                <td>{{ $quotation->id }}</td>
                                                <td>{{ $quotation->description }}</td>
                                                <td>{{ $quotation->user->name }}</td>
                                                <td>{{ $quotation->client->full_name }}</td>
                                                <td>{{ $quotation->nit }}</td>
                                                <td>{{ $quotation->total }}</td>
                                                <td>{{ $quotation->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/quotations/view', ['id' => $quotation->id]) }}"><i class="fa fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/quotations/pdf', ['id' => $quotation->id]) }}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $quotations->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
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
