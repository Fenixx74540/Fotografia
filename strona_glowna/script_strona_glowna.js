$(document).ready(function(){
    $(window).scroll(function(){
        if(this.scrollY > 20){
            //po przekręceniu kółkiem 20px w osiY (pion) to doda się klasa sticky,
            //która dodaje tło do paska nawigacji
            $('.navbar').addClass("sticky");
        }else{
            //gdy wrócimy z powrotem do góry to usuwa klasę 
            $('.navbar').removeClass("sticky");
        }
        if(this.scrollY > 500){
            //po przekręceniu kółkiem 500px w osiY (pion) to doda się klasa show,
            //która ujawnia ukrytą ikonę strzałki
            $('.scroll-up-btn').addClass("show");
        }else{
            //gey wrócimy z powrotem do góry to usuwa klasa 
            $('.scroll-up-btn').removeClass("show");
        }
    }); 

    //skrypt przesuwania płynnie strony do góry
    $('.scroll-up-btn').click(function(){
        $('html').animate({scrollTop: 0});
        //usunięcie płynnego przewijania po kliknięciu strzałki przewijania do góry
        $('html').css("scrollBehavior", "auto");
    });

    $('.navbar .menu li a').click(function(){
        //aktywowanie płynnego przewijania po kliknięciu w menu
        $('html').css("scrollBehavior", "smooth");
    });

    //skrypt przełączający tryb menu
    $('.menu-btn').click(function(){
        $('.navbar .menu').toggleClass("active");
        $('.menu-btn i').toggleClass("active");
    });

    //animacja wstukiwania liter oraz ich usuwania
    var typed = new Typed(
       ".typing", {
        strings: ["Fotografem", "Blogerem", "Freelancerem"],
        typeSpeed: 70,
        backSpeed: 50,
        loop: true
       } 
    );

    var typed = new Typed(
        ".typing-2", {
         strings: ["Fotografem", "Blogerem", "Freelancerem"],
         typeSpeed: 70,
         backSpeed: 50,
         loop: true
        } 
     );

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