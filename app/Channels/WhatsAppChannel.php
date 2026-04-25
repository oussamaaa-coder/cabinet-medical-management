<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            return;
        }

        $message = $notification->toWhatsApp($notifiable);
        
        // Get the phone number. We assume $notifiable has a 'phone' attribute
        // or uses routeNotificationFor('whatsapp')
        $to = $notifiable->routeNotificationFor('whatsapp', $notification) ?? $notifiable->phone;

        if (!$to) {
            return;
        }

        // --- EXEMPLE AVEC TWILIO API ---
        // Twilio attend le format "whatsapp:+1234567890"
        if (!str_starts_with($to, 'whatsapp:')) {
            // Nettoyage du numéro et ajout du '+' si nécessaire
            $cleanPhone = '+' . ltrim(preg_replace('/[^0-9]/', '', $to), '+');
            $to = "whatsapp:" . $cleanPhone;
        }

        $from = "whatsapp:" . env('TWILIO_WHATSAPP_NUMBER'); // ex: whatsapp:+14155238886
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');

        if (!$sid || !$token || !$from) {
            Log::info("--- TEST WHATSAPP (Pas de clés configurées) ---");
            Log::info("Destinataire : " . $to);
            Log::info("Message :\n" . $message);
            Log::info("-------------------------------------------------");
            return;
        }

        $response = Http::withBasicAuth($sid, $token)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                'From' => $from,
                'To' => $to,
                'Body' => $message,
            ]);

        if ($response->failed()) {
            Log::error('Erreur envoi WhatsApp: ' . $response->body());
        }
    }
}
