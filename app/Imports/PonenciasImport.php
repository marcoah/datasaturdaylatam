<?php

namespace App\Imports;

use App\Models\Ponencia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PonenciasImport implements ToModel
{
    public function model(array $row)
    {
        // Verificar si el usuario ya existe
        $user = User::where('email', $row['email'])->first();

        if (!$user) {
            // Generar contraseña temporal
            $passwordTemporal = Str::random(10);

            // Crear usuario
            $user = User::create([
                'name' => $row['nombre'] . ' ' . $row['apellido'],
                'email' => $row['email'],
                'password' => Hash::make($passwordTemporal),
                'role' => 'ponente',
            ]);

            // Aquí podrías enviar el email con las credenciales
        }

        // Crear ponencia
        return new Ponencia([
            'user_id' => $user->id,
            'titulo' => $row['titulo'],
            'descripcion' => $row['descripcion'],
            'fecha_ponencia' => \Carbon\Carbon::parse($row['fecha_ponencia']),
            'horario_ponencia' => $row['horario_ponencia'],
            'nivel' => $row['nivel'] ?? 'intermedio',
            'aprobada' => false,
        ]);
    }
}
