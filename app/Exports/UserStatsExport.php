<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserStatsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $users = User::all()->map(function ($user) {
            return [
                'Name' => $user->name,
                'Attendances' => $user->attendances()->count(),
                'Izin' => $user->leaveRequests()->where('reason', 'izin')->count(),
                'Sakit' => $user->leaveRequests()->where('reason', 'sakit')->count(),
            ];
        });

        return $users;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Hadir',
            'Izin',
            'Sakit',
        ];
    }
}
