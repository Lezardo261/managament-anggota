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
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $totalTasks = Task::count();
        $pendingApprovals = LeaveRequest::where('status', 'pending')->count();
    
        $today = Carbon::today();
        $hasScheduleToday = Schedule::whereDate('date', $today)->exists();
    
        $users = User::all()->map(function ($user) {
            $user->encrypted_id = Crypt::encrypt($user->id);
            return $user;
        });
    
        $userStats = $users->map(function ($user) {
            return [
                'user' => $user,
                'attendances' => $user->attendances()->count(),
                'izin' => $user->leaveRequests()->where('reason', 'izin')->count(),
                'sakit' => $user->leaveRequests()->where('reason', 'sakit')->count(),
            ];
        });
    
        return inertia('Admin/Dashboard', [
            'users' => $users,
            'userStats' => $userStats,
            'totalTasks' => $totalTasks,
            'pendingApprovals' => $pendingApprovals,
            'hasScheduleToday' => $hasScheduleToday, 
        ]);
    }
    public function exportUserStats()
    {
        return Excel::download(new UserStatsExport, 'user_stats.xlsx');
    }
    
}
