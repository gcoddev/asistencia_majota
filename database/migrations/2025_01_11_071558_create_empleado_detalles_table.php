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
            $table->unsignedBigInteger('dep_id')->nullable();
            $table->unsignedBigInteger('des_id')->nullable();
            $table->string('num_pasaporte')->nullable();
            $table->string('exp_pasaporte')->nullable();
            $table->string('tel_pasaporte')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->enum('genero', ['M', 'F'])->nullable();
            $table->string('religion')->nullable();
            $table->string('etnia')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('ocupacion')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('contacto_emergencia')->nullable();
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
