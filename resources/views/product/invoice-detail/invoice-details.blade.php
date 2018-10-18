@extends('layouts.app')

@section('action-buttons')
    <a href="{{ url('product/invoice-details/new') }}" class="btn btn-sm header-btn">
        <i class="fa fa-list-alt"></i> <span>Agregar detalle factura</span>
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
            <a class="dropdown-item" href="{{ url('product/invoice-details') . '?' . $params }}">10 detalles de factura</a>
            <?php $params = []; $params['pages'] = 20; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/invoice-details') . '?' . $params }}">20 detalles factura</a>
            <?php $params = []; $params['pages'] = 30; $params = http_build_query(array_merge($params, Request::except('pages'))); ?>
            <a class="dropdown-item" href="{{ url('product/invoice-details') . '?' . $params }}">30 detalles factura</a>
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
                                <h3 class="title">Detalles Factura</h3>
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
                                            <th>@sortablelink('invoice_id', 'Factura')</th>
                                            <th>@sortablelink('product_id', 'Producto')</th>
                                            <th>@sortablelink('quantity', 'Cantidad')</th>
                                            <th>@sortablelink('unit_price', 'Precio Unitario')</th>
                                            <th>@sortablelink('unit_cost', 'Costo Unitario')</th>
                                            <th>@sortablelink('sub_total', 'Sub Total')</th>
                                            <th>@sortablelink('created_at', 'Creado en')</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoiceDetails as $invoiceDetail)
                                            <tr>
                                                <td>{{ $invoiceDetail->id }}</td>
                                                <td>{{ $invoiceDetail->invoice->description }}</td>
                                                <td>{{ $invoiceDetail->product->description }}</td>
                                                <td>{{ $invoiceDetail->quantity }}</td>
                                                <td>{{ $invoiceDetail->unit_price }}</td>
                                                <td>{{ $invoiceDetail->unit_cost }}</td>
                                                <td>{{ $invoiceDetail->sub_total }}</td>
                                                <td>{{ $invoiceDetail->created_at->format('d/m/Y - H:i A')  }}</td>
                                                <td>
                                                    <!--<a class="btn btn-sm btn-secondary" href="{{ url('product/invoice-details/delete', ['id' => $invoiceDetail->id]) }}"><i class="fa fa-remove"></i></a>-->
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-xs-right">
                                        {!! $invoiceDetails->appends(Request::except('page'))->render('vendor.pagination.bootstrap-4') !!}
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
