$(function(){

  $(".IconUsuario, .textoEntrar").click(function() {
    $(".modalConteiner").fadeIn();
  });
  $("#fechar").click(function() {
    $(".modalConteiner").fadeOut();
  });

  $(document).keyup(function(e) {
    if (e.keyCode == 27) {
      $(".modalConteiner").fadeOut();
    }

  });

  


});
