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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/{name}', function () {
    return redirect('/home');
})->where('name', '[A-Za-z]+');

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/verify/{verifyToken}', 'VerifyController@verify')->name('verify');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('brands', 'BrandController');
Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');
Route::resource('subcats', 'SubcatController');

Route::post('getBrands', 'BrandController@getBrands')->name('getBrands');


Route::post('getcategories', 'CategoryController@getcategories')->name('getcategories');
Route::post('getsubcat', 'CategoryController@getsubcat')->name('getsubcat');

Route::post('getsubcategories', 'SubcatController@getsubcategories')->name('getsubcategories');

Route::post('getproducts', 'ProductController@getproducts')->name('getproducts');
Route::post('prodImage/{id}', 'ProductController@prodImage')->name('prodImage');
