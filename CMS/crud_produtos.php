<?php
	session_start();
	require_once ("funcoes/funcoes.php");
	conexao();

	$descricaoDigitada = "";
	$catEscolhida = "";
	$marcaEscolhida = "";
	//se existir na URL a variavel modo:
	if (isset($_GET["modo"])) {

		//guarda o conteudo da variavel modo numa variavel local
		$modo = $_GET["modo"];

		//se o modo for excluir:
		if ($modo == "excluir") {

	    //resgata a variavel que contem o id do produto, chamada id
	    $id = $_GET["id"];

	    //script para apagar registros no banco de dados; para apagar um registro especifico usa-se where e um campo especifico de um registro.
			//Neste caso será apagado o produto cujo ID for igual ao id resgatado da URL
	    $sql = "DELETE FROM tblproduto WHERE id_produto = ".$id;

	  	$resultado = mysql_query($sql);
	    if (! $resultado) {
	      die("Erro ao excluir Produto!".mysql_error());
	      exit();
	    }else{
	      echo "<script type'text/javascript'>
	              alert('Produto excluído com sucesso!');
	              document.location.href = 'crud_produtos.php';
	            </script>";
	    }
		}
	}

	//aprovação
	if (isset($_GET['aprovar'])) {

		$aprovar = $_GET['aprovar'];
		$id = $_GET['id'];
    $pagina = "crud_produtos.php";

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
		$descricaoDigitada = $_POST['txtDescricaoPesq'];
		$catEscolhida = $_POST['slcCatPesq'];
		$marcaEscolhida = $_POST['slcMarcaPesq'];

	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gerenciamento de Produtos</title>
		<link rel="stylesheet" href="css/crud_produtos.css">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
		<script type="text/javascript" src="js/tablesorter.js"></script>


		<script type="text/javascript">
			$(document).ready(function() {
				$("#file").change(function () {
					$(this).siblings("#spanNome").text("");
					$(this).siblings("#spanNome").text($(this).val());

				});
				$("#file").hover(
					function() {
						$(this).siblings("img").attr("src", "img/camera2.png");
						$(this).css("cursor", "pointer");
					},
					function () {
						$(this).siblings("img").attr("src", "img/camera.png");
				});



			});

			function readURL(input, id) {
      	if (input.files && input.files[0]) {

					var reader = new FileReader();
					reader.onload = function (e) {
						$('#'+id).attr('src', e.target.result);
					}

					reader.readAsDataURL(input.files[0]);
        }
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
          <p id="txtPagina">Gerenciamento de Produtos</p>
        </div>
        <hr width="1070" size="1">

        <div class="filtros">
					<form action="crud_produtos.php" method="post">

						<div id="pesqDesc">
							<p class="texto">Descrição</p>
							<input class="pesq" type="text" name="txtDescricaoPesq" value="" placeholder="Buscar pela descrição">
						</div>

						<div id="pesqCat">
							<p class="texto">Categoria</p>
							<select class="slcCatPesq" name="slcCatPesq">
								<option value="">Selecione</option>
								<?php
									//Variavel que recebe o script para selecionar todas as categorias.
									$categorias = "SELECT * FROM tblcategoria ORDER BY descricao ASC;";

									//comando que executará este script, que será armazenado na variavel $categorias
									$select = mysql_query($categorias);

									//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $estados numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as categorias guardadas no banco e mostrá-las no select:
									while ($rs = mysql_fetch_array($select)) {
								?>
										<option value="<?php echo($rs["descricao"]); ?>"><?php echo($rs["descricao"]); ?></option>
								<?php
									}
								 ?>
							</select>
						</div>

						<div id="pesqMarca">
							<p class="texto">Marca</p>
							<select class="slcMarcaPesq" name="slcMarcaPesq">
								<option value="">Selecione</option>
								<?php
									//Variavel que recebe o script para selecionar todas as marcas.
									$marcas = "SELECT * FROM tblmarca ORDER BY marca ASC;";

									//comando que executará este script, que será armazenado na variavel $marcas
									$select = mysql_query($marcas);

									//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $estados numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as marcas guardadas no banco e mostrá-las no select:
									while ($rs = mysql_fetch_array($select)) {
								?>
										<option value="<?php echo($rs["marca"]); ?>"><?php echo($rs["marca"]); ?></option>
								<?php
									}
								 ?>
							</select>
						</div>

						<input id="buscar" type="submit" name="btnBuscar" value="Buscar">
					</form>
        </div>

				<div class="modalConteiner">
					<div class="caixaModal">
						<div class="modalHeader">
							<p>Cadastrar Produto</p>
							<img src="img/close.png" id="fechar" alt="Fechar" title="Fechar">
						</div>

						<div class="modalContent">
							<form class="frmCadastro" action="crud_produtos.php" method="post">

								<fieldset id="cadProd">

									<div id="textoInputDescricao">
										<p class="texto">Descricao</p>
										<input id="descricao" type="text" name="" value="">
									</div>

									<div id="textoInputCategoria">
										<p class="texto">Categoria</p>
										<select class="slcCat" name="slcNome">
											<option value="0">Suco</option>
											<option value="0">Água</option>
											<option value="0">Refrigerante</option>
										</select>
									</div>

									<div id="textoInputCod">
										<p class="texto">Cód. de barras</p>
										<input id="cod" type="text" name="" value="" maxlength="12">
									</div>

									<div id="textoInputQtdEst">
										<p class="texto">Qtd. em estoque</p>
										<input id="qtdEst" type="text" name="" value="" disabled>
									</div>

									<div id="textoInputQtd">
										<p class="texto">Disp. p/ venda</p>
										<input id="qtd" type="number" name="" value="" min="0">
									</div>

									<div id="textoInputValor">
										<p class="texto">Valor</p>
										<input id="valor" type="text" name="" value="">
									</div>

									<div id="textoInputDesconto">
										<p class="texto">Desconto(%)</p>
										<input id="desconto" type="number" name="" value="" min="0" max="100" >
									</div>

									<div id="textoInputQtdEng">
										<p class="texto">Qtd. Engradado</p>
										<input id="qtdEng" type="number" name="" value="" min="0" max="50">
									</div>

									<div class="imgProd">
										<img id="imgProd" src="" alt="">

									</div>
									<div class="nomeArquivo">
										<span id="spanNome"></span>
										<img src="img/camera.png" alt="">
										<input id="file" type="file" name="" value="" onchange="readURL(this,'imgProd');">
									</div>

								</fieldset>

								<input class="botao" type="submit" name="btnConfirmar" value="Confirmar">
								<input class="botao limpar" type="reset" name="" value="Limpar">

							</form>
						</div>
					</div>
				</div>

        <div class="tabela">

          <div class="tblTitulo">
            Produtos Cadastrados
          </div>

          <div class="contTitulos">
            <div class="titulo id">
              ID
            </div>
            <div class="titulo desc">
              Descrição
            </div>
            <div class="titulo quantidade">
              Qtd
            </div>
            <div class="titulo cat">
              Categoria
            </div>
						<div class="titulo marca">
              Marca
            </div>
						<div class="titulo cod">
              Preço
            </div>
            <div class="titulo opcoes">
              Opções
            </div>
          </div>

          <div class="contCampos">
						<?php
							//Variavel que recebe o script para selecionar todos os usuários cadastrados, ordenando-os pelo ID de forma decrescente.
							$sql="SELECT p.*, c.descricao, m.marca FROM
										tblproduto AS p INNER JOIN tblcategoria AS c
										ON p.id_categoria = c.id_categoria
										INNER JOIN tblmarca as m
										ON p.id_marca = m.id_marca
										WHERE p.nome LIKE '%$descricaoDigitada%'
										AND c.descricao LIKE '%$catEscolhida%'
										AND m.marca LIKE '%$marcaEscolhida%'
										ORDER BY p.id_produto DESC;";
							//comando que executará este script, que será armazenado na variavel $select
							$select = mysql_query($sql);

							$cor = "";
							//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os dados de cada usuário cadastrado no banco e mostrá-los na tela:
							while ($rs = mysql_fetch_array($select))
							{
						?>
		            <div class="campos">
		              <div class="campo id">
		                <?php echo $rs['id_produto']; ?>
		              </div>
		              <div class="campo desc">
		                <?php echo utf8_encode($rs['nome']); ?>
		              </div>
		              <div class="campo quantidade">
		                <?php echo $rs['quantidadeEstoque']; ?>
		              </div>
		              <div class="campo cat">
		                <?php echo utf8_encode($rs['descricao']); ?>
		              </div>
									<div class="campo marca">
		                <?php echo utf8_encode($rs['marca']); ?>
		              </div>
									<div class="campo cod">
		                <?php echo ("R$ ".number_format(($rs['valorVenda']), 2, ',', ' ')); ?>
		              </div>
									<div class="campo edita">
										<a href="editar_produto.php?id=<?php echo($rs['id_produto'])?>">
		                	<img src="img/editar.png" class="imgOpcao edit" alt="editar" title="Editar Produto">
										</a>
		              </div>
		              <div class="campo apaga">
										<a href="crud_produtos.php?modo=excluir&id=<?php echo($rs['id_produto'])?>">
		                	<img src="img/apagar.png" class="imgOpcao" alt="apagar" title="Excluir Produto">
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
