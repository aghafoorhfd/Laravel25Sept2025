<?php
namespace Modules\Course\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTag extends BaseModel
{
    use SoftDeletes;
    protected $table = 'core_course_tag';
    protected $fillable = [
        'course_id',
        'tag_id'
    ];

    public static function getModelName()
    {
        return __("Course Tag");
    }

    public static function searchForMenu($q = false)
    {

    }

    public function tag()
    {
        return $this->belongsTo('Modules\Course\Models\CourseTag');
    }

    public static function getAll()
    {
        return self::with('tag')->get();
    }

    public static function addTag($tags_ids, $course_id)
    {
        if (!empty($tags_ids)) {
            foreach ($tags_ids as $tag_id) {
                $find = parent::where('course_id', $course_id)->where('tag_id', $tag_id)->first();
                if (empty($find)) {

                    $a = new self();
                    $a->course_id = $course_id;
                    $a->tag_id = $tag_id;
                    $a->save();
                }
            }
        }
    }

    public static function getTags(){

        $query = Tag::query()->with('translations');

        $query->select(['core_tags.*']);

        return $query
            ->join('core_course_tag as nt','nt.tag_id','=','core_tags.id')->orderByRaw('RAND()')
            ->groupBy('core_tags.id')
            ->get(10);

    }
}
