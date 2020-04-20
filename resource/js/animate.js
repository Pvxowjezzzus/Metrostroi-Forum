$('#search-btn').click(function () {
    $('.search-bar:not(:animated)').slideToggle(300);
})

$('.search-bar input').keyup(function () {
    let query = $(this).val();
    $.ajax ({
        url: '/form/handler.php',
        type: 'POST',
        cache:false,
        dataType: 'html',
        data: {query:query},
        success: function (data) {
           $('#search-res').html(data);
        }
    })
})