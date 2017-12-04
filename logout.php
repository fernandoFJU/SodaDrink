<?php
	session_start();
	unset( $_SESSION['ClienteNome'] );
	unset( $_SESSION['ClienteFisNome'] );

  header("location: index.php");
?>
