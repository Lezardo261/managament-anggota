<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(): Response
    {
        // Mengirimkan data pengguna ke view Inertia
        return Inertia::render('Dashboard');
    }
}

