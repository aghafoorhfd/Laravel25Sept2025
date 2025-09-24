"use strict";
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

window.bravo_format_money =  function($money) {

    if (!$money) {
        //return bookingCore.free_text;
    }
    //if (typeof bookingCore.booking_currency_precision && bookingCore.booking_currency_precision) {
    //    $money = Math.round($money).toFixed(bookingCore.booking_currency_precision);
    //}

    $money            = bravo_number_format($money*bookingCore.currency_rate, bookingCore.booking_decimals, bookingCore.decimal_separator, bookingCore.thousand_separator);
    var $symbol       = bookingCore.currency_symbol;
    var $money_string = '';

    switch (bookingCore.currency_position) {
        case "right":
            $money_string = $money + $symbol;
            break;
        case "left_space":
            $money_string = $symbol + " " + $money;
            break;

        case "right_space":
            $money_string = $money + " " + $symbol;
            break;
        case "left":
        default:
            $money_string = $symbol + $money;
            break;
    }

    return $money_string;
}

window.bravo_number_format = function (number, decimals, dec_point, thousands_sep) {


    number         = (number + '')
        .replace(/[^0-9+\-Ee.]/g, '');
    var n          = !isFinite(+number) ? 0 : +number,
        prec       = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep        = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec        = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s          = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                .toFixed(prec);
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s              = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
}

window.bravo_handle_error_response = function(e){
    switch (e.status) {
        case 401:
            // not logged in
            $('#login').modal('show');
            break;
    }
};

// Form validation
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
});

var bookingCoreApp ={
    showSuccess:function (configs){
        var args = {};
        if(typeof configs == 'object')
        {
            args = configs;
        }else{
            args.message = configs;
        }
        if(!args.title){
            args.title = i18n.success;
        }
        args.centerVertical = true;
        bootbox.alert(args);
    },
    showError:function (configs) {
        var args = {};
        if(typeof configs == 'object')
        {
            args = configs;
        }else{
            args.message = configs;
        }
        if(!args.title){
            args.title = i18n.warning;
        }
        args.centerVertical = true;
        bootbox.alert(args);
    },
    showAjaxError:function (e) {
        var json = e.responseJSON;
        if(typeof json !='undefined'){
            if(typeof json.errors !='undefined'){
                var html = '';
                _.forEach(json.errors,function (val) {
                    html+=val+'<br>';
                });

                return this.showError(html);
            }
            if(json.message){
                return this.showError(json.message);
            }
        }
        if(e.responseText){
            return this.showError(e.responseText);
        }
    },
    showAjaxMessage:function (json) {
        if(json.message)
        {
            if(json.status){
                this.showSuccess(json);
            }else{
                this.showError(json);
            }
        }
    },
    showConfirm:function (configs) {
        var args = {};
        if(typeof configs == 'object')
        {
            args = configs;
        }
        args.buttons = {
            confirm: {
                label: '<i class="fa fa-check"></i> '+i18n.confirm,
            },
            cancel: {
                label: '<i class="fa fa-times"></i> '+i18n.cancel,
            }
        };
        args.centerVertical = true;
        bootbox.confirm(args);
    }
};


$(document).on('click','.bravo_add_to_cart',function(e){
    e.preventDefault();
    $(this).addClass('loading');
    var me = $(this);
    $.ajax({
        url:bookingCore.routes.add_to_cart,
        data:$(this).data('product'),
        type:'post',
        dataType:'json',
        success:function(json){
            me.removeClass('loading');
            if(json.fragments){
                for(var k in json.fragments){
                    $(k).html(json.fragments[k]);
                }
            }
            if(json.url){
                window.location.href = json.url;
            }
            if(json.message){
                bookingCoreApp.showAjaxMessage(json);
            }

        },
        error:function(err){
            bravo_handle_error_response(err);
            me.removeClass('loading');
            console.log(err)
        }
    })
})
$(document).on('click','.bravo_delete_cart_item',function(e){
    e.preventDefault();

    var c = confirm(i18n.delete_cart_item_confirm);
    if(!c) return;

    var me = $(this);
    var id = $(this).data('id');
    $.ajax({
        url:bookingCore.routes.remove_cart_item,
        data:{
            id:id
        },
        type:'post',
        dataType:'json',
        success:function(json){
            if(json.fragments){
                for(var k in json.fragments){
                    $(k).html(json.fragments[k]);
                }
            }
            if(json.url){
                window.location.href = json.url;
            }
            if(json.reload){
                window.location.reload();
            }
            if(json.message){
                bookingCoreApp.showAjaxMessage(json);
            }

        },
        error:function(err){
            bravo_handle_error_response(err);
            console.log(err)
        }
    })
})

$(document).on('click','.preview_url_lesson',function(e){
    let preview_url = $(this).data('url');
    let title_name = $(this).data('title');
    var args = {};
    args.title = '<b>'+title_name+'</b>';
    if(preview_url.includes('uploads')){
        args.message = '<video width="100%" height="100%" controls><source src="'+preview_url+'" type="video/mp4">Your browser does not support the video tag.</video>';
    }else{
        args.message = '<iframe class="iframe_video" height="300" src="'+preview_url+'" frameborder="0" allowfullscreen></iframe>';
    }
    args.centerVertical = true;
    args.size = 'lg';
    bootbox.alert(args);
});


