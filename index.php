<?php
  session_start();
  require_once('funcoes/funcoes.php');
  conexao();
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SodaDrink</title>
    <link rel="stylesheet" type="text/css" media="all" href="css/index.css"/>
    <link rel="stylesheet" type="text/css" href="js/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css"/>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/slick/slick.min.js"></script>
    <script type="text/javascript" src="js/slider.js"></script>
    <script type="text/javascript" src="js/logo.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/menuOffCanvas.js"></script>
    <script type="text/javascript">
      $(function () {
        $(".divloginResponsivo").click(function() {
          $(".modalConteiner").fadeIn();
        });
        $("#fechar").click(function() {
          $(".modalConteiner").fadeOut();
        });
      });
    </script>


  </head>
  <body>

    <?php chamaMenuOffCanvas(); ?>

    <header>
      <?php chamaCabecalho(); ?>
    </header>

    <figure id="slider">
      <img class="imgSlider" src="img/slider_1.png" alt="">
      <img class="imgSlider" src="img/imgSlider.jpg" alt="">
      <img class="imgSlider" src="img/156.jpg" alt="">

    </figure>
    <section id="conteudo">

      <?php modalLogin(); ?>
      <?php
        if (isset($_POST['rdoTipo'])) {
          $tipo = $_POST['rdoTipo'];
          if ($tipo == "juridico") {
            autenticarClienteJuridicoParaOSite();
          }elseif($tipo == "fisico"){
            autenticarClienteFisicoParaOSite();
          }
        }
      ?>

      <div class="TituloContainer">
          <p>Você não pode ficar sem:</p>
      </div>
      <div class="ContainerDasImagensConteudo">
        <!-- prod significa produto -->
  			<div class="prod imgs1">

          <div class="produto">
              <img class="imgProd prod1" src="img/img_1.png" alt="">
    			</div>

          <div class="produto ProdutoDireita banner_4">
              <img class="imgProd prod2" src="img/img_2.png" alt="">
    			</div>
  			</div>
        <div class="prod">
          <div class="produto">
              <img class="imgProd prod3" src="img/img_3.png" alt="">
          </div>
          <div class="produto ProdutoDireita banner_3">
              <img class="imgProd prod4" src="img/img_4.png" alt="">
    			</div>
          <div class="produto ProdutoDireita banner_4">
              <img class="imgProd prod5" src="img/img_5.png" alt="">
    			</div>
          <div class="produto banner_5">
              <img class="imgProd prod6" src="img/img_1.png" alt="">
    			</div>
        </div>

        </div>
      <div class="ContainerDasImagensConteudo2">
        <img class="imgProd img1" src="img/img_1.png" alt="">
        <img class="imgProd img2" src="img/img_2.png" alt="">
        <img class="imgProd img3" src="img/img_3.png" alt="">
        <img class="imgProd img4" src="img/img_4.png" alt="">
        <img class="imgProd img5" src="img/img_5.png" alt="">
        <img class="imgProd img6" src="img/img_1.png" alt="">
      </div>
      <div class="TituloContainer titulo_dois">
          <p>Recomendamos para você:</p>
      </div>

      <figure id="slider2">
        <img class="imgSlider2" src="img/img_1.png" alt="">
        <img class="imgSlider2" src="img/img_2.png" alt="">
        <img class="imgSlider2" src="img/img_5.png" alt="">
        <img class="imgSlider2" src="img/img_4.png" alt="">
        <img class="imgSlider2" src="img/item_bebida1.png" alt="">
      </figure>

    </section>
    <?php
      chamaRodape();
     ?>
    <script type="text/javascript" src="js/scrollToFixed.js"></script>
    <script type="text/javascript">
      $(".baixo").scrollToFixed();
    </script>
  </body>
</html>
