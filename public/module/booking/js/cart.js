(function ($) {
    "use strict";
    new Vue({
        el:'#bravo-cart-page',
        data:{
            onSubmit:false,
            message:{
                content:'',
                type:false
            },
            coupon:''
        },
        methods:{
            deleteCartItem:function(item){
                $.ajax({
                    url:bookingCore.url+'/delete-cart-item',
                    data:{
                        id:item.rowId
                    },
                    method:"post",
                    success:function (res) {
                        if(!res.status && !res.url){
                            me.onSubmit = false;
                        }

                        if(res.elements){
                            for(var k in res.elements){
                                $(k).html(res.elements[k]);
                            }
                        }

                        if(res.message)
                        {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }

                        if(res.url){
                            window.location.href = res.url
                        }

                        if(res.errors && typeof res.errors == 'object')
                        {
                            var html = '';
                            for(var i in res.errors){
                                html += res.errors[i]+'<br>';
                            }
                            me.message.content = html;
                        }
                        
                        if(res.fragments){
                            for(var k in res.fragments){
                                $(k).html(res.fragments[k]);
                            }
                        }

                    },
                    error:function (e) {
                        me.onSubmit = false;
                        if(e.responseJSON){
							me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
							me.message.type = false;
                        }else{
                            if(e.responseText){
								me.message.content = e.responseText;
								me.message.type = false;
                            }
                        }


                    }
                })
            },
            applyCoupon:function(){},
            updateCart:function(){},
            validate(){
                return true;
            }
        }
    })
})(jQuery)
