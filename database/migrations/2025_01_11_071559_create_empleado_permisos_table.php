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
        Schema::create('empleado_permisos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usu_detalle_id');
            $table->enum('tipo', ['permiso', 'vacacion']);
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->unsignedBigInteger('dias');
            $table->string('razones');
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
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
        Schema::dropIfExists('empleado_permisos');
    }
};
