<?php

namespace App\Services;

use OpenAI\Client;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = Client::factory([
            'api_key' => env('OPENAI_API_KEY'),
        ]);
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
        $content = [
            [
                'role' => 'user',
                'content' => json_encode([
                    [
                        'type' => 'text',
                        'text' => '¿Qué hay en esta imagen? Clasifica como orgánico o inorgánico, y dame un puntaje ambiental (0 a 1, usando decimables base a 100, por ejemplo "0.45") sobre el impacto de reciclarlo. ademas devuelveme una descripcion super brebe y detallada en maximo 3 palabras de lo que hay en la imagen, solo me tienes que regresas un json de esta manera ejemplo: {"name: "bolsa de papel","classification": 0.45, "type": "organico" }',
                    ],
                    [
                        'type' => 'image_url',
                        'image_url' => [
                            'url' => "data:image/jpeg;base64,{$base64Image}",
                        ],
                    ],
                ]),
            ],
        ];

        // Realiza la solicitud a OpenAI
        $response = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => $content,
        ]);

        // Procesa la respuesta
        $message = $response['choices'][0]['message']['content'] ?? null;

        return $message ? json_decode($message, true) : ['error' => 'Error analyzing the image'];
    }
}
