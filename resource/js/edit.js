

$('.remove-answ').on('click', function () {
    var remove = $(this);
    var answid = remove.data('answid');

    $.ajax ({
        url: '/form/handler.php',
        type: 'POST',
        data: { answid:answid,
        },
        async: false,
        success: function (result) {
            $(function () {
                location.reload();
                $(window).scrollTop(0);
            });

        }
    })
})
function edit_query(name, data) {
    var str;
    $.each(data.split('.'), function (key, value) {
        str += '&' + value + '=' + $('#' + value).val();
    });
    $.ajax({
        url: '/form/edit.php',
        type: 'POST',
        dataType: 'html',
        data: name + '_form=1' + str,
        cache: false,
        success: function (result) {
            if (result == 'Успешное изменение') {
                location.reload();
                $('#msg').html(result);
                $('#msg').css('color', 'green');
            } else {
                $('#msg').html(result);
            }
        }
    });
}

function remove(name) {
    $.ajax({
        url: '/form/handler.php',
        type: 'POST',
        data: name,
        cache: false,
        sucess: function (result) {
            alert(result);
        }
    })
}

$('.prof-btn').on('click', function prof_drop(e) {
    e.preventDefault();
    $(this).toggleClass('prof-btn_active');
    $('.prof-drop').slideToggle(300);
});
$('.create-theme').click(function () {
    $('.select-section').slideToggle(200);
})
$(window).mouseup(function (e) {
    if(!$('.prof-btn').is(e.target)) {
        $('.prof-drop').hide();
        $('.prof-btn').removeClass('prof-btn_active');
    }
})
$(document).on( 'submit', '#create-sect', function(e) {
    e.preventDefault();
    let sect = $(this).val();
    let theme = $(this.theme).val();
    let cat = $(this.cat).val();

    $.ajax({
        url: '/form/handler.php',
        type: 'post',
        data: {
            sect:sect,
            theme:theme,
            cat:cat,
        },
        success: function (result) {
            if (result !='')
               $('#error').html(result);
            else
                location.reload();
            /*$('.discussions').load("/discussions .discussions >");*/
        },
        error: function (error) {
            console.log('ошибка' + error);
        }
    })
})
