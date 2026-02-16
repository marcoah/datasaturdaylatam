<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paseo extends Model
{
    //
    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
        'ubicacion',
        'fecha_inicio',
        'hora_inicio',
        'fecha_fin',
        'hora_fin',
        'url_1',
        'url_2',
        'btn_1',
        'btn_2',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function getFechaHoraInicioAttribute()
    {
        return $this->fecha_inicio->format('d/m/Y') . ' ' .
            \Carbon\Carbon::parse($this->hora_inicio)->format('H:i');
    }

    public function getFechaHoraFinAttribute()
    {
        if (is_null($this->fecha_fin) || is_null($this->hora_fin)) {
            return 'N/A';
        }

        return $this->fecha_fin->format('d/m/Y') . ' ' .
            \Carbon\Carbon::parse($this->hora_fin)->format('H:i');
    }

    public function getEstadoAttribute()
    {
        $hoy = \Carbon\Carbon::now();
        $inicio = \Carbon\Carbon::parse($this->attributes['fecha_inicio'] . ' ' . $this->attributes['hora_inicio']);
        $diferencia = $hoy->diffInDays($inicio, false);

        if ($diferencia >= 0 && $diferencia <= 7) {
            return 'proximo';
        } elseif ($diferencia < 0 && $diferencia >= -1) {
            return 'en_curso';
        }

        return null;
    }
}
