<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminAttendanceController extends Controller
{
    public function index()
    {
        $attendances = DB::table('attendances')
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->join('schedules', 'attendances.schedule_id', '=', 'schedules.id')
            ->select('attendances.*', 'users.name as user_name', 'schedules.title as schedule_title')
            ->get()
            ->map(function($attendance) {
                $attendance->photo_url = Storage::url('attendance/' . $attendance->photo_path);
                return $attendance;
            });
    
        return Inertia::render('Admin/Attendances/Index', [
            'attendances' => $attendances,
        ]);
    }
    
}


