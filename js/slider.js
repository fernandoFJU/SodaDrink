
$(document).ready(function(){
 $('#slider').slick({
    autoplay: true,
    autoplaySpeed: 2000,
    dots: false,
    infinite: true,
    speed: 1500,
    fade: true,
    cssEase: 'ease',
    arrows:"true",
    pauseOnHover: false
  });
  $('#slider2').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    infinite: true,
    dots: true,
    arrows:"false",
    pauseOnHover: false,
    autoplay: true,
    autoplaySpeed: 2000
   });
});
