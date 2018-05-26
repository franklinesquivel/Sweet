@extends('layouts.public')
@section('titulo', 'Página de Inicio')

@section('assets')
    {!! Html::style('css/index.css') !!}
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
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
                <li class="active"><a href="{{ route('catalog') }}"><i class="material-icons right">shopping_cart</i> Catálogo de productos</a></li>
                <li><a href="{{ route('login') }}"><i class="material-icons right">person_pin</i> Iniciar Sesión</a></li>
                <li><a href="{{ route('register') }}"><i class="material-icons right">person_add</i> Registrarme</a></li>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="{{ route('home') }}"><i class="material-icons left">home</i> Inicio</a></li>
        <li class="active"><a href="{{ route('catalog') }}"><i class="material-icons left">shopping_cart</i> Catálogo de productos</a></li>
        <li><a href="{{ route('login') }}"><i class="material-icons left">person_pin</i> Iniciar Sesión</a></li>
        <li><a href="{{ route('register') }}"><i class="material-icons left">person_add</i> Registrarme</a></li>
    </ul>
@endsection

@section('contenido')
    <div class="section catalog-cont">
        <h4 class="grey-text text-darken-2 center">Productos</h4>
        <div id="contProducts" class="grid">
            @if(count($products) > 0)
            <div class="grid-sizer">
                @foreach($products as $p)
                <div class="grid-item">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="{{ Storage::url($p->images->count() > 0 ? $p->images->random()->image : 'public/products/default.png') }}">
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
            </div>
            @else
                <h5 class="center grey-text lighten-1">El producto no posee imágenes</h5>
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

@section('script')
    <script>
        $(document).ready(function(){
            if(document.querySelector('#contProducts') != null){
                imagesLoaded(contProducts, function(){
                    var elem = document.querySelector('.grid');
                    var msnry = new Masonry( elem, {
                        itemSelector: '.grid-item',
                        columnWidth: '.grid-sizer',
                        percentPosition: true
                    });
                });
            }
        });
    </script>
@endsection