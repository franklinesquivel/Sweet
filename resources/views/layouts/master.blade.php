<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ env('APP_NAME') }} - @yield('titulo')</title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    {!! Html::style('css/materialize.min.css') !!}

    {!! Html::script('js/jquery.min.js') !!}
    {!! Html::script('js/materialize.min.js') !!}
    {!! Html::script('js/datatables.min.js') !!}
    {!! Html::script('js/jquery.validate.js') !!}
    {!! Html::script('js/Loader.js') !!}
    {!! Html::script('js/init.js') !!}

    @section('assets')
    @show
</head>
<body>
    @yield('header')
    <main class="section mainContent">
        <div id="cont">
            @yield('contenido')
        </div>
    </main>
    @yield('footer')
    @yield('script')
</body>
</html>