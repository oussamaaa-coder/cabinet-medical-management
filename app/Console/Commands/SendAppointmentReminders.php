<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Notifications\AppointmentReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-appointment-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email and database notifications for upcoming appointments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find appointments happening tomorrow
        $tomorrow = Carbon::tomorrow()->toDateString();

        $appointments = Appointment::where('date', $tomorrow)
            ->whereIn('status', ['planned', 'urgent'])
            ->with(['patient.user', 'doctor'])
            ->get();

        $count = 0;
        foreach ($appointments as $appointment) {
            if ($appointment->patient) {
                if ($appointment->patient->user) {
                    // Si le patient a un compte utilisateur
                    $appointment->patient->user->notify(new AppointmentReminder($appointment));
                    $count++;
                } elseif ($appointment->patient->email || $appointment->patient->phone) {
                    // Sinon, envoi "Anonyme" si un email ou numéro existe
                    $route = Notification::route('mail', $appointment->patient->email ?? null);
                    if ($appointment->patient->phone) {
                        $route->route('whatsapp', $appointment->patient->phone);
                    }
                    $route->notify(new AppointmentReminder($appointment));
                    $count++;
                }
            }
        }

        $this->info("Sent {$count} appointment reminders for {$tomorrow}.");
    }
}
