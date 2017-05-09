<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaImpressao.php";
?>
<html>

<style type="text/css">@import url("../css/estilo_relatorio.css"); </style>

<body leftmargin="5" topmargin="5" onLoad="window.print();">
<br>
<table width="800" height="66" border="1" cellpadding="3" cellspacing="0">
	<tr>
    	<td rowspan="2" width="251"><img src="../Imagens/logo_menor.jpg"></td>
    	<td colspan="2" align="center" class="titulo">Comprova&ccedil;&atilde;o de Di&aacute;rias</td>
	</tr>
    <tr height="33">
    	<td><span class="linha_titulo">&Aacute;rea Benefici&aacute;ria</span><br><span class="linha"><?=$UnidadeCustoNome?></span></td>
    	<td width="100"><span class="linha_titulo">Nº CD</span><br><span class="linha"><?=$Numero?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
	<tr class="dataLinha" height="28">
    	<td width="500"><span class="linha_titulo">Nome</span><br><span class="linha"><?=f_ConsultaNomeFuncionario($Beneficiario)?></span></td>
    	<td width="150"><span class="linha_titulo">Matr&iacute;cula</span><br><span class="linha"><?=$Matricula?></span></td>
    	<td width="150"><span class="linha_titulo">Comprovada em</span><br><span class="linha"><?=$DataDaComprovacao?> &agrave;s <?=$HoraDaComprovacao?></span></td>
	</tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
	<tr class="dataLinha" height="60">
    	<td width="400" colspan="2" valign="top"><span class="linha_titulo">Lota&ccedil;&atilde;o</span><br><span class="linha"><?=f_ConsultaEstruturaOrganizacional($EstruturaAtuacao)?></span></td>
    	<td width="400" colspan="2" valign="top"><span class="linha_titulo">ACP</span><br><span class="linha"><?=$UnidadeCustoNumero?>&nbsp;-&nbsp;<?=f_ExibeUnidadeCusto($UnidadeCusto)?></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
	<tr class="dataLinha" height="28">
    	<td width="410"><span class="linha_titulo">Cargo/Fun&ccedil;&atilde;o</span><br><span class="linha"><?=$CargoNome?></span></td>
    	<td width="130"><span class="linha_titulo">Empenho</span><br><span class="linha"><?=$Empenho?></span></td>
    	<td width="130"><span class="linha_titulo">Data do Empenho</span><br><span class="linha"><?=$DataEmpenho?></span></td>
    	<td width="130"><span class="linha_titulo">Processo</span><br><span class="linha"><?=$Processo?></span></td>
	</tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
	<tr class="dataLinha" height="28">
    	<td width="200"><span class="linha_titulo">CPF</span><br><span class="linha"><?=$CPF?></span></td>
    	<td width="240"><span class="linha_titulo">Dados Banc&aacute;rios</span><br><span class="linha">Bco.<?=$Banco?>&nbsp;/&nbsp;Ag.<?=$Agencia?>&nbsp;/&nbsp;CC.<?=$Conta?></span></td>
    	<td width="360"><span class="linha_titulo">Projeto</span><br><span class="linha">Projeto <?=$Projeto?>&nbsp;,&nbsp;Produto <?=Acao?>&nbsp;,&nbsp;Territ&oacute;rio <?=$Territorio?>&nbsp;,&nbsp;Fonte <?=$Fonte?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<?

	$sqlRoteiro 	= "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$Codigo;
	$rsRoteiro 		= pg_query(abreConexao(),$sqlRoteiro);
    $qtdDeRegistro	= pg_fetch_row($rsRoteiro);
    $Contador 		= count($qtdDeRegistro);
    $i =1;

	while($linharsRoteiro=pg_fetch_assoc($rsRoteiro))
    {
        $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " .$linharsRoteiro['roteiro_origem'];
        $rsRoteiroOrigem = pg_query(abreConexao(),$sqlRoteiroOrigem);
        $linharsRoteiroOrigem=pg_fetch_assoc($rsRoteiroOrigem);

        $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " .$linharsRoteiro['roteiro_destino'];
        $rsRoteiroDestino = pg_query(abreConexao(),$sqlRoteiroDestino);
        $linharsRoteiroDestino=pg_fetch_assoc($rsRoteiroDestino);

        If ($i == 1)
        {
            $Inicio = $linharsRoteiroOrigem['municipio_ds']. " - (" .$linharsRoteiroOrigem['estado_uf']. ")" . " / " .$linharsRoteiroDestino['municipio_ds']. " - (" .$linharsRoteiroDestino['estado_uf']. ")";
        }
        Elseif (($i != 1) && ($i < $Contador))
        {
            $Meio = " / " .$linharsRoteiroOrigem['municipio_ds']. " - (" .$linharsRoteiroOrigem['estado_uf'].")" . " / " .$linharsRoteiroDestino['municipio_ds']." - (" .$linharsRoteiroDestino['estado_uf']. ")";

        }
        Elseif ($i == $Contador)
        {    $Final = " / " .$linharsRoteiroDestino['municipio_ds']. " - (" .$linharsRoteiroDestino['estado_uf']. ")";
        }

        $i = $i+1;
    }

	$Roteiro = $Inicio.$Meio.$Final;



	$sqlRoteiroComprovacao = "SELECT roteiro_comprovacao_origem, roteiro_comprovacao_destino FROM diaria.roteiro_comprovacao WHERE diaria_id = " .$Codigo;
	$rsRoteiroComprovacao = pg_query(abreConexao(),$sqlRoteiroComprovacao);
	$qtdDeRegistro= pg_fetch_row($rsRoteiroComprovacao);
    $ContadorComprovacao =count($qtdDeRegistro);
    $i =1;

    while($linharsRoteiroComprovacao=pg_fetch_assoc($rsRoteiroComprovacao))
    {
        $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiroComprovacao['roteiro_comprovacao_origem'];
        $rsRoteiroOrigem = pg_query(abreConexao(),$sqlRoteiroOrigem);
        $linharsRoteiroOrigem=pg_fetch_assoc($rsRoteiroOrigem);

        $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " .$linharsRoteiroComprovacao['roteiro_comprovacao_destino'];
        $rsRoteiroDestino = pg_query(abreConexao(),$sqlRoteiroDestino);
        $linharsRoteiroDestino=pg_fetch_assoc($rsRoteiroDestino);

        If ($i == 1)
        {
            $Inicio = $linharsRoteiroOrigem['municipio_ds']. " - (" .$linharsRoteiroOrigem['estado_uf']. ")" . " / " .$linharsRoteiroDestino['municipio_ds']. " - (" .$linharsRoteiroDestino['estado_uf']. ")";
        }
        Elseif (($i <> 1) && ($i < $ContadorComprovacao))
        {
            $Meio = " / " .$linharsRoteiroOrigem['municipio_ds']. " - (" .$linharsRoteiroOrigem['estado_uf'] . ")" . " / " .$linharsRoteiroDestino['municipio_ds'] . " - (" .$linharsRoteiroDestino['estado_uf']. ")";
        }
        Elseif ($i == $ContadorComprovacao)
        {

            $Final = " / " .$linharsRoteiroDestino['municipio_ds']. " - (" .$linharsRoteiroDestino['estado_uf']. ")";
        }


        $i = $i+1;

    }

	$RoteiroComprovacao = $Inicio.$Meio.$Final;

?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
	<tr class="dataLinha" height="60">
    	<td valign="top"><span class="linha_titulo">Roteiro da Comprova&ccedil;&atilde;o</span><br><span class="linha"><?=$RoteiroComprovacao?></span></td>
    </tr>
</table>


<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
	<tr class="dataLinha" height="60">
    	<td width="400" valign="top"><span class="linha_titulo">Meio de Transporte</span><br><span class="linha"><?=$MeioTransporte?></span></td>
    	<td width="400" valign="top"><span class="linha_titulo">Observa&ccedil;&atilde;o</span><br><span class="linha">&nbsp;<?=$TransporteObservacao?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
	<tr class="dataLinha" height="28">
    	<td width="400"><span class="linha_titulo">Motivo</span><br><span class="linha"><?=$Motivo?></span></td>
    	<?//<td width="400"><span class="linha_titulo">SubMotivo</span><br><span class="linha">&nbsp;</?=$SubMotivo?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
	<tr class="dataLinha" height="80">
    	<td valign="top"><span class="linha_titulo">Detalhe do Motivo</span><br><span class="linha"><?=$Descricao?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
    <tr height="21">
        <td width="200" colspan="2" align="center"><span class="linha_titulo">Partida Prevista</span></td>
        <td width="200" colspan="2" align="center"><span class="linha_titulo">Chegada Prevista</span></td>
        <td width="200" colspan="2" align="center"><span class="linha_titulo">Partida Efetiva</span></td>
        <td width="200" colspan="2" align="center"><span class="linha_titulo">Chegada Efetiva</span></td>
    </tr>
    <tr height="21">
        <td width="120"><span class="linha"><?=$DataPartida?><br><?=$DiaSemanaPartida?></span></td>
        <td width="80" align="center"><span class="linha"><?=$HoraPartida?><br></span></td>
        <td width="120"><span class="linha"><?=$DataChegada?><br><?=$DiaSemanaChegada?></span></td>
        <td width="80" align="center"><span class="linha"><?=$HoraChegada?><br></span> </td>
        <? $linharsComprovacao=pg_fetch_assoc($rsComprovacao);?>
        <td width="120"><span class="linha"><?=$linharsComprovacao['diaria_comprovacao_dt_saida']?><br><?=diasemana($linharsComprovacao['diaria_comprovacao_dt_saida'])?></span></td>
        <td width="80" align="center"><span class="linha"><?=$linharsComprovacao['diaria_comprovacao_hr_saida']?><br></span></td>
        <td width="120"><span class="linha"><?=$linharsComprovacao['diaria_comprovacao_dt_chegada']?><br><?=diasemana($linharsComprovacao['diaria_comprovacao_dt_chegada'])?></span></td>
        <td width="80" align="center"><span class="linha"><?=$linharsComprovacao['diaria_comprovacao_hr_chegada']?><br></span> </td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
    <tr height="21">
    	<td width="400" colspan="3" align="center"><span class="linha_titulo">Di&aacute;rias Recebidas</span></td>
    	<td width="200" colspan="2" align="center"><span class="linha_titulo">Di&aacute;rias Utilizadas</span></td>
    	<td width="200" colspan="2" align="center"><span class="linha_titulo">Saldo</span></td>
    </tr>
    <tr height="21">
        <td width="130" align="center"><span class="linha">Quantidade</span><br><span class="linha"><?=$Qtde?></span></td>
        <td width="140" align="center"><span class="linha">Valor Refer&ecirc;ncia</span><br><span class="linha"><?=$ValorRef?></span></td>
        <td width="130" align="center"><span class="linha">Valor Total</span><br><span class="linha"><?=$Valor?></span></td>
        <td width="100" align="center"><span class="linha">Quantidade</span><br><span class="linha"><?=$QtdeComprovacao?></span></td>
        <td width="100" align="center"><span class="linha">Valor Total</span><br><span class="linha"><?=$ValorComprovacao?></span></td>
        <td width="100" align="center"><span class="linha">A Receber</span><br><span class="linha"><?=number_format($SaldoReceber, 2, ',', '.');?></span></td>
        <td width="100" align="center"><span class="linha">A Restituir</span><br><span class="linha"><?=number_format($SaldoPagar, 2, ',', '.');?></span></td>
    </tr>
<?
	If ($Complemento == "1")
    {
?>
	<tr class="dataLinha" height="28">
    	<td colspan="7"><span class="linha_titulo">Justificativa do Complemento&nbsp;(Conforme Art. 4º par&aacute;grafo 2º do DECRETO Nº 5.910 de Outubro de 1996.)</span><br><span class="linha"><?=$ComplementoJustificativa?></span></td>
    </tr>
<?
    }
?>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
    <tr class="dataLinha" height="80">
        <td valign="top"><span class="linha_titulo">Justificativa do Fim de Semana e Feriado</span><br><span class="linha"><?=$JustificativaFimSemana?><br><?=$JustificativaFeriado?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>


<table width="800" border="1" cellpadding="3" cellspacing="0">
<tr height="21"><td align="center"><span class="linha_titulo">Relat&oacute;rio de atividades</td></tr>
<tr height="210"><td valign="top"><textarea name="teste" class="RealmenteInvisivel" readonly cols="149" rows="14"><?=$Resumo?></textarea></td></tr>
</table>


<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
	<tr class="dataLinha" height="210">
    	<td width="267" valign="top" align="center"><span class="linha_titulo">BENEFICI&Aacute;RIO</b></span></td>
    	<td width="267" valign="top" align="center"><span class="linha_titulo">DIRIGENTE DA UNIDADE</b></span></td>
    	<td width="266" valign="top" align="center"><span class="linha_titulo">DIRETOR</b></span></td>
    </tr>
</table>
<br>
</body>
</html>

