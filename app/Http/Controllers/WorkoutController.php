<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\Workout;
use App\Models\User;
use App\Models\Set;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Rating;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class WorkoutController extends ApiController
{
    public function index()
    {
        $workouts = Workout::where('user_id','=',Auth::user()->id)->with('sets')->get();
        return $this->successResponse($workouts, 200);
    }

    public function show(Workout $workout)
    {
        return $this->successResponse($workout, 200);
    }

    public function store(Request $request)
    {
        $workout = Workout::create($request->all());
        $sets = $request->input('sets');
        foreach ($sets as $set) {
            $foundSet = Set::where('exercise_id', $set['exercise'])->where('repetitions', $set['repetitions'])->first();
            $workout->sets()->attach($foundSet, ['weight' => $set['weight']]);
        }
        
        $workout->sets;        
        return $this->successResponse($workout, 'Workout creado con éxito', 201);
    }

    public function update(Request $request, Workout $workout)
    {
        if (Auth::user()->id != $workout->user_id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        $workout->update($request->all());
        $sets = $request->input('sets');

        $workout->sets()->detach();
        foreach ($sets as $set) {
            $foundSet = Set::where('exercise_id', $set['exercise'])->where('repetitions', $set['repetitions'])->first();
            $workout->sets()->attach($foundSet, ['weight' => $set['weight']]);
        }

        $workout->sets;
        return $this->successResponse($workout, 'Workout editado con éxito', 201);
    }

    public function delete(Workout $workout)
    {

        if (Auth::user()->id != $workout->user_id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }
        $id = $workout->id;
        try {
            $workout->delete();
        } catch (Exception $e) {
            return $this->errorResponse('Algo ha ido mal', 500);
        }

        return $this->successResponse(['id' => $id], 'Workout eliminado con éxito', 200);
    }
   
}
