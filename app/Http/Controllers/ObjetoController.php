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
    



      /**
     * Obtener los objetos (trash) de un usuario y calcular el total.
     *
     * @OA\Get(
     *     path="/objetos/getTrash/{user_id}",
     *     summary="Obtener los objetos de un usuario y calcular el total",
     *     description="Devuelve una lista de objetos asociados a un usuario y el total de sus valores",
     *     tags={"Objetos"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="ID del usuario",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="trash",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="nombre", type="string", example="Objeto 1"),
     *                     @OA\Property(property="valor", type="number", format="float", example=99.99)
     *                 )
     *             ),
     *             @OA\Property(property="total", type="number", format="float", example=150.49)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *         )
     *     )
     * )
     */

    // Método para obtener todos los objetos
    public function getTrash($id)
    {
        // Filtrar los objetos por el user_id
        $objetos = Objeto::where('user_id', $id)->orderby('id', 'desc')->get();

        // Mapear los datos al formato requerido
        $trash = $objetos->map(function ($objeto) {
            return [
                'nombre' => $objeto->nombre,
                'valor' => $objeto->valor,
            ];
        });

        // Calcular el total de los valores
        $total = $objetos->sum('valor');

        return response()->json([
            'success' => true,
            'trash' => $trash,
            'total' => $total,
        ]);
    }
   
    }

