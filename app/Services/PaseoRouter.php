<?php

namespace App\Services;

use App\Models\Paseo;
use App\Models\User;

class PaseoRouter
{
    /**
     * Decide which view or response the given user should receive for the home page.
     *
     * @param User $user
     * @return string|\Illuminate\Contracts\Support\Renderable
     */
    public function paseoViewFor(User $user)
    {
        // Ensure we have an authenticated user (caller should guarantee this, but double-check)
        if (! $user) {
            abort(401, 'Unauthenticated.');
        }

        $roles = $user->getRoleNames();
        $primaryRole = $roles->first();

        if (! $primaryRole) {
            abort(403, 'User does not have any role assigned.');
        }

        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            $paseos = Paseo::all();
            return view('paseos.index', compact('paseos'));
        }

        if ($user->hasRole(['ponente', 'asistente'])) {
            $paseos = Paseo::orderBy('fecha_inicio', 'asc')
                ->orderBy('hora_inicio', 'asc')
                ->paginate(9); // 9 tarjetas por página (3x3)

            return view('paseos.menu_paseos', compact('paseos'));
        }

        logger()->warning('HomeRouter::homeViewFor: unexpected role', [
            'user_id' => $user->id ?? null,
            'roles' => $roles->toArray(),
        ]);

        abort(403, 'Unauthorized role.');
    }
}
