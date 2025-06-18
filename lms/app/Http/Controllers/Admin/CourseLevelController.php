<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseLevel;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $levels = CourseLevel::paginate(15);
        return view('admin.course.course-level.index', compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.course.course-level.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => ['required', 'max:255', 'unique:course_levels']]);
        $level = new CourseLevel();
        $level->name = $request->name;
        $level->slug = Str::slug($request->name);
        $level->save();

        notyf()->success('Created successfully');
        return to_route('admin.course-levels.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseLevel $course_level)
    {
        return view('admin.course.course-level.edit', compact('course_level'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseLevel $course_level): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:course_levels,name,' . $course_level->id]
        ]);

        $course_level->name = $request->name;
        $course_level->slug = Str::slug($request->name);
        $course_level->save();

        notyf()->success('Updated successfully');
        return to_route('admin.course-levels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseLevel $course_level)
    {
        try {
            $course_level->delete();
            notyf()->success('Deleted Successfully');
        } catch (Exception $e) {
            logger($e);
            return response(['message' => 'Something went wrong'], 500);
        }
    }
}
