$(document).ready(function () {


var chatquill = new Quill('#chat-answer',{

    modules: {
        toolbar: {
            container:  [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
            ],
        },
    },

    placeholder: 'Ваш ответ...',
    theme: 'snow'
});
    var objDiv =  document.getElementById("chat");
    objDiv.scrollTop = objDiv.scrollHeight;
})

var curDate = new Date();
var date = curDate.getHours() + ':' + curDate.getMinutes();
var socket = new WebSocket("ws://localhost:8080");
var status = document.querySelector('#status');
var output = document.querySelector('.chat-output');
var btn = $('#send-answer');
var nick = $('#nick').val();
var answer =  $('.ql-editor ').html();
$(document).ready(function () {

    socket.onopen = function (e) {
        console.log('success');
    }

    socket.onmessage = function (e) {
        console.log(e.data);
        var div = document.createElement("div");
        div.classList.add("white", "bold", "new-answ", "chat-answ");
        output.appendChild(div);

        div.innerHTML +=  e.data;
        /*   var login = document.createElement("p");
        login.classList.add("regular");
        login.innerHTML +=  nick + ':';
        div.appendChild(login);*/
    };

    btn.on('click', function () {
        let img = $('.ql-editor img').attr('width');
        if (img > 1000) {
            $('.ql-editor img').attr('width', '1000');
        }
        var send = $(this);
        var tid = send.data('tid');
        var answer =  $('.ql-editor ').html();
        let msg = $('.ql-editor ').text();

        if (msg.length > 500)
            alert('Лимит 500 символов');
        if (msg == '')
            alert('Пустое поле');
        if (msg !== '' && msg.length <= 500)
            {
            socket.send(nick + ":" + answer);
            $('.ql-editor ').empty();
                $.ajax ({
                    url: '/form/handler.php',
                    type: 'POST',
                    data: {
                        chatanswer:answer,
                        login:nick,
                    },

                })
        }


        var top =
        $('.chat-output').animate({ scrollTop: 100000000000}, 1000);
        return false;

    })
})
