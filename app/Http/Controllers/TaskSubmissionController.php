<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TaskCollection;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Auth;

class TaskSubmissionController extends Controller
{
    public function store(Request $request)
    {
        // Validate data
        $request->validate([
            'submission_text' => 'required|string',
            'files.*' => 'nullable|file|max:10240', // Maximum 10MB per file
            'task_id' => 'required|exists:tasks,id',
        ]);

        $files = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('submissions', 'public');
                $files[] = $path;
            }
        }

        TaskSubmission::create([
            'task_id' => $request->task_id,
            'user_id' => Auth::id(),
            'submission_text' => $request->submission_text,
            'file' => json_encode($files), 
        ]);        
    }
}