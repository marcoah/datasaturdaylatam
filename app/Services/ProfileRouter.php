<?php

namespace App\Services;

use App\Models\User;

class ProfileRouter
{
    /**
     * Decide which view or response the given user should receive for the home page.
     *
     * @param User $user
     * @return string|\Illuminate\Contracts\Support\Renderable
     */
    public function profileViewFor(User $user)
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
            return View('dashboards.profile')
                ->with('user', $user);
        }

        if ($user->hasRole('ponente')) {
            return View('dashboards.ponentes.profile')
                ->with('user', $user);
        }

        if ($user->hasRole('asistente')) {
            return View('dashboards.asistentes.profile')
                ->with('user', $user);
        }

        logger()->warning('HomeRouter::homeViewFor: unexpected role', [
            'user_id' => $user->id ?? null,
            'roles' => $roles->toArray(),
        ]);

        abort(403, 'Unauthorized role.');
    }
}
