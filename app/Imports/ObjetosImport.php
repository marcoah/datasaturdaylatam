<?php

namespace App\Imports;

use App\Models\Objeto;
use Clickbar\Magellan\Data\Geometries\Point;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class ObjetosImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    protected $capaId;
    protected $errores = [];

    public function __construct($capaId)
    {
        $this->capaId = $capaId;
    }

    public function model(array $row)
    {
        // Validar que tenga latitud y longitud
        if (empty($row['latitud']) || empty($row['longitud'])) {
            $this->errores[] = "Fila sin coordenadas: {$row['nombre']}";
            return null;
        }

        // Crear el punto geométrico - Magellan lo manejará como Geometry
        $point = Point::make(
            (float) $row['longitud'],
            (float) $row['latitud'],
            4326
        );

        return new Objeto([
            'nombre' => $row['nombre'],
            'capa_id' => $this->capaId,
            'tipo' => 'POINT', // Guardamos el tipo como string
            'geometria' => $point, // Magellan lo convierte automáticamente
            'icono' => $row['icono'] ?? 'fa-map-pin',
            'direccion' => $row['direccion'] ?? null,
            'telefono' => $row['telefono'] ?? null,
            'email' => $row['email'] ?? null,
            'url' => $row['url'] ?? null,
            'observaciones' => $row['observaciones'] ?? null,
            'meta' => isset($row['meta']) ? json_decode($row['meta'], true) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'latitud.required' => 'La latitud es obligatoria',
            'latitud.numeric' => 'La latitud debe ser un número',
            'latitud.between' => 'La latitud debe estar entre -90 y 90',
            'longitud.required' => 'La longitud es obligatoria',
            'longitud.numeric' => 'La longitud debe ser un número',
            'longitud.between' => 'La longitud debe estar entre -180 y 180',
        ];
    }

    public function getErrores()
    {
        return $this->errores;
    }
}
