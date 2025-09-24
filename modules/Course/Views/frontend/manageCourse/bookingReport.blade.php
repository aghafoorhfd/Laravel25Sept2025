@extends('layouts.user')
@section('head')

@endsection
@section('content')
    <div class="col-lg-12">
        @include('admin.message')
        <div class="my_course_content_container">
            <div class="my_setting_content">
                <div class="my_setting_content_header">
                    <div class="my_sch_title">
                        <h4 class="m0">{{__('Course Orders')}}</h4>
                    </div>
                </div>
                <div class="my_setting_content_details">
                    <div class="cart_page_form style2">
                        <table class="table table-responsive">
                            <thead>
                            <tr class="carttable_row">
                                <th class="cartm_title" width="80px">{{__('No')}}</th>
                                <th class="cartm_title">{{__('Item')}}</th>
                                <th class="cartm_title">{{__('Customer')}}</th>
                                <th class="cartm_title">{{__('Date')}}</th>
                                <th class="cartm_title">{{__("Commission")}}</th>
                                <th class="cartm_title a-hidden">{{__("Status")}}</th>
                                <th class="cartm_title">{{__('Total')}}</th>
                                <th class="cartm_title">{{__('Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody class="table_body">
                            @foreach($bookings as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                  <th scope="row">
                                   @if($row->service)
                                   <a href="{{$row->service->getDetailUrl()}}" target="_blank">{{$row->service->title}}</a>
                                   @else
                                   {{__('Service not available')}}
                                   @endif
                                   </th>
                                    <td>{{$row->first_name}} {{$row->last_name}}
                                        <br>
                                        {{$row->email}}
                                    </td>
                                    <td>{{display_date($row->created_at)}}</td>
                                    <td>
                                        @php($commission_type = json_decode($row->commission_type,true))
                                        @if($commission_type['type']=='percent')
                                            {{__("Percent")}} : {{$commission_type['amount'].'%'}} <br>
                                        @endif
                                        {{__("Amount")}} : {{format_money_main($row->commission)}} <br>
                                    </td>
                                    <td>{{$row->statusName}}</td>
                                    <td class="cart_total">{{format_money($row->total)}}</td>
                                    <td>
                                        @if(!empty(setting_item("course_allow_vendor_can_change_their_booking_status")))
                                            <a class="btn btn-xs btn-info btn-make-as" data-toggle="dropdown">
                                                <i class="icofont-ui-settings"></i>
                                                {{__("Action")}}
                                            </a>
                                            <div class="dropdown-menu">
                                                @if(!empty($statues))
                                                    @foreach($statues as $status)
                                                        <a href="{{ route("course.vendor.orders.bulk_edit" , ['id'=>$row->id , 'status'=>$status]) }}">
                                                            <i class="icofont-long-arrow-right"></i> {{__('Mark as: :name',['name'=>booking_status_to_text($status)])}}
                                                        </a>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="bravo-pagination">
                            {{$bookings->appends(request()->query())->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')

@endsection
