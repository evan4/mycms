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

    $('#form-login').on('submit', function (e) {
        e.preventDefault();

        result.empty();

        var fValid;
        fValid = true;
        fValid = fValid && checkReg(email, emailpattern, emailTooltip);
        var data = $(this).serializeArray();

        if (fValid) {
            $.ajax({
                url: '/auth',
                data: data
            })
            .done(function (res) {
                console.log(res);
                
                if (!Object.keys(res).length) {
                    console.log(Object.keys(res).length);
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
