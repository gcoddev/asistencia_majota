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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usu_id');
            $table->unsignedBigInteger('enviado_id');
            $table->unsignedBigInteger('recibido_id');
            $table->string('mensaje', 255);
            $table->string('tipo', 20);
            $table->boolean('leido')->default(false);
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
        Schema::dropIfExists('chats');
    }
};
