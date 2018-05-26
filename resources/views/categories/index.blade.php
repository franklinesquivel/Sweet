@extends('layouts.admin')

@section('page-title', 'Categorías')

@section('contenido')

    @if(session()->has('msg'))
        <div class="alert {{ session()->get('msg_type')}} {{ session()->get('msg_type')}}-text lighten-3 text-darken-3 center">
            {{ session()->get('msg') }}
        </div>
    @endif

    
    @if(count($categories) > 0)
        <table id="tblCategories" class="center">
            <thead>
                <th>idCategoria</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cantidad de productos asignados</th>
                <th>Acciones</th>
            </thead>
            <tbody>
            @foreach($categories as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->description }}</td>
                    <td>{{ count($c->products) }}</td>
                    <td>
                        <a class="btn grey darken-3 waves-effect waves-light btnInitEdit" title="Modificar" idCategory="{{ $c->id }}"><i class="material-icons">edit</i></a>
                        <a class="btn red darken-3 waves-effect waves-light btnInitDelete" {{count($c->products) > 0 ? 'disabled' : ''}} idCategory="{{ $c->id }}" title="Eliminar"><i class="material-icons">delete</i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="center red red-text text-darken-4 lighten-4 alert">No hay categorías registradas...</div>
    @endif

    <div class="section">
        <a href="{{ route('categories.create') }}" class="btn grey darken-3 waves-effect waves-light"><i class="material-icons left">add</i> Añadir nueva categoría</a>
    </div>

    <div id="mdlConfirm" class="modal">
        <div class="modal-content">
            <h4 class="grey-text text-darken-2 center">¿Estás seguro que quieres eliminar esta categoría?</h4>
            <div class="section">
                <h6 class="center"><b>Nombre: </b><span id="category_name"></span></h6>
                <h6 class="center"><b>Descripción: </b><span id="category_description"></span></h6></div>
            <div class="btn-cont">
                <a id="btnConfirm" class="btnAction btn green waves-effect waves-light darken-1"><i class="material-icons left">check</i> Confirmar</a>
                <a id="btnCancel" class="btn red waves-effect waves-light darken-1"><i class="material-icons left">cancel</i> Cancelar</a>
            </div>
        </div>

        {!! Form::open(['name' => 'frmDelete', 'method' => 'DELETE', 'route' => ['categories.destroy', null]]) !!}
            {!! Form::hidden('category_id') !!}
        {!! Form::close() !!}
    </div>

    <div id="mdlEditCategory" class="modal">
        <div class="modal-content row">
            <h4 class="center grey-text darken-2">Modificar categoría</h4><br>
            {!! Form::open(['name' => 'frmEdit', 'method' => 'PUT', 'route' => ['categories.update', null]]) !!}
                {!! Form::hidden('category_id') !!}
                <div class="input-field col s10 offset-s1 m8 offset-m2">
                {!! Form::text('name', null, ['class' => $errors->has('name') ? 'invalid' : '', 'id' => 'name']) !!}
                {!! Form::label('name', 'Nombre') !!}
                    @if ($errors->has('name'))
                        <div id="frm_err"></div>
                        <span class="helper-text" data-error="{{ $errors->first('name') }}"></span>
                    @endif
                </div>
                <div class="input-field col s10 offset-s1 m8 offset-m2">
                    {!! Form::textarea('description', null,  ['class' => ($errors->has('description') ? 'invalid' : '') . " materialize-textarea", 'id' => 'description']) !!}
                    {!! Form::label('description', 'Descripcion') !!}
                    @if ($errors->has('description'))
                        <div id="frm_err"></div>
                        <span class="helper-text" data-error="{{ $errors->first('description') }}"></span>
                    @endif
                </div>
                <div class="col s12 btn-cont">
                    <button class="btnAction btn grey darken-3 waves-effect waves-light"><i class="material-icons left">save</i> Guardar cambios</button>
                </div>
            {!! Form::close() !!}
        </div>

        
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#tblCategories").DataTable({
                "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false
                }
            ],
            "order": [[ 1, "asc" ], [3, "asc"]]
            });

            $('.btnInitDelete').click(function(){
                let category_id = $(this).attr('idCategory'), loader = new Loader();
                loader.in();
                $.ajax({
                    url: `{{ route('categories.json.get', null) }}/${category_id}`,
                    success: function(res, textStatus, xhr){
                        if(xhr.status === 200){
                            $('#mdlConfirm').modal('open');
                            $("#category_name").html(res.name);
                            $("#category_description").html(res.description);
                            frmDelete.category_id.value = res.id;
                        }else{
                            M.toast({html: `<b>Ha ocurrido un error al intentar comunicarse con el servidor! inténtalo más tarde...</b>`, classes: 'red darken-1'});
                        }
                    },
                    error: function(err, textStatus, xhr){
                        if(err.status === 404){
                            M.toast({html: `<b>${err.responseJSON.msg}</b>`, classes: 'yellow darken-2'});
                        }else{
                            M.toast({html: `<b>Ha ocurrido un error al intentar comunicarse con el servidor! inténtalo más tarde...</b>`, classes: 'red darken-1'});
                        }
                    }
                }).always(function(){
                    loader.out();
                })
            });

            $('.btnInitEdit').click(function(){
                let category_id = $(this).attr('idCategory'), loader = new Loader();
                loader.in();
                $.ajax({
                    url: `{{ route('categories.json.get', null) }}/${category_id}`,
                    success: function(res, textStatus, xhr){
                        if(xhr.status === 200){
                            $('#mdlEditCategory').modal('open');
                            frmEdit.category_id.value = res.id;
                            frmEdit.name.value = res.name;
                            frmEdit.description.value = res.description;
                            M.updateTextFields();
                        }else{
                            M.toast({html: `<b>Ha ocurrido un error al intentar comunicarse con el servidor! inténtalo más tarde...</b>`, classes: 'red darken-1'});
                        }
                    },
                    error: function(err, textStatus, xhr){
                        if(err.status === 404){
                            M.toast({html: `<b>${err.responseJSON.msg}</b>`, classes: 'yellow darken-2'});
                        }else{
                            M.toast({html: `<b>Ha ocurrido un error al intentar comunicarse con el servidor! inténtalo más tarde...</b>`, classes: 'red darken-1'});
                        }
                    }
                }).always(function(){
                    loader.out();
                })
            })

            $("#btnConfirm").click(function(){
                let category_id = frmDelete.category_id.value;
                if(category_id !== ""){
                    frmDelete.action = `{{ route('categories.destroy', null) }}/${category_id}`;
                    frmDelete.submit();
                }else{
                    M.toast({html: `<b>Debes seleccionar una categoría para eliminarla <i class='material-icons right'>warning</i></b>`, classes: 'yellow darken-2'});
                    $('#mdlConfirm').modal('close');
                }
            });

            if(document.querySelector('#frm_err') != null){
                $('#mdlEditCategory').modal('open');
            }

            $(frmEdit).submit(function(){
                let category_id = frmEdit.category_id.value;
                if(category_id !== ""){
                    frmEdit.action = `{{ route('categories.update', null) }}/${category_id}`;
                    frmEdit.submit();
                }else{
                    M.toast({html: `<b>Debes seleccionar una categoría para modificarla <i class='material-icons right'>warning</i></b>`, classes: 'yellow darken-2'});
                    $('#mdlEditCategory').modal('close');
                }
            });
        });
    </script>
@endsection