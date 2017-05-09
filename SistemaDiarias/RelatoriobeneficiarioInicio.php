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
		frm.cmbContrato.focus();
	}


	function GerarRelatorio(frm)
		{
         	if (frm.txtDataComprovaIni.value == "")
			{
				alert("Infome a Data Início!");
				frm.txtDataComprovaIni.focus();
				frm.txtDataComprovaIni.style.backgroundColor='#B9DCFF';
				return false;
			}

				if (frm.txtDataComprovaFim.value == "")
			{
				alert("Infome a Data Fim!");
				frm.txtDataComprovaFim.focus();
				frm.txtDataComprovaFim.style.backgroundColor='#B9DCFF';
				return false;
			}
			    	
				if (frm.txtDataComprovaFim.value < frm.txtDataComprovaIni.value) 
			{
				alert("Data fim não pode ser menor que data início");
				frm.txtDataComprovaFim.focus();
				frm.txtDataComprovaFim.style.backgroundColor='#B9DCFF';
				return false;
			}
			frm.action = "RelatorioBeneficiarioPDF.php";
			frm.submit();

		}


	function AlterarForm(frm)
	 {

		if ((frm.checkExrato.checked == true) && (frm.FiltrarProjeto.checked == true))
		{
			alert("Escolha apenas um Filtro.");
			return false;
		}
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
                            <tr height="20">
                           		 <td width="" class="dataLabel">&nbsp;Data In&iacute;cio</td>
                                 <td width="0" class="dataLabel">&nbsp;</td>
                                 <td width="" class="dataLabel">&nbsp;Data Fim</td>
                                 <td width="0" class="dataLabel">&nbsp;</td>
                                 <td width="" class="dataLabel">&nbsp;Benefici&aacute;rio</td>
                                 <td width="" class="dataLabel">&nbsp;Filtrar Projeto</td>
                                 <td width="" class="dataLabel">&nbsp;Extrato</td>
                            </tr>

                            <tr>
                             <td width="" class="dataField">&nbsp;<input type="text" name="txtDataComprovaIni" value="" style="width:66px;" readonly></td>
                             <td width="" class="dataField"><a href="#" onClick="javascript:displayCalendar(txtDataComprovaIni,'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar CalendÃ¡rio" width="18" height="18"></a></td>

                             <td width="" class="dataField">&nbsp;<input type="text" name="txtDataComprovaFim" value="" style="width:66px;" readonly></td>
                             <td width="" class="dataField"><a href="#" onClick="javascript:displayCalendar(txtDataComprovaFim,'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar CalendÃ¡rio" width="18" height="18"></a></td>
                             <td width="" class="dataField">&nbsp;<?=ComboBeneficiario($Beneficiario,"")?></td>
                             <td width="" class="dataField">&nbsp;<input type="checkbox" name="FiltrarProjeto"onClick="Javascript:AlterarForm(document.Form);"></td>
							<td width="" class="dataField">&nbsp;<input type="checkbox" name="checkExrato" onClick="Javascript:AlterarForm(document.Form);"></td>
                            </tr>

                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                            <tr>
                                <td>
                                   <table border="0" cellpadding="1" cellspacing="1" width="798">
                                    <tr height="20">
                                    <td width="" class="dataLabel">&nbsp;Projeto </td>
                                    </tr>
                                    <tr>
                                    <td width="" class="dataField">&nbsp;<?=f_ComboProjeto("","")?></td>
                                    </tr>
                                    </table>
                        </table>


                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
	                                <button style="width:100px" onClick="Javascript:AlterarForm(document.Form);GerarRelatorio(document.Form);" name="btnGravar" class="botao">Gerar Relat&oacute;rio</button>
                               </td>
                           </tr>
                        </table>

                </tr>
            </table>
        </td>
	</tr>
</table>



</form>

</body>
</html>
