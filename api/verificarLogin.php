<?php

include_once('conexaoMysqli.php');
login();


function login(){

  global $connect;

  $login = $_POST['login'];
  $senha = $_POST['senha'];

  $sql = "SELECT * FROM tblclientefisico WHERE login = '$login' and senha = '$senha'";

  $resultado = mysqli_query($connect, $sql);

  $numero_de_linhas = mysqli_num_rows($resultado);

  $lista = array();

  if($numero_de_linhas > 0){

    while($linha = mysqli_fetch_assoc($resultado)){

      $lista[] = $linha;

    }

    echo json_encode(array('DADOS' => $lista));

    /*$id_cliente = $numero_de_linhas['id_cliente'];
    $json['LOGADO'] = $id_cliente;

    echo json_encode($json);*/

  }else{

    $json['INCORRETO'] = 'Login ou Senha Incorreto';
    echo json_encode($json);

  }

}

 ?>
