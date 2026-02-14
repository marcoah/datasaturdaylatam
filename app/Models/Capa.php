<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Capa extends Model
{
    //
    protected $fillable = [
        'nombre',
        'color',
        'visible',
        'observaciones',
        'meta'
    ];

    protected function casts(): array
    {
        return [
            'visible' => 'boolean',
            'meta' => 'array'
        ];
    }

    protected $attributes = [
        'color' => '#3388ff',
        'visible' => true
    ];

    public function objetos(): HasMany
    {
        return $this->hasMany(Objeto::class);
    }

    // Scope para capas visibles
    public function scopeVisibles($query)
    {
        return $query->where('visible', true);
    }
}
