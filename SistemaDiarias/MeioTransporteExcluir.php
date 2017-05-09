<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseMeioTransporte.php";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--

	function ExcluirForm(frm, checkbox)
	 {
		frm.action="MeioTransporteExcluir.php?excluirMultiplo=1&acao=excluir";
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

                        <?// inicio titulo da pagina ?>

                        <div id="titulopagina">

                        <?include "../Include/Inc_Titulo.php"?>

                        </div>

                        <?// fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <?include "../Include/Inc_TituloExcluir.php"?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="738">&nbsp;Descri&ccedil;&atilde;o</td>
                                            <td width="60" align="center">Status</td>
                                        </tr>
<?

										

										$ExcluirCheckbox = $_GET['excluirMultiplo'];
										$codCheckbox = $_POST['checkbox'];

										If ($ExcluirCheckbox == 1)
                                        {

											$sqlConsulta = "SELECT * FROM diaria.meio_transporte WHERE meio_transporte_id IN (".$codCheckbox.") ORDER BY UPPER(meio_transporte_ds)";
                                            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

											

												$Codigo = $codCheckbox;
                                                while($linha=pg_fetch_assoc($rsConsulta))
                                                {
                                                    $Descricao	  = $linha['meio_transporte_ds'];
                                                    $StatusNumero  = $linha['meio_transporte_st'];

												

													If ($StatusNumero == "0")
                                                    {  $StatusNome = "Ativo";

                                                    }
                                                     Else
                                                     {  $StatusNome = "Inativo";

                                                     }
?>
                                                    <tr height="21" class="dataField">
                                                        <td width="738" >&nbsp;<?=$Descricao?></td>
                                                        <td width="60" align="center"><?=$StatusNome?></td>
                                                    </tr>
<?                                                }
                                        }
										

										Else
                                        {
?>
                                                    <tr height="21" class="dataField">
                                                        <td width="738" >&nbsp;<?=$Descricao?></td>
                                                        <td width="60" align="center"><?=$StatusNome?></td>
                                                    </tr>
<?
                                        }
?>
                        				</table>
									</td>
								</tr>
							</table>

						<?include "../Include/Inc_Linha.php"?>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
<?
									If ($ExcluirCheckbox == 1)
                                    {
?>
	                    				<button style="width:70px" onClick="Javascript:ExcluirForm(document.Form);" class="botao">Sim</button>&nbsp;&nbsp;
<?
                                    }
                                    Else
                                    {
?>
                                    	<button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php?acao=excluir&cod=<?=$Codigo?>';" class="botao">Sim</button>&nbsp;&nbsp;
<?
                                    }
?>
                                	<button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" class="botao">N&atilde;o</button></td>
								</td>
                           	</tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
	</tr>
</table>
<input name="txtCodigo" type="hidden" value="<?=$Codigo?>">
</form>

</body>
</html>

