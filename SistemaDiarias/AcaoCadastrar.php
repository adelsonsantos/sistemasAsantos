<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseAcao.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript" charset="utf-8">
<!--

	function Foco(frm)
	{
		frm.txtNumero.focus();
	}

	function GravarForm(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.txtNumero.value == "")
		{
			alert("Campo N�MERO em Branco.");
			frm.txtNumero.focus();
			frm.txtNumero.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.cmbAcaoTipo.value == "0")
		{
			alert("Escolha o TIPO.");
			frm.cmbAcaoTipo.focus();
			frm.cmbAcaoTipo.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtDescricao.value == "")
		{
			alert("Campo DESCRI��O em Branco.");
			frm.txtDescricao.focus();
			frm.txtDescricao.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtCodigo.value == "")
			frm.action = "AcaoCadastrar.php?acao=incluir";
		else
			frm.action = "AcaoCadastrar.php?acao=alterar";

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

                        <?include "../Include/Inc_Titulo.php"?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLabel" width="100">&nbsp;N&uacute;mero</td>
                                            <td class="dataLabel" width="130">&nbsp;Tipo</td>
                                            <td class="dataLabel" width="568">&nbsp;Descri&ccedil;&atilde;o</td>
                                        </tr>
                                        <tr height="21">
<?
											If ($Numero != "")
                                            {
?>
                                            	<td class="dataField">&nbsp;<input name="txtNumero" maxlength="4" type="text" value="<?=$Numero?>" style=" width:50px;" readonly class="Oculto">&nbsp;*</td>
<?
                                            }
                                            Else
                                            {
?>
                                            	<td class="dataField">&nbsp;<input name="txtNumero" maxlength="4" type="text" value="<?=$Numero?>" style=" width:50px;">&nbsp;*</td>
<?
                                            }
?>
                                            <td class="dataField">&nbsp;<?=f_ComboAcaoTipo($Tipo)?>&nbsp;*</td>
                                            <td class="dataField">&nbsp;<input name="txtDescricao" maxlength="350" type="text" value="<?=$Descricao?>" style=" width:400px;">&nbsp;*</td>
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

							echo "<table border='0' cellpadding='0' cellspacing='0' width='100?'>";
							echo "<tr>";
							echo "<td class='MensagemErro'>".$MensagemErroBD."</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td><img src='../images/vazio.gif' width='1' height='10' border='0'></td>";
							echo "</tr>";
							echo "</table>";

                        }
?>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
                                    <button style="width:70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao">Gravar</button>&nbsp;&nbsp;&nbsp;
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