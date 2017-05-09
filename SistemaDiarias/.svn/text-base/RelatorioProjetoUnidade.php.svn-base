<?php
include "../Include/Inc_Configuracao.php";
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
		frm.cmbContrato.focus();
	}

	function GerarRelatorio(frm)
	{
		var i


		if (frm.txtDataInicial.value == "")
		{
			alert("Informe a Data Inicial!");
			frm.txtDataInicial.focus();
			frm.txtDataInicial.style.backgroundColor='#B9DCFF';
			return false;
		}

		if (frm.txtDataFinal.value == "")
		{
			alert("Informe a Data Final!");
			frm.txtDataFinal.focus();
			frm.txtDataFinal.style.backgroundColor='#B9DCFF';
			return false;
		}


		if ( frm.TipoRelatorio[0].checked == false  &&
				 frm.TipoRelatorio[1].checked == false &&
				 frm.TipoRelatorio[2].checked == false
			 )
		{
			alert("Selecione o tipo de Relatorio!");
			return false;
		}


		if (frm.TipoRelatorio[0].checked == true)
		{
			frm.action = "RelatorioProjetoUnidadePDF.php?tiporelatorio=1";
			frm.submit();
		}
		if (frm.TipoRelatorio[1].checked == true )
		{
			frm.action = "RelatorioProjetoUnidadePDF.php?tiporelatorio=2";
			frm.submit();
		}

		if (frm.TipoRelatorio[2].checked == true )
		{
			frm.action = "RelatorioProjetoUnidadePDF.php?tiporelatorio=3";
			frm.submit();
		}
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

						<table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
							<tr>
								<td>
									<table border="0" cellpadding="1" cellspacing="1" width="798">
										<tr height="20">
											<td width="150" class="dataLabel">&nbsp;Informe Data Inicial</td>
											<td width="75" class="dataField">&nbsp;<input type="text" name="txtDataInicial" value="" style="width:66px;" readonly></td>
											<td width="" class="dataField"><a href="#" onClick="javascript:displayCalendar(txtDataInicial,'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calend&acute;rio" width="18" height="18"></a></td>

											<td width="150" class="dataLabel">&nbsp;Informe Data Final</td>
											<td width="75" class="dataField">&nbsp;<input type="text" name="txtDataFinal" value="" style="width:66px;" readonly></td>
											<td width="" class="dataField"><a href="#" onClick="javascript:displayCalendar(txtDataFinal,'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calend&acute;rio" width="18" height="18"></a></td>

											<td width="" class="dataField">
												<INPUT TYPE=RADIO NAME="TipoRelatorio" VALUE="0">&nbsp;Movimento por Centro de custo (Provis&atilde;o)<br>
												<INPUT TYPE=RADIO NAME="TipoRelatorio" VALUE="1">&nbsp;Movimento por Unidade (Provis&atilde;o)<br>
												<INPUT TYPE=RADIO NAME="TipoRelatorio" VALUE="2">&nbsp;Movimento por Unidade (Execu&ccedil;&atilde;o)
											</td>
									 </tr>
									</table>

								</td>
							</tr>
						</table>

						<table border="0" cellpadding="1" cellspacing="1" width="800">
							<tr height="25">
								<td align="right">
									<button style="width:100px" onClick="Javascript:GerarRelatorio(document.Form);" name="btnGravar" class="botao">Gerar Relat&oacute;rio</button>
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
