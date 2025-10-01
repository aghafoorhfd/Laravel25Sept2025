<div class="order_sidebar_widget mb30">
    <h4 class="title">{{__('Your Order')}}</h4>
    <ul>
        @if(empty($hide_list))
            <li class="subtitle"><p>{{__('Product')}} <span class="float-right">{{__('Total')}}</span></p></li>
            @foreach(Cart::content() as $cartItem)
            <li >
                @if($cartItem->model)
                    <p > <a href="{{$cartItem->model->getDetailUrl()}}">{{$cartItem->model->title}}</a> × {{$cartItem->qty}} <span class="float-right cart-item-price" data-usd-price="{{format_money($cartItem->price)}}" data-pkr-price="PKR {{$cartItem->model->easypaisa_price ?? 0}}">{{format_money($cartItem->price)}}</span>
                    </p>
                @else
                    <p > {{$cartItem->name}} × {{$cartItem->qty}} <span class="float-right cart-item-price" data-usd-price="{{format_money($cartItem->price)}}" data-pkr-price="PKR 0">{{format_money($cartItem->price)}}</span>
                    </p>
                @endif
            </li>
            @endforeach
        @endif
        <li class="subtitle"><p>{{__('Total')}} <span class="float-right totals color-orose" id="checkout-total">{{format_money(Cart::total())}}</span></p></li>
        <li id="currency-note" style="display: none;"><p class="text-muted small"><em>{{__('Amount shown in selected payment currency')}}</em></p></li>
    </ul>
</div>
