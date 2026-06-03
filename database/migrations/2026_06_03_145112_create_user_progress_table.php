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
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('level_id');
            $table->boolean('completed')->default(false);
            $table->integer('score')->default(0);
            $table->integer('attempts')->default(0);
            $table->integer('time_played')->default(0); // en segundos
            $table->string('difficulty')->default('normal');
            $table->integer('distance')->default(0);
            $table->timestamps();
            
            // Índice único para evitar duplicados de nivel por usuario
            $table->unique(['user_id', 'level_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
