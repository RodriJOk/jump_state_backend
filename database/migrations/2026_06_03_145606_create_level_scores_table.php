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
        Schema::create('level_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('level_id');
            $table->integer('score')->default(0);
            $table->integer('best_score')->default(0);
            $table->integer('attempts')->default(0);
            $table->boolean('completed')->default(false);
            $table->string('mode')->default('cube'); // cube, ship, ball, ufo, wave
            $table->boolean('practice_mode')->default(false);
            $table->timestamps();
            
            // Índice único para evitar duplicados de nivel por usuario
            $table->unique(['user_id', 'level_id']);
            
            // Índices para optimizar consultas de leaderboard
            $table->index(['level_id', 'best_score']);
            $table->index('best_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_scores');
    }
};
