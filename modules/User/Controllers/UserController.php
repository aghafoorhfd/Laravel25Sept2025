<?php
namespace Modules\User\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Matrix\Exception;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseCategory;
use Modules\FrontendController;
use Modules\Review\Models\Review;
use Modules\User\Events\SendMailUserRegistered;
use Modules\User\Models\Newsletter;
use Modules\User\Models\Subscriber;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Validator;
use Modules\Booking\Models\Booking;
use App\Helpers\ReCaptchaEngine;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use function GuzzleHttp\Psr7\str;

class UserController extends FrontendController
{
    use AuthenticatesUsers;
    protected $userClass;
    protected $courseCategoryClass;

    public function __construct()
    {
        $this->courseCategoryClass = CourseCategory::class;
        $this->userClass = User::class;
    }

    public function index(Request $request)
    {
        $is_ajax = $request->query('_ajax');
        $model_User = $this->userClass::select("users.*");
        $model_User->where("users.status", "publish");

        if (!empty($search = $request->input("s"))) {
            $model_User->where(function($query) use ($search) {
                $query->where('users.name', 'LIKE', '%' . $search . '%');
                $query->orWhere('users.first_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('users.last_name', 'LIKE', '%' . $search . '%');
            });
        }


        if (!empty($category_ids = $request->query('cat_id'))) {
            if(!is_array($category_ids)) $category_ids = [$category_ids];
            $list_cat = $this->courseCategoryClass::whereIn('id', $category_ids)->where("status","publish")->get();
            if(!empty($list_cat)){
                $where_left_right = [];
                foreach ($list_cat as $cat){
                    $where_left_right[] = " ( bravo_course_category._lft >= {$cat->_lft} AND bravo_course_category._rgt <= {$cat->_rgt} ) ";
                }
                $sql_where_join = " ( " . implode("OR", $where_left_right) . " )  ";
                $model_User
                    ->join('bravo_courses', function ($join) {
                        $join->on('bravo_courses.create_user', '=', 'users.id');
                    })
                    ->join('bravo_course_category', function ($join) use ($sql_where_join) {
                        $join->on('bravo_course_category.id', '=', 'bravo_courses.category_id')
                            ->WhereRaw($sql_where_join);
                    });
            }

        }
        $model_User->role(['administrator', 'vendor']);

        $model_User->groupBy("users.id");
        $review_scores = $request->query('review_score');
        if (is_array($review_scores) && !empty($review_scores)) {
            $where_review_score = [];
            foreach ($review_scores as $number){
                $where_review_score[] = " ( AVG(bravo_review.rate_number) >= {$number} AND AVG(bravo_review.rate_number) <= {$number}.9 ) ";
            }
            $sql_where_review_score = " ( " . implode("OR", $where_review_score) . " )  ";
            $model_User->selectRaw('AVG(bravo_review.rate_number) as score_total')
                ->join('bravo_review', function ($join) {
                    $join->on('bravo_review.vendor_id', '=', 'users.id')
                        ->where('object_model', "course")
                        ->where("bravo_review.status", "approved");
                });
            $model_User->havingRaw($sql_where_review_score);
        }

        $model_User->orderBy("id", "asc");

        $list = $model_User->paginate(9);

        $topPopular = $this->userClass::select("users.*")
            ->where("users.status", "publish")
            ->selectRaw('sum(bravo_booking_items.id) as student_total')
                ->join('bravo_booking_items', function ($join) {
                    $join->on('bravo_booking_items.vendor_id', '=', 'users.id');
                })
            ->orderBy('student_total', 'desc')
            ->groupBy("users.id")
            ->limit(10)
            ->get();


        $data = [
            'rows' => $list,
            'popular' => $topPopular,
            'course_category' => $this->courseCategoryClass::where('status', 'publish')->with(['translations', 'countCourse'])->get()->toTree(),
            "blank" => 1,
            "seo_meta" => [],
            'breadcrumbs'       => [
                [
                    'name'  => __('Instructors'),
                    'url'  => route('user.index'),
                    'class' => 'active'
                ],
            ],
            'banner_image' => setting_item("users_page_list_banner", '')
        ];

        $layout = setting_item("user_layout_search", 'normal');
        if ($request->query('_layout')) {
            $layout = $request->query('_layout');
        }
        if ($is_ajax) {
           return $this->sendSuccess([
                'html' => view('User::frontend.layouts.search-map.list-item', $data)->render(),
                "markers" => $data['markers']
            ]);
        }


        return view('User::frontend.search', $data);
    }

    public function detail(Request $request, $id)
    {
        $row = $this->userClass::where('id', $id)->where("status", "publish")->first();
        if (empty($row)) {
            return redirect('/');
        }

        $data = [
            'row' => $row,
            'countCourse' => Course::where('create_user', $id)->count(),
            'body_class'=>'is_single',
            'hideSubBc' => '1',
            'banner_image' => setting_item("users_page_list_banner", '')
        ];
        $this->setActiveMenu($row);
        return view('User::frontend.detail', $data);
    }

    public function dashboard(Request $request)
    {
        $this->checkPermission('dashboard_vendor_access');
        $user_id = Auth::id();
        $data = [
            'cards_report'       => Booking::getTopCardsReportForVendor($user_id),
            'earning_chart_data' => Booking::getEarningChartDataForVendor(strtotime('monday this week'), time(), $user_id),
            'page_title'         => __("Instructor Dashboard"),
            'breadcrumbs'        => [
                [
                    'name'  => __('Dashboard'),
                    'class' => 'active'
                ]
            ]
        ];
        return view('User::frontend.dashboard', $data);
    }

    public function reloadChart(Request $request)
    {
        $chart = $request->input('chart');
        $user_id = Auth::id();
        switch ($chart) {
            case "earning":
                $from = $request->input('from');
                $to = $request->input('to');
               return $this->sendSuccess([
                    'data' => Booking::getEarningChartDataForVendor(strtotime($from), strtotime($to), $user_id)
                ]);
                break;
        }
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        if (!empty($request->input())) {

            $request->validate([
                'first_name'              => 'required|max:255',
                'last_name'              => 'required|max:255',
                'email'              =>[
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id)
                ],
            ]);

            $user->fill($request->input());
            $user->birthday = date("Y-m-d", strtotime($user->birthday));
            $user->save();
            return redirect()->back()->with('success', __('Update successfully'));
        }
        $data = [
            'dataUser'    => $user,
            'page_title'  => __("Profile"),
            'breadcrumbs' => [
                [
                    'name'  => __('Setting'),
                    'class' => 'active'
                ]
            ],
            'is_vendor_access'   => $this->hasPermission('dashboard_vendor_access')
        ];
        return view('User::frontend.profile', $data);
    }

    public function changePassword(Request $request)
    {
        if (!empty($request->input())) {
            if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
                // The passwords matches
                return redirect()->back()->with("error", __("Your current password does not matches with the password you provided. Please try again."));
            }
            if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
                //Current password and new password are same
                return redirect()->back()->with("error", __("New Password cannot be same as your current password. Please choose a different password."));
            }
            $request->validate([
                'current-password' => 'required',
                'new-password'     => 'required|string|min:6|confirmed',
            ]);
            //Change Password
            $user = Auth::user();
            $user->password = bcrypt($request->get('new-password'));
            $user->save();
            return redirect()->back()->with('success', __('Password changed successfully !'));
        }

        $data = [
            'breadcrumbs'        => [
                [
                    'name' => __('Setting'),
                    'url' => route("user.profile.index")
                ],
                [
                    'name' => __('Change Password'),
                    'class' => 'active'
                ]
            ],
            'page_title'         => __("Change Password"),
        ];
        return view('User::frontend.changePassword',$data);
    }

    public function bookingHistory(Request $request)
    {
        $user_id = Auth::id();
        $data = [
            'bookings' => Booking::getBookingHistory($request->input('status'), $user_id),
            'statues'  => config('booking.statuses'),
            'breadcrumbs'        => [
                [
                    'name' => __('Order History'),
                    'class' => 'active'
                ]
            ],
            'page_title'         => __("Order History"),
        ];
        return view('User::frontend.bookingHistory', $data);
    }

    public function userLogin(Request $request)
    {
        $rules = [
            'email'    => 'required|email',
            'password' => 'required'
        ];
        $messages = [
            'email.required'    => __('Email is required field'),
            'email.email'       => __('Email invalidate'),
            'password.required' => __('Password is required field'),
        ];
        if (ReCaptchaEngine::isEnable() and setting_item("user_enable_login_recaptcha")) {
            $codeCapcha = $request->input('g-recaptcha-response');
            if (!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)) {
                $errors = new MessageBag(['message_error' => __('Please verify the captcha')]);
                return response()->json(['error'    => true,
                                         'messages' => $errors
                ], 200);
            }
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'    => true,
                                     'messages' => $validator->errors()
            ], 200);
        } else {
            $email = strip_tags(e($request->input('email')));
            $password = strip_tags(e($request->input('password')));
            if (Auth::attempt(['email'    => $email,
                               'password' => $password
            ], $request->has('remember'))) {
                if(in_array(Auth::user()->status,['blocked'])){
                    Auth::logout();
                    $errors = new MessageBag(['message_error' => __('Your account has been blocked')]);
                    return response()->json([
                        'error'    => true,
                        'messages' => $errors,
                        'redirect' => false
                    ], 200);

                }

                $url = strip_tags($request->input('redirect'));
                return response()->json([
                    'error'    => false,
                    'messages' => false,
                    'redirect' => $url ? e($url) : url(app_get_locale(false,'/'))
                ], 200);
            } else {
                $errors = new MessageBag(['message_error' => __('Username or password incorrect')]);
                return response()->json([
                    'error'    => true,
                    'messages' => $errors,
                    'redirect' => false
                ], 200);
            }
        }
    }

    public function userRegister(Request $request)
    {
        $rules = [
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],
            'last_name'  => [
                'required',
                'string',
                'max:255'
            ],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password'   => [
                'required',
                'string'
            ],
            'term'       => ['required'],
        ];
        $messages = [
            'email.required'      => __('Email is required field'),
            'email.email'         => __('Email invalidate'),
            'password.required'   => __('Password is required field'),
            'first_name.required' => __('The first name is required field'),
            'last_name.required'  => __('The last name is required field'),
            'term.required'       => __('The terms and conditions field is required'),
        ];

    if(ReCaptchaEngine::isEnable() and setting_item("user_enable_register_recaptcha")){
        $codeCapcha = $request->input('g-recaptcha-response');
        if(!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)){
            $errors = new MessageBag(['message_error' => __('Please verify the captcha') ]);
            return response()->json(['error'   => true,
                                     'messages' => $errors
            ], 200);
        }
    }

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['error'   => true,
                                 'messages' => $validator->errors()
        ], 200);
    } else {

        // $user = \App\User::create([
        //     'first_name'=>strip_tags($request->input('first_name')),
        //     'last_name'=>strip_tags($request->input('last_name')),
        //     'email'=>strip_tags($request->input('email')),
        //     'password'=>Hash::make($request->input('password')),
        //     'publish'=>strip_tags($request->input('publish')),
        // ]);
        $user = new \App\User();
        $user->first_name = strip_tags($request->input('first_name'));
        $user->last_name = strip_tags($request->input('last_name'));
        $user->email = strip_tags($request->input('email'));
        $user->password = Hash::make($request->input('password'));
        // $user->publish = strip_tags($request->input('publish'));
        $user->save();
        
        event(new Registered($user));
        Auth::loginUsingId($user->id);
        $user->assignRole('customer');
        $url = strip_tags($request->input('redirect'));
        return response()->json([
             'error'    => false,
             'messages'  => false,
             'success'  => true,
             'message'  => __('You have been successfully registered and logged in!.Click the Courses and then Courses list'),
             'redirect' => $url ? e($url) : url(app_get_locale(false,'/'))
            ], 200);
    }
}

    public function subscribe(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email|max:255'
        ]);
        $check = Subscriber::withTrashed()->where('email', $request->input('email'))->first();
        if ($check) {
            if ($check->trashed()) {
                $check->restore();
               return $this->sendSuccess([], __('Thank you for subscribing'));
            }
           return $this->sendError(__('You are already subscribed'));
        } else {
            $a = new Subscriber();
            $a->email = $request->input('email');
            $a->first_name = $request->input('first_name');
            $a->last_name = $request->input('last_name');
            $a->save();
           return $this->sendSuccess([], __('Thank you for subscribing'));
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect(app_get_locale(false,'/'));
    }
}
