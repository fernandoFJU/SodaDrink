<?php

  include_once('conexaoMysqli.php');
  cadastrarPesquisa();

function cadastrarPesquisa(){

  global $connect;

  $pergunta1 = $_POST['pergunta1'];
  $pergunta2 = $_POST['pergunta2'];
  $pergunta3 = $_POST['pergunta3'];
  $pergunta4 = $_POST['pergunta4'];
  $pergunta5 = $_POST['pergunta5'];

  $sql = "INSERT INTO tblpesquisa(pergunta1,pergunta2,pergunta3,pergunta4,pergunta5) values('$pergunta1','$pergunta2','$pergunta3','$pergunta4','$pergunta5')";

  mysqli_query($connect, $sql) or die (mysqli_error($connect));
  mysqli_close($connect);

}

 ?>
