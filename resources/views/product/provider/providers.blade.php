@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/providers/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-truck"></i> <span>Agregar proveedor</span>
    </a>
    <div class="btn-group">
        <button type="button" class="btn btn-sm header-btn"><i class="fa fa-ellipsis-v"></i> <span>Mostrar</span>
        </button>
        <button type="button" class="btn btn-sm header-btn dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
            <?php $params = []; $params['pages'] = 10; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/providers') . '?' . $params }}">10 proveedores</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/providers') . '?' . $params }}">20 proveedores</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/providers') . '?' . $params }}">30 proveedores</a>
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
                                <h3 class="title">Proveedores</h3>
                                <form id="search-form" action="{{ url('product/providers') }}" method="GET">
                                    <div class="form-group">
                                        @if (Request::has('pages'))
                                            <input type="hidden" name="pages" value="{{ Request::get('pages') }}">
                                        @endif
                                        {{ Form::text('search', Request::get('search'), ['class' => 'form-control underlined', 'placeholder' => 'Buscar proveedor', 'id' => 'search']) }}
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
                                            <th>@sortablelink('name', 'Nombre')</th>
                                            <th>@sortablelink('phone', 'Teléfono')</th>
                                            <th>@sortablelink('address', 'Dirección')</th>
                                            <th>@sortablelink('email', 'Correo')</th>
                                            <th>@sortablelink('contact', 'Contacto')</th>
                                            <th>@sortablelink('website', 'Sitio Web')</th>
                                            <th>@sortablelink('additional_info', 'Información Adicional')</th>
                                            <th>@sortablelink('created_at', 'Creado en')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($providers as $provider)
                                            <tr>
                                                <td>{{ $provider->id }}</td>
                                                <td>{{ $provider->name }}</td>
                                                <td>{{ $provider->phone }}</td>
                                                <td>{{ $provider->address }}</td>
                                                <td>{{ $provider->email }}</td>
                                                <td>{{ $provider->contact }}</td>
                                                <td>{{ $provider->website }}</td>
                                                <td>{{ $provider->additional_info }}</td>
                                                <td>{{ $provider->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/providers/edit', ['id' => $provider->id]) }}"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/providers/delete', ['id' => $provider->id]) }}"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $providers->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
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
