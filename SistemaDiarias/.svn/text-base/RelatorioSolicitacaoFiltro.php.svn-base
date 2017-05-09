<?php
include "../Include/Inc_Configuracao.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>
<style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
<script language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>

<script language="javascript"charset="utf-8">
<!--

	function Foco(frm)
	{
		frm.txtFiltro.focus();
	}

	function GerarRelatorio(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		data1 = frm.txtDataInicio.substring(6,10) + "/" + frm.txtDataInicio.substring(3,5) + "/" + frm.txtDataInicio.substring(0,2);
		data2 = frm.txtDataTermino.substring(6,10) + "/" + frm.txtDataTermino.substring(3,5) + "/" + frm.txtDataTermino.substring(0,2);

		if (frm.txtDataInicio == "")
		{
			alert("Escolha a Data de Início.");
			frm.txtDataInicio.focus();
			frm.txtDataInicio.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtDataTermino == "")
		{
			alert("Escolha a Data de Termino.");
			frm.txtDataTermino.focus();
			frm.txtDataTermino.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (data2<data1)
		{
			alert("Data de Chegada é menor que a Data de Partida");
			document.Form.txtDataInicio.style.backgroundColor='#B9DCFF';
			document.Form.txtDataTermino.style.backgroundColor='#B9DCFF';
			return false;
		}

		frm.action = "SolicitacaoInicio.php?acao=buscar";
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
                                            <td width="150" class="dataLabel">&nbsp;Per&iacute;odo da Solicita&ccedil;&atilde;o</td>
                                            <td width="75" class="dataField">&nbsp;<input type="text" name="txtDataInicio" value="" style="width:66px;" readonly></td>
                                            <td width="20" class="dataField"><a href="#" onClick="javascript:displayCalendar(txtDataInicio,'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18" height="18"></a></td>
                                            <td width="20" class="dataField">&nbsp;&aacute;&nbsp;</td>
                                            <td width="75" class="dataField">&nbsp;<input type="text" name="txtDataTermino" value="" style="width:66px;" readonly></td>
                                            <td width="20" class="dataField"><a href="#" onClick="javascript:displayCalendar(txtDataTermino,'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18" height="18"></a></td>
                                            <td class="dataField">&nbsp;</td>
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
