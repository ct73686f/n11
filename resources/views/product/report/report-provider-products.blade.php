@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Reporte Productos por Proveedor</h3>
                        </div>
                        <form id="report-cash-day-form">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
                                <label for="category" class="control-label">Categoría</label>
                                {{ Form::select('provider', $providers, null, ['class' => 'form-control underlined chosen-select', 'data-placeholder' => 'Seleccione un proveedor', 'id' => 'provider']) }}
                                <span id="error-category" class="has-error"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Generar PDF</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection

@section('page-script')
    <script>
        $(function () {
            var $reportCashDayForm = $('#report-cash-day-form');

            $reportCashDayForm.on('submit', function (e) {
                e.preventDefault();
                var $this = $(this);

                $.ajax({
                    url: '{{ url('product/reports/provider-products') }}',
                    type: 'POST',
                    data: $this.serialize(),
                    success: function (res) {
                        //$this[0].reset();

                        $.popupWindow({
                            height: 500,
                            width: 800,
                            top: 50,
                            left: 50,
                            scrollbars: 1,
                            windowURL: res.url,
                            windowName: res.url
                        });
                    },
                    error: function (res) {

                    }
                });
            });
        });

    </script>
@endsection