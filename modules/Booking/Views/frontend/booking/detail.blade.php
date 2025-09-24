@php $lang_local = app()->getLocale(); $hideBc = 1; @endphp
<div class="booking-review">
    <h4 class="booking-review-title">{{__("Your Booking")}}</h4>
    <div class="booking-review-content">
        <div class="review-section">
            <div class="service-info">
                <div>
                    @foreach($booking->items as $item)
                    @if($item->service)
                   <h3 class="service-name"><a href="{{$item->service->getDetailUrl()}}">{{$item->service->title}}</a></h3>
                   @else
                   <h3 class="service-name">{{__('Service not available')}}</h3>
                   @endif
                   @endforeach
                </div>
            </div>
        </div>
        <div class="review-section total-review">
            <ul class="review-list">
                <li class="final-total">
                    <div class="label">{{__("Total:")}}</div>
                    <div class="val">{{format_money($booking->total)}}</div>
                </li>
            </ul>
        </div>
    </div>
</div>
