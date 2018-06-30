@extends('layouts.public')
@section('titulo', 'Login')

@section('header')
    <div class="back">
        <img src="{{ asset('img/login_wall.jpg') }}">
    </div>
@endsection

@section('assets')
    {!! Html::style('css/login.css') !!}
@show

@section('contenido')
        <div class="front">
            <div class="frmBody">
                <h2 class="center {{ env('PRIMARY_COLOR') }}-text text-darken-3">
                    {{ env('APP_NAME') }}
                    <img height="40px" width="40px" src="{{ asset('favicon.png') }}">
                </h2>
                <h5 class="center grey-text text-darken-1">[Iniciar Sesión]</h5>

                @if(session()->has('msg'))
                    <div class="alert {{ session()->get('msg_type')}} {{ session()->get('msg_type')}}-text lighten-3 text-darken-3 center">
                        {{ session()->get('msg') }}
                    </div>
                @endif

                <form method="POST" class="row" id="frmLogin" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="input-field col s12 {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Correo Electrónico</label>
                        <input id="email" type="email" class="" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="error-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="input-field col s12 {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" class="" name="password" required>

                        @if ($errors->has('password'))
                            <span class="error-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="col s12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="filled-in" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span>Recuérdame</span>
                            </label>
                        </div>
                    </div>

                    <div class="col s12 submitBtns">
                        <button type="submit" class="btn waves-effect waves-light {{ env('PRIMARY_COLOR')  }}">
                            Iniciar Sesión
                        </button>

                        <a class="btn-flat {{ env('PRIMARY_COLOR')  }}-text waves-effect waves-light" href="{{ route('password.request') }}">
                            He olvidado mi contraseña
                        </a>
                    </div>
                </form>
            </div>
        </div>
@endsection