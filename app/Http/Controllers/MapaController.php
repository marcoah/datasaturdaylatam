<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Capa;
use App\Models\Objeto;
use Clickbar\Magellan\Data\Geometries\Point;

class MapaController extends Controller
{
    public function mostrar($slug)
    {
        // Buscar la capa por slug
        $capa = Capa::where('slug', $slug)->firstOrFail();

        // Obtener todos los objetos de esta capa que tengan geometría tipo POINT
        $objetos = Objeto::where('capa_id', $capa->id)
            ->whereNotNull('geometria')
            ->get()
            ->filter(function ($objeto) {
                // Verificar que la geometría sea tipo Point
                return $objeto->geometria instanceof Point;
            })
            ->map(function ($objeto) {
                // Magellan/PostGIS devuelve objetos Point con lat y lng
                $objeto->latitud = $objeto->geometria->getLatitude();
                $objeto->longitud = $objeto->geometria->getLongitude();
                return $objeto;
            });

        // Calcular centro del mapa (promedio de coordenadas)
        $centroLat = $objetos->avg('latitud') ?? config('map.center_latitude');
        $centroLng = $objetos->avg('longitud') ?? config('map.center_longitude');

        //dd($objetos);

        return view('dashboards.mapa', [
            'capa' => $capa,
            'objetos' => $objetos,
            'centroLat' => $centroLat,
            'centroLng' => $centroLng,
            'zoom' => $objetos->count() > 0 ? 13 : 12
        ]);
    }
}
