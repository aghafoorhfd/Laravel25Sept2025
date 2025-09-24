<div class="b-panel-title">{{__('Order information')}}</div>
<div class="b-table-wrap">
    <table class="b-table" cellspacing="0" cellpadding="0">
        <tr>
            <td class="label">{{__('Number')}}</td>
            <td class="val">#{{$booking->id}}</td>
        </tr>
        <tr>
            <td class="label">{{__('Order Status')}}</td>
            <td class="val">{{$booking->statusName}}</td>
        </tr>
        @if($booking->gatewayObj)
            <tr>
                <td class="label">{{__('Payment method')}}</td>
                <td class="val">{{$booking->gatewayObj->getOption('name')}}</td>
            </tr>
        @endif
    </table>
    <br>
    <br>
    <table class="b-table" cellspacing="0" cellpadding="0">
        <tr>
            <td class="label"><strong>{{__("Product")}}</strong></td>
            <td  class="val">{{__("Price")}}</td>
        </tr>
        @foreach($booking->items as $item)
            <tr>
                <td>
                    @if(get_bookable_service_by_id($item->object_model) and $service = $item->service)
                        <a>{{$service->title}}</a>
                    @else
                        {{__("[Deleted]")}}
                    @endif
                </td>
                <td class="val">{{format_money($item->subtotal)}}</td>
            </tr>
        @endforeach
        <tr>
            <td class="label fsz21">{{__('Total')}}</td>
            <td class="val fsz21"><strong style="color: #FA5636">{{format_money($booking->total)}}</strong></td>
        </tr>
    </table>
</div>
<div class="text-center mt20">
    <a href="{{url('user/booking-history')}}" target="_blank" class="btn btn-primary">{{__('Manage Orders')}}</a>
</div>
