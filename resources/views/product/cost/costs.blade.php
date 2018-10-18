@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/costs/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-tag"></i> <span>Agregar costo</span>
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
            <a class="dropdown-item" href="{{ url('product/costs') . '?' . $params }}">10 costos</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/costs') . '?' . $params }}">20 costos</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/costs') . '?' . $params }}">30 costos</a>
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
                                <h3 class="title">Costos</h3>
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
                                            <th>@sortablelink('product_id', 'Producto')</th>
                                            <th>@sortablelink('unit_price', 'Precio Unitario')</th>
                                            <th>@sortablelink('unit_cost', 'Costo Unitario')</th>
                                            <th>@sortablelink('wholesale_price', 'Precio por Mayor')</th>
                                            <th>@sortablelink('created_at', 'Creado en')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($costs as $cost)
                                            <tr>
                                                <td>{{ $cost->id }}</td>
                                                <td>{{ $cost->product->description }}</td>
                                                <td>{{ $cost->unit_price }}</td>
                                                <td>{{ $cost->unit_cost }}</td>
                                                <td>{{ $cost->wholesale_price }}</td>
                                                <td>{{ $cost->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/costs/edit', ['id' => $cost->id]) }}"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/costs/delete', ['id' => $cost->id]) }}"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $costs->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
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
