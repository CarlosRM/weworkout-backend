<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;

class ExerciseController extends ApiController
{

    public function index()
    {
        $exercises = Exercise::all();
        foreach($exercises as $exercise) {
            $exercise->similar = $exercise->similar()->pluck('exercises.id')->toArray();
        }
        return $this->successResponse($exercises, 200);
    }

    public function show(Exercise $exercise)
    {
        return $exercise;
    }

    public function store(Request $request)
    {
        $exercise = Exercise::create($request->all());

        return response()->json($exercise, 201);
    }

    public function update(Request $request, Exercise $exercise)
    {
        $exercise->update($request->all());

        return response()->json($exercise, 200);
    }

    public function delete(Exercise $exercise)
    {
        $exercise->delete();

        return response()->json(null, 204);
    }}
