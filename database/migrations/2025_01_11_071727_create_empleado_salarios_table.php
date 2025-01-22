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
            $table->unsignedBigInteger('usu_detalle_id')->nullable();
            $table->string('base')->nullable();
            $table->float('salario_base', 10.2)->nullable();
            $table->string('metodo_pago')->nullable();
            $table->string('cuenta_bancaria')->nullable();
            $table->boolean('pf_contribucion')->default(false)->nullable();
            $table->string('pf_numero')->nullable();
            $table->float('pf_adicional', 10.2)->nullable();
            $table->float('pf_tasa_total', 10.2)->nullable();
            $table->boolean('esi_contribucion')->default(false)->nullable();
            $table->string('esi_numero')->nullable();
            $table->float('esi_adicional', 10.2)->nullable();
            $table->float('esi_tasa_total', 10.2)->nullable();
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
