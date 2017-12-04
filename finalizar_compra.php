<?php

  require_once('funcoes/funcoes.php');
  conexao();
  session_start();

  $formaPagamento = "";
  $cliente = 0;
  $valor = 0;

  if (isset($_POST['btnFinalizar'])) {

    $formaPagamento = $_POST["slcForma"];
    $cliente = $_SESSION['ClienteId'];
    $valor = $_SESSION['total2'];

    $sqlInserir = "INSERT INTO tblpedidovenda(id_forma_pagamento, id_cliente, dtPedido, valorTotal)
                   VALUES('".$formaPagamento."', ".$cliente.", curdate(), ".$valor.");";


    mysql_query($sqlInserir);

    $idDaUltimaVendaInserida = mysql_insert_id();

    foreach ($_SESSION['carrinho'] as $prod_insert => $quantidade) {

      $inserirItem = "INSERT INTO tblitenspedido(id_pedido, id_produto, quantidade)
                     VALUES(".$idDaUltimaVendaInserida.", ".$prod_insert.", ".$quantidade.");";
      mysql_query($inserirItem);
    }

    if ($formaPagamento == 1) {
      echo "<script type'text/javascript'>
              document.location.href = 'sucesso_cartao.php';
            </script>";
    }else{
      echo "<script type'text/javascript'>
              document.location.href = 'sucesso.php';
            </script>";
    }


  }
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Finalizando a compra</title>
    <link rel="stylesheet" media="all" href="css/finalizar_compra.css">
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

    <script type="text/javascript">
      $(document).ready(function() {

        $("#slcForma").change(function () {

					var valorSelect = $("#slcForma").val();

					if (valorSelect == "1") {
						$("#boleto").css("display", "none");
						$("#cartao").fadeIn(500);
            $("#inputNumero").prop('required',true);
            $("#inputTitular").prop('required',true);
					}else if(valorSelect == "2"){
						$("#cartao").css("display", "none");
						$("#boleto").fadeIn(500);
            $("#inputNumero").prop('required',false);
            $("#inputTitular").prop('required',false);


					}else {
						$("#cartao").fadeOut(1);
						$("#boleto").fadeOut(1);
					}

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
          <h1 id="txtTitulo">Finalizar a compra</h1>
          <p id="texto">Para finalizar sua compra, escolha a forma de pagamento desejada e clique em Finalizar.</p>

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
        <form class="" action="" method="post">
          <div id="conteinerForma">

            <div id="escolhaForma">
              <p id="txtForma">Forma de Pagamento</p>

              <select id="slcForma" name="slcForma">
                <option value="0">Selecione</option>
                <?php
    							//Variavel que recebe o script para selecionar as formas de pagamento cadastrados
    							$sql="SELECT * FROM tblformapagamento;";
    							//comando que executará este script, que será armazenado na variavel $select
    							$select = mysql_query($sql);

    							//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os formas de pagamento cadastrados no banco e mostrá-los na tela:
    							while ($rs = mysql_fetch_array($select))
    							{
    						?>

                    <option value="<?php echo $rs['id_forma_pagamento']?>"><?php echo $rs['formaPagamento']?></option>

                <?php
                  }
                ?>
              </select>
            </div>

            <div id="boxForma">
              <div id="cartao">
                <div id="imgCartoes">
    							<img class="cartao visa" src="img/visa.png" alt="">
    							<img class="cartao" src="img/master.png" alt="">
    							<img class="cartao" src="img/hiper.png" alt="">
    							<img class="cartao" src="img/amex.png" alt="">
                </div>

                <div class="dados">
                  <p>
                    <span id="txtParcela">Parcelas*</span>
                    <select class="slcParcelas" name="slcParcelas">
                      <?php
                        $cont = 1;

                        while ($cont <= 6) {

                          $parcela = $_SESSION['total2']/$cont;
                       ?>
                          <option value="<?php echo $cont;?>"><?php echo $cont." x R$ ".number_format($parcela, 2, ',', '.'); ?></option>
                      <?php
                          $cont++;
                        }
                      ?>
                    </select>
                  </p>
                  <p><span id="txtNumero">Número do cartão*</span> <input type="text" id="inputNumero" name="txtNumeroCartao" value=""></p>
                  <p><span id="txtTitular">Titular do cartão*</span> <input type="text" id="inputTitular" name="txtTitularCartao" value=""></p>
                  <p>
                    <span id="txtExpira">Expira*</span>
                    <select class="slcMes" name="slcMes">
                      <option value="0">Mês</option>
                      <option value="0">Janeiro</option>
                      <option value="1">Fevereiro</option>
                      <option value="3">Março</option>
                      <option value="4">Abril</option>
                      <option value="5">Maio</option>
                      <option value="6">Junho</option>
                      <option value="7">Julho</option>
                      <option value="8">Agosto</option>
                      <option value="9">Setembro</option>
                      <option value="10">Outubro</option>
                      <option value="11">Novembro</option>
                      <option value="12">Dezembro</option>

                    </select>
                    <select class="slcAno" name="slcAno">
                      <?php $cont = 2017;
                        while ($cont <= 2027) {
                          echo "<option value=".$cont.">".$cont."</option>";
                          $cont ++;
                        }
                        ?>

                    </select>
                  </p>
                </div>
              </div>

              <div id="boleto">
                <div id="imgBoleto">
    							<img class="boleto" src="img/boleto.png" alt="">
                </div>
                <div class="explicacao">
                  <ul>
                    <li>O pagamento via boleto oferece desconto de 5% na compra.</li>
                    <li>Imprima o Boleto Bancário após a confirmação do pedido.</li>
                    <li>A data de vencimento é de 5 dias corridos após o fechamento do pedido. Após esta data, ele será automaticamente cancelado.</li>
                    <li>Para pagar o Boleto pelo Internet Banking de seu banco, digite o código de barras.</li>
                    <li>Atenção: desative seu programa anti pop-up caso esteja ativado para que consiga finalizar sua compra com esta forma de pagamento.</li>
                  </ul>
                </div>
              </div>
            </div>

          </div>

          <div id="resumoConteiner">
            <input id="divTitulo" type="submit" name="btnFinalizar" value="Finalizar &#10097;">
            <div id="txtResumo">
              Resumo do pedido
            </div>

            <div id="boxResumo">
              <div class="normal"class="normal">
                <?php echo count($_SESSION['carrinho']); ?> produtos
              </div>
              <div class="normal"class="normal">
                Frete Grátis
              </div>
              <div id="total">
                <p>TOTAL</p>
                <p id="txtTotal"><?php echo "R$ ".number_format($_SESSION['total2'], 2, ',', '.'); ?></p>
              </div>
              <div class="normal parcele">
                Parcele em até 6x sem juros no cartão
              </div>
            </div>

          </div>
        </form>

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
