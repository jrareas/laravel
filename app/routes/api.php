<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function() {
    Route::get('/user', function(Request $request) {
        return $request->user();
    });
});

Route::middleware('client')->group(function() {
    Route::middleware('logAccess')->group(function(){
        Route::middleware('subscribed')->group(function() {
            Route::get("/whois/{url}", 'Who@is')->name('check_domain_availability');
            Route::get("unitsofmeasure/{physical_quantity}", 'UnitsOfMeasure@index')->name('units_of_measure');
            Route::get('addressvalidation/validate_address','AddressValidationController@validateAddress');
        });
    });
});
Route::prefix('rapi')->middleware('checkRapidApiKey')->group(function() {
    Route::get("/whois/{url}", 'Who@is');
    Route::get("/unitsofmeasure/{physical_quantity}", 'UnitsOfMeasure@index');
    Route::get('addressvalidation/validate_address','AddressValidationController@validateAddress');
});
