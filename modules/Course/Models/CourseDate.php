<?php
namespace Modules\Course\Models;

use App\BaseModel;

class CourseDate extends BaseModel
{
    protected $table = 'bravo_course_dates';
    protected $courseMetaClass;

    protected $casts = [
        'person_types'=>'array'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->courseMetaClass = CourseMeta::class;
    }

    public static function getDatesInRanges($date,$target_id){
        return static::query()->where([
            ['start_date','>=',$date],
            ['end_date','<=',$date],
            ['target_id','=',$target_id],
        ])->first();
    }
    public function saveMeta(\Illuminate\Http\Request $request)
    {
        $locale = $request->input('lang');
        $meta = $this->courseMetaClass::where('course_date_id', $this->id)->first();
        if (!$meta) {
            $meta = new $this->courseMetaClass();
            $meta->course_date_id = $this->id;
        }
        return $meta->saveMetaOriginOrTranslation($request->input() , $locale);
    }
}
