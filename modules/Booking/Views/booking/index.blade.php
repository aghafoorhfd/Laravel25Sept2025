@extends('layouts.app')
@section('content')
<script src="https://www.paypalobjects.com/api/sdk.js"></script>
<div id="paypal-button"></div>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__('All Bookings')}}</h1>
        </div>
           <div style="text-align: center;">
  <div id="paypal-button-container"></div>
</div>     
    </div>
@endsection
@section('script.body')
    <script>
  function initPayPalButton() {
  /*
    This is a server side integration of the client side PayPal JavaScript SDK -
    The createOrder method makes a call to the PayPal API -
    The PayPal documentation uses the fetch() method but Apps Script uses google.script.run
    to make a server call so the PayPal example must be modified -
  */

  paypal.Buttons({
    style: {
      shape: 'rect',
      color: 'gold',
      layout: 'vertical',
      label: 'paypal',
    },
    
    createOrder : function() {
      //console.log('createOrder 93' + 'order')
      return iWillWaitForU()// Call the server code to complete the payment transaction
        //This both creates and executes the transaction
        .then(function(response) {
          //console.log('response 89' + response)
          return JSON.parse(response);
          //window.PayPalOrderId = orderInfo.id;
          //return orderInfo.id;
          },//THERE MUST BE A COMMA HERE!!!!  This is a list of functions seperated by a comma
          function (error) {//Because this is the second function this is what gets called for an error
            showModalMessageBox("There was an error in the PayPal button!","ERROR!");
            //console.log(error);
            return "Error";
        }).then(
           function(orderObj){
           //console.log('orderObj.orderID' + orderObj.id)
          return orderObj.id;
        });
    },
    
    onApprove: function() {
      //console.log('onapprove ran')
      startSpinner();
  
      backToStartPay();
     
      capture_the_order({"which":"capture","orderId":window.PayPalOrderId})
        .then(
  
        function(hadSuccess) {
          //cl('hadSuccess 89',hadSuccess)
          if (hadSuccess) {
            payPalPaymentComplete();
            //console.log('Transaction completed !');
            } else {
            showModalMessageBox("There was an error getting the payment!","ERROR!");
            //console.log(error);
            stopSpinner();
            }
          },//THERE MUST BE A COMMA HERE!!!!  This is a list of functions seperated by a comma
          function (error) {//Because this is the second function this is what gets called for an error
            showModalMessageBox("There was an error getting the payment!","ERROR!");
            //console.log(error);
            stopSpinner();
        })
    },


    onCancel: function (data, actions) {
      // Show a cancel page or return to cart
      showModalMessageBox('PayPal Session was cancelled',"CANCELLED!");
      backToStartPay();
    },
    
    onError: function(err) {
      showModalMessageBox("There was an error in the PayPal button!","ERROR!");
      //console.log(err);
    }
    
  }).render('#paypal-button-container');//Render the PayPal button into the html element with id #paypal-button-container - 
  //See HTML file - H_PayPal_New
  
}
initPayPalButton();
</script>
@endsection
