<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Attend;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class AttendController extends Controller
{

    
    public function store(Request $request)
    {
        $photo = $request->input('photo');
        $photo = str_replace('data:image/png;base64,', '', $photo);
        $photo = str_replace(' ', '+', $photo);
        $photoData = base64_decode($photo);
        $filename = 'attendance/' . uniqid() . '.png';
        Storage::disk('public')->put($filename, $photoData);
        DB::table('attendances')->insert([
            'user_id' => Auth::user()->id,
            'schedule_id' => $request->input('schedule_id'),
            'photo_path' => $filename,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
