<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseContrato.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
<script language="javascript" src="../JavaScript/mascara.js"></script>

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

		if (frm.txtDescricao.value == "")
		{
			alert("Campo OBJETO em Branco.");
			frm.txtDescricao.focus();
			frm.txtDescricao.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.cmbPJ.value == "0")
		{
			alert("Campo EMPRESA em Branco.");
			frm.cmbPJ.focus();
			frm.cmbPJ.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtDataInicio.value == "")
		{
			alert("Campo IN�CIO DO CONTRATO em Branco.");
			frm.txtDataInicio.focus();
			frm.txtDataInicio.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtDataTermino.value == "")
		{
			alert("Campo T�RMINO DO CONTRATO em Branco.");
			frm.txtDataTermino.focus();
			frm.txtDataTermino.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.cmbContratoTipo.value == "0")
		{
			alert("Campo CONTRATO TIPO em Branco.");
			frm.cmbContratoTipo.focus();
			frm.cmbContratoTipo.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtCodigo.value == "")
			frm.action = "ContratoCadastrar.php?acao=incluir";
		else
			frm.action = "ContratoCadastrar.php?acao=alterar";

		frm.submit();
	}

-->
</script>

<body onLoad="WM_initializeToolbar()">

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

                        <?//inicio titulo da pagina ?>

                        <div id="titulopagina">

                        <?include "../Include/Inc_Titulo.php"?>

                        </div>

                        <? //fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <?//inicio aba de cadastramento ?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="140">&nbsp;N&uacute;mero</td>
                                            <td width="340" colspan="2">&nbsp;Objeto</td>
                                            <td width="318" colspan="2">&nbsp;Empresa</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<input name="txtNumero" maxlength="10" type="text" value="<?=$Numero?>" style=" width:120px;">&nbsp;*</td>
                                            <td colspan="2">&nbsp;<input name="txtDescricao" maxlength="50" type="text" value="<?=$Descricao?>" style=" width:300px;">&nbsp;*</td>
                                            <td colspan="2">&nbsp;<?=f_ComboPJContrato($Empresa)?>&nbsp;*</td>
                                        </tr>
                                        <tr height="21" class="dataLabel">
                                            <td width="140">&nbsp;Data In&iacute;cio</td>
                                            <td width="140">&nbsp;Data T&eacute;rmino</td>
                                        	<td width="200">&nbsp;Tipo de Contrato</td>
                                            <td width="130">&nbsp;Valor em R$</td>
                                            <td width="188">&nbsp;Qtde M&aacute;xima <font class="dataTexto">(de Pessoas)</font></td>
                                        </tr>
                                        <tr height="21" class="dataField">
                    						<td>&nbsp;<input name="txtDataInicio" maxlength="10" type="text" value="<?=$DataInicio?>" style=" width:120px;" OnKeyUp="mascaraData(this.value, document.Form.txtDataInicio);" onKeyPress="mascaraNumero(event, this);">&nbsp;*</td>
                    						<td>&nbsp;<input name="txtDataTermino" maxlength="10" type="text" value="<?=$DataTermino?>" style=" width:120px;" OnKeyUp="mascaraData(this.value, document.Form.txtDataTermino);" onKeyPress="mascaraNumero(event, this);">&nbsp;*</td>
	                                        <td>&nbsp;<?=f_ContratoTipo($Tipo)?>&nbsp;*</td>
                                            <td>&nbsp;<input name="txtValor" maxlength="15" type="text" value="<?=$Valor?>" style=" width:120px;" onKeyPress="return(MascaraMoeda(this,'.',',',event))"></td>
                                            <td>&nbsp;<input name="txtQtde" maxlength="3" type="text" value="<?=$Qtde?>" style=" width:40px;"></td>
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
						If($MensagemErroBD != "" )
						{
							echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
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
