<?php

  require_once('funcoes/funcoes.php');
  session_start();
  conexao();
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Promoções</title>
    <link rel="stylesheet" href="css/promocoes.css" media="all">
    <link rel="stylesheet" media="all" href="css/index.css">

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
    <section id="conteudo">


      <div class="titulo">
				<p id="txtPromocao">Promoções SodaDrink</p>
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

      <div class="conteinerPromocao">

        <?php
          //Variavel que recebe o script para selecionar todos as promoções cadastradas.
          $sql="SELECT * FROM tblpromocao WHERE aprovado = 1 LIMIT 2;";
          //comando que executará este script, que será armazenado na variavel $select
          $select = mysql_query($sql);

          //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as promoções cadastrados no banco e mostrá-los na tela:
          while ($rs = mysql_fetch_array($select))
          {
        ?>

            <div class="promocao">

              <p id="txtDescricao"><?php echo utf8_encode($rs['descricao']); ?></p>

              <div class="descricao">

                <img src="CMS/<?php echo $rs['imagem']; ?>" class="imgPromocao" alt="Imagem da Promoção">

                <div class="passos">
                  <p class="txtPasso"><span class="passo">1º Passo: </span> <?php echo utf8_encode($rs['passo1']); ?></p>
                  <p class="txtPasso"><span class="passo">2º Passo: </span> <?php echo utf8_encode($rs['passo2']); ?></p>
                  <p class="txtPasso"><span class="passo">3º Passo: </span> <?php echo utf8_encode($rs['passo3']); ?></p>

                  <div class="participar">
                    Participar
                  </div>

                  <p id="validade">Promoção válida até <?php echo $rs['validade']; ?>.</p>
                </div>

              </div>

            </div>
        <?php
          }
         ?>
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
