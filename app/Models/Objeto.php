<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Clickbar\Magellan\Data\Geometries\Geometry;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Data\Geometries\Polygon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Objeto extends Model
{

    protected $fillable = [
        'nombre',
        'tipo',
        'icono',
        'geometria',
        'archivo',
        'observaciones',
        'meta',
        'capa_id'
    ];

    protected function casts(): array
    {
        return [
            'geometria' => Geometry::class,
            'meta' => 'array',
        ];
    }

    protected $attributes = [
        'icono' => 'fa-map-pin'
    ];

    // Constantes para tipo
    const TIPO_POINT = 'POINT';
    const TIPO_LINESTRING = 'LINESTRING';
    const TIPO_POLYGON = 'POLYGON';
    const TIPO_MULTIPOINT = 'MULTIPOINT';
    const TIPO_MULTILINESTRING = 'MULTILINESTRING';
    const TIPO_MULTIPOLYGON = 'MULTIPOLYGON';

    public function capa(): BelongsTo
    {
        return $this->belongsTo(Capa::class);
    }

    // Scopes
    public function scopeConGeometria($query)
    {
        return $query->whereNotNull('geometria');
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Helper para obtener GeoJSON de la geometría
    public function getGeojsonAttribute()
    {
        if (!$this->geometria) return null;

        $geojson = DB::selectOne(
            "SELECT ST_AsGeoJSON(geometria) as geojson FROM objetos WHERE id = ?",
            [$this->id]
        );

        return $geojson ? json_decode($geojson->geojson) : null;
    }

    // Helper para obtener color efectivo (propio o heredado de capa)
    public function getColorEfectivoAttribute()
    {
        return $this->meta['color'] ?? $this->capa->color;
    }
}
