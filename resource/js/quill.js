var quill = new Quill('#answer', {
    modules: {
        toolbar: {
            container:  [
    ['bold', 'italic', 'underline', 'strike'],
    ['image', 'blockquote', 'link'],
    [{ 'size': ['small', false, 'large', 'huge'] }],
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
    [{ 'color': [] }, { 'background': [] }],
    [{ 'font': [] }],
    [{ 'align': [] }],
],
            handlers: { image:  imageHandler},
        },
        imageResize: {
            handleStyles: {
                backgroundColor: 'white',
                border: 'none',
                color: 'white'
            },
            modules: [ 'Resize', 'DisplaySize', 'Toolbar']
        },
    },

    placeholder: 'Ваш ответ...',
    theme: 'snow'
});



function imageHandler() {
    $('#picture').click();
}

$('#picture').change(function () {
    var formData = new FormData($('#upload').get(0));
    $.ajax({
        url: '/form/handler.php',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'post',
        success: function(result){
            if(result == "Запрещенный тип файла!") {
            alert(result);
                }
            else
                var res = result.replace(/^\s*(.*)\s*$/, '$1');
                quill.insertEmbed(1, 'image', '/resource/pics/'+ res);
                quill.format('color', )

        }
    });
});

$('#send-answer').on('click', function () {
    let img = $('.ql-editor img').attr('width');
    if (img > 1000) {
        $('.ql-editor img').attr('width', '1000');
    }
    var send = $(this);
    var tid = send.data('tid');
    var answer =  $('.ql-editor ').html();

    $.ajax ({
        url: '/form/handler.php',
        type: 'POST',
        data: {answer:answer,
            tid:tid,
        },
        success: function (result) {
            if (result != '') {
                alert(result);
            }
            else {
                $('#send-answer').attr('disabled', 'disabled');
                location.reload();

            }

        }
    })

})
