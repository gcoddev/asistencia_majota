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
            $table->string('titulo')->nullable();
            $table->unsignedBigInteger('usu_detalle_id')->nullable();
            $table->boolean('use_compensaciones')->default(false);
            $table->boolean('use_deducciones')->default(false);
            $table->date('fecha_recibo')->nullable();
            $table->string('tipo')->nullable();
            $table->integer('cantidad')->nullable();
            $table->date('fecha_ini')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('horas_totales')->nullable();
            $table->string('salario_neto')->nullable();
            $table->string('salario_total')->nullable();
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
