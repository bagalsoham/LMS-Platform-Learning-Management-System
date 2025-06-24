<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Pest\ArchPresets\Strict;

class CourseContentController extends Controller
{
    function createChapterModal(): String
    {
        // This method can be used to list course contents
        return view('frontend.instructor.course.partials.course-chapter-modal')->render();
    }
}
