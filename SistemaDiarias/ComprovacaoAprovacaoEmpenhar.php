<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseAprovacaoEmpenhar.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>
<style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
<script language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>
<script language="javascript" charset="utf-8">
<!--

	function Foco(frm)
	{
		frm.txtEmpenho.focus();
	}

	function GravarForm(frm)
	 {

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.txtEmpenho.value == "")
		{
			alert("Digite o NÚMERO DO EMPENHO.");
			frm.txtEmpenho.focus();
			frm.txtEmpenho.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtDataEmpenho.value == "")
		{
			alert("Digite a DATA DO EMPENHO.");
			frm.txtDataEmpenho.focus();
			frm.txtDataEmpenho.style.backgroundColor='#B9DCFF';
			return false;
		}


		frm.action = "ComprovacaoAprovacaoEmpenhar.php?acao=empenhar";
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
                                            <td valign="top" class="LinhaTexto">&nbsp;&nbsp;<b>Confirma empenho da solicita&ccedil;&atilde;o abaixo?</td>
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
                                        $linha=pg_fetch_assoc($rsConsulta);
										echo "<tr height='20' bgcolor='#f2f2f2' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
										echo "<td class='GridPaginacaoLink' align='center'>" .$linha['diaria_numero']. "</td>";
										echo "<td class='GridPaginacaoLink' align='left'>&nbsp;" .$linha['pessoa_nm']. "</td>";
										echo "<td class='GridPaginacaoLink' align='center'>" .$linha['diaria_comprovacao_dt_saida']. " " .$linha['diaria_comprovacao_hr_saida']. "</td>";
										echo "<td class='GridPaginacaoLink' align='center'>" .$linha['diaria_comprovacao_dt_chegada']. " " .$linha['diaria_comprovacao_hr_chegada']. "</td>";
										echo "<td class='GridPaginacaoLink' align='left'>&nbsp;" .$linha['motivo_ds']. "</td>";
										echo "</tr>";

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
                                        <tr class="dataLabel" height="21">
                                            <td width="150">&nbsp;Nº do Empenho</td>
                                            <td width="140" colspan="2">&nbsp;Data do Empenho</td>
                                            <td>&nbsp;Valor</td>
                                         </tr>
                                         <tr class="dataField">
                                            <td width="150">&nbsp;<input type="text" name="txtEmpenho" value="" maxlength="30" style="width:120px;" onKeyPress="mascaraNumero(event, this);">&nbsp;*</td>
                                            <td width="120">&nbsp;<input type="text" name="txtDataEmpenho" value="" maxlength="20" style="width:95px;" readonly>&nbsp;*</td>
                                            <td width="20"><a href="#" onClick="javascript:displayCalendar(txtDataEmpenho,'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar CalendÃ¡rio" width="18" height="18"></a></td>
                                            <td>&nbsp;<?=number_format($linha['diaria_comprovacao_saldo'], 2, ',', '.')?></td>
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
	                                <button style="width:70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao">Gravar</button>&nbsp;&nbsp;&nbsp;
                                    <button style="width:70px" onClick="Javascript:history.back(-1);" name="btnConsultar" class="botao">Voltar</button>
                               </td>
                           </tr>
                        </table>

                    </td>
                </tr>
            </table>
		    <input type="hidden" name="txtCodigo" value="<?=$linha['diaria_id']?>">
        </td>
	</tr>
</table>

</form>

</body>
</html>