<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseAcao.php";
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

		frm.action = "AcaoInicio.php?acao=buscar";
		frm.submit();
	}

	function TodosForm(frm)
	{
		frm.txtFiltro.value = "";
		frm.action = "AcaoInicio.php";
		frm.submit();
	}

	function ExcluirForm(frm, checkbox)
	 {
	 	cont = 0;
		for (i = 0 ; i < checkbox.length ; i++)
			if (checkbox[i].checked == true)
			{
				cont = cont + 1;
			}

		if (cont == 0)
		{
			alert("Escolha pelo menos um registro.");
			return false;
		}

		frm.action="AcaoExcluir.php?excluirMultiplo=1";
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

                        <?//inicio titulo da pagina?>

                        <div id="titulopagina">

                        <table cellpadding="2" cellspacing="2" border="0" width="800" class="TabModulo">
                            <tr>
                                <td width="1"><img src="../images/icones/vazio.gif" width="1" height="1" border="0"></td>
                                <td align="left" class="titulo_pagina">Ação</td>
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

                        <?//fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <? //inicio camada do filtro ?>

                        <div id="todofiltro">

                            <table cellpadding="0" cellspacing="0" border="0" width="800" class="leftColumaMenu">
                                <tr>
                                    <td width="5"><img src="../Imagens/tab_esq_home.gif" border="0"></td>
                                    <td style="background-image : url(../Imagens/tab_meio_home.gif);" width="100%">

                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="leftColumaMenu">
                                            <tr>
                                                <td width="16"><img src="../Icones/document_view.gif" width="16" height="16" border="0"></td>
                                                <td width="5"><img src="../Imagens/vazio.gif" width="7" height="1" border="0"></td>
                                                <td width="98%"><b>Filtro</b></td>
                                                <td width="12" align="right">
                                                    <img id="imgrecolhe1" style="cursor:hand;display:block" src="../Imagens/esconde_filtro.gif" alt="Recolhe filtro" onClick="esconde_obj_id(filtro1); esconde_obj_id(imgrecolhe1); mostra_obj_id(imgrecolhe2)" border="0">
                                                    <img id="imgrecolhe2" style="cursor:hand;display:none" src="../Imagens/esconde_filtro2.gif" alt="Mostra filtro" onClick="mostra_obj_id(filtro1); mostra_obj_id(imgrecolhe1); esconde_obj_id(imgrecolhe2)" border="0">
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                    <td width="5"><img src="../Imagens/tab_dir_home.gif" border="0"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center" class="tabFiltro" >

                                        <table cellpadding="0" border="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td><img src="../Imagens/vazio.gif" width="1" height="3" border="0"></td>
                                            </tr>
                                            <tr>
                                                <td valign="top" class="LinhaTexto">
                                                    <div id="filtro1">
                                                        <table cellpadding="0" border="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td width="270" class="dataField">&nbsp;<input name="txtFiltro" maxlength="100" type="text" value="<?=$RetornoFiltro?>" style=" width:265px;"></td>
                                                                <td width="75"><button style="width:70px; height: 17px;" onClick="Javascript:FiltrarForm(document.Form);" class="botao">Filtrar</button></td>
<?
                                                                If ($RetornoFiltro != "")
                                                                {

?>
                                                                    <td><button style="width:90px; height: 17px;" onClick="Javascript:TodosForm(document.Form);" class="botao">Cancelar Filtro</button></td>
<?
                                                                }
                                                                Else
                                                                {
?>
                                                                    <td>&nbsp;</td>
<?
                                                                }
?>
                                                           </tr>
                                                        </table>

                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="../Imagens/vazio.gif" width="1" height="2" border="0"></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                        </div>

                        <?//fim camada do filtro ?>

                        <? include "../Include/Inc_Linha.php"?>

                        <?//inicio da lista de registros ?>

                        <div id="Lista">

                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                            <tr>
                                <td><? include "../Include/Inc_RegistroOpcoes.php"?></td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="1" cellspacing="1">
                                        <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                            <td width="90" colspan="4">&nbsp;</td>
                                            <td width="180" align="center">&nbsp;Sistema</td>
                                            <td width="150" align="center">&nbsp;Seção</td>
                                            <td width="151" align="center">&nbsp;Ação</td>
                                            <td width="70" align="center">Status</td>
                                            <td width="70" align="center">Criado em</td>
                                            <td width="70" align="center">Alterado em</td>
                                        </tr>
<?
										If ($_GET['PaginaMostrada']=="")
										{	$iPageCurrent = 1;

                                        }
										Else
										{	$iPageCurrent = (int)($_GET['PaginaMostrada']);
                                        }

										rsConsulta.CacheSize = iPageSize;

										rsConsulta.PageSize = iPageSize

										iPageCount = rsConsulta.PageCount

										If ($iPageCurrent > $iPageCount)
                                        { $iPageCurrent = $iPageCount;

                                        }

										If ($iPageCurrent < 1)
                                        {  $iPageCurrent = 1;

                                        }

										If ($iPageCount > 0)
                                        {

												rsConsulta.AbsolutePage = $iPageCurrent;
												$iRecordsShown = 0;

												Do While iRecordsShown < iPageSize And Not rsConsulta.EOF
                                                {

														$numCodigo			= rsConsulta("acao_id")
														$strSistema			= rsConsulta("sistema_nm")
														$strSecao			= rsConsulta("secao_ds")
														$strDescricao	   	= rsConsulta("acao_ds")
														$numStatus	   		= rsConsulta("acao_st")
														$strDataCriacao   	= rsConsulta("acao_dt_criacao")
														$strDataAlteracao 	= rsConsulta("acao_dt_alteracao")

														If ($numStatus == "0")
                                                        {   $strStatus = "Ativo";

                                                        }
                                                        Else
                                                        {  $strStatus = "Inativo";

                                                        }

														$CodigoRegistro = $numCodigo

														echo "<tr height='20' bgcolor='#f2f2f2' onMouseOver=javascript:this.style.backgroundColor='#cccccc'
                                                               onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
?>
														<? include "../Include/Inc_Registro.php"?>
<?
														echo "<td class='GridPaginacaoLink' align='left'>&nbsp;" .$strSistema. "</td>"
														echo "<td class='GridPaginacaoLink' align='left'>&nbsp;" .$strSecao. "</td>"
														echo "<td class='GridPaginacaoLink' align='left'>&nbsp;" .$strDescricao. "</td>"
														echo "<td class='GridPaginacaoLink' align='center'><a href=acaoInicio.php?acao=alterarStatus&cod="
                                                             .$numCodigo. "&status=" .$numStatus."><font color='#065387'>" .$strStatus."</font></a></td>";
														echo "<td class='GridPaginacaoLink' align='center'>" .$strDataCriacao. "</td>"
														echo "<td class='GridPaginacaoLink' align='center'>" .$strDataAlteracao. "</td>"
														echo "</tr>"

														$iRecordsShown = $iRecordsShown + 1;

													rsConsulta.MoveNext
                                                }
                                        }
?>
                                     </table>
                                </td>
                            </tr>
                            <tr>
                                <td><? include "../Include/Inc_Paginacao.php"?></td>
                            </tr>
                            <tr>
                                <td><?include "../Include/Inc_RegistroOpcoes.php"?></td>
                            </tr>
                        </table>
                    </div>
                    </td>
                </tr>
            </table>
        </td>
	</tr>
</table>

</form>

</body>
</html>

