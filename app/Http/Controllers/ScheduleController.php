<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Eskul;
use App\Models\Attend;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Fetch all eskul IDs associated with the user
        $userEskulIds = Auth::user()->eskuls->pluck('id')->toArray(); // Assumes `eskuls` is a relationship on User model
    
        Log::info('User Eskul IDs: ' . json_encode($userEskulIds));
        // Get schedules for all eskuls the user belongs to
        $schedules = Schedule::whereIn('eskul_id', $userEskulIds)
            ->whereDate('date', Carbon::today())
            ->get();
        Log::info('Schedules: ' . $schedules->toJson());
        // Get the schedule IDs for the user's attendances
        $userAttendances = DB::table('attendances')
            ->where('user_id', $userId)
            ->whereIn('schedule_id', $schedules->pluck('id'))
            ->pluck('schedule_id')
            ->toArray();
    
        return Inertia::render('Schedules/Index', [
            'schedules' => $schedules,
            'userAttendances' => $userAttendances,
        ]);
    }
    public function create()
    {
        $eskuls = Eskul::all();
        $scheduleCount = Schedule::count();
        return Inertia::render('Schedules/Create', [
            'scheduleCount' => $scheduleCount,
            'eskuls' => $eskuls,
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eskul_id' => 'required|exists:eskuls,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);
    
        Schedule::create($validated);
    }    
}
