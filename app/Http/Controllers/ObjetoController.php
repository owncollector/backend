<?php

namespace App\Http\Controllers;

use App\Models\Objeto;
use Illuminate\Http\Request;

class ObjetoController extends Controller
{


    /**
     * @OA\Post(
     *     path="/api/objetos",
     *     summary="Crear un nuevo objeto",
     *     description="Endpoint para crear un nuevo objeto en el sistema.",
     *     tags={"Objetos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "nombre", "valor"},
     *             @OA\Property(property="user_id", type="integer", example=1, description="ID del usuario al que pertenece el objeto"),
     *             @OA\Property(property="nombre", type="string", example="Ejemplo de Objeto", description="Nombre del objeto"),
     *             @OA\Property(property="valor", type="number", format="float", example=99.99, description="Valor del objeto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Objeto creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Datos Registrados"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Ejemplo de Objeto"),
     *                 @OA\Property(property="valor", type="number", format="float", example=99.99),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-01T00:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-01T00:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la solicitud",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Faltan datos requeridos"),
     *             @OA\Property(property="data", type="null")
     *         )
     *     )
     * )
     */

    // Método para crear un nuevo objeto
    public function store(Request $request)
    {
        // Depurar para verificar los datos que llegan en la solicitud
        logger()->info('Datos recibidos:', $request->all());
    
        // Extraer los datos directamente del request
        $user_id = $request->user_id;
        $nombre = $request->nombre;
        $valor = $request->valor;
    
        // Verificar que todos los campos estén presentes
        if (!$user_id || !$nombre || !$valor) {
            return response()->json([
                'message' => 'Faltan datos requeridos',
                'data' => null
            ], 400); // Respuesta de error
        }
    
        // Crear el objeto
        $objeto = Objeto::create([
            'user_id' => $user_id,
            'nombre' => $nombre,
            'valor' => $valor,
        ]);
    
        // Respuesta exitosa
        return response()->json([
            'message' => 'Datos Registrados',
            'data' => $objeto
        ], 200);
    }
    




    // Método para obtener todos los objetos
    public function index()
    {
        // Obtener todos los objetos incluyendo el user_id
        $objetos = Objeto::select('id', 'user_id', 'nombre', 'valor')->get();

        return response()->json([
            'success' => true,
            'data' => $objetos,
        ]);
    }

   
    }

