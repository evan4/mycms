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
        result.hide();

        var fValid;
        fValid = true;
        fValid = fValid && checkReg(email, emailpattern, emailTooltip);
        var data = $(this).serializeArray();
        data[data.length] = { "name": "csrf", "value": $('#csrf').val() };

        if (fValid) {
            $.ajax({
                url: '/auth',
                data: data
            })
            .done(function (res) {
                console.log(res);
                if (res.error) {
                    result.show().find('li').text(res.error);
                }
            })
            .fail(function () {
                result.show().find('li').text('Произошла ошибка. Попробуйте еще раз');
            });
        }

       e.preventDefault();
    });


});