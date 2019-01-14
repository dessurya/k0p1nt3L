var win = $(window);

// for dekstop
if(win.width() >= 812){
    var initNavbar = 168;
    win.scroll(function () {
        // if (win.scrollTop() >= initNavbar) {
        //     $( "#nav" ).addClass( "scroll" );
        // }
        // else if (win.scrollTop() <= initNavbar) {
        //     $( "#nav" ).removeClass( "scroll" );
        // }
    });
}
// end for dekstop

// for mobile
if(win.width() <= 812){
    $('#kopin_banner #burger').click(function(){
        $('#kopin_banner').toggleClass("active");
        $('#navigasi').toggleClass("active");
    });
    // var initNavbar = 68;
    // win.scroll(function () {
    //     if (win.scrollTop() >= initNavbar) {
    //         $( "#nav" ).addClass( "scroll_mobile" );
    //     }
    //     else if (win.scrollTop() <= initNavbar) {
    //         $( "#nav" ).removeClass( "scroll_mobile" );
    //     }
    // });
}
// for mobile

// animate scrool to
    $(function() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 150
                        }, 1500);
                    return false;
                }
            }
        });
    });
// animate scrool to

// message
    // $(function(){
    //     $(document).on('submit', '#message form', function(){
    //         var url   = $(this).attr('action');
    //         var data  = $(this).serializeArray();

    //         // console.log(data);

    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //         $.ajax({
    //             url: url,
    //             type: 'post',
    //             dataType: 'json',
    //             data: data,
    //             beforeSend: function() {
    //                 $('#message .bar label.error').html('').hide();
    //                 $('#message #response').show();
    //                 $('#message #response #content').html('Waiting...! Send Your Request...!');
    //             },
    //             success: function(data) {
    //                 $('#message #response #content').html(data.msg);
    //                 if (data.response == false) {
    //                     $.each(data.resault, function(key, val){
    //                         $('#message .bar label#'+key+'.error').html(val).show();
    //                     });
    //                 }
    //                 window.setTimeout(function() {
    //                     $('#message #response').hide();
    //                     // grecaptcha.reset();
    //                 }, 1550);
    //             }
    //         });
    //         return false;
    //     });
    // });
// message  
