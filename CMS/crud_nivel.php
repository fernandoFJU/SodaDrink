<?php
	//chamada do arquivo com a conexão com o banco de dados
	require_once("funcoes/funcoes.php");

	session_start();

	//chamada da função de conexão com o banco de dados
	conexao();

	//variavel criada para alterar o value do botao Cadastrar, para o usuário perceba o que está pestes a fazer
	$botao = "Cadastrar";
	$descricao = "";

  $categoria = 0;
  $produto = 0;
  $marca = 0;
  $nivel = 0;
  $usuario = 0;
  $relatorio = 0;

	//se existir na URL a variavel modo:
	if (isset($_GET["modo"])) {

		//guarda o conteudo da variavel modo numa variavel local
		$modo = $_GET["modo"];

		//se o modo for excluir:
		if ($modo == "excluir") {

	    //resgata a variavel que contem o id do nivel, chamada id
	    $id = $_GET["id"];

	    if (! mysql_query("call spGerenciarNivel(3, '".$id."', '', null, null, null, null, null, null);")) {
	      die("Erro ao excluir nível!".mysql_error());
	      exit();
	    }else{
	      echo "<script type'text/javascript'>
	              alert('Nível excluído com sucesso!');
	              document.location.href = 'crud_nivel.php';
	            </script>";
	    }
		//caso o modo seja editar
		}elseif($modo == 'editar'){

			//resgata a variavel que contem o id do nivel, chamada id
	    $id = $_GET["id"];

			//precisou-se criar uma variavel de sessão para guardar o id do nível, pois ao atualizar a pagina será nescessario recuperar essa informação
			$_SESSION['id_nivel'] = $id;

			//script para localizar o nivel específico
			$sql = "select * from tblnivel where id_nivel = ".$id;

			//executa o script no banco e guarda na variavel select
			$select = mysql_query($sql);
			//converte o resutado do banco em matriz
			$rs = mysql_fetch_array($select);
			//os dados que rernarem do banco serão armazenados nas variaveis
			$descricao = $rs['descricao'];
			$categoria = $rs["categoria"];
			$produto = $rs["produto"];
			$marca = $rs["marca"];
			$nivel = $rs["nivel"];
			$usuario = $rs["usuario"];
			$relatorio = $rs["relatorio"];
			//a varivael mudará seu valor pois a opção foi Atualizar o nível
			$botao='Atualizar';

		}
	}

	//se existir o clique do botão cadastrar:
	if (isset($_POST["btnCadastrar"])) {

		//as variaveis anteriormente criadas recebem o conteudo que o usuário forneceu
		$descricao = $_POST["txtDescricao"];


    if(isset($_POST["cboCat"])){
      $categoria = 1;
    }else {
      $categoria = 0;
    }
    if(isset($_POST["cboProduto"])){
      $produto = 1;
    }else {
      $produto = 0;
    }
    if(isset($_POST["cboMarca"])){
      $marca = 1;
    }else {
      $marca = 0;
    }
    if(isset($_POST["cboNivel"])){
      $nivel = 1;
    }else {
      $nivel = 0;
    }
    if(isset($_POST["cboUser"])){
      $usuario = 1;
    }else {
      $usuario = 0;
    }
    if(isset($_POST["cboRel"])){
      $relatorio = 1;
    }else {
      $relatorio = 0;
    }

		if ($_POST["btnCadastrar"] == "Cadastrar") {

			if (! mysql_query("CALL spGerenciarNivel(1, null, '".$descricao."', ".$produto.", ".$categoria.", ".$marca.", ".$usuario.", ".$nivel.", ".$relatorio.")")) {
				die("Erro ao cadastrar!".mysql_error());
				exit();
			}else{
				echo "<script type'text/javascript'>
								alert('Cadastro efetuado com sucesso!');
								document.location.href = 'crud_nivel.php';
							</script>";
			}

		}elseif ($_POST["btnCadastrar"] == "Atualizar") {

			if (! mysql_query("CALL spGerenciarNivel(2, '".$_SESSION['id_nivel']."', '".$descricao."', ".$produto.", ".$categoria.", ".$marca.", ".$usuario.", ".$nivel.", ".$relatorio.")")) {
				die("Erro ao Atualizar!".mysql_error());
				exit();
			}else{
				echo "<script type'text/javascript'>
								alert('Atualização efetuada com sucesso!');
								document.location.href = 'crud_nivel.php';
							</script>";
			}
		}

	}

	//aprovação
	if (isset($_GET['aprovar'])) {

		$aprovar = $_GET['aprovar'];
		$id = $_GET['id'];
    $pagina = "crud_nivel.php";

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
		<title>Gerenciamento de Níveis</title>
		<link rel="stylesheet" href="css/crud_nivel.css">

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
          <p id="txtPagina">Gerenciamento de Níveis</p>
        </div>
        <hr width="1070" size="1">

        <div class="filtros">

					<form action="crud_nivel.php" method="post">

						<div id="pesqNome">
							<p class="texto">Nível</p>
							<input class="pesq" type="text" name="txtDescricao" value="<?php echo($descricao); ?>" placeholder="Nome do Nível" required>
						</div>
						<div id="checkboxes">
							<p style="font-weight:bold; font-size:18px;">Permissões</p>

							<input type="checkbox" id="checkProd" name="cboProduto" <?php echo $produto == 1 ?  "checked" : "" ?>  >
							<label for="checkProd">Produto</label>

							<input type="checkbox" id="checkCat" name="cboCat" <?php echo $categoria == 1 ?  "checked" : "" ?>>
							<label for="checkCat">Categoria</label>

							<input type="checkbox" id="checkMarca" name="cboMarca" <?php echo $marca == 1 ?  "checked" : "" ?>>
							<label for="checkMarca">Marca</label>

							<input type="checkbox" id="checkNivel" name="cboNivel" <?php echo $nivel == 1 ?  "checked" : "" ?>>
							<label for="checkNivel">Nível</label>

							<input type="checkbox" id="checkUser" name="cboUser" <?php echo $usuario== 1 ?  "checked" : "" ?>>
							<label for="checkUser">Usuário</label>

							<input type="checkbox" id="checkRel" name="cboRel" <?php echo $relatorio == 1 ?  "checked" : "" ?>>
							<label for="checkRel">Relatórios</label>
						</div>
            <input id="buscar" type="submit" name="btnCadastrar" value="<?php echo($botao); ?>">
					</form>
        </div>

        <div class="tabela">

          <div class="tblTitulo">
            Níveis Cadastrados
          </div>

          <div class="contTitulos">
            <div class="titulo id">
              ID
            </div>
            <div class="titulo nome">
              Nível
            </div>
						<div class="titulo permissoes">
              Permissões
            </div>
            <div class="titulo opcoes">
              Opções
            </div>
          </div>

          <div class="contCampos">
						<?php
							//Variavel que recebe o script para selecionar todos os níveis cadastrados, ordenando-os pelo ID de forma decrescente.
							$sql="SELECT * FROM tblnivel ORDER BY id_nivel DESC;";
							//comando que executará este script, que será armazenado na variavel $select
							$select = mysql_query($sql);

							$cor = "";
							//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os niveis cadastrados no banco e mostrá-los na tela:
							while ($rs = mysql_fetch_array($select)){

								$categoria = $rs["categoria"];
								$produto = $rs["produto"];
								$marca = $rs["marca"];
								$nivel = $rs["nivel"];
								$usuario = $rs["usuario"];
								$relatorio = $rs["relatorio"];

						?>
		            <div class="campos">
		              <div class="campo id">
		                <?php echo($rs['id_nivel']); ?>
		              </div>
		              <div class="campo nome">
										<?php echo($rs['descricao']); ?>
		              </div>
									<div class="campo permissoes">
										<?php
											if ($produto == "1") {
												echo "<input type='checkbox' class='checkbox' name='' value='' disabled checked> Produto &nbsp";
											}else {
												echo "<input type='checkbox' class='checkbox'name='' value='' disabled > Produto &nbsp";
											}
											if ($categoria== "1") {
												echo "<input type='checkbox' class='checkbox'name='' value='' disabled checked> Categoria &nbsp";
											}else {
												echo "<input type='checkbox' class='checkbox'name='' value='' disabled > Categoria &nbsp";
											}
											if ($marca == "1") {
												echo "<input type='checkbox' class='checkbox' name='' value='' disabled checked> Marca &nbsp";
											}else {
												echo "<input type='checkbox' class='checkbox' name='' value='' disabled > Marca &nbsp";
											}
											if ($nivel == "1") {
												echo "<input type='checkbox' class='checkbox' name='' value='' disabled checked> Nível &nbsp";
											}else {
												echo "<input type='checkbox' class='checkbox' name='' value='' disabled > Nível &nbsp";
											}
											if ($usuario == "1") {
												echo "<input type='checkbox' class='checkbox' name='' value='' disabled checked> Usuário &nbsp";
											}else {
												echo "<input type='checkbox' class='checkbox' name='' value='' disabled > Usuário &nbsp";
											}
											if ($relatorio == "1") {
												echo "<input type='checkbox' class='checkbox' name='' value='' disabled checked> Relatórios &nbsp";
											}else {
												echo "<input type='checkbox' class='checkbox' name='' value='' disabled > Relatórios &nbsp";
											}
										 ?>
			            </div>
		              <div class="campo edita">
										<a href="crud_nivel.php?modo=editar&id=<?php echo($rs['id_nivel']); ?>">
											<img src="img/editar.png" class="imgOpcao" alt="editar" title="Editar Nível">
										<a/>
		              </div>
		              <div class="campo apaga">
										<a href="crud_nivel.php?modo=excluir&id=<?php echo($rs['id_nivel']); ?>">
		                	<img src="img/apagar.png" class="imgOpcao" alt="apagar" title="Excluir Nível">
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
