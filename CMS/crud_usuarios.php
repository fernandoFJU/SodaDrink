<?php
	//chamada do arquivo com a conexão com o banco de dados
	require_once("funcoes/funcoes.php");

	session_start();

	//chamada da função de conexão com o banco de dados
	conexao();

	$nome = "";
	$cpf = "";
	$nascimento = "";
	$email = "";
	$telefone = "";
	$sexo = "";
	$estado = "";
	$cep = "";
	$logradouro = "";
	$bairro = "";
	$cidade = "";
	$numero = null;
	$nivel = "";
	$login = "";
	$senha = "";

	$nomeDigitado = "";
	$emailDigitado = "";
	$nivelEscolhido = "";

	//se existir na URL a variavel modo:
	if (isset($_GET["modo"])) {

		//guarda o conteudo da variavel modo numa variavel local
		$modo = $_GET["modo"];

		//se o modo for excluir:
		if ($modo == "excluir") {

	    //resgata a variavel que contem o id do usuario, chamada id
	    $id = $_GET["id"];

	    if (! mysql_query("call spGerenciarUsuario(3, '".$id."',null,null,'','','','','','','','','','',null,'','');")) {
	      die("Erro ao excluir Usuário!".mysql_error());
	      exit();
	    }else{
	      echo "<script type'text/javascript'>
	              alert('Usuário excluído com sucesso!');
	              document.location.href = 'crud_usuarios.php';
	            </script>";
	    }
		//caso o modo seja editar
		}
	}

	//se existir o clique do botão cadastrar pessoa juridica:
	if (isset($_POST["btnCadastrar"])) {

		//as variaveis anteriormente criadas recebem o conteudo que o usuário forneceu
		$nome = $_POST["txtNome"];
		$cpf = $_POST["txtCpf"];
		$nascimento = $_POST["txtNascimento"];
		$email = $_POST["txtEmail"];
		$telefone = $_POST["txtTelefone"];
		$sexo = $_POST["sexo"];
		$estado = $_POST["slcEstado"];
		$cep = $_POST["txtCep"];
		$logradouro = $_POST["txtLogradouro"];
		$bairro = $_POST["txtBairro"];
		$cidade = $_POST["txtCidade"];
		$numero = $_POST["txtNumero"];
		$nivel = $_POST["slcNivel"];
		$login = $_POST["txtLogin"];
		$senha = $_POST["txtSenha"];
		$senhaCriptografada = base64_encode($senha);

		if (! mysql_query("call spGerenciarUsuario(1, null, '".$estado."', '".$nivel."', '".$nome."', '".$cpf."', '".$nascimento."', '".$sexo."', '".$telefone."', '".$email."', '".$cep."', '".$cidade."', '".$logradouro."', '".$bairro."', ".$numero.",'".$login."','".$senhaCriptografada."');")) {

			die("Erro ao cadastrar!".mysql_error());
			exit();
		}else{
			echo "<script type'text/javascript'>
							alert('Cadastro efetuado com sucesso!');
							document.location.href = 'crud_usuarios.php';
						</script>";
		}
	}

	//aprovação
	if (isset($_GET['aprovar'])) {

		$aprovar = $_GET['aprovar'];
		$id = $_GET['id'];
    $pagina = "crud_usuarios.php";

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
		$nomeDigitado = $_POST['txtNomePesq'];
		$emailDigitado = $_POST['txtEmailPesq'];
		$nivelEscolhido = $_POST['slcNivelPesq'];
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gerenciamento de Usuários</title>
		<link rel="stylesheet" href="css/crud_usuarios.css">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
		<script type="text/javascript" src="js/jMaskedInput.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				$("#cpf").mask("999.999.999-99", {placeholder:" "});
				$("#telefone").mask("(99) 9999-9999", {placeholder:" "});
				$("#cep").mask("99999-999", {placeholder:" "});
				$("#nascimento").mask("99/99/9999", {placeholder:" "});

				$("#cpfCad").mask("999.999.999-99", {placeholder:" "});
				$("#telefoneCad").mask("(99) 9999-9999", {placeholder:" "});
				$("#cepCad").mask("99999-999", {placeholder:" "});
				$("#nascimentoCad").mask("99/99/9999", {placeholder:" "});
			});
		</script>
		<script type="text/javascript" >
      $(document).ready(function() {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#logradouroCad").val("");
            $("#bairroCad").val("");
            $("#cidadeCad").val("");
        }

        //Quando o campo cep perde o foco.
        $("#cepCad").blur(function() {

          //Nova variável "cep" somente com dígitos.
          var cep = $(this).val().replace(/\D/g, '');

          //Verifica se campo cep possui valor informado.
          if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

              //Preenche os campos com "..." enquanto consulta webservice.
              $("#logradouroCad").val("...");
              $("#bairroCad").val("...");
              $("#cidadeCad").val("...");

                //Consulta o webservice viacep.com.br/
              $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                  //Atualiza os campos com os valores da consulta.
                  $("#logradouroCad").val(dados.logradouro);
                  $("#bairroCad").val(dados.bairro);
                  $("#cidadeCad").val(dados.localidade);
                  //$("#uf").val(dados.uf);
                  //$("#ibge").val(dados.ibge);
                }else {
                  //CEP pesquisado não foi encontrado.
                  limpa_formulário_cep();
                  alert("CEP não encontrado.");
                }
              });
            }else {
              //cep é inválido.
              limpa_formulário_cep();
              alert("Formato de CEP inválido.");
            }
          } //end if.
          else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
          }
        });
      });
    </script>
		<script type="text/javascript">

      $(function(){

        $('.novo').click(function() {
          $(".modalConteinerCadastro").fadeIn();
        });
				$('#fecharCad').click(function() {
          $(".modalConteinerCadastro").fadeOut();
        });
				$(document).keyup(function(e) {
		      if (e.keyCode == 27) {
		        $(".modalConteinerCadastro").fadeOut();
		      }

		    });

				$('.editar').click(function() {
          $(".modalConteiner").fadeIn();
        });

      });

      function chamaModal(id_usuario) {

        $.ajax({
          type: "POST",
          url: "modal_container_usuario.php",
          data: {id_usuario:id_usuario},
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
          <p id="txtPagina">Gerenciamento de Usuários</p>
        </div>
        <hr width="1070" size="1">

        <div class="filtros">
          <div class="novo">
            &#10133; Novo Usuário
          </div>
					<form action="" method="post">

						<div id="pesqNome">
							<p class="texto">Nome</p>
							<input class="pesq Pnome" type="text" name="txtNomePesq" value="" placeholder="Buscar por Nome">
						</div>
						<div id="pesqEmail">
							<p class="texto">E-mail</p>
							<input class="pesq Pemail" type="email" name="txtEmailPesq" value="" placeholder="Buscar por E-mail">
						</div>

						<div id="pesqNivel">
							<p class="texto">Nível</p>
							<select class="slcNivelPesq" name="slcNivelPesq" >
								<option value="">Selecione</option>
								<?php
									//Variavel que recebe o script para selecionar todos os niveis de usuário.
									$niveis = "SELECT * FROM tblnivel;";

									//comando que executará este script, que será armazenado na variavel $niveis
									$select = mysql_query($niveis);

									//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $niveis numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os níveis guardados no banco e mostrá-los no select:
									while ($rs = mysql_fetch_array($select)) {

								?>
										<option value="<?php echo($rs["descricao"]); ?>"><?php echo($rs["descricao"]); ?></option>
								<?php
									}
								 ?>
							</select>
						</div>

						<input id="buscar" type="submit" name="btnBuscar" value="Buscar">
					</form>
        </div>

				<div class="modalConteiner">

				</div>

				<div class="modalConteinerCadastro">
					<div class="caixaModalCad">
					  <div class="modalHeaderCad">
					    <p>Cadastrar Usuário</p>
					    <img src="img/close.png" id="fecharCad" alt="Fechar" title="Fechar">
					  </div>

					  <div class="modalContentCad">
					    <form class="frmCadastro" action="crud_usuarios.php" method="post">

					      <fieldset id="dadosPessoaisCad">

					        <legend>Dados Pessoais</legend>

					        <div id="textoInputNomeCad">
					          <p class="textoCad">Nome</p>
					          <input id="nomeCad" type="text" name="txtNome" value="" required>
					        </div>

					        <div id="textoInputCpfCad">
					          <p class="textoCad">CPF</p>
					          <input id="cpfCad" type="text" name="txtCpf" value="" required>
					        </div>

					        <div id="textoInputTelefoneCad">
					          <p class="textoCad">Telefone</p>
					          <input id="telefoneCad" type="text" name="txtTelefone" value="" required>
					        </div>

					        <div id="textoInputNascimentoCad">
					          <p class="textoCad">Nascimento</p>
					          <input id="nascimentoCad" type="text" name="txtNascimento" value="" required>
					        </div>

					        <div id="textoInputEmailCad">
					          <p class="textoCad">E-mail</p>
					          <input id="emailCad" type="email" name="txtEmail" value="" required>
					        </div>

					        <div id="textoInputSexoCad">
					          <p class="textoCad">Sexo</p>
					          <input class="sexCad" type="radio" name="sexo" value="M" checked>Masculino
					          <input class="sexCad" type="radio" name="sexo" value="F">Feminino
					        </div>

					        <div id="textoInputUfCad">
					          <p class="textoCad">UF</p>
					          <select class="slcUfCad" name="slcEstado" required>
					            <?php
					              //Variavel que recebe o script para selecionar todos os estados.
					              $estados = "SELECT * FROM tblestado;";

					              //comando que executará este script, que será armazenado na variavel $estados
					              $select = mysql_query($estados);

					              //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $estados numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os estados guardados no banco e mostrá-los no select:
					              while ($rs = mysql_fetch_array($select)) {

					            ?>
					                <option value="<?php echo($rs['id_estado']); ?>"><?php echo($rs["uf"]); ?></option>
					            <?php
					              }
					             ?>
					          </select>
					        </div>

					        <div id="textoInputLograCad">
					          <p class="textoCad">Logradouro</p>
					          <input id="logradouroCad" type="text" name="txtLogradouro" value="" required>
					        </div>

					        <div id="textoInputNumeroCad">
					          <p class="textoCad">N°</p>
					          <input id="numeroCad" type="number" name="txtNumero" value="" required>
					        </div>

					        <div id="textoInputCepCad">
					          <p class="textoCad">CEP</p>
					          <input id="cepCad" type="text" name="txtCep" value="" required>
					        </div>

					        <div id="textoInputCidadeCad">
					          <p class="textoCad">Cidade</p>
					          <input id="cidadeCad" type="text" name="txtCidade" value="" required>
					        </div>

					        <div id="textoInputBairroCad">
					          <p class="textoCad">Bairro</p>
					          <input id="bairroCad" type="text" name="txtBairro" value="" required>
					        </div>

					      </fieldset>

					      <fieldset id="dadosProfissionaisCad">

					        <legend>Dados Profissionais</legend>

					        <div id="textoInputUsuarioCad">
					          <p class="textoCad">Usuário</p>
					          <input id="usuarioCad" type="text" name="txtLogin" value="" required>
					        </div>

					        <div id="textoInputSenhaCad">
					          <p class="textoCad">Senha</p>
					          <input id="senhaCad" type="password" name="txtSenha" value="" required>
					        </div>

					        <div id="textoInputConfirmarCad">
					          <p class="textoCad">Confirmar senha</p>
					          <input id="confirmarCad" type="password" name="" value="" required>
					        </div>

					        <div id="textoInputNivelCad">
					          <p class="textoCad">Nível</p>
					          <select class="slcNivelCad" name="slcNivel" required>
					            <option value="0">Selecione</option>
					            <?php
					              //Variavel que recebe o script para selecionar todos os niveis de usuário.
					              $niveis = "SELECT * FROM tblnivel;";

					              //comando que executará este script, que será armazenado na variavel $niveis
					              $select = mysql_query($niveis);

					              //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $niveis numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os níveis guardados no banco e mostrá-los no select:
					              while ($rs = mysql_fetch_array($select)) {

					            ?>
					                <option value="<?php echo($rs['id_nivel']); ?>"><?php echo($rs["descricao"]); ?></option>
					            <?php
					              }
					             ?>
					          </select>
					        </div>

					      </fieldset>

					      <input class="botaoCad" type="submit" name="btnCadastrar" value="Cadastrar">
					      <input class="botaoCad limparCad" type="reset" name="" value="Limpar">

					    </form>
					  </div>
					</div>
				</div>


        <div class="tabela">

          <div class="tblTitulo">
            Usuários Cadastrados
          </div>

          <div class="contTitulos">
            <div class="titulo id">
              ID
            </div>
            <div class="titulo nome">
              Nome
            </div>
            <div class="titulo email">
              E-mail
            </div>
            <div class="titulo tel">
              Telefone
            </div>
            <div class="titulo nivel">
              Nível
            </div>
            <div class="titulo opcoes">
              Opções
            </div>
          </div>

          <div class="contCampos">
						<?php
							//Variavel que recebe o script para selecionar todos os usuários cadastrados, ordenando-os pelo ID de forma decrescente.
							$sql="SELECT u.id_usuario, u.nome, u.email, u.telefone, n.descricao, n.id_nivel FROM
										tblusuario AS u INNER JOIN tblnivel AS n
										ON u.id_nivel = n.id_nivel
										AND u.nome LIKE '%$nomeDigitado%'
										AND u.email LIKE '%$emailDigitado%'
										AND n.descricao LIKE '%$nivelEscolhido%'";
							//comando que executará este script, que será armazenado na variavel $select
							$select = mysql_query($sql);

							$cor = "";
							//Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os dados de cada usuário cadastrado no banco e mostrá-los na tela:
							while ($rs = mysql_fetch_array($select))
							{
						?>
            <div class="campos">
              <div class="campo id">
                <?php echo($rs['id_usuario']); ?>
              </div>
              <div class="campo nome">
                <?php echo(utf8_encode($rs['nome'])); ?>
              </div>
              <div class="campo email">
                <?php echo($rs['email']); ?>
              </div>
              <div class="campo tel">
                <?php echo($rs['telefone']); ?>
              </div>
              <div class="campo nivel">
                <?php echo($rs['descricao']); ?>
              </div>
              <div class="campo edita">
								<img src="img/editar.png" onclick="chamaModal(<?php echo $rs['id_usuario'];?>);" class="editar" alt="" title="Editar Usuário">
              </div>
              <div class="campo apaga">
								<a href="crud_usuarios.php?modo=excluir&id=<?php echo($rs['id_usuario'])?>">
                	<img src="img/apagar.png" class="imgOpcao" alt="apagar" title="Excluir Usuário">
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
		<?php mysql_close(); ?>
	</body>
</html>
