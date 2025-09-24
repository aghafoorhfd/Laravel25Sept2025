<?php
namespace Modules\Course\Models;

use App\BaseModel;

class SectionsTranslation extends BaseModel
{
    protected $table = 'bravo_course_section_translations';
    protected $fillable = [
        'name',
    ];
}
