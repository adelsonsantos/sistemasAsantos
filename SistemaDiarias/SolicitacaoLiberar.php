<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaLiberada.php";
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


	function Gravar(frm)
		{
			if (frm.cmbBeneficiario.value == "0")
			{
				alert("Selecione um Beneficiário.");
				frm.cmbBeneficiario.focus();
				frm.cmbBeneficiario.style.backgroundColor='#B9DCFF';
				return false;
			}

			if (frm.txtJustificativaDiaria.value == "")
			{
				alert("Digite a JUSTIFICATIVA.");
				frm.txtJustificativaDiaria.focus();
				frm.txtJustificativaDiaria.style.backgroundColor='#B9DCFF';
				return false;
			}
			alert( "Diária Liberada com sucesso!! Favor informar ao usuário.");
			frm.action = "SolicitacaoLiberar.php?Acao=Liberar";
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
                            <tr height="20">
                                 <td width="" class="dataLabel">&nbsp;Benefici&aacute;rio</td>
                            </tr>
                            <tr>
                             <td width="" class="dataField">&nbsp;<?=ComboBeneficiario($Beneficiario,"")?></td>
                            </tr>
                             <tr height="20">
                                 <td width="" class="dataLabel">&nbsp;Justificativa</td>
                            </tr>

 <tr height="21" class="dataField">
                                            <td>&nbsp;<textarea name="txtJustificativaDiaria" style=" width:789px; height:45px" maxlenght="255" onKeyUp="ContarJustificativaFimSemana(this,255)"></textarea></td>                                                                                        
	                                    </tr>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
	                                <button style="width:100px" onClick="Javascript:Gravar(document.Form);" name="btnGravar" class="botao">Gravar</button>
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
