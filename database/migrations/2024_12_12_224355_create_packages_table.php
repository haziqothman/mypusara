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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            // Foreign Key
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            
            // Column Definitions
            $table->string('pusaraNo'); // Define pusaraNo column
            $table->enum('status', ['tersedia', 'tidak_tersedia', 'dalam_penyelanggaraan']);
            $table->text('packageDesc'); // Package description (text type for larger text)
            $table->enum('area', ['area_A', 'area_B', 'area_C']); // Enum type for area
            $table->string('packageImage')->nullable(); // Package image (nullable)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
