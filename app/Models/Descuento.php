<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Descuento extends Model
{
    //
    protected $fillable = [
        'codigo',
        'user_id',
        'porcentaje',
        'monto_fijo',
        'tipo',
        'usado',
        'activo',
        'fecha_inicio',
        'fecha_expiracion',
        'usado_en'
    ];

    protected $casts = [
        'usado' => 'boolean',
        'activo' => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_expiracion' => 'date',
        'usado_en' => 'datetime',
        'porcentaje' => 'decimal:2',
        'monto_fijo' => 'decimal:2',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generar código único
    public static function generarCodigo($longitud = 8)
    {
        do {
            $codigo = strtoupper(Str::random($longitud));
        } while (self::where('codigo', $codigo)->exists());

        return $codigo;
    }

    // Verificar si el código está disponible
    public function estaDisponible()
    {
        if (!$this->activo || $this->usado) {
            return false;
        }

        if ($this->fecha_inicio && now()->lt($this->fecha_inicio)) {
            return false;
        }

        if ($this->fecha_expiracion && now()->gt($this->fecha_expiracion)) {
            return false;
        }

        return true;
    }

    // Usar el código (solo una vez)
    public function usar($userId = null)
    {
        if (!$this->estaDisponible()) {
            return false;
        }

        $this->usado = true;
        $this->usado_en = now();

        if ($userId) {
            $this->user_id = $userId;
        }

        $this->save();

        return true;
    }

    // Scope para códigos disponibles
    public function scopeDisponibles($query)
    {
        return $query->where('activo', true)
            ->where('usado', false)
            ->where(function ($q) {
                $q->whereNull('fecha_expiracion')
                    ->orWhere('fecha_expiracion', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('fecha_inicio')
                    ->orWhere('fecha_inicio', '<=', now());
            });
    }

    // Scope para códigos usados
    public function scopeUsados($query)
    {
        return $query->where('usado', true);
    }
}
