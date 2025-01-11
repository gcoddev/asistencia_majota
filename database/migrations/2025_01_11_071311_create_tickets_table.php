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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->string('asunto', 100);
            $table->unsignedBigInteger('usu_id');
            $table->string('descripcion', 255);
            $table->enum('estado', ['abierto', 'empleado', 'admin', 'finalizado', 'cerrado'])->default('abierto');
            $table->enum('prioridad', ['alta', 'media', 'baja'])->default('media');
            $table->date('fecha_fin');
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
        Schema::dropIfExists('tickets');
    }
};
