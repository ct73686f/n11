@extends('layouts.app')

@section('content')
    <article class="content dashboard-page">
        <section class="section">
            <div class="row sameheight-container">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
                    <div class="card sameheight-item stats" data-exclude="xs" style="height: 316px;">
                        <div class="card-block">
                            <div class="title-block">
                                <h4 class="title"> Bienvenido {{ auth()->user()->name }}</h4>
                                <p class="title-description"> Applicación Inventario ver. 1.0</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
