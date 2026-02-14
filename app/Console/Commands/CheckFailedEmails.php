<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailHistory;

class CheckFailedEmails extends Command
{
    protected $signature = 'email:check-failures';
    protected $description = 'Verifica y registra emails que fallaron al enviarse';

    public function handle()
    {
        // Laravel guarda los emails fallidos en Mail::failures()
        $failures = Mail::failures();

        if (empty($failures)) {
            $this->info('No hay emails fallidos.');
            return;
        }

        foreach ($failures as $email) {
            EmailHistory::create([
                'mailable_class' => 'Unknown',
                'subject' => 'Email fallido',
                'from_email' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
                'to' => [$email],
                'status' => 'failed',
                'error_message' => 'El email no pudo ser enviado',
                'sent_at' => now(),
            ]);
        }

        $count = count($failures);
        $this->info("Se registraron {$count} emails fallidos.");
    }
}
