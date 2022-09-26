$(window).on('load', function(event) {
    $('body').removeClass('preloading');
    // $('.load').delay(1000).fadeOut('fast');
    $('.loader,.textLoad').delay(4000).fadeOut('fast');
})
var timer = setTimeout(function() {
    window.location = 'manage.php'
}, 2000);