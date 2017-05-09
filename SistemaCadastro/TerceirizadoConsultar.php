<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseTerceirizado.php";
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
                                            <td width="150">&nbsp;CPF</td>
                                            <td width="150">&nbsp;Data de Nascimento</td>
                                            <td width="338">&nbsp;Nome</td>
                                            <td width="160" class="dataLabel">&nbsp;Sexo</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$CPF?></td>
                                            <td>&nbsp;<?=$DataNascimento?></td>
                                            <td>&nbsp;<?=$Nome?></td>
                                            <td>&nbsp;<?=$Sexo?></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="150">&nbsp;RG</td>
                                            <td width="150">&nbsp;&Oacute;rg&atilde;o Emissor do RG</td>
                                            <td width="120">&nbsp;UF Emissor do RG</td>
                                            <td width="218">&nbsp;Data de Expedi&ccedil;&atilde;o do RG</td>
                                            <td width="160">&nbsp;Grupo Sangu&iacute;neo</td>
                                            <td width="72">&nbsp;Qtde Filho</td>
                                            <td width="72">&nbsp;Qtde Filha</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$RG?></td>
                                            <td>&nbsp;<?=$RGOrgao?></td>
                                            <td>&nbsp;<?=$RGOrgaoUF?></td>
                                            <td>&nbsp;<?=$RGData?></td>
                                            <td>&nbsp;
<?
											If ($Sangue != "0")
                                            {
												echo $Sangue;
                                            }

?>
                                            <td>&nbsp;<?=$Filho?></td>  
                                            <td>&nbsp;<?=$Filha?></td>                                               

											</td>
                                        </tr>
                                    </table>

                          	<table width="798" border="0" cellpadding="0" cellspacing="1">
										<tr height="21" class="dataLabel">
											<td width="150">&nbsp;Estado Civil</td>
											<td width="150">&nbsp;Escolaridade</td>
                                            <td width="150">&nbsp;Semestre</td>                                            
											<td width="166">&nbsp;Nome do Curso</font></td>
                                            <td width="166">&nbsp;Nome da Institui&ccedil;&atilde;o</font></td>
											<td width="166">&nbsp;Conselho / Registro</font></td>
										</tr>
										<tr height="21" class="dataField">
											<td>&nbsp;<?=f_ConsultaEstadoCivil($EstadoCivil)?></td>
											<td>&nbsp;<?=f_ConsultaNivelEscolar($NivelEscolar)?></td>
                                            <td>&nbsp;<?=$NivelTecnicoSemestre?></td>
											<td>&nbsp;<?=$NivelTecnicoCurso?></td>
											<td>&nbsp;<?=$NivelTecnicoInstituicao?></td>
											<td>&nbsp;<?=$NivelTecnicoConselho?></td>
										</tr>
									</table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="200">&nbsp;(Filia&ccedil;&atilde;o) Nome do Pai</td>
                                            <td width="200">&nbsp;(Filia&ccedil;&atilde;o) Nome da M&atilde;e</td>
                                            <td width="120">&nbsp;Nacionalidade</td>
                                            <td width="278" class="dataLabel">&nbsp;Naturalidade</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$NomePai?></td>
                                            <td>&nbsp;<?=$NomeMae?></td>
                                            <td>&nbsp;<?=$Nacionalidade?></td>
                                            <td>&nbsp;<?=f_ConsultaMunicipio($Naturalidade)?> - <?=$NaturalidadeUF?></td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="2">Dados Adicionais</font></td></tr></table>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                            <tr>
                                <td>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="150">&nbsp;Num. T&iacute;tulo de Eleitor</td>
                                            <td width="150">&nbsp;T&iacute;tulo de Eleitor Zona</td>
                                            <td width="150">&nbsp;T&iacute;tulo de Eleitor Se&ccedil;&atilde;o</td>
                                            <td>&nbsp;T&iacute;tulo de Eleitor Cidade</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$Num. TituloEleitor?></td>
                                            <td>&nbsp;<?=$TituloEleitorZona?></td>
                                            <td>&nbsp;<?=$TituloEleitorSecao?></td>
                                            <td>&nbsp;<?=$TituloEleitorUF?> - <?=f_ConsultaMunicipio($TituloEleitorCidade)?></div></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
               						<tr height="21" class="dataLabel">
											<td width="150">Num. &nbsp;Habilita&ccedil;&atilde;o</td>
											<td width="150">&nbsp;Categoria</td>
                                            <td width="150">&nbsp;Habilita&ccedil;&atilde;o Validade</td>
                                            <td width="150">&nbsp;Lente Corretiva</td>
                                            <td width="150">&nbsp;Passaporte</td>
        					        	</tr>
										<tr height="21" class="dataField">
											<td>&nbsp;<?=$Habilitacao?></td>
											<td>&nbsp;<?=$HabilitacaoCategoria?></td>
                                            <td>&nbsp;<?=$HabilitacaoValidade?></td>
                                            <td>&nbsp;<?=$HabilitacaoLenteCorretiva==1 ? "Sim" : "Não";?></td>
                                            <td>&nbsp;<?=$Passaporte?></td>
										</tr>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="200" colspan="2">&nbsp;Num. Reservista / UF</td>
                                            <td width="598">&nbsp;Reservista Minist&eacute;rio</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$Reservista?></td>
                                            <td width="50">&nbsp;<?=$ReservistaUF?></td>
                                            <td>&nbsp;
<?
											If ($ReservistaMinisterio != "0")
                                            {
												echo $ReservistaMinisterio;
                                            }
?>
											</td>
                                        </tr>
                                     </table>

                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="2">Endere&ccedil;o</font></td></tr></table>

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
                                            <td width="424">&nbsp;Endere&ccedil;o</td>
                                            <td width="246">&nbsp;N&uacute;mero</td>
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
											<td width="798">&nbsp;Ponto de Referencia</td>
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
                                            <td width="140">&nbsp;Telefone Residencial</td>
                                            <td width="30">&nbsp;DDD</td>
                                            <td width="140">&nbsp;Telefone Comercial</td>
                                            <td width="30">&nbsp;DDD</td>
                                            <td width="140">&nbsp;Telefone Celular</td>
                                            <td width="30">&nbsp;DDD</td>
                                            <td width="258">&nbsp;Telefone Fax</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$TelefoneDDDResidencial?></td>
                                            <td>&nbsp;<?=$TelefoneResidencial?></td>
                                            <td>&nbsp;<?=$TelefoneDDDComercial?></td>
                                            <td>&nbsp;<?=$TelefoneComercial?></td>
                                            <td>&nbsp;<?=$TelefoneDDDCelular?></td>
                                            <td>&nbsp;<?=$TelefoneCelular?></td>
                                            <td>&nbsp;<?=$TelefoneDDDFax?></td>
                                            <td>&nbsp;<?=$TelefoneFax?></td>
                                        </tr>
                                    </table>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td>&nbsp;E-Mail</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$Email?></td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="2">Informa&ccedil;&otilde;es Organizacionais</font></td></tr></table>

                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                            <tr>
                                <td>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="150">&nbsp;Tipo de Funcion&aacute;rio</td>
                                            <td width="135">&nbsp;Matr&iacute;cula</td>
                                            <td width="135">&nbsp;Data de Admiss&atilde;o</td>
                                            <td width="135">&nbsp;Data de Demiss&atilde;o</td>
                                            <td width="233">&nbsp;Fun&ccedil;&atilde;o</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;Terceirizado</td>
                                            <td>&nbsp;<?=$Matricula?></td>
                                            <td>&nbsp;<?=$DataAdmissao?></td>
                                            <td>&nbsp;<?=$DataDemissao?></td>
                                            <td>&nbsp;<?=f_ConsultaFuncao($Funcao)?></td>
                                        </tr>
                                     </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="287">&nbsp;Unidade de Trabalho</td>
                                            <td width="274">&nbsp;Contrato</td>
                                            <td width="234">&nbsp;E-Mail Institucional</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=f_ConsultaLotacao($Lotacao)?></td>
                                            <td>&nbsp;<?=f_ConsultaContrato($Contrato)?></td>
                                            <td>&nbsp;<?=$FuncionarioEmail?></td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="150">&nbsp;Num. Carteira de Trabalho</td>
                                            <td width="195" colspan="2">&nbsp;Carteira de Trabalho S&eacute;rie / UF</td>
                                            <td width="140">&nbsp;PIS/PASEP</td>
                                            <td width="140">&nbsp;Conta FGTS</td>
                                            <td>&nbsp;Ramal</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$CartTrabalho?></td>
                                            <td width="140">&nbsp;<?=$CartTrabalhoSerie?></td>
                                            <td width="55">&nbsp;<?=$CartTrabalhoUF?></td>
                                            <td>&nbsp;<?=$PIS?></td>
                                            <td>&nbsp;<?=$FGTS?></td>
                                            <td>&nbsp;<?=$FuncionarioRamal?></td>
                                        </tr>
                                     </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21" class="dataLabel">
                                            <td width="151">&nbsp;Banco</td>
                                            <td width="110">&nbsp;Ag&ecirc;ncia</td>
                                            <td width="150">&nbsp;Conta</td>
                                            <td width="195">&nbsp;Tipo da Conta</td>
                                            <td width="192">&nbsp;Sal&aacute;rio</td>
                                        </tr>
                                        <tr height="21" class="dataField">
                                            <td>&nbsp;<?=$BancoNumero?> - <?=$BancoNome?></td>
                                            <td>&nbsp;<?=$Agencia?></td>
                                            <td>&nbsp;<?=$Conta?></td>
                                            <td>&nbsp;
<?
											If (($TipoConta == "C") && ($Banco != 0))
                                            {
												echo "Conta Corrente";
                                            }
											ElseIf (($TipoConta == "P")&& ($Banco != 0))
											{	echo "Conta Poupan&ccedil;a";

                                            }

?>
                                            </td>
                                            <td>&nbsp;<? If ($Salario != ""){ number_format($Salario, 2, ',', '.');} ?></td>
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
