<?php

namespace Sweet\Http\Controllers;

use Illuminate\Http\Request;
use Sweet\Product;
use Sweet\Category;
use Sweet\Image;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $aux = [];

        foreach($categories as $t){
            $aux[$t->id] = $t->name;
        }

        $categories = $aux;
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [ //Español
            'name.required' => 'El nombre del producto es requerido',
            'name.max' => 'El nombre del producto sobrepasa la longitud permitida (80)',
            'name.unique' => 'El nombre que desea ingresar ya existe',
            
            'description.required' => 'La descripción del producto es requerida',
            
            'price.required' => 'El precio del producto es requerido',
            'price.numeric' => 'El precio del producto debe ser un valor numérico',
            'price.min' => 'El precio del producto debe ser mayor que 0',
            
            'category_id.required' => 'Seleccione una categoría',

            'images.*.image' => 'Todos los archivos seleccionados deben ser imágenes',
            'images.*.mimes' => 'Todos los archivos seleccionados deben ser imágenes',
            'images.*.max' => 'Todos los archivos debes ser menores de 4048Kb'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products|max:80',
            'description' => 'required',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048'
        ], $message);

        if($validator->fails() || is_null(Category::find($request->input('category_id')))){
            if(is_null(Category::find($request->input('category_id')))){
                $validator->errors()->add('category_id', 'La categoría que deseas asignar no existe!');
            }

            return redirect()->route('products.create')->withErrors($validator)->withInput();
        }
        
        try{
            DB::beginTransaction();

            $product = new Product([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'category_id' => $request->input('category_id')
            ]);

            if($product->save()){
                if($request->hasFile('images')){
                    try{
                        foreach($request->file('images') as $item){
                            $image = new Image([
                                'image' => $item->store('public/products')
                            ]);
                            
                            Product::find($product->id)->images()->save($image);
                        }
                    }catch(Exception $e){
                        DB::rollBack();
                    }
                    
                }

                DB::commit();
                return redirect()->route('products.index')->with([
                    'msg' => 'El producto ha sido registrado éxitosamente',
                    'msg_type' => 'green'
                ]);
            }else{
                DB::rollBack();
                return redirect()->route('products.store')->with([
                    'msg' => 'Ha ocurrido un error al intentar guardar el producto!',
                    'msg_type' => 'red'
                ]);
            }
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('products.store')->with([
                'msg' => 'Ha ocurrido un error al intentar guardar el producto!',
                'msg_type' => 'red'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if(is_null($product)){
            return redirect()->route('products.index')->with([
                'msg' => 'El producto al que desea acceder no existe',
                'msg_type' => 'yellow'
            ]);
        }else{
            return view('products.show', compact('product'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        if(is_null($product)){
            return redirect()->route('products.index')->with([
                'msg' => 'El producto al que desea acceder no existe',
                'msg_type' => 'yellow'
            ]);
        }else{
            $categories = Category::all();
            $aux = [];

            foreach($categories as $t){
                $aux[$t->id] = $t->name;
            }

            $categories = $aux;
            return view('products.edit', compact(['product', 'categories']));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            DB::beginTransaction();

            $product = Product::find($id);

            if(is_null($product)){
                return redirect()->route('products.index')->with([
                    'msg' => 'El producto al que desea acceder no existe',
                    'msg_type' => 'yellow'
                ]);
            }
            
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->category_id = $request->input('category_id');

            if($product->save()){
                DB::commit();
                return redirect()->route('products.show', $product->id)->with([
                    'msg' => 'El producto ha sido modificado éxitosamente',
                    'msg_type' => 'green'
                ]);
            }else{
                DB::rollBack();
                return redirect()->route('products.edit', $product->id)->with([
                    'msg' => 'Ha ocurrido un error al intentar modificar el producto!',
                    'msg_type' => 'red'
                ]);
            }
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('products.edit', $product->id)->with([
                'msg' => 'Ha ocurrido un error al intentar modificar el producto!',
                'msg_type' => 'red'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if(is_null($product)){
            return redirect()->route('products.index')->with([
                'msg' => 'El producto que deseas eliminar no existe!',
                'msg_type' => 'yellow'
            ]);
        }

        try{
            DB::beginTransaction();

            if(count($product->images) > 0){
                foreach($product->images as $i){
                    Storage::delete($i->image);
                }
            }

            $product->delete();
            DB::commit();
            return redirect()->route('products.index')->with([
                'msg' => 'El producto ha sido eliminado éxitosamente!',
                'msg_type' => 'green'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('products.index')->with([
                'msg' => 'Ha ocurrido al intentar eliminar el producto!',
                'msg_type' => 'red'
            ]);
        }
    }

    public function storeImages(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048'
        ], [
            'images.*.required' => 'Debe ingresar por lo menos una imagen',
            'images.*.image' => 'Todos los archivos seleccionados deben ser imágenes',
            'images.*.mimes' => 'Todos los archivos seleccionados deben ser imágenes',
            'images.*.max' => 'Todos los archivos debes ser menores de 4048Kb'
        ]);

        $product = Product::find($id);

        if(is_null($product)){
            return redirect()->route('products.index')->with([
                'msg' => 'El producto al que desea acceder no existe',
                'msg_type' => 'yellow'
            ]);
        }

        if(!$request->hasFile('images')){
            $validator->errors()->add('images.*', 'Debe ingresar por lo menos una imagen');
            return redirect()->route('products.show', $product->id)->withErrors($validator)->withInput();
        }else{ 
            try{
                DB::beginTransaction();
                foreach($request->file('images') as $item){
                    $image = new Image([
                        'image' => $item->store('public/products')
                    ]);
                
                    Product::find($product->id)->images()->save($image);
                }
            }catch(Exception $e){
                DB::rollBack();
                return redirect()->route('products.show', $product->id)->with([
                    'msg' => 'Ha ocurrido un error al intentar agregar imágenes al producto!',
                    'msg_type' => 'red'
                ]);
            }
    
            DB::commit();
            return redirect()->route('products.show', $product->id)->with([
                'msg' => 'Las imágenes han sido registradas éxitosamente',
                'msg_type' => 'green'
            ]);
        }

    }

    public function destroyImages(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image_id' => 'required'
        ], [
            'image_id.required' => 'Debe seleccionar por lo menos una imagen',
        ]);

        $product = Product::find($id);

        if(is_null($product)){
            return redirect()->route('products.index')->with([
                'msg' => 'El producto al que desea acceder no existe',
                'msg_type' => 'yellow'
            ]);
        }
        
        if(count($request->input('image_id')) > 0){
            try{
                DB::beginTransaction();
                foreach($request->input('image_id') as $id){
                    $img = Image::find($id);
                    if(is_null($img)){
                        DB::rollBack();
                        return redirect()->route('products.show', $product->id)->with([
                            'msg' => 'Las imágenes que deseas eliminar no existen!',
                            'msg_type' => 'yellow'
                        ]);
                    }else{
                        Storage::delete($img->image);
                        $img->delete();
                    }
                }

                DB::commit();                
                return redirect()->route('products.show', $product->id)->with([
                    'msg' => 'Las imágenes seleccionadas han sido eliminadas éxitosamente!',
                    'msg_type' => 'green'
                ]);
            }catch(Exception $e){
                DB::rollBack();                
                return redirect()->route('products.show', $product->id)->with([
                    'msg' => 'Ha ocurrido un error al intentar eliminar las imágenes seleccionadas!',
                    'msg_type' => 'red'
                ]);
            }

        }else{
            $validator->errors()->add('image_id', 'Debes seleccionar por lo menos una imagen');
            return redirect()->route('products.show', $product->id)->withErrors($validator)->withInput();
        }
    }

    public function getData($product_id)
    {
        $product = Product::find($product_id);

        if(is_null($product)){
            return response()->json([
                'msg' => "El producto que deseas seleccionar no existe! <i class='material-icons right'>search</i></b>",
            ], 404);
        }else{
            return response()->json($product);
        }
    }
}
