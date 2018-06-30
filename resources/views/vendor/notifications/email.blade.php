@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# Hola!
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'teal';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Saludos, **{{ config('app.name') }}**
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
Sí estás teniendo problemas al clickear el botón de "{{ $actionText }}" , copia y pega la URL de abajo
en tu navegador web: [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
