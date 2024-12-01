<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

/**
 * @OA\Info(
 *     title="API Register",
 *     version="1.0.0",
 *     description="Registro"
 * )
 * 
 * @OA\Server(url="http://127.0.0.1:8000")
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
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password); 

        $useremail = User::where('email', $email)->first(); 

        if ($useremail) {
            return response()->json([
                'message' => 'Ya hay un usuario registrado con este correo',
                'data' => ''
            ], 500);  
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'data' => $user
        ], 200);  
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Iniciar sesión",
     *     description="Permite a los usuarios iniciar sesión en la aplicación.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Inicio de sesión exitoso"),
     *             @OA\Property(property="data", type="object", additionalProperties={true})
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Inicio de sesión incorrecto"),
     *             @OA\Property(property="data", type="null")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password; // No hashees la contraseña aquí

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        // Verificar las credenciales
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Session::put([
                'user' => $user,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Inicio de sesión exitoso",
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Inicio de sesión incorrecto",
                'data' => null,
            ], 401);
        }
    }
}
