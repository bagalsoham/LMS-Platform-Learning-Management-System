<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\FileUpload;

class StudentDashboardController extends Controller
{
    use FileUpload;
    /**
     * Display the student dashboard.
     */
    public function index(): View
    {
        // 'dashboard' naam ka view return karta hai (resources/views/dashboard.blade.php)
        return view('frontend.student.dashboard');
    }
    public function becomeinstructor():View {
        return view('frontend.student.become-instructor.index');
        if(auth()->user()->role == 'instructor') abort(403);
    }
    public function becomeinstructorUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'document' => ['required', 'mimes:pdf,doc,docx,jpg,png', 'max:12000']
        ]);

        $user = auth()->user();
        $filePath = $this->uploadFile($request->file('document'));
        $user->update([
            'approve_status' => 'pending',
            'document' => $filePath
        ]);

        notyf()->info('Your instructor application has been submitted and is being reviewed.');
        return redirect()->route('student.dashboard');
    }
}
