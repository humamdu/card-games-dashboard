<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rounds', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('match_id')->constrained('matches')->cascadeOnDelete();
            $table->unsignedSmallInteger('number');
            $table->string('kingdom')->nullable();
            $table->string('contract')->nullable();
            $table->foreignId('bid_team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->integer('bid_amount')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
            $table->unique(['match_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rounds');
    }
};
