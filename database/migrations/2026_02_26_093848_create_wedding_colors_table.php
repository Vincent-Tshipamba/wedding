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
        Schema::create('wedding_colors', function (Blueprint $table) {
            $table->id();
            $table->string('color', 50);
            $table->foreignId('wedding_event_id')->constrained('wedding_events')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['wedding_event_id', 'color']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_colors');
    }
};
