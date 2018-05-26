@extends('layouts.admin')

@section('page-title', 'Ver producto')

@section('assets')
    @parent
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
@show

@section('contenido')

    @if(session()->has('msg'))
        <div class="alert {{ session()->get('msg_type')}} {{ session()->get('msg_type')}}-text lighten-3 text-darken-3 center">
            {{ session()->get('msg') }}
        </div>
    @endif

   

    <div class="section">
        <div class="btn-cont">
            <a href="{{ route('products.edit', $product->id) }}" class="btn grey darken-3"><i class="material-icons left">edit</i>Modificar</a>
            <a href="#mdlPhotos" class="modal-trigger btn grey darken-3"><i class="material-icons left">photo</i>Administrar imágenes</a>
            <a href="{{ route('products.index') }}" class="btn grey darken-3"><i class="material-icons left">remove_red_eye</i>Ver productos</a>
        </div>
        <br>
        <div class="btn-cont">
            <a href="#mdlConfirmDelete" class="btn red darken-1 waves-effect waves-light modal-trigger"><i class="material-icons left">delete</i> Eliminar producto</a>
        </div>

        <h4 class="grey-text text-darken-2 center">Información</h4>
        <h5><b>Nombre</b>: {{ $product->name }}</h5>
        <h5><b>Descripción</b>: {{ $product->description }}</h5>
        <h5><b>Precio</b>: ${{ $product->price }}</h5>
        <h5><b>Categoría</b>: {{ $product->category->name }}</h5>
    </div>

    <div class="section">
        <h4 class="grey-text text-darken-2 center">Imágenes</h4>
        <div id="contProducts" class="grid">
            @if(count($product->images) > 0)
            <div class="grid-sizer">
                @foreach($product->images as $i)
                <div class="grid-item">
                    <div class="card">
                        <div class="card-image">
                            <img src="{{ Storage::url($i->image) }}" class="materialboxed">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
                <h5 class="center grey-text lighten-1">El producto no posee imágenes</h5>
            @endif
        </div>
    </div>
      
    <div id="mdlPhotos" class="modal">
        <div class="modal-content">
            <h4 class="grey-text text-darken-2 center">Administrar imágenes</h4>
            {!! Form::open(['method' => 'DELETE', 'class' => 'row', 'name' => 'frmProductImages_delete', 'route' => ['products.images.destroy', $product->id]]) !!}
                <div class="input-field col s10 offset-s1 m8 offset-m2 {{ $errors->has('image_id') ? 'invalid' : '' }}">
                    <select class="icons" id="image_id" name="image_id[]" multiple>
                        @if(count($product->images) > 0)
                            {{ $c = 0 }}
                            @foreach($product->images as $i)
                                    <option value="{{ $i->id }}" data-icon="{{ Storage::url($i->image) }}">Imagen {{ ++$c }}</option>
                            @endforeach
                        @else
                            <option value="null" disabled>No hay imágenes asociadas a este producto</option>
                        @endif
                    </select>
                    <label for="image_id">Selecciona las imágenes que deseas eliminar</label> 
                    @if ($errors->has('image_id'))
                        <div id="Img_err"></div>
                        <span class="helper-text" data-error="{{ $errors->first('image_id') }}"></span>
                    @endif
                </div>
                <div class="col s12 btn-cont">
                    <div id="btnDeleteImg" class="btnAction btn grey darken-3 waves-effect waves-light"><i class="material-icons left">delete</i> Eliminar imágenes</div>
                </div>
            {!! Form::close() !!}
            <hr>
            {!! Form::open(['class' => 'row', 'name' => 'frmProductImages_add', 'route' => ['products.images.store', $product->id], 'enctype' => 'multipart/form-data']) !!}
                <div class="input-field file-field col s8 offset-s2">
                    <div class="btn grey darken-3">
                        <span><i class="material-icons">photo</i></span>
                        <input type="file" name="images[]" multiple>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path {{ $errors->has('images.*') ? 'invalid' : '' }}" type="text" placeholder="Ingresa una o varias imágenes">
                        
                        @if ($errors->has('images.*'))
                            <div id="Img_err"></div>
                            <span class="helper-text" data-error="{{ $errors->first('images.*') }}"></span>
                        @endif
                    </div>
                </div>
                <div class="col s12 btn-cont">
                    <button class="btnAction btn grey darken-3 waves-effect waves-light"><i class="material-icons left">add_photo_alternate</i> Añadir imágenes</button>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="mdlConfirm" class="modal">
        <div class="modal-content">
            <h4 class="grey-text text-darken-2 center">¿Estás seguro que quieres eliminar estas imágenes?</h4>
            <div class="btn-cont">
                <a id="btnConfirm" class="btn green waves-effect waves-light darken-1"><i class="material-icons left">check</i> Confirmar</a>
                <a id="btnCancel" class="btn red waves-effect waves-light darken-1"><i class="material-icons left">cancel</i> Cancelar</a>
            </div>
        </div>
    </div>

    <div id="mdlConfirmDelete" class="modal">
        <div class="modal-content">
            <h4 class="grey-text text-darken-2 center">¿Estás seguro que quieres eliminar este producto?</h4>
            <div class="btn-cont">
                <a id="btnConfirmDelete" class="btn green waves-effect waves-light darken-1"><i class="material-icons left">check</i> Confirmar</a>
                <a id="btnCancel" class="btn red waves-effect waves-light darken-1"><i class="material-icons left">cancel</i> Cancelar</a>
            </div>
        </div>
    </div>

    {!! Form::open(['name' => 'frmDelete', 'route' => ['products.destroy', $product->id], 'method' => 'DELETE']) !!}
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            if(document.querySelector('#contProducts') != null){
                imagesLoaded(contProducts, function(){
                    var elem = document.querySelector('.grid');
                    var msnry = new Masonry( elem, {
                        itemSelector: '.grid-item',
                        columnWidth: '.grid-sizer',
                        percentPosition: true
                    });
                });
            }

            if(document.querySelector('#Img_err') != null){
                $('#mdlPhotos').modal('open');
            }
            
            $(btnDeleteImg).click(function(){
                if(frmProductImages_delete.image_id.value == ""){
                    M.toast({html: '<b>Debes seleccionar por lo menos una imagen para eliminar!</b>', classes: 'red darken-1 white-text'});
                    $(this).removeAttr('disabled');
                }else{
                    let loader = new Loader();
                    loader.in();
                    $('#mdlPhotos').modal('close');
                    setTimeout(() => {
                        $('#mdlConfirm').modal('open');
                        loader.out();
                    }, 1000); 
                }
            })

            $("#btnConfirm").click(function(){
                frmProductImages_delete.submit();
            })
            
            $("#btnConfirmDelete").click(function(){
                frmDelete.submit();
            })
        });
    </script>
@endsection