<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Routine;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class UserController extends ApiController
{

    public function index()
    {
        $users = User::all();
        foreach($users as $user) {
            $user->followers = $user->followers()->pluck('users.id')->toArray();
            $user->followees = $user->followees()->pluck('users.id')->toArray();
            $user->routines = $user->routines()->pluck('routines.id')->toArray();
            $user->favourite_routines = $user->favouriteRoutines()->pluck('favourite_routines.id')->toArray();
        }
        return $this->successResponse($users, 200);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->id != $user->id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }
        Log::error($request->all());
        $user->update($request->all());
        $user->favourite_routines = $user->favouriteRoutines()->pluck('routine_id')->toArray();
        $user->followers = $user->followers()->pluck('follower')->toArray();
        $user->followees = $user->followees()->pluck('followee')->toArray();
        $user->routines = $user->routines()->pluck('id')->toArray();

        return $this->successResponse($user, 'Usuario editado con éxito', 200);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }

    public function addFavorite(Request $request, User $user, Routine $routine)
    {
        try  {
            $user->favouriteRoutines()->attach($routine->id);
        } catch(\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('La rutina ya está en favoritos', 409);
        }
        
        return $this->successResponse($routine, 'Rutina añadida a Favoritos con éxito', 200);
    }

    public function removeFavorite(Request $request, User $user, Routine $routine)
    {
            $user->favouriteRoutines()->detach($routine->id);
       
        return $this->successResponse($routine, 'Rutina eliminada de Favoritos con éxito', 200);
    }

    public function follow(Request $request, User $user, User $followee) {

        if (Auth::user()->id != $user->id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        try {
            $user->followees()->attach($followee);
        } catch(\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('Ha habido un error siguiendo a este usuario', 409);
        }

        return $this->successResponse($followee->id, 'Usuario seguido con éxito', 200);
    }

    public function unfollow(Request $request, User $user, User $followee) {

        if (Auth::user()->id != $user->id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        try {
            $user->followees()->detach($followee);
        } catch(\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('Ha habido un error dejando de seguir a este usuario', 409);
        }

        return $this->successResponse($followee->id, 'Usuario dejado de seguir con éxito', 200);
    }

}
