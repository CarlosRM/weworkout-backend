<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\RoutineController;

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

Route::get('/apitest', function () {
    $res = ['data' => 'Conexión con el backend de WeWorkout establecida con éxito'];
    return json_encode($res);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout')->middleware('jwt');
    Route::post('refresh', 'AuthController@refresh')->middleware('jwt');
    Route::post('me', 'AuthController@me')->middleware('jwt');

});

Route::get('routines', 'RoutineController@index')->middleware('jwt');
Route::get('routines/{routine}', 'RoutineController@show');
Route::post('routines', 'RoutineController@store');
Route::put('routines/{routine}', 'RoutineController@update');
Route::delete('routines/{routine}', 'RoutineController@delete');