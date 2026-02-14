<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('objetos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', [
                'POINT',
                'LINESTRING',
                'POLYGON',
                'MULTIPOINT',
                'MULTILINESTRING',
                'MULTIPOLYGON'
            ])->nullable();
            $table->string('icono')->default('fa-map-pin');
            $table->geometry('geometria', 'GEOMETRY', 4326)->nullable();
            $table->string('archivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->json('meta')->nullable();
            $table->foreignId('capa_id')->constrained('capas')->onDelete('cascade');
            $table->timestamps();

            $table->spatialIndex('geometria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objetos');
    }
};
