<?php

//if($_SERVER["REQUEST_METHOD" == "POST"]){

  include_once('conexaoMysqli.php');
  editarCliente();

//}

function editarCliente(){

  global $connect;

  $id_cliente = $_POST['id_cliente'];

  $nome = $_POST['nome'];
  $login = $_POST['login'];
  $senha = $_POST['senha'];
  $celular = $_POST['celular'];
  $email = $_POST['email'];

  $sql = "UPDATE tblclientefisico SET nome = '$nome', login = '$login', senha = '$senha', celular = '$celular', email = '$email' WHERE id_cliente = '$id_cliente'";

  mysqli_query($connect,$sql);
  mysqli_close($connect);

}

 ?>
