<?php

use Illuminate\Support\Facades\Route;

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
    return view('homepage');
});

Route::middleware(["verified","auth"])->group(function() {
    Route::get("info","ProfileInfoController@index");

    Route::get("/subscriptions/{user_id}", 'ApiSubscriptionController@get');
    Route::get("/subscriptions/cancel/{id}", 'ApiSubscriptionController@cancel');
    Route::post("/subscribe", 'ApiSubscriptionController@store');
    Route::get("/plans", 'PlansController@get');
    Route::get('/address', 'AddressController@index');
    Route::post('/address', 'AddressController@store');
    Route::post('/addresses/{user_id}', 'AddressController@index');
    Route::get('/countries','CountryController@index');

    Route::middleware(['admin'])->group(function() {
        Route::get("/users","UserController@get");
        Route::put("/markadmin/{user_id}/{flag}","UserController@markadmin");
        Route::get('/admin/user', 'AdminController@user');

        Route::get('/apiregistration', "ApiRegistrationController@index");

        Route::post('/api', "ApiRegistrationController@store");
        Route::put('/api/{id}', "ApiRegistrationController@update");

        Route::post('image/upload', 'ImageController@upload');
        Route::get('image/get/{image_id}/{size?}', 'ImageController@get');

    });
});

Route::get('/apis', "ApiRegistrationController@get");
Route::get('/products/index', "ProductsController@index")->name('products_index');

Auth::routes(['verify' => true]);

Route::namespace('Auth')->put("/user/{id}","Me@update");

Route::get('/user/{id}', "Me@index");

Route::get('/documentation/index', "DocumentationController@index")->name('documentation_index');
Route::get('/documentation', "DocumentationController@get");

Route::get('/home', 'HomeController@index')->name('home');
