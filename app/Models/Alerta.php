<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $fillable = [
        'user_id',
        'titulo',
        'mensaje',
        'mensaje_adicional',
        'tipo',
        'activa',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $casts = [
        'activa' => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    // Relación con usuario (destinatario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación muchos a muchos con usuarios que han leído la alerta
    public function usuariosQueHanLeido()
    {
        return $this->belongsToMany(User::class, 'alerta_user')
            ->withTimestamps()
            ->withPivot('leida_en');
    }

    // Verificar si un usuario ha leído la alerta
    public function fueLeida($userId)
    {
        return $this->usuariosQueHanLeido()->where('user_id', $userId)->exists();
    }

    // Marcar como leída por un usuario
    public function marcarComoLeida($userId)
    {
        if (!$this->fueLeida($userId)) {
            $this->usuariosQueHanLeido()->attach($userId, [
                'leida_en' => now()
            ]);
        }
    }

    // Scope para alertas activas
    public function scopeActivas($query)
    {
        return $query->where('activa', true)
            ->where(function ($q) {
                $q->whereNull('fecha_inicio')
                    ->orWhere('fecha_inicio', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('fecha_fin')
                    ->orWhere('fecha_fin', '>=', now());
            });
    }

    // Scope para alertas de un usuario específico
    public function scopeParaUsuario($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->whereNull('user_id')  // Alertas globales
                ->orWhere('user_id', $userId); // Alertas específicas del usuario
        });
    }

    // Scope para alertas no leídas por un usuario
    public function scopeNoLeidas($query, $userId)
    {
        return $query->whereDoesntHave('usuariosQueHanLeido', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    // Scope para alertas globales
    public function scopeGlobales($query)
    {
        return $query->whereNull('user_id');
    }
}
