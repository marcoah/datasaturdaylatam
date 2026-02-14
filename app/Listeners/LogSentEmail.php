<?php

namespace App\Listeners;

use App\Models\EmailHistory;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class LogSentEmail
{
    public function handle(MessageSent $event): void
    {
        try {
            $message = $event->sent->getSymfonySentMessage()->getOriginalMessage();

            // Extraer destinatarios
            $to = [];
            if ($message->getTo()) {
                foreach ($message->getTo() as $address) {
                    $to[] = $address->getAddress();
                }
            }

            $cc = [];
            if ($message->getCc()) {
                foreach ($message->getCc() as $address) {
                    $cc[] = $address->getAddress();
                }
            }

            $bcc = [];
            if ($message->getBcc()) {
                foreach ($message->getBcc() as $address) {
                    $bcc[] = $address->getAddress();
                }
            }

            // Extraer información del remitente
            $from = $message->getFrom();
            $fromEmail = null;
            $fromName = null;

            if ($from && count($from) > 0) {
                $firstFrom = reset($from);
                $fromEmail = $firstFrom->getAddress();
                $fromName = $firstFrom->getName();
            }

            // Extraer attachments
            $attachments = [];
            foreach ($message->getAttachments() as $attachment) {
                $attachments[] = [
                    'name' => $attachment->getFilename() ?? $attachment->getName(),
                    'type' => $attachment->getContentType(),
                ];
            }

            // Obtener el cuerpo del email
            $bodyHtml = $message->getHtmlBody();
            $bodyText = $message->getTextBody();

            // Intentar obtener la clase del mailable de múltiples formas
            $mailableClass = $this->detectMailableClass($event);

            EmailHistory::create([
                'mailable_class' => $mailableClass,
                'subject' => $message->getSubject() ?? 'Sin asunto',
                'from_email' => $fromEmail ?? config('mail.from.address'),
                'from_name' => $fromName ?? config('mail.from.name'),
                'to' => $to,
                'cc' => !empty($cc) ? $cc : null,
                'bcc' => !empty($bcc) ? $bcc : null,
                'body_html' => $bodyHtml,
                'body_text' => $bodyText,
                'attachments' => !empty($attachments) ? $attachments : null,
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error guardando historial de email: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Detecta la clase del mailable de forma robusta
     */
    protected function detectMailableClass(MessageSent $event): string
    {
        // Opción 1: Buscar en event->data
        if (isset($event->data['__laravel_mailable'])) {
            $mailable = $event->data['__laravel_mailable'];
            if (is_object($mailable)) {
                return get_class($mailable);
            }
            if (is_string($mailable)) {
                return $mailable;
            }
        }

        // Opción 2: Buscar otras claves comunes
        if (isset($event->data['mailable']) && is_object($event->data['mailable'])) {
            return get_class($event->data['mailable']);
        }

        // Opción 3: Inspeccionar el evento completo
        if (is_object($event->sent)) {
            $reflection = new \ReflectionClass($event->sent);
            $properties = $reflection->getProperties();

            foreach ($properties as $property) {
                $property->setAccessible(true);
                $value = $property->getValue($event->sent);

                if (is_object($value) && strpos(get_class($value), 'App\\Mail\\') !== false) {
                    return get_class($value);
                }
            }
        }

        // Opción 4: Revisar el subject para deducir el tipo
        $message = $event->sent->getSymfonySentMessage()->getOriginalMessage();
        $subject = $message->getSubject() ?? '';

        // Aquí podrías agregar lógica para deducir el tipo basándote en el subject
        // Por ejemplo: if (str_contains($subject, 'Welcome')) return 'WelcomeMail';

        return 'Unknown';
    }
}
