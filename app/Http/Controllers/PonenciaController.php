<?php

namespace App\Http\Controllers;

use App\Models\Ponencia;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PonenciasImport;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PonenciaController extends Controller
{
    public function index()
    {
        $ponencias = Ponencia::with('user')
            ->orderBy('fecha_ponencia', 'desc')
            ->orderBy('horario_ponencia', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Ponencia::count(),
            'aprobadas' => Ponencia::aprobadas()->count(),
            'pendientes' => Ponencia::pendientes()->count(),
        ];

        return view('ponencias.index', compact('ponencias', 'stats'));
    }

    public function create()
    {
        return view('ponencias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_ponencia' => 'required|date',
            'horario_ponencia' => 'required',
            'nivel' => 'required|in:basico,intermedio,avanzado',
            'archivo' => 'nullable|file|mimes:pdf,pptx,ppt|max:10240', // 10MB max
        ]);

        // Generar contraseña temporal
        $passwordTemporal = Str::random(10);

        // Crear usuario ponente
        $user = User::create([
            'firstname' => $request->nombre,
            'lastname' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($passwordTemporal),
        ]);

        // Crear profile usando la relación
        $user->profile()->create([
            'job' => 'Ponente',
        ]);

        $user->assignRole('ponente');

        // Manejar archivo si existe
        $archivoPath = null;
        if ($request->hasFile('archivo')) {
            $archivoPath = $request->file('archivo')->store('ponencias', 'public');
        }

        // Crear ponencia
        $ponencia = Ponencia::create([
            'user_id' => $user->id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_ponencia' => $request->fecha_ponencia,
            'horario_ponencia' => $request->horario_ponencia,
            'nivel' => $request->nivel,
            'archivo' => $archivoPath,
            'aprobada' => false,
        ]);

        // Enviar email de bienvenida con credenciales
        $this->enviarEmailBienvenida($user, $passwordTemporal, $ponencia);

        return redirect()->route('ponencias.index')
            ->with('success', 'Ponencia registrada exitosamente. Se envió un correo a ' . $user->email);
    }

    public function importarExcel(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new PonenciasImport, $request->file('archivo_excel'));

            return redirect()->route('ponencias.index')
                ->with('success', 'Ponencias importadas exitosamente desde Excel.');
        } catch (\Exception $e) {
            return redirect()->route('ponencias.index')
                ->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function show(Ponencia $ponencia)
    {
        return view('ponencias.show', compact('ponencia'));
    }

    public function edit(Ponencia $ponencia)
    {
        return view('ponencias.edit', compact('ponencia'));
    }

    public function update(Request $request, Ponencia $ponencia)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_ponencia' => 'required|date',
            'horario_ponencia' => 'required',
            'nivel' => 'required|in:basico,intermedio,avanzado',
            'archivo' => 'nullable|file|mimes:pdf,pptx,ppt|max:10240',
        ]);

        $data = $request->only(['titulo', 'descripcion', 'fecha_ponencia', 'horario_ponencia', 'nivel']);

        // Manejar nuevo archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($ponencia->archivo && Storage::disk('public')->exists($ponencia->archivo)) {
                Storage::disk('public')->delete($ponencia->archivo);
            }

            $data['archivo'] = $request->file('archivo')->store('ponencias', 'public');
        }

        $ponencia->update($data);

        return redirect()->route('ponencias.index')
            ->with('success', 'Ponencia actualizada correctamente.');
    }

    public function destroy(Ponencia $ponencia)
    {
        // Eliminar archivo si existe
        if ($ponencia->archivo && Storage::disk('public')->exists($ponencia->archivo)) {
            Storage::disk('public')->delete($ponencia->archivo);
        }

        $ponencia->delete();

        return redirect()->route('ponencias.index')
            ->with('success', 'Ponencia eliminada correctamente.');
    }

    public function toggleAprobada(Ponencia $ponencia)
    {
        $ponencia->aprobada = !$ponencia->aprobada;
        $ponencia->save();

        $estado = $ponencia->aprobada ? 'aprobada' : 'marcada como pendiente';

        return redirect()->route('ponencias.index')
            ->with('success', "Ponencia {$estado} correctamente.");
    }

    private function enviarEmailBienvenida($user, $passwordTemporal, $ponencia)
    {
        Mail::send('mail.ponencia-bienvenida', [
            'user' => $user,
            'password' => $passwordTemporal,
            'ponencia' => $ponencia,
            'urlLogin' => env('APP_URL') . '/login',
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Bienvenido - Ponencia Registrada');
        });
    }

    public function subirArchivo(Request $request, Ponencia $ponencia)
    {
        $user = Auth::user();

        // Verificar que el ponente sea el dueño de la ponencia
        if ($user->id !== $ponencia->user_id) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'archivo' => 'required|file|mimes:pdf,pptx,ppt|max:10240',
        ]);

        // Eliminar archivo anterior si existe
        if ($ponencia->archivo && Storage::disk('public')->exists($ponencia->archivo)) {
            Storage::disk('public')->delete($ponencia->archivo);
        }

        // Guardar nuevo archivo
        $archivoPath = $request->file('archivo')->store('ponencias', 'public');

        $ponencia->update(['archivo' => $archivoPath]);

        return redirect()->back()
            ->with('success', 'Archivo subido correctamente.');
    }

    public function miPonencia()
    {
        $user = Auth::user();

        $ponencia = Ponencia::where('user_id', $user->id)->first();

        return view('ponencias.subir-archivo', compact('ponencia'));
    }
}
