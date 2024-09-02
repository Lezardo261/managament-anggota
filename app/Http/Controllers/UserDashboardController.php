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
        $tasks = Task::with(['submissions' => function($query) {
            $query->where('user_id', Auth::id());
        }])->get();
        
        $tasks = $tasks->map(function($task) {
            $task->is_submitted = $task->submissions->isNotEmpty();
            return $task;
        });
        
        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
        ]);
    }
}

