<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function eskul()
    {
        return $this->belongsTo(Eskul::class);
    } 
    public function eskuls()
    {
        return $this->belongsToMany(Eskul::class, 'eskul_leave_request');
    }

}
