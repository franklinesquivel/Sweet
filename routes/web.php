<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/login', 'HomeController@login')->name('login');
Route::get('/catalog', 'HomeController@Catalog')->name('catalog');
Route::get('/register', 'HomeController@Register')->name('register');
Route::post('/register', 'UserController@store')->name('users.store.public');

Route::middleware(['auth.admin'])->group(function(){
    Route::prefix('adm')->group(function(){
        Route::get('/', 'AdminController@index')->name('admin.index');

        Route::resource('users', 'UserController');

        Route::resource('products', 'ProductController');
        Route::get('products/json/{product_id}', 'ProductController@getData')->name('products.json.get');
        Route::post('products/images/{id}', 'ProductController@storeImages')->name('products.images.store');
        Route::delete('products/images/{id}', 'ProductController@destroyImages')->name('products.images.destroy');

        Route::resource('categories', 'CategoryController');
        Route::get('categories/json/{category_id}', 'CategoryController@getData')->name('categories.json.get');
    });
});
