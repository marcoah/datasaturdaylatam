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

        $capas = [
            [
                'nombre' => 'Hoteles',
                'slug' => 'hoteles',
                'observaciones' => 'Hoteles y alojamientos',
                'color' => '#3388ff',
                'visible' => true
            ],
            [
                'nombre' => 'Restaurantes',
                'slug' => 'restaurantes',
                'observaciones' => 'Restaurantes y gastronomía',
                'color' => '#ff3333',
                'visible' => true
            ],
            [
                'nombre' => 'Cultura',
                'slug' => 'cultura',
                'observaciones' => 'Lugares culturales',
                'color' => '#33ff33',
                'visible' => true
            ],
            [
                'nombre' => 'Turismo',
                'slug' => 'turismo',
                'observaciones' => 'Puntos turísticos',
                'color' => '#ffaa33',
                'visible' => true
            ],
        ];

        foreach ($capas as $capa) {
            Capa::updateOrCreate(
                ['slug' => $capa['slug']],
                $capa
            );
        }
    }
}
