@extends('layouts.app')

@section('content')
    <article class="content responsive-tables-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title">Reporte Cuentas por Cobrar</h3>
                        </div>
                        <form id="report-cash-day-form">
                            {{ csrf_field() }}
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
        $(function() {
            // cash
            var $reportCashDayForm = $('#report-cash-day-form');

            $reportCashDayForm.on('submit', function (e) {
                e.preventDefault();
                var $this = $(this);

                $.ajax({
                    url: '{{ url('product/reports/accounts-receivables') }}',
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

                    }
                });
            });
        });

    </script>
@endsection