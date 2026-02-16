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
        Schema::create('paseos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('imagen')->nullable();
            $table->longText('descripcion');
            $table->string('ubicacion');
            $table->date('fecha_inicio');
            $table->time('hora_inicio');
            $table->string('fecha_fin')->nullable();
            $table->string('hora_fin')->nullable();
            $table->string('btn_1')->nullable();
            $table->string('url_1')->nullable();
            $table->string('btn_2')->nullable();
            $table->string('url_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paseos');
    }
};
