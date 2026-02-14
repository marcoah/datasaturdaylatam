<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class); //primero crea los roles para usarlos en el UserSeeder
        $this->call(UserSeeder::class);

        //Contenido interno
        $this->call(CapaSeeder::class);
        $this->call(TemplateSeeder::class);
    }
}
