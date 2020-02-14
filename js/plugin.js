$=jQuery;
$(document).ready(function(){
$("#inner-caption").owlCarousel({
    items:1,
    autoPlay : false,
    rtl:true,
    navigation:false,
    pagination:true,
    loop:3000,
    itemsTablet: [1000,1], 
    itemsMobile : [750,1],
    itemsDesktopSmall: [1200,1],
    itemsDesktop: [1280,1],
    navigationText:['<i class="flaticon-back"></i>','<i class="flaticon-right-arrow"></i>'],
    autoPlaySpeed: 5000,
    autoPlayTimeout: 5000,
    autoplayHoverPause: true

});  

$(".owl-news").owlCarousel({
    items:4,
    autoPlay : true,
    rtl:true,
    navigation:false,
    pagination:true,
    loop:3000,
    itemsTablet: [1000,3], 
    itemsMobile : [750,1],
    itemsDesktopSmall: [1200,3],
    itemsDesktop: [1280,1],
    navigationText:['<i class="flaticon-back"></i>','<i class="flaticon-right-arrow"></i>'],
    autoPlaySpeed: 5000,
    autoPlayTimeout: 5000,
    autoplayHoverPause: true

});  
$(".owl-photos").owlCarousel({
    items:2,
    autoPlay : true,
    rtl:true,
    navigation:false,
    pagination:false,
    loop:3000,
    itemsTablet: [1000,2], 
    itemsMobile : [750,1],
    itemsDesktopSmall: [1200,3],
    itemsDesktop: [1280,1],
    navigationText:['<i class="flaticon-back"></i>','<i class="flaticon-right-arrow"></i>'],
    autoPlaySpeed: 5000,
    autoPlayTimeout: 5000,
    autoplayHoverPause: true

}); 
$(".owl-product").owlCarousel({
    items:1,
    autoPlay : true,
    rtl:true,
    navigation:false,
    pagination:false,
    loop:3000,
    itemsTablet: [1000,1], 
    itemsMobile : [750,1],
    itemsDesktopSmall: [1200,1],
    itemsDesktop: [1280,1],
    navigationText:['<i class="flaticon-back"></i>','<i class="flaticon-right-arrow"></i>'],
    autoPlaySpeed: 5000,
    autoPlayTimeout: 5000,
    autoplayHoverPause: true

});  
var slides=$(".slideShow > li");
var slideCount=0;
var totalSlides = slides.length;
var slideCache = [];
(function preloader(){
    if(slideCount < totalSlides){
        slideCache[slideCount]=new Image();
        slideCache[slideCount].src=slides.eq(slideCount).find("img").attr("src");
        slideCache[slideCount].onload =function(){
            slideCount ++;
            preloader();
        }
    }
    else{
        slideCount=0;
        slideShow();
    }
}())
function slideShow(){
    slides.eq(slideCount).fadeIn(1000).delay(2000).fadeOut(1000,function(){
        slideCount < totalSlides -1 ? slideCount ++ : slideCount = 0;
        slideShow();
    })
}

var slidebar_width  = 290;
var slide_bar       = $(".side-menu-wrapper");
var slide_open_btn  = $(".mob-menu-open");
var slide_close_btn = $(".menu-close"); 
var overlay         = $(".side-menu-overlay");
 slide_open_btn.click(function(e){
    
   e.preventDefault();
   slide_bar.css( {"right": "0px"});
   overlay.css({"opacity":"1", "width":"100%"});
});
slide_close_btn.click(function(e){
   e.preventDefault();
   slide_bar.css({"right": "-"+ slidebar_width + "px"});
   overlay.css({"opacity":"0", "width":"0"});  
});

 











})/* end */