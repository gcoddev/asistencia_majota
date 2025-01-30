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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('apellidos', 100)->nullable();
            $table->string('ci', 50)->unique();
            $table->string('email', 255)->unique()->nullable();
            // $table->string('username', 50)->unique();
            $table->string('tipo', 20)->nullable();
            $table->string('celular', 15)->nullable();
            $table->string('password', 255);
            $table->string('imagen', 255)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('ciudad', 50)->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('en_linea')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
