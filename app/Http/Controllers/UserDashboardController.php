<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $userEskulIds = $user->eskuls->pluck('id'); // Ambil semua eskul_id yang diikuti user
        $userId = $user->id; 
        
        $tasks = Task::whereIn('eskul_id', $userEskulIds)->get();
        $tasks = $tasks->map(function($task) use ($userId) {
            $task->is_submitted = $task->submissions->where('user_id', $userId)->isNotEmpty(); // Cek berdasarkan user_id
            return $task;
        });

        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
        ]);
    }
}

