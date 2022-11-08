$(document).ready(function(){
    $(window).scroll(function(){
        if(this.scrollY > 20){
            //po przekręceniu kółkiem 20px w osiY (pion) to doda się klasa sticky,
            //która dodaje tło do paska nawigacji
            $('.navbar').addClass("sticky");
        }else{
            //gdy wrócimy z powrotem do góry to usuwa klasę dodającą w.w. atrybuty
            $('.navbar').removeClass("sticky");
        }
    });
    // skrypt przełączający tryb menu
    $('.menu-btn').click(function(){
        $('.navbar .menu').toggleClass("active");
        $('.menu-btn i').toggleClass("active");
    });

    //skrypt do karuzeli zdjęć owl-carousel
    $('.carousel').owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeOut: 2000,
        autoplayHoverPause: true,
        responsive: {
            0:{
                items: 1.2,
                nav: false
            },
            700:{
                items: 1.7,
                nav: false
            },
            800:{
                items: 2.2,
                nav: false
            },
            1000:{
                items: 2.5,
                nav: false
            },
            1200:{
                items: 3.12,
                nav: false
            },
            1700:{
                items: 3.4,
                nav: false
            }
        }
    });
});