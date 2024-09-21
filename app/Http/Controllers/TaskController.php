<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Eskul;
use Illuminate\Http\Request;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $userEskuls = DB::table('user_eskul')->where('user_id', Auth::id())->pluck('eskul_id');
        $tasks = Task::whereIn('eskul_id', $userEskuls)->with('submissions')->get();
        return Inertia::render('Task/Index', ['tasks' => $tasks]);
    }
     
    public function getSubmissions(Task $task)
    {
        $submissions = $task->submissions()->with('user')->get();
        return response()->json(['submissions' => $submissions]);
    }
    public function create()
    {
        $eskuls = Eskul::all(); // Ambil semua ekskul
        return Inertia::render('Task/Create', [
        'eskuls' => $eskuls,
    ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'eskul_id' => 'required|exists:eskuls,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        Task::create([
            'eskul_id' => $request->eskul_id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);
    }  
}
