<?php

use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/getAllTransactions', 'TransactionController@index');
    Route::apiResource('products', 'ProductController')->except([
        'index'
    ]);
    Route::post('/getAllProducts', 'ProductController@index');
    Route::get('/getProductsApproved', 'ProductController@getProductsApproved');

    Route::get('/getUser', function (Request $request) {
        return $request->user();
    });
});


Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

Auth::routes();
