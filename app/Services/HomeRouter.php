<?php

namespace App\Services;

use App\Models\User;

class HomeRouter
{
    /**
     * Decide which view or response the given user should receive for the home page.
     *
     * @param User $user
     * @return string|\Illuminate\Contracts\Support\Renderable
     */
    public function homeViewFor(User $user)
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
            return view('dashboards.principal');
        }

        if ($user->hasRole('ponente')) {
            return view('dashboards.ponentes.principal');
        }

        if ($user->hasRole('asistente')) {
            return view('dashboards.asistentes.principal');
        }

        logger()->warning('HomeRouter::homeViewFor: unexpected role', [
            'user_id' => $user->id ?? null,
            'roles' => $roles->toArray(),
        ]);

        abort(403, 'Unauthorized role.');
    }
}
