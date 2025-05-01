<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grave extends Model
{
    public function up()
    {
        Schema::create('graves', function (Blueprint $table) {
            $table->id();
            $table->string('pusaraNo')->unique();
            $table->string('nama_simati')->nullable();
            $table->enum('status', ['available', 'booked', 'buried'])->default('available');
            $table->date('eventDate')->nullable();
            $table->timestamps();
        });
    }
    
}
