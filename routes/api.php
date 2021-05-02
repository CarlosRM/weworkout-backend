<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\RoutineController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\UserController;

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

// User Routes
Route::get('users', 'UserController@index')->middleware('jwt', 'belongsToUser');
Route::get('users/{user}', 'UserController@show')->middleware('jwt', 'belongsToUser');
Route::post('users', 'UserController@store')->middleware('jwt', 'belongsToUser');
Route::put('users/{user}', 'UserController@update')->middleware('jwt', 'belongsToUser');
Route::delete('users/{user}', 'UserController@delete')->middleware('jwt', 'belongsToUser');

Route::get('users/{user}/addFavorite/{routine}', 'UserController@addFavorite')->middleware('jwt', 'belongsToUser');
Route::get('users/{user}/removeFavorite/{routine}', 'UserController@removeFavorite')->middleware('jwt', 'belongsToUser');


// Routine Routes
Route::get('routines', 'RoutineController@index')->middleware('jwt');
Route::get('routines/{routine}', 'RoutineController@show')->middleware('jwt');
Route::post('routines', 'RoutineController@store')->middleware('jwt');
Route::put('routines/{routine}', 'RoutineController@update')->middleware('jwt');
Route::delete('routines/{routine}', 'RoutineController@delete')->middleware('jwt');

// Exercise Routes
Route::get('exercises', 'ExerciseController@index')->middleware('jwt');
Route::get('exercises/{exercise}', 'ExerciseController@show')->middleware('jwt');
Route::post('exercises', 'ExerciseController@store')->middleware('jwt');
Route::put('exercises/{exercise}', 'ExerciseController@update')->middleware('jwt');
Route::delete('exercises/{exercise}', 'ExerciseController@delete')->middleware('jwt');

// Category Routes
Route::get('categories', 'CategoryController@index')->middleware('jwt');
Route::get('categories/{category}', 'CategoryController@show')->middleware('jwt');
Route::post('categories', 'CategoryController@store')->middleware('jwt');
Route::put('categories/{category}', 'CategoryController@update')->middleware('jwt');
Route::delete('categories/{category}', 'CategoryController@delete')->middleware('jwt');