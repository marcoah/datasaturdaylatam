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
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('porcentaje', 5, 2)->default(0); // Ej: 15.50 para 15.5%
            $table->decimal('monto_fijo', 10, 2)->nullable(); // Descuento en valor fijo
            $table->enum('tipo', ['porcentaje', 'monto_fijo'])->default('porcentaje');
            $table->boolean('usado')->default(false);
            $table->boolean('activo')->default(true);
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_expiracion')->nullable();
            $table->timestamp('usado_en')->nullable(); // Cuando se usó
            $table->timestamps();

            // Índices
            $table->index('codigo');
            $table->index('user_id');
            $table->index('usado');
            $table->index('activo');
            $table->index('fecha_expiracion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};
