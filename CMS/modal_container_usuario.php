<?php
  require_once("funcoes/funcoes.php");
  conexao();

  $id_usuario = "";
  //variavel criada para alterar o value do botao Cadastrar, para o usuário perceba o que está pestes a fazer
	$botao = "Cadastrar";
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

  $id_usuario = $_POST["id_usuario"];

  //script para localizar o nivel específico
  $sql = "select * from tblusuario where id_usuario = ".$id_usuario;
  //executa o script no banco e guarda na variavel select

  $select = mysql_query($sql);
  //converte o resutado do banco em matriz
  $rs = mysql_fetch_array($select);

  $nome = $rs['nome'];
  $cpf = $rs['cpf'];
  $nascimento = $rs['dtNascimento'];
  $email = $rs['email'];
  $telefone = $rs['telefone'];
  $sexo = $rs['sexo'];
  $estado = $rs['id_estado'];
  $cep = $rs['cep'];
  $logradouro =$rs['logradouro'];
  $bairro = $rs['bairro'];
  $cidade = $rs['cidade'];
  $numero = $rs['numero'];
  $nivel = $rs['id_nivel'];
  $login = $rs['login'];
  $senha = $rs['senha'];

  if (isset($_POST['btnAtualizar'])) {

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

    $sql = "UPDATE tblusuario set nome = '".$nome."',
								   cpf = '".$cpf."',
								   dtNascimento = '".$nascimento."',
								   email = '".$email."',
								   telefone = '".$telefone."',
								   sexo = '".$sexo."',
								   id_estado = ".$estado.",
								   cep = '".$cep."',
								   logradouro = '".$logradouro."',
								   bairro = '".$bairro."',
								   cidade = '".$cidade."',
								   numero = ".$numero.",
								   id_nivel = ".$nivel.",
								   login = '".$login."',
								   senha = '".$senha."'
                   where id_usuario = ".$id_usuario ;

    mysql_query($sql);

    echo ("<script>location.reload();</script>");

  }

?>

<script type="text/javascript">
  $(function(){
    $('#fechar').click(function() {
      $(".modalConteiner").fadeOut();
    });
    $(document).keyup(function(e) {
      if (e.keyCode == 27) {
        $(".modalConteiner").fadeOut();
      }

    });
  });
</script>

<div class="caixaModal">
  <div class="modalHeader">
    <p>Atualizar Usuário</p>
    <img src="img/close.png" id="fechar" alt="Fechar" title="Fechar">
  </div>

  <div class="modalContent">
    <form class="frmCadastro" action="" method="post">

      <fieldset id="dadosPessoais">

        <legend>Dados Pessoais</legend>

        <div id="textoInputNome">
          <p class="texto">Nome</p>
          <input id="nome" type="text" name="txtNome" value="<?php echo($nome); ?>" required>
        </div>

        <div id="textoInputCpf">
          <p class="texto">CPF</p>
          <input id="cpf" type="text" name="txtCpf" value="<?php echo($cpf); ?>" required>
        </div>

        <div id="textoInputTelefone">
          <p class="texto">Telefone</p>
          <input id="telefone" type="text" name="txtTelefone" value="<?php echo($telefone); ?>" required>
        </div>

        <div id="textoInputNascimento">
          <p class="texto">Nascimento</p>
          <input id="nascimento" type="text" name="txtNascimento" value="<?php echo($nascimento); ?>" required>
        </div>

        <div id="textoInputEmail">
          <p class="texto">E-mail</p>
          <input id="email" type="text" name="txtEmail" value="<?php echo($email); ?>" required>
        </div>

        <div id="textoInputSexo">
          <p class="texto">Sexo</p>
          <input class="sex" type="radio" name="sexo" value="M" checked>Masculino
          <input class="sex" type="radio" name="sexo" value="F">Feminino
        </div>

        <div id="textoInputUf">
          <p class="texto">UF</p>
          <select class="slcUf" name="slcEstado" required>
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

        <div id="textoInputLogra">
          <p class="texto">Logradouro</p>
          <input id="logradouro" type="text" name="txtLogradouro" value="<?php echo($logradouro); ?>" required>
        </div>

        <div id="textoInputNumero">
          <p class="texto">N°</p>
          <input id="numero" type="number" name="txtNumero" value="<?php echo($numero); ?>" required>
        </div>

        <div id="textoInputCep">
          <p class="texto">CEP</p>
          <input id="cep" type="text" name="txtCep" value="<?php echo($cep); ?>" required>
        </div>

        <div id="textoInputCidade">
          <p class="texto">Cidade</p>
          <input id="cidade" type="text" name="txtCidade" value="<?php echo($cidade); ?>" required>
        </div>

        <div id="textoInputBairro">
          <p class="texto">Bairro</p>
          <input id="bairro" type="text" name="txtBairro" value="<?php echo($bairro); ?>" required>
        </div>

      </fieldset>

      <fieldset id="dadosProfissionais">

        <legend>Dados Profissionais</legend>

        <div id="textoInputUsuario">
          <p class="texto">Usuário</p>
          <input id="usuario" type="text" name="txtLogin" value="<?php echo($login); ?>" required>
        </div>

        <div id="textoInputSenha">
          <p class="texto">Senha</p>
          <input id="senha" type="password" name="txtSenha" value="<?php echo($senha); ?>" required>
        </div>

        <div id="textoInputConfirmar">
          <p class="texto">Confirmar senha</p>
          <input id="confirmar" type="password" name="" value="<?php echo($senha); ?>" required>
        </div>

        <div id="textoInputNivel">
          <p class="texto">Nível</p>
          <select class="slcNivel" name="slcNivel" required>
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

      <input class="botao" type="submit" name="btnAtualizar" value="Atualizar">
      <input class="botao limpar" type="reset" name="" value="Limpar">

    </form>
  </div>
</div>
