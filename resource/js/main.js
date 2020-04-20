$(window).on("load",function () {
    $('.slick-arrow').append("<img src='/resource/img/back.png'>");
    createSlick();

})

function createSlick() {
    $('.slider').not('.slick-initialized').slick();
}
$("#create_sect").on('click', function(e){
    e.preventDefault();
    $('.create-block:not(:animated)').toggle(200);
});

$(window).mouseup(function (e) {
    if(!$('#create-block *').is(e.target)) {
        $('#create-block').hide("slide");
    }
     if (!$('.search-bar *').is(e.target)) {
        $('.search-bar').hide("slide");
        $('.search-bar input').val('');
        $('#search-res').empty();
    }
})



function thread_create() {
    $('.modal').fadeIn(350);
    $('.modal').css('display', 'flex');
}

$('.close-modal').click(function thread_close() {
    $('.modal').fadeOut(350);
})


$('#create-thread').click(function(event) {
    event.preventDefault();
    var name = $(this).attr('id');
    var answer = $('.ql-editor').html();
    var theme = $('#thread').val();
    var section = $('#section').val();
    $.ajax({

        url: '/form/handler.php',
        type: 'post',
        dataType:'json',
        data:
            {
                create_thread:name,
                theme:theme,
                answer:answer,
                section:section,

            },
        beforeSend:function (result) {
            $('#create-thread').attr('disabled', true);
        },
        success: function (result) {
            if(result.success != '') {

                $('#msg').css('color', 'green');
                $('#msg').html(result.success);
                if (result.success == 'Обсуждение создано') {
                    setTimeout(function () {
                        window.location.href = "http://localhost/discussions/thread/"+result.tid;
                    },1000)
                }
                else {
                    setTimeout(function () {
                        location.reload();
                    },2000)
                }
            }
            else {
                $('#msg').css('color', 'red');
                $('#msg').html(result.error);
                $('#create-thread').removeAttr('disabled', true);
            }
        }
    });
    return false;
})

$('.sort-elem').on('click', function () {

    var sort = $(this);
    var type = sort.data('type');
    $.ajax ({
        url: '/form/handler.php',
        type: 'POST',
        data:{type:type},
        success: function (data) {
            location.reload();
        }
    })

})

$('#pic').on('change', function () {
    var files = $(this).val();
    $.ajax ({
        url: '/form/handler.php',
        type: 'POST',
        data: {files:files},
        success: function (result) {
            alert(result);
        }
    })
})


