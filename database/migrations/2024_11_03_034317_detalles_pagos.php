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
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->foreignId('pago_id')->constrained('pagos');
            $table->decimal('monto', 10, 2); 
            $table->string('metodo_de_pago'); 
            $table->timestamp('fecha')->nullable(); 
            $table->string('referencia')->nullable(); 
            $table->timestamps(); 
            $table->softDeletes();
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