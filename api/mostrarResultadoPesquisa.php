<?php

include_once('conexaoMysqli.php');
mostrarPromocoes();

function mostrarPromocoes(){

  global $connect;

  $sql = "SELECT SUM(pergunta1) as totalPergunta1,SUM(pergunta2) as totalPergunta2,SUM(pergunta3) as totalPergunta3,SUM(pergunta4) as totalPergunta4,SUM(pergunta5) as totalPergunta5 FROM tblpesquisa;";

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
