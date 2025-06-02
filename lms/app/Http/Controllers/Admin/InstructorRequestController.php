<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
class InstructorRequestController extends Controller
{
    // This method handles the display of all pending instructor requests
    public function index(): View
    {   
        // Fetch all users where the 'approve_status' is set to 'pending'
        // These represent instructors who have requested approval but haven't been approved yet
        $instructorRequests = User::where('approve_status', 'pending')
        ->orWhere('approve_status', 'rejected')
        ->get();

        // Return the view for displaying instructor requests, passing the fetched data to the view
        return view('admin.instructor-request.index', compact('instructorRequests'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);
        
        $instructor_request = User::findOrFail($id);
        $instructor_request->approve_status = $request->status;
        $request->status == 'approved' ? $instructor_request->role = 'instructor' : "";
        $instructor_request->save();
        
        return redirect()->back()->with('success', 'Instructor request updated successfully');
    }

    public function show($id)
    {
        $instructorRequest = User::findOrFail($id);
        return view('admin.instructor-request.show', compact('instructorRequest'));
    }
    public function download(User $user){
        return response()->download(public_path($user->document));


    }

}
