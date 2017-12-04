
<?php
  require_once("funcoes/funcoes.php");
  conexao();

  $id_cliente = "";

  $id_cliente = $_POST["id_cliente_juridico"];

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


    <?php

      //Variavel que recebe o script para selecionar todos os clientes dos clientes
      $sql="SELECT * FROM tblclientejuridico where id_cliente=".$id_cliente;
      //comando que executará este script, que será armazenado na variavel $select
      $select = mysql_query($sql);

      $cor = "";
      //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os dados de cada comentario guardado no banco e mostrá-los na tela:
      while ($rs = mysql_fetch_array($select))
      {
    ?>
        <div class="imagem">
          <p id="imagem" >
            <img src="..\<?php echo $rs["imagem"] ?>" alt="Logo cliente" style="width:80px; height:80px;">
          </p>
        </div>

        <p class="txt">ID</p>
        <div class="texto">
          <p id="id">
            <?php echo $rs["id_cliente"] ?>
          </p>
        </div>

        <p class="txt">Razão Social</p>
        <div class="texto">
          <p><?php echo $rs["razaoSocial"] ?></p>
        </div>

        <p class="txt">Nome Fantasia</p>
        <div class="texto">
          <p><?php echo $rs["nomeFantasia"] ?></p>
        </div>

        <p class="txt">Tipo</p>
        <div class="texto">
          <p>Cliente Jurídico</p>
        </div>

        <p class="txt">E-mail</p>
        <div class="texto">
          <p><?php echo $rs["email"] ?></p>
        </div>

        <p class="txt">Telefone</p>
        <div class="texto">
          <p><?php echo $rs["telefone"] ?></p>
        </div>
    <?php
      }
     ?>
  </div>
</div>
