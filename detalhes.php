<?php

  require_once('funcoes/funcoes.php');
  conexao();
  session_start();

  $nome = "";
  $categoria = "";
  $peso = "";
  $marca = "";
  $preco = null;
  $desconto= null;
  $descontoNoBoleto = null;
  $precoComDescontoParaOBoleto = null;
  $valorSemDesconto = null;
  $qtdNoEngradado = null;

  if (isset($_GET['produto'])) {

    $id = $_GET['produto'];

    $sql= "SELECT p.*, c.descricao, m.marca FROM tblproduto as p
           INNER JOIN tblcategoria AS c
           ON p.id_categoria = c.id_categoria
           INNER JOIN tblmarca AS m
           ON p.id_marca = m.id_marca
           WHERE id_produto = ".$id;
    $select = mysql_query($sql);

    $rs = mysql_fetch_array($select);

    $id_produto = $rs['id_produto'];
    $nome = $rs['nome'];
    $categoria = $rs['descricao'];
    $peso = $rs['peso'];
    $porcDesconto = $rs['porcDesconto'];
    $marca = $rs['marca'];
    $valorSemDesconto = $rs['valorVenda'];
    $qtdNoEngradado = $rs['quantidadeEngradado'];
    $desconto = ($porcDesconto /100) * $valorSemDesconto;
    $preco = $valorSemDesconto - $desconto;
    $descontoNoBoleto = (5/100) * $preco;
    $precoComDescontoParaOBoleto = $preco - $descontoNoBoleto;

  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Comprar produto</title>
    <link rel="stylesheet" href="css/detalhes.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="js/slick/slick.css"/>
  	<link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css"/>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/slick/slick.min.js"></script>
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

      <div class="imgProd">
        <img src="CMS/<?php echo $rs['imagem']; ?>" id="imgProd" alt="">
      </div>

      <?php modalLogin(); ?>
      <?php autenticarClienteJuridicoParaOSite("comprar_produto"); ?>

      <div class="informacoesProd">

        <div class="nome">
          <p id="nomeProd"><?php echo $nome; ?></p>
          <hr style="margin-top:3px;" size="1">
          <p id="txtOutros">Outros produtos: <a href="bebidas.php?marca=<?php echo $rs['id_marca']; ?>"><?php echo $marca; ?></a></p>
          <p id="txtCodigo">Código do produto: <?php echo $id_produto; ?></p>
        </div>

        <div class="caracteristicas">

          <p class="comum n"><?php echo $nome; ?></p>
          <p class="comum"><b>Categoria:</b> <?php echo $categoria; ?></p>
          <p class="comum"><b>Marca:</b> <?php echo $marca; ?></p>
          <p class="contemDet">Contém:</p>
          <p class="comum dois">Engradado com: <?php echo $qtdNoEngradado; ?> unidade(s)</p>
          <p class="contemDet">Detalhes:</p>
          <p class="comum dois"><b>Peso:</b> <?php echo number_format(($peso), 0, ',', ' '); ?> Kg</p>

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
