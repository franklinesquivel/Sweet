<?php

namespace Sweet\Http\Controllers;

use Illuminate\Http\Request;
use Sweet\User;
use Sweet\UserType;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Sweet\Mail\UserRegistered;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'dui.required' => 'El DUI es un campo requerido',
            'dui.unique' => 'El DUI ingresado ya existe!',
            'dui.regex' => 'Ingrese un DUI válido! xxxxxxxx-x',
            
            'name.required' => 'El nombre es un campo requerido',
            
            'lastname.required' => 'El apellido es un campo requerido',

            'email.required' => 'El correo electrónico es un campo requerido',
            'email.unique' => 'El correo electrónico ingresado ya existe!',
            'email.email' => 'Ingrese un correo electrónico válido!',
            
            'birthdate.required' => 'La fecha de nacimiento es un campo requerido',
            'birthdate.date' => 'Ingrese una fecha',

            'address.required' => 'La dirección es un campo requerido',

            'phone.required' => 'El número de teléfono es un campo requerido',
            'phone.regex' => 'Ingrese un número de teléfono válido! (2|6|7)xxx-xxxx',
        ];

        $validator = Validator::make($request->all(), [
            'dui' => 'required|unique:users|regex:/(^\d{8}-\d$)/',
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users|email',
            'birthdate' => 'required|date',
            'address' => 'required',
            'phone' => 'required|regex:/(^[267]\d{3}[- ]?\d{4}$)/',
            'user_type_id' => 'nullable',
        ], $message);

        $err_route = auth()->check() ? auth()->user->userType->id . "/users/create" : "/register";
        $success_route = auth()->check() ? auth()->user->userType->id . "/users/" : "/login";

        if($validator->fails()){
            return redirect($err_route)->withErrors($validator)->withInput();
        }

        if(!is_null($request->input('user_type_id'))){
            if(is_null(UserType::find($request->input('user_type_id')))){
                $validator->errors()->add('user_type_id', 'El tipo de usuario que deseas asignar no existe!');
                return redirect($err_route)->withErrors($validator)->withInput();
            }
        }

        $now = new Carbon(config('app.timezone'));
        $birth = new Carbon($request->input('birthdate'));
        $age = $now->diffInYears($birth);

        if($birth > $now){
            $validator->errors()->add('birthdate', 'Ingrese una fecha menor a hoy!');
            return redirect($err_route)->withErrors($validator)->withInput();
        }

        if($age < 18){
            $validator->errors()->add('birthdate', 'Debes ser mayor de edad para registrarte a nuestra plataforma!!');
            return redirect($err_route)->withErrors($validator)->withInput();
        }

        try{
            DB::beginTransaction();

            $pass = str_random(6);
            $user = new User([
                'dui' => $request->input('dui'),
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'birthdate' => $request->input('birthdate'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'age' => $age
            ]);

            $user->password = bcrypt($pass);

            if(!is_null($request->input('user_type_id'))){
                $user->user_type_id = $request->input('user_type_id');
            }

            if($user->save()){
                $user = User::find($user->id);
                Mail::to($user->email)->send(new UserRegistered($user, $pass));
                DB::commit();

                return redirect($success_route)->with([
                    'msg' => 'El usuario ha sido registrado éxitosamente! La contraseña ha sido mandada a su correo electrónico.',
                    'msg_type' => 'green'
                ]);
            }else{
                DB::rollBack();
                return redirect($err_route)->with([
                    'msg' => 'Ha ocurrido un error al intentar registrar el usuario!',
                    'msg_type' => 'red'
                ]);
            }
        }catch(Exception $e){
            DB::rollBack();
            return redirect($err_route)->with([
                'msg' => 'Ha ocurrido un error al intentar registrar el usuario!',
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
