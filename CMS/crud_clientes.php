<?php
  session_start();
  require_once("funcoes/funcoes.php");
  conexao();

  //aprovação
	if (isset($_GET['aprovar'])) {

		$aprovar = $_GET['aprovar'];
		$id = $_GET['id'];
    $pagina = "crud_clientes.php";

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
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nossos clientes</title>
		<link rel="stylesheet" href="css/crud_clientes.css">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>

    <script type="text/javascript">

      $(document).ready(function(){

        $('.imgInformacao').click(function() {
          $(".modalConteiner").fadeIn();
        });

      });

      function chamaModalFisico(id_cliente_fisico) {

        $.ajax({
          type: "POST",
          url: "modal_container_cliente_fis.php",
          data: {id_cliente_fisico:id_cliente_fisico},
          success: function(data2) {
            $('.modalConteiner').html(data2);
          }
        });

      }

      function chamaModalJuridico(id_cliente_juridico) {

        $.ajax({
          type: "POST",
          url: "modal_container_cliente_jur.php",
          data: {id_cliente_juridico:id_cliente_juridico},
          success: function(data2) {
            $('.modalConteiner').html(data2);
          }
        });
      }
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
          <p id="txtPagina">Nossos Clientes</p>
        </div>
        <hr width="1070" size="1">

        <div class="filtros">

					<form action="crud_clientes.php" method="get">

						<div id="pesqNome">
							<p class="txtbusca">Nome</p>
							<input class="pesq" type="text" name="" value="" placeholder="Buscar por Nome">
						</div>

						<div id="pesqTipo">
							<p class="txtbusca">Tipo</p>
							<select class="slcTipoPesq" name="slcTipo">
								<option value="0">Jurídico</option>
								<option value="0">Físico</option>
							</select>
						</div>

						<input id="buscar" type="submit" name="" value="Buscar">
					</form>
        </div>

        <div class="modalConteiner">

        </div>

        <div class="tabela">

          <div class="tblTitulo">
            Clientes cadastrados
          </div>

          <div class="contTitulos">
            <div class="titulo id">
              ID
            </div>
            <div class="titulo nome">
              Nome
            </div>
            <div class="titulo tipo">
              Tipo
            </div>
            <div class="titulo info">
              Informações
            </div>
          </div>

          <div class="contCampos">
            <?php
              //Variavel que recebe o script para selecionar todos os comentarios dos clientes, ordenando-os pelo ID de forma decrescente.
              $sql="SELECT * FROM tblclientefisico;";
              //comando que executará este script, que será armazenado na variavel $select
              $select = mysql_query($sql);

              $cor = "";
              //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os dados de cada comentario guardado no banco e mostrá-los na tela:
              while ($rs = mysql_fetch_array($select))
              {
            ?>
                <div class="campos">
                  <div class="campo id">
                    <?php echo($rs['id_cliente']); ?>
                  </div>
                  <div class="campo nome">
                    <?php echo(utf8_encode($rs['nome'])); ?>
                  </div>
                  <div class="campo tipo">
                    Físico
                  </div>
                  <div class="campo info">

                    <img src="img/informacoes.png" onclick="chamaModalFisico(<?php echo $rs['id_cliente'];?>);" class="imgInformacao" alt="Informacão" title="Mais informações do comentário">

                  </div>
                </div>

                <?php
              }
                ?>

                <?php
                  //Variavel que recebe o script para selecionar todos os comentarios dos clientes, ordenando-os pelo ID de forma decrescente.
                  $sql="SELECT * FROM tblclientejuridico;";
                  //comando que executará este script, que será armazenado na variavel $select
                  $select = mysql_query($sql);

                  $cor = "";
                  //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os dados de cada comentario guardado no banco e mostrá-los na tela:
                  while ($rs = mysql_fetch_array($select))
                  {
                ?>
                    <div class="campos">
                      <div class="campo id">
                        <?php echo($rs['id_cliente']); ?>
                      </div>
                      <div class="campo nome">
                        <?php echo($rs['razaoSocial']); ?>
                      </div>
                      <div class="campo tipo">
                        Jurídico
                      </div>
                      <div class="campo info">

                        <img src="img/informacoes.png" onclick="chamaModalJuridico(<?php echo $rs['id_cliente'];?>);" class="imgInformacao" alt="Informacão" title="Mais informações do comentário">

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
