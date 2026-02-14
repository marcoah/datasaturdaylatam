<?php

namespace App\Http\Controllers;

use App\Models\Capa;
use App\Models\Objeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CapaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $capas = Capa::All();
        return view('capas.index', compact('capas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('capas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'color' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        Capa::create([
            'nombre' => $request->nombre,
            'color' => $request->color ?? '#3388ff',
            'visible' => $request->has('visible'), // true si existe, false si no
            'observaciones' => $request->observaciones,
            'meta' => $request->meta,
        ]);

        return redirect()->route('capas.index')->with('success', 'Capa created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Capa $capa)
    {
        return view('capas.show', compact('capa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Capa $capa)
    {
        return view('capas.edit', compact('capa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Capa $capa)
    {
        $request->validate([
            'nombre' => 'required',
            'color' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['visible'] = $request->has('visible'); // Convertir checkbox a boolean

        $capa->update($data);
        return redirect()->route('capas.index')->with('success', 'capa updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Capa $capa)
    {
        $capa->delete();
        return redirect()->route('capas.index')->with('success', 'capa deleted successfully');
    }

    public function obtenerDatosCapa($idproyecto)
    {
        $capas = Capa::Find($idproyecto);
        return response()->json($capas);
    }

    public function obtenercapas()
    {
        $capas = Capa::All();
        return response()->json($capas);
    }

    public function mostrarmapa($id)
    {
        $objetos = Objeto::with('capa')
            ->where('capa_id', $id)
            ->get();

        return view('capas.mapa', compact('objetos'));
    }

    public function exportarGeoJSON($id)
    {
        $capa = Capa::with('objetos')->findOrFail($id);

        $features = [];

        foreach ($capa->objetos as $objeto) {
            $geometry = null;

            // Si tiene punto o polígono, lo convertimos a GeoJSON
            if ($objeto->posicion) {
                $geometry = DB::selectOne('SELECT ST_AsGeoJSON(?) AS geom', [$objeto->posicion])->geom;
            } elseif ($objeto->area) {
                $geometry = DB::selectOne('SELECT ST_AsGeoJSON(?) AS geom', [$objeto->area])->geom;
            }

            if (!$geometry) continue;

            $features[] = [
                'type' => 'Feature',
                'geometry' => json_decode($geometry),
                'properties' => [
                    'id' => $objeto->id,
                    'nombre' => $objeto->nombre,
                    'tipo' => $objeto->tipo,
                    'origen' => $objeto->origen,
                    'fuente' => $objeto->fuente,
                    'icono' => $objeto->icono,
                    'archivo' => $objeto->archivo,
                    'observaciones' => $objeto->observaciones,
                    'meta' => json_decode($objeto->meta, true),
                ],
            ];
        }

        $geojson = [
            'type' => 'FeatureCollection',
            'name' => $capa->nombre,
            'features' => $features,
        ];

        return response()->streamDownload(function () use ($geojson) {
            echo json_encode($geojson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, "capa_{$capa->id}.geojson", [
            'Content-Type' => 'application/geo+json',
        ]);
    }

    public function importar()
    {
        $capas = Capa::All();

        return view('objetos.importar', compact('capas'));
    }

    public function importarGeojson(Request $request, $id)
    {
        $request->validate([
            'geojson' => 'required|array', // en vez de file|mimes 'geojson' => 'required|file|mimes:json,geojson',
        ]);

        $capa = Capa::findOrFail($id);
        $geojson = $request->input('geojson');
        //$file = $request->file('geojson');
        //$geojson = json_decode(file_get_contents($file->getRealPath()), true);

        //dd($geojson);

        if (!$geojson || !isset($geojson['features'])) {
            return response()->json(['error' => 'Formato GeoJSON inválido'], 422);
        }

        foreach ($geojson['features'] as $feature) {
            $geometry = json_encode($feature['geometry']);
            $props = $feature['properties'] ?? [];

            //dd($props);

            Objeto::create([
                'nombre' => $props['nombre'] ?? 'Sin nombre',
                'tipo' => $feature['geometry']['type'] ?? null,
                'posicion' => $feature['geometry']['type'] === 'Point'
                    ? DB::raw("ST_GeomFromGeoJSON('$geometry')")
                    : null,
                'area' => $feature['geometry']['type'] === 'Polygon'
                    ? DB::raw("ST_GeomFromGeoJSON('$geometry')")
                    : null,
                'meta' => $props,
                'capa_id' => $capa->id,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
