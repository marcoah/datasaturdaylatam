<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailHistory extends Model
{
    protected $table = 'email_histories';

    protected $fillable = [
        'mailable_class',
        'subject',
        'from_email',
        'from_name',
        'to',
        'cc',
        'bcc',
        'body_html',
        'body_text',
        'attachments',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'to' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'attachments' => 'array',
        'sent_at' => 'datetime',
    ];

    // Scopes útiles
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('sent_at', '>=', now()->subDays($days));
    }

    public function scopeByMailable($query, $mailableClass)
    {
        return $query->where('mailable_class', $mailableClass);
    }

    // Accessor para mostrar el nombre corto de la clase
    public function getMailableNameAttribute()
    {
        return class_basename($this->mailable_class);
    }

    // Accessor para el primer destinatario
    public function getPrimaryRecipientAttribute()
    {
        return is_array($this->to) && count($this->to) > 0 ? $this->to[0] : null;
    }
}
