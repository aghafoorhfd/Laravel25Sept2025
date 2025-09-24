<?php
namespace Modules\Course\Models;

use App\BaseModel;

class CourseCategoryTranslation extends BaseModel
{
    protected $table = 'bravo_course_category_translations';
    protected $fillable = [
        'name',
        'content',
    ];
    protected $cleanFields = [
        'content'
    ];
}
