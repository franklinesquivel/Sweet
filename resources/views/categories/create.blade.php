@extends('layouts.admin')

@section('page-title', 'Registro de categoría')

@section('contenido')

    {!! Form::open(['class' => 'row', 'name' => 'frmCategory', 'route' => 'categories.store']) !!}
        
        <div class="input-field col s10 offset-s1 m8 offset-m2">
            {!! Form::text('name', null, ['class' => $errors->has('name') ? 'invalid' : '', 'id' => 'name']) !!}
            {!! Form::label('name', 'Nombre') !!}
            @if ($errors->has('name'))
                <span class="helper-text" data-error="{{ $errors->first('name') }}"></span>
            @endif
        </div>
        <div class="input-field col s10 offset-s1 m8 offset-m2">
            {!! Form::textarea('description', null,  ['class' => ($errors->has('description') ? 'invalid' : '') . " materialize-textarea", 'id' => 'description']) !!}
            {!! Form::label('description', 'Descripcion') !!}
            @if ($errors->has('description'))
                <span class="helper-text" data-error="{{ $errors->first('description') }}"></span>
            @endif
        </div>
        <div class="col s12 btn-cont">
            <button type="submit" class="btnAction btn grey darken-3 waves-effect waves-light"><i class="material-icons left">add</i> Registrar categoría</button>
        </div>

    {!! Form::close() !!}

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $(frmProduct).validate({
                rules: {
                    name: 'required',
                    description: 'required'
                },
                messages: {
                    name: 'El nombre del producto es requerido',
                    description: 'La descripción del producto es requerida'
                },
                invalidHandler: function(form) {
                    $('.btnAction').removeAttr('disabled');
                },
                submitHandler: function(form) {
                    $(form).submit();
                }
            })
        });
    </script>
@endsection