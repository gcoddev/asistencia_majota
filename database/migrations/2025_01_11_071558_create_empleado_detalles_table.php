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
        Schema::create('empleado_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usu_id');
            $table->unsignedBigInteger('dep_id');
            $table->unsignedBigInteger('des_id');
            $table->string('num_pasaporte');
            $table->string('exp_pasaporte');
            $table->string('tel_pasaporte');
            $table->string('nacionalidad');
            $table->string('religion');
            $table->string('etnia');
            $table->string('estado_civil');
            $table->string('ocupacion');
            $table->date('fecha_nacimiento');
            $table->date('fecha_ingreso');
            ('contacto_emergencia');
            $table->foreign('usu_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');
            $table->foreign('dep_id')
                ->references('id')
                ->on('departamentos')
                ->onDelete('cascade');
            $table->foreign('des_id')
                ->references('id')
                ->on('designaciones')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_detalles');
    }
};
