<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class InstructorDashboardController extends Controller
{
    /**
     * Display the instructor dashboard.
     */
    public function index(): View
    {
        return view('frontend.instructor.dashboard');
    }
}
