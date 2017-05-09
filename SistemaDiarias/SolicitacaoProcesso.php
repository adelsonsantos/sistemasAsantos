<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaGestao.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<body leftmargin="5" topmargin="5" onLoad="window.print();">
<br>
<table width="800" height="66" border="1" cellpadding="3" cellspacing="0">
    <tr height="33">
    	<td colspan="2"><font size="2" color="#000000"><b>ADAB - AGÊNCIA DE DEFESA AGROPECÚARIA DA BAHIA</b></font></td>
    </tr>
    <tr height="33">
    	<td colspan="2"><font size="2" color="#000000"><b><?=$UnidadeCustoNome?></b></font></td>
    </tr>
    <tr height="33">
    	<td colspan="2"><font size="2" color="#000000"><b><?=f_ConsultaNomeFuncionario($Beneficiario)?></b></font></td>
    </tr>
    <tr height="33">
    	<td colspan="2"><font size="2" color="#000000"><b>SOLICITA&Ccedil;&Atilde;O DE DI&Aacute;RIA <?=$Numero?> EMPENHO <?=$Empenho?> DATA <?=$DataDaSolicitacao?></b></font></td>
    </tr>
    <tr height="33">
    	<td colspan="2"><font size="2" color="#000000"><b><?=$UnidadeCustoNome?></b></font></td>
    </tr>
</table>

</body>
</html>

