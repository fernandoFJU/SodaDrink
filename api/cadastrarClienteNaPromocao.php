<?php

include_once('conexaoMysqli.php');
cadastrarClienteNaPromocao();

function cadastrarClienteNaPromocao(){

  global $connect;

  $id_cliente_fisico = $_POST['id_cliente_fisico'];
  $id_promocao = $_POST['id_promocao'];

  $sql = "INSERT INTO tblclientepromocao(id_cliente_fisico,id_promocao)values('$id_cliente_fisico','$id_promocao')";

  mysqli_query($connect,$sql) or die (mysqli_error($connect));

  mysqli_close($connect);

}

 ?>
