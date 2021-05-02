<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Routine;

use Illuminate\Support\Facades\Auth;

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
        $user->update($request->all());

        return response()->json($user, 200);
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

}
