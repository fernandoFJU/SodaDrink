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
	function chamaCabecalho(){
?>
<div id="cabecalho">
<div class="ParteDeCimaDoCabecalho">
	<div class="iconeMenu">
		<img id="imagemLogo"src="img/menu.png" alt="">
	</div>
	<div id="divLogo">
		<a href="index.php"><img id="imgLogo" src="img/logo.png" alt="SodaDrink"></a>
		<div class="ola">
			<p>
				Olá, <?php
								if (isset($_SESSION['ClienteNome'])) {
									echo $_SESSION['ClienteNome'];
								}elseif(isset($_SESSION['ClienteFisNome'])){
									echo $_SESSION['ClienteFisNome'];

								}else{
									echo "Cliente";
								}
							?>
				<a href="logout.php">
					<img src="img/logout.png" width="25" height="25" style="position:relative; top:7px; cursor:pointer;" alt="">
				</a>
			</p>
		</div>
	</div>
	<div class="divloginResponsivo">
		<div class="DivIconUsuarioResponsivo">
			<img class="IconUsuarioResponsivo" src="img/userimg.png" alt="usuarioLogin">
		</div>
	</div>
	<div class="DivDireitaCabecalho">

		<div class="divlogin">
			<div class="DivIconUsuario">
				<img class="IconUsuario" src="img/userimg.png" alt="usuarioLogin">
			</div>
			<div class="DivEntrarCadastrar">
					<span class="textoEntrar">Entre ou Cadastre-se</span>
			</div>
		</div>
		<?php
				if (isset($_SESSION['ClienteNome'])) {
					echo "<div class='DivCarrinhoCompras' style='display:inline;'>
									<a href='carrinho.php'>
										<img class='iconCarrinho' src='img/carrinho.png' alt='Carrinho'>
									</a>
								</div>";
				}
			 ?>

	</div>
	</div>
	<div class="ParteDeBaixoCabecalho">
		<div class="DivMenu">
				 <div class="ItemMenu PrimeiroItem">
					 	<a href="index.php"><p class="TextoMenuDecoracao">Home</p></a>
				 </div>
				 <div class="ItemMenu">
					 	<a href="promocoes.php"><p class="TextoMenuDecoracao">Promoções</p></a>
				 </div>
				 <div class="ItemMenu">
					 	<a href="onde_comprar.php"><p class="TextoMenuDecoracao">Onde Comprar</p></a>
				 </div>
				 <div class="ItemMenu">
					 	<a href="bebidas.php"><p class="TextoMenuDecoracao">Bebidas</p></a>
				 </div>
		</div>
	</div>


<?php
}
?>

 <?php
	function chamaMenuOffCanvas(){
?>
		<div class="background"></div>

		<nav class="menuOffCanvas">

			<div id="informacoes">
				<p id="txtBemVindo">Olá</p>
				<p id="nomeCliente">
					<?php
						if (isset($_SESSION['ClienteNome'])) {
							echo $_SESSION['ClienteNome'];
						}elseif(isset($_SESSION['ClienteFisNome'])){
							echo $_SESSION['ClienteFisNome'];

						}else{
							echo "Cliente";
						}
					?>
				</p>
			</div>
			<div id="menuVertical">
				<div class="itemMenuOffCanvas">
					<a href="index.php">
						Home
					</a>
				</div>
				<div class="itemMenuOffCanvas">
					<a href="promocoes.php">
						Promoções
					</a>
				</div>
				<div class="itemMenuOffCanvas">
					<a href="onde_comprar.php">
						Onde Comprar
					</a>
				</div>
				<div class="itemMenuOffCanvas">
					<a href="bebidas.php">
						Bebidas
					</a>
				</div>
				<?php
					if (isset($_SESSION['ClienteNome'])) {
						echo "<div class='itemMenuOffCanvas' style='display:block;'>
										<a href='carrinho.php'>
											Carrinho
										</a>
									</div>";
					}else{
					echo "<div class='itemMenuOffCanvas' style='display:none;'>
									<a href='carrinho.php'>
										Carrinho
									</a>
								</div>";
					}
				?>

				<div class="itemMenuOffCanvas">
					<a href="sobre.php">
						Sobre Nós
					</a>
				</div>
				<div class="itemMenuOffCanvas">
					<a href="fale_conosco.php">
						Fale Conosco
					</a>
				</div>
				<div class="itemMenuOffCanvas">
					<a href="logout.php">
						Sair
					</a>
				</div>
			</div>

		</nav>

<?php
	}
?>

<?php
	function chamaRodape(){
 ?>
 		<div class="DivNewsLetter">
			<div class="RecebaNossasNovidades">
					Quer ficar por dentro de tudo que há de novo? Assine nossa NewsLetter!!!
			</div>
			<div class="FormularioNewsLetter">
				<form action="index.php" method="post">
					<p>
						<input class="input" type="text" name="txtNomeNewletter" value="" placeholder="Seu Nome">
					</p>
					<p>
						<input class="input" type="email" name="txtEmailNewletter" value="" placeholder="Seu e-mail">
					</p>
					<p>
						<input id="btnOk" type="submit" name="btnOk" value="OK">
					</p>
				</form>
			</div>

 		</div>
		<footer id="rodape">

			<div id="rodapeCima">
				<div id="siga">
					<p id="txtSiga">Continue Conosco </p>
					<div class="redes">
						<img class="rede" src="img/faceIcon.png" alt="">
						<img class="rede" src="img/gplusIcon.png" alt="">
						<img class="rede" src="img/twitterIcon.png" alt="">
					</div>
				</div>
				<div id="baixar">
					<p id="txtBaixe">Baixe nosso App</p>
					<a href="api/SodaDrink.apk">
						<img id="gplay" src="img/gplay.png" alt="">
					</a>
				</div>
				<ul id="mapa">
					<li><a href="home.php">Home</a></li>
					<li><a href="promocoes.php">Promoções</a></li>
					<li><a href="bebidas.php">Bebidas</a></li>
					<li><a href="onde_comprar.php">Onde comprar</a></li>
					<li><a href="sobre.php">Sobre nós</a></li>
					<li><a href="fale_conosco.php">Fale conosco</a></li>
				</ul>
			</div>

			<hr size="1" id="hrFooter">

			<div id="rodapeBaixo">
				<div id="pagamento">
					<img class="frmPagamento" src="img/visa.png" alt="">
					<img class="frmPagamento" src="img/hiper.png" alt="">
					<img class="frmPagamento" src="img/master.png" alt="">
					<img class="frmPagamento" src="img/amex.png" alt="">
					<img class="frmPagamento" src="img/boleto.png" alt="">

				</div>

				<div id="copy">
					<p id="txtCopy">© SodaDrink. Todos os direitos reservados</p>
				</div>
			</div>

			<?php
				//fecha a conexão com o banco
				mysql_close();
			?>
		</footer>
<?php
	}
?>

<?php
	function modalLogin(){
 ?>

 	<div class="modalConteiner" style="display:none;">
 		<div class="caixaModal">

 			<div class="modalHeader">
	 			<p>Entre ou Cadastre-se</p>
	 			<img src="img/close.png" id="fechar" alt="Fechar" title="Fechar">
 			</div>

 			<div class="modalContent">
				<form class="frmLogin" action="" method="post">

					<input type="radio" name="rdoTipo" value="fisico" id="rdoFis"><label for="rdoFis" class="tpCliente">Físico</label>
					<input type="radio" name="rdoTipo" value="juridico" id="rdoJur"><label for="rdoJur" class="tpCliente">Jurídico</label>

					<p class="txtDoLogin usu">Usuário</p>
					<input class="inputLoginModal" type="text" name="txtUserLogin" value="" required>

					<p class="txtDoLogin">Senha</p>
					<input class="inputLoginModal" type="password" name="txtSenhaLogin" value="" required>

					<p><input type="submit" class="btnEntrar" name="btnEntrar" value="Entrar"></p>

					<p id="txtOu">Ou</p>
					<p id="txtCadastarModal"><a href="cad_pessoa.php">Cadastre-se</a></p>
				</form>
 			</div>

 		</div>
 	</div>
<?php
}
?>

<?php
	//função para o cliente juridico conseguir autenticar-se no site
	function autenticarClienteJuridicoParaOSite(){

		if(isset($_POST['btnEntrar'])){

			//resgata o login e senha do cliente
			$login =$_POST['txtUserLogin'];
			$senha = $_POST['txtSenhaLogin'];

			$criptografada = base64_encode($senha);

			//script para realizar a busca na tabela do cliente juridico cujo login e senha forem iguais ao digitado pelo cliente
			$sql="SELECT * FROM tblclientejuridico WHERE (login = '".$login."') AND (senha = '".$criptografada."')";

			//executa o script no banco
			$resultado = mysql_query($sql);

			//se o numero de linhas(clientes) que retornarem do banco de dados for diferente de 1
			if (mysql_num_rows($resultado) != 1){

				echo "<script type'text/javascript'>
								alert('Usuário ou senha Inválidos!');
							</script>";


			}else {

				//resultado recebe o cliente específico encontrado em $resultado
				$cliente = mysql_fetch_assoc($resultado);

				// Salva os dados encontrados na sessão;
				$_SESSION['ClienteId'] = $cliente['id_cliente'];
				$_SESSION['ClienteNome'] = $cliente['nomeFantasia'];


				// cliente ja autenticado
				echo "<script type'text/javascript'>
 	              document.location.href = 'bebidas.php';
 	            </script>";

				if (isset($_SESSION['carrinho'])) {
					unset($_SESSION['carrinho']);
				}

			}
		}
	}

 ?>

 <?php
 	//função para o cliente juridico conseguir autenticar-se no site
 	function autenticarClienteFisicoParaOSite(){

 		if(isset($_POST['btnEntrar'])){

 			//resgata o login e senha do cliente
 			$login =$_POST['txtUserLogin'];
 			$senha = $_POST['txtSenhaLogin'];

			$criptografada = base64_encode($senha);
 			//script para realizar a busca na tabela do cliente fisico cujo login e senha forem iguais ao digitado pelo cliente
 			$sql="SELECT * FROM tblclientefisico WHERE (login = '".$login."') AND (senha = '".$criptografada."')";

 			//executa o script no banco
 			$resultado = mysql_query($sql);

 			//se o numero de linhas(clientes) que retornarem do banco de dados for diferente de 1
 			if (mysql_num_rows($resultado) != 1){

 				echo "<script type'text/javascript'>
 								alert('Usuário ou senha Inválidos!');
 							</script>";


 			}else {

 				//resultado recebe o cliente específico encontrado em $resultado
 				$cliente = mysql_fetch_assoc($resultado);

 				// Salva os dados encontrados na sessão;
 				$_SESSION['ClienteFisId'] = $cliente['id_cliente'];
 				$_SESSION['ClienteFisNome'] = $cliente['nome'];

 				// cliente ja autenticado
 				echo "<script type'text/javascript'>
  	              document.location.href = 'index.php';
  	            </script>";

				if (isset($_SESSION['carrinho'])) {
					unset($_SESSION['carrinho']);
				}

 			}
 		}
 	}

  ?>
