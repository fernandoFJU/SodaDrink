<?php
  session_start();
  require_once("funcoes/funcoes.php");
  //chamada da função para conectar com o banco de dados
  conexao();
  autenticarParaOCms();

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Acesso ao Gerenciamento do Site</title>
    <link rel="stylesheet" href="css/index.css">
  </head>
  <body>

    <section>
      <div class="conteiner">

        <div id="login">
          <h1 id="bemVindo">Seja Bem-Vindo</h1>
          <p class="texto">Identifique-se por favor para ter acesso ao <b>Gerenciamento do Site SodaDrink</b></p>
          <form action="" method="post">

            <p class="texto usu">Usuário*</p>
            <input type="text" class="campo" name="txtUser" value="" required>

            <p class="texto senha">Senha*</p>
            <input type="password" class="campo" name="txtSenha" value="" required>

            <input type="submit" class="btnAcessar" name="btnAcessar" value="Acessar">
            <a href="../index.php">
              <input type="button" class="btnVoltar" name="btnVoltar" value="Voltar">
            </a>
          </form>
        </div>
        <div id="logo">
          <img class="imgLogo" src="img/logo.png" alt="">
        </div>

      </div>
    </section>

  </body>
</html>
