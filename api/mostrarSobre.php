<?php

include_once('conexaoMysqli.php');
mostrarSobre();

function mostrarSobre(){

  global $connect;

  $sql = "SELECT * FROM tblsobre;";

  $resultado = mysqli_query($connect,$sql);

  $numero_de_linhas = mysqli_num_rows($resultado);

  $lista = array();

  if($numero_de_linhas > 0){

    while($linha = mysqli_fetch_array($resultado)){

      $lista[] = $linha;

    }

    header('Content-Type: application/json');
    echo json_encode(array('SOBRE' => $lista));
    mysqli_close($connect);

  }
  
}


 ?>
