<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CourseChapter;
use Illuminate\Support\Facades\Auth; // ✅ Correct import
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseContentController extends Controller
{
    function createChapterModal(string $id): string // lowercase 's' is more conventional
    {
        // This method can be used to list course contents
        return view('frontend.instructor.course.partials.course-chapter-modal', compact('id'))->render();
    }

    function storeChapter(Request $request, string $id): RedirectResponse
    {
/*         dd($request->all()); // ✅ This will help you debug the request data
 */
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $chapter = new CourseChapter();
        $chapter->title = $request->title;
        $chapter->course_id = $id; // ✅ Assign course_id from the method parameter
        $chapter->instructor_id = Auth::user()->id; // ✅ Now Auth::user() will work
        $chapter->order = CourseChapter::where('course_id', $id)->count() + 1; // Set order based on existing chapters
        $chapter->save(); // ✅ Don't forget to save the model

        // Return redirect response
        return redirect()->back();
    }
}
