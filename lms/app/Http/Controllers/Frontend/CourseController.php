<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CourseBasicInfoCreateRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use function Ramsey\Uuid\v1;

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
                $categories = CourseCategory::where('status',1)->get();
                return view('frontend.instructor.course.more-info')->with('categories', $categories);
                break;

            case '3':
                return view('frontend.instructor.course.course-content');
                break;

            case '4':
                return view('frontend.instructor.course.finish');
                break;

            default:
                // Fallback to step 1 if invalid step provided
                return view('frontend.instructor.course.create');
                break;
        }
    }
}
