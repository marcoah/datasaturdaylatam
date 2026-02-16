<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    public function index()
    {
        $noticias = Noticia::orderBy('fecha_publicacion', 'desc')
            ->paginate(10);

        return view('noticias.index', compact('noticias'));
    }

    public function create()
    {
        return view('noticias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'fecha_publicacion' => 'required|date',
        ]);

        $data = $request->only(['titulo', 'contenido', 'fecha_publicacion']);
        $data['publicada'] = $request->has('publicada');

        // Manejar imagen
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }

        Noticia::create($data);

        return redirect()->route('noticias.index')
            ->with('success', 'Noticia creada con éxito.');
    }

    public function show(Noticia $noticia)
    {
        return view('noticias.show', compact('noticia'));
    }

    public function edit(Noticia $noticia)
    {
        return view('noticias.edit', compact('noticia'));
    }

    public function update(Request $request, Noticia $noticia)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'fecha_publicacion' => 'required|date',
        ]);

        $data = $request->only(['titulo', 'contenido', 'fecha_publicacion']);
        $data['publicada'] = $request->has('publicada');

        // Manejar nueva imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior
            if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
                Storage::disk('public')->delete($noticia->imagen);
            }

            $data['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }

        $noticia->update($data);

        return redirect()->route('noticias.index')
            ->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy(Noticia $noticia)
    {
        // Eliminar imagen si existe
        if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
            Storage::disk('public')->delete($noticia->imagen);
        }

        $noticia->delete();

        return redirect()->route('noticias.index')
            ->with('success', 'Noticia eliminada correctamente.');
    }

    // Vista pública de noticias
    public function publicIndex()
    {
        $noticias = Noticia::publicadas()
            ->recientes()
            ->paginate(9);

        return view('noticias.publico', compact('noticias'));
    }
}
