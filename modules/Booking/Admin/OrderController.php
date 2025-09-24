<?php
namespace Modules\Booking\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Booking\Models\Booking;

class OrderController extends AdminController
{
    public function index(Request $request){
        $this->checkPermission('report_view');

        $query = Booking::where('status', '!=', 'draft');
        if (!empty($request->s)) {
            $query->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->s . '%')->orWhere('last_name', 'like', '%' . $request->s . '%')->orWhere('email', 'like', '%' . $request->s . '%')->orWhere('phone', 'like', '%' . $request->s . '%')->orWhere('address', 'like', '%' . $request->s . '%')->orWhere('address2', 'like', '%' . $request->s . '%');
            });
        }
        if ($this->hasPermission('booking_manage_others')) {
            if (!empty($request->vendor_id)) {
                $query->where('vendor_id', $request->vendor_id);
            }
        } else {
            $query->where('vendor_id', Auth::id());
        }
        $query->orderBy('id','desc');
        $data = [
            'rows'                  => $query->paginate(20),
            'page_title'            => __("All Orders"),
            'booking_manage_others' => $this->hasPermission('booking_manage_others'),
            'booking_update'        => $this->hasPermission('booking_update'),
            'statues'               => config('booking.statuses')
        ];
        return view('Booking::admin.order.index', $data);
    }
}
