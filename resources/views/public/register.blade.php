@extends('layouts.public')
@section('titulo', 'Registro')

@section('assets')
    {!! Html::style('css/login.css') !!}
@show

@section('header')
    <nav>
        <div class="nav-wrapper {{ env('primary_color')  }} darken-3">
            <a href="{{ url('/') }}" class="brand-logo">
                <img height="40px" width="40px" src="{{ asset('favicon.png') }}">
                {{ config('app.name') }}
            </a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="{{ url('/') }}">Inicio</a></li>
                <li><a href="{{ url('login') }}">Iniciar Sesión</a></li>
            </ul>
        </div>
    </nav>
@endsection

@section('contenido')
    <div class="frmBody">
        <h2 class="center {{ env('PRIMARY_COLOR') }}-text text-darken-3">
            {{ env('APP_NAME') }}
            <img height="40px" width="40px" src="{{ asset('favicon.png') }}">
        </h2>
        <h5 class="center grey-text text-darken-1">[Registro]</h5>
        <div class="row">
            <form method="POST" class="col l8 offset-l2" id="frm_usuario" action="{{ url('register') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col l6 s12 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Nombre</label>
                        <input id="name" class="" name="name" type="text" required autofocus>
                        @if ($errors->has('name'))
                            <span class="error-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="input-field col l6 s12 {{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <label for="lastname">Apellido</label>
                        <input id="lastname" type="text" class="" name="lastname" required>

                        @if ($errors->has('lastname'))
                            <span class="error-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 s12 {{ $errors->has('dui') ? ' has-error' : '' }}">
                        <label for="dui">DUI</label>
                        <input id="dui" type="text" class="" name="dui" required>

                        @if ($errors->has('dui'))
                            <span class="error-block">
                            <strong>{{ $errors->first('dui') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="input-field col l6 s12 {{ $errors->has('birthdate') ? ' has-error' : '' }}">
                        <label for="birthdate">Fecha de Nacimiento</label>
                        <input type="text" name="birthdate" id="birthdate" class="datepicker" >
                        @if ($errors->has('bithdate'))
                            <span class="error-block">
                            <strong>{{ $errors->first('birthdate') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 s12 {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Correo Electrónico</label>
                        <input id="email" class="" type="email" name="email" required>

                        @if ($errors->has('email'))
                            <span class="error-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="input-field col l6 s12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone">Teléfono</label>
                        <input id="phone" class="" type="text" name="phone" required>

                        @if ($errors->has('phone'))
                            <span class="error-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 {{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="address">Dirección</label>
                        <textarea id="address" name="address" class="materialize-textarea"></textarea>
                        @if ($errors->has('address'))
                            <span class="error-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="col s12 submitBtns center-align">
                    <button type="submit" class="btn waves-effect waves-light {{ env('PRIMARY_COLOR')  }}">
                        Registrarme
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            function serialize_json(serial){
                let json = {};

                serial.split("&").forEach(function(datos){
                    var item = datos.split("=");
                    json[item[0]] = item[1];
                });

                return json;
            }

            function serializeArray_json(serial){
                let json = {};

                for (let i = 0; i < serial.length; i++) {
                    const element = serial[i];
                    json[element.name] = element.value;
                }

                return json;
            }

            // $('.datepicker').datepicker({
            //     selectMonths: true,
            //     selectYears: 200,
            //     format: 'yyyy-mm-dd',
            //     maxDate: new Date()
            // });

            // $.validator.setDefaults({
            //     errorClass: 'invalid',
            //     validClass: 'none',
            //     errorPlacement: function(error, element) {
            //         $(element).parent().find('span.helper-text').remove();
            //         $(element).parent()
            //             .append(`<span class='helper-text' data-error='${error.text()}'></span>`);
            //     }
            // });

            $.validator.addMethod('validDui', function(value, element) {
                return this.optional(element) || /^\d{8}-\d$/.test(value);
            }, 'Ingrese un DUI válido.');

            $.validator.addMethod('validEmail', function(value, element) {
                return this.optional(element) ||/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(value);
            }, 'Ingrese un correo válido.');
        
            $.validator.addMethod('validNum', function(value, element) {
                return this.optional(element) || /^[267]\d{3}[- ]?\d{4}$/.test(value);
            }, 'Ingrese un valor válido.');

            $.validator.addMethod('validDate', function(value, element) {
                let actualDate = new Date(), birthdate = new Date(value);
                return this.optional(element) || (Math.abs(actualDate.getFullYear() - birthdate.getFullYear() >= 18));
            }, 'Ingrese una fecha válida (18 años).');
            
            $('#frm_usuario').validate({
                rules: {
                    name: {
                        required: true
                    },
                    lastname: {
                        required: true
                    },
                    dui: {
                        required: true,
                        validDui: true
                    },
                    birthdate:{
                        required: true,
                        validDate: true
                    },
                    email:{
                        required: true,
                        validEmail: true
                    },
                    phone:{
                        required: true,
                        validNum: true
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
                },
                submitHandler: function(_form) {
                    //form.preventDefault();
                    var formdata = serializeArray_json($(_form).serializeArray()); // here $(this) refere to the form its submitting

                    let loader = new Loader();
                    loader.in();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: $("#frm_usuario").attr('action'),
                        data: formdata,
                        success: function (res) {
                            if (res.success) {
                                M.toast({html: res.msg, classes: 'rounded', completeCallback: function(){location.href = `${location.origin}/login`}});
                            } else {
                                loader.out();

                                if(typeof res.errors !== 'undefined'){
                                    $.each(res.errors, function(key, value){
                                        M.toast({html: value, classes: 'rounded red darken-1' });
                                    });
                                }else if(typeof res.msg !== 'undefined'){
                                    M.toast({html: res.msg, classes: 'rounded red darken-1' });
                                }else{
                                    M.toast({html: 'Ha ocurrido un error!', classes: 'rounded red darken-1' });
                                }
                            }
                        },
                        error : function ( jqXhr, json, errorThrown )
                        {
                            loader.out();
                            var errors = jqXhr.responseJSON;
                            var errorsHtml= '';
                            $.each( errors, function( key, value ) {
                                errorsHtml += '<li>' + value[0] + '</li>';
                            });

                            M.toast({classes: 'red darken-2',html:  "Error: " + jqXhr.status +': '+ errorThrown + ' ' + JSON.stringify(json)});
                        }
                    });
                }
            });

            // $("#frm_usuario").submit(function(stay){
            //     stay.preventDefault(); 

            // });
        });
    </script>
@endsection

@section('assets')
    {!! Html::style('css/register.css') !!}
@show