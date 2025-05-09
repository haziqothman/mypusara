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
        Schema::create('admin_selection_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       // In the migration file
        Schema::create('admin_selection_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('requirements');
            $table->string('status')->default('pending'); // pending, processing, completed
            $table->foreignId('selected_package_id')->nullable()->constrained('packages');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }
};
