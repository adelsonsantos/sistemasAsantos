<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseFuncionario.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="pt-BR" lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="Description" content="ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia" />
        <meta name="Keywords" content="ADAB, Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia, Defesa Agropecu&aacute;ria, Agropecu&aacute;ria Bahia" />
        <meta name="language" content="pt-br" />
        <meta name="distribution" content="Global" />
        <meta name="rating" content="General" />
        <meta name="DC.title" content="ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia" />
        <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE8'></meta>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia</title> 
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
    </head>

    <body onLoad="WM_initializeToolbar();">
        <form name="Form" method="post">
            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><?php include "../Include/Inc_Topo.php" ?></td>
                </tr>
                <tr>
                    <td><?php include "../Include/Inc_Aba.php"?></td>
                </tr>
                <tr>
                    <td>
                        <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">                               
                                    <div id="titulopagina">
                                        <?php include "../Include/Inc_Titulo.php"?>
                                    </div>                               
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr class="titulo_pagina">
                                            <td height="21">
                                                <font size="2">Dados Principais</font>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="150">CPF</td>
                                                        <td height="21" width="150">Data de Nascimento</td>
                                                        <td height="21" width="338">Nome</td>
                                                        <td height="21" width="160">Sexo</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$CPF?></td>
                                                        <td height="21"><?=$DataNascimento?></td>
                                                        <td height="21"><?=$Nome?></td>
                                                        <td height="21"><?=$Sexo?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="150">RG</td>
                                                        <td height="21" width="150">&Oacute;rg&atilde;o Emissor</td>
                                                        <td height="21" width="120">UF do RG</td>
                                                        <td height="21" width="120">Data Expedi&ccedil;&atilde;o</td>
                                                        <td height="21" width="218">Tipo Sanguineo</td>
                                                        <td height="21" width="82">Qtde Filho</td>
                                                        <td height="21" width="82">Qtde Filha</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$RG?></td>
                                                        <td height="21"><?=$RGOrgao?></td>
                                                        <td height="21"><?=$RGOrgaoUF?></td>
                                                        <td height="21"><?=$RGData?></td>
                                                        <td height="21">
                                                            <?php
                                                            if ($Sangue != "0")
                                                            {
                                                                echo $Sangue;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?=$Filho?></td>
                                                        <td><?=$Filha?></td>                                                    
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="150">Estado Civil</td>
                                                        <td height="21" width="150">Escolaridade</td>
                                                        <td height="21" width="150">Semestre</td>                                            
                                                        <td height="21" width="166">Nome do Curso</font></td>
                                                        <td height="21" width="166">Nome da Institui&ccedil;&atilde;o</font></td>
                                                        <td height="21" width="166">Conselho / Registro</font></td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=f_ConsultaEstadoCivil($EstadoCivil)?></td>
                                                        <td height="21"><?=f_ConsultaNivelEscolar($NivelEscolar)?></td>
                                                        <td height="21"><?=$NivelTecnicoSemestre?></td>
                                                        <td height="21"><?=$NivelTecnicoCurso?></td>
                                                        <td height="21"><?=$NivelTecnicoInstituicao?></td>
                                                        <td height="21"><?=$NivelTecnicoConselho?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="200">Nome do Pai</td>
                                                        <td height="21" width="200">Nome da M&atilde;e</td>
                                                        <td height="21" width="120">Nacionalidade</td>
                                                        <td height="21" width="278">Naturalidade</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$NomePai?></td>
                                                        <td height="21"><?=$NomeMae?></td>
                                                        <td height="21"><?=$Nacionalidade?></td>
                                                        <td height="21"><?=f_ConsultaMunicipio($Naturalidade)?> - <?=$NaturalidadeUF?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
                                        <tr>
                                            <td class="titulo_pagina">
                                                <font size="2">Dados Adicionais</font>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="150">Num. T&iacute;tulo de Eleitor</td>
                                                        <td height="21" width="150">Zona</td>
                                                        <td height="21" width="150">Se&ccedil;&atilde;o</td>
                                                        <td height="21" width="150" >Cidade</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$TituloEleitor?></td>
                                                        <td height="21"><?=$TituloEleitorZona?></td>
                                                        <td height="21"><?=$TituloEleitorSecao?></td>
                                                        <td height="21"><?=$TituloEleitorUF?> - <?=f_ConsultaMunicipio($TituloEleitorCidade)?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="150">Num. Habilita&ccedil;&atilde;o</td>
                                                        <td height="21" width="150">Categoria</td>
                                                        <td height="21" width="150">Habilita&ccedil;&atilde;o Validade</td>
                                                        <td height="21" width="150">Lente Corretiva</td>
                                                        <td height="21" width="150">Passaporte</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$Habilitacao?></td>
                                                        <td height="21"><?=$HabilitacaoCategoria?></td>
                                                        <td height="21"><?=$HabilitacaoValidade?></td>
                                                        <td height="21"><?=$HabilitacaoLenteCorretiva==1 ? "Sim" : "Não";?></td>
                                                        <td height="21"><?=$Passaporte?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="200" colspan="2">Reservista / UF</td>
                                                        <td height="21" width="598">Reservista Minist&eacute;rio</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$Reservista?></td>
                                                        <td height="21" width="50"><?=$ReservistaUF?></td>
                                                        <td height="21">
                                                            <?php
                                                            if ($ReservistaMinisterio != "0")
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
                                                    <tr class="dataLabel">
                                                        <td height="21" width="55" >Estado</td>
                                                        <td height="21" width="375">Munic&iacute;pio</td>
                                                        <td height="21" width="240">Bairro</td>
                                                        <td height="21" width="138">CEP</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$EnderecoUF?></td>
                                                        <td height="21"><?=f_ConsultaMunicipio($EnderecoMunicipio)?></div></td>
                                                        <td height="21"><?=$EnderecoBairro?></td>
                                                        <td height="21"><?=$EnderecoCEP?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="424">Endere&ccedil;o</td>
                                                        <td height="21" width="246">N&uacute;mero</td>
                                                        <td height="21" width="138">Complemento</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$Endereco?></td>
                                                        <td height="21"><?=$EnderecoNumero?></td>
                                                        <td height="21"><?=$EnderecoComplemento?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="798">Ponto de Referencia</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$EnderecoReferencia?></td>
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
                                                    <tr class="dataLabel">
                                                        <td height="21" width="30">DDD</td>
                                                        <td height="21" width="140">Telefone Residencial</td>
                                                        <td height="21" width="30">DDD</td>
                                                        <td height="21" width="140">Telefone Comercial</td>
                                                        <td height="21" width="30">DDD</td>
                                                        <td height="21" width="140">Telefone Celular</td>
                                                        <td height="21" width="30">DDD</td>
                                                        <td height="21" width="258">Telefone Fax</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$TelefoneDDDResidencial?></td>
                                                        <td height="21"><?=$TelefoneResidencial?></td>
                                                        <td height="21"><?=$TelefoneDDDComercial?></td>
                                                        <td height="21"><?=$TelefoneComercial?></td>
                                                        <td height="21"><?=$TelefoneDDDCelular?></td>
                                                        <td height="21"><?=$TelefoneCelular?></td>
                                                        <td height="21"><?=$TelefoneDDDFax?></td>
                                                        <td height="21"><?=$TelefoneFax?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21">E-Mail</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$Email?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
                                        <tr>
                                            <td class="titulo_pagina">
                                                <font size="2">Informa&ccedil;&otilde;es Organizacionais</font>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="150">Tipo de Funcion&aacute;rio</td>
                                                        <td height="21" width="135">Matr&iacute;cula</td>
                                                        <td height="21" width="135">Data de Admiss&atilde;o</td>
                                                        <td height="21" width="135">Data de Demiss&atilde;o</td>
                                                        <td height="21" width="233">E-Mail</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=f_ConsultaTipoFuncionario($TipoFuncionario)?></td>
                                                        <td height="21"><?=$Matricula?></td>
                                                        <td height="21"><?=$DataAdmissao?></td>
                                                        <td height="21"><?=$DataDemissao?></td>
                                                        <td height="21"><?=$FuncionarioEmail?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="798" colspan="3">Unidade de Lota&ccedil;&atilde;o/ACP</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21" colspan="3"><?=f_ConsultaEstruturaOrganizacional($EstruturaAtuacao)?></td>
                                                    </tr>
                                                    <tr class="dataLabel">                                                        
                                                        <td height="21" width="520">Local de Trabalho</td>
                                                        <td height="21" width="139">&Oacute;rg&atilde;o de Origem</td>
                                                        <td height="21" width="139">&Oacute;rg&atilde;o a Disposi&ccedil;&atilde;o</td>
                                                    </tr>
                                                    <tr class="dataField">                                                        
                                                        <td height="21"><?=f_ConsultaEstruturaOrganizacionalLotacao($EstruturaLotacao)?></td>
                                                        <td height="21"><?=f_ConsultaOrgao($OrgaoOrigem)?></td>
                                                        <td height="21"><?=f_ConsultaOrgao($OrgaoDestino)?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="315">Cargo Tempor&aacute;rio</td>
                                                        <td height="21" width="315">Cargo Permanente</td>
                                                        <td height="21" width="168">&Ocirc;nus</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=f_ConsultaCargo($CargoTemporario)?></td>
                                                        <td height="21"><?=f_ConsultaCargo($CargoPermanente)?></td>
                                                        <td height="21"><?php echo $FuncionarioOnus==1 ? "Sim" : "Não"; ?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="150">Carteira de Trabalho</td>
                                                        <td height="21" width="195" colspan="2">Carteira de Trabalho S&eacute;rie / UF</td>
                                                        <td height="21" width="140">PIS/PASEP</td>
                                                        <td height="21">Conta FGTS</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$CartTrabalho?></td>
                                                        <td height="21" width="140"><?=$CartTrabalhoSerie?></td>
                                                        <td height="21" width="55"><?=$CartTrabalhoUF?></td>
                                                        <td height="21"><?=$PIS?></td>
                                                        <td height="21"><?=$FGTS?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="201">Banco</td>
                                                        <td height="21" width="110">Ag&ecirc;ncia</td>
                                                        <td height="21" width="150">Conta</td>
                                                        <td height="21" width="337">Tipo da Conta</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$BancoNumero?> - <?=$BancoNome?></td>
                                                        <td height="21"><?=$Agencia?></td>
                                                        <td height="21"><?=$Conta?></td>
                                                        <td height="21">
                                                        <?php
                                                        if (($TipoConta == "C") && ($BancoNumero != "000"))
                                                        {
                                                            echo "Conta Corrente";
                                                        }
                                                        elseIf (($TipoConta == "P")&& ($BancoNumero != "000"))
                                                        {
                                                            echo "Conta Poupan&ccedil;a";
                                                        }
                                                        ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="798">Dados que deu origem as informacoes Cadastrais:</td>
                                                     </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="201">Num.: CI / Oficio / Processo</td>
                                                        <td height="21" width="150">Armario: Num/nome</td>
                                                        <td height="21" width="150">Gaveta</td>
                                                        <td height="21" width="150">Pasta</td>
                                                        <td height="21" width="150">Posicao</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><?=$Documento?></td>
                                                        <td height="21"><?=$Armario?></td>
                                                        <td height="21"><?=$Gaveta?></td>
                                                        <td height="21"><?=$Pasta?></td>
                                                        <td height="21"><?=$Posicao?></td>
                                                    </tr>
                                                </table>
                                                <?php include "../Include/Inc_Linha.php"?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="797" height="27" border="0" cellpadding="0" cellspacing="1">
                                        <tr class="dataLabel">
                                            <td height="25" align="right">
                                                <input type="button" style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
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
