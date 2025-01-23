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
        Schema::create('empleado_descuentos_compensaciones', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['deduccion', 'compensacion']);
            $table->unsignedBigInteger('usu_detalle_id');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->date('fecha');
            $table->integer('horas');
            $table->float('monto');
            $table->boolean('use')->default(false);
            $table->unsignedBigInteger('usu_id')->nullable();
            $table->foreign('usu_detalle_id')
                ->references('id')
                ->on('empleado_detalles')
                ->onDelete('cascade');
            $table->foreign('usu_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_descuentos_compensaciones');
    }
};
