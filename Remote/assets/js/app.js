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

    window.loginUser = loginUser;
    function loginUser() {
        const username = $('#form_username').val();
        const password = $('#form_password').val();
        $.ajax({
            url: "/loginUser",
            type: "post",
            data : { username : username, password : password},
            success: function(response) {
                if(response == 'admin') {
                    window.location.href = '/admin'
                }
                if(response == 'user') {
                    window.location.href = '/panel'
                }
            }
        })
    }

    $('form').keydown(function (event) {
        var keypressed = event.keyCode || event.which;
        if (keypressed == 13) {
            loginUser();
        }
    });

    let usernameValid = 0;
    let passwordValid = 0;

    window.checkEmail = checkEmail;
    function checkEmail() {
        const username = $('#form_username').val();
        const regexEmail = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
        const checkRegexEmail = () => regexEmail.test(username);
        if(checkRegexEmail(username)) {
            activateButtonEmail();
        }
    };

    window.checkPassword = checkPassword;
    function checkPassword() {
        const password = $('#form_password').val();
        if(password.length > 7) {
            passwordValid = 1;
            activateButtonPassword();
        } else if(password.length < 7){
            passwordValid = 0;
            activateButtonPassword();
        }
    };

    window.activateButtonPassword = activateButtonPassword;
    function activateButtonPassword() {
        const usernameValid = 1;
        if(usernameValid && passwordValid) {
            $("#form_submit").attr("disabled", false);
        } else if (!usernameValid || !passwordValid){
            $("#form_submit").attr("disabled", true);
        }
    };

    window.checkEmail = checkEmail;
    function checkEmail() {
        const username = $('#form_username').val();
        const regexEmail = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
        const checkRegexEmail = () => regexEmail.test(username);
        if(checkRegexEmail(username)) {
            $.ajax({
                url: "/checkUsernameAvaibility",
                type: "post",
                data: { username : username },
                success: function(response) {
                    if(response == 1) {
                        usernameValid = 1;
                        activateButtonEmail();
                        if($('.username .emailError')) {
                            $('.username .emailError').remove();
                        }
                    } else if(response == 0) {
                        usernameValid = 0;
                        activateButtonEmail();
                        const message = '<div class="emailError">This email is registered. <a href="/resetPassword">May you reset password?</a></div>';
                        if($('.username .emailError').length == 0) {
                            $('.username').append(message);
                        }
                    }
                }
            })
        }
    };

    $('form').keydown(function (event) {
        var keypressed = event.keyCode || event.which;
        if (keypressed == 13) {
            loginUser();
        }
    });

    window.checkPassword = checkPassword;
    function checkPassword() {
        const password = $('#form_password').val();
        if(password.length > 7) {
            passwordValid = 1;
            activateButtonPassword();
        } else if(password.length < 7){
            passwordValid = 0;
            activateButtonPassword();
        }
    };

    window.activateButtonEmail = activateButtonEmail;
    function activateButtonEmail() {
        if(usernameValid) {
            $("#form_submit").attr("disabled", false);
        } else if (!usernameValid){
            $("#form_submit").attr("disabled", true);
        }
    };

    window.sendRegistrationMail = sendRegistrationMail;
    function sendRegistrationMail() {
        const username = $('#form_username').val();
        $.ajax({
            url: "/sendRegisterMail",
            type: "post",
            data: { username : username },
            success: function(response) {
                if(response == 1) {
                    window.location.href = '/';
                } else if(response == 0) {
                    alert('Error. Please contact us');
                }
            }
        })
    };

    window.registerUser = registerUser;
    function registerUser() {
        const username = $('#form_username').val();
        const password = $('#form_password').val();
        $.ajax({
            url: "/registerUser",
            type: "post",
            data : { username : username, password : password },
            success: function(response) {
                if(response == 1) {
                    window.location.href = '/';
                } else if(response == 0) {
                    alert('Error. Please contact us');
                }
            }
        });
    };


});





