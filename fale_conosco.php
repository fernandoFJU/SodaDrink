<?php
  //chama-se o arquivo com a conexão com o banco de dados
  require_once("funcoes/funcoes.php");
  conexao();

  //criando variaveis vazias que futuramente receberão o conteudo que o usuário fornecer
  $nome = "";
  $telefone = "";
  $celular = "";
  $email = "";
  $comentario = "";
  $tipo = "";

  //se existir o clique do botão enviar executará:
  if (isset($_POST["btnEnviar"])) {
    //as variaveis anteriormente criadas recebem o conteudo que o usuário forneceu
    $nome = $_POST["txtNome"];
    $telefone = $_POST["txtTelefone"];
    $celular = $_POST["txtCelular"];
    $email = $_POST["txtEmail"];
    $comentario = $_POST["txtComentario"];
    $tipo = $_POST["tipo"];

    //em seguida as informaçoes serão guardadas no banco de dados
    $sql = "INSERT INTO tblfaleconosco(nome, email, telefone, celular, comentario, tipo)
            VALUES('".$nome."', '".$email."', '".$telefone."', '".$celular."', '".$comentario."', '".$tipo."');";

    //comando que executa um comando no mysql, neste caso será uma inserção, que ficará guardado numa variavel que servirá para um tratamento de erro
    $resultado = mysql_query($sql);
    //se a inserção no banco de dados não acontecer mostrará ao cliente uma mensagem de erro
    if (! $resultado) {
      die("Erro ao enviar mensagem!".mysql_error());
      exit();
    }else{
      //caso contrario redirecionará o cliente para a mesma pagina mostrando uma mensagem de sucesso
      echo "<script type'text/javascript'>
              alert('Mensagem enviada com sucesso!');
            </script>";
    }

  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Fale Conosco</title>
    <link rel="stylesheet" media="all" href="css/fale_conosco.css">
    <link rel="stylesheet" media="all" href="css/index.css">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jMaskedInput.js"></script>
    <script type="text/javascript" src="js/logo.js"></script>
    <script type="text/javascript" src="js/menuOffCanvas.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				$(".tel").mask("(99) 9999-9999", {placeholder:" "});
				$(".cel").mask("(99) 99999-9999", {placeholder:" "});

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

  </head>
  <body>
    <?php chamaMenuOffCanvas(); ?>

    <header>
      <?php chamaCabecalho(); ?>
    </header>
    <section id="conteudo1">

      <div id="titulo">
        <h1 id="txtFale">Fale Conosco</h1>
        <p id="texto">Para enviar sua mensagem, escolha se é crítica ou sugestão, preencha o formulário e clique em enviar mensagem.</p>

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

      <div id="dados">
        <form  action="fale_conosco.php" method="post">
          <input class="radio" id="rdoCritica" type="radio" name="tipo" value="c" checked>
          <label for="rdoCritica">Crítica</label>
          <input class="radio" id="rdoSugestao" type="radio" name="tipo" value="s">
          <label for="rdoSugestao">Sugestão</label>

          <p class="txt nome">Nome*</p>
          <input class="entrada" type="text" name="txtNome" value="" required>
          <p class="txt">E-mail*</p>
          <input class="entrada" type="email" name="txtEmail" value="" required>
          <p class="txt">Telefone*</p>
          <input class="entrada tel" type="text" name="txtTelefone" value="" required>
          <p class="txt celu">Celular</p>
          <input class="entrada cel" type="text" name="txtCelular" value="">

          <div id="textoTextarea">
            <p class="txt area">Comentário*</p>
            <textarea name="txtComentario" maxlength="255" required></textarea>
          </div>

          <input id="btnEnviar" type="submit" name="btnEnviar" value="Enviar Mensagem">
        </form>
      </div>

      <div id="info">
        <p>Av. Luiz Carlos Berrini, 115</p>
        <p>Brooklin Novo, São Paulo-SP</p>
        <p>CEP: 04571-010</p>
        <p>TEL. (11) 7785-3365</p>
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
