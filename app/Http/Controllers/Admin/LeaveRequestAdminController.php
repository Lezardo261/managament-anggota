<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaveRequestAdminController extends Controller
{
    public function index()
    {
        // Dapatkan semua permintaan cuti untuk admin
        $leaveRequests = LeaveRequest::with('user')->get();

        return Inertia::render('Admin/LeaveRequests', [
            'leaveRequests' => $leaveRequests
        ]);
    }

    public function approve($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->status = 'Approved';
        $leaveRequest->save();
    }

    public function reject($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->status = 'Rejected';
        $leaveRequest->save();
    }
}
