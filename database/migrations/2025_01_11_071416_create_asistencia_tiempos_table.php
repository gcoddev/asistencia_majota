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
        Schema::create('asistencia_tiempo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usu_id');
            $table->unsignedBigInteger('asis_id');
            $table->time('hora_ini');
            $table->time('hora_fin')->nullable();
            $table->string('ubicacion', 255)->nullable();
            $table->boolean('facturable')->default(false);
            $table->string('ip', 255)->nullable();
            $table->string('note', 255)->nullable();
            $table->boolean('estado')->nullable();
            $table->foreign('usu_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');
            $table->foreign('asis_id')
                ->references('id')
                ->on('asistencias')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_tiempo');
    }
};
