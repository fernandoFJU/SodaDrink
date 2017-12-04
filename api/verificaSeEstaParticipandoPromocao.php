<?php

session_start();
include_once('conexaoMysqli.php');
mostrarPromocoes();

function mostrarPromocoes(){

  global $connect;

  $id_promocao = $_POST['id_promocao'];

  $sql = "SELECT p.* FROM tblpromocao as p INNER JOIN tblclientepromocao as cp WHERE p.id_promocao = cp.id_promocao and cp.id_promocao = '$id_promocao'";

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

  }

}


 ?>
