<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaFinanceiro.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--

	function Foco(frm)
	{
		frm.txtFiltro.focus();
	}

	function FiltrarForm(frm)
	{

		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.txtFiltro.value == "")
		{
			alert("Digite filtro para busca.");
			frm.txtFiltro.focus();
			frm.txtFiltro.style.backgroundColor='#B9DCFF';
			return false;
		}

		frm.action = "SolicitacaoFinanceiroInicio.php?acao=buscar";
		frm.submit();
	}

	function TodosForm(frm)
	{
		frm.txtFiltro.value = "";
		frm.action = "SolicitacaoFinanceiroInicio.php";
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

                        <?include "../Include/Inc_Pesquisa_Sem_Filtro.php"?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                            <tr>
                                <td>
                                    <table border="0" cellpadding="1" cellspacing="1" width="798">
                                        <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                            <td width="100" colspan="3"></td>
                                            <td width="80" align="center">SD</td>
                                            <td width="290" align="left">&nbsp;Nome</td>
                                            <td width="68" align="center">Criada em</td>
                                            <td width="130" align="center">Partida Prevista</td>
                                            <td width="130" align="center">Chegada Prevista</td>
	                                     </tr>
<?
                                         while($linha=pg_fetch_assoc($rsConsulta))
                                         {
												$Codigo	      = $linha['diaria_id'];
												$Beneficiario = $linha['diaria_beneficiario'];
												$Numero		    = $linha['diaria_numero'];
												$Nome		      = $linha['pessoa_nm'];
												$DataPartida  = $linha['diaria_dt_saida'];
												$HoraPartida  = $linha['diaria_hr_saida'];
												$DataChegada  = $linha['diaria_dt_chegada'];
												$HoraChegada  = $linha['diaria_hr_chegada'];
												$DataCriacao  = $linha['diaria_dt_criacao'];
												$Status		    = $linha['diaria_st'];



?>
                                                <?include "IncludeLocal/Inc_Regra_Bloqueio.php"?>
<?
                                                If ($Status == 3)
                                                {
                                                    $strLink = "<a href='SolicitacaoPreLiquidar.php?acao=consultar&cod=" .$Codigo. "'><img src='../Icones/ico_comprovar.png' border='0' alt='Pr&eacute;-Liquidar'></a>";
                                                }
                                                ElseIf ($Status == 4)
                                                {
                                                    $strLink = "<a href='SolicitacaoLiquidar.php?acao=consultar&cod=" .$Codigo. "'><img src='../Icones/ico_comprovar.png' border='0' alt='Liquidar'></a>";
                                                }

                                                echo "<tr height='20' bgcolor='#f2f2f2' class='GridPaginacaoLink' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                /*
                                            '	If (PossuiBloqueio = 1) Then

                                            '		echo "<td colspan='3' align='center'><img src='../icones/ico_aviso.gif' alt='Alerta' border='0'></td>"

                                            '	Else
                                                 *
                                                 */
                                                echo "<td align='center'><a href='SolicitacaoConsultarFinanceiro.php?acao=consultar&cod=".$Codigo."'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";
                                                echo "<td align='center'>".$strLink."</td>";
                                                echo "<td align='center'><a href='SolicitacaoDevolver.php?cod=".$Codigo."'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'></a></td>";
                                                echo "<td align='center'>".$Numero."</td>";
                                                echo "<td>&nbsp;".$Nome."</a></td>";
                                                echo "<td align='center'>".f_FormataData($DataCriacao)."</a></td>";
                                                echo "<td align='center'>".$DataPartida." &agrave;s ".$HoraPartida."</td>";
                                                echo "<td align='center'>".$DataChegada." &agrave;s ".$HoraChegada."</td>";
                                                echo "</tr>";


                                                If ($ContadorVirtual > 0)
                                                {
                                                    echo "<tr height='21'><td colspan='8' class='dataField'>&nbsp;Benefici&aacute;rio com comprova&ccedil;&atilde;o pendente de documenta&ccedil;&atilde;o - ".$NumeroDiariaVirtual." </td></tr>";
                                                }

                                                If ($ContadorAtraso > 0)
                                                {
                                                    echo "<tr height='21'><td colspan='8' class='dataField'>&nbsp;Benefici&aacute;rio com solicita&ccedil;&atilde;o pendente de comprova&ccedil;&atilde;o - ".$NumeroDiariaAtrasada." </td></tr>";
                                                }
                                         }
                                         
?>
                                     </table>
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