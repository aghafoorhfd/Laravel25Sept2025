<?php use Gloudemans\Shoppingcart\Facades\Cart; ?>
@if(Cart::count())
    @foreach(Cart::content() as $cartItem)
    <li class="list_content" style="animation-delay: 0.1s;">
        @if($cartItem->model)
        <a href="{{$cartItem->model->getDetailUrl()}}">
            <span class="img">
                {!! get_image_tag($cartItem->model->image_id,'thumb',['class'=>'float-left','lazy'=>false])!!}
            </span>
            <p>{{$cartItem->model->title}}</p>
            <small>{{$cartItem->qty}} × {{format_money($cartItem->price)}}</small>
        </a>
        @else
        <a href="#">
            <p>{{$cartItem->name}}</p>
            <small>{{$cartItem->qty}} × {{format_money($cartItem->price)}}</small>
        </a>
        @endif
        <span class="close_icon float-right bravo_delete_cart_item" data-id="{{$cartItem->rowId}}"><i class="fa fa-plus"></i></span>
    </li>
    @endforeach
    <li class="list_content" >
        <h5>{{__('Subtotal')}}: {{format_money(Cart::subtotal())}}</h5>
        <a href="{{route('booking.cart')}}" class="btn btn-thm cart_btns">{{__('View cart')}}</a>
        <a href="{{route('booking.checkout')}}" class="btn btn-thm3 checkout_btns">{{__('Checkout')}}</a>
    </li>
@else
    <li class="list_content" style="animation-delay: 0.19s;">
        {{__("Your cart is empty")}}
    </li>
@endif
