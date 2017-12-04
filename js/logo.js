$(document).ready(function() {

  var loginho = $("#loginho");

  $(window).scroll(function() {
    if($(this).scrollTop() > 100){

      loginho.fadeIn();
    }else {
      loginho.fadeOut();
    }
  });
});
