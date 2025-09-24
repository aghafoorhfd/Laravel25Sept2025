<?php



    namespace Modules\Course\Models;
    use Modules\Media\Models\MediaFile;
    use App\Currency;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;
    use Modules\Booking\Models\Bookable;
    use Modules\Booking\Models\Booking;
    use Modules\Booking\Models\BookingItem;
    use Modules\Location\Models\Location;
    use Modules\Review\Models\Review;
    use Modules\Course\Models\CourseTerm;
    use Modules\Media\Helpers\FileHelper;
    use Illuminate\Support\Facades\Cache;
    use Validator;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Modules\Core\Models\SEO;
    use Modules\User\Models\UserWishList;
    use Gloudemans\Shoppingcart\Facades\Cart;

    class Course extends Bookable
    {
        use SoftDeletes;
        protected $table                              = 'bravo_courses';
        public    $checkout_booking_detail_file       = 'Course::frontend/booking/detail';
        public    $checkout_booking_detail_modal_file = 'Course::frontend/booking/detail-modal';
        public    $email_new_booking_file             = 'Course::emails.new_booking_detail';
        public    $type                               = 'course';
        protected $fillable                           = [
            //Course info
            'title',
            'slug',
            'content',
            'image_id',
            'banner_image_id',
            'pdf_file_id',
            'short_desc',
            'category_id',
            'is_featured',
            'gallery',
            'video',
            //Price
            'price',
            'sale_price',
            //Course type
            'duration',
            //Extra Info
            'faqs',
            'status',
            'include',
            'exclude',
            'itinerary',
            'easypaisa_price'
        ];
        protected $slugField                          = 'slug';
        protected $slugFromField                      = 'title';
        protected $seo_type                           = 'course';
        /**
         * The attributes that should be casted to native types.
         *
         * @var array
         */
        protected $casts = [
            'faqs' => 'array',
            'include' => 'array',
            'exclude' => 'array',
            'itinerary' => 'array',
            'price'=>'float',
            'sale_price'=>'float',
            'easypaisa_price'=>'float'
        ];

        public static function getModelName()
        {
            return __("Course");
        }

        public function pdfFile()
        {
            return $this->belongsTo(\Modules\Media\Models\MediaFile::class, 'pdf_file_id');
        }

        protected $bookingClass;
        protected $courseTermClass;
        protected $courseTranslationClass;
        protected $courseMetaClass;
        protected $courseDateClass;
        protected $userWishListClass;
        protected $reviewClass;

        public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);
            $this->bookingClass = Booking::class;
            $this->courseTermClass = CourseTerm::class;
            $this->courseTranslationClass = CourseTranslation::class;
            $this->courseMetaClass = CourseMeta::class;
            $this->courseDateClass = CourseDate::class;
            $this->userWishListClass = UserWishList::class;
            $this->reviewClass = Review::class;
        }

        /**
         * Get Category
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function category_course()
        {
            return $this->hasOne("Modules\Course\Models\CourseCategory", "id", 'category_id')->with(['translations']);
        }

        /**
         * Get SEO fop page list
         *
         * @return mixed
         */
        static public function getSeoMetaForPageList()
        {
            $meta['seo_title'] = __("Search for Courses");
            if (!empty($title = setting_item_with_lang("course_page_list_seo_title", false))) {
                $meta['seo_title'] = $title;
            } else if (!empty($title = setting_item_with_lang("course_page_search_title"))) {
                $meta['seo_title'] = $title;
            }
            $meta['seo_image'] = null;
            if (!empty($title = setting_item("course_page_list_seo_image"))) {
                $meta['seo_image'] = $title;
            } else if (!empty($title = setting_item("course_page_search_banner"))) {
                $meta['seo_image'] = $title;
            }
            $meta['seo_desc'] = setting_item_with_lang("course_page_list_seo_desc");
            $meta['seo_share'] = setting_item_with_lang("course_page_list_seo_share");
            $meta['full_url'] = url(config('course.course_route_prefix'));
            return $meta;
        }

        /**
         * Get Category
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function meta()
        {
            return $this->hasOne($this->courseMetaClass, "course_id");
        }

        /**
         * Get Category
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function course_term()
        {
            return $this->hasMany($this->courseTermClass, "course_id");
        }

        public function courseRelated()
        {
            return $this->hasMany(self::class, "create_user", "create_user")->where('status', 'publish')->where('id', '!=', $this->id)->limit(3);
        }

        public function getTags()
        {
            $tags = CourseTag::where('course_id', $this->id)->get();
            $tag_ids = [];
            if (!empty($tags)) {
                foreach ($tags as $key => $value) {
                    $tag_ids[] = $value->tag_id;
                }
            }
            return Tag::whereIn('id', $tag_ids)->with('translations')->get();
        }

        public function getDetailUrl($include_param = true)
        {
            $param = [];
            if($include_param){
                if(!empty($date =  request()->input('date'))){
                    $dates = explode(" - ",$date);
                    if(!empty($dates)){
                        $param['start'] = $dates[0] ?? "";
                        $param['end'] = $dates[1] ?? "";
                    }
                }
            }
            $urlDetail = app_get_locale(false, false, '/') . config('course.course_route_prefix') . "/" . $this->slug;
            if(!empty($param)){
                $urlDetail .= "?".http_build_query($param);
            }
            return url($urlDetail);
        }

        public static function getLinkForPageSearch($locale = false, $param = [])
        {

            return url(app_get_locale(false, false, '/') . config('course.course_route_prefix') . "?" . http_build_query($param));
        }


        public function getGallery($featuredIncluded = false)
        {
            if (empty($this->gallery))
                return $this->gallery;
            $list_item = [];
            if ($featuredIncluded and $this->image_id) {
                $list_item[] = [
                    'large' => FileHelper::url($this->image_id, 'full'),
                    'thumb' => FileHelper::url($this->image_id, 'thumb')
                ];
            }
            $items = explode(",", $this->gallery);
            foreach ($items as $k => $item) {
                $large = FileHelper::url($item, 'full');
                $thumb = FileHelper::url($item, 'thumb');
                $list_item[] = [
                    'large' => $large,
                    'thumb' => $thumb
                ];
            }
            return $list_item;
        }

        public function getEditUrl()
        {
            return url('admin/module/course/edit/' . $this->id);
        }

        public function getDiscountPercentAttribute()
        {
            if (!empty($this->price) and $this->price > 0
                and !empty($this->sale_price) and $this->sale_price > 0
                and $this->price > $this->sale_price
            ) {
                $percent = 100 - ceil($this->sale_price / ($this->price / 100));
                return $percent . "%";
            }
        }

        function getDatefomat($value)
        {
            return \Carbon\Carbon::parse($value)->format('j F, Y');
        }

        public function saveMeta(\Illuminate\Http\Request $request)
        {
            $meta = $this->courseMetaClass::where('course_id', $this->id)->first();
            if (!$meta) {
                $meta = new $this->courseMetaClass();
                $meta->course_id = $this->id;
            }
            $meta->fill($request->input());
            return $meta->save();
        }

        public function saveTag($tags_name, $tag_ids)
        {

            if (empty($tag_ids))
                $tag_ids = [];
            $tag_ids = array_merge(Tag::saveTagByName($tags_name), $tag_ids);
            $tag_ids = array_filter(array_unique($tag_ids));
            // Delete unused
            CourseTag::whereNotIn('tag_id', $tag_ids)->where('course_id', $this->id)->delete();
            //Add
            CourseTag::addTag($tag_ids, $this->id);
        }

        public function fill(array $attributes)
        {
            if (!empty($attributes)) {
                foreach ($this->fillable as $item) {
                    $attributes[$item] = $attributes[$item] ?? null;
                }
            }
            return parent::fill($attributes); // TODO: Change the autogenerated stub
        }

        public function isBookable()
        {
            if ($this->status != 'publish')
                return false;
            return parent::isBookable();
        }

        public function addToCart(Request $request)
        {
            $this->addToCartValidate($request);

            // Only single litem
            $cartproduct = Cart::content()->where('id', $this->getBuyableIdentifier())->where('name', $this->getBuyableDescription())->first();
            if($cartproduct){
            }else{
                Cart::add($this,1);
            }

            $buy_now = $request->input('buy_now');

            return $this->sendSuccess([
                'fragments'=>get_cart_fragments(),
                'url'=>$buy_now ? route('booking.checkout') : ''
            ],
               !$buy_now ? __('":title" has been added to your cart.',['title'=>$this->title]) :''
            );
        }

        public function getDataPriceAvailabilityInRanges($start_date){
            $datesRaw = $this->courseDateClass::getDatesInRanges($start_date,$this->id);
            $dates = [
                'base_price' => null,
                'person_types' => null,
            ];
            if(!empty($datesRaw))
            {
                $dates =  [
                   'base_price' => $datesRaw->price,
                   'person_types' => is_array($datesRaw->person_types) ? $datesRaw->person_types : false,
               ];
            }
            return $dates;
        }

        public function beforeCheckout(Request $request, $booking)
        {
            $maxGuests = $this->getNumberAvailableBooking($booking->start_date);
            if ($booking->total_guests > $maxGuests) {
                return $this->sendError(__("There are " . $maxGuests . " guests available for your selected date"));
            }
        }

        public function getNumberAvailableBooking($start_date)
        {
            $courseDate = $this->courseDateClass::where('target_id', $this->id)->where('start_date', $start_date)->where('active', 1)->first();
            $totalGuests = $this->bookingClass::where('object_id', $this->id)->where('start_date', $start_date)->whereNotIn('status', $this->bookingClass::$notAcceptedStatus)->sum('total_guests');
            $maxGuests = !empty($courseDate->max_guests) ? $courseDate->max_guests : $this->max_people;
            $number = $maxGuests - $totalGuests;
            return $number > 0 ? $number : 0;
        }

        public function addToCartValidate(Request $request)
        {

            return true;
        }

        public function getBookingData($extra = [])
        {
            $booking_data = [
                'id'              => $this->id,
                'type'=>$this->type
            ];

            return array_merge($booking_data,$extra);
        }

        public static function searchForMenu($q = false)
        {
            $query = static::select('id', 'title as name');
            if (strlen($q)) {

                $query->where('title', 'like', "%" . $q . "%");
            }
            $a = $query->limit(10)->get();
            return $a;
        }

        public static function getMinMaxPrice()
        {
            $model = parent::selectRaw('MIN( CASE WHEN sale_price > 0 THEN sale_price ELSE ( price ) END ) AS min_price ,
                                    MAX( CASE WHEN sale_price > 0 THEN sale_price ELSE ( price ) END ) AS max_price ')->where("status", "publish")->first();
            if (empty($model->min_price) and empty($model->max_price)) {
                return [
                    0,
                    100
                ];
            }
            return [
                $model->min_price,
                $model->max_price
            ];
        }

        public function getReviewEnable()
        {
            return setting_item("course_enable_review", 0);
        }

        public function getReviewApproved()
        {
            return setting_item("course_review_approved", 0);
        }

        public function check_enable_review_after_booking()
        {
            $option = setting_item("course_enable_review_after_booking", 0);
            if ($option) {
                $number_review = $this->reviewClass::countReviewByServiceID($this->id, Auth::id(),false,$this->type) ?? 0;
                $number_booking = $this->bookingClass::countBookingByServiceID($this->id, Auth::id()) ?? 0;
                if ($number_review >= $number_booking) {
                    return false;
                }
            }
            return true;
        }
        public function check_allow_review_after_making_completed_booking()
        {
            $options = setting_item("course_allow_review_after_making_completed_booking", false);
            if (!empty($options)) {
                $status = json_decode($options);
                $booking = $this->bookingClass::select("status")
                    ->where("object_id", $this->id)
                    ->where("object_model", $this->type)
                    ->where("customer_id", Auth::id())
                    ->orderBy("id","desc")
                    ->first();
                $booking_status = $booking->status ?? false;
                if(!in_array($booking_status , $status)){
                    return false;
                }
            }
            return true;
        }

        public static function getReviewStats()
        {
            $reviewStats = [];
            if (!empty($list = setting_item("course_review_stats", []))) {
                $list = json_decode($list, true);
                foreach ($list as $item) {
                    $reviewStats[] = $item['title'];
                }
            }
            return $reviewStats;
        }

        public function getReviewDataAttribute()
        {
            $list_score = [
                'score_total'  => 0,
                'score_text'   => __("Not Rated"),
                'total_review' => 0,
                'rate_score'   => [],
            ];
            $dataTotalReview = $this->reviewClass::selectRaw(" AVG(rate_number) as score_total , COUNT(id) as total_review ")->where('object_id', $this->id)->where('object_model', "course")->where("status", "approved")->first();
            if (!empty($dataTotalReview->score_total)) {
                $list_score['score_total'] = number_format($dataTotalReview->score_total, 1);
                $list_score['score_text'] = $this->reviewClass::getDisplayTextScoreByLever(round($list_score['score_total']));
            }
            if (!empty($dataTotalReview->total_review)) {
                $list_score['total_review'] = $dataTotalReview->total_review;
            }
            $list_data_rate = $this->reviewClass::selectRaw('COUNT( CASE WHEN rate_number = 5 THEN rate_number ELSE NULL END ) AS rate_5,
                                                            COUNT( CASE WHEN rate_number = 4 THEN rate_number ELSE NULL END ) AS rate_4,
                                                            COUNT( CASE WHEN rate_number = 3 THEN rate_number ELSE NULL END ) AS rate_3,
                                                            COUNT( CASE WHEN rate_number = 2 THEN rate_number ELSE NULL END ) AS rate_2,
                                                            COUNT( CASE WHEN rate_number = 1 THEN rate_number ELSE NULL END ) AS rate_1 ')->where('object_id', $this->id)->where('object_model', $this->type)->where("status", "approved")->first()->toArray();
            for ($rate = 5; $rate >= 1; $rate--) {
                if (!empty($number = $list_data_rate['rate_' . $rate])) {
                    $percent = ($number / $list_score['total_review']) * 100;
                } else {
                    $percent = 0;
                }
                $list_score['rate_score'][$rate] = [
                    'title'   => $this->reviewClass::getDisplayTextScoreByLever($rate),
                    'total'   => $number,
                    'percent' => round($percent),
                ];
            }
            return $list_score;
        }

        /**
         * Get Score Review
         *
         * Using for loop course
         */
        public function getScoreReview()
        {
            $course_id = $this->id;
            $list_score = Cache::rememberForever('review_' . $this->type . '_' . $course_id, function () use ($course_id) {
                $dataReview = $this->reviewClass::selectRaw(" AVG(rate_number) as score_total , COUNT(id) as total_review ")->where('object_id', $course_id)->where('object_model', "course")->where("status", "approved")->first();
                return [
                    'score_total'  => !empty($dataReview->score_total) ? number_format($dataReview->score_total, 1) : 0,
                    'total_review' => !empty($dataReview->total_review) ? $dataReview->total_review : 0,
                ];
            });
            return $list_score;
        }

        public function getNumberReviewsInService($status = false)
        {
            return $this->reviewClass::countReviewByServiceID($this->id, false, $status, $this->type) ?? 0;
        }

        public function getNumberServiceInLocation($location)
        {
            $number = 0;
            if (!empty($location)) {
                $number = parent::join('bravo_locations', function ($join) use ($location) {
                    $join->on('bravo_locations.id', '=', 'bravo_courses.location_id')->where('bravo_locations._lft', '>=', $location->_lft)->where('bravo_locations._rgt', '<=', $location->_rgt);
                })->where("bravo_courses.status", "publish")->with(['translations'])->count("bravo_courses.id");
            }

            if(empty($number)) return false;
            if ($number > 1) {
                return __(":number Courses", ['number' => $number]);
            }
            return __(":number Course", ['number' => $number]);
        }

        /**
         * @param $from
         * @param $to
         * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
         */
        public function getBookingsInRange($from, $to)
        {

            $query = $this->bookingClass::query();
            $query->whereNotIn('status', ['draft']);
            $query->where('start_date', '<=', $to)->where('end_date', '>=', $from)->take(50);

            $query->where('object_id', $this->id);
            $query->where('object_model', 'course');

            return $query->orderBy('id', 'asc')->get();

        }

        public function saveCloneByID($clone_id)
        {
            $old = parent::find($clone_id);
            if (empty($old)) return false;
            $selected_terms = $old->course_term->pluck('term_id');
            $old->title = $old->title . " - Copy";
            $new = $old->replicate();
            $new->save();
            //Terms
            foreach ($selected_terms as $term_id) {
                $this->courseTermClass::firstOrCreate([
                    'term_id' => $term_id,
                    'course_id' => $new->id
                ]);
            }
            //Language
            $langs = $this->courseTranslationClass::where("origin_id", $old->id)->get();
            if (!empty($langs)) {
                foreach ($langs as $lang) {
                    $langNew = $lang->replicate();
                    $langNew->origin_id = $new->id;
                    $langNew->save();
                    $langSeo = SEO::where('object_id', $lang->id)->where('object_model', $lang->getSeoType() . "_" . $lang->locale)->first();
                    if (!empty($langSeo)) {
                        $langSeoNew = $langSeo->replicate();
                        $langSeoNew->object_id = $langNew->id;
                        $langSeoNew->save();
                    }
                }
            }
            //SEO
            $metaSeo = SEO::where('object_id', $old->id)->where('object_model', $this->seo_type)->first();
            if (!empty($metaSeo)) {
                $metaSeoNew = $metaSeo->replicate();
                $metaSeoNew->object_id = $new->id;
                $metaSeoNew->save();
            }
            //Meta
            $metaCourse = $this->courseMetaClass::where('course_id', $old->id)->first();
            if (!empty($metaCourse)) {
                $metaCourseNew = $metaCourse->replicate();
                $metaCourseNew->course_id = $new->id;
                $metaCourseNew->save();
            }
        }

        public function hasWishList()
        {
            return $this->hasOne($this->userWishListClass, 'object_id', 'id')->where('object_model', $this->type)->where('user_id', Auth::id() ?? 0);
        }

        public function isWishList()
        {
            if (Auth::id()) {
                if (!empty($this->hasWishList) and !empty($this->hasWishList->id)) {
                    return 'active';
                }
            }
            return '';
        }
        public static  function getServiceIconFeatured(){
            return "fa fa-book";
        }

        public static  function getServiceIconOrder(){
            return "fa fa-inbox";
        }
        public static function isEnable(){
            return setting_item('course_disable') == false;
        }

        public function getStudentCount(){
            return BookingItem::where(['object_id' => $this->id, 'object_model' => 'course'])->count();
        }

        public function getAdminJsDataAttribute(){
            $this->load('sections.lessons');
            $sections = $this->sections;
            return [
                'id'=>$this->id,
                'sections'=>$sections,
                'i18n'=>[
                    'add_lecture'=>[
                        'video'=>__("Add video lesson"),
                        'scorm'=>__("Add scorm lesson"),
                        'presentation'=>__("Add presentation lesson"),
                        'iframe'=>__("Add iframe lesson"),
                    ],
                    'validate'=>[
                        'title'=>__("Lesson name is required"),
                        'section_title'=>__("Section name is required"),
                        'file_id'=>__("File is required"),
                        'url'=>__("Url is required"),
                        'duration'=>__("Duration is required"),
                    ]
                ],
                'routes'=>[
                    'store'=>route('course.admin.lesson.store',['id'=>$this->id]),
                    'store_section'=>route('course.admin.section.store',['id'=>$this->id]),
                ]
            ];
        }

        public function sections(){
            return $this->hasMany(Sections::class,'course_id','id');
        }
        public function frontendSections(){
            return $this->hasMany(Sections::class,'course_id','id')->where('active',1)->orderBy('display_order','ASC');
        }
        public function getStudyJsDataAttribute(){
            $this->load('frontendSections.frontendLessons');
            $sectionsData = $this->frontendSections;
            $sections = [];
            foreach($sectionsData as $k=>$section){
                $sections[] = [
                    'id'=>$section->id,
                    'title'=>$section->name,
                    'lessons'=>$section->lessons_study_js_data,
                    'active'=>empty($k) ? true : false
                ];
            }
            return [
                'id'=>$this->id,
                'sections'=>$sections,
                'i18n'=>[
                ],
                'routes'=>[
                    'log'=>route('course.study-log')
                ]
            ];
        }

    }
