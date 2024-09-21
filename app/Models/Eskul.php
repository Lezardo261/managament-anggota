<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Eskul extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_eskul');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function getUsersWithEskul()
    {
        return User::with('eskul')->get();
    }
    public function leaveRequests()
    {
        return $this->belongsToMany(LeaveRequest::class);
    }
}
