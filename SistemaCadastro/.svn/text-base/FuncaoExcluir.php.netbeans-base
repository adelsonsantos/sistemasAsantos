<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseFuncao.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--
	function ExcluirForm(frm, checkbox)
	 {
		frm.action="FuncaoExcluir.php?excluirMultiplo=1&acao=excluir";
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

                        <? //inicio titulo da pagina ?>

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
                                            <td width="738">&nbsp;Fun&ccedil;&atilde;o</td>
                                            <td width="60" align="center">Status</td>
                                        </tr>
<?


										$ExcluirCheckbox = $_GET['excluirMultiplo'];
										$codCheckbox 	= $_POST['checkbox'];

										If ($ExcluirCheckbox == 1)
                                        {
											$sqlConsulta = "SELECT * FROM dados_unico.funcao WHERE funcao_id IN (".$codCheckbox. ") ORDER BY UPPER(funcao_ds)";
                                            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);


                                            $FuncaoCodigo = $codCheckbox;
											while($linha=pg_fetch_assoc($rsConsulta))
											{	$FuncaoDescricao	    = $linha['funcao_ds'];
												$FuncaoStatusCod	    = $linha['funcao_st'];
												If ($FuncaoStatusCod == "0")
                                                {  $FuncaoStatus = "Ativo";

                                                }
                                                else
                                                { $FuncaoStatus = "Inativo";

                                                }
?>
                                                    <tr height="21" class="dataField">
                                                        <td>&nbsp;<?=$FuncaoDescricao?></td>
                                                        <td align="center"><?=$FuncaoStatus?></td>
                                                    </tr>
<?
                                            }
                                        }
										Else
                                        {
?>
                                                    <tr height="21" class="dataField">
                                                        <td >&nbsp;<?=$FuncaoDescricao?></td>
                                                        <td align="center"><?=$FuncaoStatus?></td>
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
                                    	<button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php?acao=excluir&cod=<?=$FuncaoCodigo?>';" class="botao">Sim</button>&nbsp;&nbsp;
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
<input name="txtCodigo" type="hidden" value="<?=$FuncaoCodigo?>">
</form>

</body>
</html>

