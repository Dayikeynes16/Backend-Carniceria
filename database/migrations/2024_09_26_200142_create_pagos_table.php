<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.x
     */
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('total');
            $table->string('metodo_de_pago')->default('efectivo');
            $table->decimal('tarjeta')->default(0);
            $table->decimal('transferencia')->default(0);
            $table->decimal('efectivo')->default(0);
            $table->decimal('pendiente')->default(0);
            $table->foreignId('venta_id')->nullable()->constrained('ventas');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
