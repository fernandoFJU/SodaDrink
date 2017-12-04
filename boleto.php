<?php

  require_once('funcoes/funcoes.php');
  conexao();

  $sql = "SELECT p.valorTotal, c.*,e.uf as estado FROM tblpedidovenda as p inner join tblclientejuridico as c on p.id_cliente = c.id_cliente inner join tblestado as e on c.id_estado = e.id_estado;";

  $select = mysql_query($sql);

  $venda = mysql_fetch_assoc($select);

  $nomeCliente = $venda['razaoSocial'];
  $cnpjCliente = $venda['cnpj'];
  $lograCliente = $venda['logradouro'];
  $cidadeCliente = $venda['cidade'];
  $estadoCliente = $venda['estado'];
  $cepCliente = $venda['cep'];

  $valorCompra = $venda['valorTotal'];

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boleto</title>
    <link rel="stylesheet" href="css/boleto.css">
  </head>
  <body>
    <div class="conteiner">

      <div class="cima">
        <div class="imagem">
          <img src="img/BB.png" alt="" id="imgBanco">
        </div>
        <div class="cod">
          234-2
        </div>
        <div class="numeracao">
          36595.22345 22152.459587 32654.854631 2 333262210054664
        </div>
      </div>

      <div class="esquerda">
        <div class="linhas">
          <p class="titulo">Local de pagamento</p>
          <p class="texto">PAGÁVEL PREFERENCIALMENTE NAS AGÊNCIAS DO BANCO DO BRASIL</p>
        </div>
        <div class="linhas">
          <p class="titulo">Cedente</p>
          <p class="texto">SodaDrink Ltda.</p>
        </div>
        <div class="linhas">
          <div class="data">
            <p class="titulo">Data do documento</p>
            <p class="texto"><?php echo date("d/m/Y"); ?></p>
          </div>
          <div class="numero">
            <p class="titulo">N° documento</p>
            <p class="texto">0000</p>
          </div>
          <div class="especie">
            <p class="titulo">Espécie doc.</p>
            <p class="texto">SD</p>
          </div>
          <div class="aceite">
            <p class="titulo">Aceite</p>
            <p class="texto">N</p>
          </div>
          <div class="processa">
            <p class="titulo">Data processamento</p>
            <p class="texto"><?php echo date("d/m/Y"); ?></p>
          </div>
        </div>
        <div class="linhas">
          <div class="uso">
            <p class="titulo">Uso do banco</p>
          </div>
          <div class="carteira">
            <p class="titulo">Carteira</p>
            <p class="texto">SR</p>
          </div>
          <div class="esp">
            <p class="titulo">Esp. Moeda</p>
            <p class="texto">R$</p>
          </div>
          <div class="quantidade">
            <p class="titulo">Qtde. moeda</p>
          </div>
          <div class="valorX">
            <p class="titulo">Valor moeda</p>
          </div>
        </div>
        <div class="linhas instrucoes">
          <p class="titulo">Instruções (Texto de responsablidade do cedente)</p>
          <p class="texto">REMOVER DESCONTO DE 5% APÓS O VENCIMENTO</p>
        </div>
      </div>

      <div class="direita">
        <div class="linhasDireita">
          <p class="titulo">Vencimento</p>
          <p class="texto dir"><?php echo date("d/m/Y"); ?></p>
        </div>
        <div class="linhasDireita">
          <p class="titulo">Agência / Código cedente</p>
          <p class="texto dir">1111-8/0002222-5</p>
        </div>
        <div class="linhasDireita">
          <p class="titulo">Nosso número</p>
          <p class="texto dir">00000001001-6</p>
        </div>
        <div class="linhasDireita">
          <p class="titulo">(=) Valor documento</p>
          <p class="texto dir"><?php echo number_format($valorCompra, 2, ",", "."); ?></p>
        </div>
        <div class="linhasDireita">
          <p class="titulo">(-) Descontos / Abatimentos</p>
          <p class="texto dir">5%</p>
        </div>
        <div class="linhasDireita">
          <p class="titulo">(-) Outras deduções</p>
        </div>
        <div class="linhasDireita">
          <p class="titulo">(+) Mora / Multa</p>
        </div>
        <div class="linhasDireita">
          <p class="titulo">(+) Outros acréscimos</p>
        </div>
        <div class="linhasDireita">
          <p class="titulo">(=) Valor cobrado</p>
        </div>
      </div>

      <div class="sacado">
        <p class="titulo">Sacado</p>
        <p class="texto"><?php echo $nomeCliente." - CNPJ: ". $cnpjCliente?></p>
        <p class="texto"><?php echo $lograCliente ?></p>
        <p class="texto"><?php echo $cidadeCliente." - ".$estadoCliente." - CEP: ".$cepCliente?></p>
      </div>
      <div class="codBarra">
        <p class="titulo">Sacador / Avalista</p>
        <img src="img/barras.png" id="imgBarra" alt="">
      </div>
    </div>
  </body>
</html>
