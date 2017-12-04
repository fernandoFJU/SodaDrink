<?php

  //chamada do arquivo com a conexão com o banco de dados
  require_once("funcoes/funcoes.php");

  //chamada da função de conexão com o banco de dados
  conexao();
  session_start();
?>

<?php
  //criando variaveis vazias que futuramente receberão o conteudo que o cliente fornecer
  $razaoSocial = "";
  $nomeFantasia = "";
  $cnpj = "";
  $inscricaoEstadual = "";
  $email = "";
  $telefone = "";
  $cep = "";
  $logradouro = "";
  $bairro = "";
  $cidade = "";
  $numero = null;
  $estado = "";
  $login = "";
  $senha = "";

  //se existir o clique do botão cadastrar pessoa juridica:
  if (isset($_POST["btnPessoaJuridica"])) {

    //variavel que recebe o conteudo do input file
    $nome_arq = basename($_FILES['fleimagem']['name']);
    //variavel que recebe o caminho da pasta que o arquivo será guardado
    $upload_dir = "imgClientes/";
    //variavel que contem o caminho e o nome do arquivo
    $upload_file = $upload_dir.$nome_arq;

    //estrutura de decisão para verificar se o arquivo seleciondo é .jpg ou .png
    if(strstr($nome_arq, '.jpg') || strstr($nome_arq, '.png')){

      //copia o arquivo que o usuário escolheu para o servidor na pasta imgClientes, se a copia acontecer com sucesso realizamos o insert no banco
      if(move_uploaded_file($_FILES['fleimagem']['tmp_name'], $upload_file)){

        //variaveis criadas para receberem o conteudo que o cliente forneceu
        $razaoSocial = $_POST["txtRazao"];
        $nomeFantasia = $_POST["txtFantasia"];
        $cnpj = $_POST["txtCnpj"];
        $inscricaoEstadual = $_POST["txtIe"];
        $email = $_POST["txtEmail"];
        $telefone = $_POST["txtTelefone"];
        $cep = $_POST["txtCep"];
        $logradouro = $_POST["txtLogradouro"];
        $bairro = $_POST["txtBairro"];
        $cidade = $_POST["txtCidade"];
        $numero = $_POST["txtNumero"];
        $estado = $_POST["slcEstado"];
        $login = $_POST["txtLogin"];
        $senha = $_POST["txtSenha"];
        $senhaCriptografada = base64_encode($senha);

        //variável que receberá o script para inserir um novo cliente juridico
        $sql = "INSERT INTO tblclientejuridico(razaoSocial, nomeFantasia, cnpj, inscricaoEstadual, email, telefone, cep, cidade, logradouro, bairro, numero, id_estado, dtCadastro, login, senha, imagem)
        VALUES('".$razaoSocial."', '".$nomeFantasia."', '".$cnpj."', '".$inscricaoEstadual."', '".$email."', '".$telefone."', '".$cep."', '".$cidade."','".$logradouro."', '".$bairro."', ".$numero.", '".$estado."', NOW(), '".$login."', '".$senhaCriptografada."', '".$upload_file."')";

        //variavel que receberá o resultado da execução deste script. Se retornar um erro será mostrado um alert
        $resultado = mysql_query($sql);
        if (! $resultado) {
          die("Erro ao cadastrar!".mysql_error());
          exit();
        }else{
          echo "<script type'text/javascript'>
                  alert('Cadastro efetuado com sucesso!');
                  document.location.href = 'cad_pessoa.php';
                </script>";
        }
      }else{
        echo "erro";
      }
    }
  }
?>

<?php
  //criando variaveis vazias que futuramente receberão o conteudo que o cliente fornecer
  $nome = "";
  $email = "";
  $celular= "";
  $login = "";
  $senha = "";

  //se existir o clique do botão cadastrar pessoa juridica:
  if (isset($_POST["btnPessoaFisica"])) {

    //as variaveis anteriormente criadas recebem o conteudo que o cliente forneceu
    $nome = $_POST["txtNome"];
    $email = $_POST["txtEmailFisico"];
    $celular = $_POST["txtCelular"];
    $login = $_POST["txtLoginFisico"];
    $senha = $_POST["txtSenhaFisico"];
    $senhaCriptografada = base64_encode($senha);

    //variável que receberá o script para inserir um novo cliente juridico
    $sql = "INSERT INTO tblclientefisico(nome, email, celular, dtCadastro, login, senha)
    VALUES('".$nome."', '".$email."', '".$celular."', NOW(), '".$login."', '".$senhaCriptografada."')";

    //variavel que receberá o resultado da execução deste script. Se retornar um erro será mostrado um alert
    $resultado = mysql_query($sql);
    if (! $resultado) {
      die("Erro ao cadastrar!".mysql_error());
      exit();
    }else{
      echo "<script type'text/javascript'>
              alert('Cadastro efetuado com sucesso!');
              document.location.href = 'cad_pessoa.php';
            </script>";
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cadastro</title>
    <link rel="stylesheet" type="text/css" media="all" href="css/cad_pessoa.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/index.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jMaskedInput.js"></script>
    <script type="text/javascript" src="js/logo.js"></script>
    <script type="text/javascript" src="js/menuOffCanvas.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {

        var abrirJuridico = $(".jur");
        var abrirFisico = $(".fis");
        var divPessoaJuridica = $(".juridica");
        var divPessoaFisica = $(".fisica");

        abrirJuridico.click(function(){
          divPessoaFisica.css("display", "none");
          divPessoaJuridica.fadeIn(500);
        });
        abrirFisico.click(function(){
          divPessoaJuridica.css("display", "none");
          divPessoaFisica.fadeIn(500);
        });

      });
    </script>
    <script type="text/javascript">
      $(function () {
        $(".divloginResponsivo").click(function() {
          $(".modalConteiner").fadeIn();
        });
        $("#fechar").click(function() {
          $(".modalConteiner").fadeOut();
        });
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
        $(".cnpj").mask("99.999.999/9999-99", {placeholder:" "});
        $(".ie").mask("999.999.999.999", {placeholder:" "});
        $(".cep").mask("99999-999", {placeholder:" "});
        $(".tel").mask("(99) 9999-9999", {placeholder:" "});
        $(".cel").mask("(99)9 9999-9999", {placeholder:" "});
      });
    </script>
    <script type="text/javascript" >

      $(document).ready(function() {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $(".logra").val("");
            $(".bairro").val("");
            $(".cidade").val("");
        }

        //Quando o campo cep perde o foco.
        $(".cep").blur(function() {

          //Nova variável "cep" somente com dígitos.
          var cep = $(this).val().replace(/\D/g, '');

          //Verifica se campo cep possui valor informado.
          if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

              //Preenche os campos com "..." enquanto consulta webservice.
              $(".logra").val("...");
              $(".bairro").val("...");
              $(".cidade").val("...");

                //Consulta o webservice viacep.com.br/
              $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                  //Atualiza os campos com os valores da consulta.
                  $(".logra").val(dados.logradouro);
                  $(".bairro").val(dados.bairro);
                  $(".cidade").val(dados.localidade);
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
    <?php chamaMenuOffCanvas(); ?>
    <header>
      <?php chamaCabecalho(); ?>
    </header>
    <section id="conteudo">

      <div class="botoes">
        <div class="tipo jur">
          Pessoa Jurídica
        </div>
        <div class="tipo fis">
          Pessoa Física
        </div>
      </div>
      <?php modalLogin(); ?>
      <?php
        if (isset($_POST['rdoTipo'])) {
          $tipo = $_POST['rdoTipo'];
          if ($tipo == "juridico") {
            autenticarClienteJuridicoParaOSite();
          }elseif($tipo == "fisico"){
            autenticarClienteFisicoParaOSite();
          }
        }
      ?>

      <div class="pessoa juridica">
        <form action="cad_pessoa.php" method="post" enctype="multipart/form-data">
          <fieldset class="dadosGenericos emp">
            <legend>Dados da Empresa</legend>

            <div class="textoInput">
              <p class="texto">Razão Social*</p>
              <input class="campo" type="text" name="txtRazao" value="" maxlength="5" required>
            </div>
            <div class="textoInput">
              <p class="texto">Nome Fantasia</p>
              <input class="campo" type="text" name="txtFantasia" value="">
            </div>
            <div class="textoInput cn">
              <p class="texto">CNPJ*</p>
              <input class="campo cnpj" type="text" name="txtCnpj" value="" required>
            </div>
            <div class="textoInput ies">
              <p class="texto">Inscrição Estadual</p>
              <input class="campo ie" type="text" name="txtIe" value="">
            </div>
            <div class="textoInput email">
              <p class="texto">E-mail*</p>
              <input class="campo ema" type="email" name="txtEmail" value="" required>
            </div>
						<div class="textoInput telefone">
              <p class="texto">Telefone*</p>
              <input class="campo tel" type="text" name="txtTelefone" value="" required>
            </div>
            <div class="textoInput cep">
              <p class="texto">CEP*</p>
              <input class="campo cep" type="text" name="txtCep" value="" required>
            </div>
            <div class="textoInput logra">
              <p class="texto">Logradouro*</p>
              <input class="campo logra" type="text" name="txtLogradouro" value="" required>
            </div>
            <div class="textoInput bairro">
              <p class="texto">Bairro*</p>
              <input class="campo bairro" type="text" name="txtBairro" value="" required>
            </div>
            <div class="textoInput numero">
              <p class="texto">N°*</p>
              <input class="campo numero" type="number" name="txtNumero" value="" required>
            </div>
            <div class="textoInput cidade">
              <p class="texto">Cidade*</p>
              <input class="campo cidade" type="text" name="txtCidade" value="" required>
            </div>
            <div class="textoInput slcEstado">
              <p class="texto">UF*</p>
              <select class="slcEstado" name="slcEstado">

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

            <div class="imgCliente">
              <img id="imgCliente" src="" alt="">

            </div>
            <div class="nomeArquivo">
              <span id="spanNome"></span>
              <img src="img/camera.png" alt="">
              <input id="file" type="file" name="fleimagem" value="" onchange="readURL(this,'imgCliente');">
            </div>

          </fieldset>

          <fieldset class="dadosAcesso">
            <legend>Dados de acesso</legend>

            <div class="textoInput acesso">
              <p class="texto">Login</p>
              <input class="campo login" type="email" name="txtLogin" value="" required>
            </div>
            <div class="textoInput acesso">
              <p class="texto">Senha</p>
              <input class="campo senha" type="password" name="txtSenha" value="">
            </div>
            <div class="textoInput acesso">
              <p class="texto">Confirmar senha</p>
              <input class="campo conf" type="password" name="txtConfSenha" value="" required>
            </div>
          </fieldset>

					<input class="btnCadastrar" type="submit" name="btnPessoaJuridica" value="Cadastrar">
        </form>
      </div>

      <div class="pessoa fisica">
        <form action="cad_pessoa.php" method="post">
          <fieldset class="dadosGenericos pess">
            <legend>Dados Pessoais</legend>

            <div class="textoInput nome">
              <p class="texto">Nome*</p>
              <input class="campo nome" type="text" name="txtNome" value="" required>
            </div>
            <div class="textoInput email">
              <p class="texto">E-mail*</p>
              <input class="campo ema" type="email" name="txtEmailFisico" value="" required>
            </div>
            <div class="textoInput telefone">
              <p class="texto">Celular*</p>
              <input class="campo tel" type="text" name="txtCelular" value="" required>
            </div>
          </fieldset>

          <fieldset class="dadosAcesso">
            <legend>Dados de acesso</legend>

            <div class="textoInput acesso">
              <p class="texto">Login</p>
              <input class="campo login" type="email" name="txtLoginFisico" value="" required>
            </div>
            <div class="textoInput acesso">
              <p class="texto">Senha</p>
              <input class="campo senha" type="password" name="txtSenhaFisico" value="" required>
            </div>
            <div class="textoInput acesso">
              <p class="texto">Confirmar senha</p>
              <input class="campo conf" type="password" name="txtConfSenhaFisico" value="" required>
            </div>
          </fieldset>

					<input class="btnCadastrar" type="submit" name="btnPessoaFisica" value="Cadastrar">
        </form>
      </div>

    </section>
    <?php
      chamaRodape();
     ?>
    <script type="text/javascript" src="js/scrollToFixed.js"></script>
    <script type="text/javascript">
      $(".baixo").scrollToFixed();
    </script>
  </body>
</html>
