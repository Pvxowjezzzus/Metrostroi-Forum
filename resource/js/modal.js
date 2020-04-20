
var signup_btn = $('#signup-btn');
var auth_btn = $('#auth-btn');


signup_btn.click(function() {
    $('.signup_modal').fadeIn(300);
})
auth_btn.click(function() {
    $('.auth_modal').fadeIn(300);
})

$('.close-modal').click(function() {
    $('.signup_modal').fadeOut(300);
    $('.auth_modal').fadeOut(300);
})

$(window).mouseup(function (e) {
    if(!$('#modal *').is(e.target)) {
        $('#modal').fadeOut(300);
        $('.auth_modal').fadeOut(300);
    }
})


