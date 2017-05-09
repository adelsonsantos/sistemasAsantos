<?php
include "../Include/Inc_Configuracao.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>
<style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
<script language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>

<script language="javascript">
<!--

	function Foco(frm)
	{
		frm.cmbContrato.focus();
	}

	function GerarRelatorio(frm)
	{
		frm.action = "RelatorioTercerizadoPDF.php";
		frm.submit();
	}

-->
</script>


<body onLoad="WM_initializeToolbar();">


<form name="Form" method="post">

<table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
       <td><?include "../Include/Inc_Topo.php"?></td>
    </tr>
    <tr>
    	<td><?include "../Include/Inc_Aba.php"?></td>
    </tr>
    <tr>
    	<td align="left">
            <table width="990" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td valign="top" align="left" width="190"><?include "../Include/Inc_Menu.php"?></td>
                    <td valign="top" align="left">

                        <?include "../Include/Inc_Titulo.php"?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                            <tr>
                                <td>
                                    <table border="0" cellpadding="1" cellspacing="1" width="798">
                                        <tr height="20">
                                        	<td class="dataLabel">&nbsp;Tipo de Funcion&aacute;rio </td>
											<td class="dataLabel">&nbsp;Contrato </td>
                                            <td class="dataLabel">&nbsp; </td>
                                        </tr>
                                        <tr height="20">
                                        	<td class="dataField">&nbsp;Tercerizado</td>
                                            <td class="dataField">&nbsp;<?=f_ComboContrato($Contrato)?>&nbsp;</td>
                                            <td class="dataField"></td>
                                        </tr>
                                        <tr height="20">
                                        	<td class="dataLabel">&nbsp;Loca&ccedil;&atilde;o </td>
											<td class="dataLabel">&nbsp;Fun&ccedil;&atilde;o </td>
                                             <td class="dataLabel">&nbsp;Situa&ccedil;&atilde;o </td>
                                        </tr>
                                        <tr height="20">
                                   				<td class="dataField">&nbsp;<?=f_ComboLotacao($Lotacao)?>&nbsp;</td>
 	                							<td class="dataField">&nbsp;<?=f_ComboFuncao($Funcao)?>&nbsp;</td>
                                                <td class="dataField">
                                                	<select name="cmbSituacao">
														<option value="0">[---Selecione ---]</option>
                                                        <option value="1">CONTRATADO</option>
														<option value="2">DESLIGADO</option>
													</select>
                                                </td>
      									</tr>
                                     </table>
                                </td>
                            </tr>
                        </table>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
	                                <button style="width:100px" onClick="Javascript:GerarRelatorio(document.Form);" name="btnGravar" class="botao">Gerar Relat&oacute;rio</button>
                               </td>
                           </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </td>
	</tr>
</table>

</form>

</body>
</html>


