<?php

  require_once('funcoes/funcoes.php');
  conexao();
  session_start();
  $palavraPesquisada = "";
  if (isset($_POST['btnPesquisa'])) {
    $palavraPesquisada = $_POST['txtPesquisa'];
  }
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nossas bebidas</title>
    <link rel="stylesheet" href="css/bebidas.css"  media="all">
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
    <section >
      <div id="conteudo1">
	<div id="titulo">
        <h1 id="txtBebidas">Bebidas</h1>
        <form class="frmPesq" action="" method="post">
          <input type="text" name="txtPesquisa" value="" id="pesquisa" placeholder="Pesquise sua bebida favorita..." maxlength="50px;">
          <input type="submit" id="btnPesquisa" name="btnPesquisa" value="Pesquisar">
        </form>
        <?php
          if (isset($palavraPesquisada)) {
            if ($palavraPesquisada == "") {
              echo "";
            }else {
              echo "<p id='resultPesquisa'>Resultado da pesquisa: $palavraPesquisada</p>";
            }
          }
         ?>

      </div>
      <div id="tituloResponsivo">
        <h1 id="txtBebidas">Bebidas</h1>
        <form class="frmPesq" action="" method="post">
          <input type="text" name="txtPesquisa" value="" id="pesquisa" placeholder="Pesquise sua bebida favorita..." maxlength="50px;">
          <input type="submit" id="btnPesquisa" name="btnPesquisa" value="Pesquisar">
        </form>
        <?php
          if (isset($palavraPesquisada)) {
            if ($palavraPesquisada == "") {
              echo "";
            }else {
              echo "<p id='resultPesquisa'>Resultados da pesquisa: <b>$palavraPesquisada</b></p>";
            }
          }
         ?>

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

      <nav id="menuFiltro">
        <div id="txtMarca">
          <p>Marca</p>
        </div>
        <?php
          //Variavel que recebe o script para selecionar todas as marcas cadastradas.
          $sql="SELECT * FROM tblmarca WHERE aprovado = 1  ORDER BY marca ASC;";
          //comando que executará este script, que será armazenado na variavel $select
          $select = mysql_query($sql);

          //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as marcas cadastrados no banco e mostrá-los na tela:
          while ($rs = mysql_fetch_array($select))
          {
        ?>
            <a href="bebidas.php?marca=<?php echo $rs['id_marca']; ?>">
              <div class="marca">
                <p><?php echo utf8_encode($rs['marca']); ?></p>
              </div>
            </a>
        <?php
          }
         ?>

        <div id="txtCategoria">
          <p>Categoria</p>
        </div>
        <?php
          //Variavel que recebe o script para selecionar todas as categorias cadastradas.
          $sql="SELECT * FROM tblcategoria WHERE aprovado = 1 ORDER BY descricao ASC;";
          //comando que executará este script, que será armazenado na variavel $select
          $select = mysql_query($sql);

          //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as categorias cadastrados no banco e mostrá-los na tela:
          while ($rs = mysql_fetch_array($select))
          {
        ?>
          <a href="bebidas.php?categoria=<?php echo $rs['id_categoria']; ?>">
            <div class="categoria">
              <p><?php echo utf8_encode($rs['descricao']); ?></p>
            </div>
          </a>
        <?php
          }
         ?>
      </nav>

      <div class="produtoConteiner">
        <?php

          //caso o cliente não escolha um produto pela marca ou categoria trará todos
          if(! isset($_GET['marca']) && ! isset($_GET['categoria'])){

            //Variavel que recebe o script para selecionar todos os produtos cadastradas.
            $sql="SELECT p.*, c.descricao, m.marca FROM
                  tblproduto AS p INNER JOIN tblcategoria AS c
                  ON p.id_categoria = c.id_categoria
                  INNER JOIN tblmarca as m
                  ON p.id_marca = m.id_marca
                  WHERE p.aprovado = 1
                  AND p.nome LIKE '%$palavraPesquisada%'
                  AND p.imagem <> ''
                  ORDER BY rand()
                  LIMIT 6;";
            //comando que executará este script, que será armazenado na variavel $select
            $select = mysql_query($sql);

            //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os produtos cadastrados no banco e mostrá-los na tela:
            while ($rs = mysql_fetch_array($select))
            {
          ?>
              <div class="produto1">
                <div class="contImg">
                  <img src="CMS/<?php echo $rs['imagem']; ?>" class="imgProduto" alt="">
                </div>
                <div class="contInfo">
                  <p id="txtNomeProd"><?php echo utf8_encode($rs['nome']); ?></p>
                  <p id="txtMarcaProd"><?php echo utf8_encode($rs['marca']); ?></p>
                  <p id="txtCategoriaProd"><?php echo utf8_encode($rs['descricao']); ?></p>
                  <?php
                    if (isset($_SESSION['ClienteNome'])) {
                      echo "<p id='txtPreco'>R$ ".number_format($rs['valorVenda'], 2, ',', '.')."</p>";
                    }else{
                      echo "<p id='txtPreco'>&nbsp</p>";
                    }
                   ?>
                   <?php
                     if (isset($_SESSION['ClienteNome'])) {
                    ?>
                      <a href="comprar_produto.php?produto=<?php echo $rs['id_produto']; ?>">
                        <div id="boxDetalhe">
                          <p id="txtDetalhes">Comprar</p>
                        </div>
                      </a>
                    <?php
                     }else{
                    ?>
                      <a href="detalhes.php?produto=<?php echo $rs['id_produto']; ?>">
                        <div id="boxDetalhe">
                          <p id="txtDetalhes">Detalhes</p>
                        </div>
                      </a>
                    <?php
                     }
                    ?>

                </div>
              </div>
          <?php
            }
            //senão, caso escolha pela marca trará todos daquela marca
          }elseif(isset($_GET['marca'])){
            $marca = $_GET['marca'];
            //Variavel que recebe o script para selecionar todos os produtos cadastradas.
            $sql="SELECT p.*, c.descricao, m.marca FROM
                  tblproduto AS p INNER JOIN tblcategoria AS c
                  ON p.id_categoria = c.id_categoria
                  INNER JOIN tblmarca as m
                  ON p.id_marca = m.id_marca
                  WHERE p.id_marca = ".$marca."
                  AND p.aprovado = 1
                  AND p.imagem <> ''
                  ORDER BY rand()
                  LIMIT 6;";
            //comando que executará este script, que será armazenado na variavel $select
            $select = mysql_query($sql);

            //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os produtos cadastrados no banco e mostrá-los na tela:
            while ($rs = mysql_fetch_array($select))
            {
          ?>
              <div class="produto1">
                <div class="contImg">
                  <img src="CMS/<?php echo $rs['imagem']; ?>" class="imgProduto" alt="">
                </div>
                <div class="contInfo">
                  <p id="txtNomeProd"><?php echo utf8_encode($rs['nome']); ?></p>
                  <p id="txtMarcaProd"><?php echo utf8_encode($rs['marca']); ?></p>
                  <p id="txtCategoriaProd"><?php echo utf8_encode($rs['descricao']); ?></p>
                  <?php
                    if (isset($_SESSION['ClienteNome'])) {
                      echo "<p id='txtPreco'>R$ ".number_format($rs['valorVenda'], 2, ',', '.')."</p>";
                    }else{
                      echo "<p id='txtPreco'>&nbsp</p>";
                    }
                   ?>
                   <?php
                     if (isset($_SESSION['ClienteNome'])) {
                    ?>
                      <a href="comprar_produto.php?produto=<?php echo $rs['id_produto']; ?>">
                        <div id="boxDetalhe">
                          <p id="txtDetalhes">Comprar</p>
                        </div>
                      </a>
                    <?php
                     }else{
                    ?>
                    <a href="detalhes.php?produto=<?php echo $rs['id_produto']; ?>">
                      <div id="boxDetalhe">
                        <p id="txtDetalhes">Detalhes</p>
                      </div>
                    </a>
                    <?php
                     }
                    ?>
                </div>
              </div>
          <?php
            }
            //senão, caso escolha pela categoria trará todos daquela categoria
          }elseif(isset($_GET['categoria'])){
            $categoria = $_GET['categoria'];
            //Variavel que recebe o script para selecionar todos os produtos cadastradas.
            $sql="SELECT p.*, c.descricao, m.marca FROM
                  tblproduto AS p INNER JOIN tblcategoria AS c
                  ON p.id_categoria = c.id_categoria
                  INNER JOIN tblmarca as m
                  ON p.id_marca = m.id_marca
                  WHERE p.id_categoria = ".$categoria."
                  AND p.aprovado = 1
                  AND p.imagem <> ''
                  ORDER BY rand()
                  LIMIT 6;";
            //comando que executará este script, que será armazenado na variavel $select
            $select = mysql_query($sql);

            //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os produtos cadastrados no banco e mostrá-los na tela:
            while ($rs = mysql_fetch_array($select))
            {
          ?>
              <div class="produto1">
                <div class="contImg">
                  <img src="CMS/<?php echo $rs['imagem']; ?>" class="imgProduto" alt="">
                </div>
                <div class="contInfo">
                  <p id="txtNomeProd"><?php echo utf8_encode($rs['nome']); ?></p>
                  <p id="txtMarcaProd"><?php echo utf8_encode($rs['marca']); ?></p>
                  <p id="txtCategoriaProd"><?php echo utf8_encode($rs['descricao']); ?></p>
                  <?php
                    if (isset($_SESSION['ClienteNome'])) {
                      echo "<p id='txtPreco'>R$ ".number_format($rs['valorVenda'], 2, ',', '.')."</p>";
                    }else{
                      echo "<p id='txtPreco'>&nbsp</p>";
                    }
                   ?>
                   <?php
                     if (isset($_SESSION['ClienteNome'])) {
                    ?>
                      <a href="comprar_produto.php?produto=<?php echo $rs['id_produto']; ?>">
                        <div id="boxDetalhe">
                          <p id="txtDetalhes">Comprar</p>
                        </div>
                      </a>
                    <?php
                     }else{
                    ?>
                    <a href="detalhes.php?produto=<?php echo $rs['id_produto']; ?>">
                      <div id="boxDetalhe">
                        <p id="txtDetalhes">Detalhes</p>
                      </div>
                    </a>
                    <?php
                     }
                    ?>
                </div>
              </div>
          <?php
            }
          }
          ?>
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
