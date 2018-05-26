@extends('layouts.admin')

@section('page-title', 'Registro de producto')

@section('contenido')

    {!! Form::open(['class' => 'row', 'name' => 'frmProduct', 'route' => 'products.store', 'enctype' => 'multipart/form-data']) !!}
        
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
        <div class="input-field col s10 offset-s1 m8 offset-m2">
            {!! Form::text('price', null,  ['class' => $errors->has('price') ? 'invalid' : '', 'id' => 'price']) !!}
            {!! Form::label('price', 'Precio') !!}
            @if ($errors->has('price'))
                <span class="helper-text" data-error="{{ $errors->first('price') }}"></span>
            @endif
        </div>
        <div class="input-field col s10 offset-s1 m8 offset-m2 {{ $errors->has('category_id') ? 'invalid' : '' }}">
            {!! Form::select('category_id', count($categories) > 0 ? $categories : [-1 => 'No hay categorías registradas'], null, ['class' =>  $errors->has('category_id') ? 'invalid' : '']) !!}
            {!! Form::label('category_id', 'Categoría') !!}
            @if ($errors->has('category_id'))
                <span class="helper-text" data-error="{{ $errors->first('category_id') }}"></span>
            @endif
        </div>
        <div class="input-field file-field col s8 offset-s2">
            <div class="btn grey darken-3">
                <span><i class="material-icons left">photo</i> Imágenes (Opcional)</span>
                <input type="file" name="images[]" multiple>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path {{ $errors->has('images.*') ? 'invalid' : '' }}" type="text" placeholder="Ingresa una o varias imágenes">
                
                @if ($errors->has('images.*'))
                    <span class="helper-text" data-error="{{ $errors->first('images.*') }}"></span>
                @endif
            </div>
        </div>
        <div class="col s12 btn-cont">
            <button class="btnAction btn grey darken-3 waves-effect waves-light"><i class="material-icons left">add</i> Registrar producto</button>
        </div>

    {!! Form::close() !!}

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $(frmProduct).validate({
                rules: {
                    name: 'required',
                    description: 'required',
                    price: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    category_id: 'required'
                },
                messages: {
                    name: 'El nombre del producto es requerido',
                    description: 'La descripción del producto es requerida',
                    price: {
                        required: 'El precio del producto es requerido',
                        number: 'El precio del producto debe ser un valor numérico',
                        min: 'El precio del producto debe ser mayor que 0'
                    },
                    category_id: 'Seleccione un tipo de producto'
                }
            })
        });
    </script>
@endsection