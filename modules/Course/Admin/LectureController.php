<?php

namespace Modules\Course\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseTerm;
use Modules\Course\Models\CourseTranslation;
use Modules\Core\Models\Attributes;
use Modules\Course\Models\CourseCategory;
use Modules\Course\Models\Lessons;

class LectureController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu(route('course.admin.index'));
    }

    public function index($id = ''){
        $row = $this->checkItemPermission($id);
        // echo '<pre>';print_r($row.lessons); die;
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
                    'url'  => route('course.admin.index')
                ],
                [
                    'name'  => $row->title,
                    'url'  => route('course.admin.edit',['id'=>$row->id]),
                ],
                [
                    'name'  => __("Lessons Management"),
                    'class' => 'active'
                ],
            ],
        ];

        return view('Course::admin.lesson.index',$data);
    }

    public function store($id = ''){
        $row = $this->checkItemPermission($id);

        if(empty($row)){
            return $this->sendError(__("Course not found"));
        }
        $type = request()->input('type');
        $section_id = request()->input('section_id');

        $rules = [
            'name'=>'required',
            'duration'=>'required',
            'type'=>'required',
            'section_id'=>'required'
        ];


        request()->validate($rules);

        if($module_id = request()->input('id')){
            $module = Lessons::find($module_id);
            if(empty($module)){
                return $this->sendError(__("Lesson not found"));
            }
        }else{
            $module = new Lessons();
            $module->course_id = $id;
            $module->section_id = $section_id;
        }

        $module->fillByAttr([
            'name',
            'file_id',
            'active',
            'preview_url',
            'url',
            'duration',
            'type',
            'display_order',
            'downloadable'
        ],request()->input());
        // print_r($module); die;
        $module->save();

        if($module_id){
            return $this->sendSuccess(__("Lesson updated"));
        }else{
            return $this->sendSuccess(['lecture'=>$module],__("Lesson created"));
        }
    }

    protected function checkItemPermission($id){

        if(empty($id)) return false;
        $row = Course::find($id);

        if(empty($row)) return false;

        if(!$this->hasPermission('course_manage_others'))
        {
            if($row->author_id != Auth::id()){
                return false;
            }
        }
        return $row;
    }
}
