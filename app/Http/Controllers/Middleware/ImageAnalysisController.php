<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;

class ImageAnalysisController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    /**
     * Analiza una imagen enviada como base64.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function analyze(Request $request)
    {
        $request->validate([
            'image' => 'required|base64_image', // Valida que sea una cadena base64 válida
        ]);

        $base64Image = $request->input('image');

        $result = $this->openAIService->analyzeImage($base64Image);

        return response()->json($result);
    }
}
