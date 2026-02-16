<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $fillable = [
        'titulo',
        'contenido',
        'imagen',
        'publicada',
        'fecha_publicacion'
    ];

    protected $casts = [
        'publicada' => 'boolean',
        'fecha_publicacion' => 'datetime',
    ];

    // Scope para noticias publicadas
    public function scopePublicadas($query)
    {
        return $query->where('publicada', true)
            ->whereNotNull('fecha_publicacion')
            ->where('fecha_publicacion', '<=', now());
    }

    // Scope para ordenar por más reciente
    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_publicacion', 'desc');
    }
}
