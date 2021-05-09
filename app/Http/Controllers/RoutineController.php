<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\User;
use App\Models\Set;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Rating;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class RoutineController extends ApiController
{
    public function index()
    {
        $routines = Routine::with('comments', 'ratings')->get();
        foreach ($routines as $routine) {
            $routine->rating = $routine->ratings->avg('rating');
            $r = Routine::find($routine->id);
            $sets = $r->sets;
            $routine->sets = $sets;
            $bodyparts = [];
            foreach ($sets as $set) {
                $muscles = $set->exercise->muscles;
                foreach ($muscles as $muscle) {
                    $bodyparts[] = $muscle->bodypart;
                }
            }
            $cats = $r->categories;
            $routine->bodyparts = array_values(array_unique($bodyparts));
            $routine->categories = $cats->map(function ($el) {
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
        $sets = $request->input('sets');
        $categories = $request->input('categories');
        foreach ($sets as $set) {
            $foundSet = Set::where('exercise_id', $set['exercise'])->where('repetitions', $set['repetitions'])->first();
            $routine->sets()->attach($foundSet);
        }
        foreach ($categories as $cat) {
            $foundCat = Category::find($cat);
            $routine->categories()->attach($foundCat);
        }

        
        $routine->rating = $routine->ratings()->avg('rating');
        $routine->sets;
        $bodyparts = [];
        foreach ($routine->sets as $set) {
            $muscles = $set->exercise->muscles;
            foreach ($muscles as $muscle) {
                $bodyparts[] = $muscle->bodypart;
            }
        }
        $routine->bodyparts = array_values(array_unique($bodyparts));
        $routine->categories = $routine->categories()->pluck('categories.id')->toArray();
        $routine->similar = $routine->similar()->pluck('routines.id')->toArray();
        $routine->comments;

        
        return $this->successResponse($routine, 'Rutina creada con éxito', 201);
    }

    public function update(Request $request, Routine $routine)
    {
        if (Auth::user()->id != $routine->user_id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        $routine->update($request->all());
        $sets = $request->input('sets');
        $categories = $request->input('categories');

        $routine->sets()->detach();
        $routine->categories()->detach();
        foreach ($sets as $set) {
            $foundSet = Set::where('exercise_id', $set['exercise'])->where('repetitions', $set['repetitions'])->first();
            $routine->sets()->attach($foundSet);
        }
        foreach ($categories as $cat) {
            $foundCat = Category::find($cat);
            $routine->categories()->attach($foundCat);
        }

        
        $routine->rating = $routine->ratings()->avg('rating');
        $routine->sets;
        $bodyparts = [];
        foreach ($routine->sets as $set) {
            $muscles = $set->exercise->muscles;
            foreach ($muscles as $muscle) {
                $bodyparts[] = $muscle->bodypart;
            }
        }
        $routine->bodyparts = array_values(array_unique($bodyparts));
        $routine->categories = $routine->categories()->pluck('categories.id')->toArray();
        $routine->similar = $routine->similar()->pluck('routines.id')->toArray();
        $routine->comments;

        
        return $this->successResponse($routine, 'Rutina creada con éxito', 201);
    }

    public function delete(Routine $routine)
    {

        if (Auth::user()->id != $routine->user_id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }
        $id = $routine->id;
        try {
            $routine->delete();
        } catch (Exception $e) {
            return $this->errorResponse('Algo ha ido mal', 500);
        }

        return $this->successResponse(['id' => $id], 'Rutina eliminada con éxito', 200);
    }

    public function addComment(Request $request, Routine $routine)
    {

        if (Auth::user()->id != $request->input('user_id')) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        try {
            $comment = Comment::create($request->all());

            $routine = Routine::find($request->input('routine_id'));        
            $routine->rating = $routine->ratings()->avg('rating');
            $routine->sets;
            $bodyparts = [];
            foreach ($routine->sets as $set) {
                $muscles = $set->exercise->muscles;
                foreach ($muscles as $muscle) {
                    $bodyparts[] = $muscle->bodypart;
                }
            }
            $routine->bodyparts = array_values(array_unique($bodyparts));
            $routine->categories = $routine->categories()->pluck('categories.id')->toArray();
            $routine->similar = $routine->similar()->pluck('routines.id')->toArray();
            $routine->comments;

        
            return $this->successResponse($routine, 'Comentario añadido con éxito', 201);
        } catch (Exception $e) {
            return $this->errorResponse('Ha habido un error creando tu comentario', 500);
        }
    }

    public function addRating(Request $request, Routine $routine)
    {


        try {
            $comment = Rating::updateOrCreate(
                ['user_id' => Auth::user()->id, 'routine_id' => $routine->id],
                ['rating' => $request->rating]
            );

            $routine = Routine::find($routine->id);        
            $routine->rating = $routine->ratings()->avg('rating');
            $routine->sets;
            $bodyparts = [];
            foreach ($routine->sets as $set) {
                $muscles = $set->exercise->muscles;
                foreach ($muscles as $muscle) {
                    $bodyparts[] = $muscle->bodypart;
                }
            }
            $routine->bodyparts = array_values(array_unique($bodyparts));
            $routine->categories = $routine->categories()->pluck('categories.id')->toArray();
            $routine->similar = $routine->similar()->pluck('routines.id')->toArray();
            $routine->comments;

        
            return $this->successResponse($routine, 'Rating añadido con éxito', 201);
        } catch (Exception $e) {
            return $this->errorResponse('Ha habido un error añadiendo tu rating', 500);
        }
    }
}
