<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Attend;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('date', Carbon::today())->get();
        $userId = Auth::id();
        $userAttendances = DB::table('attendances')->where('user_id', $userId)
            ->whereIn('schedule_id', $schedules->pluck('id'))
            ->pluck('schedule_id')
            ->toArray();
    
        return Inertia::render('Schedules/Index', [
            'schedules' => $schedules,
            'userAttendances' => $userAttendances
        ]);
    }
    
    

    public function create()
    {
        $scheduleCount = Schedule::count();
        return Inertia::render('Schedules/Create', [
            'scheduleCount' => $scheduleCount,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        Schedule::create($validated);
        return redirect()->route('admin.dashboard');
    }

}
