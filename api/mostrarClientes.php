<?php

//if($_SERVER["REQUEST_METHOD" == "POST"]){

  include_once('conexaoMysqli.php');
  mostrarCliente();

//}

function mostrarCliente(){

  global $connect;

  $sql = "SELECT * FROM tblclientefisico;";

  $resultado = mysqli_query($connect,$sql);

  $numero_de_linhas = mysqli_num_rows($resultado);

  $lista = array();

  if($numero_de_linhas > 0){

    while ($linha = mysqli_fetch_assoc($resultado)) {

      $lista[] = $linha;

    }

    header('Content-Type: application/json');
    echo json_encode(array("CLIENTES" => $lista));
    mysqli_close($connect);

  }

}

 ?>
