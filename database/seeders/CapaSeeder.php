<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Capa;

class CapaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $capa = new Capa();
        $capa->nombre = "Hoteles";
        $capa->color = "#228B22";
        $capa->visible = true;
        $capa->observaciones = "Capa de hoteles";
        $capa->save();

        $capa = new Capa();
        $capa->nombre = "Restaurantes";
        $capa->color = "#FF0000";
        $capa->visible = true;
        $capa->observaciones = "Capa de restaurantes";

        $capa->save();

        $capa = new Capa();
        $capa->nombre = "Cultura";
        $capa->color = "#FFD700";
        $capa->visible = true;
        $capa->observaciones = "Sitios culturales";
        $capa->save();
    }
}
