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
        Schema::create('venta_diarias', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('subtotal_transferencia', total: 8, places: 2);
            $table->decimal('subtotal_efectivo', total: 8, places: 2);
            $table->decimal('subtotal_tarjeta', total: 8, places: 2);
            $table->decimal('total', total: 8, places: 2);       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_diarias');
    }
};
