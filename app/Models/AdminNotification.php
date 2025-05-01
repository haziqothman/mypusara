<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Schema::create('admin_notifications', function (Blueprint $table) {
    $table->id();
    $table->string('phone');
    $table->text('message');
    $table->string('method'); // whatsapp/sms/failed
    $table->boolean('is_sent')->default(false);
    $table->timestamps();
});
