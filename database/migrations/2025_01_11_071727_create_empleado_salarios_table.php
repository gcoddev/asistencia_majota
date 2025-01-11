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
        Schema::create('empleado_salarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usu_detalle_id');
            $table->string('base');
            $table->string('salario_base');
            $table->string('metodo_pago');
            $table->string('pf_contribucion');
            $table->string('pf_numero');
            $table->string('pf_adicional');
            $table->string('pf_tasa_total');
            $table->string('esi_contribucion');
            $table->string('esi_numero');
            $table->string('esi_adicional');
            $table->string('esi_tasa_total');
            $table->foreign('usu_detalle_id')
                ->references('id')
                ->on('empleado_detalles')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_salarios');
    }
};
