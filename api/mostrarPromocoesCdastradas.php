<?php

session_start();
include_once('conexaoMysqli.php');
mostrarPromocoes();

function mostrarPromocoes(){

  global $connect;

  //$id_cliente = $_SESSION['id_cliente'];
  $id_cliente = $_POST['id_cliente'];

  //$sql = "SELECT * from tblpromocao";
  $sql = "SELECT p.* FROM tblpromocao as p INNER JOIN tblclientepromocao as cp WHERE p.id_promocao = cp.id_promocao and id_cliente_fisico = '$id_cliente'";

  $resultado= mysqli_query($connect, $sql);

  $numero_de_linhas = mysqli_num_rows($resultado);

  $lista = array();

  if($numero_de_linhas > 0){

    while($linha = mysqli_fetch_assoc($resultado)){

      $lista[] = $linha;

    }

    header('Content-Type: application/json');
    echo json_encode(array('PROMOCAO' => $lista));
    mysqli_close($connect);
    //session_destroy();

  }

}


 ?>
