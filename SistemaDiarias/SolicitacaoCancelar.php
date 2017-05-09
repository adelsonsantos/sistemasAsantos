<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaCancelar.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--

	function Foco(frm)
	{
		frm.cmbMotivoDiaria.focus();
	}

	function GravarForm(frm)
	 {

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.cmbMotivoDiaria.value == "0")
		{
			alert("Escolha um MOTIVO DE CANCELAMENTO.");
			frm.cmbMotivoDiaria.focus();
			frm.cmbMotivoDiaria.style.backgroundColor='#B9DCFF';
			return false;
		}

		frm.action = "SolicitacaoCancelar.php?acao=cancelar";
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

                        <table cellpadding="0" cellspacing="0" border="0" width="800">
                            <tr>
                                <td align="center" class="tabPesquisa" >

                                    <table cellpadding="0" border="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td><img src="../SistemaCadastro/Imagens/vazio.gif" width="1" height="3" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="LinhaTexto">&nbsp;&nbsp;<b>Confirma cancelamento da solicita&ccedil;&atilde;o abaixo?</td>
                                        </tr>
                                        <tr>
                                            <td><img src="../SistemaCadastro/Imagens/vazio.gif" width="1" height="2" border="0"></td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                        <?include "../Include/Inc_Linha.php"?>

                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                            <tr>
                                <td>
                                    <table border="0" cellpadding="1" cellspacing="1" width="798">
                                        <tr height="21" class="GridPaginacaoRegistroCabecalho">
                                            <td width="100" align="center">SD</td>
                                            <td width="250" align="left">&nbsp;Nome</td>
                                            <td width="110" align="center">Partida Prevista</td>
                                            <td width="110" align="center">Chegada Prevista</td>
                                            <td width="228" align="left">&nbsp;Motivo da Viagem</td>
                                        </tr>
<?

                                         while($linharsConsulta=pg_fetch_assoc($rsConsulta))
                                         {
                                            echo "<tr height='20' bgcolor='#f2f2f2' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                            echo "<td class='GridPaginacaoLink' align='center'>" .$linharsConsulta['diaria_numero']."</td>";
                                            echo "<td class='GridPaginacaoLink' align='left'>&nbsp;" .$linharsConsulta['pessoa_nm']."</td>";
                                            echo "<td class='GridPaginacaoLink' align='center'>" .$linharsConsulta['diaria_dt_saida']." " .$linharsConsulta['diaria_hr_saida']."</td>";
                                            echo "<td class='GridPaginacaoLink' align='center'>" .$linharsConsulta['diaria_dt_chegada']." " .$linharsConsulta['diaria_hr_chegada']."</td>";
                                            echo "<td class='GridPaginacaoLink' align='left'>&nbsp;" .$linharsConsulta['motivo_ds']."</td>";
                                            echo "</tr>";
                                         }

?>
                                     </table>
                                </td>
                            </tr>
                        </table>

						<br>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                            <tr>
                                <td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLabel" width="150">&nbsp;Motivo do Cancelamento</td>
                                            <td class="dataField" width="648">&nbsp;<?=ComboMotivoDiaria(0,1,"")?>&nbsp;*</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Descri&ccedil;&atilde;o</td>
                                            <td class="dataField">&nbsp;<textarea name="txtDescricao" style=" width:309px; height:60px" maxlenght="255"></textarea></td>
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

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
                                <?
								//echo rsConsulta("diaria_solicitante")
								//	If (Session("UsuarioCodigo") = rsConsulta("diaria_solicitante")) Or (Session("UsuarioCodigo") = rsConsulta("diaria_beneficiario")) Then
								?>
									<button style="width:70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao">Gravar</button>&nbsp;&nbsp;&nbsp;                                 &nbsp;&nbsp;&nbsp;
                                <?
								//	End If
								?>

                                    <button style="width:70px" onClick="Javascript:Javascript:history.back(-1);" name="btnConsultar" class="botao">Voltar</button>
                               </td>
                           </tr>
                        </table>

                    </td>
                </tr>
            </table>
		    <input type="hidden" name="txtCodigo" value="<?=$Codigo?>">
        </td>
	</tr>
</table>

</form>

</body>
</html>