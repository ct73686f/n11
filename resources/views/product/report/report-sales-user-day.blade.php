@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Reporte Ventas Usuario por Día</h3>
                        </div>
                        <form id="report-cash-day-form">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                                <label for="client" class="control-label">Fecha</label>
                                {{ Form::text('date', null, ['class' => 'form-control underlined datepicker-dashed', 'placeholder' => 'Fecha', 'id' => 'cash-day-date']) }}
                                <span id="error-cash-day-date" class="has-error"></span>
                            </div>
                            <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
                                <label for="user" class="control-label">Usuario</label>
                                {{ Form::select('user', $users, null, ['class' => 'form-control underlined chosen-select', 'data-placeholder' => 'Seleccione un usuario', 'id' => 'user']) }}
                                <span id="error-user" class="has-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="details">
                                    <input type="checkbox" class="checkbox" id="details" name="details">
                                    <span>Incluir detalles</span>
                                </label>
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
            // cash
            var $reportCashDayForm = $('#report-cash-day-form');
            var $errorCashDayDate  = $('#error-cash-day-date');
            var $errorUser         = $('#error-user');

            $reportCashDayForm.on('submit', function (e) {
                e.preventDefault();
                var $this = $(this);
                $errorCashDayDate.html('').parent('.form-group').removeClass('has-error');
                $errorUser.html('').parent('.form-group').removeClass('has-error');

                $.ajax({
                    url: '{{ url('product/reports/sales/user/day') }}',
                    type: 'POST',
                    data: $this.serialize(),
                    success: function (res) {
                        $this[0].reset();
                        $('#user').val('').trigger('chosen:updated');

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
                        var errors = res.responseJSON;

                        if (errors.date) {
                            $errorCashDayDate.html(errors.date).parent('.form-group').addClass('has-error');
                        }

                        if (errors.user) {
                            $errorUser.html(errors.user).parent('.form-group').addClass('has-error');
                        }
                    }
                });
            });
        });

    </script>
@endsection