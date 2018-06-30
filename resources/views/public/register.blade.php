@extends('layouts.public')
@section('titulo', 'Registro')

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
                <li class="active"><a href="{{ route('register') }}"><i class="material-icons right">person_add</i> Registrarme</a></li>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="{{ route('home') }}"><i class="material-icons left">home</i> Inicio</a></li>
        <li><a href="{{ route('catalog') }}"><i class="material-icons left">shopping_cart</i> Catálogo de productos</a></li>
        <li><a href="{{ route('login') }}"><i class="material-icons left">person_pin</i> Iniciar Sesión</a></li>
        <li class="active"><a href="{{ route('register') }}"><i class="material-icons left">person_add</i> Registrarme</a></li>
    </ul>
@endsection

@section('contenido')
    @if(session()->has('msg'))
        <div class="alert {{ session()->get('msg_type')}} {{ session()->get('msg_type')}}-text lighten-3 text-darken-3 center">
            {{ session()->get('msg') }}
        </div>
    @endif

    <div class="frmBody">
        <h2 class="center {{ env('PRIMARY_COLOR') }}-text text-darken-3">
            {{ env('APP_NAME') }}
            <img height="40px" width="40px" src="{{ asset('favicon.png') }}">
        </h2>
        <h5 class="center grey-text text-darken-1">[Registro]</h5>
        <div class="row">
            {!! Form::open(['name' => 'frm_usuario', 'class' => 'col l8 offset-l2', 'route' => 'register']) !!}
                <div class="row">
                    <div class="input-field col l6 s12">
                        {!! Form::text('name', null, ['class' => $errors->has('name') ? 'invalid' : '', 'id' => 'name']) !!}
                        {!! Form::label('name', 'Nombre') !!}
                        @if ($errors->has('name'))
                            <span class="helper-text" data-error="{{ $errors->first('name') }}"></span>
                        @endif
                    </div>

                    <div class="input-field col l6 s12">
                        {!! Form::text('lastname', null, ['class' => $errors->has('lastname') ? 'invalid' : '', 'id' => 'lastname']) !!}
                        {!! Form::label('lastname', 'Apellido') !!}
                        @if ($errors->has('lastname'))
                            <span class="helper-text" data-error="{{ $errors->first('lastname') }}"></span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 s12">
                        {!! Form::text('dui', null, ['class' => $errors->has('dui') ? 'invalid' : '', 'id' => 'dui']) !!}
                        {!! Form::label('dui', 'DUI') !!}
                        @if ($errors->has('dui'))
                            <span class="helper-text" data-error="{{ $errors->first('dui') }}"></span>
                        @endif
                    </div>
                    <div class="input-field col l6 s12">
                        {!! Form::text('birthdate', null, ['class' => ($errors->has('birthdate') ? 'invalid' : '') . " datepicker", 'id' => 'birthdate']) !!}
                        {!! Form::label('birthdate', 'Fecha de nacimiento') !!}
                        @if ($errors->has('birthdate'))
                            <span class="helper-text" data-error="{{ $errors->first('birthdate') }}"></span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 s12">
                        {!! Form::email('email', null, ['class' => $errors->has('email') ? 'invalid' : '', 'id' => 'email']) !!}
                        {!! Form::label('email', 'Correo electrónico') !!}
                        @if ($errors->has('email'))
                            <span class="helper-text" data-error="{{ $errors->first('email') }}"></span>
                        @endif
                    </div>
                    <div class="input-field col l6 s12">
                        {!! Form::text('phone', null, ['class' => $errors->has('phone') ? 'invalid' : '', 'id' => 'phone']) !!}
                        {!! Form::label('phone', 'Número de teléfono') !!}
                        @if ($errors->has('phone'))
                            <span class="helper-text" data-error="{{ $errors->first('phone') }}"></span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        {!! Form::textarea('address', null, ['class' => ($errors->has('address') ? 'invalid' : '') . " materialize-textarea", 'id' => 'address']) !!}
                        {!! Form::label('address', 'Dirección') !!}
                        @if ($errors->has('address'))
                            <span class="helper-text" data-error="{{ $errors->first('address') }}"></span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 btn-cont">
                    <button type="submit" class="btn waves-effect waves-light {{ env('PRIMARY_COLOR')  }}">
                        Registrarme
                    </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        $(document).ready(function(){

            $.validator.addMethod('dui', function(value, element) {
                return this.optional(element) || /^\d{8}-\d$/.test(value);
            }, 'Ingrese un DUI válido.');

            $.validator.addMethod('email', function(value, element) {
                return this.optional(element) ||/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(value);
            }, 'Ingrese un correo válido.');
        
            $.validator.addMethod('phone', function(value, element) {
                return this.optional(element) || /^[267]\d{3}[- ]?\d{4}$/.test(value);
            }, 'Ingrese un valor válido. [2|6|7]xxx-xxxx');

            $.validator.addMethod('validDate', function(value, element) {
                let actualDate = new Date(), birthdate = new Date(value);
                return this.optional(element) || (Math.abs(actualDate.getFullYear() - birthdate.getFullYear() >= 18));
            }, 'Ingrese una fecha válida (18 años).');
            
            $('.frm_usuario').validate({
                rules: {
                    name: {
                        required: true
                    },
                    lastname: {
                        required: true
                    },
                    dui: {
                        required: true,
                        dui: true
                    },
                    birthdate:{
                        required: true,
                        validDate: true
                    },
                    email:{
                        required: true,
                        email: true
                    },
                    phone:{
                        required: true,
                        phone: true
                    },
                    address: {
                        required: true
                    }
                },
                messages:{
                    name: {
                        required: 'Nombre es obligatorio'
                    },
                    lastname: {
                        required: 'Apellido es obligatorio'
                    },
                    dui: {
                        required: 'DUI es obligatorio'
                    },
                    birthdate:{
                        required: 'Fecha de Nacimiento es obligatoria'
                    },
                    email:{
                        required: 'Correo es obligatorio'
                    },
                    phone:{
                        required: 'Telefono es obligatorio'
                    },
                    address: {
                        required: 'Dirección es obligatoria'
                    }
                }
            });
        });
    </script>
@endsection

@section('assets')
    {!! Html::style('css/register.css') !!}
@show