<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseSimbolo.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
<script language="javascript" src="../JavaScript/mascara.js"></script>

<script language="javascript" charset="utf-8">
<!--

	function Foco(frm)
	{
		frm.txtSimbolo.focus();
	}

	function GravarForm(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.txtSimbolo.value == "")
		{
			alert("Campo SÍMBOLO em Branco.");
			frm.txtSimbolo.focus();
			frm.txtSimbolo.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtSalario.value == "")
		{
			alert("Campo SALÁRIO em Branco.");
			frm.txtSalario.focus();
			frm.txtSalario.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtValor.value == "")
		{
			alert("Campo VALOR em Branco.");
			frm.txtValor.focus();
			frm.txtValor.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtCodigo.value == "")
			frm.action = "SimboloCadastrar.php?acao=incluir";
		else
			frm.action = "SimboloCadastrar.php?acao=alterar";

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

                        <?// inicio titulo da pagina ?>

                        <div id="titulopagina">

                        <?include "../Include/Inc_Titulo.php"?>

                        </div>

                        <?// fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <?// inicio aba de cadastramento ?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td width="150" class="dataLabel">&nbsp;Simbolo</td>
                                            <td width="150" class="dataLabel">&nbsp;Sal&aacute;rio em R$</td>
                                            <td class="dataLabel">&nbsp;Di&aacute;ria em R$</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<input name="txtSimbolo" maxlength="10" type="text" value="<?=$strDescricao?>" style=" width:100px;"></td>
                                            <td class="dataField">&nbsp;<input name="txtSalario" maxlength="10" type="text" value="<?=$strSalario?>" style=" width:100px;" onKeyPress="return(MascaraMoeda(this,'.',',',event))"></td>
                                            <td class="dataField">&nbsp;<input name="txtValor" maxlength="10" type="text" value="<?=$strValorDiaria?>" style=" width:100px;" onKeyPress="return(MascaraMoeda(this,'.',',',event))"></td>
                                        </tr>
                                    </table>
 								</td>
                        	</tr>
                        </table>

                        <input name="txtCodigo" type="hidden" value="<?=$numCodigo?>">

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
