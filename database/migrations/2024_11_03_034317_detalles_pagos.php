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
        Schema::create('detalles_pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_id')->constrained('pagos')->onDelete('set null');
            $table->decimal('monto', 10, 2); // Monto pagado en este pago
            $table->string('metodo_de_pago'); // Método de pago (efectivo, tarjeta, transferencia, etc.)
            $table->timestamp('fecha')->nullable(); // Fecha en que se realizó el pago
            $table->string('referencia')->nullable(); // Número de referencia (opcional)
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_pagos');
    }
};