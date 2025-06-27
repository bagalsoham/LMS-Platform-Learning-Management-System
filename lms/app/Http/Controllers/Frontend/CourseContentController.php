<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Models\CourseChapter;
use App\Models\CourseChapterLesson;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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


    public function editChapterModal(string $id): string
    {
        $editMode = true;
        $chapter = CourseChapter::where([
            'id' => $id,
            'instructor_id' => Auth::user()->id,
        ])->firstOrFail();
        return view('frontend.instructor.course.partials.course-chapter-modal', ['chapter' => $chapter, 'editMode' => $editMode])->render();
    }

    function updateChapterModal(Request $request,string $id):RedirectResponse{

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $chapter = CourseChapter::findOrFail($id);
        $chapter->title = $request->title;
        $chapter->save();

        notyf()->success('Chapter updated successfully');
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
            'file_type' => 'required|in:video,audio,doc,pdf,file',
            'duration' => 'nullable|string',
            'is_preview' => 'nullable|boolean',
            'downloadable' => 'nullable|boolean',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'chapter_id' => 'required|exists:course_chapters,id',
            'file' => 'required_without:url',
            'url' => 'required_without:file',
        ], [
            'file.required_without' => 'Either a file or a URL is required.',
            'url.required_without' => 'Either a file or a URL is required.',
        ]);

        $lesson = new CourseChapterLesson();
        $lesson->title = $request->title;
        $lesson->slug = Str::slug($request->title) . '-' . uniqid();
        $lesson->storage = $request->source;
        $lesson->file_path = $request->filled('file') ? $request->file : $request->url;
        $lesson->file_type = $request->file_type;
        $lesson->duration = $request->duration;
        $lesson->is_preview = $request->has('is_preview') ? 1 : 0;
        $lesson->downloadable = $request->has('downloadable') ? 1 : 0;
        $lesson->description = $request->description;
        $lesson->instructor_id = Auth::user()->id;
        $lesson->course_id = $request->course_id;
        $lesson->chapter_id = $request->chapter_id;
        $lesson->order = CourseChapterLesson::where('chapter_id', $request->chapter_id)->count() + 1;
        $lesson->save();


        notyf()->success('Lesson created successfully');
        return redirect()->back();
    }

    function destroyChapter(string $id): Response
    {
        try {
            // delete chapter
            $chapter = CourseChapter::findOrFail($id);
            $chapter->delete();
            notyf()->success('Deleted Successfully!');
            return response(['message' => 'Deleted Successfully!'], 200);
        } catch (Exception $e) {
            logger("Course Level Error >> " . $e);
            return response(['message' => 'Something went wrong!'], 500);
        }
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

        return view('frontend.instructor.course.partials.chapter-lesson-modal', compact('courseId', 'chapterId', 'lesson', 'editMode'))->render();
    }
    function updateLesson(Request $request, string $id): RedirectResponse
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


    public function destroyLesson(Request $request, string $id): Response
    {
        try {
            $lesson = CourseChapterLesson::findOrFail($id);
            $lesson->delete();
            notyf()->success('Deleted Successfully!');
            return response(['message' => 'Deleted Successfully!'], 200);
        } catch (Exception $e) {
            logger("Course Sub Category Error >> " . $e);
            return response(['message' => 'Something went wrong!'], 500);
        }
    }

    /* Sort chapter lesson */
    public function sortLesson(Request $request , string $id){//jquery.min.js is used for this
        $newOrder = $request->order_ids;
        foreach($newOrder as $key => $itemId){
            $lesson = CourseChapterLesson::where(['chapter_id' => $id, 'id' => $itemId])->first();
            if ($lesson) {
                $lesson->order = $key + 1; // since the keys start from 0, we add 1 to make it start from 1
                $lesson->save();
            }
        }
        return response(['status' => 'success', 'message' => 'Updated successfully!'], 200);

    }

    function sortChapter(string $id):string{
        $chapters =CourseChapter::where('course_id', $id)->orderBy('order')->get();
        return view('frontend.instructor.course.partials.course-chapter-sort-modal', compact('chapters', 'id'))->render();

    }
    function updateSortChapter(Request $request, string $id): RedirectResponse{
        $newOrder = $request->order_ids;
        foreach ($newOrder as $key => $itemId) {
            $chapter = CourseChapter::where(['course_id' => $id, 'id' => $itemId])->first();
            $chapter->order = $key + 1; // since the keys start from 0, we add 1 to make it start from 1
            $chapter->save();
        }
        notyf()->success('Chapter order updated successfully');
        return redirect()->back();
    }
}
