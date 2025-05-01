<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSelectionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'requirements',
        'status',
        'selected_package_id',
        'admin_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'selected_package_id');
    }
}