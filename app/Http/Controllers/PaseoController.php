<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\PaseoRouter;
use App\Models\Paseo;
use App\Models\User;

class PaseoController extends Controller
{
    private PaseoRouter $paseoRouter;

    public function __construct(PaseoRouter $paseoRouter)
    {
        $this->middleware('auth');
        $this->paseoRouter = $paseoRouter;
    }

    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        // Delegate view-routing by role to the HomeRouter service
        return $this->paseoRouter->paseoViewFor($user);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('paseos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ubicacion' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'hora_inicio' => 'required',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_fin' => 'nullable',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048', // max 2MB
            'btn_1' => 'nullable|max:255',
            'btn_2' => 'nullable|max:255',
            'url_1' => 'nullable|max:255',
            'url_2' => 'nullable|max:255',
        ]);

        $data = $request->only(['nombre', 'descripcion', 'ubicacion', 'fecha_inicio', 'hora_inicio']);

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('paseos', 'public');
            $data['imagen'] = $imagePath;
        }

        // Manejar fecha_fin y hora_fin
        if ($request->has('mostrar_finalizacion')) {
            $data['fecha_fin'] = $request->fecha_fin;
            $data['hora_fin'] = $request->hora_fin;
        } else {
            $data['fecha_fin'] = null;
            $data['hora_fin'] = null;
        }

        // Agregar URLs
        $data['btn_1'] = $request->btn_1;
        $data['btn_2'] = $request->btn_2;
        $data['url_1'] = $request->url_1;
        $data['url_2'] = $request->url_2;

        Paseo::create($data);

        return redirect()->route('paseos.index')->with('success', 'Paseo creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paseo $paseo)
    {
        //
        return view('paseos.show', compact('paseo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paseo $paseo)
    {
        //
        return view('paseos.edit', compact('paseo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paseo $paseo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ubicacion' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'hora_inicio' => 'required',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_fin' => 'nullable',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'btn_1' => 'nullable|max:255',
            'btn_2' => 'nullable|max:255',
            'url_1' => 'nullable|max:255',
            'url_2' => 'nullable|max:255',
        ]);

        $data = $request->only(['nombre', 'descripcion', 'ubicacion', 'fecha_inicio', 'hora_inicio']);

        // Manejar eliminación de imagen
        if ($request->has('eliminar_imagen') && $request->eliminar_imagen == '1') {
            if ($paseo->imagen && Storage::disk('public')->exists($paseo->imagen)) {
                Storage::disk('public')->delete($paseo->imagen);
            }
            $data['imagen'] = null;
        }
        // Manejar nueva imagen
        elseif ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($paseo->imagen && Storage::disk('public')->exists($paseo->imagen)) {
                Storage::disk('public')->delete($paseo->imagen);
            }

            $imagePath = $request->file('imagen')->store('paseos', 'public');
            $data['imagen'] = $imagePath;
        }

        // Manejar fecha_fin y hora_fin
        if ($request->has('mostrar_finalizacion')) {
            $data['fecha_fin'] = $request->fecha_fin;
            $data['hora_fin'] = $request->hora_fin;
        } else {
            $data['fecha_fin'] = null;
            $data['hora_fin'] = null;
        }

        // Agregar URLs
        $data['btn_1'] = $request->btn_1;
        $data['url_1'] = $request->url_1;
        $data['btn_2'] = $request->btn_2;
        $data['url_2'] = $request->url_2;

        $paseo->update($data);

        return redirect()->route('paseos.index')
            ->with('success', 'Paseo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paseo $paseo)
    {
        // Eliminar imagen si existe
        if ($paseo->imagen && Storage::disk('public')->exists($paseo->imagen)) {
            Storage::disk('public')->delete($paseo->imagen);
        }

        $paseo->delete();

        return redirect()->route('paseos.index')
            ->with('success', 'Paseo eliminado correctamente.');
    }
}
