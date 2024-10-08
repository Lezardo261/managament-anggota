<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
    public function eskul()
    {
        return $this->belongsTo(Eskul::class);
    }
    
}
