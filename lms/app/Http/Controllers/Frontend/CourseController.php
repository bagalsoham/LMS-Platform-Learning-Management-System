<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CourseBasicInfoCreateRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseChapter;
use App\Models\CourseLanguage;
use App\Models\CourseLevel;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    use FileUpload;

    function index(): View
    {
        $courses = Course::where('instructor_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('frontend.instructor.course.index', compact('courses'));
    }

    function create(): View
    {
        return view('frontend.instructor.course.create');
    }


    function storeBasicInfo(CourseBasicInfoCreateRequest $request)
    {
        // DRY RUN: Log all request data for debugging
        Log::info('Course Create Request', $request->all());
        $thumbnailPath = $this->uploadFile($request->file('thumbnail'));
        $course = new Course();
        $course->title = $request->title;
        $course->slug = Str::slug($request->title);
        $course->seo_description = $request->seo_description;
        $course->thumbnail = $thumbnailPath;
        $course->demo_video_storage = $request->demo_video_storage;
        // Save demo_video_source from file or url
        $course->demo_video_source = $request->file ?? $request->url;
        $course->price = $request->price;
        $course->discount = $request->discount;
        $course->description = $request->description;
        $course->instructor_id = Auth::guard('web')->user()->id;
        $course->save();

        // save course id on session
        Session::put('course_create_id', $course->id);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'redirect' => route('instructor.course.edit', ['id' => $course->id, 'step' => 2])
            ]);
        }

        return redirect()->route('instructor.course.edit', ['id' => $course->id, 'step' => 2]);
    }

    function edit(Request $request)
    {

        switch ($request->step) {
            case '1':
                $course = Course::findOrFail($request->id);
                return view('frontend.instructor.course.edit', compact('course'));
                break;

            case '2':
                $categories = CourseCategory::where('status', 1)->get();
                $levels = CourseLevel::all();
                $languages = CourseLanguage::all();
                $course = Course::findOrFail($request->id);
                return view('frontend.instructor.course.more-info', compact('categories', 'levels', 'languages', 'course'));
                break;

            case '3':
                $courseId = $request->id;
                $chapters = CourseChapter::where(['course_id' => $courseId, 'instructor_id' => Auth::user()->id])->orderBy('order')->get();

                return view('frontend.instructor.course.course-content', compact('courseId','chapters'));
                break;

            case '4':
                $courseId = $request->id;
                $course = Course::findOrFail($request->id);
                $editMode = true;
                return view('frontend.instructor.course.finish', compact('course', 'editMode'));
                break;
        }
    }

    function update(Request $request)
    {
        // dd($request->all());
        switch ($request->current_step) {
            case '1':
                $rules = [
                    'title' => ['required', 'max:255', 'string'],
                    'seo_description' => ['nullable', 'max:255', 'string'],
                    'demo_video_storage' => ['nullable', 'in:youtube,vimeo,external_link,upload', 'string'],
                    'price' => ['required', 'numeric'],
                    'discount' => ['nullable', 'numeric'],
                    'description' => ['required'],
                    'thumbnail' => ['nullable', 'image', 'max:3000'],
                    'demo_video_source' => ['nullable']
                ];

                $request->validate($rules);

                $course = Course::findOrFail($request->id);

                if ($request->hasFile('thumbnail')) {
                    $thumbnailPath = $this->uploadFile($request->file('thumbnail'));
                    $this->deleteFile($course->thumbnail);
                    $course->thumbnail = $thumbnailPath;
                }

                $course->title = $request->title;
                $course->slug = Str::slug($request->title);
                $course->seo_description = $request->seo_description;
                $course->demo_video_storage = $request->demo_video_storage;
                $course->demo_video_source = $request->filled('file') ? $request->file : $request->url;
                $course->price = $request->price;
                $course->discount = $request->discount;
                $course->description = $request->description;
                $course->instructor_id = Auth::guard('web')->user()->id;
                $course->save();

                // save course id on session
                Session::put('course_create_id', $course->id);

                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'success',
                        'redirect' => route('instructor.course.edit', ['id' => $course->id, 'step' => $request->next_step])
                    ]);
                }
                return redirect()->route('instructor.course.edit', ['id' => $course->id, 'step' => $request->next_step]);
            case '2':
                // validation
                $request->validate([
                    'capacity' => ['nullable', 'numeric'],
                    'duration' => ['required', 'numeric'],
                    'qna' => ['nullable', 'boolean'],
                    'certificate' => ['nullable', 'boolean'],
                    'category' => ['required', 'integer'],
                    'level' => ['required', 'integer'],
                    'language' => ['required', 'integer'],
                ]);

                // update course data
                $course = Course::findOrFail($request->id);
                $course->capacity = $request->capacity;
                $course->duration = $request->duration;
                $course->qna = $request->qna ? 1 : 0;
                $course->certificate = $request->certificate ? 1 : 0;
                $course->category_id = $request->category;
                $course->course_level_id = $request->level;
                $course->course_language_id = $request->language;
                $course->save();

                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'success',
                        'redirect' => route('instructor.course.edit', ['id' => $request->id, 'step' => $request->next_step])
                    ]);
                }
                return redirect()->route('instructor.course.edit', ['id' => $request->id, 'step' => $request->next_step]);
            case '3':
                return response()->json([
                    'status' => 'success',
                    'message' => 'Updated successfully.',
                    'redirect' => route('instructor.course.edit', ['id' => $request->id, 'step' => $request->next_step])
                ]);
            case '4':
                // validation
                $request->validate([
                    'message' => ['nullable', 'max:1000', 'string'],
                    'status' => ['required', 'in:active,inactive,draft']
                ]);

                // update course data
                $course = Course::findOrFail($request->id);
                $course->message_for_reviewer = $request->message;
                $course->status = $request->status;
                $course->save();

                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'success',
                        'redirect' => route('instructor.course.index')
                    ]);
                }
                return redirect()->route('instructor.course.index');
            default:
                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid step.'
                    ], 400);
                }
                notyf()->error('Invalid step.');
                return redirect()->route('instructor.course.index');
        }
    }
}
