<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaGER.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<body leftmargin="5" topmargin="5" onLoad="window.print();">
<br>
<table width="800" height="66" border="0" cellpadding="3" cellspacing="0">
	<tr>
    	<td rowspan="2" width="251"><img src="../Imagens/logo.png"></td>
    	<td colspan="2" align="center"><font size="5" color="#000000"><b>GUIA ESPECIAL DE RECOLHIMENTO<BR><font size="3" color="#000000">Dep&oacute;sito Identificado</b></font></td>
	</tr>
</table>

<?include "../Include/Inc_Linha.php"?>

<table width="800" border="1" cellpadding="3" cellspacing="0">
	<tr class="dataLinha">
    	<td width="620" colspan="4"><font size="2" color="#000000"><b>1. Nome</b></font><br><font size="2" color="#000000"><?=f_ConsultaNomeFuncionario($Beneficiario)?></font></td>
        <?$linharsGER=pg_fetch_assoc($rsGER);?>
        <td width="180"><font size="2" color="#000000"><b>2. C&oacute;digo do Recolhimento</b></font><br><font size="2" color="#000000"><?=$linharsGER['ger_cod_recolhimento']?></font></td>
	</tr>

	<tr class="dataLinha">
    	<td width="468" colspan="3"><font size="2" color="#000000"><b>3. Endere&ccedil;o</b></font><br><font size="2" color="#000000"><?=$Endereco?></font></td>
    	<td width="156"><font size="2" color="#000000"><b>4. Telefone</b></font><br><font size="2" color="#000000">&nbsp;</font></td>
    	<td width="170"><font size="2" color="#000000"><b>5. CPF</b></font><br><font size="2" color="#000000"><?=$CPF?></font></td>
	</tr>
	<tr class="dataLinha">
    <?$linharsEndereco=pg_fetch_assoc($rsEndereco);?>
    	<td width="156"><font size="2" color="#000000"><b>6. Bairro</b></font><br><font size="2" color="#000000"><?=$linhaEndereco['endereco_bairro']?></font></td>
    	<td width="156"><font size="2" color="#000000"><b>7. Munic&iacute;pio</b></font><br><font size="2" color="#000000"><?=$linhaEndereco['municipio_ds']?></font></td>
    	<td width="156"><font size="2" color="#000000"><b>8. UF</b></font><br><font size="2" color="#000000"><?=$linhaEndereco['estado_uf']?></font></td>
    	<td width="156"><font size="2" color="#000000"><b>9. CEP</b></font><br><font size="2" color="#000000"><?=$linhaEndereco['endereco_cep']?></font></td>
    	<td width="170"><font size="2" color="#000000"><b>10. C&oacute;digo da UG</b></font><br><font size="2" color="#000000"><?=$linharsGER['ger_cod_ug']?></font></td>
	</tr>
	<tr class="dataLinha">
    	<td width="156"><font size="2" color="#000000"><b>11. Banco</b></font><br><font size="2" color="#000000"><?=$linharsGER['ger_banco']?></font></td>
    	<td width="156"><font size="2" color="#000000"><b>12. Ag&ecirc;ncia</b></font><br><font size="2" color="#000000"><?=$linharsGER['ger_agencia']?></font></td>
    	<td width="312" colspan="2"><font size="2" color="#000000"><b>13. Nome da Conta</b></font><br><font size="2" color="#000000"><?=$linharsGER['ger_nm_conta']?></font></td>
    	<td width="170"><font size="2" color="#000000"><b>14. N&uacute;mero da Conta</b></font><br><font size="2" color="#000000"><?=$linharsGER['ger_conta']?></font></td>
	</tr>

	<tr class="dataLinha">
    	<td width="630" rowspan="2" colspan="4" valign="top"><font size="2" color="#000000"><b>15. Espefica&ccedil;&atilde;o do Recolhimento</b></font><br><br><font size="2" color="#000000"><?=$linharsGER['ger_cod_recolhimento']?> - Devolu&ccedil;&atilde;o de Di&aacute;rias</font></td>
    	<?php 
            $linharsComprovacao=pg_fetch_assoc($rsComprovacao);            
            if(substr($SaldoPagar,0,1) != '-')
            {
                $SaldoPagar = number_format($SaldoPagar, 2, ',', '.');
            }
            else
            {
                $saldoArray = explode('-', $SaldoPagar);
                $SaldoPagar = number_format($saldoArray['1'], 2, ',', '.');
            }
        ?>
        
        <td width="170"><font size="2" color="#000000"><b>16. Valor Principal</b></font><br><font size="2" color="#000000"><?=$SaldoPagar?></font></td>
	</tr>
	<tr class="dataLinha">
    	<td width="170"><font size="2" color="#000000"><b>17. Atualiza&ccedil;&atilde;o Monet&aacute;ria</b></font><br><font size="2" color="#000000">&nbsp;</font></td>
	</tr>
	<tr class="dataLinha">
    	<td width="630" rowspan="2" colspan="4" valign="top"><font size="2" color="#000000"><b>18. Informa&ccedil;&otilde;es Complementares</b></font><br><font size="2" color="#000000"><b>RECEBIMENTO EXCLUSIVO NO BANCO DO BRASIL</b><br>Devolu&ccedil;&atilde;o de valor de di&aacute;ria recebida a maior<br>Di&aacute;ria: <?=$Numero?>&nbsp;&nbsp; Processo: <?=$Processo?>&nbsp;&nbsp;Empenho: <?=$Empenho?></font></td>
    	<td width="170"><font size="2" color="#000000"><b>19. Juros / Acr&eacute;scimos</b></font><br><font size="2" color="#000000">&nbsp;</font></td>
	</tr>
	<tr class="dataLinha">
    	<td width="170"><font size="2" color="#000000"><b>20. Total a Recolher</b></font><br><font size="2" color="#000000"><?=$SaldoPagar?></font></td>
	</tr>
	<tr class="dataLinha">
    <?$Date=date("Y-m-d");
      $Time=date("H:i:s");
    ?>
    	<td width="156"><font size="2" color="#000000"><b>21. Data de Emiss&atilde;o</b></font><br><font size="2" color="#000000"><?=F_formataData($Date)?>&nbsp;<?=$Time?></font></td>
    	<td width="644" colspan="4"><font size="2" color="#000000"><b>22. Autentica&ccedil;&atilde;o Mec&acirc;nica</b></font><br><font size="2" color="#000000"><b>ANEXAR O COMPROVANTE DE DEP&Oacute;SITO IDENTIFICADO</font></td>
	</tr>

</table>


</body>
</html>

