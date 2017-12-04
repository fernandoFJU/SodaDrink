<?php

  require_once('funcoes/funcoes.php');
  conexao();
  session_start();
  $marca = 0;
  if (isset($_GET["marca"])) {
    $marca = $_GET["marca"];
  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Localize nossas bebidas</title>

    <link rel="stylesheet" media="all" href="css/onde_comprar.css">
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
        <h1 id="txtLocalize">Localize nossas bebidas</h1>
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

      <nav id="menuMarcas">
        <?php
          //Variavel que recebe o script para selecionar todas as marcas cadastradas.
          $sql="SELECT * FROM tblmarca ORDER BY marca ASC;";
          //comando que executará este script, que será armazenado na variavel $select
          $select = mysql_query($sql);

          //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as marcas cadastrados no banco e mostrá-los na tela:
          while ($rs = mysql_fetch_array($select))
          {
        ?>
            <div class="marca">
              <a href="?marca=<?php echo $rs['id_marca']; ?>">
                <p><?php echo $rs['marca']; ?></p>
              </a>
            </div>
        <?php
          }
         ?>
      </nav>

      <div class="lojasConteiner">

        <?php

          //Variavel que recebe o script para selecionar todas as marcas cadastradas.
          $sql="SELECT cliente.nomeFantasia, cliente.imagem, cliente.email, cliente.telefone,
                cliente.cep,pedido.id_pedido_venda, p.nome, m.marca
                FROM tblclientejuridico as cliente
                inner join tblpedidovenda as pedido
                on cliente.id_cliente = pedido.id_cliente
                inner join tblitenspedido as ip
                on pedido.id_pedido_venda = ip.id_pedido
                inner join tblproduto as p
                on ip.id_produto = p.id_produto
                inner join tblmarca as m
                on m.id_marca = p.id_marca
                where m.id_marca = ".$marca."
                group by cliente.nomeFantasia";
          //comando que executará este script, que será armazenado na variavel $select
          $select = mysql_query($sql);

          if ($marca == 0) {
            echo "<p class='selecione'>
                    Selecione uma marca e veja onde pode encontrar suas bebidas!!!
                  </p>";
          }else {

            //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as marcas cadastrados no banco e mostrá-los na tela:
            while ($rs = mysql_fetch_array($select))
            {
          ?>

              <div class="loja1">
                <div class="contImg">
                  <img src="<?php echo $rs['imagem']; ?>" class="imgLoja" alt="">
                </div>
                <div class="contInfo">
                  <p id="txtNomeEmpresa"><?php echo $rs['nomeFantasia']; ?></p>
                  <p id="txtEmailEmpresa"><span>Email:</span> <?php echo $rs['email']; ?></p>
                  <p id="txtTelEmpresa"><span>Tel.:</span> <?php echo $rs['telefone']; ?></p>
                  <p id="txtLocalizaEmpresa"><span>Cep:</span> <?php echo $rs['cep']; ?></p>
                  <a href="#">
                    <div id="boxAcessar">
                      <p id="txtAcessar">Acessar</p>
                    </div>
                  </a>
                </div>
              </div>
          <?php
            }
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
