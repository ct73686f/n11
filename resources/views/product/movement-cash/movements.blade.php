@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/movements-cash/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-cart-plus"></i> <span>Agregar movimiento efectivo</span>
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
            <a class="dropdown-item" href="{{ url('product/movements-cash') . '?' . $params }}">10 movimientos efectivo</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/movements-cash') . '?' . $params }}">20 movimientos efectivo</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/movements-cash') . '?' . $params }}">30 movimientos efectivo</a>
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
                                <h3 class="title">Movimientos Efectivo</h3>
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
                                            <th>@sortablelink('document_cash_id', 'Movimiento')</th>
                                            <th>@sortablelink('description', 'Descripción')</th>
                                            <th>@sortablelink('amount', 'Monto')</th>
                                            <th>Tipo Salida</th>
                                            <th>@sortablelink('created_at', 'Creado en')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($movements as $movement)
                                            <tr>
                                                <td>{{ $movement->id }}</td>
                                                <td>{{ $movement->document->description }}</td>
                                                <td>{{ $movement->description }}</td>
                                                <td>{{ number_format($movement->amount, '2', '.', ',') }}</td>
                                                <td>{{ $movement->document->output_type }}</td>
                                                <td>{{ $movement->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $movements->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
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
