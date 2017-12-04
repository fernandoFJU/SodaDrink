<?php

include_once('conexaoMysqli.php');
mostrarPromocoes();

function mostrarPromocoes(){

  global $connect;

  $sql = "SELECT * FROM tblpesquisa";

  $resultado= mysqli_query($connect, $sql);

  $numero_de_linhas = mysqli_num_rows($resultado);

  $lista = array();

  if($numero_de_linhas > 0){

    while($linha = mysqli_fetch_assoc($resultado)){

      $lista[] = $linha;

    }

    header('Content-Type: application/json');
    echo json_encode(array('RESULTADO' => $lista));
    mysqli_close($connect);


  }

}


 ?>
