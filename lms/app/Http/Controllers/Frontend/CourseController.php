<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CourseBasicInfoCreateRequest;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class CourseController extends Controller
{
    function index():View{
        return view('frontend.instructor.course.index');
    }
    function create():View{
        return view('frontend.instructor.course.create');
    }

    function storeBasicInfo(CourseBasicInfoCreateRequest $request){
        $course = new Course();

        $course->title =$request ->title;
        $course->slug  =Str::slug($request->title);
        $course->seo_description =$request ->seo_description;
        $course->thumbnail ='';
        $course->demo_video_storage =$request ->demo_video_storage;
        $course->demo_video_source =$request ->demo_video_source;
        $course->price =$request ->price;
        $course->discount =$request ->discount;
        $course->description =$request ->description;
        $course->instructor_id =Auth::guard('web')->user()->id;
        $course->save();

        return response([
            'status'=>'success',
            'message'=>'Updated successfully'
        ]);
    }
}

