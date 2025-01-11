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
        Schema::create('ticket_respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tic_id');
            $table->unsignedBigInteger('respuesta_id');
            $table->text('mensaje');
            $table->boolean('leido', false);
            $table->foreign('tic_id')
                ->references('id')
                ->on('tickets')
                ->onDelete('cascade');
            $table->foreign('respuesta_id')
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
        Schema::dropIfExists('ticket_respuestas');
    }
};
