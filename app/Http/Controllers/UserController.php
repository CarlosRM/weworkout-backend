<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Routine;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class UserController extends ApiController
{
/**
    * @OA\Get(
    *     path="/api/users",
    *     summary="Mostrar usuarios",
    *     tags={"Usuarios"},
    *     @OA\Response(
    *         response=200,
    *         description="Mostrar todos los usuarios.",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                    {
    *                        "status": 200,
    *                        "message": 200,
    *                        "data": {
    *                            {
    *                                "id": 1,
    *                                "name": "Tony Stark",
    *                                "email": "ironman@avengers.com",
    *                                "email_verified_at": "2021-05-31T21:11:08.000000Z",
    *                                "birthdate": "2013-05-31T00:00:00.000000Z",
    *                                "genre": "Hombre",
    *                                "description": "HOMBRE DE ACERO. Genio. Multimillonario. Filántropo. La confianza de Tony Stark solo se compara con sus habilidades de alto vuelo como el héroe llamado Iron Man.",
    *                                "created_at": "2021-05-31T21:11:08.000000Z",
    *                                "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                "followers": {
    *                                    6
    *                                },
    *                                "followees": {},
    *                                "routines": {
    *                                    1,
    *                                    4,
    *                                    22,
    *                                    27,
    *                                    35,
    *                                    38
    *                                },
    *                                "favourite_routines": {
    *                                    1,
    *                                    2
    *                                }
    *                            },
    *                            {
    *                                "id": 2,
    *                                "name": "rreynolds",
    *                                "email": "mckenzie.rita@example.org",
    *                                "email_verified_at": "2021-05-31T21:11:08.000000Z",
    *                                "birthdate": "1994-05-12T05:56:26.000000Z",
    *                                "genre": "Hombre",
    *                                "description": "Explicabo vel consequatur sunt magnam dolores commodi eaque. Deserunt ut in molestiae et voluptatem et libero. Asperiores veritatis aut laborum autem. Officiis temporibus enim ratione vel.",
    *                                "created_at": "2021-05-31T21:11:08.000000Z",
    *                                "updated_at": "2021-05-31T21:11:08.000000Z",
    *                                "followers": {
    *                                    3,
    *                                    5
    *                                },
    *                                "followees": {
    *                                    5,
    *                                    11
    *                                },
    *                                "routines": {
    *                                    16,
    *                                    20,
    *                                    30,
    *                                    37
    *                                },
    *                                "favourite_routines": {
    *                                    3
    *                                }
    *                            }
    *                        }
    *                    }
    *                  ),     
    *              ),
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
    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Crear usuario",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="genre",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="birthdate",
     *                     type="string"
     *                 ),
     *                 example = {
     *                       "name": "test2",
     *                       "email": "test2@test2.com",
     *                       "genre": "Hombre",
     *                       "password": "43211234",
     *                       "birthdate": "1996-05-17 00:00:00"
     *                  }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK. Crea un usuario",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              example=
     *                       {
     *                           "status": 200,
     *                           "message": "Registro completado con éxito. Inicia sesión para continuar",
     *                           "data": {
     *                               "name": "test2222",
     *                               "email": "test2222@test2.com",
     *                               "birthdate": "1996-05-17T00:00:00.000000Z",
     *                               "genre": "Hombre",
     *                               "updated_at": "2021-06-01T08:08:02.000000Z",
     *                               "created_at": "2021-06-01T08:08:02.000000Z",
     *                               "id": 12
     *                           }
     *                       },
     *                  ),     
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error creando usuario"
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);

        if($validator->fails()){
                return $this->errorResponse($validator->errors()->toJson(), 400);
        }

        try {
            $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'birthdate' => $request->get('birthdate'),
            'genre' => $request->get('genre'),
            'password' => Hash::make($request->get('password')),
        ]);
        } catch(\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('Ha habido un error en el registro', 500);
        }

        return $this->successResponse($user, 'Registro completado con éxito. Inicia sesión para continuar', 200);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *    description="ID of user",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     summary="Actualizar Usuario",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="genre",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="birthdate",
     *                     type="string"
     *                 ),
     *                 example = {
     *                       "name": "Cpt America",
     *                       "email": "ironman@vengadores.com",
     *                       "genre": "Hombre",
     *                       "birthdate": "1996-05-17 00:00:00"
     *                  }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK. Actualiza el usuario",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              example=
     *                       {
     *                           "status": 200,
     *                           "message": "Usuario editado con éxito",
     *                           "data": {
     *                               "id": 1,
     *                               "name": "Carlos",
     *                               "email": "ironman@avengers.com",
     *                               "email_verified_at": "2021-05-31T21:11:08.000000Z",
     *                               "birthdate": "1996-05-17T00:00:00.000000Z",
     *                               "genre": "Hombre",
     *                               "description": "Desc ejemplo",
     *                               "created_at": "2021-05-31T21:11:08.000000Z",
     *                               "updated_at": "2021-06-01T08:19:45.000000Z",
     *                               "favourite_routines": {
     *                                   5,
     *                                   31
     *                               },
     *                               "followers": {
     *                                   6
     *                               },
     *                               "followees": {},
     *                               "routines": {
     *                                   1,
     *                                   4,
     *                                   22,
     *                                   27,
     *                                   35,
     *                                   38
     *                               }
     *                           }
     *                       },
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
     *         description="Error actualizando el usuario"
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->id != $user->id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'genre' => 'required|string',
            'birthdate' => 'required|string|date_format:Y-m-d H:i:s'
        ]);

        if($validator->fails()){
                return $this->errorResponse($validator->errors()->toJson(), 400);
        }

        try {
            $user->update($request->all());
            $user->favourite_routines = $user->favouriteRoutines()->pluck('routine_id')->toArray();
            $user->followers = $user->followers()->pluck('follower')->toArray();
            $user->followees = $user->followees()->pluck('followee')->toArray();
            $user->routines = $user->routines()->pluck('id')->toArray();
        } catch(\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('Ha habido un error en el registro', 500);
        }

        return $this->successResponse($user, 'Usuario editado con éxito', 200);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{userId}/addFavorite/{routineId}",
     *     summary="Añadir rutina favorita",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *    description="ID of user",
     *    in="path",
     *    name="userId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     @OA\Parameter(
     *    description="ID of routine",
     *    in="path",
     *    name="routineId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK. Añade una rutina favorita",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              example=
     *                      {
     *                      "status": 200,
     *                      "message": "Rutina añadida a Favoritos con éxito",
     *                      "data": {
     *                          "id": 3,
     *                          "created_at": "2021-05-29T11:24:12.000000Z",
     *                          "updated_at": "2021-05-31T18:59:52.000000Z",
     *                          "user_id": 8,
     *                          "name": "Expedita ut doloremque facere quis accusantium praesentium.",
     *                          "description": "Consequatur a ut magnam corporis consectetur. Iure magni et error minus. In fugiat magnam aut. Dolor optio sed doloremque pariatur repellendus perspiciatis. Quasi consectetur consequatur eos mollitia. Et nam aut quisquam quibusdam aut. Dolor tempore quia qui ullam. Impedit voluptatem blanditiis consequatur repudiandae culpa. Qui qui sapiente voluptas cumque iste. Fugiat ea non iure non. Et consectetur labore recusandae. Molestiae in modi corporis et. Pariatur nobis aut et odit reiciendis. Autem sint minus provident modi voluptatem rerum. Aut dolore ipsum aut necessitatibus. Sapiente optio rerum et ut distinctio et magnam. Qui ipsam quia ea et vero consectetur delectus. Laboriosam perspiciatis eius sint voluptatem quos eos. Iste id non aliquam sint voluptatibus doloribus. Ipsum ipsa sit qui exercitationem at. Ea numquam eius iste quas sunt. Praesentium sunt adipisci quibusdam suscipit a placeat.",
     *                          "visualizations": 594
     *                          }
     *                      },
     *                  ),     
     *              ),
     *     @OA\Response(
     *         response=409,
     *         description="Error. La rutina ya está en favoritos."
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
    public function addFavorite(Request $request, User $user, Routine $routine)
    {
        try  {
            $user->favouriteRoutines()->attach($routine->id);
        } catch(\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('La rutina ya está en favoritos', 409);
        }
        
        return $this->successResponse($routine, 'Rutina añadida a Favoritos con éxito', 200);
    }
    /**
     * @OA\Get(
     *     path="/api/users/{userId}/removeFavorite/{routineId}",
     *     summary="Eliminar rutina favorita",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *    description="ID of user",
     *    in="path",
     *    name="userId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     @OA\Parameter(
     *    description="ID of routine",
     *    in="path",
     *    name="routineId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK. Elimina una rutina favorita",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              example=
     *                      {
     *                      "status": 200,
     *                      "message": "Rutina eliminada de Favoritos con éxito",
     *                      "data": {
     *                          "id": 3,
     *                          "created_at": "2021-05-29T11:24:12.000000Z",
     *                          "updated_at": "2021-05-31T18:59:52.000000Z",
     *                          "user_id": 8,
     *                          "name": "Expedita ut doloremque facere quis accusantium praesentium.",
     *                          "description": "Consequatur a ut magnam corporis consectetur. Iure magni et error minus. In fugiat magnam aut. Dolor optio sed doloremque pariatur repellendus perspiciatis. Quasi consectetur consequatur eos mollitia. Et nam aut quisquam quibusdam aut. Dolor tempore quia qui ullam. Impedit voluptatem blanditiis consequatur repudiandae culpa. Qui qui sapiente voluptas cumque iste. Fugiat ea non iure non. Et consectetur labore recusandae. Molestiae in modi corporis et. Pariatur nobis aut et odit reiciendis. Autem sint minus provident modi voluptatem rerum. Aut dolore ipsum aut necessitatibus. Sapiente optio rerum et ut distinctio et magnam. Qui ipsam quia ea et vero consectetur delectus. Laboriosam perspiciatis eius sint voluptatem quos eos. Iste id non aliquam sint voluptatibus doloribus. Ipsum ipsa sit qui exercitationem at. Ea numquam eius iste quas sunt. Praesentium sunt adipisci quibusdam suscipit a placeat.",
     *                          "visualizations": 594
     *                          }
     *                      },
     *                  ),     
     *              ),
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
    public function removeFavorite(Request $request, User $user, Routine $routine)
    {
        try  {
            $user->favouriteRoutines()->detach($routine->id);
        } catch(\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('Error eliminando rutina de favoritos', 500);
        }
        return $this->successResponse($routine, 'Rutina eliminada de Favoritos con éxito', 200);
    }
    /**
     * @OA\Post(
     *     path="/api/users/{userId}/follow/{targetId}",
     *     summary="Seguir",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *    description="ID of user",
     *    in="path",
     *    name="userId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     @OA\Parameter(
     *    description="ID of target user",
     *    in="path",
     *    name="targetId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK. Sigue a un usuario",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              example=
     *                          {
     *                               "status": 200,
     *                               "message": "Usuario seguido con éxito",
     *                               "data": 10
     *                           }
     *                  ),     
     *              ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Ya sigues al usuario"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error"
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function follow(Request $request, User $user, User $followee) {

        if (Auth::user()->id != $user->id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        try {
            $user->followees()->attach($followee);
        } catch(\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1062) {
                return $this->errorResponse('Ya sigues a este usuario', 409);
            } else {
                return $this->errorResponse('Ha habido un error siguiendo a este usuario', 500);
            }
        }

        return $this->successResponse($followee->id, 'Usuario seguido con éxito', 200);
    }
    /**
     * @OA\Post(
     *     path="/api/users/{userId}/unfollow/{targetId}",
     *     summary="Dejar de seguir",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *    description="ID of user",
     *    in="path",
     *    name="userId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     @OA\Parameter(
     *    description="ID of target user",
     *    in="path",
     *    name="targetId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK. Deja de seguir a un usuario",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              example=
     *                          {
     *                               "status": 200,
     *                               "message": "Usuario dejado de seguir con éxito",
     *                               "data": 10
     *                           }
     *                  ),     
     *              ),
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
    public function unfollow(Request $request, User $user, User $followee) {

        if (Auth::user()->id != $user->id) {
            return response()->json(["msg" => "No autorizado"], 401);
        }

        try {
            $user->followees()->detach($followee);
        } catch(\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('Ha habido un error dejando de seguir a este usuario', 500);
        }

        return $this->successResponse($followee->id, 'Usuario dejado de seguir con éxito', 200);
    }

}
