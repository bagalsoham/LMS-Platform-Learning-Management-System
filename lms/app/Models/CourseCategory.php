<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseCategory extends Model
{
    use HasFactory;
    function subCartegories() :HasMany{
        return $this-> hasMany(CourseCategory:: class,'parent_id' );
    }

}
