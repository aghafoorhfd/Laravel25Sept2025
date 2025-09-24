<div class="card_stripe">
    <form action="https://easypay.easypaisa.com.pk/easypay/Index.jsf" method="POST" id="myCCForm">
        <input type="text" name="amount" value="{{$post_data['amount']}}">
        <input type="text" name="storeId" value="{{$post_data['storeId']}}">
        <input type="text" name="postBackURL" value="{{$post_data['postBackURL']}}">
        <input type="text" name="orderRefNum" value="{{$post_data['orderRefNum']}}">
        <input type="text" name="expiryDate" value="{{$post_data['expiryDate']}}">
        <input type="text" name="autoRedirect" value="{{$post_data['autoRedirect']}}">
        <input type="text" name="merchantHashedReq" value="{{$post_data['merchantHashedReq']}}">
        <input type="text" name="paymentMethod" value="{{$post_data['paymentMethod']}}">

        <div class="card-body p-3">   
            <h2>Pay With</h2>
            <br>
            <div class="text-right">
                <a href="index.php" id="payBtn" class="btn btn-primary py-2">Back</a> 
                <input type="submit" id="payBtn" class="btn btn-info py-2" value="Proceed to Checkhout">
            </div>
        </div>
    </form>
</div>