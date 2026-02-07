<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->firstname = 'Marco';
        $user->lastname = 'Hernandez';
        $user->password = Hash::make('marcoa1*');
        $user->email = 'marcoah@gmail.com';
        $user->save();
        $user->assignRole('super-admin');

        $profile = new Profile();
        $profile->about = 'Desarrollador e ingeniero. Programador principal';
        $profile->job = 'Administrator';
        $profile->country = 'Venezuela';
        $profile->address = 'Calle Las Margaritas #20 Sector el Progreso El Limon';
        $profile->phone = '0424 - 1335622';
        $profile->user_id = $user->id;
        $profile->save();
    }
}
