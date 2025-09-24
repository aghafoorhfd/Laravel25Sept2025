<?php
namespace Modules\Course\Models;

use App\BaseModel;

class CourseTranslation extends BaseModel
{
    protected $table = 'bravo_course_translations';
    protected $fillable = [
        'title',
        'content',
        'short_desc',
        'address',
        'faqs',
        'include',
        'exclude',
        'itinerary',
    ];
    protected $slugField     = false;
    protected $seo_type = 'course_translation';
    protected $cleanFields = [
        'content'
    ];
    protected $casts = [
        'faqs' => 'array',
        'include' => 'array',
        'exclude' => 'array',
        'itinerary' => 'array',
    ];
    public function getSeoType(){
        return $this->seo_type;
    }
}
