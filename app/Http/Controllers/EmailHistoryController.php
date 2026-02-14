<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailHistory;

class EmailHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailHistory::query()->orderBy('sent_at', 'desc');

        // Filtro por búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'ilike', "%{$search}%")
                    ->orWhere('from_email', 'ilike', "%{$search}%")
                    ->orWhereRaw("to::text ilike ?", ["%{$search}%"])
                    ->orWhere('mailable_class', 'ilike', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por rango de fechas
        if ($request->filled('date_from')) {
            $query->where('sent_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('sent_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Filtro por tipo de mailable
        if ($request->filled('mailable_class')) {
            $query->where('mailable_class', $request->mailable_class);
        }

        $emails = $query->paginate(20)->withQueryString();

        // Obtener todas las clases de mailable para el filtro
        $mailableClasses = EmailHistory::distinct()
            ->pluck('mailable_class')
            ->sort();

        return view('templates.historial', compact('emails', 'mailableClasses'));
    }

    public function show(string $id)
    {
        $emailHistory = EmailHistory::findOrFail($id);

        return view('templates.detail', compact('emailHistory'));
    }

    public function destroy(string $id)
    {
        $emailHistory = EmailHistory::findOrFail($id);
        $emailHistory->delete();

        return redirect()->route('email-history.index')
            ->with('success', 'Email eliminado del historial');
    }
}
