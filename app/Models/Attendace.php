<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendace extends Model
{
    use HasFactory;
    protected $table = 'attendances';
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
    public function getPhotoAttribute($value)
    {
        // Mengembalikan path dengan prefix /storage/
        return asset('storage/attendance/' . $value);
    }

}
