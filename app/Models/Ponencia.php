<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ponencia extends Model
{
    //
    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'fecha_ponencia',
        'horario_ponencia',
        'nivel',
        'archivo',
        'aprobada'
    ];

    protected $casts = [
        'fecha_ponencia' => 'date',
        'aprobada' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor para fecha y hora combinadas
    public function getFechaHoraPonenciaAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['fecha_ponencia'] . ' ' . $this->horario_ponencia)
            ->format('d/m/Y H:i');
    }

    // Scope para ponencias aprobadas
    public function scopeAprobadas($query)
    {
        return $query->where('aprobada', true);
    }

    // Scope para ponencias pendientes
    public function scopePendientes($query)
    {
        return $query->where('aprobada', false);
    }
}
