<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Exports\UserStatsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    public function index(): Response
    {
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
        ]);
    }
    public function exportUserStats()
    {
        return Excel::download(new UserStatsExport, 'user_stats.xlsx');
    }
    
}
