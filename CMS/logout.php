<?php
	session_start();
	unset( $_SESSION['UsuarioNome'] );
  header("location: index.php");
?>
