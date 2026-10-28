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
        Schema::create('intervention_piece', function (Blueprint $table) {
            $table->foreignId('intervention_id')->constrained();
            $table->foreignId('piece_id')->constrained();
            $table->primary(['intervention_id', 'piece_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervention_piece');
    }
};
