<?php
namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeaveRequestAdminController extends Controller
{
    public function index()
    {
        $adminUser = Auth::user();
        $adminEskulIds = $adminUser->eskuls->pluck('id')->toArray();
    
        $leaveRequests = LeaveRequest::with(['user', 'user.eskuls', 'eskuls'])
            ->whereHas('eskuls', function($query) use ($adminEskulIds) {
                $query->whereIn('eskul_id', $adminEskulIds);
            })
            ->get();
    
        return Inertia::render('Admin/LeaveRequests', [
            'leaveRequests' => $leaveRequests,
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
