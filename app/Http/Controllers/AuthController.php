<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Inicia sesión",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "ironman@avengers.com", "password": "PepperPotts<3"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK. Devuelve el token y datos del usuario",
     *          @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                       {
    *                            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYyMjU0NzU5MywiZXhwIjoxNjIyNTUxMTkzLCJuYmYiOjE2MjI1NDc1OTMsImp0aSI6ImZsTDhVeVptc0pncFlIZDMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.qHb0koGvpInuyMlVWyazc7DxgFALfX0uFLzpi1H4KDg",
    *                            "token_type": "bearer",
    *                            "expires_in": 3600,
    *                            "user": {
    *                                "id": 1,
    *                                "name": "Carlos",
    *                                "email": "ironman@avengers.com",
    *                                "email_verified_at": "2021-05-31T21:11:08.000000Z",
    *                                "birthdate": "1996-05-17T00:00:00.000000Z",
    *                                "genre": "Hombre",
    *                                "description": "Desc ejemplo",
    *                                "created_at": "2021-05-31T21:11:08.000000Z",
    *                                "updated_at": "2021-06-01T08:19:45.000000Z",
    *                                "favourite_routines": {
    *                                    5,
    *                                    31
    *                                },
    *                                "followers": {
    *                                    6
    *                                },
    *                                "followees": {},
    *                                "routines": {
    *                                    4,
    *                                    22,
    *                                    27,
    *                                    35,
    *                                    38,
    *                                    41
    *                                }
    *                            }
    *                        }
    *                  ),     
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas"
     *     ),
     * )
     */
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {

            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/me",
     *     summary="Obtiene información del usuario",
     *     tags={"Autenticación"},
     *     @OA\Response(
     *         response=200,
     *         description="OK. Devuelve datos del usuario",
     *          @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                       {
    *                            "user": {
    *                                "id": 1,
    *                                "name": "Carlos",
    *                                "email": "ironman@avengers.com",
    *                                "email_verified_at": "2021-05-31T21:11:08.000000Z",
    *                                "birthdate": "1996-05-17T00:00:00.000000Z",
    *                                "genre": "Hombre",
    *                                "description": "Desc ejemplo",
    *                                "created_at": "2021-05-31T21:11:08.000000Z",
    *                                "updated_at": "2021-06-01T08:19:45.000000Z",
    *                                "favourite_routines": {
    *                                    5,
    *                                    31
    *                                },
    *                                "followers": {
    *                                    6
    *                                },
    *                                "followees": {},
    *                                "routines": {
    *                                    4,
    *                                    22,
    *                                    27,
    *                                    35,
    *                                    38,
    *                                    41
    *                                }
    *                           }
    *                       }
    *                  ),   
     *     ),
     *  security={{ "apiAuth": {} }}
     * )
     */
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(['user' => $this->getCurrentUser()], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Cierra sesión",
     *     tags={"Autenticación"},
     *     @OA\Response(
     *         response=200,
     *         description="OK. Cierra sesión",
     *           @OA\MediaType(
    *             mediaType="application/json",
    *              example=
    *                        {
    *                            "message": "Sesión cerrada con éxito"
    *                        }
    *                  ),   
     *     ),
     *  security={{ "apiAuth": {} }}
     * )
     */
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Sesión cerrada con éxito'], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $this->getCurrentUser()
        ], 200);
    }

    function getCurrentUser() {
        $user = User::find(auth()->user()->id);
        $user->favourite_routines = $user->favouriteRoutines()->pluck('routine_id')->toArray();
        $user->followers = $user->followers()->pluck('follower')->toArray();
        $user->followees = $user->followees()->pluck('followee')->toArray();
        $user->routines = $user->routines()->pluck('id')->toArray();
        return $user;
    }
}
