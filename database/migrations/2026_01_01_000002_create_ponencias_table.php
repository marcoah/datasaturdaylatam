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
        Schema::create('ponencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descripcion');
            $table->date('fecha_ponencia');
            $table->time('horario_ponencia');
            $table->enum('nivel', ['basico', 'intermedio', 'avanzado'])->default('intermedio');
            $table->string('archivo')->nullable(); // Ruta del archivo (pptx o pdf)
            $table->boolean('aprobada')->default(false);
            $table->timestamps();

            // Índices
            $table->index('user_id');
            $table->index('fecha_ponencia');
            $table->index('aprobada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ponencias');
    }
};
