<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseContrato.php";
?>

<html>

<style type="text/css">@import url("../css/estilo.css"); </style>

<script language="javascript" src="../JavaScript/ScriptMenu.js"></script>

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

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                        	<tr>
                            	<td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="130">&nbsp;N&uacute;mero</td>
                                            <td width="335">&nbsp;Objeto</td>
                                            <td width="335">&nbsp;Empresa</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$Numero?></td>
                                            <td>&nbsp;<?=$Descricao?></td>
                                            <td>&nbsp;<?=f_ExibePJ($Empresa)?></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="130">&nbsp;Data In&iacute;cio</td>
                                            <td width="130">&nbsp;Data T&eacute;rmino</td>
                                        	<td width="201">&nbsp;Tipo de Contrato</td>
                                            <td width="130">&nbsp;Valor em R$</td>
                                            <td>&nbsp;Qtde M&aacute;xima <font class="dataTexto">(de Pessoas)</font></td>
                                        </tr>
                                        <tr height="21" class="dataField">
                    						<td>&nbsp;<?=$DataInicio?></td>
                    						<td>&nbsp;<?=$DataTermino?></td>
	                                        <td>&nbsp;<?=f_ConsultaContratoTipo($Tipo)?></td>
                                            <td>&nbsp;<?
														If ($Valor != "")
														{	echo number_format($Valor, 2, ',', '.');

                                                        }
														Else
														{	echo "";

                                                        }

													  ?>
                                            </td>
                                            <td>&nbsp;<?=$Qtde?></td>
                                        </tr>
                                    </table>

 								</td>
                        	</tr>
                        </table>

						<?include "../Include/Inc_Linha.php"?>

                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right"><button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" name="btnConsultar" class="botao">Voltar</button></td>
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



