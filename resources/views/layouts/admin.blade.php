@extends('layouts.master')
@section('titulo')
    [Administrador]
@endsection

@section('assets')
    {{ Html::style('css/main.css') }}
    {{ Html::style('css/admin.css') }}
@show

@section('header')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
    <header>
        <!--nav class="top-nav grey darken-4">
            <div class="container">
                <a href="#" data-target="user_nav" class="sidenav-trigger "><i class="material-icons">menu</i></a>
                <div class="nav-wrapper"><a class="page-title">@yield('page-title', 'Título')</a></div>
            </div>
        </nav-->

        <!-- <nav class="grey darken-4">
            <div class="container">
                <img class=""  width="50px" src="{{ asset('favicon.png')  }}">
                <ul id="nav-mobile" class="left hide-on-med-and-down">
                    <li><a href="sass.html">Sass</a></li>
                    <li><a href="badges.html">Components</a></li>
                    <li><a href="collapsible.html">JavaScript</a></li>
                </ul>
                <a href="#" data-target="user_nav" class="sidenav-trigger "><i class="material-icons">menu</i></a>
                <div class="nav-wrapper"><a class="brand-logo center">@yield('page-title', 'Administrador')</a></div>
            </div>
        </nav> -->

        
        <nav>
            <div class="nav-wrapper grey darken-3">
            <a class="brand-logo center">@yield('page-title', 'Administrador')</a>
            <a href="#" data-target="user_nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li>
                    <a class="btnLogout"><i class="material-icons right">exit_to_app</i>Cerrar Sesión</a>
                </li>
            </ul>
            </div>
        </nav>
        

        <ul id="user_nav" class="sidenav sidenav-fixed">
            <li id="user-data" class="grey darken-3">
                <a class="brand-logo main">
                    <img  width="40px" src="{{ asset('favicon.png')  }}">
                    <span>{{ env('APP_NAME') }}</span>
                </a>
                <div class="user-view">
                <a>
                    <span class="white-text name">{{ explode(' ', auth()->user()->name)[0] . ' ' . explode(' ', auth()->user()->lastname)[0]  }} &nbsp; <b>[{{ auth()->user()->userType->name }}]</b></span>
                </a>
                <a><span class="white-text email">{{ auth()->user()->email }}</span></a> 
                </div>
            </li>
            <li class="nav-item"><a href="{{ route('admin.index') }}"><i class="material-icons">home</i>Inicio</a></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header"><i class="material-icons">cake</i> Productos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{ route('products.index') }}"><i class="material-icons left">remove_red_eye</i>Ver productos</a></li>
                                <li><a href="{{ route('products.create') }}"><i class="material-icons left">add</i>Añadir producto</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header"><i class="material-icons">category</i> Categorías</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{ route('categories.index') }}"><i class="material-icons left">remove_red_eye</i>Ver categorías</a></li>
                                <li><a href="{{ route('categories.create') }}"><i class="material-icons left">add</i>Añadir categoría</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- <li>
                <a class="subheader">Opciones</a>
            </li> -->
            <li class="nav-item hide-on-med-and-up">
                <a class="btnLogout"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a>
            </li>
        </ul>
    </header>
@endsection

@section('contenido')
    @yield('contenido')
@endsection

@section('script')
    @yield('script')
@endsection
