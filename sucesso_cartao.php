<?php

  require_once('funcoes/funcoes.php');
  conexao();

  session_start();

  $sql = "SELECT p.id_pedido_venda,p.dtPedido, s.status, last_insert_id(p.id_pedido_venda) as ultimaVenda
          FROM tblpedidovenda AS p
          INNER JOIN tblstatus AS s
          ON p.id_status = s.id_status;";

  $select = mysql_query($sql);

  $venda = mysql_fetch_assoc($select);
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Compra finalizada</title>
    <link rel="stylesheet" media="all" href="css/sucesso.css">
    <link rel="stylesheet" media="all" href="css/index.css">
    <script type="text/javascript" src="js/jquery.js"></script>
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
    <section id="conteudo1">

      <?php modalLogin(); ?>
      <?php autenticarClienteJuridicoParaOSite("sucesso"); ?>

      <div id="sucesso">
        <div class="terminar">
          <img src="img/sucessIcon.png" class="imgSucesso" alt="">
          <h3>Seu pedido foi realizado com sucesso!</h3>
          <p class="texto">Em breve, você receberá um e-mail de confirmação com todas as informações da sua compra.</p>
          <p class="texto">O número do seu pedido é: <span id="numero"><?php echo $venda['id_pedido_venda'];?></span>.</p>

        </div>
        <div class="infoPedido">
          <div class="informacoesPed">
            <div id="txtInformacoes">
              Informações sobre o pedido
            </div>
            <div class="linhas">
              Situação:
              <?php
                $status = $venda['status'];
                if ($status == "Entregue") {
                  echo "<span id='sit' style='color: #009688'>$status</span>";
                }elseif($status == "Pendente") {
                  echo "<span id='sit' style='color: #ff0000'>$status</span>";
                }
            ?>

            </div>
            <div class="linhas">
              Data: <span id="data"><?php echo (date('d/m/Y', strtotime($venda['dtPedido'])));?></span>
            </div>
            <div class="linhas f">
              Forma de pagamento: <span id="forma">Cartão de crédito</span>
            </div>
          </div>
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
