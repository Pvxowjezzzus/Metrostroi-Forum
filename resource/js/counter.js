$(document).ready(function () {
    $('.like').on('click', function () {

        var like = $(this);
        var uid = like.data('uid');
        var aid = like.data('aid');
        var authorid = like.data('authorid');

       $.ajax ({
            url: '/form/counter.php',
            type: 'POST',
            data: { aid:aid,
                    uid:uid,
                    authorid:authorid,
            },
            success: function (result) {
                location.reload();
            }
       })
    })
})