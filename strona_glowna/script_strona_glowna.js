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
    })
});