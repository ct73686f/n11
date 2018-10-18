@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Reporte Ingreso de Mercaderia del Día Actual</h3>
                        </div>
                        <form id="report-cash-day-form">
                            {{ csrf_field() }}
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                                    <label for="client" class="control-label">Fecha Inicio</label>
                                    {{ Form::text('date', null, ['class' => 'form-control underlined datepicker-dashed', 'placeholder' => 'Fecha Inicio', 'id' => 'date']) }}
                                    <span id="error-date" class="has-error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Generar PDF</button>
                                </div>
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
        $(function() {
            // cash
            var $reportCashDayForm = $('#report-cash-day-form');
            var $errorCashDayDate  = $('#error-date');

            $reportCashDayForm.on('submit', function (e) {
                e.preventDefault();
                var $this = $(this);
                $errorCashDayDate.html('').parent('.form-group').removeClass('has-error');

                $.ajax({
                    url: '{{ url('product/reports/merchandise-income-day') }}',
                    type: 'POST',
                    data: $this.serialize(),
                    success: function (res) {
                        $this[0].reset();

                        $.popupWindow({
                            height:500,
                            width:800,
                            top:50,
                            left:50,
                            scrollbars: 1,
                            windowURL: res.url,
                            windowName: res.url
                        });
                    },
                    error: function (res) {
                        var errors = res.responseJSON;

                        if (errors.date) {
                            $errorCashDayDate.html(errors.date).parent('.form-group').addClass('has-error');
                        }
                    }
                });
            });
        });

    </script>
@endsection