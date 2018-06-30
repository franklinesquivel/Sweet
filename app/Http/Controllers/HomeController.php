<?php

namespace Sweet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sweet\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->check()){
            return redirect('/' . strtolower(auth()->user()->userType->id));
        }else{
            $products = Product::latest()->limit(3)->whereExists(function($query){
                $query->select()->from('product_images')->whereRaw('product_images.product_id = products.id');
            })->get();
            return view('public.home', compact('products'));
        }
    }

    public function login()
    {
        if(auth()->check()){
            return redirect('/');
        }else{
            return view( 'public.login');
        }
    }

    public function catalog()
    {
        if(auth()->check()){
            return redirect('/' . strtolower(auth()->user()->userType->id));
        }else{
            $products = Product::orderBy('created_at', 'desc')->get();
            return view('public.catalog', compact('products'));
        }
    }

    public function register()
    {
        if(auth()->check()){
            return redirect('/' . strtolower(auth()->user()->userType->id));
        }else{
            return view('public.register');
        }
    }
}
