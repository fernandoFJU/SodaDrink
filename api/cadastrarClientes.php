<?php

//if($_SERVER["REQUEST_METHOD"] == "POST"){

  require_once('conexaoMysqli.php');
  criarClienteFisico();

//}

function criarClienteFisico(){

 global $connect;


 $nome = $_POST["nome"];
 $login = $_POST["login"];
 $senha = $_POST["senha"];
 $celular = $_POST["celular"];
 $email = $_POST["email"];

 $sql = "INSERT INTO tblclientefisico(nome,login,senha,celular,email,dtCadastro) values('$nome','$login','$senha','$celular','$email',NOW());";

mysqli_query($connect, $sql) or die (mysqli_error($connect));
mysqli_close($connect);

}

?>
