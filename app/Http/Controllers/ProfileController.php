<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function store(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Verificar que el usuario no tenga ya un perfil
        if ($user->profile()->exists()) {
            return redirect()
                ->route('profile')
                ->with('error', 'El usuario ya tiene un perfil creado');
        }

        $validated = $request->validate([
            // Campos de User
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Campos de Profile
            'about' => 'nullable|string',
            'company' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'birthday' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($user, $validated) {
            // Actualizar campos de User
            $user->update([
                'firstname' => $validated['firstname'] ?? null,
                'lastname' => $validated['lastname'] ?? null,
            ]);

            // Crear Profile con los demás campos
            $user->profile()->create(
                collect($validated)->except(['firstname', 'lastname'])->toArray()
            );
        });

        return redirect()
            ->route('profile')
            ->with('success', 'Perfil creado exitosamente');
    }

    public function update(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $profile = $user->profile;

        if (!$profile) {
            return redirect()
                ->route('profile')
                ->with('error', 'El usuario no tiene un perfil creado');
        }

        $validated = $request->validate([
            // Campos de User
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Campos de Profile
            'about' => 'nullable|string',
            'company' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'birthday' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($user, $profile, $validated, $request) {

            // Manejar el avatar
            if ($request->hasFile('avatar')) {
                // Eliminar avatar anterior si existe
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Guardar nuevo avatar
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            // Manejar eliminación de avatar
            if ($request->remove_avatar == '1' && $user->avatar) {
                Storage::disk('public')->delete($user->avatar);
                $user->avatar = null;
            }

            // Actualizar campos de User
            $user->firstname = $validated['firstname'] ?? null;
            $user->lastname = $validated['lastname'] ?? null;
            $user->save();

            // Actualizar Profile con los demás campos
            $profile->update(
                collect($validated)->except(['firstname', 'lastname'])->toArray()
            );
        });

        return redirect()
            ->route('profile')
            ->with('success', 'Perfil actualizado exitosamente');
    }

    public function downloadAvatar($userId)
    {
        $user = User::findOrFail($userId);

        if (!$user->avatar || !Storage::disk('public')->exists($user->avatar)) {
            return redirect()->back()->with('error', 'Avatar no encontrado');
        }

        //Extension del archivo a descargar
        $extension = pathinfo($user->avatar, PATHINFO_EXTENSION);

        // Verifica si hay nombre y apellido y arma el nombre de la descarga
        $downloadName = trim(($user->firstname ?? '') . '_' . ($user->lastname ?? '')) ?: "user_{$userId}";
        $downloadName .= "_avatar.{$extension}";

        // Ver qué valores tiene
        /*
        dd([
            'userId' => $userId,
            'user' => $user,
            'avatar' => $user->avatar,
            'extension' => $extension,
            'downloadName' => $downloadName
        ]);
        */

        // Forzar descarga con Content-Disposition
        return Storage::disk('public')->download(
            $user->avatar,
            $downloadName,
            [
                'Content-Type' => Storage::disk('public')->mimeType($user->avatar),
                'Content-Disposition' => 'attachment; filename="' . $downloadName . '"'
            ]
        );
    }
}
