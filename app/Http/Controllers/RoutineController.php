<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\User;

class RoutineController extends ApiController
{

    public function index()
    {
        $routines = Routine::with('comments', 'ratings')->get();
        foreach($routines as $routine) {
            $routine->rating = $routine->ratings->avg('rating');
            $r = Routine::find($routine->id);
            $sets = $r->sets;
            $routine->sets = $sets;
            $bodyparts = [];
            foreach($sets as $set) {
                $muscles = $set->exercise->muscles;
                foreach($muscles as $muscle) {
                    $bodyparts[] = $muscle->bodypart;
                }
            }
            $cats = $r->categories;
            $routine->bodyparts = array_values(array_unique($bodyparts));
            $routine->categories = $cats->map(function($el) {
                return $el->id;
            });
            $routine->similar = $r->similar()->pluck('routines.id')->toArray();
        }
        return $this->successResponse($routines, 200);
    }

    public function show(Routine $routine)
    {
        return $this->successResponse($routine, 200);
    }

    public function store(Request $request)
    {
        $routine = Routine::create($request->all());

        return response()->json($routine, 201);
    }

    public function update(Request $request, Routine $routine)
    {
        $routine->update($request->all());

        return response()->json($routine, 200);
    }

    public function delete(Routine $routine)
    {
        $routine->delete();

        return response()->json(null, 204);
    }}
