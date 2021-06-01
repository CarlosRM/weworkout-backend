<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;

class ExerciseController extends ApiController
{

    /**
    * @OA\Get(
    *     path="/api/exercises",
    *     summary="Obtener ejercicios",
    *     tags={"Ejercicios"},
    *     @OA\Response(
    *         response=200,
    *         description="Obtener todos los ejercicios.",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                       {
    *                            "status": 200,
    *                            "message": 200,
    *                            "data": {
    *                                {
    *                                    "id": 1,
    *                                    "created_at": "2021-05-31T21:11:08.000000Z",
    *                                    "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                    "name": "Flexión",
    *                                    "description": "Dolore enim rerum voluptatem distinctio ipsum accusamus eum fugit. Et ut laborum est quaerat quia quia mollitia quod. Iure voluptate sed asperiores omnis sunt perferendis dolores.",
    *                                    "videoURL": "https://www.youtube.com/embed/Olkjnp6-2Rs",
    *                                    "similar": {
    *                                        4,
    *                                        8,
    *                                        11
    *                                    },
    *                                    "muscles": {
    *                                        {
    *                                            "id": 2,
    *                                            "created_at": "2021-05-31T21:11:07.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                            "name": "Tríceps",
    *                                            "bodypart": "Brazo",
    *                                            "pivot": {
    *                                                "exercise_id": 1,
    *                                                "muscle_id": 2
    *                                            }
    *                                        },
    *                                        {
    *                                            "id": 9,
    *                                            "created_at": "2021-05-31T21:11:07.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                            "name": "Abdominales Superiores",
    *                                            "bodypart": "Torso",
    *                                            "pivot": {
    *                                                "exercise_id": 1,
    *                                                "muscle_id": 9
    *                                            }
    *                                        },
    *                                        {
    *                                            "id": 11,
    *                                            "created_at": "2021-05-31T21:11:07.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                            "name": "Pecho",
    *                                            "bodypart": "Torso",
    *                                            "pivot": {
    *                                                "exercise_id": 1,
    *                                                "muscle_id": 11
    *                                            }
    *                                        }
    *                                    }
    *                                }
    *                            }
    *                        }
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
        $exercises = Exercise::all();
        foreach($exercises as $exercise) {
            $exercise->similar = $exercise->similar()->pluck('exercises.id')->toArray();
            $exercise->muscles;
        }
        return $this->successResponse($exercises, 200);
    }
}
