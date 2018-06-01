var width = $(window).width();

$(window).resize(function(){

    width = $(window).width();

    setNiceScroll();

})

$(document).ready(function(){

    $('.select2').select2({
        width: '100%'
    });

    setNiceScroll();

})

function setNiceScroll(){

    if(width >= 992){

        $("body").niceScroll({
            cursorcolor:"#1386ca",
            cursorwidth:"10px",
            scrollspeed: 100,
            mousescrollstep: 12 * 3,
            cursoropacitymax: 0.4,
            spacebarenabled: false,
            horizrailenabled:false
        });

        $('.nicescroll').getNiceScroll().remove();
        // $('.custom-navbar').getNiceScroll().remove();

    }else{

        $(".nicescroll").niceScroll({
            cursorcolor:"#1386ca",
            cursorwidth:"10px",
            scrollspeed: 100,
            mousescrollstep: 12 * 3,
            cursoropacitymax: 0.4,
            spacebarenabled: false,
            horizrailenabled:false
        });

        // $(".custom-navbar").niceScroll({
        //     cursorcolor:"#1386ca",
        //     cursorwidth:"10px",
        //     scrollspeed: 100,
        //     mousescrollstep: 12 * 3,
        //     cursoropacitymax: 0.4,
        //     spacebarenabled: false,
        // });

        // $('.nicescroll').getNiceScroll().remove();

    }

}