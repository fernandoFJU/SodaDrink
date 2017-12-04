<?php
//sleep(5);

//if($_SERVER["REQUEST_METHOD" == "POST"]){

  include_once('conexaoMysqli.php');
  mostrarCliente();

//}

function mostrarCliente(){

  global $connect;

  $sql = "SELECT p.*,c.descricao as nomeCategoria,m.marca as nomeMarca FROM tblproduto as p INNER JOIN tblcategoria as c INNER JOIN tblmarca as m WHERE p.id_categoria = c.id_categoria and p.id_marca = m.id_marca;";

  $resultado = mysqli_query($connect,$sql);

  $numero_de_linhas = mysqli_num_rows($resultado);

  $lista = array();

  if($numero_de_linhas > 0){

    while ($linha = mysqli_fetch_assoc($resultado)) {

      $lista[] = $linha;

    }

    header('Content-Type: application/json');
    echo json_encode(array("PRODUTOS" => $lista));
    mysqli_close($connect);

  }

}

 ?>
