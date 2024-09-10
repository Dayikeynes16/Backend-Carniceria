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
        Schema::create('venta', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('total')->default(0.00);
            $table->string('metodo de pago')->default('efectivo');
            $table->boolean('pagado')->default(false);
            $table->string('status')->default('por cobrar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};
