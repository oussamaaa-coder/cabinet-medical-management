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
        $apiKey = config('services.gemini.key');

        if (!$apiKey) {
            return response()->json(['reply' => 'Erreur: Clé API non configurée.'], 500);
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(60)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => $apiKey,
                ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Tu es 'L'Assistant MediCal', un secrétaire médical intelligent et ultra-bienveillant pour un cabinet à Casablanca.
                            Ton but est de rendre la prise de rendez-vous (RDV) possible même pour quelqu'un qui n'a jamais utilisé d'ordinateur.

                            RÈGLES D'OR :
                            1. ACCESSIBILITÉ : Parle en Français ET/OU en Darija (Arabe Marocain) selon la langue du patient. Sois très simple.
                            2. CONCIERGE : Ne dis pas 'allez sur la page X'. Pose des questions une par une :
                            - 'Quel est votre problème de santé ?'
                            - 'Préférez-vous venir le matin ou l'après-midi ?'
                            3. RDV : Quand le patient est prêt, propose-lui de cliquer sur le bouton 'Prendre RDV' ou guide-le pour créer son compte.
                            4. INFOS : (Horaires: Lun-Ven 9h-18h, Sam 9h-13h. Prix: 200-500 DH. Adresse: 123 Avenue de la Santé, Casablanca).
                            5. URGENCE : Si douleur poitrine/respiration -> Dit 'Appelez le 15' immédiatement en gras.

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

            $errorData = $response->json();
            $errorMessage = $errorData['error']['message'] ?? "Erreur inconnue";

            Log::error('Gemini API Error Status: ' . $response->status());
            Log::error('Gemini API Error Body: ' . $response->body());

            return response()->json([
                'reply' => "Désolé, j'ai rencontré une erreur technique (Status: " . $response->status() . "). " . $errorMessage
            ], 500);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json(['reply' => "Une erreur est survenue lors de la communication avec l'IA."], 500);
        }
    }
}
