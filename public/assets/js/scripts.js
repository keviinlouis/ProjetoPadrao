// var scroll_y;

// $(window).scroll(function(){

//     scroll_y = $(window).scrollTop();

//     if(scroll_y >= 200){

//         $('.custom-navbar').addClass('default');

//     }else{

//         $('.custom-navbar').removeClass('default');

//     }

// })

$(document).ready(function(){

    // Clicando no menu, ira scrollar para o ID que estiver em HREF
    $('.menu-item').click(function(){

        var section_id = $(this).children().attr('href');

        $("html, body").animate({
            scrollTop: $(section_id).offset().top
        }, 500);

    })

})