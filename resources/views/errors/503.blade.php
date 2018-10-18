<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <base href="{{ url('/') }}">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/css/app-red.css" rel="stylesheet">
    <link href="/css/vendor.css" rel="stylesheet">
</head>

<body>
<div class="app blank sidebar-opened">
    <article class="content">
        <div class="error-card global">
            <div class="error-title-block">
                <h1 class="error-title">503</h1>
                <h2 class="error-sub-title">Volveremos pronto</h2>
            </div>
            <br>
            <div class="error-container">
                <a class="btn btn-primary" href="{{ url('/') }}"> <i class="fa fa-angle-left"></i> Volver al inicio</a>
            </div>
        </div>
    </article>
</div>
<script src="js/vendor.js"></script>
<script src="js/app.js"></script>
</body>
</html>