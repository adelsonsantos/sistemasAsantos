<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaConsulta.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript" charset="utf-8">
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

		frm.action = "ConsultaDiaria.php?acao=buscar";
		frm.submit();
	}

	function TodosForm(frm)
	{
		frm.txtFiltro.value = "";
		frm.action = "ConsultaDiaria.php";
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
    	<td><?include"../Include/Inc_Aba.php"?></td>
    </tr>
    <tr>
    	<td align="left">
            <table width="990" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td valign="top" align="left" width="190"><?include "../Include/Inc_Menu.php"?></td>
                    <td valign="top" align="left">

                        <?include "../Include/Inc_Titulo.php"?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table cellpadding="0" cellspacing="0" border="0" width="800">
                            <tr>
                                <td align="center" class="tabPesquisa" >
                                    <table cellpadding="0" border="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td width="270" class="dataField">&nbsp;<input name="txtFiltro" maxlength="100" type="text" value="<?=$RetornoFiltro?>" style=" width:265px;"></td>
                                            <td width="75" valign="middle"><button style="width:70px; height: 18px;" onClick="Javascript:FiltrarForm(document.Form);" class="botao">Pesquisar</button></td>
                        <?
                                            If ($RetornoFiltro != "")
                                            {
                        ?>
                                                <td valign="middle"><button style="width:90px; height: 18px;" onClick="Javascript:TodosForm(document.Form);" class="botao">Exibir Todos</button></td>
                        <?
                                            }
                                            Else
                                            {
                        ?>
                                                <td>&nbsp;</td>
                        <?					}


                        ?>
                                            </td>
                                       </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <?include "../Include/Inc_Linha.php"?>

                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                            <tr>
                                <td>
                                    <table border="0" cellpadding="1" cellspacing="1">
                                        <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                            <td width="30"></td>
                                            <td width="80" align="center">SD</td>
                                            <td width="268" align="left">&nbsp;Benefici&aacute;rio</td>
                                            <td width="100" align="center">Partida</td>
                                            <td width="100" align="center">Chegada</td>
                                            <td width="110 "align="center">Processo</td>
                                            <td width="110" align="center">Status</td>
                                        </tr>
<?
										If ($_GET['PaginaMostrada'] == "")
                                        {
											$paginaAtual = 1;
                                        }
										Else
										{	$paginaAtual = (int)($_GET['PaginaMostrada']);
                                        }

										 $qtdRegistroPagina = $iPageSize;

                                        $qtdRegistroTotal = pg_num_rows($rsConsulta);

                                        $qtdIndice = $paginaAtual * $qtdRegistroPagina;

                                        $qtdIndiceFinal = (($qtdIndice + $qtdRegistroPagina)-1);

                                        $qtdPagina = ($qtdRegistroTotal/$qtdRegistroPagina);

                                        $qtdPagina= ceil($qtdPagina);



                                        While((($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal)))
										{       $linha=pg_fetch_assoc($rsConsulta,$qtdIndice);

												$Codigo		  = $linha['diaria_id'];
												$Numero		  = $linha['diaria_numero'];
												$DataPartida  = $linha['diaria_dt_saida'];
												$HoraPartida  = $linha['diaria_hr_saida'];
												$DataChegada  = $linha['diaria_dt_chegada'];
												$HoraChegada  = $linha['diaria_hr_chegada'];
												$Processo	  = $linha['diaria_processo'];
												$Status		  = $linha['diaria_st'];
												$Nome		  = $linha['pessoa_nm'];



?>
												<?include "IncludeLocal/Inc_Status_Diaria.php"?>
<?
                                                echo "<tr height='30' bgcolor='#f2f2f2' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";

                                                If ($Status < 7)
                                                {
                                                    echo "<td align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=".$Codigo."'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";
                                                }
                                                Else
                                                {	echo "<td align='center'><a href='ComprovacaoConsultar.php?acao=consultar&cod=" .$Codigo. "'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";
                                                }

                                                echo "<td class='GridPaginacaoLink' align='center'>".$Numero."</td>";
                                                echo "<td class='GridPaginacaoLink' align='left'>&nbsp;".substr($Nome,0,30)."</td>";
                                                echo "<td class='GridPaginacaoLink' align='center'>".$DataPartida." ".$HoraPartida."</td>";
                                                echo "<td class='GridPaginacaoLink' align='center'>".$DataChegada." ".$HoraChegada."</td>";
                                                echo "<td class='GridPaginacaoLink' align='center'>".$Processo."</td>";
                                                echo "<td class='GridPaginacaoLink' align='center'><font color='#000099'>".$StatusNome."</font></td>";
                                                echo "</tr>";

                                                $qtdIndice++;
                                             }

                                        $paginaAtual++;
?>
                                     </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?include "../Include/Inc_Paginacao.php"?></td>
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