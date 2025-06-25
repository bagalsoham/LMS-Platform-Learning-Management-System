<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CourseChapter;
use App\Models\CourseChapterLesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class CourseContentController extends Controller
{
    function createChapterModal(string $id): string
    {
        return view('frontend.instructor.course.partials.course-chapter-modal', compact('id'))->render();
    }

    function storeChapter(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $chapter = new CourseChapter();
        $chapter->title = $request->title;
        $chapter->course_id = $id;
        $chapter->instructor_id = Auth::user()->id;
        $chapter->order = CourseChapter::where('course_id', $id)->count() + 1;
        $chapter->save();
        notyf()->success('Chapter created successfully');
        return redirect()->back();
    }

    function createLesson(Request $request): string // Fixed return type
    {
        $courseId = $request->course_id;
        $chapterId = $request->chapter_id;
        $id = null;

        return view('frontend.instructor.course.partials.chapter-lesson-modal', compact('courseId', 'chapterId', 'id'))->render();
    }

    function storeLesson(Request $request): RedirectResponse
    {
        // Remove dd() for production - only use for debugging
        /*         dd($request->all());
 */
        $request->validate([
            'title' => 'required|string|max:255',
            'source' => 'required|string',
            'file_type' => 'required|in:video,audio,doc,pdf,file', // Fixed validation key
            'duration' => 'nullable|string',
            'is_preview' => 'nullable|boolean',
            'downloadable' => 'nullable|boolean',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'chapter_id' => 'required|exists:course_chapters,id',
        ]);

        $lesson = new CourseChapterLesson();
        $lesson->title = $request->title;
        $lesson->slug = Str::slug($request->title) . '-' . uniqid();
        $lesson->storage = $request->source;
        $lesson->file_path = $request->filled('file') ? $request->file : $request->url;
        $lesson->file_type = $request->file_type;
        $lesson->duration = $request->duration;
        $lesson->is_preview = $request->has('is_preview') ? 1 : 0; // Fixed boolean handling
        $lesson->downloadable = $request->has('downloadable') ? 1 : 0; // Fixed boolean handling
        $lesson->description = $request->description;
        $lesson->instructor_id = Auth::user()->id;
        $lesson->course_id = $request->course_id;
        $lesson->chapter_id = $request->chapter_id;
        $lesson->order = CourseChapterLesson::where('chapter_id', $request->chapter_id)->count() + 1;
        $lesson->save();


        notyf()->success('Lesson created successfully');
        return redirect()->back();
    }
    function editLesson(Request $request): String
    {
        $editMode = true; // Set edit mode to true
        $courseId = $request->course_id;
        $chapterId = $request->chapter_id;
        $lessonId = $request->lesson_id;

        // Loosen the query to just id and instructor_id
        $lesson = CourseChapterLesson::where([
            'chapter_id' => $chapterId,
            'course_id' => $courseId,
            'instructor_id' => Auth::user()->id,
            'id' => $lessonId
        ])->first();

        if (!$lesson) {
            return response()->json(['error' => 'Lesson not found'], 404);
        }

        return view('frontend.instructor.course.partials.chapter-lesson-modal', compact('courseId', 'chapterId', 'lesson' ,'editMode'))->render();
    }
    function updateLesson(Request $request,string $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'source' => 'required|string',
            'file_type' => 'in:video,audio,doc,pdf,file', // Fixed validation key
            'duration' => 'nullable|string',
            'is_preview' => 'nullable|boolean',
            'downloadable' => 'nullable|boolean',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'chapter_id' => 'required|exists:course_chapters,id',
        ]);

        $lesson = CourseChapterLesson::findOrFail($id);
        $lesson->title = $request->title;
        $lesson->slug = Str::slug($request->title) . '-' . uniqid();
        $lesson->storage = $request->source;
        $lesson->file_path = $request->filled('file') ? $request->file : ($request->url ?? $lesson->file_path);
        $lesson->file_type = $request->file_type;
        $lesson->duration = $request->duration;
        $lesson->is_preview = $request->has('is_preview') ? 1 : 0; // Fixed boolean handling
        $lesson->downloadable = $request->has('downloadable') ? 1 : 0; // Fixed boolean handling
        $lesson->description = $request->description;
        $lesson->instructor_id = Auth::user()->id;
        $lesson->course_id = $request->course_id;
        $lesson->chapter_id = $request->chapter_id;
        // No need to update order, it remains the same
        $lesson->save();

        notyf()->success('Lesson updated successfully');
        return redirect()->back();
    }

}
