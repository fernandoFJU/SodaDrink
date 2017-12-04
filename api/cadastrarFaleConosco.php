<?php

//if($_SERVER["REQUEST_METHOD"] == "POST"){

  require_once('conexaoMysqli.php');
  criarFaleConosco();

//}

function criarFaleConosco(){

 global $connect;

 $nome = $_POST["nome"];
 $email = $_POST["email"];
 $tipo = $_POST["tipo"];
 $telefone = $_POST["telefone"];
 $celular = $_POST["celular"];
 $comentario = $_POST["comentario"];

 $sql = "INSERT INTO tblfaleconosco(nome,email,tipo,telefone,celular,comentario) values('$nome','$email','$tipo','$telefone','$celular','$comentario');";

mysqli_query($connect, $sql) or die (mysqli_error($connect));
mysqli_close($connect);

}

?>
