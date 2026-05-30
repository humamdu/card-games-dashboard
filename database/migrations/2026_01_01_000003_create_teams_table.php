<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('match_id')->constrained('matches')->cascadeOnDelete();
            $table->string('name');
            $table->unsignedSmallInteger('position')->default(1);
            $table->integer('score')->default(0);
            $table->timestamps();
            $table->unique(['match_id', 'position']);
        });

        Schema::create('player_team', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['player_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_team');
        Schema::dropIfExists('teams');
    }
};
