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


Route::get('/ecommerce/{name}', function () {
    return redirect('/home');
})->where('name', '[A-Za-z]+');

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/verify/{verifyToken}', 'VerifyController@verify')->name('verify');

Auth::routes();
Route::get('/home', 'CartController@home')->name('home');

Route::resource('users', 'UserController');
Route::resource('brands', 'BrandController');
Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');
Route::resource('subcats', 'SubcatController');
Route::resource('cart', 'CartController');

Route::post('getBrands', 'BrandController@getBrands')->name('getBrands');


Route::post('getcategories', 'CategoryController@getcategories')->name('getcategories');
Route::post('getsubcat', 'CategoryController@getsubcat')->name('getsubcat');

Route::post('getsubcategories', 'SubcatController@getsubcategories')->name('getsubcategories');

Route::post('getproducts', 'ProductController@getproducts')->name('getproducts');
Route::post('prodImage/{id}', 'ProductController@prodImage')->name('prodImage');
Route::post('getprod', 'ProductController@getprod')->name('getprod');



Route::post('getUsers', 'UserController@getUsers')->name('getUsers');
Route::post('getDrivers', 'UserController@getDrivers')->name('getDrivers');
Route::post('getCustomer', 'UserController@getCustomer')->name('getCustomer');
Route::post('getLogedinUsers', 'UserController@getLogedinUsers')->name('getLogedinUsers');
Route::post('profile/{id}', 'UserController@profile')->name('profile');

Route::post('productimg/{id}', 'UserController@productimg')->name('productimg');

// cart
Route::post('addcart/{id}', 'CartController@addcart')->name('addcart');