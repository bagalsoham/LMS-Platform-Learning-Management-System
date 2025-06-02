<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\User;
class InstructorRequestController extends Controller
{
    // This method handles the display of all pending instructor requests
    public function index(): View
    {   
        // Fetch all users where the 'approve_status' is set to 'pending'
        // These represent instructors who have requested approval but haven't been approved yet
        $instructorRequests = User::where('approve_status', 'pending')->get();

        // Return the view for displaying instructor requests, passing the fetched data to the view
        return view('admin.instructor-request.index', compact('instructorRequests'));
    }

}
