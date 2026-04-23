<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json(['reply' => 'Erreur: Clé API non configurée.'], 500);
        }

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Tu es l'assistant IA officiel du cabinet médical 'MediCal' à Casablanca (123 Avenue de la Santé). 
                            Tes objectifs : 
                            1. Aider à la prise de rendez-vous (diriger vers /register/patient).
                            2. Répondre aux FAQ (Horaires: Lun-Ven 9h-18h, Sam 9h-13h. Prix: 200-500 DH).
                            3. Faire un triage de base SANS donner de diagnostic final.
                            4. En cas de douleur à la poitrine ou difficulté respiratoire, ordonne d'appeler le 15 immédiatement.
                            5. Sois professionnel, bienveillant et concis. Réponds en Français.
                            
                            Question du patient : {$userMessage}"]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? "Désolé, je ne peux pas répondre pour le moment.";
                
                return response()->json(['reply' => $reply]);
            }

            Log::error('Gemini API Error Status: ' . $response->status());
            Log::error('Gemini API Error Body: ' . $response->body());
            return response()->json(['reply' => "Désolé, j'ai rencontré une erreur technique (Status: " . $response->status() . ")."], 500);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json(['reply' => "Une erreur est survenue lors de la communication avec l'IA."], 500);
        }
    }
}
