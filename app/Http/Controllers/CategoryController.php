<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/categories",
    *     summary="Obtener categories",
    *     tags={"Categorías"},
    *     @OA\Response(
    *         response=200,
    *         description="Obtener todas las categorías.",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                       {
    *                            "status": 200,
    *                            "message": 200,
    *                            "data": {
    *                                {
    *                                    "id": 1,
    *                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                    "name": "Principiante"
    *                                },
    *                                {
    *                                    "id": 2,
    *                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                    "name": "Intermedio"
    *                                },
    *                                {
    *                                    "id": 3,
    *                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                    "name": "Avanzado"
    *                                },
    *                                {
    *                                    "id": 4,
    *                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                    "name": "Ligero"
    *                                },
    *                                {
    *                                    "id": 5,
    *                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                    "name": "Intenso"
    *                                },
    *                                {
    *                                    "id": 6,
    *                                    "created_at": "2021-05-31T21:11:07.000000Z",
    *                                    "updated_at": "2021-05-31T21:11:07.000000Z",
    *                                    "name": "Rápido"
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
        $categories = Category::all();
        return $this->successResponse($categories, 200);
    }

}
