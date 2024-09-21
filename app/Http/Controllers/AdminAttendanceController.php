<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Attendace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Attendance; // Perbaiki typo di sini

class AdminAttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $adminEskulIds = $user->eskuls->pluck('id')->toArray();
        
        $attendances = Attendace::with(['user', 'schedule.eskul'])
            ->whereHas('schedule', function ($query) use ($adminEskulIds) {
                $query->whereIn('eskul_id', $adminEskulIds);
            })
            ->get();
    
        return Inertia::render('Admin/Attendances/Index', [
            'attendances' => $attendances
        ]);
    }
}