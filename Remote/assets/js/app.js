require('../css/app.scss');

const $ = require('jquery');

$(document).ready(function(){

    let getJobsNamesCounter = 0;

    $('#select_lang').val(getCookie('lang'));
    $('#select_lang').css('display', 'inline');

    window.getval = getval;
    function getval(sel) {
        setCookie('lang', sel.value, 365)
    }

    window.setCookie = setCookie;
    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        window.location.reload(false);
    }

    window.getCookie = getCookie;
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    $('#form_name').attr('autocomplete', 'off');

    $('#form_name').keyup(function () {
        if($("#form_name").val().length >= 3 && getJobsNamesCounter == 0) {
            $.ajax({
                url: "/getJobsNames",
                type: "post",
                data: { lang : getCookie('lang') },
                success: function(response) {
                    horsey(document.getElementById('form_name'), {
                        source: [{ list : response }],
                        limit: 5,
                    });
                    getJobsNamesCounter += 1;
                }
            });
        }
    });

});





