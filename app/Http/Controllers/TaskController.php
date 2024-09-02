<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\TaskSubmission;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return Inertia::render('Task/Index', [
            'tasks' => $tasks,
        ]);
    }
    public function getSubmissions(Task $task)
    {
        $submissions = $task->submissions()->with('user')->get();

        return response()->json(['submissions' => $submissions]);
    }
    public function create()
    {
        return Inertia::render('Task/Create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);
        return redirect()->route('tasks.create')->with('success', 'Task created successfully.');
    }
    
}
