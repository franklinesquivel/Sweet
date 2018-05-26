@extends('layouts.public')
@section('titulo', 'Página de Inicio')

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
                <li class="active"><a href="{{ route('home') }}"><i class="material-icons right">home</i> Inicio</a></li>
                <li><a href="{{ route('catalog') }}"><i class="material-icons right">shopping_cart</i> Catálogo de productos</a></li>
                <li><a href="{{ route('login') }}"><i class="material-icons right">person_pin</i> Iniciar Sesión</a></li>
                <li><a href="{{ route('register') }}"><i class="material-icons right">person_add</i> Registrarme</a></li>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
        <li class="active"><a href="{{ route('home') }}"><i class="material-icons left">home</i> Inicio</a></li>
        <li><a href="{{ route('catalog') }}"><i class="material-icons left">shopping_cart</i> Catálogo de productos</a></li>
        <li><a href="{{ route('login') }}"><i class="material-icons left">person_pin</i> Iniciar Sesión</a></li>
        <li><a href="{{ route('register') }}"><i class="material-icons left">person_add</i> Registrarme</a></li>
    </ul>

    <div class="slider">
        <ul class="slides">
            <li>
                <img src="{{ Storage::url('public/home_1.jpg') }}">
                <div class="caption center-align">
                    <h3>This is our big Tagline!</h3>
                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>
            <li>
                <img src="{{ Storage::url('public/home_2.jpg') }}">
                <div class="caption left-align">
                    <h3>Left Aligned Caption</h3>
                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>
            <li>
                <img src="{{ Storage::url('public/home_3.jpg') }}">
                <div class="caption right-align">
                    <h3>Right Aligned Caption</h3>
                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>
        </ul>
    </div>
@endsection

@section('contenido')
    <div class="section row {{ env('PRIMARY_COLOR') }}">
        <h3 class="white-text center">Lorem</h3>
        <p class="col s10 offset-s1 justify white-text text-darken-3">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt quia consequatur expedita molestiae assumenda excepturi est cum repudiandae? Tenetur repellendus fugit vel! Explicabo pariatur, laboriosam accusamus soluta quod nostrum dignissimos!
        </p>
        <div class="btn-cont col s12">
            <a href="{{ route('catalog') }}" class="btn btn-large waves-effect wave-light secondary"><i class="material-icons right">books</i>Échale un vistazo a nuestros productos!</a>
        </div>
    </div>
    <div class="row">
        <div class="col s8 offset-s2">
            <div class="col s12 m4">
                <div class="center promo promo-example">
                    <i class="material-icons">flash_on</i>
                    <p class="promo-caption">Speeds up development</p>
                    <p class="light center">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components.</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="center promo promo-example">
                    <i class="material-icons">flash_on</i>
                    <p class="promo-caption">Speeds up development</p>
                    <p class="light center">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components.</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="center promo promo-example">
                    <i class="material-icons">flash_on</i>
                    <p class="promo-caption">Speeds up development</p>
                    <p class="light center">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="section row {{ env('PRIMARY_COLOR') }}">
        <h3 class="white-text center">Productos nuevos</h3>
        <div class="col s10 offset-s1">
            @if(count($products) > 0)
                @foreach($products as $p)
                <div class="card-cont  col s12 m4">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="{{ Storage::url($p->images->random()->image) }}">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4"><b>{{ $p->name }}</b><i class="material-icons right">more_vert</i></span>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4"><b>{{ $p->name }}</b><i class="material-icons right">close</i></span>
                            <p><b>Precio:</b> ${{ $p->price }}</p>
                            <p><b>Descripción:</b> {{ $p->description }}</p>
                        </div> 
                    </div>
                </div>
                @endforeach
            @else
                <div class="red lighten-4 red-text text-darken-4 alert center">
                    No hay productos registrados en la plataforma <i class="material-icons" style="margin-left: 2%;">not_interested</i>
                </div>
            @endif
        </div>
    </div>
    
@endsection

@section('footer')
    <footer class="page-footer {{ env('PRIMARY_COLOR') }}">
        <div class="footer-copyright">
          <div class="container center-align white-text">
            © 2018 Copyright {{ config('app.name') }}
          </div>
        </div>
    </footer>
@endsection