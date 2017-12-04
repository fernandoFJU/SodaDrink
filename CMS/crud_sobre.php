<?php
//chamada do arquivo com a conexão com o banco de dados
require_once("funcoes/funcoes.php");

session_start();

//chamada da função de conexão com o banco de dados
conexao();



if (isset($_POST['btnSalvar'])) {
	$paragrafo1 =$_POST['txtparagrafo1'];
	$paragrafo2 =$_POST['txtparagrafo2'];
	$paragrafo3 =$_POST['txtparagrafo3'];
	$id =1;

	//variavel que recebe o conteudo do input file
	$nome_arq = basename($_FILES['fleImagem']['name']);
	//variavel que recebe o caminho da pasta que o arquivo será guardado
	$upload_dir = "../imgSobre/";
	//variavel que contem o caminho e o nome do arquivo
	$upload_file = $upload_dir.$nome_arq;
	//estrutura de decisão para verificar se o arquivo seleciondo é .jpg ou .png
	if(strstr($nome_arq, '.jpg') || strstr($nome_arq, '.png')){

		//copia o arquivo que o usuário escolheu para o servidor na pasta imgSobre, se a copia acontecer com sucesso realizamos o insert no banco
			if(move_uploaded_file($_FILES['fleImagem']['tmp_name'], $upload_file)){
				$sql=mysql_query("UPDATE tblsobre SET missao= '$paragrafo1', visao= '$paragrafo2', paragrafo = '$paragrafo3', imagem ='".$upload_file."' WHERE id_sobre = $id") or die(mysql_error());

				if (mysql_affected_rows() > 0) {
					echo "<script>alert('Sucesso!')</script>";
				}else {
					echo "<script>alert('Ocorreu um erro! Não foi possivel atualizar')</script>";
				}
			}
	}
}

	//aprovação
	if (isset($_GET['aprovar'])) {

		$aprovar = $_GET['aprovar'];
		$id = $_GET['id'];
    $pagina = "crud_sobre.php";

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
		<title>Gerenciar sobre nós</title>
		<link rel="stylesheet" href="css/crud_sobre.css">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>

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
          <p id="txtPagina">Gerenciar Sobre Nós</p>
        </div>

        <hr>

				<div class="contEditar">
					<form method="post" enctype="multipart/form-data" action="crud_sobre.php">

						<div class="imgSobre">
							<img id="imgSobre" src="" alt="">

						</div>
						<div class="nomeArquivo">
							<span id="spanNome"></span>
							<img src="img/camera.png" alt="">
							<input id="file" type="file" name="fleImagem" value="" onchange="readURL(this,'imgSobre');" required>
						</div>

						<p class="paragrafo">
							Missão:
						</p>
						<textarea class="txtarea"  name="txtparagrafo1" required></textarea>

						<p class="paragrafo">
							Visão:
						</p>
						<textarea class="txtarea"  name="txtparagrafo2" required></textarea>

						<p class="paragrafo">
							Mais sobre nós...
						</p>
						<textarea class="txtarea"  name="txtparagrafo3" required></textarea>

							<input id="btnSalvar" type="submit" value="Salvar" name="btnSalvar">
							<input id="btnApagar" type="reset" value="Limpar">
							<a href="../sobre.php"><input id="Redirect" type="button" value="Ir para sobre"></a>

					</form>

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
