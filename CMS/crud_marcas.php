<?php
	//chamada do arquivo com a conexão com o banco de dados
	require_once("funcoes/funcoes.php");

	session_start();

	//chamada da função de conexão com o banco de dados
	conexao();

	//variavel criada para alterar o value do botao Cadastrar, para o usuário perceba o que está pestes a fazer
	$botao = "Cadastrar";
	$marca = "";
	//se existir na URL a variavel modo:
	if (isset($_GET["modo"])) {

		//guarda o conteudo da variavel modo numa variavel local
		$modo = $_GET["modo"];

		//se o modo for excluir:
		if ($modo == "excluir") {

	    //resgata a variavel que contem o id da marca, chamada id
	    $id = $_GET["id"];

	    //script para apagar registros no banco de dados; para apagar um registro especifico usa-se where e um campo especifico de um registro. Neste caso será apagada a marca cujo ID for igual ao id resgatado da URL
	    $sql = "DELETE FROM tblmarca WHERE id_marca = ".$id;

	  	$resultado = mysql_query($sql);
	    if (! $resultado) {
	      die("Erro ao excluir marca!".mysql_error());
	      exit();
	    }else{
	      echo "<script type'text/javascript'>
	              alert('Marca excluída com sucesso!');
	              document.location.href = 'crud_marcas.php';
	            </script>";
	    }
		//caso o modo seja editar
		}elseif($modo == 'editar'){

			//resgata a variavel que contem o id da categoria, chamada id
	    $id = $_GET["id"];

			//precisou-se criar uma variavel de sessão para guardar o id da marca, pois ao atualizar a pagina será nescessario recuperar essa informação
			$_SESSION['id_marca'] = $id;

			//script para localizar o nivel específico
			$sql = "select * from tblmarca where id_marca = ".$id;

			//executa o script no banco e guarda na variavel select
			$select = mysql_query($sql);
			//converte o resutado do banco em matriz
			$rs = mysql_fetch_array($select);
			//os dados que rernarem do banco serão armazenados nas variaveis
			$marca = $rs['marca'];

			//a varivael mudará seu valor pois a opção foi Atualizar a categoria
			$botao='Atualizar';

		}
	}

	//se existir o clique do botão cadastrar:
	if (isset($_POST["btnCadastrar"])) {

		//as variaveis anteriormente criadas recebem o conteudo que o usuário forneceu
		$marca = $_POST["txtMarca"];

		if ($_POST["btnCadastrar"] == "Cadastrar") {

			//variável que receberá o script para inserir uma nova marca
			$sql = "INSERT INTO tblmarca(marca)VALUES('".$marca."')";

			//variavel que receberá o resultado da execução deste script. Se retornar um erro será mostrado um alert
			$resultado = mysql_query($sql);
			if (! $resultado) {
				die("Erro ao cadastrar!".mysql_error());
				exit();
			}else{
				echo "<script type'text/javascript'>
								alert('Cadastro efetuado com sucesso!');
								document.location.href = 'crud_marcas.php';
							</script>";
			}

		}elseif ($_POST["btnCadastrar"] == "Atualizar") {

			$sql="UPDATE tblmarca SET marca= '".$marca."' WHERE id_marca = ".$_SESSION['id_marca'];

			//variavel que receberá o resultado da execução deste script. Se retornar um erro será mostrado um alert
			$resultado = mysql_query($sql);
			if (! $resultado) {
				die("Erro ao Atualizar!".mysql_error());
				exit();
			}else{
				echo "<script type'text/javascript'>
								alert('Atualização efetuada com sucesso!');
								document.location.href = 'crud_marcas.php';
							</script>";
			}
		}

	}

	//aprovação
	if (isset($_GET['aprovar'])) {

		$aprovar = $_GET['aprovar'];
		$id = $_GET['id'];
    $pagina = "crud_marcas.php";

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
		<title>Gerenciamento de Usuários</title>
		<link rel="stylesheet" href="css/crud_marcas.css">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>

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
          <p id="txtPagina">Gerenciamento de Marcas</p>
        </div>
        <hr width="1070" size="1">

        <div class="filtros">

					<form action="crud_marcas.php" method="post">

						<div id="pesqNome">
							<p class="texto">Marca</p>
							<input class="pesq" type="text" name="txtMarca" value="<?php echo ($marca); ?>" placeholder="Nome da Marca" required>
						</div>
            <input id="buscar" type="submit" name="btnCadastrar" value="<?php echo ($botao); ?>">
					</form>
        </div>

        <div class="tabela">

          <div class="tblTitulo">
            Marcas Cadastradas
          </div>

          <div class="contTitulos">
            <div class="titulo id">
              ID
            </div>
            <div class="titulo nome">
              Marca
            </div>
            <div class="titulo opcoes">
              Opções
            </div>
          </div>

          <div class="contCampos">
						<?php
							//Variavel que recebe o script para selecionar todas as marcas cadastrados, ordenando-as pelo ID de forma decrescente.
							$sql="SELECT * FROM tblmarca ORDER BY id_marca DESC;";
							//comando que executará este script, que será armazenado na variavel $select
							$select = mysql_query($sql);

							$cor = "";
							//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as marcas cadastrados no banco e mostrá-los na tela:
							while ($rs = mysql_fetch_array($select))
							{
						?>
		            <div class="campos">
		              <div class="campo id">
		                <?php echo($rs['id_marca']); ?>
		              </div>
		              <div class="campo nome">
		                <?php echo(utf8_encode($rs['marca'])); ?>
		              </div>
		              <div class="campo edita">
										<a href="crud_marcas.php?modo=editar&id=<?php echo($rs['id_marca']); ?>">
											<img src="img/editar.png" class="imgOpcao" alt="editar" title="Editar Marca">
										<a/>
		              </div>
		              <div class="campo apaga">
										<a href="crud_marcas.php?modo=excluir&id=<?php echo($rs['id_marca']); ?>">
		                	<img src="img/apagar.png" class="imgOpcao" alt="apagar" title="Excluir Marca">
										<a/>
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
