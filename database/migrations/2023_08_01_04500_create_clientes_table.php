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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->string('telefono');
            $table->boolean('is_proveedor')->nullable();
            $table->string('direccion');
            $table->string('cordenadas')->nullable();                                                                                                                      
            $table->boolean('credito')->default('false');
            $table->decimal('monto',total: 8, places: 2)->default(0);
        });
    }

    /**   
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venta', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']); // Asegúrate de que el nombre de la clave sea correcto
        });
        
        Schema::dropIfExists('clientes');    }
};
