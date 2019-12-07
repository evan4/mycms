jQuery(function($) {
    "use strict";
    
    var email = $('#email'),
        emailpattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        emailTooltip= "Введите корректный email",

        result = $('.result');
       
    $.ajaxSetup({
        dataType: "json",
        method: "POST",
    });

    function checkReg(o, regexp, tooltip) {
        if (!(regexp.test(o.val())) || o.val() === $(o).attr('placeholder')) {
            errorField(o, tooltip);
        } else {
            $(o).removeClass("errors").siblings("span").remove();
            return true;
        }
    }

    function errorField(o, tooltip){
        var position = o.position();
        if($(o).next( ".text-danger" ).length>0){
            $(o).next( ".text-danger" ).slideDown();
        }else{
            $("<span class='text-danger' style='top: "+(position.top + 30)+"px'>"+tooltip+"</span>").insertAfter(o); 
            $(o).next( ".text-danger" ).slideDown();
        }
      o.addClass("errorField");
      return false;
    }

    $('#email').on('change', function () { 
        result.empty();

        var fValid;
        fValid = true;

        fValid = fValid && checkReg(email, emailpattern, emailTooltip);

        var data = $(this).serializeArray();

        if (fValid) {
            $.ajax({
                url: '/user-exists',
                data: data
            })
            .done(function (res) {
                if (Object.keys(res).length) {
                    output(res);
                }
                
            })
            .fail(function (error) {
                
            });
        }
    });

    $('#form-reg').on('submit', function (e) {
        e.preventDefault();

        result.empty();

        var fValid;
        fValid = true;

        fValid = fValid && checkReg(email, emailpattern, emailTooltip);

        var data = $(this).serializeArray();

        if (fValid) {
            $.ajax({
                url: '/singup',
                data: data
            })
            .done(function (res) {
                
                if (!Object.keys(res).length) {
                    window.location ='/admin';
                }
                output(res);
            })
            .fail(function (error) {
                let res = {
                    'error': 'Произошла ошибка. Попробуйте еще раз'
                }
                output(res);
            });
        }
    });

    function output(data) {
        let list =  '<ul class="list-group mb-2">';

        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                const element = data[key];
                list += '<li class="list-group-item list-group-item-danger">'+element+'</li>';
            }
        }
        list += '</ul>';
        result.append(list);
    }

});
