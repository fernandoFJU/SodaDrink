
<?php
  require_once("funcoes/funcoes.php");
  conexao();

  $id_comentario = "";

  $id_comentario = $_POST["id_comentario"];

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
    <p>Informações do comentário</p>
    <img src="img/close.png" id="fechar" alt="Fechar" title="Fechar">
  </div>

  <div class="modalContent">

    <p class="txt">ID</p>
    <?php

      //Variavel que recebe o script para selecionar todos os comentarios dos clientes, ordenando-os pelo ID de forma decrescente.
      $sql="SELECT * FROM tblfaleconosco where id_fale_conosco=".$id_comentario;
      //comando que executará este script, que será armazenado na variavel $select
      $select = mysql_query($sql);

      $cor = "";
      //Essa estrutura de repetição transforma o resultado do banco de dados que foi armazenado na variavel $select numa matriz e guarda a matriz na variavel $rs(ResultSet). Assim sendo, será possivel resgatar os dados de cada comentario guardado no banco e mostrá-los na tela:
      while ($rs = mysql_fetch_array($select))
      {
    ?>
        <div class="texto">
          <p id="id">
            <?php echo $rs["id_fale_conosco"] ?>
          </p>
        </div>



        <p class="txt">Nome</p>
        <div class="texto">
          <p><?php echo $rs["nome"] ?></p>
        </div>

        <p class="txt">E-mail</p>
        <div class="texto">
          <p><?php echo $rs["email"] ?></p>
        </div>

        <p class="txt">Telefone</p>
        <div class="texto">
          <p><?php echo $rs["telefone"] ?></p>
        </div>

        <p class="txt">Celular</p>
        <div class="texto">
          <p><?php echo $rs["celular"] ?></p>
        </div>

        <p class="txt">Tipo do comentário</p>
        <div class="texto">
          <p>
            <?php
              //Se o valor que retornar do campo tipo for C então mostrará Critica, caso contrario, mostrará Sugestão
              if ($rs['tipo'] == "c") {
                echo("Crítica");
              }else {
                echo ("Sugestão");
              }
            ?>
          </p>
        </div>

        <p class="txt">Comentário</p>
        <div class="texto">
          <p><?php echo $rs["comentario"] ?></p>
        </div>
    <?php
      }
     ?>
    <a href="crud_fale_conosco.php?excluir&id=<?php echo($id_comentario);?>">
      <div class="excluir">
        Excluir
      </div>
    </a>
  </div>
</div>
