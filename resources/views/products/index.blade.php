@extends('layouts.admin')

@section('page-title', 'Productos')

@section('contenido')

    @if(session()->has('msg'))
        <div class="alert {{ session()->get('msg_type')}} {{ session()->get('msg_type')}}-text lighten-3 text-darken-3 center">
            {{ session()->get('msg') }}
        </div>
    @endif

    
    @if(count($products) > 0)
        <table id="tblProducts" class="center">
            <thead>
                <th>idProducto</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </thead>
            <tbody>
            @foreach($products as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>${{ $p->price }}</td>
                    <td>{{ $p->status == 1 ? 'Activo' : 'De baja' }}</td>
                    <td>{{ $p->category->name }}</td>
                    <td>
                        <a class="btn grey darken-3 waves-effect waves-light" href="{{ route('products.show', $p->id) }}" title="Mostrar"><i class="material-icons">remove_red_eye</i></a>
                        <a class="btn grey darken-3 waves-effect waves-light" href="{{ route('products.edit', $p->id) }}" title="Modificar"><i class="material-icons">edit</i></a>
                        <a class="btn red darken-3 waves-effect waves-light btnInitDelete" idProduct="{{ $p->id }}" title="Eliminar"><i class="material-icons">delete</i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="center red red-text text-darken-4 lighten-4 alert">No hay productos registrados...</div>
    @endif

    <div class="section">
        <a href="{{ route('products.create') }}" class="btn grey darken-3 waves-effect waves-light"><i class="material-icons left">add</i> Añadir nuevo producto</a>
    </div>

    <div id="mdlConfirm" class="modal">
        <div class="modal-content">
            <h4 class="grey-text text-darken-2 center">¿Estás seguro que quieres eliminar este producto?</h4>
            <div class="section">
                <h6 class="center"><b>Nombre: </b><span id="product_name"></span></h6>
                <h6 class="center"><b>Descripción: </b><span id="product_description"></span></h6></div>
            <div class="btn-cont">
                <a id="btnConfirm" class="btnAction btn green waves-effect waves-light darken-1"><i class="material-icons left">check</i> Confirmar</a>
                <a id="btnCancel" class="btn red waves-effect waves-light darken-1"><i class="material-icons left">cancel</i> Cancelar</a>
            </div>
        </div>

        {!! Form::open(['name' => 'frmDelete', 'method' => 'DELETE', 'route' => ['products.destroy', null]]) !!}
            {!! Form::hidden('product_id') !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#tblProducts").DataTable({
                "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false
                }
            ],
            "order": [[ 1, "asc" ]]
            });

            $('.btnInitDelete').click(function(){
                let product_id = $(this).attr('idProduct'), loader = new Loader();
                loader.in();
                $.ajax({
                    url: `{{ route('products.json.get', null) }}/${product_id}`,
                    success: function(res, textStatus, xhr){
                        if(xhr.status === 200){
                            $('#mdlConfirm').modal('open');
                            $("#product_name").html(res.name);
                            $("#product_description").html(res.description);
                            frmDelete.product_id.value = res.id;
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

            $("#btnConfirm").click(function(){
                let product_id = frmDelete.product_id.value;
                if(product_id !== ""){
                    frmDelete.action = `{{ route('products.destroy', null) }}/${product_id}`;
                    frmDelete.submit();
                }else{
                    M.toast({html: `<b>Debes seleccionar un producto para eliminarlo <i class='material-icons right'>warning</i></b>`, classes: 'yellow darken-2'});
                    $('#mdlConfirm').modal('close');
                }
            });
        });
    </script>
@endsection