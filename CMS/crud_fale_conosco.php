<?php
  session_start();
  require_once("funcoes/funcoes.php");
  conexao();

  $nomeDigitado = "";
  $tipoEscolhido = "";
  //se existir na URL a variavel excluir:
  if (isset($_GET["excluir"])) {
    //resgata a variavel que contem o id do comentario, chamada id
    $id = $_GET["id"];

    //script para apagar registros no banco de dados; para apagar um registro especifico usa-se where e um campo especifico de um registro. Neste caso será apagado o comentario cujo ID for igual ao id resgatado da URL
    $sql = "DELETE FROM tblfaleconosco WHERE id_fale_conosco = ".$id;

    $resultado = mysql_query($sql);
    if (! $resultado) {
      die("Erro ao excluir comentário!".mysql_error());
      exit();
    }else{
      echo "<script type'text/javascript'>
              alert('Comentário excluído com sucesso!');
              document.location.href = 'crud_fale_conosco.php';
            </script>";
    }

  }

  //aprovação
	if (isset($_GET['aprovar'])) {

		$aprovar = $_GET['aprovar'];
		$id = $_GET['id'];
    $pagina = "crud_fale_conosco.php";

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
  if (isset($_POST["btnPesquisa"])) {
    $nomeDigitado = $_POST["txtPesquisa"];
    $tipoEscolhido = $_POST["slcTipo"];
  }

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gerenciamento de Fale Conosco</title>
		<link rel="stylesheet" href="css/crud_fale_conosco.css">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>

    <script type="text/javascript">

      $(document).ready(function(){

        $('.imgInformacao').click(function() {
          $(".modalConteiner").fadeIn();
        });

      });

      function chamaModal(id_fale) {

        $.ajax({
          type: "POST",
          url: "modal_container_fale_conosco.php",
          data: {id_comentario:id_fale},
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
          <p id="txtPagina">Gerenciar críticas e sugestões</p>
        </div>
        <hr width="1070" size="1">

        <div class="filtros">

					<form action="crud_fale_conosco.php" method="POST">

						<div id="pesqNome">
							<p class="txtbusca">Nome</p>
							<input class="pesq" type="text" name="txtPesquisa" value="" placeholder="Buscar por Nome">
						</div>

						<div id="pesqTipo">
							<p class="txtbusca">Tipo</p>
							<select class="slcTipoPesq" name="slcTipo">
                <option value="">Selecione</option>
								<option value="c">Crítica</option>
								<option value="s">Sugestão</option>
							</select>
						</div>

						<input id="buscar" type="submit" name="btnPesquisa" value="Buscar">
					</form>
        </div>

        <div class="modalConteiner">

        </div>

        <div class="tabela">

          <div class="tblTitulo">
            Comentários dos clientes
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
            <div class="titulo opcoes">
              Opção
            </div>
          </div>

          <div class="contCampos">
            <?php
              //Variavel que recebe o script para selecionar todos os comentarios dos clientes, ordenando-os pelo ID de forma decrescente.
              $sql="SELECT * FROM tblfaleconosco
                    WHERE nome LIKE '%$nomeDigitado%'
                    AND tipo LIKE '%$tipoEscolhido%'
                    ORDER BY id_fale_conosco DESC;";
              //comando que executará este script, que será armazenado na variavel $select
              $select = mysql_query($sql);

              $cor = "";
              //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os dados de cada comentario guardado no banco e mostrá-los na tela:
              while ($rs = mysql_fetch_array($select))
              {
            ?>
                <div class="campos">
                  <div class="campo id">
                    <?php echo($rs['id_fale_conosco']); ?>
                  </div>
                  <div class="campo nome">
                    <?php echo utf8_encode($rs['nome']); ?>
                  </div>
                  <div class="campo tipo">
                    <?php
                      //Se o valor que retornar do campo tipo for C então mostrará Critica, caso contrario, mostrará Sugestão
                      if ($rs['tipo'] == "c") {
                        echo("Crítica");
                      }else {
                        echo ("Sugestão");
                      }
                    ?>
                  </div>
                  <div class="campo info">

                      <img src="img/informacoes.png" onclick="chamaModal(<?php echo $rs['id_fale_conosco'];?>);" class="imgInformacao" alt="Informacão" title="Mais informações do comentário">

                  </div>

                  <div class="campo apaga">
                    <a href="crud_fale_conosco.php?excluir&id=<?php echo($rs['id_fale_conosco']);?>">
                      <img src="img/apagar.png"  class="imgOpcao" alt="apagar" title="Excluir Comentário">
                    </a>
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
