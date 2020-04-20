
$('.signup').on('submit', function () {
    var data = 'signup.login.email.passwd.passwd2.captcha.quest';
    var str;
    $.each(data.split('.'), function (key, value) {
        str += '&' + value + '=' + $('#' + value).val();
    });
    var  quest = $('#captcha').attr('placeholder');
   str += quest;
    $.ajax({
        url: '/form/guest.php',
        type: 'POST',
        data:  str,
        cache: false,
        success: function (result) {
            if (result == 'Вы успешно зарегистрированы') {
                setTimeout(function () {
                    location.reload();
                }, 1000);
                alert(result);
            } else {
                alert(result);
            }
        }
    })
    return false;
})

$('.auth').on('submit', function () {
    var data = 'auth.auth_login.auth_passwd.auth_captcha.auth_quest';
    var str;
    $.each(data.split('.'), function (key, value) {
        str += '&' + value + '=' + $('#' + value).val();
    });
    var  quest = $('#auth_captcha').attr('placeholder');
    str += quest;
    $.ajax({
        url: '/form/guest.php',
        type: 'POST',
        data: str,
        cache: false,
        success: function (result) {
            if (result == 'Успех') {
                alert(result);
                location.reload();
            } else {
                alert(result);
            }
        }
    });
    return false;
})
