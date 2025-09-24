<?php

namespace Modules\Course\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseTerm;
use Modules\Course\Models\CourseTranslation;
use Modules\Core\Models\Attributes;
use Modules\Course\Models\CourseCategory;
use Modules\Course\Models\Lessons;

class LectureController extends \Modules\Course\Admin\LectureController
{

    public function index($id = '')
    {
        $row = $this->checkItemPermission($id);

        if(empty($row)){
            abort(403);
        }

        $data = [
            'rows'=>$row->sections,
            'row'=>$row,
            'page_title'=>__("Lessons Management"),
            'breadcrumbs'        => [
                [
                    'name' => __('Courses'),
                    'url'  => route('course.vendor.index')
                ],
                [
                    'name'  => $row->title,
                    'url'  => route('course.vendor.edit',['id'=>$row->id]),
                ],
                [
                    'name'  => __("Lessons Management"),
                    'class' => 'active'
                ],
            ],
        ];

        return view('Course::frontend.manageCourse.lesson',$data);
    }
}
