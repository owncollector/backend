<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        
    }

    /**
     * Procesa una imagen en base64 para analizar reciclaje y clasificación.
     *
     * @param string $base64Image La imagen codificada en base64.
     * @return array Resultado del análisis.
     */
    public function analyzeImage(string $base64Image): array
    {
        // Construye el contenido del mensaje
        $content = 
        [
            [
                "role" => "user",
                "content" => [
                    [
                        "type" => "text",
                        "text" => '¿Qué hay en esta imagen? Clasifica como orgánico o inorgánico (en ambos casos escribeme la respuesta sin acentos), y dame un puntaje ambiental (0 a 1, usando decimales base a 100, por ejemplo "0.45") sobre el impacto de reciclarlo. Además, devuélveme una descripción super breve y detallada en máximo 3 palabras de lo que hay en la imagen. Solo me tienes que regresar un JSON de esta manera: {"name": "bolsa de papel", "classification": 0.45, "type": "orgánico"}. esto es para una app que detectara los tipos de clasificacion de basura, enfocate especificamente en ese elemento de la foto, si no detectas nada que no sea enfocado en basura solo coloca "no se encontro coindicencia con algun tipo de basura" dentro de "nombre", considera que la imagen esta tomada sobre una base de carton entonces es importante que no me reespondas nunca que detectaste carton'
                    ],
                    [
                        "type" => "image_url",
                        "image_url" => [
                            "url" => $base64Image
                        ]
                    ]
                ]
            ]
        ];
        info($base64Image);
        // Realiza la solicitud a OpenAI
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => $content,
        ]);

        info(json_encode($response));
        // Procesa la respuesta
        $message = $response['choices'][0]['message']['content'] ?? null;

        if ($message) {
            // Limpia el mensaje para extraer solo el JSON
            $jsonStart = strpos($message, '{');
            $jsonEnd = strrpos($message, '}');

            if ($jsonStart !== false && $jsonEnd !== false) {
                $jsonString = substr($message, $jsonStart, $jsonEnd - $jsonStart + 1);
                $decodedJson = json_decode($jsonString, true);

                if ($decodedJson) {
                    return $decodedJson; // Retorna el JSON decodificado como un array asociativo
                }
            }
        }

        return ['error' => 'Error extracting JSON'];
    }
}
