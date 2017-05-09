﻿<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseTerceirizado.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>

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

		frm.action = "TerceirizadoInicio.php?acao=buscar";
		frm.submit();
	}

	function TodosForm(frm)
	{
		frm.txtFiltro.value = "";
		frm.action = "TerceirizadoInicio.php";
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

		frm.action="TerceirizadoExcluir.php?excluirMultiplo=1";
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

		frm.action="TerceirizadoCadastrar.php?acao=consultar";
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
    	<td>
            <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td valign="top" align="left" width="190"><?include "../Include/Inc_Menu.php"?></td>
                    <td valign="top" align="left">

                        <?include "../Include/Inc_Titulo.php"?>

                        <?include "../Include/Inc_Linha.php"?>

                        <?include "../Include/Inc_Pesquisa.php"?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                            <tr>
                                <td><?include "../Include/Inc_RegistroOpcoes.php"?></td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="1" cellspacing="1">
                                        <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                            <td width="80" colspan="4">&nbsp;</td>
                                            <td width="100" align="left">&nbsp;Matr&iacute;cula</td>
                                            <td width="428" align="left">&nbsp;Nome</td>
                                            <td width="130">&nbsp;Contrato</td>
                                            <td width="60" align="center">Status</td>
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

												$Codigo				= $linha['pessoa_id'];
												$Matricula  		= $linha['funcionario_matricula'];
												$ContratoNumero		= $linha['contrato_num'];
												$Nome	   			= $linha['pessoa_nm'];
												$StatusNumero		= $linha['pessoa_st'];



														If ($StatusNumero == "0")
                                                        {  $StatusNome = "Ativo";

                                                        }
                                                         Else
                                                         {  $StatusNome = "Inativo";

                                                         }

														$CodigoRegistro = $Codigo;

														echo "<tr class='GridPaginacaoLink' height='20' bgcolor='#f2f2f2' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
?>
														<?include "../Include/Inc_Registro.php"?>
<?
														echo "<td>&nbsp;".$Matricula."</td>";
														echo "<td>&nbsp;".$Nome."</td>";
														echo "<td>&nbsp;".$ContratoNumero."</td>";
														echo "<td align='center'><a href=TerceirizadoInicio.php?acao=alterarStatus&cod=".$Codigo."&status=" .$StatusNumero."><font color='#065387'>".$StatusNome. "</font></a></td>";
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