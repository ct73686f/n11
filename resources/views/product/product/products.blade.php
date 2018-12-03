@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/products/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-cart-plus"></i> <span>Agregar producto</span>
    </a>
    <div class="btn-group">
        <button type="button" class="btn btn-sm header-btn"><i class="fa fa-ellipsis-v"></i> <span>Mostrar</span>
        </button>
        <button type="button" class="btn btn-sm header-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
            <?php $params = []; $params['pages'] = 10; $params = http_build_query(array_merge($params,
                    Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/products') . '?' . $params }}">10 productos</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params,
                    Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/products') . '?' . $params }}">20 productos</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params,
                    Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/products') . '?' . $params }}">30 productos</a>
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
                                <h3 class="title">Productos</h3>
                                <form id="search-form" action="{{ url('product/products') }}" method="GET">
                                    <div class="form-group">
                                        @if (Request::has('pages'))
                                            <input type="hidden" name="pages" value="{{ Request::get('pages') }}">
                                        @endif
                                        {{ Form::text('search', Request::get('search'), ['class' => 'form-control underlined', 'placeholder' => 'Buscar producto', 'id' => 'search']) }}
                                        @if (Request::has('sort'))
                                            <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
                                        @endif
                                        @if (Request::has('order'))
                                            <input type="hidden" name="order" value="{{ Request::get('order') }}">
                                        @endif
                                    </div>
                                </form>
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
                                            <th>@sortablelink('image', 'Imagen')</th>
                                            <th>Precio Unitario</th>
                                            <th>Precio Costo</th>
                                            <th>Proveedor(es)</th>
                                            <th>Categoría(s)</th>
                                            <th>Stock</th>
                                            <th>@sortablelink('created_at', 'Creado en')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->description }}</td>
                                                <td><img class="img-thumbnail img-responsive"
                                                         src="uploads/{{ $product->thumbnail }}" alt=""></td>
                                                <td>{{ $product->cost->unit_price }}</td>
                                                <td>{{ $product->cost->unit_cost }}</td>
                                                <td>{{ $product->providers->implode('name', ', ') }}</td>
                                                <td>{{ $product->categories->implode('description', ', ') }}</td>
                                                <td>{{ is_null($product->inventory) ? 0 : $product->inventory->current }}</td>
                                                <td>{{ $product->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary"
                                                       href="{{ url('product/products/edit', ['id' => $product->id]) }}"><i
                                                                class="fa fa-edit"></i></a>
                                                    <a class="btn btn-sm btn-secondary"
                                                       href="{{ url('product/products/delete', ['id' => $product->id]) }}"><i
                                                                class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $products->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
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
@section('page-script')
    <script>
        $(function () {
            /*$('#search-form').on('submit', function (e) {
                e.preventDefault();
            });*/
        });
    </script>
@endsection