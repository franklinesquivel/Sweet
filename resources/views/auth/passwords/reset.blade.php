@extends('layouts.public')
@section('titulo', 'Reestablecer contraseña')

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
<div class="container">
    <div class="row">
        <div class="col-md-8">
        <h2 class="center {{ config('app.colors.primary') }}-text text-darken-3">
            {{ config('app.name') }}
            <img height="40px" width="40px" src="{{ asset('favicon.png') }}">
        </h2>
        <h5 class="center grey-text text-darken-1">[Reestablecer contraseña]</h5>

            <div class="row">

                <div class="card-content">
                    <form id="form-reset" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="input-field col s10 offset-s1 m8 offset-m2">
                            {!! Form::email('email', null, ['class' => $errors->has('email') ? 'invalid' : '', 'id' => 'email']) !!}
                            {!! Form::label('email', 'Confirmar correo') !!}
                            @if ($errors->has('email'))
                                <span class="helper-text" data-error="{{ $errors->first('email') }}"></span>
                            @endif
                        </div>

                        <div class="input-field col s10 offset-s1 m8 offset-m2">
                            {!! Form::password('password', ['class' => $errors->has('password') ? 'invalid' : '', 'id' => 'password']) !!}
                            {!! Form::label('password', 'Nueva contraseña') !!}
                            @if ($errors->has('password'))
                                <span class="helper-text" data-error="{{ $errors->first('password') }}"></span>
                            @endif
                        </div>

                        <div class="input-field col s10 offset-s1 m8 offset-m2">
                            {!! Form::password('password_confirmation', ['class' => $errors->has('password_confirmation') ? 'invalid' : '', 'id' => 'password_confirmation']) !!}
                            {!! Form::label('password_confirmation', 'Confirmar contraseña') !!}
                            @if ($errors->has('password_confirmation'))
                                <span class="helper-text" data-error="{{ $errors->first('password_confirmation') }}"></span>
                            @endif
                        </div>

                        <div class="col s12 btn-cont">
                            <button type="submit" class="btn {{ config('app.colors.primary') }}">
                                Restaurar clave
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        
        $(document).ready(function(){
            $.validator.addMethod('email', function(value, element) {
                    return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
            }, 'Ingrese un correo válido.')

            $("#form-reset").validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password",
                    },
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    password: {
                        required: 'Debes ingresar una contraseña',
                        minlength: 'Ĺa longitud mínimo de la contraseña es de  6 carácteres'
                    },
                    password_confirmation: {
                        required: 'Debes ingresar una confirmación de contraseña',
                        equalTo: 'El valor ingresado debe ser igual a la nueva contraseña ingresada'
                    },
                    email: {
                        required: 'Debe ingresar un correo electrónico',
                    }
                }
            });
        });
    
    </script>
@endsection