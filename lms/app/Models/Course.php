<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    function subCategories():HasMany
    {
        return $this->hasMany(CourseCategory::class, 'parent_id');
    }
}
