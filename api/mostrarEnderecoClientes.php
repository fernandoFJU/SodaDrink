<?php

  include_once('conexaoMysqli.php');
  mostrarEnderecoClientes();

function mostrarEnderecoClientes(){

  global $connect;

  $sql = "SELECT * FROM tblclientejuridico";

  $resultado = mysqli_query($connect,$sql);

  $numero_de_linha = mysqli_num_rows($resultado);

  $lista = array();

  if($numero_de_linha > 0){

    while($linha = mysqli_fetch_assoc($resultado)){

      $lista[] = $linha;

    }

    header('Content-Type: application/json');
    echo json_encode(array("ENDERECOS" => $lista));
    mysqli_close($connect);

  }


}

 ?>
