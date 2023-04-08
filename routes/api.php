<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

//Route::get('clientes', 'App\Http\Controllers\Api\ClienteApiController@index');

// ROTAS DE AUTENTICAÇÃO
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');

});

// ROTAS API
Route::group([

    'middleware' => 'auth:api'

], function ($router) {

    // Rota de clientes
    Route::get('clientes/{id}/documento', 'App\Http\Controllers\Api\ClienteApiController@documento');
    Route::get('clientes/{id}/filmesalugados', 'App\Http\Controllers\Api\ClienteApiController@alugados');
    Route::get('clientes/{id}/telefone', 'App\Http\Controllers\Api\ClienteApiController@telefone');
    Route::resource('clientes', 'App\Http\Controllers\Api\ClienteApiController');

    // Rota de documentos de clientes
    Route::get('documento/{id}/cliente', 'App\Http\Controllers\Api\DocumentoApiController@cliente');
    Route::resource('documento', 'App\Http\Controllers\Api\DocumentoApiController');

    // Rota de telefones de clientes
    Route::get('telefone/{id}/cliente', 'App\Http\Controllers\Api\TelefoneApiController@cliente');
    Route::resource('telefone', 'App\Http\Controllers\Api\TelefoneApiController');

    // Rota de filmes
    Route::resource('filme', 'App\Http\Controllers\Api\FilmeApiController');

});
