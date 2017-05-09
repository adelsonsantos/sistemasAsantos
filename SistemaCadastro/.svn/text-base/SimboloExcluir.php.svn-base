<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseSimbolo.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--

	function ExcluirForm(frm, checkbox)
	 {
		frm.action="SimboloExcluir.php?excluirMultiplo=1&acao=excluir";
		frm.submit();
	 }

-->
</script>

<body onLoad="WM_initializeToolbar()">

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
                                            <td width="528" align="center">&nbsp;Descri&ccedil;&atilde;o</td>
                                            <td width="80" align="center">Sal&aacute;rio</td>
                                            <td width="80" align="center">Di&aacute;ria</td>
                                            <td width="80" align="center">Status</td>
                                            <td width="30" align="center">&nbsp;</td>
                                        </tr>
<?



										$ExcluirCheckbox = $_GET['excluirMultiplo'];
										$codCheckbox 	= $_POST['checkbox'];

										If ($ExcluirCheckbox == 1)
                                        {

											$sqlConsulta = "SELECT * FROM dados_unico.Simbolo WHERE simbolo_id IN (" .$codCheckbox. ") ORDER BY UPPER(simbolo_ds)";
                                            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);


												$numCodigo = $codCheckbox;
                                                while($linha=pg_fetch_assoc($rsConsulta))
                                                {  $strDescricao	   	= $linha['simbolo_ds'];
												   $strSalario 			= $linha['simbolo_salario'];
												   $strValorDiaria		= $linha['simbolo_valor_diaria'];
												   $numStatus	   		= $linha['simbolo_st'];
												   $strDataCriacao   	= $linha['simbolo_dt_criacao'];
												   $strDataAlteracao 	= $linha['simbolo_dt_alteracao'];



													If ($strDataAlteracao != "")
                                                    {
														$strTextoAlteracao = " - Alterado em ".$strDataAlteracao;
                                                    }
													Else
													{	$strTextoAlteracao = "";
                                                    }

													If ($numStatus == "0")
                                                    {  $strStatus = "Ativo";

                                                    }
                                                    Else
                                                    {  $strStatus = "Inativo";

                                                    }
?>
                                                    <tr height="21" class="dataField">
                                                        <td width="528" >&nbsp;<?=$strDescricao?></td>
                                                        <td width="80" align="center">R$<?=$strSalario?></td>
                                                        <td width="80" align="center">R$<?=$strValorDiaria?></td>
                                                        <td width="80" align="center"><?=$strStatus?></td>
                                                        <td width="30" align="center"><img src="..\imagens\calendar.gif" alt="Criado em <?=$strDataCriacao?> <?=$strTextoAlteracao?>"></td>
                                                    </tr>
<?
                                                }
                                        }

										Else
                                        {


											If ($strDataAlteracao != "")
                                            {
												$strTextoAlteracao = " - Alterado em ".$strDataAlteracao;
                                            }
											Else
											{	$strTextoAlteracao = "";

                                            }

?>
                                            <tr height="21" class="dataField">
                                                <td width="528" >&nbsp;<?=$strDescricao?></td>
                                                <td width="80" align="center">R$<?=$strSalario?></td>
                                                <td width="80" align="center">R$<?=$strValorDiaria?></td>
                                                <td width="80" align="center"><?=$strStatus?></td>
                                                <td width="30" align="center"><img src="..\imagens\calendar.gif" alt="Criado em <?=$strDataCriacao?> <?=$strTextoAlteracao?>"></td>
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
                                    	<button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php?acao=excluir&cod=<?=$numCodigo?>';" class="botao">Sim</button>&nbsp;&nbsp;
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
<input name="txtCodigo" type="hidden" value="<?=$numCodigo?>">
</form>

</body>
</html>
