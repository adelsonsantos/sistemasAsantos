<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseAssociarMunicipio.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript" charset="utf-8">
<!--

	function AssociarForm(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.cmbTerritorio.value == "0")
		{
			alert("Escolha um TERRIT”RIO.");
			frm.cmbTerritorio.focus();
			frm.cmbTerritorio.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.cmbMunicipio.value == "0")
		{
			alert("Escolha um MUNICÕPIO.");
			frm.cmbMunicipio.focus();
			frm.cmbMunicipio.style.backgroundColor='#B9DCFF';
			return false;
		}

		frm.action = "AssociarMunicipio.php?acao=associar";
		frm.submit();
	}

	function RemoverMunicipio(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.cmbTerritorio.value == "0")
		{
			alert("Escolha um TERRIT”RIO.");
			frm.cmbTerritorio.focus();
			frm.cmbTerritorio.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.cmbMunicipio.value == "0")
		{
			alert("Escolha um MUNICÕPIO.");
			frm.cmbMunicipio.focus();
			frm.cmbMunicipio.style.backgroundColor='#B9DCFF';
			return false;
		}


		frm.action = "AssociarMunicipio.php?acao=remover";
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

                        <?//inicio titulo da pagina ?>

                        <div id="titulopagina">

                        <table cellpadding="2" cellspacing="2" border="0" width="800" class="TabModulo">
                            <tr>
                                <td width="1"><img src="../images/icones/vazio.gif" width="1" height="1" border="0"></td>
                                <td align="left" class="titulo_pagina">Associar Munic&iacute;pio a Territ&oacute;rio</td>
                                <td width="20" align="right">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="right"><a href="Javascript:history.back(-1)"><img src="../Imagens/voltar.gif" border="0"></a></td>
                                            <td width="21" align="left"><a href="Javascript:history.back(-1)" class="Voltarlink">Voltar</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        </div>

                        <?include "../Include/Inc_Linha.php"?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Territ&oacute;rio</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=f_ComboTerritorio("","",785)?></td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Munic√≠pio</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=f_ComboMunicipioDiaria("BA")?></td>
                                        </tr>
                                    </table>
 								</td>
                        	</tr>
                        </table>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right"><button style="width:190px" onClick="Javascript:RemoverMunicipio(document.Form);" name="btnGravar" class="botao">Remover Munic&iacute;pio do Territ&iacute;rio</button>&nbsp;&nbsp;&nbsp;<button style="width:70px" onClick="Javascript:AssociarForm(document.Form);" name="btnGravar" class="botao">Associar</button></td>
                           </tr>
                        </table>
<?
						If ($MensagemErroBD != "")
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
                          switch ($sucesso)
                        {  case 1:
                                $MensagemErro = "REGISTRO ASSOCIADO COM SUCESSO!";
                                break;
                           case 2:
                                $MensagemErro = "REGISTRO DESASSOCIADO COM SUCESSO!";
                                break;

                        }
?>
                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right" class="MensagemErro"><?=$MensagemErro?></td>
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