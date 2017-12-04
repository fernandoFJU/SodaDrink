<?php
	session_start();
	require_once ("funcoes/funcoes.php");
	conexao();

	$nomeDigitado = "";
	$statusEscolhido = "";
	$formaEscolhida = "";

	//aprovação
	if (isset($_GET['aprovar'])) {

		$aprovar = $_GET['aprovar'];
		$id = $_GET['id'];
    $pagina = "pedido.php";

		switch ($aprovar) {
			case 'produto':
				$sql = "UPDATE tblproduto SET aprovado = 1 WHERE id_produto = ".$id;

				if (! mysql_query($sql)) {
		      die("Erro ao aprovar!".mysql_error());
		      exit();
		    }else{
		      echo "<script type'text/javascript'>
		              alert('Produto aprovado');
									document.location.href = '$pagina';
		            </script>";
		    }
			break;
			case 'categoria':
				$sql = "UPDATE tblcategoria SET aprovado = 1 WHERE id_categoria = ".$id;

				if (! mysql_query($sql)) {
					die("Erro ao aprovar!".mysql_error());
					exit();
				}else{
					echo "<script type'text/javascript'>
									alert('Categoria aprovada');
									document.location.href = '$pagina';
								</script>";
				}
			break;
			case 'marca':
				$sql = "UPDATE tblmarca SET aprovado = 1 WHERE id_marca = ".$id;

				if (! mysql_query($sql)) {
					die("Erro ao aprovar!".mysql_error());
					exit();
				}else{
					echo "<script type'text/javascript'>
									alert('Marca aprovada');
									document.location.href = '$pagina';
								</script>";
				}
			break;
			case 'promocao':
				$sql = "UPDATE tblpromocao SET aprovado = 1 WHERE id_promocao = ".$id;

				if (! mysql_query($sql)) {
					die("Erro ao aprovar!".mysql_error());
					exit();
				}else{
					echo "<script type'text/javascript'>
									alert('Promoção aprovada');
									document.location.href = '$pagina';
								</script>";
				}
			break;
		}
	}

	//busca
	if (isset($_POST['btnBuscar'])) {

		$nomeDigitado = $_POST['txtNomeCliente'];
		$statusEscolhido = $_POST['slcStatus'];
		$formaEscolhida = $_POST['slcForma'];

	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Acompanhamento dos pedidos</title>
		<link rel="stylesheet" href="css/pedido.css">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>

		<script type="text/javascript">
      $(function(){
        $('#grafico').click(function () {
          $('.modalConteiner').fadeIn();
        });
        $('#fechar').click(function () {
          $('.modalConteiner').fadeOut();
        });
				$(document).keyup(function(e) {
		      if (e.keyCode == 27) {
		        $(".modalConteiner").fadeOut();
		      }

		    });

      });
    </script>
	</head>
	<body>

		<header class="cabecalho">
			<?php
				chamaCabecalhoCms();
			 ?>
		</header>

		<section class="conteudoConteiner">

				<?php
					chamaMenu();
				 ?>

			<div class=conteudo>

        <div class="pagina">
          <p id="txtPagina">Pedidos Registrados</p>
        </div>
        <hr width="1070" size="1">

        <div class="filtros">
					<form action="" method="post">

						<div id="pesqDe">
							<p class="texto">De</p>
							<input class="pesq" type="date" name="" value="">
						</div>
						<div id="pesqAte">
							<p class="texto">Até</p>
							<input class="pesq" type="date" name="" value="">
						</div>

						<div id="pesqCliente">
							<p class="texto">Nome do Cliente</p>
							<input class="pesq nome" type="text" name="txtNomeCliente" value="">
						</div>

						<div id="pesqStatus">
							<p class="texto">Status</p>
							<select class="slcStatusPesq" name="slcStatus">
								<option value="">Selecione</option>
								<?php
									//Variavel que recebe o script para selecionar todos os status.
									$status = "SELECT * FROM tblstatus where status != 'Entregue' ORDER BY status ASC;";

									//comando que executará este script, que será armazenado na variavel $select
									$select = mysql_query($status);

									//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os status guardadas no banco e mostrá-los no select:
									while ($rs = mysql_fetch_array($select)) {
								?>
										<option value="<?php echo($rs["status"]); ?>"><?php echo($rs["status"]); ?></option>
								<?php
									}
								 ?>
							</select>
						</div>

						<div id="pesqForma">
							<p class="texto">Forma de pagamento</p>
							<select class="slcFormaPesq" name="slcForma">
								<option value="">Selecione</option>

								<?php
									//Variavel que recebe o script para selecionar todas as marcas.
									$formaPagamento = "SELECT * FROM tblformapagamento;";

									//comando que executará este script, que será armazenado na variavel $select
									$select = mysql_query($formaPagamento);

									//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $estados numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as formas de pagamento guardadas no banco e mostrá-las no select:
									while ($rs = mysql_fetch_array($select)) {
								?>
										<option value="<?php echo($rs['formaPagamento']); ?>"><?php echo($rs["formaPagamento"]); ?></option>
								<?php
									}
								 ?>
							</select>
						</div>

						<input id="buscar" type="submit" name="btnBuscar" value="Buscar">
					</form>
        </div>

        <div class="tabela">

          <div class="tblTitulo">
            Vendas Registradas
          </div>

          <div class="contTitulos">
            <div class="titulo id">
              ID
            </div>
            <div class="titulo data">
              Dt. Pedido
            </div>
            <div class="titulo cliente">
              Cliente
            </div>
            <div class="titulo pagamento">
              Pagamento
            </div>
						<div class="titulo total">
              Total
            </div>
						<div class="titulo status">
              Status
            </div>
          </div>

          <div class="contCampos">
						<?php
							//Variavel que recebe o script para selecionar todos os usuários cadastrados, ordenando-os pelo ID de forma decrescente.
							$sql="SELECT p.*, f.formaPagamento, c.nomeFantasia, s.status FROM
										tblpedidovenda AS p INNER JOIN tblformapagamento AS f
										ON p.id_forma_pagamento = f.id_forma_pagamento
										INNER JOIN tblclientejuridico as c
										ON p.id_cliente = c.id_cliente
										INNER JOIN tblstatus as s
										ON p.id_status = s.id_status
										WHERE c.nomeFantasia LIKE '%$nomeDigitado%'
										AND f.formaPagamento LIKE'%$formaEscolhida%'
										AND s.status LIKE'%$statusEscolhido%'
										AND s.status != 'Entregue'
										ORDER BY p.dtPedido DESC;";
							//comando que executará este script, que será armazenado na variavel $select
							$select = mysql_query($sql);

							$cor = "";
							//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os dados de cada usuário cadastrado no banco e mostrá-los na tela:
							while ($rs = mysql_fetch_array($select))
							{
						?>
		            <div class="campos">
		              <div class="campo id">
		                <?php echo $rs['id_pedido_venda']; ?>
		              </div>
		              <div class="campo data">
		                <?php echo (date('d/m/Y', strtotime($rs['dtPedido'])));?>
		              </div>
		              <div class="campo cliente">
		                <?php echo utf8_encode($rs['nomeFantasia']); ?>
		              </div>
		              <div class="campo pagamento">
		                <?php echo utf8_encode($rs['formaPagamento']); ?>
		              </div>
									<div class="campo total">
		                <?php echo ("R$ ".number_format(($rs['valorTotal']), 2, ',', ' ')); ?>
		              </div>
									<div class="campo status">
		                <?php echo $rs['status']; ?>
		              </div>

								</div>
							<?php
							}
							 ?>

          </div>
        </div>

			</div>

			<?php
				chamaAprovacao();
			?>

		</section>

		<footer>
			<p>Developed by TechSolutions</p>
		</footer>

		<script type="text/javascript">

		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
		  acc[i].onclick = function() {
		    this.classList.toggle("active");
		    var panel = this.nextElementSibling;
		    if (panel.style.maxHeight){
		      panel.style.maxHeight = null;
		    } else {
		      panel.style.maxHeight = panel.scrollHeight + "px";
		    }
		  }
		}
		</script>

	</body>
</html>
