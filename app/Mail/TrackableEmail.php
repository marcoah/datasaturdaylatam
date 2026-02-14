<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use App\Models\EmailHistory;

/**
 * Trait para agregar a tus Mailables y capturar errores
 *
 * Uso:
 * class TuMailable extends Mailable {
 *     use TrackableEmail;
 * }
 */
trait TrackableEmail
{
    public function send($mailer)
    {
        try {
            return parent::send($mailer);
        } catch (\Exception $e) {
            // Registrar el email fallido
            $this->logFailedEmail($e);

            // Re-lanzar la excepción
            throw $e;
        }
    }

    protected function logFailedEmail(\Exception $e)
    {
        try {
            $to = [];
            if (isset($this->to) && is_array($this->to)) {
                $to = array_map(function ($recipient) {
                    return is_object($recipient) ? $recipient->email : $recipient;
                }, $this->to);
            }

            EmailHistory::create([
                'mailable_class' => get_class($this),
                'subject' => $this->subject ?? 'Sin asunto',
                'from_email' => $this->from[0]['address'] ?? config('mail.from.address'),
                'from_name' => $this->from[0]['name'] ?? config('mail.from.name'),
                'to' => $to,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'sent_at' => now(),
            ]);
        } catch (\Exception $logError) {
            Log::error('Error al registrar email fallido: ' . $logError->getMessage());
        }
    }
}
