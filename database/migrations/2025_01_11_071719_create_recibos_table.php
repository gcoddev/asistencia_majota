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
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->unsignedBigInteger('usu_detalle_id');
            $table->string('permiso');
            $table->string('descuento');
            $table->date('fecha_recibo');
            $table->string('tipo');
            $table->string('semanas');
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->integer('horas_totales');
            $table->string('salario_neto');
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
        Schema::dropIfExists('recibos');
    }
};
