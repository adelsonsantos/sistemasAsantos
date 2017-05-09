<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClassePessoaJuridica.php";
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

                        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="2">Dados Principais</font></td></tr></table>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                            <tr>
                                <td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="150">&nbsp;CNPJ</td>
                                            <td width="380">&nbsp;Raz&atilde;o Social</td>
                                            <td width="268">&nbsp;Nome Fantasia</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$CNPJ?></td>
                                            <td>&nbsp;<?=$RazaoSocial?></td>
                                            <td>&nbsp;<?=$NomeFantasia?></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="150">&nbsp;Data de Abertura</td>
                                            <td width="150" class="dataLabel">&nbsp;Inscri&ccedil;&atilde;o Estadual</td>
                                            <td class="dataLabel">&nbsp;Inscri&ccedil;&atilde;o Municipal</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$DataAbertura?></td>
                                            <td>&nbsp;<?=$IE?></td>
                                            <td>&nbsp;<?=$IM?></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td class="dataLabel">&nbsp;Relacionamento com a Secretaria</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?
											If ($Fornecedor == "1")
                                            {  echo"Fornecedor";

                                            }
											?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0" width="100?" height="30"><tr><td class="titulo_pagina"><font size="2">Endere&ccedil;o</font></td></tr></table>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                            <tr>
                                <td>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td width="55" class="dataLabel">&nbsp;Estado</td>
                                            <td width="375" class="dataLabel">&nbsp;Munic&iacute;pio</td>
                                            <td width="240" class="dataLabel">&nbsp;Bairro</td>
                                            <td width="138" class="dataLabel">&nbsp;CEP</td>
                                        </tr>
                                        <tr height="21">
                                            <td class="dataField">&nbsp;<?=$EnderecoUF?></td>
                                            <td class="dataField">&nbsp;<?=f_ConsultaMunicipio($EnderecoMunicipio)?></div></td>
                                            <td class="dataField">&nbsp;<?=$EnderecoBairro?></td>
                                            <td class="dataField">&nbsp;<?=$EnderecoCEP?></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
																			<tr height="21" class="dataLabel">
																					<td width="426">&nbsp;Endere&ccedil;o</td>
																					<td width="234">&nbsp;N&uacute;mero</td>
																					<td width="138">&nbsp;Complemento</td>
																			</tr>
																			<tr height="21">
																					<td class="dataField">&nbsp;<?=$Endereco?></td>
																					<td class="dataField">&nbsp;<?=$EnderecoNumero?></td>
																					<td class="dataField">&nbsp;<?=$EnderecoComplemento?></td>
																			</tr>
                                    </table>
																		
																		<table width="798" border="0" cellpadding="0" cellspacing="1">
																			<tr height="21" class="dataLabel">
																					<td width="798">Ponto de Refer&ecirc;ncia</td>
																			</tr>
																			<tr height="21">
																					<td class="dataField">&nbsp;<?=$EnderecoReferencia?></td>
																			</tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="2">Contato</font></td></tr></table>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                            <tr>
                                <td>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="30">&nbsp;DDD</td>
                                            <td width="140">&nbsp;Telefone Comercial 1</td>
                                            <td width="30">&nbsp;DDD</td>
                                            <td width="140">&nbsp;Telefone Comercial 2</td>
                                            <td width="30">&nbsp;DDD</td>
                                            <td width="140">&nbsp;Telefone Fax</td>
                                            <td>&nbsp;E-Mail da Empresa</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$TelefoneDDDComercial1?></td>
                                            <td>&nbsp;<?=$TelefoneComercial1?></td>
                                            <td>&nbsp;<?=$TelefoneDDDComercial2?></td>
                                            <td>&nbsp;<?=$TelefoneComercial2?></td>
                                            <td>&nbsp;<?=$TelefoneDDDFax?></td>
                                            <td>&nbsp;<?=$TelefoneFax?></td>
                                            <td>&nbsp;<?=$Email?></td>
                                        </tr>
                                    </table>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="260">&nbsp;Nome do Contato</td>
                                            <td colspan="2">&nbsp;Celular do Contato</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td width="260">&nbsp;<?=$Contato?></td>
                                            <td width="30">&nbsp;<?=$TelefoneDDDCelular?></td>
                                            <td width="508">&nbsp;<?=$TelefoneCelular?></td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

						<?include "../Include/Inc_Linha.php"?>


                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                            <tr height="25">
                                <td align="right">
								<button style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" name="btnConsultar" class="botao">Voltar</button>
                               </td>
                           </tr>
                        </table><br><br>
                    </td>
                </tr>
            </table>
        </td>
	</tr>
</table>

</form>

</body>
</html>
