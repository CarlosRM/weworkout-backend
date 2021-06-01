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
Route::get('users', 'UserController@index')->middleware('jwt');
Route::get('users/{user}', 'UserController@show')->middleware('jwt', 'belongsToUser');
Route::post('users', 'UserController@store');
Route::put('users/{user}', 'UserController@update')->middleware('jwt', 'belongsToUser');

Route::post('users/{user}/addFavorite/{routine}', 'UserController@addFavorite')->middleware('jwt', 'belongsToUser');
Route::post('users/{user}/removeFavorite/{routine}', 'UserController@removeFavorite')->middleware('jwt', 'belongsToUser');

Route::post('users/{user}/follow/{followee}', 'UserController@follow')->middleware('jwt', 'belongsToUser');
Route::post('users/{user}/unfollow/{followee}', 'UserController@unfollow')->middleware('jwt', 'belongsToUser');

// Routine Routes
Route::get('routines', 'RoutineController@index')->middleware('jwt');
Route::get('routines/{routine}', 'RoutineController@show')->middleware('jwt');
Route::post('routines', 'RoutineController@store')->middleware('jwt');
Route::put('routines/{routine}', 'RoutineController@update')->middleware('jwt');
Route::delete('routines/{routine}', 'RoutineController@delete')->middleware('jwt');
Route::post('routines/{routine}/comment', 'RoutineController@addComment')->middleware('jwt');
Route::post('routines/{routine}/rating', 'RoutineController@addRating')->middleware('jwt');
Route::post('routines/{routine}/visualization', 'RoutineController@addVisualization')->middleware('jwt');

// Exercise Routes
Route::get('exercises', 'ExerciseController@index')->middleware('jwt');

// Category Routes
Route::get('categories', 'CategoryController@index')->middleware('jwt');

// Workout Routes
Route::get('workouts', 'WorkoutController@index')->middleware('jwt');
Route::get('workouts/{workout}', 'WorkoutController@show')->middleware('jwt');
Route::post('workouts', 'WorkoutController@store')->middleware('jwt');
Route::put('workouts/{workout}', 'WorkoutController@update')->middleware('jwt');
Route::delete('workouts/{workout}', 'WorkoutController@delete')->middleware('jwt');
