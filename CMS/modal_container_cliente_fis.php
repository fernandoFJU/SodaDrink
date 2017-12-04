
<?php
  require_once("funcoes/funcoes.php");
  conexao();

  $id_cliente = "";

  $id_cliente = $_POST["id_cliente_fisico"];

?>

<script type="text/javascript">
  $(function(){
    $('#fechar').click(function() {
      $(".modalConteiner").fadeOut();
    });
    $(document).keyup(function(e) {
      if (e.keyCode == 27) {
        $(".modalConteiner").fadeOut();
      }
    });
  });
</script>
<div class="caixaModal">
  <div class="modalHeader">
    <p>Informações do cliente</p>
    <img src="img/close.png" id="fechar" alt="Fechar" title="Fechar">
  </div>

  <div class="modalContent">

    <p class="txt">ID</p>
    <?php

      //Variavel que recebe o script para selecionar todos os clientes dos clientes
      $sql="SELECT * FROM tblclientefisico where id_cliente=".$id_cliente;
      //comando que executará este script, que será armazenado na variavel $select
      $select = mysql_query($sql);

      $cor = "";
      //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os dados de cada comentario guardado no banco e mostrá-los na tela:
      while ($rs = mysql_fetch_array($select))
      {
    ?>
        <div class="texto">
          <p id="id">
            <?php echo $rs["id_cliente"] ?>
          </p>
        </div>



        <p class="txt">Nome</p>
        <div class="texto">
          <p><?php echo $rs["nome"] ?></p>
        </div>

        <p class="txt">Tipo</p>
        <div class="texto">
          <p>Cliente Físico</p>
        </div>

        <p class="txt">E-mail</p>
        <div class="texto">
          <p><?php echo $rs["email"] ?></p>
        </div>

        <p class="txt">Celular</p>
        <div class="texto">
          <p><?php echo $rs["celular"] ?></p>
        </div>
    <?php
      }
     ?>
  </div>
</div>
