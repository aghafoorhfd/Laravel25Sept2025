<?php
namespace Modules\Course\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Models\Course;
use Illuminate\Http\Request;
use Modules\Course\Models\Course2User;
use Modules\Course\Models\CourseCategory;
use Modules\Course\Models\CourseModuleCompletion;
use Modules\Course\Models\CourseStudyLog;
use Modules\Course\Models\CourseUserCompletion;
use Modules\Location\Models\Location;
use Modules\Review\Models\Review;
use Modules\Core\Models\Attributes;
use DB;

class StudyController extends Controller
{
    protected $courseClass;
    protected $locationClass;
    public function __construct()
    {
        $this->courseClass = Course::class;
    }

    public function study(Request $request, $slug = '')
    {
        if(empty($slug)){
            return redirect('/');
        }
        $row = $this->courseClass::where('slug', $slug)->where("status", "publish")
            ->with(['translations','hasWishList','sections.lessons'])
            ->first();;
        if (empty($row)) {
            return redirect('/');
        }
        $user = Auth::user()->isStudentOf($row->id);

        if(empty($user) or empty($user['active'])){
            return redirect()->back();
        }

        $translation = $row->translateOrOrigin(app()->getLocale());

        $row->views++;
        $row->save();

        $data = [
            'row'          => $row,
            'translation'       => $translation,
            'seo_meta'  => $row->getSeoMetaWithTranslation(app()->getLocale(),$translation),
            'body_class'=>'is_single is_study_page',
            'review_data'=>$row->getScoreReview(),
            'header_transparent'=>1,
        ];
        $this->setActiveMenu($row);
        $this->registerJs('module/course/js/study.vue.js');
        return view('Course::frontend.study', $data);
    }

    public function studyLog(){
        \request()->validate([
            'course_id'=>'required',
            'section_id'=>'section_id',
            'module_id'=>'module_id',
        ]);

        $module_id = \request()->input('module_id');
        $course_id = \request()->input('course_id');
        $section_id = \request()->input('section_id');

        $user = Auth::user()->isStudentOf($course_id);
        if(empty($user) or empty($user['active'])){
            return $this->sendError(__("You are not student of this course"));
        }

        $log = new CourseStudyLog();
        $log->course_id = \request()->input('course_id');
        $log->module_id = \request()->input('module_id');
        $log->section_id = \request()->input('section_id');
        $log->user_id = Auth::id();

        $log->save();

        $completion = CourseModuleCompletion::query()->where('course_id',\request()->input('course_id'))
                                                    ->where('user_id',Auth::id())
                                                    ->where('module_id',$module_id)->first();
        if(!$completion){
            $completion = new CourseModuleCompletion();
            $completion->course_id = $course_id;
            $completion->module_id = $module_id;
            $completion->user_id = Auth::id();
            $completion->section_id = $section_id;
        }

        if(empty($completion->state)){
            $completion->state = 1;
            $completion->save();
        }

        return $this->sendSuccess([],'OK');
    }
}
