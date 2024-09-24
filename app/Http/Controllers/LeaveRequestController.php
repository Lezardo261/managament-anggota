<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LeaveRequestForm;

class LeaveRequestController extends Controller
{
    public function index(): Response
    {
        $userId = Auth::id();
        $userEskulIds = Auth::user()->eskuls->pluck('id');
    
        $leaveRequests = LeaveRequest::with('eskuls') // Ensure to load the related `eskuls`
            ->whereHas('eskuls', function ($query) use ($userEskulIds) {
                $query->whereIn('eskul_id', $userEskulIds);
            })
            ->where('user_id', $userId)
            ->get();
    
        return Inertia::render('LeaveRequest/Index', [
            'leaveRequests' => $leaveRequests,
        ]);
    }
    
    public function create(): Response
    {
        $userEskuls = Auth::user()->eskuls;
        
        return Inertia::render('LeaveRequest/Create', [
            'eskuls' => $userEskuls,
        ]);
    }
    
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => 'required|string',
            'leave_date' => 'required|date',
            'eskul_ids' => 'nullable|array',
            'eskul_ids.*' => 'exists:eskuls,id',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);
        $leaveRequest = LeaveRequest::create([
            'user_id' => Auth::id(),
            'reason' => $validated['reason'],
            'leave_date' => $validated['leave_date'],
            'attachment' => $request->hasFile('attachment') 
                            ? $request->file('attachment')->store('attachments', 'public') 
                            : null,
        ]);
        if (!empty($validated['eskul_ids'])) {
            $leaveRequest->eskuls()->sync($validated['eskul_ids']);
        }
        return redirect()->route('leave-requests.index')->with('status', 'Leave request submitted.');
    }
    public function destroy($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        $leaveRequest->delete();
    }
}
