$(function () {
  $(".iconeMenu").click(function () {
    $(".menuOffCanvas").css({"-webkit-transform":"translateX(800px)"});
    $(".background").css({"display":"block"});
  });
  $(".voltar").click(function () {
    $(".menuOffCanvas").css({"-webkit-transform":"translateX(-800px)"});
    $(".background").css({"display":"none"});
  });
  $(".background").click(function () {
    $(".menuOffCanvas").css({"-webkit-transform":"translateX(-800px)"});
    $(this).css({"display":"none"});
  });
});
