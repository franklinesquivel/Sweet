@component('mail::message')
# Bienvenido a {{ config('app.name') }}

El usuario **{{ $user->name . " " . $user->lastname }}** ha sido registrado éxitosamente a la plataforma como **{{ $user->userType->name }}**!

Ahora puedes disfrutar de todas las funcionalidades que ofrecemos! Te adjuntamos la contraseña de tu nueva cuenta para que puedas acceder:

@component('mail::panel', ['class' => 'center'])
{{ $password }}
@endcomponent

@component('mail::button', ['url' => env('APP_URL') . '/login', 'class' => 'btn ' . env('PRIMARY_COLOR')])
    Iniciar sesión
@endcomponent

Gracias por formar parte de nuestra familia, **{{ config('app.name') }}**
@endcomponent
