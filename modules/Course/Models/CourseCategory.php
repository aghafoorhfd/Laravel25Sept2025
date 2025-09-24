<?php
namespace Modules\Course\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseCategory extends BaseModel
{
    use SoftDeletes;
    use NodeTrait;
    protected $table = 'bravo_course_category';
    protected $fillable = [
        'name',
        'image_id',
        'content',
        'slug',
        'status',
        'parent_id'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';

    public static function getModelName()
    {
        return __("Course Category");
    }

    public function countCourse()
    {
        return $this->hasMany(Course::class, "category_id", 'id');
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'name');
        if (strlen($q)) {
            $query->where('name', 'like', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
        return $a;
    }
    public function getDetailUrl(){
        return url(app_get_locale(false, false, '/') . config('course.course_route_prefix').'?cat_id[]='.$this->id);
    }
}
