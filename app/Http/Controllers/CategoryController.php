<?php

namespace Sweet\Http\Controllers;

use Illuminate\Http\Request;
use Sweet\Category;
use Validator;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products|max:80',
            'description' => 'required',
        ], [
            'name.required' => 'El nombre del producto es requerido',
            'name.max' => 'El nombre del producto sobrepasa la longitud permitida (80)',
            'name.unique' => 'El nombre que desea ingresar ya existe',
            
            'description.required' => 'La descripción del producto es requerida',
        ])->validate();

        try{
            DB::beginTransaction();

            $category = new Category([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);

            if($category->save()){
                DB::commit();
                return redirect()->route('categories.index')->with([
                    'msg' => 'La categoría ha sido registrada éxitosamente',
                    'msg_type' => 'green'
                ]);
            }else{
                DB::rollBack();
                return redirect()->route('categories.store')->with([
                    'msg' => 'Ha ocurrido un error al intentar guardar la categoría!',
                    'msg_type' => 'red'
                ]);
            }
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('categories.store')->with([
                'msg' => 'Ha ocurrido un error al intentar guardar la categoría!',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products|max:80',
            'description' => 'required',
        ], [
            'name.required' => 'El nombre del producto es requerido',
            'name.max' => 'El nombre del producto sobrepasa la longitud permitida (80)',
            'name.unique' => 'El nombre que desea ingresar ya existe',
            
            'description.required' => 'La descripción del producto es requerida',
        ])->validate();

        $category = Category::find($id);

        if(is_null($category)){
            return redirect()->route('categories.index')->with([
                'msg' => 'La categoría que deseas modificar no existe',
                'msg_type' => 'yellow'
            ]);
        }

        try{
            DB::beginTransaction();

            $category->name = $request->input('name');
            $category->description = $request->input('description');

            if($category->save()){
                DB::commit();
                return redirect()->route('categories.index')->with([
                    'msg' => 'La categoría ha sido modificada éxitosamente',
                    'msg_type' => 'green'
                ]);
            }else{
                DB::rollBack();
                return redirect()->route('categories.index')->with([
                    'msg' => 'Ha ocurrido un error al intentar modificar la categoría!',
                    'msg_type' => 'red'
                ]);
            }
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('categories.index')->with([
                'msg' => 'Ha ocurrido un error al intentar modificar la categoría!',
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
        $category = Category::find($id);

        if(is_null($category)){
            return redirect()->route('categories.index')->with([
                'msg' => 'La categoría que deseas eliminar no existe',
                'msg_type' => 'red'
            ]);
        }else{
            if(count($category->products) > 0){
                return redirect()->route('categories.index')->with([
                    'msg' => 'La categoría no puede ser eliminada porque posee productos asignados!',
                    'msg_type' => 'yellow'
                ]);
            }else{
                try{
                    DB::beginTransaction();
                    $category->delete();
                    DB::commit();
                    return redirect()->route('categories.index')->with([
                        'msg' => 'La categoría ha sido eliminada éxitosamente!',
                        'msg_type' => 'green'
                    ]);
                }catch(Exception $e){
                    DB::rollback();
                    return redirect()->route('categories.index')->with([
                        'msg' => 'Ha ocurrido un error al intentar eliminar la categoría!',
                        'msg_type' => 'red'
                    ]);
                }
            }
        }
    }

    public function getData($category_id)
    {
        $category = Category::find($category_id);

        if(is_null($category)){
            return response()->json([
                'msg' => "La categoría que deseas seleccionar no existe! <i class='material-icons right'>search</i></b>",
            ], 404);
        }else{
            return response()->json($category);
        }
    }
}
