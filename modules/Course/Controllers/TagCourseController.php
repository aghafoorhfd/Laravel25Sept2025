<?php
namespace Modules\Course\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\FrontendController;
use Modules\Course\Models\CourseCategory;
use Modules\Course\Models\Tag;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseTag;

class TagCourseController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if (empty($tag)) {
            return redirect('/course');
        }
        $listCourse = Course::query();
        $listCourse->select(['core_course.*'])->join('core_course_tag', 'core_course_tag.course_id', '=', 'core_course.id')
            ->where('core_course_tag.tag_id', $tag->id)
            ->with(['getAuthor','translations'])->with("getCategory");

        $translation = $tag->translateOrOrigin(app()->getLocale());

        $data = [
            'rows'           => $listCourse->paginate(5),
            'model_category' => CourseCategory::where("status", "publish"),
            'model_tag'      => Tag::query(),
            'model_course'     => Course::where("status", "publish"),
            'breadcrumbs'    => [
                [
                    'name' => __('Course'),
                    'url'  => route('course.index')
                ],
                [
                    'name'  => $translation->name,
                    'class' => 'active'
                ],
            ],
            'seo_meta'  => $tag->getSeoMetaWithTranslation(app()->getLocale(),$translation),
            'translation'=>$translation,
            'page_title'=>$translation->name ?? ''
        ];
        return view('Course::frontend.index', $data);
    }
}
