<?php

namespace App\Services;

use App\Models\Capa;
use App\Models\User;

class SitioRouter
{
    /**
     * Decide which view or response the given user should receive for the home page.
     *
     * @param User $user
     * @return string|\Illuminate\Contracts\Support\Renderable
     */
    public function sitioViewFor(User $user)
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
            $capas = Capa::All();
            return view('mapas.interno', compact('capas'));
        }

        if ($user->hasRole(['ponente', 'asistente'])) {
            $capas = Capa::All();
            return view('mapas.interno', compact('capas'));
        }

        logger()->warning('HomeRouter::homeViewFor: unexpected role', [
            'user_id' => $user->id ?? null,
            'roles' => $roles->toArray(),
        ]);

        abort(403, 'Unauthorized role.');
    }
}
