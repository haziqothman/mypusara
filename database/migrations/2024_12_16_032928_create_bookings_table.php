<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('customerName');
            $table->string('no_mykad', 20); // Added
            $table->string('customerEmail');
            $table->string('contactNumber', 20);
            $table->string('pusaraNo', 50);
            $table->string('area', 100); // Added
            $table->string('nama_simati', 255); // Added
            $table->text('notes')->nullable();
            $table->date('eventDate');
            $table->time('eventTime'); // Added (stores time only)
            $table->string('eventLocation');
            $table->string('document_path')->nullable(); // Added (stores file path)
            $table->foreignId('user_id')->constrained(); // Added (links to users table)
            $table->foreignId('package_id')->constrained(); // Added (links to packages table)
            $table->string('status')->default('pending'); // Added (e.g., 'pending', 'confirmed', 'cancelled')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
