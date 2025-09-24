<div class="card_stripe">
    <form action="https://easypay.easypaisa.com.pk/easypay/Confirm.jsf" method="POST" id="easypaisaConfirmForm">
        <input type="hidden" name="auth_token" value="{{$data['auth_token']}}">
        <input type="hidden" name="postBackURL" value="{{$data['postBackURL']}}">
        <input style="display:none;" type="submit" id="payBtn" class="btn btn-info py-2" value="Proceed to Checkhout">
    </form>
</div>