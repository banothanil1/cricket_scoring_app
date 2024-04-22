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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('batsman');
            $table->boolean('isout');
            $table->integer('hisruns')->nullable();
            $table->string('bowler');
            $table->string('onthisbowl');
            $table->integer('current_runs')->default(0);
            $table->integer('current_wickets')->default(0);
            $table->integer('current_over')->default(1);
            $table->integer('count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
