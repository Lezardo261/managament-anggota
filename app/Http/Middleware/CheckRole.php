<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     $user = Auth::user();

    //     if ($user && $user->role === 'admin') {
    //         // Hanya redirect ke admin.dashboard jika rute yang diakses tidak termasuk yang diperbolehkan
    //         if (!in_array($request->route()->getName(), ['admin.dashboard', 'admin.users.edit', 'admin.user.destroy', 'admin.users.update', 'admin.attendances.index', 'schedules.create'])) {
    //             return redirect()->route('admin.dashboard');
    //         }
            
    //     }        
    
    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next)
    {
    $user = Auth::user();
    $routeName = $request->route()->getName();

    Log::info('Route Name: ' . $routeName);
    Log::info('User Role: ' . ($user ? $user->role : 'Guest'));

        if ($user && $user->role === 'admin') {
            // Jika admin mencoba mengakses rute non-admin
            if ($this->isNonAdminRoute($routeName)) {
                return redirect()->route('admin.dashboard');
            }
        } elseif ($user && $user->role !== 'admin') {
            // Jika non-admin mencoba mengakses rute admin
            if ($this->isAdminRoute($routeName)) {
                return redirect()->route('dashboard');
            }
        }


        return $next($request);
    }

    protected function isAdminRoute($routeName)
    {
        // Tentukan rute-rute admin
        $adminRoutes = [
            'admin.dashboard',
            'admin.users.edit',
            'admin.users.update',
            'admin.user.destroy',
            'schedules.index',
            'schedules.create',
            'schedules.store',
            'admin.attendances.index',
            'admin.leave-requests.index',
            'admin.leave-requests.approve',
            'admin.leave-requests.reject',
            'admin.exportUserStats',
            'admin.tasks.index',
            'admin.tasks.getSubmissions',
            'admin.user.dashboard',
            'tasks.create',
            'tasks.store',
            'admin.logout',
            
        ];

        return in_array($routeName, $adminRoutes);
    }

    protected function isNonAdminRoute($routeName)
    {
        // Tentukan rute-rute non-admin
        $nonAdminRoutes = [
            // 'dashboard',
            // 'profile.edit',
            // 'profile.update',
            // 'profile.destroy',
            // 'schedules.user.index',
            // 'attendances.store',
            // 'leave-requests.index',
            // 'leave-requests.create',
            // 'leave-requests.store',
            // 'leave-requests.destroy',
            // 'tasks.submit',
            // 'user.logout',
            // Tambahkan rute-rute non-admin lainnya di sini
        ];

        return in_array($routeName, $nonAdminRoutes);
    }
}
