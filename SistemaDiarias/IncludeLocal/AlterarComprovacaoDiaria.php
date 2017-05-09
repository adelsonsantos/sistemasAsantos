<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaComprovacao.php";

	$_SESSION['ContadorDestino'] = "";
	$_SESSION['RelacaoViagem']   = "";
	$_SESSION['ViagemOrigem']  = "";
	$_SESSION['ViagemDestino'] = "";
	$_SESSION['PossuiRoteiro'] = "";
	$_SESSION['PercentualRecebido'] = "";
	$_SESSION['ErroRoteiro'] = "";
	$_SESSION['NumeroDiarias'] = "";
	$_SESSION['PossuiFeriado'] = "";
	$_SESSION['PossuiFimSemana']	= "";
	$_SESSION['ValorTotal'] = "";
	$_SESSION['ValorPercentual'] = "";
	$_SESSION['Origem'] = "";

?>

<html>
<style type="text/css">@import url("../css/estilo.css"); </style>
<style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>
<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
<script language="javascript" src="../JavaScript/ScriptAjax.js"></script>
<script language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>
<script language="javascript" src="JavaScript/Diaria.js"></script>
<script language="javascript" src="funcoes.js"> </script>
<script language="javascript" charset="utf-8">
<!--
	function HabilitaComplemento()
	{
		alert("Diária foi recalculada com sucesso!");

		if (document.Form.txtDiaria60.value == 1)
		{
			document.getElementById("ComplementoValor").style.display = '';
			document.Form.txtValorCampoComplemento.value = 1;
		}
		else
		{
			document.getElementById("ComplementoValor").style.display = 'none';
		}

	}

	function LimparDados(frm)
	{
		frm.action = "SolicitacaoCadastrar.php";
		frm.submit();
	}

	function AlterarRoteiro(frm)
	{
		frm.action = "AlterarComprovacaoDiaria.php?alterarRoteiro=1&acao=consultar&cod=<?=$Codigo?>&recalcular=0";
		frm.txtAlterouCalculo.value = 0;
		frm.submit();
	}

	function PedeNovoCalculo(frm)
	{
		frm.txtAlterouCalculo.value = 0;
	}

	function GravarForm(frm)
	{
	
		for(cont=0; cont < frm.elements.length; cont++)
			frm.elements[cont].style.backgroundColor = '';

		if (frm.txtAlterouCalculo.value == "0")
		{
			alert("Calcule a DIÁRIA.");
			return false;
		}

		if (frm.txtDataPartida.value == "")
		{
			alert("Digite a DATA DE PARTIDA.");
			document.getElementById("formaba1").style.display = '';
			document.getElementById("formaba2").style.display = 'none';
			document.getElementById("formaba3").style.display = 'none';
			document.getElementById("aba1_on").style.display = '';
			document.getElementById("aba1_off").style.display = 'none';
			document.getElementById("aba2_on").style.display = 'none';
			document.getElementById("aba2_off").style.display = '';
			document.getElementById("aba3_on").style.display = 'none';
			document.getElementById("aba3_off").style.display = '';
			frm.txtDataPartida.focus();
			frm.txtDataPartida.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.Calculo.value != "0")
		{
			if (frm.txtDataPartida.value != frm.txtConfDataPartida.value)
			{
				alert("A DATA DE PARTIDA calculada é diferente da DATA DE PARTIDA informada.");
				document.getElementById("formaba1").style.display = '';
				document.getElementById("formaba2").style.display = 'none';
				document.getElementById("formaba3").style.display = 'none';
				document.getElementById("aba1_on").style.display = '';
				document.getElementById("aba1_off").style.display = 'none';
				document.getElementById("aba2_on").style.display = 'none';
				document.getElementById("aba2_off").style.display = '';
				document.getElementById("aba3_on").style.display = 'none';
				document.getElementById("aba3_off").style.display = '';
				frm.txtDataPartida.focus();
				frm.txtDataPartida.style.backgroundColor='#B9DCFF';
				return false;
			}
		}

		if (frm.txtHoraPartida.value == "")
		{
			alert("Digite a HORA DE PARTIDA.");
			document.getElementById("formaba1").style.display = '';
			document.getElementById("formaba2").style.display = 'none';
			document.getElementById("formaba3").style.display = 'none';
			document.getElementById("aba1_on").style.display = '';
			document.getElementById("aba1_off").style.display = 'none';
			document.getElementById("aba2_on").style.display = 'none';
			document.getElementById("aba2_off").style.display = '';
			document.getElementById("aba3_on").style.display = 'none';
			document.getElementById("aba3_off").style.display = '';

			frm.txtHoraPartida.focus();
			frm.txtHoraPartida.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.Calculo.value != "0")
		{
			if (frm.txtHoraPartida.value != frm.txtConfHoraPartida.value)
			{
				alert("A HORA DE PARTIDA calculada é diferente da HORA DE PARTIDA informada.");
				document.getElementById("formaba1").style.display = '';
				document.getElementById("formaba2").style.display = 'none';
				document.getElementById("formaba3").style.display = 'none';
				document.getElementById("aba1_on").style.display = '';
				document.getElementById("aba1_off").style.display = 'none';
				document.getElementById("aba2_on").style.display = 'none';
				document.getElementById("aba2_off").style.display = '';
				document.getElementById("aba3_on").style.display = 'none';
				document.getElementById("aba3_off").style.display = '';

				frm.txtHoraPartida.focus();
				frm.txtHoraPartida.style.backgroundColor='#B9DCFF';
				return false;
			}
		}

		if (frm.txtDataChegada.value == "")
		{
			alert("Digite a DATA DE CHEGADA.");
			document.getElementById("formaba1").style.display = '';
			document.getElementById("formaba2").style.display = 'none';
			document.getElementById("formaba3").style.display = 'none';
			document.getElementById("aba1_on").style.display = '';
			document.getElementById("aba1_off").style.display = 'none';
			document.getElementById("aba2_on").style.display = 'none';
			document.getElementById("aba2_off").style.display = '';
			document.getElementById("aba3_on").style.display = 'none';
			document.getElementById("aba3_off").style.display = '';
			frm.txtDataChegada.focus();
			frm.txtDataChegada.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.Calculo.value != "0")
		{
			if (frm.txtDataChegada.value != frm.txtConfDataChegada.value)
			{
				alert("A DATA DE CHEGADA calculada é diferente da DATA DE CHEGADA informada.");
				document.getElementById("formaba1").style.display = '';
				document.getElementById("formaba2").style.display = 'none';
				document.getElementById("formaba3").style.display = 'none';
				document.getElementById("aba1_on").style.display = '';
				document.getElementById("aba1_off").style.display = 'none';
				document.getElementById("aba2_on").style.display = 'none';
				document.getElementById("aba2_off").style.display = '';
				document.getElementById("aba3_on").style.display = 'none';
				document.getElementById("aba3_off").style.display = '';
				frm.txtDataChegada.focus();
				frm.txtDataChegada.style.backgroundColor='#B9DCFF';
				return false;
			}
		}

		if (frm.txtHoraChegada.value == "")
		{
			alert("Digite a HORA DE CHEGADA.");
			document.getElementById("formaba1").style.display = '';
			document.getElementById("formaba2").style.display = 'none';
			document.getElementById("formaba3").style.display = 'none';
			document.getElementById("aba1_on").style.display = '';
			document.getElementById("aba1_off").style.display = 'none';
			document.getElementById("aba2_on").style.display = 'none';
			document.getElementById("aba2_off").style.display = '';
			document.getElementById("aba3_on").style.display = 'none';
			document.getElementById("aba3_off").style.display = '';
			frm.txtHoraChegada.focus();
			frm.txtHoraChegada.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.Calculo.value != "0")
		{
			if (frm.txtHoraChegada.value != frm.txtConfHoraChegada.value)
			{
				alert("A HORA DE CHEGADA calculada é diferente da HORA DE CHEGADA informada.");
				document.getElementById("formaba1").style.display = '';
				document.getElementById("formaba2").style.display = 'none';
				document.getElementById("formaba3").style.display = 'none';
				document.getElementById("aba1_on").style.display = '';
				document.getElementById("aba1_off").style.display = 'none';
				document.getElementById("aba2_on").style.display = 'none';
				document.getElementById("aba2_off").style.display = '';
				document.getElementById("aba3_on").style.display = 'none';
				document.getElementById("aba3_off").style.display = '';

				frm.txtHoraChegada.focus();
				frm.txtHoraChegada.style.backgroundColor='#B9DCFF';
				return false;
			}
		}


		if (frm.Calculo.value != "0")
		{
			if (frm.PossuiFeriado.value == "True")
			{
				if (frm.txtJustificativaFeriado.value == "")
				{
					alert("Digite a JUSTIFICATIVA DO FERIADO.");
					document.getElementById("formaba1").style.display = '';
					document.getElementById("formaba2").style.display = 'none';
					document.getElementById("formaba3").style.display = 'none';
					document.getElementById("aba1_on").style.display = '';
					document.getElementById("aba1_off").style.display = 'none';
					document.getElementById("aba2_on").style.display = 'none';
					document.getElementById("aba2_off").style.display = '';
					document.getElementById("aba3_on").style.display = 'none';
					document.getElementById("aba3_off").style.display = '';

					frm.txtJustificativaFeriado.focus();
					frm.txtJustificativaFeriado.style.backgroundColor='#B9DCFF';
					return false;
				}
			}
		}

		if (frm.Calculo.value != "0")
		{
			if (frm.PossuiFimSemana.value == "True")
			{
				if (frm.txtJustificativaFimSemana.value == "")
				{
					alert("Digite a JUSTIFICATIVA DO FIM DE SEMANA.");
					document.getElementById("formaba1").style.display = '';
					document.getElementById("formaba2").style.display = 'none';
					document.getElementById("formaba3").style.display = 'none';
					document.getElementById("aba1_on").style.display = '';
					document.getElementById("aba1_off").style.display = 'none';
					document.getElementById("aba2_on").style.display = 'none';
					document.getElementById("aba2_off").style.display = '';
					document.getElementById("aba3_on").style.display = 'none';
					document.getElementById("aba3_off").style.display = '';
					frm.txtJustificativaFimSemana.focus();
					frm.txtJustificativaFimSemana.style.backgroundColor='#B9DCFF';
					return false;
				}
			}

		}

		if (frm.txtValorCampoComplemento.value == 1)
		{
			if (frm.chkComplemento.checked == true)
			{
				if (frm.txtComplemento.value == "")
				{
					alert("Digite a JUSTIFICATIVA DO COMPLEMENTO.");
					document.getElementById("formaba1").style.display = '';
					document.getElementById("formaba2").style.display = 'none';
					document.getElementById("formaba3").style.display = 'none';
					document.getElementById("aba1_on").style.display = '';
					document.getElementById("aba1_off").style.display = 'none';
					document.getElementById("aba2_on").style.display = 'none';
					document.getElementById("aba2_off").style.display = '';
					document.getElementById("aba3_on").style.display = 'none';
					document.getElementById("aba3_off").style.display = '';
					frm.txtComplemento.focus();
					frm.txtComplemento.style.backgroundColor='#B9DCFF';
					return false;
				}
			}
		}

		if (frm.txtResumo.value == "")
		{
			alert("Digite o RESUMO DA DIÁRIA.");
			document.getElementById("formaba1").style.display = 'none';
			document.getElementById("formaba2").style.display = 'none';
			document.getElementById("formaba3").style.display = '';
			document.getElementById("aba1_on").style.display = 'none';
			document.getElementById("aba1_off").style.display = '';
			document.getElementById("aba2_on").style.display = 'none';
			document.getElementById("aba2_off").style.display = '';
			document.getElementById("aba3_on").style.display = '';
			document.getElementById("aba3_off").style.display = 'none';
			frm.txtResumo.focus();
			frm.txtResumo.style.backgroundColor='#B9DCFF';
			return false;
		}

		frm.action = "AlterarComprovacaoDiaria.php?acao=alterarComprovacao";
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

                    <table cellpadding="2" cellspacing="2" border="0" width="800" class="TabModulo">
                        <tr>
                            <td align="left" class="titulo_pagina">&nbsp;Di&aacute;ria \ Comprova&ccedil;&atilde;o</td>
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

                        <?include "../Include/Inc_Linha.php"?>

                        <table cellpadding="0" cellspacing="0" border="0" width="800">
                            <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="0" border="0" width="800">
                                        <tr>
                                            <?// aba 1 ?>
                                            <td>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba1_on">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_esq_on.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_on.gif" align="center" class="linktab">Di&aacute;ria</td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_dir_on.gif" width="7" height="18"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18"></td>
                                            <td>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba1_off" style="cursor:hand;display:none">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_esq_off.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_off.gif" align="center"><a class="linktab" href="#" onClick="mostra_obj_id(aba1_on); esconde_obj_id(aba1_off); mostra_obj_id(formaba1); mostra_obj_id(aba2_off); esconde_obj_id(aba2_on); esconde_obj_id(formaba2); mostra_obj_id(aba3_off); esconde_obj_id(aba3_on); esconde_obj_id(formaba3);">Di&aacute;ria</a></td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_dir_off.gif" width="7" height="18"></td>
                                                    </tr>
                                                 </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18"></td>
                                            <td>
                                            <?// aba 2 ?>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba2_on" style="cursor:hand;display:none">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_esq_on.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_on.gif" align="center" class="linktab">Projeto</td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_dir_on.gif" width="7" height="18"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18"></td>
                                            <td>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba2_off">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_esq_off.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_off.gif" align="center"><a class="linktab" href="#" onClick="esconde_obj_id(aba1_on); mostra_obj_id(aba1_off); esconde_obj_id(formaba1); esconde_obj_id(aba2_off); mostra_obj_id(aba2_on); mostra_obj_id(formaba2); mostra_obj_id(aba3_off); esconde_obj_id(aba3_on); esconde_obj_id(formaba3);">Projeto</a></td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_dir_off.gif" width="7" height="18"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18"></td>
                                            <?// aba 3 ?>
                                            <td>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba3_on" style="cursor:hand;display:none">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_esq_on.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_on.gif" align="center" class="linktab">Resumo</td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_dir_on.gif" width="7" height="18"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18"></td>
                                            <td>
                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba3_off">
                                                    <tr>
                                                        <td width="7" align="left" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_esq_off.gif" width="7" height="18"></td>
                                                        <td background="../Imagens/bgaba_off.gif" align="center"><a class="linktab" href="#" onClick="esconde_obj_id(aba1_on); mostra_obj_id(aba1_off); esconde_obj_id(formaba1); mostra_obj_id(aba2_off); esconde_obj_id(aba2_on); esconde_obj_id(formaba2); esconde_obj_id(aba3_off); mostra_obj_id(aba3_on); mostra_obj_id(formaba3);">Resumo</a></td>
                                                        <td width="7" align="right" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_dir_off.gif" width="7" height="18"></td>
                                                    </tr>
                                                 </table>
                                            </td>
                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="180" height="18"></td>
										</tr>
                            		</table>
                            	</td>
 				            </tr>
                            <tr>
                                <td align="center" class="tabFiltro"><img src="../Imagens/vazio.gif" width="1" height="10"></td>
                            </tr>
                        </table>

						<?include "../Include/Inc_Linha.php"?>

                        <div id="formaba1" style="display:show">

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="50%">&nbsp;Solicitante</td>
                                            <td width="50%">&nbsp;Beneficiário</td>
                                        </tr>

                                        <tr height="21" class="dataField">
                                        <? $linharsSolicitante=pg_fetch_assoc($rsSolicitante);?>
                                            <td>&nbsp;<?=$linharsSolicitante['pessoa_nm']?></td>
                                            <td>&nbsp;<?=$linhaBeneficiario['pessoa_nm']?><input type="hidden" name="txtAlterouCalculo" value="<?=$AlterouCalculo?>"></td>
                                        </tr>

                                        <tr height="21" class="dataTitulo">
                                            <td colspan="2">&nbsp;Roteiro</td>
                                        </tr>
                                        <tr height="21" class="dataLabel">
                                            <td>&nbsp;Origem</td>
                                            <td>&nbsp;Destino</td>
                                        </tr>
<?
										If ($AlterarRoteiro == 1)
                                        {
?>
                                                <tr>
                                                    <td>
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr height="21" class="dataField">
                                                                <td width="50">&nbsp;<?=f_ComboEstado("cmbRoteiroOrigemUF", "onChange=MandaID(this.value,'AjaxRoteiroOrigem','estado_id')","")?></td>
                                                                <td><div id="RoteiroOrigem"><?=f_ComboMunicipio("cmbRoteiroOrigemMunicipio","","")?></div></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table cellpadding="0" cellspacing="0" border="0" width="399">
                                                            <tr height="21" class="dataField">
                                                                <td width="50">&nbsp;<?=f_ComboEstado("cmbRoteiroDestinoUF", "onChange=MandaID(this.value,'AjaxRoteiroDestino','estado_id')","")?></td>
                                                                <td><div id="RoteiroDestino"><?=f_ComboMunicipio("cmbRoteiroDestinoMunicipio","","")?></div></td>
                                                                <td width="120">
                                                                	<input type="button" name="btnAdicionar" style=" width:55px;" value="Adicionar" onClick="AdicionaRoteiro(document.Form.cmbRoteiroOrigemMunicipio.value,document.Form.cmbRoteiroDestinoMunicipio.value,'AjaxRoteiroAdicionar');PedeNovoCalculo(document.Form);">&nbsp;
<?
																	If ($Codigo == "")
                                                                    {
?>
                                                                   	 <input type="button" style=" width:55px;" value="Limpar" onClick="LimparDados(document.Form);">
<?
                                                                    }
                                                                    Else
                                                                    {
?>
                                                                   	 <input type="button" style=" width:55px;" value="Limpar" onClick="AlterarRoteiro(document.Form);">&nbsp;
<?
                                                                    }
?>
																</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
<?
                                        }
                                        Else
                                        {

											If ($Comprovada == 0)
                                            {
												$sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = " .$Codigo;
                                            }
                                            ElseIf ($Comprovada == 1)
                                            {
												$sqlRoteiro = "SELECT roteiro_comprovacao_origem, roteiro_comprovacao_destino FROM diaria.roteiro_comprovacao WHERE diaria_id = " .$Codigo;
                                            }

                                            $rsRoteiro = pg_query(abreConexao(),$sqlRoteiro);

											$j = 0;

                                            While($linharsRoteiro=pg_fetch_assoc($rsRoteiro))
                                            {

                                                If ($Comprovada == 0)
                                                {
                                                    $RoteiroOrigem = $linharsRoteiro['roteiro_origem'];
                                                    $RoteiroDestino = $linharsRoteiro['roteiro_destino'];
                                                }
                                                ElseIf ($Comprovada == 1)
                                                {
                                                    $RoteiroOrigem = $linharsRoteiro['roteiro_comprovacao_origem'];
                                                    $RoteiroDestino = $linharsRoteiro['roteiro_comprovacao_destino'];
                                                }

                                                $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$RoteiroOrigem;

                                                $rsRoteiroOrigem = pg_query(abreConexao(),$sqlRoteiroOrigem);

                                                $linharsRoteiroOrigem=pg_fetch_assoc($rsRoteiroOrigem);

                                                $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " .$RoteiroDestino;
                                                $rsRoteiroDestino = pg_query(abreConexao(),$sqlRoteiroDestino);
                                                $linharsRoteiroDestino=pg_fetch_assoc($rsRoteiroDestino);

                                                echo "<tr class='dataField' height='21'>";
                                                echo "<td>&nbsp;" .$linharsRoteiroOrigem['estado_uf']. "- ".$linharsRoteiroOrigem['municipio_ds']. "</td>";
                                                echo "<td>&nbsp;" .$linharsRoteiroDestino['estado_uf']. "- " .$linharsRoteiroDestino['municipio_ds']."</td>";
                                                echo "</tr>";

                                                If ($j == 0)
                                                {

                                                    //verifica se o municipio eh da bahia
                                                    $sqlConsultaUF = "SELECT estado_uf FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiroDestino['municipio_cd'];
                                                    $rsConsultaUF = pg_query(abreConexao(),$sqlConsultaUF);
                                                    $linharsConsultaUF=pg_fetch_assoc($rsConsultaUF);

                                                    If ($linharsConsultaUF['estado_uf']!= "BA")
                                                    {
                                                        //verifica o percentual do municipio para calculo
                                                        $sqlConsultaCidade = "SELECT percentual_ds FROM diaria.percentual_capital pc, diaria.percentual p WHERE (pc.percentual_id = p.percentual_id) AND municipio_cd = " .$linharsRoteiroDestino['municipio_cd'];
                                                        $rsConsultaCidade = pg_query(abreConexao(),$sqlConsultaCidade);

                                                        $linharsConsultaCidade=pg_fetch_assoc($rsConsultaCidade);

                                                        If ($linharsConsultaCidade)
                                                        {

                                                            $Percentual = $linharsConsultaCidade['percentual_ds'];
                                                        }

                                                        Else
                                                        {
                                                            $sql3 = "SELECT percentual_ds FROM diaria.percentual WHERE percentual_id = 2";
                                                            $rs3 = pg_query(abreConexao(),$sql3);
                                                            $linhars3=pg_fetch_assoc($rs3);

                                                            $Percentual = $linhars3['percentual_ds']; //recebe valor padrao de calculo

                                                        }
                                                    }

                                                    Else
                                                    {
                                                        $Percentual = 0; //nao altera o calculo, so para cidades da bahia

                                                    }

                                                    $j = 1;

                                                }

											}

?>
									<tr class="dataField">
                                    	<td colspan="2" align="right"><input type="button" style=" width:85px;" value="Alterar Roteiro" onClick="AlterarRoteiro(document.Form);">&nbsp;</td>
                                    </tr>
									<input name="txtPercentual" type="hidden" value="<?=$Percentual;?>">											
<?
										
                                        }
?>
                                    </table>

                                    <div id="Roteiro"></div>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td colspan="8" class="dataLabel">&nbsp;Complemento do Roteiro</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="dataField">&nbsp;<input type="text" name="txtRoteiroComplemento" size="154" maxlentgh="120" value="<?=$RoteiroComplemento?>"></td>
                                        </tr>
                                        <tr height="21" class="dataTitulo">
                                            <td width="359" colspan="3">&nbsp;Partida Prevista</td>
                                            <td width="359" colspan="3">&nbsp;Chegada Prevista</td>
                                            <td width="160" colspan="2">&nbsp;Quantidade e Valor Previsto</td>
                                        </tr>
                                        <tr height="21" class="dataLabel">
                                            <td width="80">&nbsp;Data</td>
                                            <td width="80">&nbsp;Hora</td>
                                            <td width="139">&nbsp;Dia da Semana</td>
                                            <td width="80">&nbsp;Data</td>
                                            <td width="80">&nbsp;Hora</td>
                                            <td width="139">&nbsp;Dia da Semana</td>
                                            <td width="80">&nbsp;Qtde Di&aacute;rias</td>
                                            <td width="120">&nbsp;Valor Total</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td width="80">&nbsp;<?=$DataPartida?></td>
                                            <td width="80">&nbsp;<?=$HoraPartida?></td>

                                            <td width="139">&nbsp;<?=diasemana($DataPartida)?></td>
                                            <td width="80">&nbsp;<?=$DataChegada?></td>
                                            <td width="80">&nbsp;<?=$HoraChegada?></td>
                                            <td width="139">&nbsp;<?=diasemana($DataChegada)?></td>
                                            <td width="80">&nbsp;<?=$QtdeDiaria?></td>
                                            <td width="120">&nbsp;<input type="text" name="txtValorAnterior" value="<?=$ValorDiaria?>"  class="Invisivel" size="14" readonly></td>
                                        </tr>
									</table>

									<table width="798" border="0" cellpadding="0" cellspacing="1">
									<tr height="21" class="dataTitulo">
									<td width="399" colspan="4">&nbsp;Partida Realizada</td>
									<td width="399" colspan="4">&nbsp;Chegada Realizada</td>
									</tr>
									<tr height="21" class="dataLabel">
									<td width="100" colspan="2">&nbsp;Data</td>
									<td width="100">&nbsp;Hora</td>
									<td width="199">&nbsp;Dia da Semana</td>
									<td width="100" colspan="2">&nbsp;Data</td>
									<td width="100">&nbsp;Hora</td>
									<td width="199">&nbsp;Dia da Semana</td>
									</tr>
									<tr height="21" class="dataField">
									<td width="80">&nbsp;<input type="text" name="txtDataPartida" maxlength="10" style=" width:75px;" readonly value="<?=$DataPartida?>" onChange="compute(this,1);PedeNovoCalculo(document.Form);"></td>
									<td width="20"><a href="#" onClick="javascript:displayCalendar(txtDataPartida,'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar CalendÃ¡rio" width="18" height="18"></a></td>
									<td width="100">&nbsp;<input type="text" name="txtHoraPartida" maxlength="5" style=" width:75px;" OnKeyUp="mascaraHora(this.value, document.Form.txtHoraPartida);PedeNovoCalculo(document.Form);"  onChange="PedeNovoCalculo(document.Form);" onKeyPress="mascaraNumero(event, this);" value="<?=$HoraPartida?>"></td>
									<td width="199">&nbsp;<input type="text" name="txtPartidaSemana" class="Oculto" value="<?=diasemana($DataPartida)?>" readonly></td>
									<td width="80">&nbsp;<input type="text" name="txtDataChegada" maxlength="10" style=" width:75px;" readonly value="<?=$DataChegada?>" onChange="compute(this,2);PedeNovoCalculo(document.Form);"></td>
									<td width="20"><a href="#" onClick="javascript:displayCalendar(txtDataChegada,'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar CalendÃ¡rio" width="18" height="18"></a></td>
									<td width="100">&nbsp;<input type="text" name="txtHoraChegada" maxlength="5" style=" width:75px;" OnKeyUp="mascaraHora(this.value, document.Form.txtHoraChegada);PedeNovoCalculo(document.Form);" onKeyPress="mascaraNumero(event,this);" value="<?=$HoraChegada?>" onChange="PedeNovoCalculo(document.Form);"></td>
									<td width="199">&nbsp;<input type="text" name="txtChegadaSemana" class="Oculto" value="<?=diasemana($DataChegada)?>" readonly></td>
									</tr>
									</table>						
								
								<!-- Quando um servidor acompanha o diretor em uma Viagem -->
									<table width="798" border="0" cellpadding="0" cellspacing="1">										
										<tr height="21" class="dataLabel">
											<td width="240">Acompanha o Diretor ?&nbsp;&nbsp;&nbsp; <INPUT id="ACP_SIM" TYPE=RADIO  NAME="ACP_DIRETOR" VALUE="sim" onClick="HabEstadoACPDiretor()">Sim &nbsp;&nbsp;&nbsp;<INPUT id="ACP_NAO" TYPE=RADIO  NAME="ACP_DIRETOR" VALUE="nao" onClick="HabEstadoACPDiretor()">Não</td>
											<td width="300" id="RADIO_ESTADO_ACP_DIRETOR" style="display:none">No Estado ?&nbsp;&nbsp;&nbsp; <INPUT TYPE=RADIO  NAME="ACP_DIRETOR_ESTADO" VALUE="sim">Sim &nbsp;&nbsp;&nbsp;<INPUT TYPE=RADIO  NAME="ACP_DIRETOR_ESTADO" VALUE="nao">Não</td>																
										</tr>												
									</table>    	

								   <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="85">&nbsp;Redu&ccedil;&atilde;o 50%</td>
                                            <td width="180">&nbsp;Valor Refer&ecirc;ncia (Descri&ccedil;&atilde;o)</td>
                                            <td width="132">&nbsp;Valor do Roteiro</td>
                                            <td width="102">&nbsp;Qtde Di&aacute;rais</td>
                                            <td width="98">&nbsp;Valor Total</td>
                                            <td width="101">&nbsp;A Restituir</td>
                                            <td width="100">&nbsp;A Receber</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td width="85" valign="top">&nbsp;<input type="checkbox" name="chkDesconto" class="checkbox" <?=$DescontoMarcado?> onChange="PedeNovoCalculo(document.Form);">&nbsp;Sim</td>
                                            <td width="180" valign="top"><?=f_ValorReferencia($Beneficiario)?></td>
                                       	    <td width="533" colspan="5" valign="middle">
                                            	<div id="QtdeDiariaAlterar">
                                                	<table width="533" border="0" cellpadding="0" cellspacing="0">
														<tr class="dataField">
															<td width="142">&nbsp;<input type="hidden" name="txtValorRef" value="<? print ($ValorDiariaRef);?>"  class="Invisivel" size="14" readonly><?=$ValorDiariaRef?></td>
                                                            <td width="100">&nbsp;<input type="hidden" name="txtQtdeRef" value="<?=$QtdeDiaria?>" class="Invisivel" size="14" readonly><?=$QtdeDiaria?></td>
                                                            <td width="95">&nbsp;<input type="hidden" name="txtTotalRef" value="<?=$ValorDiaria?>" class="Invisivel" size="14" readonly><?=$ValorDiaria?></td>
                                                            <td width="96">R$0,00</td>
                                                            <td>&nbsp;R$0,00</td>
                                                         </tr>
                                                     </table>
                                                </div>
                                                <div id="QtdeDiaria" style="display:none">&nbsp;</div>
                                             </td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                       	<td colspan="7" align="right"><input type="button" name="btnCalcular" style=" width:125px;" value="Calcular Comprova&ccedil;&atilde;o" onClick="CalcularComprovacao(document.Form.txtDataPartida.value, document.Form.txtDataChegada.value,document.Form.txtHoraPartida.value,document.Form.txtHoraChegada.value, <?=$Beneficiario?>, document.Form.chkDesconto.value, document.Form.txtPercentual.value, document.Form.txtDataAtual.value, document.Form.txtValorAnterior.value,'0');">&nbsp;</td>
                                        </tr>
    									<tr>
                                        	<td colspan="7" class="dataField">
                                                <div id="ComplementoValor" style="display:none">
                                                   &nbsp;<input type="checkbox" name="chkComplemento" class="checkbox" onClick="CalcularComprovacao(document.Form.txtDataPartida.value, document.Form.txtDataChegada.value,document.Form.txtHoraPartida.value,document.Form.txtHoraChegada.value, <?=$Beneficiario?>, document.Form.chkDesconto.value, document.Form.txtPercentual.value, document.Form.txtDataAtual.value, document.Form.txtValorAnterior.value,'1');">&nbsp;Complemento de di&aacute;ria, conforme Art. 4º par&aacute;grafo 2º do DECRETO Nº 5.910 de Outubro de 1996.
                                                   <br>
                                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                        <tr height="21" class="dataLabel">
                                                            <td>
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr class="dataLabel">
                                                                        <td width="50%">&nbsp;Justificativa do Complemento</td>
                                                                        <td width="50%" align="right">M&aacute;ximo permitido 100 caracteres&nbsp;<input type="text" id="QtdeComplemento" name="QtdeComplemento" style=" width:35px;" readonly class="Oculto">&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr height="21" class="dataField">
                                                            <td>&nbsp;<textarea name="txtComplemento" style=" width:789px; height:30px" maxlenght="100" onKeyUp="ContarComplemento(this,100)"><?=$Complemento;										
															?></textarea></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                        	</td>
                                        </tr>
                                    </table>



    						        <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td>
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                	<tr class="dataLabel">
                                                    	<td width="50%">&nbsp;Justificativa do Fim de Semana</td>
                                                        <td width="50%" align="right">M&aacute;ximo permitido 255 caracteres&nbsp;<input type="text" id="QtdFimSemana" name="QtdFimSemana" style=" width:35px;" readonly class="Oculto">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<textarea name="txtJustificativaFimSemana" style=" width:789px; height:45px" maxlenght="255" onKeyUp="ContarJustificativaFimSemana(this,255)"><?=$JustificativaFimSemana?></textarea></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr class="dataLabel">
                                                        <td width="50%">&nbsp;Justificativa do Feriado</td>
                                                        <td width="50%" align="right">Máximo permitido 255 caracteres&nbsp;<input type="text" id="QtdFeriado" name="QtdFeriado" style=" width:35px;" readonly class="Oculto">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<textarea name="txtJustificativaFeriado" style=" width:789px; height:45px" maxlenght="255" onKeyUp="ContarJustificativaFeriado(this,255)"><?=$JustificativaFeriado?></textarea></td>
                                        </tr>
                                    </table>

 									<input type="hidden" name="Calculo" value="<?=$DiariaCalculada?>">

 								</td>
                        	</tr>
                        </table>

						</div>

                        <div id="formaba2" style="display:none">


                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLabel" width="320">&nbsp;Meio de Transporte</td>
                                            <td class="dataLabel" width="478">&nbsp;Meio de Transporte Observa&ccedil;&atilde;o</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=f_ExibeMeioTransporte($MeioTransporte)?></td>
                                            <td class="dataField">&nbsp;<?=$MeioTransporteObservacao?></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLabel" width="320">&nbsp;Motivo</td>
                                            <td class="dataLabel" width="478">&nbsp;Sub-Motivo</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=f_ExibeMotivo($Motivo)?></td>
                                           	<td class="dataField"><div id="SubMotivo">&nbsp;<?=f_ExibeSubMotivo($SubMotivo)?></div></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Descri&ccedil;&atilde;o da Di&aacute;ria</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=$Descricao?></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Unidade de Custo</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=f_ExibeUnidadeCusto($ACP)?></td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Projeto</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp<?=f_ExibeProjeto($Projeto)?> </td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;A&ccedil;&atilde;o</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=f_ExibeAcao($Produto)?></td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Territ&oacute;rio</td>
                                        </tr>
                                        <tr height="21">
											<td class="dataField">&nbsp;<?=f_ExibeTerritorio($Territorio)?></div></td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataLabel">&nbsp;Fonte</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField"><div id="Fonte">&nbsp;<?=f_ExibeFonte($Fonte)?></div></td>
                                        </tr>
                                    </table>

 								</td>
                        	</tr>
                        </table>

                        </div>

                        <div id="formaba3" style="display:none">

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">    
                                        <tr height="21" class="dataLabel">
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr class="dataLabel">
                                                        <td width="40%">&nbsp;Resumo</td>
                                                        <td width="60%" align="right">Máximo permitido 3000 caracteres&nbsp;<input type="text" id="QtdResumo" name="QtdResumo" style=" width:35px;" readonly class="Oculto">&nbsp;Máximo permitido 25 linhas</td>                                                                                        
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr> 
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<textarea name="txtResumo" cols="160" rows="25" onKeyUp="ContarResumo(this,3000);ContarResumoLinha(this.value)"><?=$Resumo?></textarea></td>                                                                                        
                                        </tr>  
                                    </table>                                    
 								</td>
                        	</tr>
                        </table>                                                           
                        

                        </div>
						
                        <input name="txtCodigo" type="hidden" value="<?=$Codigo?>">
                        <input name="txtComprovada" type="hidden" value="<?=$Comprovada?>">
                        <input name="txtReCalculo" type="hidden" value="0">
                        <input name="txtNovaSaida" type="hidden" value="">
                        <input name="txtNovaChegada" type="hidden" value="">
                        <input name="txtDataAtual" type="hidden" value="<?=$Atual?>">
                        <input name="txtExisteCampoComplemento" type="hidden" value="">
                        <input name="txtValorCampoComplemento" type="hidden" value="">

<?
If (substr($QtdeDiaria,2) == ".6")
	{
	?>
	<script>
	    document.getElementById("ComplementoValor").style.display = '';
   		 document.Form.txtValorCampoComplemento.value = 1;
    </script>
	<?
}
?>
						<?include "../Include/Inc_Linha.php"?>


                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
                                    <button style="width:70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao">Gravar</button>&nbsp;&nbsp;&nbsp;
                                    <button style="width:70px" onClick="Javascript:window.location.href='SolicitacaoInicio.php';" name="btnConsultar" class="botao">Voltar</button>
                               </td>
                           </tr>

                        </table>

                    </td>
                </tr>
            </table>
        </td>
	</tr>
</table>
<div id="data" style="display:none"></div>
</form>

</body>
</html>