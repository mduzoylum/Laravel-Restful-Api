<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CityController;
use App\Models\Cities;
use \App\Http\Controllers\LoginController;

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

//Şehirleri Getir
Route::get('/cities',[CityController::class,'getCities']);

//Şehri Getir
Route::get('/city'.'/{cities}',[CityController::class,'getCityById']);

//Şehir Kaydet
Route::post('/city',[CityController::class,'saveCity']);

//Şehir Guncelle
Route::put('/city/{cities}',[CityController::class,'updateCity']);

//Şehir Silme
Route::delete('/city/{cities}',[CityController::class,'deleteCity']);

//Şehir Arama
Route::get('/city',[CityController::class,'searchCity']);

//Login Giriş
Route::post('/login',[LoginController::class,'login']);

//Login Refresh Token
Route::post('/refresh',[LoginController::class,'refreshToken']);

//Logout
Route::get('logout',[LoginController::class,'logout']);

//Register
Route::post('/register',[LoginController::class,'register']);

//Gizli Alan
Route::middleware('api.auth')->get('secret',[LoginController::class,'secret']);
