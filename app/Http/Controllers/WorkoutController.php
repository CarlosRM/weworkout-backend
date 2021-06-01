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
use Illuminate\Support\Facades\Validator;


class WorkoutController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/workouts",
    *     summary="Obtener registros de ejercicios",
    *     tags={"Registros de ejercicio"},
    *     @OA\Response(
    *         response=200,
    *         description="Obtener todos los registros de ejercicio.",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                        {
    *                            "status": 200,
    *                            "message": 200,
    *                            "data": {
    *                                {
    *                                    "id": 17,
    *                                    "created_at": "2021-05-31T21:11:09.000000Z",
    *                                    "updated_at": "2021-05-31T21:11:09.000000Z",
    *                                    "name": "Earum aliquam quos illo error qui.",
    *                                    "date": "2020-05-17 15:27:54",
    *                                    "weight": 50,
    *                                    "fat_percentage": 80,
    *                                    "notes": "Consequatur animi architecto ut ut. Saepe mollitia quo doloremque amet ex et aspernatur voluptatibus. In et doloremque et magni hic. Voluptatem quaerat reiciendis nostrum optio veniam hic aut.",
    *                                    "user_id": 1,
    *                                    "sets": {
    *                                        {
    *                                            "id": 256,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "repetitions": 16,
    *                                            "exercise_id": 9,
    *                                            "pivot": {
    *                                                "workout_id": 17,
    *                                                "set_id": 256,
    *                                                "weight": 71
    *                                            }
    *                                        }
    *                                    }
    *                                }
    *                            }
    *                        },
    *                  ),     
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     ),
    *  security={{ "apiAuth": {} }}
    * )
    */
    public function index()
    {
        $workouts = Workout::where('user_id','=',Auth::user()->id)->with('sets')->get();
        return $this->successResponse($workouts, 200);
    }

    public function show(Workout $workout)
    {
        return $this->successResponse($workout, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/workouts",
     *     summary="Crear Registro de ejercicio",
     *     tags={"Registros de ejercicio"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example = 
     *                      {
     *                       "user_id": 1,
     *                       "name": "Workout SETS",
     *                       "notes": "Notas de ejemplo",
     *                       "weight": 50,
     *                       "fat_percentage": 42,
     *                       "date": "2021-03-21 14:14:36",
     *                       "sets": {{
     *                           "exercise": 1,
     *                           "repetitions": 10,
     *                           "weight": 22
     *                       }}
     *
     *                   }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK. Crea una registro de ejercicio",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                        {
    *                            "status": 201,
    *                            "message": "Workout creado con éxito",
    *                            "data": {
    *                                "user_id": 1,
    *                                "name": "Workout Test",
    *                                "notes": "Workout Notes",
    *                                "weight": 50,
    *                                "fat_percentage": 42,
    *                                "date": "2021-03-21 14:14:36",
    *                                "updated_at": "2021-06-01T08:57:51.000000Z",
    *                                "created_at": "2021-06-01T08:57:51.000000Z",
    *                                "id": 751,
    *                                "sets": {
    *                                    {
    *                                        "id": 10,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 10,
    *                                        "exercise_id": 1,
    *                                        "pivot": {
    *                                            "workout_id": 751,
    *                                            "set_id": 10,
    *                                            "weight": 22
    *                                        }
    *                                    }
    *                                }
    *                            }
    *                        }
    *                  ),     
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error añadiendo registro de ejercicio"
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function store(Request $request)
    {

        if (Auth::user()->id != $request->user_id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'name' => 'required|string',
            'notes' => 'required|string',
            'weight' => 'required|numeric',
            'fat_percentage' => 'required|numeric',
            'date' => 'required|string|date_format:Y-m-d H:i:s',
            'sets' => 'required|array'
        ]);

        if($validator->fails()){
            return $this->errorResponse($validator->errors()->toJson(), 400);
        }

        try {
            $workout = Workout::create($request->all());
            $sets = $request->input('sets');
            foreach ($sets as $set) {
                $foundSet = Set::where('exercise_id', $set['exercise'])->where('repetitions', $set['repetitions'])->first();
                $workout->sets()->attach($foundSet, ['weight' => $set['weight']]);
            }
        } catch (Illuminate\Database\QueryException $e) {
            return $this->errorResponse('Error creando registro de ejercicio', 500);
        } catch (\Exception $e) {
            return $this->errorResponse('Error creando registro de ejercicio', 500);
        }
        
        $workout->sets;        
        return $this->successResponse($workout, 'Workout creado con éxito', 201);
    }

    /**
     * @OA\Put(
     *     path="/api/workouts/{id}",
     *     summary="Actualizar Registro de ejercicio",
     *     tags={"Registros de ejercicio"},
     *     @OA\Parameter(
     *     description="ID del registro de ejercicio",
     *     in="path",
     *     name="id",
     *     required=true,
     *     example="1",
     *     @OA\Schema(
     *        type="integer",
     *        format="int64"
     *           )
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example = 
     *                      {
     *                       "user_id": 1,
     *                       "name": "Workout SETS",
     *                       "notes": "Notas de ejemplo",
     *                       "weight": 50,
     *                       "fat_percentage": 42,
     *                       "date": "2021-03-21 14:14:36",
     *                       "sets": {{
     *                           "exercise": 1,
     *                           "repetitions": 10,
     *                           "weight": 22
     *                       }}
     *
     *                   }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK. Actualiza un registro de ejercicio",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              example=
     *                       {
     *                           "status": 201,
     *                           "message": "Workout editado con éxito",
     *                           "data": {
     *                               "id": 22,
     *                               "created_at": "2021-05-31T21:11:09.000000Z",
     *                               "updated_at": "2021-06-01T09:33:47.000000Z",
     *                               "name": "Workout Test",
     *                               "date": "2021-03-21 14:14:36",
     *                               "weight": 50,
     *                               "fat_percentage": 42,
     *                               "notes": "Update test",
     *                               "user_id": 1,
     *                               "sets": {
     *                                   {
     *                                       "id": 10,
     *                                       "created_at": "2021-05-31T21:11:08.000000Z",
     *                                       "updated_at": "2021-05-31T21:11:08.000000Z",
     *                                       "repetitions": 10,
     *                                       "exercise_id": 1,
     *                                       "pivot": {
     *                                           "workout_id": 22,
     *                                           "set_id": 10,
     *                                           "weight": 22
     *                                       }
     *                                   }
     *                               }
     *                           }
     *                       }
     *                  ), 
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validación "
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error actualizando registro de ejercicio"
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function update(Request $request, Workout $workout)
    {
        if (Auth::user()->id != $workout->user_id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'notes' => 'required|string',
            'weight' => 'required|numeric',
            'fat_percentage' => 'required|numeric',
            'date' => 'required|string|date_format:Y-m-d H:i:s',
            'sets' => 'required|array'
        ]);

        if($validator->fails()){
            return $this->errorResponse($validator->errors()->toJson(), 400);
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

    /**
     * @OA\Delete(
     *     path="/api/workouts/{id}",
     *     tags={"Registros de ejercicio"},
     *     @OA\Parameter(
     *    description="ID del registro de ejercicio",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     summary="Borrar registro de ejerccio",
     *     
     *     @OA\Response(
     *         response=200,
     *         description="OK. Borra un registro de ejercicio",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              example=
     *                        {
     *                            "status": 200,
     *                            "message": "Workout eliminado con éxito",
     *                            "data": {
     *                                "id": 17
     *                            }
     *                        }
     *                  ),     
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error"
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
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
