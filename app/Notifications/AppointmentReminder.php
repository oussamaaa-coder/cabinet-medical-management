<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class AppointmentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', \App\Channels\WhatsAppChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $date = \Carbon\Carbon::parse($this->appointment->date)->format('d/m/Y');
        $time = \Carbon\Carbon::parse($this->appointment->start_time)->format('H:i');
        $doctorName = $this->appointment->doctor->first_name . ' ' . $this->appointment->doctor->last_name;

        return (new MailMessage)
            ->subject('Rappel de votre rendez-vous médical')
            ->greeting('Bonjour ' . $this->appointment->patient->first_name . ',')
            ->line('Ceci est un rappel pour votre prochain rendez-vous.')
            ->line('Date : ' . $date)
            ->line('Heure : ' . $time)
            ->line('Médecin : Dr. ' . $doctorName)
            ->action('Voir mes rendez-vous', url('/'))
            ->line('Merci de nous prévenir en cas d\'empêchement.');
    }

    /**
     * Get the WhatsApp representation of the notification.
     */
    public function toWhatsApp(object $notifiable): string
    {
        $date = \Carbon\Carbon::parse($this->appointment->date)->format('d/m/Y');
        $time = \Carbon\Carbon::parse($this->appointment->start_time)->format('H:i');
        $doctorName = $this->appointment->doctor->first_name . ' ' . $this->appointment->doctor->last_name;

        return "Bonjour {$this->appointment->patient->first_name},\n\nCeci est un rappel pour votre rendez-vous médical.\n\n📅 *Date :* {$date}\n⏰ *Heure :* {$time}\n👨‍⚕️ *Médecin :* Dr. {$doctorName}\n\nMerci de nous prévenir en cas d'empêchement.";
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $date = \Carbon\Carbon::parse($this->appointment->date)->format('d/m/Y');
        $time = \Carbon\Carbon::parse($this->appointment->start_time)->format('H:i');
        return [
            'appointment_id' => $this->appointment->id,
            'message' => "Rappel de rendez-vous le {$date} à {$time}",
            'type' => 'appointment_reminder'
        ];
    }
}
