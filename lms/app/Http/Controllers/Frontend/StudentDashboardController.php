<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class StudentDashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index(): View
    {
        // 'dashboard' naam ka view return karta hai (resources/views/dashboard.blade.php)
        return view('frontend.student.dashboard');
    }
}
