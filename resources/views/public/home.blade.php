@extends('layouts.public')
@section('titulo', 'Página de Inicio')

@section('assets')
    {!! Html::style('css/index.css') !!}
@show

@section('header')
    <nav class="{{ config('app.colors.primary') }}">
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
                <img src="{{ Storage::url('public/slide1.jpg') }}">
                <div class="caption left-align">
                    <h3 class="white-text {{ config('app.colors.primary') }} lighten-1 center" style="padding: 5px;">
                        Micro empresa comercial “Sanncheff Bakery” es una micro empresa comercial que elabora y comercializa repostería, panadería con una gran
                        variedad de combinaciones, donde cuenta con personal encargado en brindar buen servicio al cliente. 
                    </h3>
                </div>
            </li>
            <li>
                <img src="{{ Storage::url('public/slide2.jpg') }}">
                <div class="caption center-align">
                    <h2 class="{{ config('app.colors.primary') }}-text grey lighten-5 center" style="padding: 5px;">"Sí somos lo que comemos, somos toda una delicia”</h2>
                </div>
            </li>
            <li>
                <img src="{{ Storage::url('public/slide3.jpg') }}">
            </li>
        </ul>
    </div>
@endsection

@section('contenido')
    <div class="section row">
        <h3 class="{{ config('app.colors.primary') }}-text center">Productos nuevos</h3>
        <p class="col s10 offset-s1 center text-darken-3">
            Ofrecemos una gran variedad de productos como Pastelería y Panadería.
        </p>
        <div class="btn-cont col s12">
            <a href="{{ route('catalog') }}" class="btn btn-large waves-effect wave-light {{ config('app.colors.primary') }}"><i class="material-icons right">books</i>Échale un vistazo a todos nuestros productos!</a>
        </div>
    </div>
    <div class="section row {{ config('app.colors.primary') }}" style="padding-top: 20px; padding-bottom: 20px;">
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
                <div class="section red lighten-4 red-text text-darken-4 alert center">
                    No hay productos registrados en la plataforma <i class="material-icons" style="margin-left: 2%;">not_interested</i>
                </div>
            @endif
        </div>
    </div>
    <div class="section row">
        <h2 class="center {{ config('app.colors.primary') }}-text">Mision</h2>
        <p class="col s10 offset-s1 justify">
            Somos una microempresa que elabora y comercializa productos de panadería, pastelería, comprometida a la originalidad de nuestros productos
            utilizando materia prima de calidad, que cumplan los requerimientos de los clientes, así logrando un servicio único y de excelencia. 
        </p>
    </div>
    <div class="section row {{ config('app.colors.primary') }}">
        <h3 class="white-text center">Visión</h3>
        <p class="col s10 offset-s1 justify white-text text-darken-3">
            Ser una microempresa líder a nivel nacional en el área de panadería y pastelería, ofreciendo una variedad de presentaciones de alta calidad,
            que contribuya la expectativa de nuestros clientes. Garantizando la utilización de nuevas tecnologías, procedimientos amigables con el personal y
            el medio ambiente, respaldado por un recurso humano calificado y comprometidos con los valores de la microempresa.
        </p>
    </div>
    <div class="row">
        <h2 class="center {{ config('app.colors.primary') }}-text">Valores</h2>
        <div class="row">
            <div class="col s8 offset-s2">
                <div class="col s12 m4">
                    <div class="center promo promo-example">
                        <p class="promo-caption">Innovación</p>
                        <p class="light center">
                            Fomentar la generación de ideas originales y creativas, mediante la participación del cliente cuya aplicación genere cambios sustanciales y exitoso. 
                        </p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="center promo promo-example">
                        <p class="promo-caption">Trabajo en Equipo</p>
                        <p class="light center">
                            Ayudará a tomar decisiones consensuadas y oportunas.
                        </p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="center promo promo-example">
                        <p class="promo-caption">Honestidad</p>
                        <p class="light center">
                            Garantizar la calidad de los productos, que se ofrecerá al cliente.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s8 offset-s2">
                <div class="col s12 m4">
                    <div class="center promo promo-example">
                        <p class="promo-caption">Servicio al Cliente</p>
                        <p class="light center">
                            Servir con un firme compromiso canalizando los esfuerzos con el fin de asegurar la lealtad de los consumidores.
                        </p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="center promo promo-example">
                        <p class="promo-caption">Respeto</p>
                        <p class="light center">
                            Reconocemos y apreciamos de manera integral el valor de la persona con equidad y justicia, a través de un ambiente de armonía, libertad de opinión e igualdad de oportunidades. 
                        </p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="center promo promo-example">
                        <p class="promo-caption">Confianza</p>
                        <p class="light center">
                            Realizando nuestras labores de la mejor manera, buscamos satisfacer a cada uno de nuestros clientes prestándoles un servicio cómodo y puntual. 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="parallax-container flex justify-center align-center">
        <div class="parallax"><img src="{{ Storage::url('public/parallax.png') }}"></div>
        <div class="caption center-align">
            <h4 class="white-text" style="font-style: italic; font-weight: bold">
                “Sanncheff Bakery” inicio esta idea comenzó desde Agosto del año 2017 con la idea de un negocio familiar, teniendo en cuenta que la creadora de la
                idea es chef; igualmente con el apoyo de su familia estando de acuerdo con el negocio y así es como nace esta idea innovadora de repostería.
            </h4>
        </div>
    </div>
    <div class="section">
        <h2 class="center {{ config('app.colors.primary') }}-text">Direccion y Contacto</h2>
        <div class="flex justify-center align-center" style="flex-direction: column">
            <p class="col s10 offset-s1 justify">
                Calle al volcán, res. INDEP edif. 0-16 apto 14, Mejicanos
            </p>
            <ul>
                <li><b>Tel Fijo Empresa:</b> 2519-4230</li>
                <li><b>WhatsApp:</b> 7686-0391 y 7474-7719</li>
                <li><b>Correo electrónico:</b> emassv@yahoo.com</li>
            </ul>
        </div>
    </div>
    
@endsection

@section('footer')
    <footer class="page-footer {{ config('app.colors.primary') }}">
        <div class="footer-copyright">
          <div class="container center-align white-text">
            © 2018 Copyright {{ config('app.name') }}
          </div>
        </div>
    </footer>
@endsection