<?php
namespace Modules\Course\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Core\Models\Attributes;
use Modules\Course\Models\CourseTerm;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseCategory;
use Modules\Course\Models\CourseTranslation;
use Modules\Course\Models\Sections;
use Modules\Location\Models\Location;

class CourseController extends AdminController
{
    protected $courseClass;
    protected $courseTranslationClass;
    protected $courseCategoryClass;
    protected $courseTermClass;
    protected $attributesClass;
    protected $sectionsClass;

    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu('admin/module/course');
        $this->courseClass = Course::class;
        $this->courseTranslationClass = CourseTranslation::class;
        $this->courseCategoryClass = CourseCategory::class;
        $this->courseTermClass = CourseTerm::class;
        $this->attributesClass = Attributes::class;
        $this->sectionsClass = Sections::class;
    }

    public function index(Request $request)
    {
        $this->checkPermission('course_view');
        $query = $this->courseClass::query() ;
        $query->orderBy('id', 'desc');
        if (!empty($course_name = $request->input('s'))) {
            $query->where('title', 'LIKE', '%' . $course_name . '%');
            $query->orderBy('title', 'asc');
        }
        if (!empty($cate = $request->input('cate_id'))) {
            $query->where('category_id', $cate);
        }
        if ($this->hasPermission('course_manage_others')) {
            if (!empty($author = $request->input('vendor_id'))) {
                $query->where('create_user', $author);
            }
        } else {
            $query->where('create_user', Auth::id());
        }
        $data = [
            'rows'               => $query->with(['getAuthor','category_course'])->paginate(20),
            'course_categories'    => $this->courseCategoryClass::where('status', 'publish')->get()->toTree(),
            'course_manage_others' => $this->hasPermission('course_manage_others'),
            'page_title'=>__("Course Management"),
            'breadcrumbs'        => [
                [
                    'name' => __('Courses'),
                    'url'  => 'admin/module/course'
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Course::admin.index', $data);
    }

    public function create(Request $request)
    {
        $this->checkPermission('course_create');
        $row = new Course();
        $row->fill([
            'status' => 'publish'
        ]);
        $data = [
            'row'           => $row,
            'attributes'    => $this->attributesClass::where('service', 'course')->get(),
            'sections'    => $this->sectionsClass::where('service', 'course')->get(),
            'course_category' => $this->courseCategoryClass::where('status', 'publish')->get()->toTree(),
            'translation' => new $this->courseTranslationClass(),
            'breadcrumbs'   => [
                [
                    'name' => __('Courses'),
                    'url'  => 'admin/module/course'
                ],
                [
                    'name'  => __('Add Course'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Course::admin.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('course_update');
        $row = $this->courseClass::find($id);
        if (empty($row)) {
            return redirect('admin/module/course');
        }
        $translation = $row->translateOrOrigin($request->query('lang'));
        if (!$this->hasPermission('course_manage_others')) {
            if ($row->create_user != Auth::id()) {
                return redirect('admin/module/course');
            }
        }
        $data = [
            'row'            => $row,
            'translation'    => $translation,
            "selected_terms" => $row->course_term->pluck('term_id'),
            'attributes'     => $this->attributesClass::where('service', 'course')->get(),
            'sections'    => $this->sectionsClass::where('service', 'course')->get(),
            'course_category'  => $this->courseCategoryClass::where('status', 'publish')->get()->toTree(),
            'tags' => $row->getTags(),
            'enable_multi_lang'=>true,
            'breadcrumbs'    => [
                [
                    'name' => __('Courses'),
                    'url'  => 'admin/module/course'
                ],
                [
                    'name'  => __('Edit Course'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Course::admin.detail', $data);
    }

    public function store(Request $request, $id)
    {
        if ($id > 0) {
            $this->checkPermission('course_update');
            $row = $this->courseClass::find($id);
            if (empty($row)) {
                return redirect(route('course.admin.edit', ['id' => $row->id]));
            }

            if ($row->create_user != Auth::id() and !$this->hasPermission('course_manage_others')) {
                return redirect(route('course.admin.edit', ['id' => $row->id]));
            }
        } else {
            $this->checkPermission('course_create');
            $row = new $this->courseClass();
            $row->status = "publish";
        }

        // Handle PDF file upload
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');

            // Store the file in the public disk
            $path = $file->store('pdfs', 'public');

            // Create a new MediaFile record
            $mediaFile = new \Modules\Media\Models\MediaFile();
            $mediaFile->file_name = $file->getClientOriginalName();
            $mediaFile->file_path = $path;
            $mediaFile->file_size = $file->getSize();
            $mediaFile->file_type = $file->getMimeType();
            $mediaFile->file_extension = $file->getClientOriginalExtension();
            $mediaFile->save();

            // Set the pdf_file_id on the course
            $row->pdf_file_id = $mediaFile->id;
        }

        // Fill the course with the request data, excluding the pdf_file and id
$row->fillByAttr([
    'title',
    'content',
    'image_id',
    'banner_image_id',
    'short_desc',
    'category_id',
    'video',
    'duration',
    'price',
    'sale_price',
    'easypaisa_price',
    'is_featured',
    'status'
], $request->input());

        // Save the course
        $res = $row->saveOriginOrTranslation($request->input('lang'), true);

        if ($res) {
            if (!$request->input('lang') or is_default_lang($request->input('lang'))) {
                $this->saveTerms($row, $request);
            }
            $row->saveMeta($request);
            if ($id > 0) {
                return back()->with('success', __('Course updated'));
            } else {
                return redirect(route('course.admin.edit', ['id' => $row->id]))->with('success', __('Course created'));
            }
        } else {
            return redirect()->back()->with('error', __('Failed to save course'));
        }
    }
    public function saveTerms($row, $request)
    {
        if (empty($request->input('terms'))) {
            $this->courseTermClass::where('course_id', $row->id)->delete();
        } else {
            $term_ids = $request->input('terms');
            foreach ($term_ids as $term_id) {
                $this->courseTermClass::firstOrCreate([
                    'term_id' => $term_id,
                    'course_id' => $row->id
                ]);
            }
            $this->courseTermClass::where('course_id', $row->id)->whereNotIn('term_id', $term_ids)->delete();
        }
    }

    public function bulkEdit(Request $request)
    {
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }

        switch ($action){
            case "delete":
                foreach ($ids as $id) {
                    $query = $this->courseClass::where("id", $id);
                    if (!$this->hasPermission('course_manage_others')) {
                        $query->where("create_user", Auth::id());
                        $this->checkPermission('course_delete');
                    }
                    $query->first();
                    if(!empty($query)){
                        $query->delete();
                    }
                }
                return redirect()->back()->with('success', __('Deleted success!'));
                break;
            case "clone":
                $this->checkPermission('course_create');
                foreach ($ids as $id) {
                    (new $this->courseClass())->saveCloneByID($id);
                }
                return redirect()->back()->with('success', __('Clone success!'));
                break;
            default:
                // Change status
                foreach ($ids as $id) {
                    $query = $this->courseClass::where("id", $id);
                    if (!$this->hasPermission('course_manage_others')) {
                        $query->where("create_user", Auth::id());
                        $this->checkPermission('course_update');
                    }
                    if($action == "publish"){
                        $query->update(['status' => $action, 'publish_date' => date("Y-m-d H:i:s")]);
                    }else{
                        $query->update(['status' => $action]);
                    }
                }
                return redirect()->back()->with('success', __('Update success!'));
                break;
        }
    }
}
