<?php
namespace Modules\Course\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Lessons extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bravo_course_lessons';
    protected $fillable = [
        'name',
        'content',
        'duration',
        'image_id',
        'course_id',
        'active',
        'url',
        'type',
        'preview_url',
        'downloadable'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';

    /**
     * @param $lesson_IDs array or number
     * @return mixed
     */
    static public function getLessonsById($lesson_IDs){
        $listLessons = [];
        if(empty($lesson_IDs)) return $listLessons;
        $lessons = parent::query()->with(['translations','section'])->find($lesson_IDs);
        if(!empty($lessons)){
            foreach ($lessons as $lesson){
                if(!empty($attr = $lesson->section)){
                    if(empty($listLessons[$lesson->attr_id]['child'])) $listLessons[$lesson->attr_id]['parent'] = $attr;
                    if(empty($listLessons[$lesson->attr_id]['child'])) $listLessons[$lesson->attr_id]['child'] = [];
                    $listLessons[$lesson->attr_id]['child'][] = $lesson;
                }
            }
        }
        return $listLessons;
    }

    public function section()
    {
        return $this->hasOne("Modules\Course\Models\Sections", "id" , "section_id");
    }

    public function course()
    {
        return $this->hasOne("Modules\Course\Models\Course", "id" , "course_id");
    }


    public static function getForSelect2Query($service,$q=false)
    {
        $query =  static::query()->select('bravo_course_lessons.id', DB::raw('CONCAT(at.name,": ",bravo_course_lessons.name) as text'))
        ->join('bravo_course_section as bcs','bcs.id','=','bravo_course_lessons.attr_id')
        ->where("bcs.service",$service)
        ->whereRaw("bcs.deleted_at is null");

        if ($query) {
            $query->where('bravo_course_lessons.name', 'like', '%' . $q . '%');
        }
        return $query;
    }

    public function getDurationHtmlAttribute(){
        return $this->duration_html = $this->duration ? convertToHoursMinutes($this->duration) : '';
    }

    public function getDownloadableLink(){
        $url = '';
        if($this->downloadable > 0){
            $media = \DB::table('media_files')->where('id', $this->downloadable)->first();
            $url = $media ? (($this->type == 'video')? 'storage/'.$media->file_path : 'uploads/'.$media->file_path) : '#';
        }
        return $url;
    }
    public function getStudyUrlAttribute(){
        $url = $this->file_id ? get_file_url($this->file_id) : $this->url;
        switch ($this->type){
            case "presentation":
                if($this->file_id) {
                    if (strpos($url, '.ppt')) {
                        $url = asset('libs/ViewerJS/#' . ($url));
                    } else {
                        $url = asset('libs/pdfjs/web/viewer.html?file=' . urlencode($url));
                    }
                }
                break;
            case "scorm":
                if($this->file_id){
                    $url = route('course.scorm_player',['id'=>$this->file_id]);
                }
                break;
        }
        if(!$this->file_id){
            $url = getYoutubeEmbedUrl($url);
        }
        return $url;
    }

}
