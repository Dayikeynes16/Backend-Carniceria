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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('total');
            $table->integer('balanza');
            $table->softDeletes();
            $table->string('metodo_de_pago')->default('efectivo');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->string('estatus')->default('activo');
            $table->boolean('pagado')->default(0);
            

        });
    }

    /**                                                                                                                                                                  
     * Reverse the migrations.                                    
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
