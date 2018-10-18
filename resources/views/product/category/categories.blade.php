@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/categories/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-tag"></i> <span>Agregar categoría</span>
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
            <a class="dropdown-item" href="{{ url('product/categories') . '?' . $params }}">10 categorias</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/categories') . '?' . $params }}">20 categorias</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/categories') . '?' . $params }}">30 categorias</a>
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
                                <h3 class="title">Categorias</h3>
                                <form id="search-form" action="{{ url('product/categories') }}" method="GET">
                                    <div class="form-group">
                                        @if (Request::has('pages'))
                                            <input type="hidden" name="pages" value="{{ Request::get('pages') }}">
                                        @endif
                                        {{ Form::text('search', Request::get('search'), ['class' => 'form-control underlined', 'placeholder' => 'Buscar categoría', 'id' => 'search']) }}
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
                                            <th>@sortablelink('created_at', 'Creado en')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td>{{ $category->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/categories/edit', ['id' => $category->id]) }}"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-sm btn-secondary" href="{{ url('product/categories/delete', ['id' => $category->id]) }}"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $categories->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
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
