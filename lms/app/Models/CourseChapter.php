<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseChapter extends Model
{
    use HasFactory;
    function lessons()
    {

        return $this->hasMany(CourseChapterLesson::class, 'chapter_id', 'id')->orderBy('order');
    }
}
