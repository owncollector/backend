<?php

namespace App\Http\Controllers;

use App\Services\OpenAIService;
use Illuminate\Http\Request;

class ImageAnalysisController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function analyze(Request $request)
    {
        $base64Image = $request->input('image'); // Asegúrate de enviar la imagen en base64 desde el frontend

        $result = $this->openAIService->analyzeImage($base64Image);

        return response()->json($result);
    }
}
