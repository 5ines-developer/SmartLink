// $(document).ready(function(){
// 	$('.sidenav').sidenav(); 

// $(".dropdown-trigger").dropdown();

//         });

$(window).scroll(function() {


    if ($(this).scrollTop() == 0) {

        $('#secondnavbar').removeClass('fixed1');

        $('.hederHight').removeClass('h84');

    } else {

        $('#secondnavbar').addClass('fixed1');

        $('.hederHight').addClass('h84');

    }

});


// mobile screen agent dashboard show and hide
$(document).ready(function() {
    $('#sidebarToggle').on('click', function() {
        $('#sidebarclose').css('display', 'block');
        $('#agent-sidebar').css('display', 'block');
        $('#sidebarToggle').css('display', 'none');
    });
    $('#sidebarclose').on('click', function() {
        $('#agent-sidebar').css('display', 'none');
        $('#sidebarToggle').css('display', 'block');
        $('#sidebarclose').css('display', 'none');
    });

});

$(document).ready(function() {
    $('.close-model').click(function(e) {
        e.preventDefault();
        $('.overlay-popup').css({ 'visibility': 'hidden', 'opacity': '0' });
    });
});