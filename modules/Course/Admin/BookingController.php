<?php
namespace Modules\Course\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseCategory;

class BookingController extends AdminController
{
    protected $courseClass;
    public function __construct()
    {
        $this->setActiveMenu('admin/module/course');
        parent::__construct();
        $this->courseClass = Course::class;
    }

    public function index(Request $request){

        $this->checkPermission('course_create');

        $q = $this->courseClass::query();

        if($request->query('s')){
            $q->where('title','like','%'.$request->query('s').'%');
        }

        if ($cat_id = $request->query('cat_id')) {
            $cat = CourseCategory::find($cat_id);
            if(!empty($cat)) {
                $q->join('bravo_course_category', function ($join) use ($cat) {
                    $join->on('bravo_course_category.id', '=', 'bravo_courses.category_id')
                        ->where('bravo_course_category._lft','>=',$cat->_lft)
                        ->where('bravo_course_category._rgt','>=',$cat->_lft);
                });
            }
        }

        if(!$this->hasPermission('course_manage_others')){
            $q->where('create_user',$this->currentUser()->id);
        }

        $q->orderBy('bravo_courses.id','desc');

        $rows = $q->paginate(10);

        $current_month = strtotime(date('Y-m-01',time()));

        if($request->query('month')){
            $date = date_create_from_format('m-Y',$request->query('month'));
            if(!$date){
                $current_month = time();
            }else{
                $current_month = $date->getTimestamp();
            }
        }

        $prev_url = url('admin/module/course/booking/').'?'.http_build_query(array_merge($request->query(),[
           'month'=> date('m-Y',$current_month - MONTH_IN_SECONDS)
        ]));
        $next_url = url('admin/module/course/booking/').'?'.http_build_query(array_merge($request->query(),[
           'month'=> date('m-Y',$current_month + MONTH_IN_SECONDS)
        ]));

        $course_categories = CourseCategory::where('status', 'publish')->get()->toTree();
        $breadcrumbs = [
            [
                'name' => __('Courses'),
                'url'  => 'admin/module/course'
            ],
            [
                'name'  => __('Booking'),
                'class' => 'active'
            ],
        ];
        $page_title = __('Course Booking History');
        return view('Course::admin.booking.index',compact('rows','course_categories','breadcrumbs','current_month','page_title','request','prev_url','next_url'));
    }
    public function test(){
        $d = new \DateTime('2019-07-04 00:00:00');

        $d->modify('+ 4 hours');
    }
}
