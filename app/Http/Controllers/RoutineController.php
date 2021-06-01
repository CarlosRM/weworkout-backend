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
use Illuminate\Support\Facades\Validator;


class RoutineController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/routines",
    *     summary="Obtener rutinas",
    *     tags={"Rutinas"},
    *     @OA\Response(
    *         response=200,
    *         description="Obtener todas las rutinas.",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                    {
    *                        "status": 200,
    *                        "message": 200,
    *                        "data": {
    *                            {
    *                                "id": 1,
    *                                "created_at": "2021-05-31T21:11:08.000000Z",
    *                                "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                "user_id": 1,
    *                                "name": "Ipsum qui ut perspiciatis.",
    *                                "description": "Deserunt sit voluptatem id ea repudiandae veritatis voluptate. Enim nostrum enim veritatis nihil facere distinctio. Enim repellat et rerum nisi ut. Molestiae eum laborum aliquid voluptate sed distinctio. Qui odit aliquam voluptas quisquam natus. Delectus temporibus atque eaque voluptatem. Nesciunt magnam qui voluptates numquam ipsum et. Ducimus possimus suscipit ut fugit est. Est sit vel consequatur aut repudiandae pariatur corporis. Vel esse commodi voluptas beatae ut eum voluptatem. Incidunt dicta et ad velit maxime. Minus aspernatur culpa cumque et saepe distinctio. Maxime dolorum autem consectetur iste sed id. Voluptatum consequatur ea eius placeat. Sunt commodi omnis est quasi. Voluptatum voluptatem consectetur voluptatem itaque dignissimos repudiandae. Reiciendis dolorem qui est magnam deserunt ipsum ut. Nobis quaerat eos voluptatem cumque. Neque libero reprehenderit a.",
    *                                "visualizations": 1823,
    *                                "rating": 3,
    *                                "sets": {
    *                                    {
    *                                        "id": 30,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 30,
    *                                        "exercise_id": 1,
    *                                        "pivot": {
    *                                            "routine_id": 1,
    *                                            "set_id": 30
    *                                         },
    *                                        "exercise": {
    *                                            "id": 1,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "name": "Flexión",
    *                                            "description": "Dolore enim rerum voluptatem distinctio ipsum accusamus eum fugit. Et ut laborum est quaerat quia quia mollitia quod. Iure voluptate sed asperiores omnis sunt perferendis dolores.",
    *                                            "videoURL": "https://www.youtube.com/embed/Olkjnp6-2Rs",
    *                                            "muscles": {
    *                                                {
    *                                                    "id": 2,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Tríceps",
    *                                                    "bodypart": "Brazo",
    *                                                    "pivot": {
    *                                                        "exercise_id": 1,
    *                                                        "muscle_id": 2
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 9,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Abdominales Superiores",
    *                                                    "bodypart": "Torso",
    *                                                    "pivot": {
    *                                                        "exercise_id": 1,
    *                                                        "muscle_id": 9
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 11,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Pecho",
    *                                                    "bodypart": "Torso",
    *                                                    "pivot": {
    *                                                        "exercise_id": 1,
    *                                                        "muscle_id": 11
    *                                                    }
    *                                                }
    *                                            }
    *                                        }
    *                                    },
    *                                    {
    *                                        "id": 87,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 27,
    *                                        "exercise_id": 3,
    *                                        "pivot": {
    *                                            "routine_id": 1,
    *                                            "set_id": 87
    *                                        },
    *                                        "exercise": {
    *                                            "id": 3,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "name": "Flexión Arquero",
    *                                            "description": "Veritatis ut amet omnis et et in sit. Dolor quae dignissimos quia aspernatur adipisci id. Ad aut fugit praesentium quibusdam.",
    *                                            "videoURL": "https://www.youtube.com/embed/3wZuPAjC12M",
    *                                            "muscles": {
    *                                                {
    *                                                    "id": 2,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Tríceps",
    *                                                    "bodypart": "Brazo",
    *                                                    "pivot": {
    *                                                        "exercise_id": 3,
    *                                                        "muscle_id": 2
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 9,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Abdominales Superiores",
    *                                                    "bodypart": "Torso",
    *                                                    "pivot": {
    *                                                        "exercise_id": 3,
    *                                                        "muscle_id": 9
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 11,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Pecho",
    *                                                    "bodypart": "Torso",
    *                                                    "pivot": {
    *                                                        "exercise_id": 3,
    *                                                        "muscle_id": 11
    *                                                    }
    *                                                }
    *                                            }
    *                                        }
    *                                    },
    *                                    {
    *                                        "id": 121,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 1,
    *                                        "exercise_id": 5,
    *                                        "pivot": {
    *                                            "routine_id": 1,
    *                                            "set_id": 121
    *                                        },
    *                                        "exercise": {
    *                                            "id": 5,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "name": "Dominada Supina",
    *                                            "description": "Quasi ipsam adipisci mollitia temporibus id fugiat facilis. Consequatur omnis aut est et ab dolor. Dolore similique nam laborum quisquam nostrum omnis.",
    *                                            "videoURL": "https://www.youtube.com/embed/uHheC0C4T3w",
    *                                            "muscles": {
    *                                                {
    *                                                    "id": 1,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Bíceps",
    *                                                    "bodypart": "Brazo",
    *                                                    "pivot": {
    *                                                        "exercise_id": 5,
    *                                                        "muscle_id": 1
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 3,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Hombros",
    *                                                    "bodypart": "Brazo",
    *                                                    "pivot": {
    *                                                        "exercise_id": 5,
    *                                                        "muscle_id": 3
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 11,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Pecho",
    *                                                    "bodypart": "Torso",
    *                                                    "pivot": {
    *                                                        "exercise_id": 5,
    *                                                        "muscle_id": 11
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 12,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Dorsales",
    *                                                    "bodypart": "Espalda",
    *                                                    "pivot": {
    *                                                        "exercise_id": 5,
    *                                                        "muscle_id": 12
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 14,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Trapecios",
    *                                                    "bodypart": "Espalda",
    *                                                    "pivot": {
    *                                                        "exercise_id": 5,
    *                                                        "muscle_id": 14
    *                                                    }
    *                                                }
    *                                            }
    *                                        }
    *                                    },
    *                                    {
    *                                        "id": 127,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 7,
    *                                        "exercise_id": 5,
    *                                        "pivot": {
    *                                            "routine_id": 1,
    *                                            "set_id": 127
    *                                        },
    *                                        "exercise": {
    *                                            "id": 5,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "name": "Dominada Supina",
    *                                            "description": "Quasi ipsam adipisci mollitia temporibus id fugiat facilis. Consequatur omnis aut est et ab dolor. Dolore similique nam laborum quisquam nostrum omnis.",
    *                                            "videoURL": "https://www.youtube.com/embed/uHheC0C4T3w",
    *                                            "muscles": {
    *                                                {
    *                                                    "id": 1,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Bíceps",
    *                                                    "bodypart": "Brazo",
    *                                                    "pivot": {
    *                                                        "exercise_id": 5,
    *                                                        "muscle_id": 1
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 3,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Hombros",
    *                                                    "bodypart": "Brazo",
    *                                                    "pivot": {
    *                                                        "exercise_id": 5,
    *                                                        "muscle_id": 3
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 11,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Pecho",
    *                                                    "bodypart": "Torso",
    *                                                    "pivot": {
    *                                                        "exercise_id": 5,
    *                                                        "muscle_id": 11
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 12,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Dorsales",
    *                                                    "bodypart": "Espalda",
    *                                                    "pivot": {
    *                                                        "exercise_id": 5,
    *                                                        "muscle_id": 12
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 14,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Trapecios",
    *                                                    "bodypart": "Espalda",
    *                                                    "pivot": {
    *                                                        "exercise_id": 5,
    *                                                        "muscle_id": 14
    *                                                    }
    *                                                }
    *                                            }
    *                                        }
    *                                    },
    *                                    {
    *                                        "id": 167,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 17,
    *                                        "exercise_id": 6,
    *                                        "pivot": {
    *                                            "routine_id": 1,
    *                                            "set_id": 167
    *                                        },
    *                                       "exercise": {
    *                                            "id": 6,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "name": "Sentadilla",
    *                                            "description": "Quae earum necessitatibus illum sapiente architecto et. Autem dolore magni nostrum non.",
    *                                            "videoURL": "https://www.youtube.com/embed/Zqc_lc93hak",
    *                                            "muscles": {
    *                                                {
    *                                                    "id": 5,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Cuádriceps",
    *                                                    "bodypart": "Pierna",
    *                                                    "pivot": {
    *                                                        "exercise_id": 6,
    *                                                        "muscle_id": 5
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 6,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Isquiotibiales",
    *                                                    "bodypart": "Pierna",
    *                                                    "pivot": {
    *                                                        "exercise_id": 6,
    *                                                        "muscle_id": 6
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 7,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Glúteos",
    *                                                    "bodypart": "Pierna",
    *                                                    "pivot": {
    *                                                        "exercise_id": 6,
    *                                                        "muscle_id": 7
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 8,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Gemelos",
    *                                                    "bodypart": "Pierna",
    *                                                    "pivot": {
    *                                                        "exercise_id": 6,
    *                                                        "muscle_id": 8
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 9,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Abdominales Superiores",
    *                                                    "bodypart": "Torso",
    *                                                    "pivot": {
    *                                                        "exercise_id": 6,
    *                                                        "muscle_id": 9
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 10,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Abdominales Inferiores",
    *                                                    "bodypart": "Torso",
    *                                                    "pivot": {
    *                                                        "exercise_id": 6,
    *                                                        "muscle_id": 10
    *                                                    }
    *                                                }
    *                                            }
    *                                        }
    *                                    }
    *                                },
    *                                "bodyparts": {
    *                                    "Brazo",
    *                                    "Torso",
    *                                    "Espalda",
    *                                    "Pierna"
    *                                },
    *                                "categories": {
    *                                    1,
    *                                    2,
    *                                    5
    *                                },
    *                                "similar": {
    *                                    16
    *                                },
    *                                "comments": {
    *                                    {
    *                                        "id": 37,
    *                                        "created_at": "2021-05-31T21:11:10.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:10.000000Z",
    *                                        "content": "Quo laboriosam quasi commodi sunt hic. Ut alias saepe animi vel. Ut eveniet possimus non omnis.",
    *                                        "user_id": 4,
    *                                        "routine_id": 1
    *                                    }
    *                                },
    *                                "ratings": {
    *                                    {
    *                                        "id": 22,
    *                                        "created_at": "2021-05-31T21:11:10.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:10.000000Z",
    *                                        "rating": 3,
    *                                        "user_id": 3,
    *                                        "routine_id": 1
    *                                    }
    *                                }
    *                            }
    *                        }
    *                    }
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
    /**
     * @OA\Post(
     *     path="/api/routines",
     *     summary="Crear Rutina",
     *     tags={"Rutinas"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example = {
     *                      "user_id": 1,
     *                      "name": "Rutina de prueba",
     *                      "description": "Ojalá funcione",
     *                      "visualizations": 0,
     *                       "sets": {{
     *                           "exercise": 1,
     *                           "repetitions": 10
     *                       }},
     *                       "categories": {
     *                           1
     *                       }
     *                   },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK. Crea una rutina",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              example=
     *                       {
     *                           "status": 201,
     *                           "message": "Rutina creada con éxito",
     *                           "data": {
     *                               "user_id": 1,
     *                               "name": "Rutina de prueba",
     *                               "description": "Ojalá funcione",
     *                               "visualizations": 0,
     *                               "updated_at": "2021-06-01T10:04:52.000000Z",
     *                               "created_at": "2021-06-01T10:04:52.000000Z",
     *                               "id": 41,
     *                               "rating": null,
     *                               "bodyparts": {
     *                                   "Brazo",
     *                                   "Torso"
     *                               },
     *                               "categories": {
     *                                   1
     *                               },
     *                               "similar": {},
     *                               "sets": {
     *                                   {
     *                                       "id": 10,
     *                                       "created_at": "2021-05-31T21:11:08.000000Z",
     *                                       "updated_at": "2021-05-31T21:11:08.000000Z",
     *                                       "repetitions": 10,
     *                                       "exercise_id": 1,
     *                                       "pivot": {
     *                                           "routine_id": 41,
     *                                           "set_id": 10
     *                                       },
     *                                       "exercise": {
     *                                           "id": 1,
     *                                           "created_at": "2021-05-31T21:11:08.000000Z",
     *                                           "updated_at": "2021-05-31T21:11:08.000000Z",
     *                                           "name": "Flexión",
     *                                           "description": "Dolore enim rerum voluptatem distinctio ipsum accusamus eum fugit. Et ut laborum est quaerat quia quia mollitia quod. Iure voluptate sed asperiores omnis sunt perferendis dolores.",
     *                                           "videoURL": "https://www.youtube.com/embed/Olkjnp6-2Rs",
     *                                           "muscles": {
     *                                               {
     *                                                   "id": 2,
     *                                                   "created_at": "2021-05-31T21:11:07.000000Z",
     *                                                   "updated_at": "2021-05-31T21:11:07.000000Z",
     *                                                   "name": "Tríceps",
     *                                                   "bodypart": "Brazo",
     *                                                   "pivot": {
     *                                                       "exercise_id": 1,
     *                                                       "muscle_id": 2
     *                                                   }
     *                                               },
     *                                               {
     *                                                   "id": 9,
     *                                                   "created_at": "2021-05-31T21:11:07.000000Z",
     *                                                   "updated_at": "2021-05-31T21:11:07.000000Z",
     *                                                   "name": "Abdominales Superiores",
     *                                                   "bodypart": "Torso",
     *                                                   "pivot": {
     *                                                       "exercise_id": 1,
     *                                                       "muscle_id": 9
     *                                                   }
     *                                               },
     *                                               {
     *                                                   "id": 11,
     *                                                   "created_at": "2021-05-31T21:11:07.000000Z",
     *                                                   "updated_at": "2021-05-31T21:11:07.000000Z",
     *                                                   "name": "Pecho",
     *                                                   "bodypart": "Torso",
     *                                                   "pivot": {
     *                                                       "exercise_id": 1,
     *                                                       "muscle_id": 11
     *                                                   }
     *                                               }
     *                                           }
     *                                       }
     *                                   }
     *                               },
     *                               "comments": {}
     *                           }
     *                       }
     *                  ),     
     *     ),
    *     @OA\Response(
     *         response=400,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error creando la rutina"
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
            'description' => 'required|string',
            'visualizations' => 'required|numeric',
            'sets' => 'required|array',
            'categories' => 'required|array'
        ]);

        if($validator->fails()){
                return $this->errorResponse($validator->errors()->toJson(), 400);
        }

        try {
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
        } catch(\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('Ha habido un error creando la rutina', 500);
        }

        
        return $this->successResponse($routine, 'Rutina creada con éxito', 201);
    }

    /**
     * @OA\Put(
     *     path="/api/routines/{id}",
     *     summary="Actualizar Rutina",
     *     tags={"Rutinas"},
     *     @OA\Parameter(
     *    description="ID de la rutina",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example = {
     *                      "user_id": 1,
     *                      "name": "Rutina de prueba",
     *                      "description": "Ojalá funcione",
     *                      "visualizations": 0,
     *                       "sets": {{
     *                           "exercise": 1,
     *                           "repetitions": 10
     *                       }},
     *                       "categories": {
     *                           1
     *                       }
     *                   },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK. Actualiza la rutina",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              example=
    *                        {
    *                            "status": 201,
    *                            "message": "Rutina actualizada con éxito",
    *                            "data": {
    *                                "id": 1,
    *                                "created_at": "2021-05-31T21:11:08.000000Z",
    *                                "updated_at": "2021-06-01T10:11:31.000000Z",
    *                                "user_id": 1,
    *                                "name": "Rutina de prueba",
    *                                "description": "Update Test",
    *                                "visualizations": 0,
    *                                "rating": 3,
    *                                "bodyparts": {
    *                                    "Brazo",
    *                                    "Torso"
    *                                },
    *                                "categories": {
    *                                    1
    *                                },
    *                                "similar": {
    *                                    16
    *                                },
    *                                "sets": {
    *                                    {
    *                                        "id": 10,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 10,
    *                                        "exercise_id": 1,
    *                                        "pivot": {
    *                                            "routine_id": 1,
    *                                            "set_id": 10
    *                                        },
    *                                        "exercise": {
    *                                            "id": 1,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "name": "Flexión",
    *                                            "description": "Dolore enim rerum voluptatem distinctio ipsum accusamus eum fugit. Et ut laborum est quaerat quia quia mollitia quod. Iure voluptate sed asperiores omnis sunt perferendis dolores.",
    *                                            "videoURL": "https://www.youtube.com/embed/Olkjnp6-2Rs",
    *                                            "muscles": {
    *                                                {
    *                                                    "id": 2,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Tríceps",
    *                                                    "bodypart": "Brazo",
    *                                                    "pivot": {
    *                                                        "exercise_id": 1,
    *                                                        "muscle_id": 2
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 9,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Abdominales Superiores",
    *                                                    "bodypart": "Torso",
    *                                                    "pivot": {
    *                                                        "exercise_id": 1,
    *                                                        "muscle_id": 9
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 11,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Pecho",
    *                                                    "bodypart": "Torso",
    *                                                    "pivot": {
    *                                                        "exercise_id": 1,
    *                                                        "muscle_id": 11
    *                                                    }
    *                                                }
    *                                            }
    *                                        }
    *                                    }
    *                                },
    *                                "comments": {
    *                                    {
    *                                        "id": 37,
    *                                        "created_at": "2021-05-31T21:11:10.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:10.000000Z",
    *                                        "content": "Quo laboriosam quasi commodi sunt hic. Ut alias saepe animi vel. Ut eveniet possimus non omnis.",
    *                                        "user_id": 4,
    *                                        "routine_id": 1
    *                                    }
    *                                }
    *                            }
    *                        }
     *                  ),     
    *     ),
    *     @OA\Response(
     *         response=400,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error actualizando la rutina"
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function update(Request $request, Routine $routine)
    {
        if (Auth::user()->id != $routine->user_id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'name' => 'required|string',
            'description' => 'required|string',
            'visualizations' => 'required|numeric',
            'sets' => 'required|array',
            'categories' => 'required|array'
        ]);

        if($validator->fails()){
                return $this->errorResponse($validator->errors()->toJson(), 400);
        }

        try {
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
        } catch(\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('Ha habido un actualizando la rutina', 500);
        }

        
        return $this->successResponse($routine, 'Rutina actualizada con éxito', 201);
    }
    /**
     * @OA\Delete(
     *     path="/api/routines/{id}",
     *     tags={"Rutinas"},
     *     @OA\Parameter(
     *    description="ID de la rutina",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     summary="Borrar rutina",
     *     
     *     @OA\Response(
     *         response=200,
     *         description="OK. Borra una rutina",
     *         @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                        {
    *                            "status": 200,
    *                            "message": "Rutina eliminada con éxito",
    *                            "data": {
    *                                "id": 1
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

    /**
     * @OA\Post(
     *     path="/api/routines/{id}/comment",
     *     summary="Añadir comentario",
     *     tags={"Rutinas"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example = {
     *                       "user_id": 1,
     *                       "routine_id": 5,
     *                       "content": "Este es un comentario de prueba"
     *                   },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK. Añade un comentario. Devuelve rutina con nuevo comentario",
     *          @OA\MediaType(
    *             mediaType="application/json",
    *              example=
     *                   {
     *                       "status": 201,
     *                       "message": "Comentario añadido con éxito",
     *                       "data": {
     *                           "id": 5,
     *                           "created_at": "2021-05-31T21:11:08.000000Z",
     *                           "updated_at": "2021-05-31T21:11:08.000000Z",
     *                           "user_id": 8,
     *                           "name": "Placeat et quam placeat eum.",
     *                           "description": "Et non excepturi distinctio illo et animi ut et. Molestias sunt quis quas illo tempore culpa. Ea non quae nesciunt sunt doloribus laboriosam suscipit. Ex vel corrupti voluptas dolor laborum unde et. Dolore provident consequatur est corrupti voluptates vero laudantium. Qui incidunt et vel sint dicta et est. Incidunt maiores et iure cupiditate ducimus facilis ea. Temporibus eum velit dolorum optio nam. Quibusdam corporis soluta adipisci eos ea voluptatem aut. Aliquam et harum sed aut dolorem odit ut. Alias explicabo tenetur adipisci nihil dolores. Voluptatibus debitis perferendis voluptatem corporis accusantium voluptas quo nihil. Aut aspernatur possimus ut provident tempora temporibus porro. Adipisci quibusdam sit id aut et vero velit. Consectetur architecto aut quia ut eos. Et consequuntur delectus libero dignissimos. Quia nulla tenetur impedit qui rerum. Cupiditate necessitatibus exercitationem ea praesentium. Praesentium nisi quae veniam nisi sint.",
     *                           "visualizations": 1511,
     *                           "rating": 2,
     *                           "bodyparts": {
     *                               "Brazo",
     *                               "Espalda"
     *                           },
     *                           "categories": {
     *                               1,
     *                               2,
     *                               4
     *                           },
     *                           "similar": {
     *                               4
     *                           },
     *                           "sets": {
     *                               {
     *                                   "id": 266,
     *                                   "created_at": "2021-05-31T21:11:08.000000Z",
     *                                   "updated_at": "2021-05-31T21:11:08.000000Z",
     *                                   "repetitions": 26,
     *                                   "exercise_id": 9,
     *                                   "pivot": {
     *                                       "routine_id": 5,
     *                                       "set_id": 266
     *                                   },
     *                                   "exercise": {
     *                                       "id": 9,
     *                                       "created_at": "2021-05-31T21:11:08.000000Z",
     *                                       "updated_at": "2021-05-31T21:11:08.000000Z",
     *                                       "name": "Remo",
     *                                       "description": "Numquam nisi et non dignissimos. Quibusdam et qui exercitationem saepe iste. Aliquam eveniet voluptatem quas exercitationem. Fugiat quia eveniet iure sint est natus.",
     *                                       "videoURL": "https://www.youtube.com/embed/xQNrFHEMhI4",
     *                                       "muscles": {
     *                                           {
     *                                               "id": 1,
     *                                               "created_at": "2021-05-31T21:11:07.000000Z",
     *                                               "updated_at": "2021-05-31T21:11:07.000000Z",
     *                                               "name": "Bíceps",
     *                                               "bodypart": "Brazo",
     *                                               "pivot": {
     *                                                   "exercise_id": 9,
     *                                                   "muscle_id": 1
     *                                               }
     *                                           },
     *                                           {
     *                                               "id": 2,
     *                                               "created_at": "2021-05-31T21:11:07.000000Z",
     *                                               "updated_at": "2021-05-31T21:11:07.000000Z",
     *                                               "name": "Tríceps",
     *                                               "bodypart": "Brazo",
     *                                               "pivot": {
     *                                                   "exercise_id": 9,
     *                                                   "muscle_id": 2
     *                                               }
     *                                           },
     *                                           {
     *                                               "id": 3,
     *                                               "created_at": "2021-05-31T21:11:07.000000Z",
     *                                               "updated_at": "2021-05-31T21:11:07.000000Z",
     *                                               "name": "Hombros",
     *                                               "bodypart": "Brazo",
     *                                               "pivot": {
     *                                                   "exercise_id": 9,
     *                                                   "muscle_id": 3
     *                                               }
     *                                           },
     *                                           {
     *                                               "id": 12,
     *                                               "created_at": "2021-05-31T21:11:07.000000Z",
     *                                               "updated_at": "2021-05-31T21:11:07.000000Z",
     *                                               "name": "Dorsales",
     *                                               "bodypart": "Espalda",
     *                                               "pivot": {
     *                                                   "exercise_id": 9,
     *                                                   "muscle_id": 12
     *                                               }
     *                                           },
     *                                           {
     *                                               "id": 14,
     *                                               "created_at": "2021-05-31T21:11:07.000000Z",
     *                                               "updated_at": "2021-05-31T21:11:07.000000Z",
     *                                               "name": "Trapecios",
     *                                               "bodypart": "Espalda",
     *                                               "pivot": {
     *                                                   "exercise_id": 9,
     *                                                   "muscle_id": 14
     *                                               }
     *                                           }
     *                                       }
     *                                   }
     *                               }
     *                           },
     *                           "comments": {
     *                               {
     *                                   "id": 4,
     *                                   "created_at": "2021-05-31T21:11:10.000000Z",
     *                                   "updated_at": "2021-05-31T21:11:10.000000Z",
     *                                   "content": "Totam impedit a aut beatae. Et ea sit quidem praesentium quos numquam.",
     *                                   "user_id": 10,
     *                                   "routine_id": 5
     *                               },
     *                               {
     *                                   "id": 8,
     *                                   "created_at": "2021-05-31T21:11:10.000000Z",
     *                                   "updated_at": "2021-05-31T21:11:10.000000Z",
     *                                   "content": "Voluptates nostrum deserunt libero tempora ipsa numquam. Fuga provident aspernatur suscipit voluptates. Eos expedita voluptate sapiente ipsum amet.",
     *                                   "user_id": 2,
     *                                   "routine_id": 5
     *                               },
     *                               {
     *                                   "id": 41,
     *                                   "created_at": "2021-06-01T10:37:37.000000Z",
     *                                   "updated_at": "2021-06-01T10:37:37.000000Z",
     *                                   "content": "Este es un comentario de prueba 2",
     *                                   "user_id": 1,
     *                                   "routine_id": 5
     *                               },
     *                               {
     *                                   "id": 42,
     *                                   "created_at": "2021-06-01T10:54:31.000000Z",
     *                                   "updated_at": "2021-06-01T10:54:31.000000Z",
     *                                   "content": "Este es un comentario de prueba 2",
     *                                   "user_id": 1,
     *                                   "routine_id": 5
     *                               }
     *                           }
     *                       }
     *                   }
    *                  ),     
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="OK. No autorizado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error"
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function addComment(Request $request, Routine $routine)
    {

        if (Auth::user()->id != $request->input('user_id')) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'routine_id' => 'required|numeric',
            'content' => 'required|string'
        ]);

        if($validator->fails()){
                return $this->errorResponse($validator->errors()->toJson(), 400);
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

    /**
     * @OA\Post(
     *     path="/api/routines/{id}/rating",
     *     summary="Añadir/Actualizar rating",
     *     tags={"Rutinas"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example = {
     *                       "rating": 5,
     *                   },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK. Añade/Actualiza rating. Devuelve rutina con rating actualizado",
     *          @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                       {
    *                            "status": 201,
    *                            "message": "Rating añadido con éxito",
    *                            "data": {
    *                                "id": 2,
    *                                "created_at": "2021-05-31T21:11:08.000000Z",
    *                                "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                "user_id": 5,
    *                                "name": "Tempore quasi tenetur minus necessitatibus dolorum consequatur.",
    *                                "description": "Illo voluptas expedita excepturi omnis assumenda perferendis pariatur delectus. Rerum rem maiores delectus id consequuntur similique deleniti magnam. Totam qui rerum corrupti explicabo est. Commodi optio dolor iusto quod recusandae. Corporis deleniti assumenda veritatis sunt aut totam. Quisquam repudiandae consequatur voluptatibus iusto dignissimos. Odio ut quisquam blanditiis ratione. Enim eaque eveniet velit provident sint dolor. Aut sunt repellendus facere illum placeat voluptatem quia. Numquam est reprehenderit blanditiis sit cupiditate optio. Sapiente quis id soluta molestias non dicta omnis. Commodi velit doloremque et non dignissimos omnis. Voluptatem et et et aliquid. Laborum libero dicta consequatur neque optio enim at voluptates. Inventore suscipit cum facilis optio pariatur blanditiis. Necessitatibus tempore nesciunt nostrum neque. Debitis natus consequatur dicta. Ut qui minima quia aut quis eos est.",
    *                                "visualizations": 1661,
    *                                "rating": 4,
    *                                "bodyparts": {
    *                                    "Brazo",
    *                                    "Pierna"
    *                                },
    *                                "categories": {
    *                                    6
    *                                },
    *                                "similar": {
    *                                    2,
    *                                    11
    *                                },
    *                                "sets": {
    *                                    {
    *                                        "id": 314,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 14,
    *                                        "exercise_id": 11,
    *                                        "pivot": {
    *                                            "routine_id": 2,
    *                                            "set_id": 314
    *                                        },
    *                                        "exercise": {
    *                                            "id": 11,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "name": "Curl de Bíceps",
    *                                            "description": "Quidem magnam modi et incidunt sed facilis. Sapiente aut nulla dolorum. Rerum non enim est error iure.",
    *                                            "videoURL": "https://www.youtube.com/embed/tMEGqKuOa-M",
    *                                            "muscles": {
    *                                                {
    *                                                    "id": 1,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Bíceps",
    *                                                    "bodypart": "Brazo",
    *                                                    "pivot": {
    *                                                        "exercise_id": 11,
    *                                                        "muscle_id": 1
    *                                                    }
    *                                                }
    *                                            }
    *                                        }
    *                                    },
    *                                    {
    *                                        "id": 383,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 23,
    *                                        "exercise_id": 13,
    *                                        "pivot": {
    *                                            "routine_id": 2,
    *                                            "set_id": 383
    *                                        },
    *                                        "exercise": {
    *                                            "id": 13,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "name": "Puente de Glúteos",
    *                                            "description": "Hic commodi dolor dolores aut. Illo rerum temporibus sit et assumenda ipsum est. Unde ea voluptatem dolorum saepe.",
    *                                            "videoURL": "https://www.youtube.com/embed/szgXdRA2R6Y",
    *                                            "muscles": {
    *                                                {
    *                                                    "id": 6,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Isquiotibiales",
    *                                                    "bodypart": "Pierna",
    *                                                    "pivot": {
    *                                                        "exercise_id": 13,
    *                                                        "muscle_id": 6
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 7,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Glúteos",
    *                                                    "bodypart": "Pierna",
    *                                                    "pivot": {
    *                                                        "exercise_id": 13,
    *                                                        "muscle_id": 7
    *                                                    }
    *                                                }
    *                                            }
    *                                        }
    *                                    }
    *                                },
    *                                "comments": {}
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
     *         description="Error en la validación"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error añadiendo rating"
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function addRating(Request $request, Routine $routine)
    {

        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric'
        ]);

        if($validator->fails()){
                return $this->errorResponse($validator->errors()->toJson(), 400);
        }

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

    /**
     * @OA\Post(
     *     path="/api/routines/{id}/visualization",
     *     summary="Añadir visualización",
     *     tags={"Rutinas"},
     *     @OA\Response(
     *         response=201,
     *         description="OK. Añade una visualización. Devuelve la rutina actualizada",
     *         @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                       {
    *                            "status": 201,
    *                            "message": "Visualización añadida con éxito",
    *                            "data": {
    *                                "id": 2,
    *                                "created_at": "2021-05-31T21:11:08.000000Z",
    *                                "updated_at": "2021-06-01T11:22:27.000000Z",
    *                                "user_id": 5,
    *                                "name": "Tempore quasi tenetur minus necessitatibus dolorum consequatur.",
    *                                "description": "Illo voluptas expedita excepturi omnis assumenda perferendis pariatur delectus. Rerum rem maiores delectus id consequuntur similique deleniti magnam. Totam qui rerum corrupti explicabo est. Commodi optio dolor iusto quod recusandae. Corporis deleniti assumenda veritatis sunt aut totam. Quisquam repudiandae consequatur voluptatibus iusto dignissimos. Odio ut quisquam blanditiis ratione. Enim eaque eveniet velit provident sint dolor. Aut sunt repellendus facere illum placeat voluptatem quia. Numquam est reprehenderit blanditiis sit cupiditate optio. Sapiente quis id soluta molestias non dicta omnis. Commodi velit doloremque et non dignissimos omnis. Voluptatem et et et aliquid. Laborum libero dicta consequatur neque optio enim at voluptates. Inventore suscipit cum facilis optio pariatur blanditiis. Necessitatibus tempore nesciunt nostrum neque. Debitis natus consequatur dicta. Ut qui minima quia aut quis eos est.",
    *                                "visualizations": 1662,
    *                                "rating": 4,
    *                                "bodyparts": {
    *                                    "Brazo",
    *                                    "Pierna"
    *                                },
    *                                "categories": {
    *                                    6
    *                                },
    *                                "similar": {
    *                                    2,
    *                                    11
    *                                },
    *                                "sets": {
    *                                    {
    *                                        "id": 314,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 14,
    *                                        "exercise_id": 11,
    *                                        "pivot": {
    *                                            "routine_id": 2,
    *                                            "set_id": 314
    *                                        },
    *                                        "exercise": {
    *                                            "id": 11,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "name": "Curl de Bíceps",
    *                                            "description": "Quidem magnam modi et incidunt sed facilis. Sapiente aut nulla dolorum. Rerum non enim est error iure.",
    *                                            "videoURL": "https://www.youtube.com/embed/tMEGqKuOa-M",
    *                                            "muscles": {
    *                                                {
    *                                                    "id": 1,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Bíceps",
    *                                                    "bodypart": "Brazo",
    *                                                    "pivot": {
    *                                                        "exercise_id": 11,
    *                                                        "muscle_id": 1
    *                                                    }
    *                                                }
    *                                            }
    *                                        }
    *                                    },
    *                                    {
    *                                        "id": 383,
    *                                        "created_at": "2021-05-31T21:11:08.000000Z",
    *                                        "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                        "repetitions": 23,
    *                                        "exercise_id": 13,
    *                                        "pivot": {
    *                                            "routine_id": 2,
    *                                            "set_id": 383
    *                                        },
    *                                        "exercise": {
    *                                            "id": 13,
    *                                            "created_at": "2021-05-31T21:11:08.000000Z",
    *                                            "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                            "name": "Puente de Glúteos",
    *                                            "description": "Hic commodi dolor dolores aut. Illo rerum temporibus sit et assumenda ipsum est. Unde ea voluptatem dolorum saepe.",
    *                                            "videoURL": "https://www.youtube.com/embed/szgXdRA2R6Y",
    *                                            "muscles": {
    *                                                {
    *                                                    "id": 6,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Isquiotibiales",
    *                                                    "bodypart": "Pierna",
    *                                                    "pivot": {
    *                                                        "exercise_id": 13,
    *                                                        "muscle_id": 6
    *                                                    }
    *                                                },
    *                                                {
    *                                                    "id": 7,
    *                                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                                    "name": "Glúteos",
    *                                                    "bodypart": "Pierna",
    *                                                    "pivot": {
    *                                                        "exercise_id": 13,
    *                                                        "muscle_id": 7
    *                                                    }
    *                                                }
    *                                            }
    *                                        }
    *                                    }
    *                                },
    *                                "comments": {}
    *                            }
    *                        }
    *                  ),     
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="OK. No autorizado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error"
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function addVisualization(Request $request, Routine $routine)
    {


        try {

            $routine->increment('visualizations');

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

        
            return $this->successResponse($routine, 'Visualización añadida con éxito', 201);
        } catch (Exception $e) {
            return $this->errorResponse('Ha habido un error añadiendo tu visualización', 500);
        }
    }
}
