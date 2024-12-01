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
                        "text" => '¿Qué hay en esta imagen? Clasifica como orgánico o inorgánico, y dame un puntaje ambiental (0 a 1, usando decimales base a 100, por ejemplo "0.45") sobre el impacto de reciclarlo. Además, devuélveme una descripción super breve y detallada en máximo 3 palabras de lo que hay en la imagen. Solo me tienes que regresar un JSON de esta manera: {"name": "bolsa de papel", "classification": 0.45, "type": "orgánico"}.'
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
