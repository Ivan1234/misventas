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

Route::group(['middleware' => ['guest']], function(){
	Route::get('/', 'Auth\LoginController@showLoginForm')->name('index');
	Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function(){
	Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

	Route::get('/home', 'HomeController@index')->name('home');

	Route::group(['middleware' => ['Comprador']], function(){
		Route::resource('categoria', 'CategoriaController');
		Route::resource('producto', 'ProductController');
		Route::resource('proveedor', 'ProviderController');
		Route::resource('compra', 'CompraController');
		Route::get('pdfCompra/{id}', 'CompraController@pdf')->name('compra_pdf');
	});

	Route::group(['middleware' => ['Vendedor']], function(){
		Route::resource('categoria', 'CategoriaController');
		Route::resource('producto', 'ProductController');
		Route::resource('cliente', 'CustomerController');
	});

	Route::group(['middleware' => ['Administrador']], function(){
		Route::resource('categoria', 'CategoriaController');
		Route::resource('producto', 'ProductController');
		Route::resource('proveedor', 'ProviderController');
		Route::resource('compra', 'CompraController');
		Route::resource('cliente', 'CustomerController');
		Route::resource('rol', 'RolController');
		Route::resource('user', 'UserController');
		Route::get('pdfCompra/{id}', 'CompraController@pdf')->name('compra_pdf');
	});

});




