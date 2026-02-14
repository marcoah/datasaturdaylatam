<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\EmailHistory;

class MailService
{
    /**
     * Envía un email con tracking automático de errores
     *
     * @param \Illuminate\Mail\Mailable $mailable
     * @param string|array $to
     * @return bool
     */
    public function send($mailable, $to)
    {
        try {
            Mail::to($to)->send($mailable);
            return true;
        } catch (\Exception $e) {
            $this->logFailedEmail($mailable, $to, $e);
            Log::error('Error enviando email: ' . $e->getMessage(), [
                'mailable' => get_class($mailable),
                'to' => $to,
            ]);
            return false;
        }
    }

    /**
     * Envía un email y lanza excepción si falla
     */
    public function sendOrFail($mailable, $to)
    {
        try {
            Mail::to($to)->send($mailable);
        } catch (\Exception $e) {
            $this->logFailedEmail($mailable, $to, $e);
            throw $e;
        }
    }

    /**
     * Registra un email fallido en la base de datos
     */
    protected function logFailedEmail($mailable, $to, \Exception $e)
    {
        try {
            // Normalizar destinatarios
            $recipients = is_array($to) ? $to : [$to];
            $normalizedRecipients = array_map(function ($recipient) {
                if (is_object($recipient)) {
                    return $recipient->email ?? (string) $recipient;
                }
                return $recipient;
            }, $recipients);

            // Obtener subject si está disponible
            $subject = 'Sin asunto';
            if (method_exists($mailable, 'build')) {
                $built = $mailable->build();
                $subject = $built->subject ?? $mailable->subject ?? 'Sin asunto';
            } elseif (property_exists($mailable, 'subject')) {
                $subject = $mailable->subject;
            }

            EmailHistory::create([
                'mailable_class' => get_class($mailable),
                'subject' => $subject,
                'from_email' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
                'to' => $normalizedRecipients,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'sent_at' => now(),
            ]);
        } catch (\Exception $logError) {
            Log::error('Error al registrar email fallido: ' . $logError->getMessage());
        }
    }

    /**
     * Queue un email con tracking
     */
    public function queue($mailable, $to)
    {
        try {
            Mail::to($to)->queue($mailable);
            return true;
        } catch (\Exception $e) {
            $this->logFailedEmail($mailable, $to, $e);
            Log::error('Error encolando email: ' . $e->getMessage());
            return false;
        }
    }
}
