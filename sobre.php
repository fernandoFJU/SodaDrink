<?php

  require_once('funcoes/funcoes.php');
  conexao();

  $sql = "SELECT * FROM tblsobre;";

  $resultado = mysql_query($sql);

  $rs = mysql_fetch_array($resultado);

  $paragrafo1 = $rs['missao'];
  $paragrafo2 = $rs['visao'];
  $paragrafo3 = $rs['paragrafo'];
  $imagem = $rs['imagem'];
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sobre nós</title>
    <link rel="stylesheet" media="all" href="css/sobre.css">
<link rel="stylesheet" media="all" href="css/index.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/slick/slick.min.js"></script>
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

    <header id="header">
      <?php chamaCabecalho(); ?>
    </header>
    <section id="conteudo">

      <div id="titulo">
        <h1 id="txtSobre">Sobre a SodaDrink...</h1>
      </div>

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

      <div id="cima">
        <div class="esquerdo">
            <img class="imagem"src="imgSobre/<?php echo $imagem?>" alt="IMAGEM SOBRE">
        </div>
        <div class="direito">
          <h4 class="title">Nossa Missão:</h4>
          <p class="paragrafo"><?php echo $paragrafo1?>.</p>

          <h4 class="title visao">Nossa Visão:</h4>
          <p class="paragrafo"><?php echo $paragrafo2?>.</p>
        </div>
      </div>
      <div class="DivMaisSobreNos">
        <div class="DivTituloMaisSobreNos">
            <p id="TituloMaisSobre">Mais Sobre Nós...</p>
        </div>
        <div class="ConteudoMaisSobreNos">
        <p id="TextoSobre"><?php echo $paragrafo3; ?></p>
        </div>
      </div>

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
