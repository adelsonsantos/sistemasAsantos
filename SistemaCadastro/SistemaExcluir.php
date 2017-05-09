<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseSistema.pjp";
?>
<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--

	function ExcluirForm(frm, checkbox)
	 {
		frm.action="SistemaExcluir.php?excluirMultiplo=1&acao=excluir";
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

                        <table cellpadding="2" cellspacing="2" border="0" width="800" class="TabModulo">
                            <tr>
                                <td width="1"><img src="../images/icones/vazio.gif" width="1" height="1" border="0"></td>
                                <td align="left" class="titulo_pagina">Confirma exclus&atilde;o do(s) registro(s) abaixo?</td>
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

                        <?// fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="498" align="center">Descri&ccedil;&atilde;o</td>
                                            <td width="90" align="center">S&iacute;mbolo</td>
                                            <td width="70" align="center">Status</td>
                                            <td width="70" align="center">Criado em</td>
                                            <td width="70" align="center">Alterado em</td>
                                        </tr>
<?



										$ExcluirCheckbox = $_GET['excluirMultiplo'];
										$codCheckbox = $_POST['checkbox'];

										If ($ExcluirCheckbox == 1)
                                        {

											$sqlConsulta = "SELECT * FROM seguranca.sistema c, seguranca.simbolo s WHERE (c.simbolo_id = s.simbolo_id) AND sistema_id IN (" .$codCheckbox. ") ORDER BY UPPER(sistema_ds)";
                                            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                                            while($linha=pg_fetch_assoc($rsConsulta))
                                            {



												$numCodigo = $codCheckbox;

												$strSimbolo	     = $linha['simbolo_ds'];
												$strDescricao	 = $linha['sistema_ds'];
												$numStatus	     = $linha['sistema_st'];
												$strDataCriacao   = $linha['sistema_dt_criacao'];
												$strDataAlteracao = $linha['sistema_dt_alteracao'];



													If ($numStatus == "0")
                                                    {  $strStatus = "Ativo";

                                                    }
                                                     Else
                                                     {  $strStatus = "Inativo";

                                                     }
?>
                                                    <tr height="21" class="dataField">
                                                        <td width="491" >&nbsp;<?=$strDescricao?></td>
                                                        <td width="90" align="center"><?=$strSimbolo?></td>
                                                        <td width="70" align="center"><?=$strStatus?></td>
                                                        <td width="70" align="center"><?=$strDataCriacao?></td>
                                                        <td width="70" align="center"><?=$strDataAlteracao?></td>
                                                    </tr>
<?
                                            }

                                        }

										Else
                                        {
?>
                                                    <tr height="21" class="dataField">
                                                        <td width="491" >&nbsp;<?=$strDescricao?></td>
                                                        <td width="90" align="center">&nbsp;<?=$strSimbolo?></td>
                                                        <td width="70" align="center"><?=$strStatus?></td>
                                                        <td width="70" align="center"><?=$strDataCriacao?></td>
                                                        <td width="70" align="center"><?=$strDataAlteracao?></td>
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