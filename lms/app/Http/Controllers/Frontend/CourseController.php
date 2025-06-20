<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CourseBasicInfoCreateRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLanguage;
use App\Models\CourseLevel;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    use FileUpload;

    function index(): View
    {
        return view('frontend.instructor.course.index');
    }

    function create(): View
    {
        return view('frontend.instructor.course.create');
    }

    function storeBasicInfo(CourseBasicInfoCreateRequest $request)
    {
        $thumbnailPath = $this->uploadFile($request->file('thumbnail'));
        $course = new Course();

        $course->title = $request->title;
        $course->slug  = Str::slug($request->title);
        $course->seo_description = $request->seo_description;
        $course->thumbnail = $thumbnailPath;
        $course->demo_video_storage = $request->demo_video_storage;
        $course->demo_video_source = $request->demo_video_source;
        $course->price = $request->price;
        $course->discount = $request->discount;
        $course->description = $request->description;
        $course->instructor_id = Auth::guard('web')->user()->id;
        $course->save();

        //save id on session
        Session::put('course_create_id', $course->id);

        return response([
            'status' => 'success',
            'message' => 'Updated successfully',
            'redirect' => route('instructor.course.edit', ['id' => $course->id, 'step' => $request->next_step]),
        ]);
    }

    function edit(Request $request)
    {
        switch ($request->step) {
            case '1':
                return view('frontend.instructor.course.create');
                break;

            case '2':
                $course = Course::find($request->id);
                $categories = CourseCategory::where('status', 1)
                    ->whereNull('parent_id') // Only get parent categories
                    ->with(['subcategories' => function ($query) {
                        $query->where('status', 1); // Only active subcategories
                    }])
                    ->get();
                $levels = CourseLevel::all();
                $languages = CourseLanguage::all();

                return view('frontend.instructor.course.more-info', compact('course', 'categories', 'levels', 'languages'));
                break;

            case '3':
                return view('frontend.instructor.course.course-content');
                break;

            case '4':
                return view('frontend.instructor.course.finish');
                break;

            default:
                return view('frontend.instructor.course.create');
                break;
        }
    }

    function update(Request $request, $id = null)
    {
        switch ($request->step) {
            case '1':
                # code...
                break;
            case '2':
                $request->validate([
                    'capacity' => ['nullable', 'numeric'],
                    'duration' => ['required', 'numeric'],
                    'qna' => ['nullable', 'boolean'],
                    'certificate' => ['nullable', 'boolean'],
                    'category' => ['required', 'integer'],
                    'level' => ['required', 'integer'],
                    'language' => ['required', 'integer'],
                ]);


                $course = Course::findOrFail($id);
                $course->capacity = (int)$request->capacity;
                $course->duration = (float)$request->duration;
                $course->qna = $request->qna ? 1 : 0;
                $course->certificate = $request->certificate ? 1 : 0;
                $course->category_id = (int)$request->category;
                $course->course_level_id = (int)$request->level;
                $course->course_language_id = (int)$request->language;
                $course->save();
                // ... rest of code

                return response([
                    'status' => 'success',
                    'message' => 'Updated successfully',
                    'redirect' => route('instructor.course.edit', ['id' => $course->id, 'step' => 3])
                ]);
                break;
            case '3':
                # code...
                break;
            case '4':
                # code...
                break;
            default:
                # code...
                break;
        }
    }
}
