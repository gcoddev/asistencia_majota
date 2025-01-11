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
            $table->time('hora_fin');
            $table->string('ubicacion', 255);
            $table->boolean('facturable')->default(false);
            $table->string('ip', 255);
            $table->string('note', 255);
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
