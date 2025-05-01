<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Table name (optional, if the table name doesn't follow Laravel's convention)
    protected $table = 'bookings';

    // Fillable fields, which can be mass-assigned
    protected $fillable = [
        'customerName', 'no_mykad', 'customerEmail', 'contactNumber',
        'area', 'nama_simati', 'no_mykad_simati', 'no_sijil_kematian', // Add the new fields here
        'notes', 'eventDate', 'eventTime', 'eventLocation', 'document_path', 'user_id', 'packageId', 'status'
    ];
    
    

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id'); // Assuming 'user_id' is the foreign key
    }

    public function package()
{
    return $this->belongsTo(Package::class, 'packageId');
}




}
