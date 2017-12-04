<?php
	session_start();
	require_once ("funcoes/funcoes.php");
	conexao();

  $descricao = "";
  $categoria = "";
  $codBarra = 0;
  $estoque = 0;
  $qtdVenda = 0;
  $precoVenda = 0;
  $desconto = 0;
  $qtdPorEngradado = 0;
  $imagem = "";

  if(isset($_GET['id'])){

    //resgata a variavel que contem o id do produto, chamada id
    $id = $_GET["id"];

    //precisou-se criar uma variavel de sessão para guardar o id do produto, pois ao atualizar a pagina será nescessario recuperar essa informação
    $_SESSION['id_produto'] = $id;

    //script para localizar o produto específico
    $sql = "SELECT p.*, c.id_categoria, c.descricao as descricao FROM tblproduto AS p
		 				INNER JOIN tblcategoria AS c
						ON p.id_categoria = c.id_categoria
						WHERE id_produto = ".$id;

    //executa o script no banco e guarda na variavel select
    $select = mysql_query($sql);
    //converte o resutado do banco em matriz
    $rs = mysql_fetch_array($select);

    //os dados que rernarem do banco serão armazenados nas variaveis
    $descricao = $rs['nome'];
    $categoria = $rs['id_categoria'];
		$nomeCat = $rs['descricao'];
    $codBarra = $rs['codBarra'];
    $estoque = $rs['quantidadeEstoque'];
    $qtdVenda = $rs['qtdParaOSite'];
    $precoVenda = $rs['valorVenda'];
    $desconto = $rs['porcDesconto'];
    $qtdPorEngradado = $rs['quantidadeEngradado'];
    $imagem =$rs['imagem'];

  }else {
    $descricao = "";
    $categoria = "";
    $codBarra = "";
    $estoque = "";
    $qtdVenda = "";
    $precoVenda = "";
    $desconto = "";
    $qtdPorEngradado = "";
    $imagem = "";
  }

	if (isset($_POST["btnConfirmar"])) {

		//variavel que recebe o conteudo do input file
    $nome_arq = basename($_FILES['fleImagem']['name']);
    //variavel que recebe o caminho da pasta que o arquivo será guardado
    $upload_dir = "imgProdutos/";
    //variavel que contem o caminho e o nome do arquivo
    $upload_file = $upload_dir.$nome_arq;

		//estrutura de decisão para verificar se o arquivo seleciondo é .jpg ou .png
    if(strstr($nome_arq, '.jpg') || strstr($nome_arq, '.png')){

      //copia o arquivo que o usuário escolheu para o servidor na pasta imgClientes, se a copia acontecer com sucesso realizamos o insert no banco
      if(move_uploaded_file($_FILES['fleImagem']['tmp_name'], $upload_file)){

				$descricao = $_POST['txtDescricao'];
		    $categoria = $_POST['slcCat'];
		    $codBarra = $_POST['txtCodBarra'];
		    $qtdVenda = $_POST['txtQtdVenda'];
		    $precoVenda = $_POST['txtPrecoVenda'];
		    $desconto = $_POST['txtDesc'];
		    $qtdPorEngradado = $_POST['txtQtdEng'];

				$sql = "UPDATE tblproduto set
																		nome='".$descricao."',
																		id_categoria=".$categoria.",
																		codBarra=".$codBarra.",
																		qtdParaOSite=".$qtdVenda.",
																		valorVenda=".$precoVenda.",
																		porcDesconto=".$desconto.",
																		quantidadeEngradado=".$qtdPorEngradado.",
																		imagem='".$upload_file."'
																		WHERE id_produto = ".$_SESSION['id_produto'];
				

				//variavel que receberá o resultado da execução deste script. Se retornar um erro será mostrado um alert
        $resultado = mysql_query($sql);
        if (! $resultado) {
          die("Erro ao cadastrar!".mysql_error());
          exit();
        }else{
          echo "<script type'text/javascript'>
                  alert('Edição concluída!');
                  document.location.href = 'crud_produtos.php';
                </script>";
        }
			}
		}
	}

	//aprovação
	if (isset($_GET['aprovar'])) {

		$aprovar = $_GET['aprovar'];
		$id = $_GET['id'];
    $pagina = "editar_produto.php";

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
		<title>Editar Produto</title>
		<link rel="stylesheet" href="css/editar_produto.css">

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
          <p id="txtPagina">Edição de Produtos</p>
        </div>

        <hr width="1070" size="1">

				<form class="frmCadastro" action="editar_produto.php" method="post" enctype="multipart/form-data">

					<fieldset id="cadProd">

						<div id="textoInputDescricao">
							<p class="texto">Descricão</p>
							<input id="descricao" type="text" name="txtDescricao" value="<?php echo($descricao);?>">
						</div>

						<div id="textoInputCategoria">
							<p class="texto">Categoria</p>
							<select class="slcCat" name="slcCat">
								<?php
									if (isset($_GET['id'])) {

										$sql = "SELECT * FROM tblcategoria ORDER BY descricao ASC;";
										//comando que executará este script, que será armazenado na variavel $categorias
										$select = mysql_query($sql);

										while ($rs = mysql_fetch_array($select)) {
								?>
											<option value="<?php echo($rs['id_categoria']); ?>"><?php echo($rs["descricao"]); ?></option>
								<?php

										}
								?>
									<option value="<?php echo($categoria); ?>" selected><?php echo($nomeCat); ?></option>
								<?php
							}else{
									$sql = "SELECT * FROM tblcategoria ORDER BY descricao ASC;";
									//comando que executará este script, que será armazenado na variavel $categorias
									$select = mysql_query($sql);

									//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $estados numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as categorias guardadas no banco e mostrá-las no select:
									while ($rs = mysql_fetch_array($select)) {
								?>
										<option value="<?php echo($rs['id_categoria']); ?>"><?php echo($rs["descricao"]); ?></option>
								<?php
									}
								}
								 ?>


							</select>
						</div>

						<div id="textoInputCod">
							<p class="texto">Cód. de barras</p>
							<input id="cod" type="text" name="txtCodBarra" value="<?php echo($codBarra);?>" maxlength="12">
						</div>

						<div id="textoInputQtdEst">
							<p class="texto">Qtd. em estoque</p>
							<input id="qtdEst" type="text" name="txtEstoque" value="<?php echo($estoque);?>" disabled>
						</div>

						<div id="textoInputQtd">
							<p class="texto">Disp. p/ venda</p>
							<input id="qtd" type="number" name="txtQtdVenda" value="<?php echo($qtdVenda);?>" min="0">
						</div>

						<div id="textoInputValor">
							<p class="texto">Preço de venda</p>
							<input id="valor" type="text" name="txtPrecoVenda" value="<?php echo($precoVenda);?>">
						</div>

						<div id="textoInputDesconto">
							<p class="texto">Desconto (%)</p>
							<input id="desconto" type="number" name="txtDesc" value="<?php echo($desconto);?>" min="0" max="100" >
						</div>

						<div id="textoInputQtdEng">
							<p class="texto">Qtd. Engradado</p>
							<input id="qtdEng" type="number" name="txtQtdEng" value="<?php echo($qtdPorEngradado);?>" min="0" max="50">
						</div>

						<div class="imgProd">
							<img id="imgProd" src="<?php echo($imagem);?>" alt="">

						</div>
						<div class="nomeArquivo">
							<span id="spanNome"></span>
							<img src="img/camera.png" alt="">
							<input id="file" type="file" name="fleImagem" value="" onchange="readURL(this,'imgProd');">
						</div>

					</fieldset>

					<input class="botao" type="submit" name="btnConfirmar" value="Confirmar">
					<input class="botao limpar" type="reset" name="" value="Limpar">

				</form>
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
