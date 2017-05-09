<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseMotivo.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript"charset="utf-8">
<!--

	function Foco(frm)
	{
		frm.txtDescricao.focus();
	}

	function GravarForm(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.cmbMotivoTipo.value == "0")
		{
			alert("Selecione o TIPO DO MOTIVO.");
			frm.cmbMotivoTipo.focus();
			frm.cmbMotivoTipo.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtDescricao.value == "")
		{
			alert("Campo DESCRIÇÃO em Branco.");
			frm.txtDescricao.focus();
			frm.txtDescricao.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtCodigo.value == "")
			frm.action = "MotivoCadastrar.php?acao=incluir";
		else
			frm.action = "MotivoCadastrar.php?acao=alterar";

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
    	<td>
            <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td valign="top" align="left" width="190"><?include "../Include/Inc_Menu.php"?></td>
                    <td valign="top" align="left">

                        <?// inicio titulo da pagina ?>

                        <?include "../Include/Inc_Titulo.php"?>

                        <?// fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLabel" width="220">&nbsp;Tipo</td>
                                            <td class="dataLabel" width="578">&nbsp;Descri&ccedil;&atilde;o</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=ComboMotivoTipo($MotivoTipo)?>&nbsp;*</td>
                                            <td class="dataField">&nbsp;<input name="txtDescricao" maxlength="100" type="text" value="<?=$Descricao?>" style=" width:350px;">&nbsp;*</td>
                                        </tr>
                                    </table>
 								</td>
                        	</tr>
                        </table>

                        <table width="798" border="0" cellpadding="0" cellspacing="1">
                            <tr height="21">
                                <td class="dataLinha">(*) Campo obrigat&oacute;rio</td>
                            </tr>
                        </table>

                        <input name="txtCodigo" type="hidden" value="<?=$Codigo?>">

						<?include "../Include/Inc_Linha.php"?>

<?
						If ($MensagemErroBD != "")
                        {

							echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>" ;
							echo "<tr>";
							echo "<td class='MensagemErro'>".$MensagemErroBD. "</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td><img src='../images/vazio.gif' width='1' height='10' border='0'></td>";
							echo "</tr>";
							echo "</table>"	;

                        }
?>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
                                    <button style="width:70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao">Gravar</button>
                                    <button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" name="btnConsultar" class="botao">Voltar</button>
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
