@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/inventories/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-cart-plus"></i> <span>Agregar inventario</span>
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
            <a class="dropdown-item" href="{{ url('product/inventarios') . '?' . $params }}">10 inventarios</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/inventarios') . '?' . $params }}">20 inventarios</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/inventarios') . '?' . $params }}">30 inventarios</a>
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
                                <h3 class="title">Inventarios</h3>
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
                                            <th>@sortablelink('user_id', 'Usuario')</th>
                                            <th>@sortablelink('product_id', 'Producto')</th>
                                            <th>@sortablelink('cost_id', 'Costo')</th>
                                            <th>@sortablelink('current', 'Stock')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($inventories as $inventory)
                                            <tr>
                                                <td>{{ $inventory->id }}</td>
                                                <td>{{ $inventory->user->name }}</td>
                                                <td>{{ $inventory->product->description }}</td>
                                                <td>{{ $inventory->cost->cost_value }}</td>
                                                <td>{{ $inventory->current }}</td>
                                                <td>{{ $inventory->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/documents/delete', ['id' => $inventory->id]) }}"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $inventories->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
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
