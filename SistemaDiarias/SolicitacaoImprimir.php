<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaGestao.php";
header("Content-Type: text/html; charset=UTF-8",true);
?>
<html>

<style type="text/css">@import url("../css/estilo_relatorio.css"); </style>

<body onLoad="window.print();">

<table width="760pt" height="66" border="1" cellpadding="1" cellspacing="0">
	<tr>
    	<td rowspan="2" width="251"><img src="../Imagens/logo_menor.jpg" /></td>
    	<td colspan="2" width="509" align="center" class="titulo">Solicita&ccedil;&atilde;o de Di&aacute;rias</td>
	</tr>
    <tr height="33">
    	<td><span class="linha_titulo">&Aacute;rea Benefici&aacute;ria</span><br><span class="linha"><?=$UnidadeCustoNome?></span></td>
        <td width="100"><span class="linha_titulo">N&ordm; Di&aacute;ria</span><br><span class="linha"><?=$Numero?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="760pt" border="1" cellpadding="1" cellspacing="0">
	<tr>
    	<td width="460"><span class="linha_titulo">Nome</span><br><span class="linha"><?=f_ConsultaNomeFuncionario($Beneficiario)?></span></td>
    	<td width="150"><span class="linha_titulo">Matr&iacute;cula</span><br><span class="linha"><?=$Matricula?></span></td>
    	<td width="150"><span class="linha_titulo">Solicitada em</span><br><span class="linha"><?=$DataDaSolicitacao?></span></td>
	</tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="760" border="1" cellpadding="1" cellspacing="0">
	<tr height="60">
    	<td width="380" colspan="2" valign="top"><span class="linha_titulo">Lota&ccedil;&atilde;o</span><br><span class="linha"><?=f_ConsultaEstruturaOrganizacional($EstruturaAtuacao)?></span></td>
    	<td width="380" colspan="2" valign="top"><span class="linha_titulo">ACP</span><br><span class="linha"><?=UnidadeCustoNumero?>&nbsp;-&nbsp;<?=f_ExibeUnidadeCusto($UnidadeCusto)?></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="760" border="1" cellpadding="1" cellspacing="0">
	<tr>
    	<td width="560"><span class="linha_titulo">Cargo/Fun&ccedil;&atilde;o</span><br><span class="linha"><?=$CargoNome?></span></td>
    	<td width="200"><span class="linha_titulo">Escolaridade</span><br><span class="linha"><?=$EscolaridadeNome?></span></td>
	</tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="760" border="1" cellpadding="1" cellspacing="0">
	<tr>
    	<td colspan="2"><span class="linha_titulo">Endere&ccedil;o Benefici&aacute;rio</span><br><span class="linha"><?=$Endereco?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="760" border="1" cellpadding="1" cellspacing="0">
	<tr>
    	<td width="190"><span class="linha_titulo">CPF</span><br><span class="linha"><?=$CPF?></span></td>
    	<td width="230"><span class="linha_titulo">Dados Banc&aacute;rios</span><br><span class="linha">Bco.<?=$Banco?>&nbsp;/&nbsp;Ag.<?=$Agencia?>&nbsp;/&nbsp;CC.<?=$Conta?></span></td>
    	<td width="340"><span class="linha_titulo">Projeto</span><br><span class="linha">Projeto <?=$Projeto?>&nbsp;,&nbsp;Produto <?=$Acao?>&nbsp;,&nbsp;Territ&oacute;rio <?=$Territorio?>&nbsp;,&nbsp;Fonte <?=$Fonte?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<?

	$sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = " .$Codigo;
    $rsRoteiro = pg_query(abreConexao(),$sqlRoteiro);
    $qtdDeRegistro= pg_fetch_row($rsRoteiro);
	$Contador =count($qtdDeRegistro);
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
        {  $Inicio = $linharsRoteiroOrigem['municipio_ds']. "(" .$linharsRoteiroOrigem['estado_uf'].")" ." / " .$linharsRoteiroDestino['municipio_ds']. "(" .$linharsRoteiroDestino['estado_uf'].")";
        }

        Elseif (($i != 1) && ($i < $Contador))
        {
            $Meio = " / " .$linharsRoteiroOrigem['municipio_ds']. "(" .$linharsRoteiroOrigem['estado_uf']. ")" . " / " .$linharsRoteiroDestino['municipio_ds']. "(" .$linharsRoteiroDestino['estado_uf']. ")";
        }
        Elseif ($i == $Contador)
        {    $Final = " / " .$linharsRoteiroDestino['municipio_ds']. "(" .$linharsRoteiroDestino['estado_uf']. ")";
        }

        $i = $i+1;
    }

		$Roteiro = $Inicio.$Meio.$Final;


?>

<table width="760" border="1" cellpadding="1" cellspacing="0">
	<tr height="80">
    	<td valign="top"><span class="linha_titulo">Roteiro</span><br><span class="linha"><?=$Roteiro?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="760" border="1" cellpadding="1" cellspacing="0">
	<tr height="60">
    	<td width="380" valign="top"><span class="linha_titulo">Meio de Transporte</span><br><span class="linha"><?=$MeioTransporte?></span></td>
    	<td width="380" valign="top"><span class="linha_titulo">Observa&ccedil;&atilde;o</span><br><span class="linha">&nbsp;<?=$TransporteObservacao?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="760" border="1" cellpadding="1" cellspacing="0">
	<tr>
    	<td width="380"><span class="linha_titulo">Motivo</span><br><span class="linha"><?=$Motivo?></span></td>
    	<?//<td width="380"><span class="linha_titulo">SubMotivo</span><br><span class="linha">&nbsp;</?=$SubMotivo?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="760" border="1" cellpadding="1" cellspacing="0">
	<tr>
    	<td height="130" valign="top"><span class="linha_titulo">Detalhe do Motivo</span><br><span class="linha"><?=$Descricao?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>


<table width="760" border="1" cellpadding="1" cellspacing="0">
    <tr height="40">
        <td width="190" colspan="2" align="center"><span class="linha_titulo">Partida Prevista</span></td>
        <td width="190" colspan="2" align="center"><span class="linha_titulo">Chegada Prevista</span></td>
        <td width="90" align="center"><span class="linha_titulo">Di&aacute;rias</span></td>
        <td width="90" align="center"><span class="linha_titulo">Valor Ref</span></td>
        <td width="100" align="center"><span class="linha_titulo">Total</span></td>
        <td width="100" align="center"><span class="linha_titulo">N�Empenho</span></td>
    </tr>
    <tr>
        <td width="110"><span class="linha"><?=$DataPartida?><br><?=$DiaSemanaPartida?></span></td>
        <td width="80" align="center"><span class="linha"><?=$HoraPartida?><br></span>
        <td width="110"><span class="linha"><?=$DataChegada?><br><?=$DiaSemanaChegada?></span></td>
        <td width="80" align="center"><span class="linha"><?=$HoraChegada?><br></span>
        <td width="90" align="center"><span class="linha"><?=$Qtde?></td>
        <td width="90" align="center"><span class="linha"><?=$ValorRef?></td>
        <td width="100" align="center"><span class="linha"><?=$Valor?></td>
        <td width="100" align="center"><span class="linha">&nbsp;<?=$Empenho?></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="760" border="1" cellpadding="1" cellspacing="0">
    <tr height="80">
        <td valign="top"><span class="linha_titulo">Justificativa do Fim de Semana e Feriado</span><br><span class="linha"><?=$JustificativaFimSemana?><br><?=$JustificativaFeriado?></span></td>
    </tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="760" border="1" cellpadding="1" cellspacing="0">
	<tr height="210">
    	<td width="255" valign="top" align="center"><span class="linha_titulo">DIRIGENTE DA UNIDADE</b></span></td>
    	<td width="255" valign="top" align="center"><span class="linha_titulo">DIRETOR</b></span></td>
    	<td width="255" valign="top" align="center"><span class="linha_titulo">AUTORIZA&Ccedil;&Atilde;O DO SECRET&Aacute;RIO</b></span></td>
    </tr>
</table>
<br>
</body>
</html>
