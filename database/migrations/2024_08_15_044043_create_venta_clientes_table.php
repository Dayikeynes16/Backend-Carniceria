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
        Schema::create('venta_clientes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('venta_id')->constrained('ventas');
            $table->boolean('pagado')->default(false);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_clientes');
    }
};
