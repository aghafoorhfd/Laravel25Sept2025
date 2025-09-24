<?php
namespace Modules\Course\Models;

use App\BaseModel;

class CourseTerm extends BaseModel
{
    protected $table = 'bravo_course_term';
    protected $fillable = [
        'term_id',
        'course_id'
    ];
}
