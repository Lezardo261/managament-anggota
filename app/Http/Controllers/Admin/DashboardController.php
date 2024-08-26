<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $users = User::all();

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
}
