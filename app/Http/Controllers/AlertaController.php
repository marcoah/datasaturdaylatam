<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AlertaController extends Controller
{
    public function index()
    {
        $alertas = Alerta::with('user')
            ->orderBy('activa', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Alerta::count(),
            'activas' => Alerta::activas()->count(),
            'globales' => Alerta::globales()->count(),
            'personalizadas' => Alerta::whereNotNull('user_id')->count(),
        ];

        return view('alertas.index', compact('alertas', 'stats'));
    }

    public function create()
    {
        $usuarios = User::orderBy('email')->get();
        return view('alertas.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'mensaje_adicional' => 'nullable|string',
            'tipo' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
            'user_id' => 'nullable|exists:users,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        Alerta::create([
            'user_id' => $request->user_id,
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'mensaje_adicional' => $request->mensaje_adicional,
            'tipo' => $request->tipo,
            'activa' => $request->has('activa'),
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return redirect()->route('alertas.index')
            ->with('success', 'Alerta creada con éxito.');
    }

    public function show(Alerta $alerta)
    {
        return view('alertas.show', compact('alerta'));
    }

    public function edit(Alerta $alerta)
    {
        $usuarios = User::orderBy('email')->get();
        return view('alertas.edit', compact('alerta', 'usuarios'));
    }

    public function update(Request $request, Alerta $alerta)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'mensaje_adicional' => 'nullable|string',
            'tipo' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
            'user_id' => 'nullable|exists:users,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $alerta->update([
            'user_id' => $request->user_id,
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'mensaje_adicional' => $request->mensaje_adicional,
            'tipo' => $request->tipo,
            'activa' => $request->has('activa'),
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return redirect()->route('alertas.index')
            ->with('success', 'Alerta actualizada correctamente.');
    }

    public function destroy(Alerta $alerta)
    {
        $alerta->delete();

        return redirect()->route('alertas.index')
            ->with('success', 'Alerta eliminada correctamente.');
    }

    public function toggleActiva(Alerta $alerta)
    {
        $alerta->activa = !$alerta->activa;
        $alerta->save();

        $estado = $alerta->activa ? 'activada' : 'desactivada';

        return redirect()->route('alertas.index')
            ->with('success', "Alerta {$estado} correctamente.");
    }

    public function marcarLeida(Request $request, Alerta $alerta)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Usuario no autenticado'], 401);
            }

            $alerta->marcarComoLeida($user->id);

            return response()->json(['success' => true, 'message' => 'Alerta marcada como leída']);
        } catch (\Exception $e) {
            Log::error('Error al marcar alerta como leída: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function estadisticas(Alerta $alerta)
    {
        $totalLecturas = $alerta->usuariosQueHanLeido()->count();
        $usuariosQueHanLeido = $alerta->usuariosQueHanLeido()
            ->orderBy('alerta_user.leida_en', 'desc')
            ->get();

        return view('alertas.estadisticas', compact('alerta', 'totalLecturas', 'usuariosQueHanLeido'));
    }
}
