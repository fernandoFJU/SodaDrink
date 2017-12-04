<?php
  session_start();
  require_once("funcoes/funcoes.php");
  conexao();

  //criando variaveis vazias que futuramente receberão o conteudo que o usuário fornecer
  $descricao= "";
  $passo1 = "";
  $passo2 = "";
  $passo3 = "";
  $validade = "";
  $botao = "Cadastrar";

  if (isset($_GET["modo"])) {

		//guarda o conteudo da variavel modo numa variavel local
		$modo = $_GET["modo"];

		//se o modo for excluir:
		if ($modo == "excluir") {

	    //resgata a variavel que contem o id da promoção, chamada id
	    $id = $_GET["id"];

	    if (! mysql_query("call spGerenciarPromocao(3, '".$id."','','','','','','');")) {
	      die("Erro ao excluir promocao!".mysql_error());
	      exit();
	    }else{
	      echo "<script type'text/javascript'>
	              alert('Promoção excluída com sucesso!');
	              document.location.href = 'crud_promocoes.php';
	            </script>";
	    }
		//caso o modo seja editar
		}elseif($modo == 'editar'){

			//resgata a variavel que contem o id da promoção, chamada id
	    $id = $_GET["id"];

			//precisou-se criar uma variavel de sessão para guardar o id da promoção, pois ao atualizar a pagina será nescessario recuperar essa informação
			$_SESSION['id_promocao'] = $id;

			//script para localizar a promoção específico
			$sql = "SELECT * FROM tblpromocao WHERE id_promocao = ".$id;

			//executa o script no banco e guarda na variavel select
			$select = mysql_query($sql);
			//converte o resutado do banco em matriz
			$rs = mysql_fetch_array($select);
			//os dados que rernarem do banco serão armazenados nas variaveis
			$descricao = $rs['descricao'];
      $passo1 = $rs['passo1'];
      $passo2 = $rs['passo2'];
      $passo3 = $rs['passo3'];
      $validade = $rs['validade'];

			//a varivael mudará seu valor pois a opção foi Atualizar a promoção
			$botao='Atualizar';

		}
	}

	//se existir o clique do botão cadastrar:
	if (isset($_POST["btnCadastrar"])) {

		//as variaveis anteriormente criadas recebem o conteudo que o usuário forneceu
		$descricao = $_POST["txtDescricao"];
    $passo1 = $_POST["txtPasso1"];
    $passo2 = $_POST["txtPasso2"];
    $passo3 = $_POST["txtPasso3"];
    $validade = $_POST['txtValidade'];

    //variavel que recebe o conteudo do input file
    $nome_arq = basename($_FILES['fleImagem']['name']);
    //variavel que recebe o caminho da pasta que o arquivo será guardado
    $upload_dir = "imgPromocoes/";
    //variavel que contem o caminho e o nome do arquivo
    $upload_file = $upload_dir.$nome_arq;

		if ($_POST["btnCadastrar"] == "Cadastrar") {

      //estrutura de decisão para verificar se o arquivo seleciondo é .jpg ou .png
      if(strstr($nome_arq, '.jpg') || strstr($nome_arq, '.png')){

        //copia o arquivo que o usuário escolheu para o servidor na pasta imgPromocoes, se a copia acontecer com sucesso realizamos o insert no banco
        if(move_uploaded_file($_FILES['fleImagem']['tmp_name'], $upload_file)){

    			if(!mysql_query("call spGerenciarPromocao(1,null,'".$descricao."','".$upload_file."','".$validade."','".$passo1."','".$passo2."','".$passo3."');")){
    				die("Erro ao cadastrar!".mysql_error());
    				exit();
    			}else{
    				echo "<script type'text/javascript'>
    								alert('Cadastro efetuado com sucesso!');
    								document.location.href = 'crud_promocoes.php';
    							</script>";
    			}
        }
      }

		}elseif ($_POST["btnCadastrar"] == "Atualizar") {

      //estrutura de decisão para verificar se o arquivo seleciondo é .jpg ou .png
      if(strstr($nome_arq, '.jpg') || strstr($nome_arq, '.png')){

        //copia o arquivo que o usuário escolheu para o servidor na pasta imgPromocoes, se a copia acontecer com sucesso realizamos o insert no banco
        if(move_uploaded_file($_FILES['fleImagem']['tmp_name'], $upload_file)){

          if(!mysql_query("call spGerenciarPromocao(2,".$_SESSION['id_promocao'].",'".$descricao."','".$upload_file."','".$validade."','".$passo1."','".$passo2."','".$passo3."');")) {
    				die("Erro ao Atualizar!".mysql_error());
    				exit();
    			}else{
    				echo "<script type'text/javascript'>
    								alert('Atualização efetuada com sucesso!');
    								document.location.href = 'crud_promocoes.php';
    							</script>";
    			}
        }
      }

		}

	}

  //aprovação
	if (isset($_GET['aprovar'])) {

		$aprovar = $_GET['aprovar'];
		$id = $_GET['id'];
    $pagina = "crud_promocoes.php";

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
		<title>Gerenciamento de Promoções</title>
		<link rel="stylesheet" href="css/crud_promocoes.css">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/jMaskedInput.js"></script>

    <script type="text/javascript">


        $(document).ready(function(){
          $('.imgInformacao').click(function() {
            $(".modalConteinerInfo").fadeIn();
          });
          $('#fechar').click(function() {
            $(".modalConteinerInfo").fadeOut();
          });

          $('.novo').click(function() {
            $(".modalConteiner").fadeIn();
          });
          $('#close').click(function() {
            $(".modalConteiner").fadeOut();
          });

          $(document).keyup(function(e) {
            if (e.keyCode == 27) {
              $(".modalConteiner").fadeOut();
              $(".modalConteinerInfo").fadeOut();
            }

          });
        });

    </script>
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

    <script type="text/javascript">
      /*$(function() {

        $('.imgInformacao').click(function() {
        $('.modalConteiner').html('Carregando..');
        var id = $(this).attr('id');
        $('modalConteiner').load('crud_fale_conosco.php?id='+id);
        });

      });*/
      $(document).ready(function() {
        $("#txtValidade").mask("99/99/9999", {placeholder:" "});

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
          <p id="txtPagina">Gerenciar Promoções</p>
        </div>

        <hr width="1070" size="1">

        <div class="filtros">

					<div class="novo">
            &#10133; Nova Promoção
          </div>

        </div>

        <div class="modalConteiner">
          <div class="caixaModal">
            <div class="modalHeader">
              <p><?php echo $botao?> Promoção</p>
              <img src="img/close.png" id="close" alt="Fechar" title="Fechar">
            </div>

            <div class="modalContent">

              <form method="post" enctype="multipart/form-data" action="crud_promocoes.php">

    						<div class="imgPromocao">
    							<img id="imgPromocao" src="" alt="">

    						</div>
    						<div class="nomeArquivo">
    							<span id="spanNome"></span>
    							<img src="img/camera.png" alt="">
    							<input id="file" type="file" name="fleImagem" value="" onchange="readURL(this,'imgPromocao');">
    						</div>

    						<p class="title">
    							Descrição
    						</p>
    						<input type="text" id="txtDescricao" name="txtDescricao" value="<?php echo $descricao?>" maxlength="100" required>

    						<p class="title">
    							Passo 1
    						</p>
    						<textarea class="txtarea"  name="txtPasso1" required><?php echo $passo1?></textarea>

    						<p class="title">
    							Passo 2
    						</p>
    						<textarea class="txtarea"  name="txtPasso2" required><?php echo $passo2?></textarea>

    						<p class="title">
    							Passo 3
    						</p>
    						<textarea class="txtarea"  name="txtPasso3" required><?php echo $passo3?></textarea>

                <p class="title">
    							Validade
    						</p>
    						<input type="text" id="txtValidade" name="txtValidade" value="<?php echo $validade?>" required>

    						<p>
    							<input id="btnSalvar" type="submit" value="<?php echo $botao?>" name="btnCadastrar">
    							<input id="btnApagar" type="reset" value="Limpar">
    						</p>

    					</form>

            </div>
          </div>
        </div>

        <div class="modalConteinerInfo">
          <div class="caixaModalInfo">
            <div class="modalHeaderInfo">
              <p>Informações da promoção</p>
              <img src="img/close.png" id="fechar" alt="Fechar" title="Fechar">
            </div>

            <div class="modalContentInfo">

              <p class="txt">ID</p>
              <div class="texto">
                <p id="id">2</p>
              </div>

							<p class="txt">Descrição</p>
              <div class="texto">
                <p>junte sei lá</p>
              </div>

              <p class="txt">Imagem</p>
              <div class="texto">
                <p>teste</p>
              </div>

              <p class="txt">Passo 1</p>
              <div class="texto">
                <p>tstestetst</p>
              </div>

							<p class="txt">Passo 2</p>
              <div class="texto">
                <p>tstestetst</p>
              </div>

							<p class="txt">Passo 3</p>
              <div class="texto">
                <p>tstestetst</p>
              </div>

              <div class="excluir">
                Excluir
              </div>
            </div>
          </div>
        </div>

        <div class="tabela">

          <div class="tblTitulo">
            Promoções Cadastradas
          </div>

          <div class="contTitulos">
            <div class="titulo id">
              ID
            </div>
            <div class="titulo desc">
              Descricao
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
              //Variavel que recebe o script para selecionar todos as promoções do site, ordenando-os pelo ID de forma decrescente.
              $sql="SELECT * FROM tblpromocao ORDER BY id_promocao DESC;";
              //comando que executará este script, que será armazenado na variavel $select
              $select = mysql_query($sql);

              $cor = "";
              //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar as promoções guardados no banco e mostrá-los na tela:
              while ($rs = mysql_fetch_array($select))
              {
            ?>
                <div class="campos">
                  <div class="campo id">
                    <?php echo($rs['id_promocao']); ?>
                  </div>
                  <div class="campo desc">
                    <?php echo(utf8_encode($rs['descricao'])); ?>
                  </div>

                  <div class="campo info">

                    <img src="img/informacoes.png" data-id="<?php echo($rs['id_promocao']);?>" class="imgInformacao" alt="Informacão" title="Mais informações do comentário">

                  </div>

									<div class="campo edita">
										<a href="crud_promocoes.php?modo=editar&id=<?php echo($rs['id_promocao'])?>">
		                	<img src="img/editar.png" class="imgOpcao" alt="editar" title="Editar promocao">
										</a>
		              </div>
                  <div class="campo apaga">
                    <a href="crud_promocoes.php?modo=excluir&id=<?php echo($rs['id_promocao']);?>">
                      <img src="img/apagar.png"  class="imgOpcao" alt="apagar" title="Excluir Promoção">
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
