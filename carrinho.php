<?php

  require_once('funcoes/funcoes.php');
  //chamada da função de conexão com o banco de dados
  conexao();
  session_start();
  $acao = "";
  $total = 0;
  $_SESSION['total2'] = 0;
  $_SESSION['totalItens'] = 0;
  //se não existir a sessão carrinho, criar-se-à:
  if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
  }
  if (isset($_GET['acao'])) {

    $acao = $_GET['acao'];

    switch ($acao) {
      case 'add':
        //verificar se o valor que vem do link é inteiro
        $id = intval($_GET['id']);

        //se não existir este produto no carrinho:
        if (!isset($_SESSION['carrinho'][$id])) {
          //este será adicionado uma vez no carrinho
          $_SESSION['carrinho'][$id] = 1;

        }else{
          //caso contrario este será adicionado mais uma vez
          $_SESSION['carrinho'][$id] += 1;
        }

        $_SESSION['totalItens'] = count($_SESSION['carrinho']);
        header("Location: carrinho.php");
        break;

      case 'del':
        //verificar se o valor que vem do link é inteiro
        $id = intval($_GET['id']);

        //se existir este produto no carrinho:
        if (isset($_SESSION['carrinho'][$id])) {
          //exclui a sessão carrinho cujo indice for o id
          unset($_SESSION['carrinho'][$id]);
        }

        $_SESSION['totalItens'] = count($_SESSION['carrinho']);
        header("Location: carrinho.php");
        break;

      case 'up':

        if (is_array($_POST['prod'])) {

          foreach ($_POST['prod'] as $id => $qtd) {

            $id = intval($id);
            $qtd = intval($qtd);
            if (!empty($qtd) || $qtd != 0) {
              $_SESSION['carrinho'][$id] = $qtd;
            }else{
              unset($_SESSION['carrinho'][$id]);
            }
          }
        }
        header("Location: carrinho.php");
        break;
    }
  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" media="all" href="css/carrinho.css">
    <link rel="stylesheet" media="all" href="css/index.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/logo.js"></script>
    <script type="text/javascript" src="js/menuOffCanvas.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
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

        <div id="titulo">
          <h1 id="txtCarrinho">Carrinho de Compras</h1>
          <p id="texto"><?php
  								if (isset($_SESSION['ClienteNome'])) {
  									echo $_SESSION['ClienteNome'];
  								}else{
  									echo "Cliente";
  								}
  							?>, seu carrinho possui <?php echo count($_SESSION['carrinho']); ?> iten(s).</p>
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


        <div id="itensConteiner">
          <form action="?acao=up" method="post">

            <?php
              if (count($_SESSION['carrinho']) <= 0) {

                echo '<p align="center" style="font-size:20px;">Não há produto no carrinho!!!</p>';

              }else{

                foreach ($_SESSION['carrinho'] as $id => $qtd):

                  $sql = "SELECT * FROM tblproduto WHERE id_produto = ".$id;
                  $select = mysql_query($sql);
                  $prod = mysql_fetch_assoc($select);

                  $nome = $prod['nome'];
                  $imagem = $prod['imagem'];
                  $valor = number_format($prod['valorVenda'], 2, ',', '.');

                  echo '<div class="item">
                          <div class="divImgProd">
                            <img class="imgProduto" src="CMS/'.$imagem.'" alt="why">
                          </div>
                          <div class="descProd">
                            <p class="txtNome">'.$nome.'</p>
                            <p class="txtQtd">Quantidade</p>
                            <input type="text" class="slcQtd" name="prod['.$id.']" value="'.$qtd.'" onblur="this.form.submit();"/>
                            <p class="txtPrecoItem">R$ '.$valor.'</p>
                            <a href="?acao=del&id='.$id.'">
                              <img class="imgDrop" src="img/drop.png" alt="Excluir item" title="Excluir item">
                            </a>
                          </div>
                        </div>';

                    $total += $prod['valorVenda']*$qtd;

                endforeach;
                $_SESSION['total2'] += $total;
              }
            ?>
          </form>
        </div>

        <div id="resumoConteiner">
          <a href="finalizar_compra.php">
            <div id="divTitulo">
              Prosseguir &#10097;
            </div>
          </a>

          <div id="txtResumo">
            Resumo do pedido
          </div>

          <div id="boxResumo">
            <div class="normal"class="normal">
              <?php echo count($_SESSION['carrinho']); ?> produto(s)
            </div>
            <div class="normal"class="normal">
              Frete Grátis
            </div>
            <div id="total">
              <p>TOTAL</p>
              <p id="txtTotal"><?php echo "R$ ".number_format($_SESSION['total2'], 2, ',', '.'); ?></p>
            </div>
            <div class="normal parcele">
              Parcele em até 10x sem juros no cartão
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
