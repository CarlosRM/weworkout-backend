<?php

namespace App\Http\Controllers;
use App\Http\Traits\ApiResponser;
use Illuminate\Http\Request;

/**
* @OA\Info(title="WeWorkout API", version="1.0", description="Documentación de la API del backend de la aplicación WeWorkout. La mayoría de llamadas utilizan autenticación mediante JWT. Se incluyen ejemplos de request y de response.")
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

/**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="apiAuth",
 * )
 */
class ApiController extends Controller
{
    
    use ApiResponser;
}
