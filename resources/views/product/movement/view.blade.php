@extends('layouts.app')


@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-10 offset-md-1">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Movimiento Inventario # {{ $movement->id }}</h3>
                        </div>
                       <div class="row">
                           <div class="col-md-4">
                               <div class="form-group{{ $errors->has('document') ? ' has-error' : '' }}">
                                   <label for="document" class="control-label">Tipo de movimiento</label>
                                   <p>
                                       {{ $movement->document->description . ' - ' . $movement->document->output_type }}
                                   </p>
                               </div>
                           </div>
                           @if ($movement->document->raw_output_type == 'E')
                               <div class="col-md-8">
                                   <label>No. Factura</label>
                                   <p>
                                       {{ $movement->invoice_number }}
                                   </p>
                               </div>
                           @endif
                           <div class="col-md-8">
                               <label>Total</label>
                               <p>
                                   {{ $movement->total }}
                               </p>
                           </div>
                       </div>
                    </div>

                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Detalle Movimiento</h3>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-block">
                                        <div class="card-title-block">
                                            <h3 class="title">Productos</h3>
                                        </div>
                                        <section class="example form-group">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Código</th>
                                                        <th>Descripción</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio</th>
                                                        <th>Sub Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="movement-products">
                                                    @foreach($movement->details as $detail)
                                                        <tr>
                                                            <td>{{ $detail->id }}</td>
                                                            <td>{{ $detail->product->id }}</td>
                                                            <td>{{ $detail->product->description }}</td>
                                                            <td>{{ $detail->quantity }}</td>
                                                            <td>{{ $detail->price }}</td>
                                                            <td>{{ $detail->sub_total }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <span id="error-product" class="has-error"></span>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="product-ids">

                        </div>
                        <input type="hidden" id="document-id" name="document">


                        <div class="form-group">
                            <a href="{{ url('product/movements') }}" class="btn btn-secondary">Regresar a movimientos</a>
                            <a href="{{ url('product/movements/pdf', ['id' => $movement->id]) }}" class="btn btn-primary">Imprimir PDF</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </article>
@endsection
