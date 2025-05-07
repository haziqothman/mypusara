<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Booking extends Model
{
    use HasFactory;

    // Table name (optional, if the table name doesn't follow Laravel's convention)
    protected $table = 'bookings';

    // Fillable fields, which can be mass-assigned
    protected $fillable = [
        'customerName', 'no_mykad', 'customerEmail', 'contactNumber',
        'area', 'nama_simati', 'no_mykad_simati', 'no_sijil_kematian','waris_address', // Add the new fields here
        'notes', 'eventDate', 'eventTime', 'eventLocation', 'document_path', 'user_id', 'packageId', 'status'
    ];
    
    public function package()
    {
        return $this->belongsTo(Package::class, 'packageId'); // 'packageId' is your foreign key
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Assuming 'user_id' is the foreign key
    }

    protected $casts = [
        'eventDate' => 'datetime',
    ];
    
    
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'packageId');
    }

    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('nama_simati');
            $table->index('no_mykad_simati');
            $table->index('status');
        });
        
        Schema::table('packages', function (Blueprint $table) {
            $table->index('pusaraNo');
            $table->index('status');
        });
    }


}
