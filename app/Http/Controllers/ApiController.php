<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
/**
 * @OA\Info(
 *     title="API Register",
 *     version="1.0.0"
 *     description="Registro"
 * )
 * 
 *              @OA\Server(url="http://127.0.0.1:8000")
 */
class ApiController extends Controller
{
      /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar un usuario",
     *     description="Registra un nuevo usuario en el sistema.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="johndoe@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation error")
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
       $name = $request->name ;
       $email = $request->email;
       $password =Hash::make($request->password); 

       $user = User::create([
        'name'=> $name,
        'email'=> $email,
        'password'=>Hash::make($password),
       ]);

       return response()->json([
        'message'=>'Usuario registrado exitosamente',
        'data'=> $user
       ],200);


    }
}
