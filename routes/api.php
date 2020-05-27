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
Route::post('register', 'RegisterController@register');
Route::post('login', 'RegisterController@login');
Route::resource('employers', 'EmployerController'); 
Route::resource('banks', 'BankController'); 
Route::PUT('createemploment', 'RegisterController@createEmployment'); 
Route::PUT('updateemployment', 'RegisterController@updateEmployment');
Route::middleware('auth:api')->group( function () {
   

});