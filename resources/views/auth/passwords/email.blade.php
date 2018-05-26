@extends('layouts.public')
@section('titulo', 'Recuperar contraseña')

@section('assets')
    {!! Html::style('css/index.css') !!}
@show

@section('header')
    <nav class="{{ env('PRIMARY_COLOR') }}">
        <div class="nav-wrapper">
            <a class="brand-logo main">
                <img height="40px" width="40px" src="{{ asset('favicon.png') }}">
                {{ config('app.name') }}
            </a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down" id="opc">    
                <li><a href="{{ route('home') }}"><i class="material-icons right">home</i> Inicio</a></li>
                <li><a href="{{ route('catalog') }}"><i class="material-icons right">shopping_cart</i> Catálogo de productos</a></li>
                <li><a href="{{ route('login') }}"><i class="material-icons right">person_pin</i> Iniciar Sesión</a></li>
                <li><a href="{{ route('register') }}"><i class="material-icons right">person_add</i> Registrarme</a></li>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="{{ route('home') }}"><i class="material-icons left">home</i> Inicio</a></li>
        <li><a href="{{ route('catalog') }}"><i class="material-icons left">shopping_cart</i> Catálogo de productos</a></li>
        <li><a href="{{ route('login') }}"><i class="material-icons left">person_pin</i> Iniciar Sesión</a></li>
        <li><a href="{{ route('register') }}"><i class="material-icons left">person_add</i> Registrarme</a></li>
    </ul>
@endsection

@section('contenido')
    <div class="row">
        <h2 class="center {{ env('PRIMARY_COLOR') }}-text text-darken-3">
            {{ env('APP_NAME') }}
            <img height="40px" width="40px" src="{{ asset('favicon.png') }}">
        </h2>
        <h5 class="center grey-text text-darken-1">[Recuperar contraseña]</h5>

        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="input-field col m6 offset-m3 s10 offset-s1 {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" class="" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="error-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="col s12 btn-cont">
                    <button type="submit" class="btn {{ env('primary_color')  }} darken-3 waves-effect">
                        Enviar link para recuperar la contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
