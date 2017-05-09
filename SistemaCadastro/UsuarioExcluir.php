<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseUsuario.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

<script language="javascript">
<!--

	function ExcluirForm(frm, checkbox)
	 {
		frm.action="UsuarioExcluir.php?excluirMultiplo=1&acao=excluir";
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

                        <? //fim do titulo da pagina ?>

                        <?include "../Include/Inc_Linha.php"?>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="400" align="left">&nbsp;Nome</td>
                                            <td width="218" align="left">&nbsp;Estrutura</td>
                                            <td width="120" align="left">&nbsp;Login</td>
                                            <td width="60" align="center">Status</td>
                                        </tr>

                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$Nome?></td>
                                            <td>&nbsp;<?=f_ConsultaEstruturaOrganizacional($EstOrganizacional)?></td>
                                            <td>&nbsp;<?=$Login?></td>
<?
											If ($Login != "")
											{	echo "<td align='center'><font color='#ff0000'>Ok</font></td>";

                                            }
											Else
											{	echo "<td align='center'><font color='#ff0000'>Sem Login</font></td>";
                                            }
?>
                                        </tr>

                        				</table>
									</td>
								</tr>
							</table>

						<?include "../Include/Inc_Linha.php"?>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
                                    <button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php?acao=excluir&cod=<?=$Codigo?>';" class="botao">Sim</button>&nbsp;&nbsp;
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

</form>

</body>
</html>
