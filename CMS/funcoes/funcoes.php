<?php
  //função para ter o acesso ao banco de dados
	function conexao(){

		//conexao do php com o banco de dados
		//$conexao = mysql_connect('192.168.0.2', 'sdrink', 'SDrink@fijp2017') or die("Erro ao abrir conexão com o banco de dados!");
		//$conexao = mysql_connect('192.168.1.1', 'sdrink', 'SDrink@fijp2017') or die("Erro ao abrir conexão com o banco de dados!");
		//$conexao = mysql_connect('10.107.144.19', 'root', 'bcd127') or die("Erro ao abrir conexão com o banco de dados!");
		$conexao = mysql_connect('localhost', 'root', 'bcd127') or die("Erro ao abrir conexão com o banco de dados!");
		//$conexao = mysql_connect('localhost', 'root', '') or die("Erro ao abrir conexão com o banco de dados!");

		//seleciona o banco de onde vai pegar os dados
		mysql_select_db('dbsodadrink') or die("Erro ao selecionar o banco de dados!");
		//mysql_select_db('dbsdrink') or die("Erro ao selecionar o banco de dados!");

	}
?>

<?php
	//função para o usuário conseguir sutenticar e finalmente ir À página inicial do CMS
	function autenticarParaOCms(){

		if(isset($_POST['btnAcessar'])){

			//resgata o login e senha do usuário
			$login =$_POST['txtUser'];
			$senha = $_POST['txtSenha'];

			$criptografada = base64_encode($senha);

			//script para realizar a busca no banco de dados do usuário cujo login e senha forem iguais ao digitado pelo usuário
			$sql="SELECT u.nome, u.login, u.senha, u.id_nivel, n.descricao FROM
						tblusuario AS u INNER JOIN tblnivel AS n
						ON u.id_nivel = n.id_nivel
						WHERE (u.login = '".$login."') AND (u.senha = '".$criptografada."')";

			//executa o script no banco
			$resultado = mysql_query($sql);

			//se o numero de linhas(usuarios) que retornarem do banco de dados for menor que 1
			if (mysql_num_rows($resultado) != 1) {

				// Mensagem de erro quando os dados são inválidos e/ou o usuário não foi encontrado
				echo "<script type'text/javascript'>
 	              alert('Acesso Negado!');
 	              document.location.href = 'index.php';
 	            </script>";
			}else {

				//resultado recebe o usuário específico encontrado em $resultado
				$usuario = mysql_fetch_assoc($resultado);

				// Salva os dados encontrados na sessão;
				$_SESSION['UsuarioLogin'] = $usuario['login'];
				$_SESSION['UsuarioNome'] = $usuario['nome'];
				$_SESSION['UsuarioNivel'] = $usuario['descricao'];

				// direciona o usuário para o cms
				echo "<script type'text/javascript'>
 	              document.location.href = 'pagina_inicial.php';
 	            </script>";
			}

		}
	}

 ?>

<?php
	function chamaCabecalhoCms(){
?>

		<figure class="logo">
			<a href="pagina_inicial.php"><img src="img/logo.png" alt="SodaDrink" title="SodaDrink" id="imgLogo"></a>
		</figure>

		<div class="titulo">
			<p class="txtTitulo">Sistema de Gerenciamento de Site</p>
		</div>

		<div class="informacoes">
			<img src="img/user.png" id="imgUser" alt="Usuário" title="Usuário">
			<p id="nomeUser">
				<?php
					if(!isset($_SESSION['UsuarioNome'])){
						echo "<script type'text/javascript'>
		 	              document.location.href = 'index.php';
		 	            </script>";
					}else{
						echo $_SESSION['UsuarioNome'];
					}
				?> &#x25bc;
			</p>
			<div id="infoUser">
				<img src="img/user.png" id="imgUserInfo" alt="Usuário" title="Usuário">
				<div id="dadosUser">
					<p id="nomeUserInfo"><?php echo $_SESSION['UsuarioNome']; ?></p>
					<p id="emailUserInfo"><?php echo $_SESSION['UsuarioLogin']; ?></p>
					<p id="emailUserInfo"><?php echo $_SESSION['UsuarioNivel']; ?></p>
				</div>

				<a href="logout.php">
					<div id="logout">
						<p>Sair</p>
					</div>
				</a>
			</div>
		</div>

<?php
	}
?>

<?php

  function chamaMenu(){
?>
    <nav class="menuConteiner">
			<a href="pagina_inicial.php" title="Página Inicial">
	      <button class="accordion">
	        Página Inicial
	      </button>
			</a>
      <div class="panel">

      </div>

      <button class="accordion">Usuários</button>
      <div class="panel">
        <p class="itemSubMenu">
          <a href="crud_usuarios.php" title="Gerenciar usuários">Gerenciar usuários</a>
        </p>
        <p class="itemSubMenu">
          <a href="crud_nivel.php" title="Gerenciar níveis">Gerenciar níveis</a>
        </p>
      </div>

      <button class="accordion">Site</button>
      <div class="panel">
        <p class="itemSubMenu">Gerenciar imagens do banner</p>
				<p class="itemSubMenu">
          <a href="crud_promocoes.php" title="Editar sobre a empresa">Gerenciar promoções</a>
        </p>
				<p class="itemSubMenu">
          <a href="crud_sobre.php" title="Editar sobre a empresa">Editar sobre nós</a>
        </p>
        <p class="itemSubMenu">
          <a href="crud_fale_conosco.php" title="Gerenciar fale conosco">Fale conosco</a>
        </p>
      </div>

      <button class="accordion">Produtos</button>
      <div class="panel">
        <p class="itemSubMenu">
          <a href="crud_produtos.php" title="Gerenciar produtos">Gerenciar produtos</a>
        </p>
        <p class="itemSubMenu">
          <a href="crud_categorias.php" title="Gerenciar categorias">Gerenciar categorias</a>
        </p>
				<p class="itemSubMenu">
          <a href="crud_marcas.php" title="Gerenciar marcas">Gerenciar marcas</a>
        </p>
      </div>

      <button class="accordion">Relatórios</button>
      <div class="panel">
				<p class="itemSubMenu">
          <a href="venda.php" title="Relatório de vendas">Relatório de vendas</a>
        </p>
				<p class="itemSubMenu">
          <a href="pedido.php" title="Relatório de pedidos">Acompanhar pedidos</a>
        </p>
				<p class="itemSubMenu">
          <a href="#" title="Produtos mais vendidos">Produtos mais vendidos</a>
        </p>
      </div>

      <button class="accordion">Clientes</button>
      <div class="panel">
				<p class="itemSubMenu">
          <a href="crud_clientes.php" title="Verificar clientes">Nossos clientes</a>
        </p>
      </div>

    </nav>
<?php
}
?>

<?php
	function chamaAprovacao(){
 ?>
		<div class="cont_aprovacoes">
			<div class="conteinerTitulo">
			 <p id="tituloAprovacao">Solicitações dos usuários</p>
			 <img src="img/notificacao.png" id="imgNotificacao" alt="Notificações" title="Notificações">
			</div>

      <button class="accordion2">Produtos</button>
      <div class="panel2">
				<?php

					$resultSet = mysql_query("SELECT * FROM tblproduto WHERE aprovado = 0");

					while ($produto = mysql_fetch_array($resultSet)) {
				?>
						<p class="itemSubMenu2">
							<?php echo $produto['nome']; ?>
							<a href="?aprovar=produto&id=<?php echo $produto['id_produto']; ?>">
								<img src="img/atencao.png" onmouseover="trocarImagem(this);" onmouseout="voltarImagem(this);" style="float:right; margin-right:50px; width:25px; height:25px;" alt="" title="Aprovar esta solicitação">
							</a>
						</p>
				<?php
					}
				 ?>
      </div>

      <button class="accordion2">Categoria</button>
			<div class="panel2">
				<?php

					$resultSet = mysql_query("SELECT * FROM tblcategoria WHERE aprovado = 0");

					while ($categoria = mysql_fetch_array($resultSet)) {
				?>
						<p class="itemSubMenu2">
							<?php echo $categoria['descricao']; ?>
							<a href="?aprovar=categoria&id=<?php echo $categoria['id_categoria']; ?>">
								<img src="img/atencao.png" onmouseover="trocarImagem(this);" onmouseout="voltarImagem(this);" style="float:right; margin-right:50px; width:25px; height:25px;" alt="" title="Aprovar esta solicitação">
							</a>
						</p>
				<?php
					}
				 ?>
      </div>

      <button class="accordion2">Marca</button>
			<div class="panel2">
				<?php

					$resultSet = mysql_query("SELECT * FROM tblmarca WHERE aprovado = 0");

					while ($marca = mysql_fetch_array($resultSet)) {
				?>
						<p class="itemSubMenu2">
							<?php echo $marca['marca']; ?>
							<a href="?aprovar=marca&id=<?php echo $marca['id_marca']; ?>">
								<img src="img/atencao.png" onmouseover="trocarImagem(this);" onmouseout="voltarImagem(this);" style="float:right; margin-right:50px; width:25px; height:25px;" alt="" title="Aprovar esta solicitação">
							</a>
						</p>
				<?php
					}
				 ?>
      </div>

      <button class="accordion2">Promoções</button>
			<div class="panel2">
				<?php

					$resultSet = mysql_query("SELECT * FROM tblpromocao WHERE aprovado = 0");

					while ($promocao = mysql_fetch_array($resultSet)) {
				?>
						<p class="itemSubMenu2">
							<?php echo $promocao['descricao']; ?>
							<a href="?aprovar=promocao&id=<?php echo $promocao['id_promocao']; ?>">
								<img src="img/atencao.png" onmouseover="trocarImagem(this);" onmouseout="voltarImagem(this);" style="float:right; margin-right:50px; width:25px; height:25px;" alt="" title="Aprovar esta solicitação">
							</a>
						</p>
				<?php
					}
				 ?>
      </div>

		</div>

		<script type="text/javascript">

		function trocarImagem(imagem) {
			$(imagem).mouseover(function () {

				$(this).attr('src', 'img/aprovar.png');
				$(this).css('cursor', 'pointer');
			});
		}
		function voltarImagem(imagem) {
			$(imagem).mouseleave(function () {

				$(this).attr('src', 'img/atencao.png');

			});
		}

		var acc = document.getElementsByClassName("accordion2");
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
<?php
	}
?>
<?php

	function aprovar(){



	}

?>
