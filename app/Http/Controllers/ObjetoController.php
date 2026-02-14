<?php

namespace App\Http\Controllers;

use App\Models\Capa;
use App\Models\Objeto;
use Illuminate\Http\Request;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Data\Geometries\Polygon;
use Clickbar\Magellan\Database\PostgisFunctions\ST;
use Clickbar\Magellan\Data\Geometries\LineString;
use Clickbar\Magellan\Data\Geometries\MultiPoint;
use Clickbar\Magellan\Data\Geometries\MultiLineString;
use Clickbar\Magellan\Data\Geometries\MultiPolygon;
use Clickbar\Magellan\IO\Parser\WKT\WKTParser;


class ObjetoController extends Controller
{
    public function index($capa)
    {
        $objetos = Objeto::where('capa_id', $capa)->get();
        return view('objetos.index', compact('objetos', 'capa'));
    }

    public function create($capa)
    {
        $datoscapa = Capa::find($capa);
        return view('objetos.create', compact('datoscapa'));
    }

    public function store(Request $request, Capa $capa)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo' => 'required|in:POINT,LINESTRING,POLYGON,MULTIPOINT,MULTILINESTRING,MULTIPOLYGON',
            'geometria' => 'required|string',
            'icono' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        // Parsear WKT a objeto Geometry de Magellan
        $parser = app(WKTParser::class);

        $geometry = $parser->parse($request->geometria);

        Objeto::create([
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'icono' => $request->icono ?? 'fa-map-pin',
            'geometria' => $geometry,
            'observaciones' => $request->observaciones,
            'meta' => $request->meta,
            'capa_id' => $capa->id,
        ]);

        return redirect()
            ->route('capas.objetos.index', ['capa' => $capa->id])
            ->with('success', 'Objeto creado exitosamente.');

        /*
        $rules = [
            'capa_id' => 'required|numeric',
            'nombre' => 'required',
            'origen' => 'required|in:Contribucion,Manual,Automatizado',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric'
        ];

        $messages = [
            'capa_id.required' => 'Indique capa',
            'capa_id.numeric' => 'capa_id debe ser un número',
            'nombre.required' => 'Agrega su nombre.',
            'origen.required' => 'Indique cual problema está reportando',
            'origen.in' => 'Defina el origen',
            'latitud.required' => 'Debe pulsar sobre el mapa para definir posicion',
            'longitud.required' => 'Debe pulsar sobre el mapa para definir posicion',
            'latitud.numeric' => 'Latitud debe ser un número',
            'longitud.numeric' => 'Longitud debe ser un numero'
        ];

        $request->validate($rules, $messages);

        $place1 = new Objeto();
        $place1->capa_id = $request->capa_id;
        $place1->nombre = $request->nombre;
        $place1->tipo = $request->tipo;
        $place1->icono = $request->icono;
        $place1->archivo = $request->archivo;
        $place1->origen = $request->origen;
        $place1->fuente = $request->fuente;

        // saving a point
        $place1->posicion = Point::make(
            $request->longitud,
            $request->latitud
        );
        $place1->save();

        return redirect()->route('capas.objetos.index', ['capa' => $request->capa_id])->with('success', 'objeto creado con éxito.');
        */
    }

    public function show(Objeto $objeto)
    {
        return view('objetos.show', compact('objeto'));
    }

    public function edit(Objeto $objeto)
    {
        return view('objetos.edit', compact('objeto'));
    }


    public function update(Request $request, Objeto $objeto)
    {
        $rules = [
            'capa_id' => 'required|numeric',
            'nombre' => 'required',
            'origen' => 'required|in:Contribucion,Manual,Automatizado',
            'fuente' => 'required',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric'
        ];

        $messages = [
            'capa_id.required' => 'Indique capa',
            'capa_id.numeric' => 'capa_id debe ser un número',
            'nombre.required' => 'Agrega su nombre.',
            'origen.required' => 'Indique cual problema está reportando',
            'origen.in' => 'Defina el origen',
            'fuente.required' => 'Indique fuente del reporte',
            'latitud.required' => 'Debe pulsar sobre el mapa para definir posicion',
            'longitud.required' => 'Debe pulsar sobre el mapa para definir posicion',
            'latitud.numeric' => 'Latitud debe ser un número',
            'longitud.numeric' => 'Longitud debe ser un numero'
        ];

        $request->validate($rules, $messages);

        $objeto->nombre = $request->nombre;
        $objeto->capa_id = $request->capa_id;
        $objeto->tipo = $request->tipo;
        $objeto->icono = $request->icono;
        $objeto->archivo = $request->archivo;
        $objeto->origen = $request->origen;
        $objeto->fuente = $request->fuente;

        // saving a point
        $objeto->posicion = Point::make($request->latitud, $request->longitud);    // (lat, lng)
        $objeto->save();

        return redirect()->route('capas.objetos.index', ['capa' => $objeto->capa_id])->with('success', 'objeto actualizado satisfactoriamente');
    }

    public function destroy(Objeto $objeto)
    {
        $objeto->delete();
        return redirect()->route('capas.objetos.index', ['capa' => $objeto->capa_id])->with('success', 'objeto eliminado satisfactoriamente');
    }

    public function obtenerDatos($id)
    {
        $objetos = Objeto::where('capa_id', $id)
            ->get()
            ->map(function ($objeto) {
                return [
                    'id' => $objeto->id,
                    'nombre' => $objeto->nombre,
                    'tipo' => $objeto->tipo,
                    'icono' => $objeto->icono,
                    'geometria' => $objeto->geometria ? json_decode(json_encode($objeto->geometria)) : null
                ];
            });

        return response()->json($objetos);
    }
}
