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
        $leaveRequests = LeaveRequest::where('user_id', Auth::id())->get();

        return Inertia::render('LeaveRequest/Index', [
            'leaveRequests' => $leaveRequests,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('LeaveRequest/Create');
    }

    public function store(LeaveRequestForm $request): RedirectResponse
    {
        $leaveRequest = new LeaveRequest();
        $leaveRequest->user_id = Auth::id();
        $leaveRequest->reason = $request->input('reason');
        $leaveRequest->leave_date = $request->input('leave_date');
    
        if ($request->hasFile('attachment')) {
            $leaveRequest->attachment = $request->file('attachment')->store('attachments', 'public');
        }
    
        $leaveRequest->save();
    
        return redirect()->route('leave-requests.index')->with('status', 'Leave request submitted.');
    }
    public function destroy($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        // Pastikan hanya pengguna yang membuat permintaan bisa menghapusnya
        if ($leaveRequest->user_id !== Auth::id()) {
            return redirect()->route('leave-requests.index')->with('error', 'Anda tidak memiliki izin untuk menghapus permintaan ini.');
        }

        $leaveRequest->delete();

        return redirect()->route('leave-requests.index')->with('success', 'Permintaan berhasil dihapus.');
    }
}
