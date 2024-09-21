<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // Import the WithHeadings concern
use App\Models\User;
use App\Models\LeaveRequest;

class UserStatsExport implements FromCollection, WithHeadings // Implement the WithHeadings interface
{
    protected $eskulIds;

    public function __construct($eskulIds)
    {
        $this->eskulIds = $eskulIds;
    }

    public function collection()
    {
        // Fetch users associated with the eskul IDs
        $users = User::whereHas('eskuls', function ($query) {
            $query->whereIn('eskul_id', $this->eskulIds);
        })->get()->map(function ($user) {
            return [
                'Name' => $user->name,
                'NIS' => $user->nis,
                'Kelas' => $user->kelas,
                'Hadir' => $user->attendances()->count(),
                'Izin' => $user->leaveRequests()->where('reason', 'izin')->count(),
                'Sakit' => $user->leaveRequests()->where('reason', 'sakit')->count(),
            ];
        });

        return collect($users);
    }

    public function headings(): array
    {
        return [
            'Name',
            'NIS',
            'Kelas',
            'Hadir',
            'Izin',
            'Sakit',
        ];
    }
}
