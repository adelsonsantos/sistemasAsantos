<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseSistema.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript" charset="utf-8">
<!--

	function Foco(frm)
	{
		frm.txtDescricao.focus();
	}

	function GravarForm(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.txtDescricao.value == "")
		{
			alert("Campo DESCRIÇÃO em Branco.");
			frm.txtDescricao.focus();
			frm.txtDescricao.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtURL.value == "")
		{
			alert("Campo DESCRIÇÃO em Branco.");
			frm.txtURL.focus();
			frm.txtURL.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtCodigo.value == "")
			frm.action = "SistemaCadastrarIncluir.php?acao=incluir";
		else
			frm.action = "SistemaCadastrar.php?acao=alterar";

		frm.submit();
	}

-->
</script>

<body onLoad="WM_initializeToolbar()">

<form name="Form" method="post" enctype="multipart/form-data">

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

                        <table cellpadding="2" cellspacing="2" border="0" width="800" class="TabModulo">
                            <tr>
                                <td width="1"><img src="../images/icones/vazio.gif" width="1" height="1" border="0"></td>
                                <td align="left" class="titulo_pagina">Sistema</td>
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

                        <?// fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="350">&nbsp;Nome do Sistema</td>
                                            <td>&nbsp;URL</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<input name="txtDescricao" maxlength="50" type="text" value="<?=$strDescricao?>" style=" width:265px;"></td>
                                            <td>&nbsp;<input name="txtURL" maxlength="50" type="text" value="<?=$strURL?>" style=" width:265px;">&nbsp;Ex: ../SistemaCadastro/Index.php</td>
                                        </tr>
                                        <tr height="21" class="dataLabel">
                                            <td colspan="2">&nbsp;&Iacute;cone</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td colspan="2">&nbsp;<input name="txtIcone" maxlength="50" type="file" style=" width:265px;"></td>
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
