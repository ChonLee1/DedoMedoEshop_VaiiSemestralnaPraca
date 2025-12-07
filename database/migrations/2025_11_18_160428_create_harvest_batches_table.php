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
        Schema::create('harvest_batches', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->string('location');
            $table->decimal('brix', 5, 2)->nullable(); // napr. 80.50
            $table->date('harvested_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvest_batches');
    }
};
