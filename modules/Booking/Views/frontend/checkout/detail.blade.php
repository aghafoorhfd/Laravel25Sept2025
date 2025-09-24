<div class="order_sidebar_widget mb30">
    <h4 class="title">{{__('Your Order')}}</h4>
    <ul>
        @if(empty($hide_list))
            <li class="subtitle"><p>{{__('Product')}} <span class="float-right">{{__('Total')}}</span></p></li>
            @foreach(Cart::content() as $cartItem)
            <li >
                @if($cartItem->model)
                    <p > <a href="{{$cartItem->model->getDetailUrl()}}">{{$cartItem->model->title}}</a> × {{$cartItem->qty}} <span class="float-right">{{format_money($cartItem->price)}}</span>
                    </p>
                @else
                    <p > {{$cartItem->name}} × {{$cartItem->qty}} <span class="float-right">{{format_money($cartItem->price)}}</span>
                    </p>
                @endif
            </li>
            @endforeach
        @endif
        <li class="subtitle"><p>{{__('Total')}} <span class="float-right totals color-orose">{{format_money(Cart::total())}}</span></p></li>
    </ul>
</div>
