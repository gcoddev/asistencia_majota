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
        Schema::create('empleado_experiencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usu_detalle_id');
            $table->string('empresa');
            $table->string('direccion');
            $table->string('cargo');
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->string('file');
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
        Schema::dropIfExists('empleado_experiencias');
    }
};
