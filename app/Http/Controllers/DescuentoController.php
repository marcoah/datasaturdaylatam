<?php

namespace App\Http\Controllers;

use App\Models\Descuento;
use Illuminate\Http\Request;

class DescuentoController extends Controller
{
    public function index()
    {
        $descuentos = Descuento::with('user')
            ->orderBy('usado', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => Descuento::count(),
            'disponibles' => Descuento::disponibles()->count(),
            'usados' => Descuento::usados()->count(),
        ];

        return view('descuentos.index', compact('descuentos', 'stats'));
    }

    public function create()
    {
        return view('descuentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:porcentaje,monto_fijo',
            'porcentaje' => 'required_if:tipo,porcentaje|nullable|numeric|min:0|max:100',
            'monto_fijo' => 'required_if:tipo,monto_fijo|nullable|numeric|min:0',
            'fecha_inicio' => 'nullable|date',
            'fecha_expiracion' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $descuento = Descuento::create([
            'codigo' => Descuento::generarCodigo(),
            'tipo' => $request->tipo,
            'porcentaje' => $request->tipo === 'porcentaje' ? $request->porcentaje : 0,
            'monto_fijo' => $request->tipo === 'monto_fijo' ? $request->monto_fijo : null,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_expiracion' => $request->fecha_expiracion,
            'activo' => true,
        ]);

        return redirect()->route('descuentos.index')
            ->with('success', 'Código de descuento creado: ' . $descuento->codigo);
    }

    public function generarCodigos(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:100',
            'tipo' => 'required|in:porcentaje,monto_fijo',
            'porcentaje' => 'required_if:tipo,porcentaje|nullable|numeric|min:0|max:100',
            'monto_fijo' => 'required_if:tipo,monto_fijo|nullable|numeric|min:0',
            'fecha_inicio' => 'nullable|date',
            'fecha_expiracion' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $cantidad = $request->cantidad;
        $codigosGenerados = [];

        for ($i = 0; $i < $cantidad; $i++) {
            $descuento = Descuento::create([
                'codigo' => Descuento::generarCodigo(),
                'tipo' => $request->tipo,
                'porcentaje' => $request->tipo === 'porcentaje' ? $request->porcentaje : 0,
                'monto_fijo' => $request->tipo === 'monto_fijo' ? $request->monto_fijo : null,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_expiracion' => $request->fecha_expiracion,
                'activo' => true,
            ]);

            $codigosGenerados[] = $descuento->codigo;
        }

        return redirect()->route('descuentos.index')
            ->with('success', "Se generaron {$cantidad} códigos de descuento exitosamente.")
            ->with('codigos', $codigosGenerados);
    }

    public function destroy(Descuento $descuento)
    {
        // Solo permitir eliminar si no se ha usado
        if ($descuento->usado) {
            return redirect()->route('descuentos.index')
                ->with('error', 'No se puede eliminar un código que ya fue usado.');
        }

        $descuento->delete();

        return redirect()->route('descuentos.index')
            ->with('success', 'Código de descuento eliminado correctamente.');
    }

    public function toggleActivo(Descuento $descuento)
    {
        // Solo permitir desactivar si no se ha usado
        if ($descuento->usado) {
            return redirect()->route('descuentos.index')
                ->with('error', 'No se puede modificar un código que ya fue usado.');
        }

        $descuento->activo = !$descuento->activo;
        $descuento->save();

        $estado = $descuento->activo ? 'activado' : 'desactivado';

        return redirect()->route('descuentos.index')
            ->with('success', "Código {$estado} correctamente.");
    }

    public function show(Descuento $descuento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Descuento $descuento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Descuento $descuento)
    {
        //
    }
}
