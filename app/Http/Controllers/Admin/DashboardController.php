<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Schedule;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Exports\UserStatsExport;
use App\Http\Controllers\Controller;
use App\Models\Eskul;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $admin = Auth::user();
        $adminEskulIds = $admin->eskuls->pluck('id')->toArray();
    
        // Get total tasks for the admin's eskuls
        $totalTasks = Task::whereIn('eskul_id', $adminEskulIds)->count();
    
        // Get pending approvals for the admin's eskuls
        $pendingApprovals = LeaveRequest::where('status', 'pending')
            ->whereHas('eskuls', function ($query) use ($adminEskulIds) {
                $query->whereIn('eskuls.id', $adminEskulIds);
            })
            ->count();
    
        // Check if there is a schedule for today for any of the admin's eskuls
        $today = Carbon::today();
        $hasScheduleToday = Schedule::whereIn('eskul_id', $adminEskulIds)
            ->whereDate('date', $today)
            ->exists();
    
        // Get users associated with the admin's eskuls
        $users = User::whereHas('eskuls', function ($query) use ($adminEskulIds) {
            $query->whereIn('eskuls.id', $adminEskulIds);
        })->get()->map(function ($user) {
            $user->encrypted_id = Crypt::encrypt($user->id);
            return $user;
        });
    
        // Compute user statistics
        $userStats = $users->map(function ($user) use ($adminEskulIds) {
            return [
                'user' => $user,
                'attendances' => $user->attendances()
                    ->whereHas('schedule', function ($query) use ($adminEskulIds) {
                        $query->whereIn('eskul_id', $adminEskulIds);
                    })->count(),
                'izin' => $user->leaveRequests()
                    ->where('reason', 'izin')
                    ->whereHas('eskuls', function ($query) use ($adminEskulIds) {
                        $query->whereIn('eskuls.id', $adminEskulIds);
                    })->count(),
                'sakit' => $user->leaveRequests()
                    ->where('reason', 'sakit')
                    ->whereHas('eskuls', function ($query) use ($adminEskulIds) {
                        $query->whereIn('eskuls.id', $adminEskulIds);
                    })->count(),
            ];
        });
    
        // Get the details for the eskuls the admin is associated with
        $eskuls = Eskul::whereIn('id', $adminEskulIds)->get();
    
        return Inertia::render('Admin/Dashboard', [
            'users' => $users,
            'userStats' => $userStats,
            'totalTasks' => $totalTasks,
            'pendingApprovals' => $pendingApprovals,
            'hasScheduleToday' => $hasScheduleToday, 
            'eskuls' => $eskuls
        ]);
    }

    public function exportUserStats()
    {
        $eskulIds = Auth::user()->eskuls->pluck('id'); // Fetch all eskul IDs
        return Excel::download(new UserStatsExport($eskulIds), 'user_stats.xlsx');
    }
    
}