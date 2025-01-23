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
        Schema::create('recibo_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recibo_id');
            $table->unsignedBigInteger('item_id');
            $table->string('tipo');
            $table->foreign('recibo_id')
                ->references('id')
                ->on('recibos')
                ->onDelete('cascade');
            $table->foreign('item_id')
                ->references('id')
                ->on('empleado_descuentos_compensaciones')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibo_items');
    }
};
