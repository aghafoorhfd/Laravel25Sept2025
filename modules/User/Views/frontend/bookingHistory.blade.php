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
                        <h4 class="m0">{{__('My Orders')}}</h4>
                    </div>
                </div>
                <div class="my_setting_content_details">
                    <div class="cart_page_form style2">
                        <table class="table table-responsive">
                            <thead>
                                <tr class="carttable_row">
                                    <th class="cartm_title" width="80px">{{__('No')}}</th>
                                    <th class="cartm_title">{{__('Item')}}</th>
                                    <th class="cartm_title">{{__('Date')}}</th>
                                    <th class="cartm_title">{{__('Status')}}</th>
                                    <th class="cartm_title">{{__('Total')}}</th>
                                </tr>
                            </thead>
                            <tbody class="table_body">
                            @if($bookings)
                            @foreach($bookings as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <th scope="row">
                                    <ul >
                                    @foreach($row->items as $item)
                                    @if($item->service)
                                  <li><a href="{{$item->service->getDetailUrl()}}" target="_blank">{{$item->service->title}}</a></li>
                                    @else
                                 <li>{{__('Service not available')}}</li>
                                    @endif
                                    @endforeach
                                    </ul>
                                    </th>
                                    <td>{{display_date($row->created_at)}}</td>
                                    <td>{{$row->statusName}}</td>
                                    <td class="cart_total">{{format_money($row->total)}}</td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="5"><div class="alert alert-warning">{{__("No data found")}}</div></td>
                                </tr>
                            @endif
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
