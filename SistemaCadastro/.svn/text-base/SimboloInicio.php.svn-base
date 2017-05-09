<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseSimbolo.php";
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

		frm.action = "SimboloInicio.php?acao=buscar";
		frm.submit();
	}

	function TodosForm(frm)
	{
		frm.txtFiltro.value = "";
		frm.action = "SimboloInicio.php";
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

		frm.action="SimboloExcluir.php?excluirMultiplo=1";
		frm.submit();
	 }

	function AlterarForm(frm, checkbox)
	 {
	 	cont = 0;
		for (i = 0 ; i < checkbox.length ; i++)
			if (checkbox[i].checked == true)
			{
				cont = cont + 1;
			}

		if (cont == 0)
		{
			alert("Escolha um registro.");
			return false;
		}

		if (cont > 1)
		{
			alert("Escolha apenas registro.");
			return false;
		}

		frm.action="SimboloCadastrar.php?acao=consultar";
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

                        <?// inicio titulo da pagina ?>

                        <div id="titulopagina">

                        <?include "../Include/Inc_Titulo.php"?>

                        </div>

                        <?// fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <?// inicio camada do filtro ?>

                        <div id="todofiltro">

                        <?include "../Include/Inc_Pesquisa.php"?>

                        </div>

                        <?// fim camada do filtro ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <?// inicio da lista de registros ?>

                        <div id="Lista">

                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                            <tr>
                                <td><?include "../Include/Inc_RegistroOpcoes.php"?></td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="1" cellspacing="1" width="798">
                                        <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                            <td width="100" colspan="4" align="center">A&ccedil;&otilde;es</td>
                                            <td width="428" align="center">S&iacute;mbolo</td>
                                            <td width="80" align="center">Sal&aacute;rio</td>
                                            <td width="80" align="center">Di&aacute;ria</td>
                                            <td width="80" align="center">Status</td>
                                            <td width="30" align="center">&nbsp;</td>
                                        </tr>
<?


										$paginaAtual =(int) $_GET['PaginaMostrada'];

                                        $qtdRegistroPagina = $iPageSize;

                                        $qtdRegistroTotal = pg_num_rows($rsConsulta);

                                        $qtdIndice = $paginaAtual * $qtdRegistroPagina;

                                        $qtdIndiceFinal = (($qtdIndice + $qtdRegistroPagina)-1);

                                        $qtdPagina = ($qtdRegistroTotal/$qtdRegistroPagina);

                                        $qtdPagina= ceil($qtdPagina);



                                        While((($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal)))
										{       $linha=pg_fetch_assoc($rsConsulta,$qtdIndice);



												$numCodigo			= $linha['simbolo_id'];
												$strDescricao	   	= $linha['simbolo_ds'];
												$strSalario 		= $linha['simbolo_salario'];
												$strValorDiaria		= $linha['simbolo_valor_diaria'];
												$numStatus	   		= $linha['simbolo_st'];
												$strDataCriacao   	= $linha['simbolo_dt_criacao'];
												$strDataAlteracao 	= $linha['simbolo_dt_alteracao'];



														If ($strDataAlteracao != "")
                                                        {
															$strTextoAlteracao = " - Alterado em " .$strDataAlteracao;
                                                        }
														Else
														{	$strTextoAlteracao = "";

                                                        }

														If ($numStatus == "0")
                                                        {  $strStatus = "Ativo";

                                                        }

														$CodigoRegistro = $numCodigo;

														echo "<tr height='20' bgcolor='#f2f2f2' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
?>
														<?include "../Include/Inc_Registro.php"?>
<?
														echo "<td class='GridPaginacaoLink'>&nbsp;".$strDescricao."</td>";
														echo "<td class='GridPaginacaoLink' align='center'>R$".$strSalario."</td>";
														echo "<td class='GridPaginacaoLink' align='center'>R$".$strValorDiaria."</td>";
														echo "<td class='GridPaginacaoLink' align='center'><a href=SimboloInicio.php?acao=alterarStatus&cod=".$numCodigo."&status=".$numStatus."><font color='#065387'>".$strStatus."</font></a></td>";
														echo "<td align='center'><img src='..\imagens\calendar.gif' alt='Criado em ".$strDataCriacao.$strTextoAlteracao."'></td>";

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
