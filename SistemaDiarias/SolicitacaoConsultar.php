<?php
include "Classe/ClasseDiaria.php";

if (isset($_GET["funcao"]))
{
    $funcao = $_GET["funcao"];
}
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
        <title>ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia</title>          
        <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE8' ></meta>
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptAjax.js"></script>
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptDiariaConsultar.js"></script>
        <script type="text/javascript" language="javascript">
            
            function CancelarDiaria(frm)
            {             
                frm.action = "SolicitacaoCancelar.php";
                frm.submit();
            }

            function ImprimirDiaria(frm)
            {
                window.open ("SolicitacaoImprimir.php?acao=imprimir&cod=<?= $codigo ?>");
            }	 
            //**** Alteração feita por Erinaldo em 21/02/2011 para atender a solictação da criação do perfil de Pré-Autorizador ****//
            function PreAutorizar(codigo)
            {
                // Falta fazer o form que vai fazer a verificação da pré-autorização
                var resposta = confirm("Prezado Senhor, a pré-autorização implica em concordância quanto à necessidade e oportunidade \n      do deslocamento, conforme roteiro e período indicado. Confirma pré-autorização ?");

                if (resposta == true)
                {
                    document.Form.action="VerificaDiariaPreAutorizacao.php?cod="+codigo+"&acao=preautorizar";
                    document.Form.submit();
                }
            }	
            //**** Fim da Alteração feita por Erinaldo em 21/02/2011 para atender a solictação da criação do perfil de Pré-Autorizador ****//

            function Autorizar(codigo)
            {
                var resposta = confirm("Prezado Senhor, a autorização implica em concordância \nquanto à necessidade e oportunidade o deslocamento, \nconforme roteiro e período indicado. \nConfirma autorização?");

                if (resposta == true)
                {
                    document.Form.action="SolicitacaoAutorizacaoInicio.php?cod="+codigo+"&acao=autorizar";
                    document.Form.submit();
                }
            }

            function Aprovar(codigo)
            {

                var resposta = confirm('Tem certeza que deseja aprovar a diária?');

                if (resposta == true)
                {
                    document.Form.action="SolicitacaoAprovacaoInicio.php?cod="+codigo+"&acao=aprovar";
                    document.Form.submit();
                }

            }

            function Devolver(codigo)
            {
                document.Form.action="SolicitacaoDevolver.php?cod="+codigo+"&pagina=SolicitacaoAutorizacao";
                document.Form.submit();
            }       
        </script>
    </head>
    
<body onload="WM_initializeToolbar();VerificaRoteirosAdicionais();">
    <form name="Form" method="post">
        <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td><?php include "../Include/Inc_Topo.php" ?></td>
            </tr>
            <tr>
                <td><?php include "../Include/Inc_Aba.php" ?></td>
            </tr>
            <tr>
                <td>
                    <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td height="21" valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php" ?></td>
                            <td height="21" valign="top" align="left">
                                <?php include "../Include/Inc_Titulo.php" ?>
                                <?php include "../Include/Inc_Linha.php" ?>
                                <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                    <tr>
                                        <td>
                                            <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                <tr class="dataLabel">
                                                    <td height="21" width="80" align="center">N&uacute;mero SD</td>
                                                    <td height="21" width="110" align="center">Solicitada em</td>
                                                    <td height="21" width="110" align="center">N&ordm; Empenho</td>
                                                    <td height="21" width="110" align="center">Data Empenho</td>
                                                    <td height="21" width="158" align="center">Processo</td>
                                                    <td height="21" width="230">Status</td>
                                                </tr>
                                                <tr class="dataField">
                                                    <td height="21" align="center"><?= $linhaDiaria['diaria_numero'] ?></td>
                                                    <td>&nbsp;<?= ($dataCriacao) . " " . $linhaDiaria['diaria_hr_criacao'] ?></td>
                                                    <td height="21" align="center"><?= $linhaDiaria['diaria_empenho'] ?></td>
                                                    <td height="21" align="center"><?= f_FormataData($linhaDiaria['diaria_dt_empenho']) ?></td>
                                                    <td height="21" align="center"><?= $linhaDiaria['diaria_processo']; ?></td>
                                                    <?php include "IncludeLocal/Inc_StatusDiaria.php" ?>
                                                    <?php
//                                                    $sql = "SELECT diaria_local_solicitacao,diaria_st FROM diaria.diaria WHERE diaria_numero = '$Numero'";
//                                                    $consulta = pg_query(abreConexao(),$sql);
//                                                    $tupla = pg_fetch_assoc($consulta);
//                                                    $local_diaria = $tupla["diaria_local_solicitacao"];
//                                                    $Status = $tupla["diaria_st"];
                                                    if (($linhaDiaria['diaria_st'] == 100) && ($linhaDiaria['diaria_local_solicitacao'] == "Coordenadoria" )) 
                                                    {
                                                        $StatusNome = "Pr&eacute; Autoriza&ccedil;&atilde;o";
                                                        echo "<td>&nbsp;<font color=\"#ff0000\">$StatusNome</font></td>";
                                                    } 
                                                    else 
                                                    {
                                                        echo "<td>&nbsp;<font color=\"#ff0000\">$StatusNome</font></td>";
                                                    }

                                                    if(substr($linhaDiaria['pessoa_fisica_cpf'],3,-10) == '.')
                                                    {                                                        
                                                        $chars = array(".","/","-");
                                                        $cpf = str_replace($chars,"",$linhaDiaria['pessoa_fisica_cpf']);
                                                    }
                                                    else
                                                    {
                                                        $cpf = $linhaDiaria['pessoa_fisica_cpf'];
                                                    }
                                                    ?>                                                    
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <?php include "../Include/Inc_Linha.php" ?>
                                <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                    <tr>
                                        <td>
                                            <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                <tr class="dataLabel">
                                                    <td height="21" width="339">&nbsp;Solicitante</td>
                                                    <td height="21" width="339">&nbsp;Benefici&aacute;rio</td>
                                                    <td height="21" width="120">&nbsp;CPF</td>
                                                </tr>
                                                <tr class="dataField">
                                                    <td>&nbsp;<?= f_ConsultaNomeFuncionario($linhaDiaria['diaria_solicitante']) ?></td>
                                                    <td>&nbsp;<?= f_ConsultaNomeFuncionario($linhaDiaria['diaria_beneficiario']) ?></td>
                                                    <td height="21" width="120">&nbsp;<?= $cpf ?></td>
                                                </tr>
                                            </table>
                                            <div id="roteiroAdicional">
                                                <table width='798' border='0' cellpadding='0' cellspacing='1'>
                                                <?php 
                                                If ($controleRoteiro == 0) 
                                                { 
                                                    $and = '';
                                                    $roteiro = '';
                                                }   
                                                else
                                                {
                                                    $and = ' AND controle_roteiro = 0 ';
                                                    $roteiro = 1;
                                                }
                                                echo "<tr class='dataTitulo'>
                                                          <td height='21' colspan='2'>&nbsp;Roteiro $roteiro</td>
                                                      </tr>
                                                      <tr class='dataLabel'>
                                                          <td>&nbsp;Origem</td>
                                                          <td>&nbsp;Destino</td>
                                                      </tr>";

                                                    $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id =".$codigo." ".$and;
                                                    $rsRoteiro = pg_query(abreConexao(), $sqlRoteiro);

                                                    While($linhaRoteiro = pg_fetch_assoc($rsRoteiro)) 
                                                    {
                                                        $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linhaRoteiro['roteiro_origem'];
                                                        $rsRoteiroOrigem = pg_query(abreConexao(), $sqlRoteiroOrigem);
                                                        $linhaOrigem = pg_fetch_assoc($rsRoteiroOrigem);
                                                        $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linhaRoteiro['roteiro_destino'];
                                                        $rsRoteiroDestino = pg_query(abreConexao(), $sqlRoteiroDestino);
                                                        $linhaDestino = pg_fetch_assoc($rsRoteiroDestino);
                                                        echo "<tr class='dataField' height='21'>";
                                                        echo "<td>&nbsp;" . $linhaOrigem['estado_uf'] . " - " . $linhaOrigem['municipio_ds']."</td>";
                                                        echo "<td>&nbsp;" . $linhaDestino['estado_uf'] . " - " . $linhaDestino['municipio_ds']."</td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </table>                                                                                                    

                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" colspan="8" class="dataLabel">&nbsp;Complemento do Roteiro</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21" colspan="8">&nbsp;<?= $linhaDiaria['diaria_roteiro_complemento'] ?></td>
                                                    </tr>
                                                </table>  
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataTitulo">
                                                        <td height="21" width="399" colspan="3">&nbsp;Partida Prevista</td>
                                                        <td height="21" width="399" colspan="3">&nbsp;Chegada Prevista</td>
                                                    </tr>
                                                    <tr class="dataLabel">
                                                        <td height="21" width="100">&nbsp;Data</td>
                                                        <td height="21" width="100">&nbsp;Hora</td>
                                                        <td height="21" width="199">&nbsp;Dia da Semana</td>
                                                        <td height="21" width="100">&nbsp;Data</td>
                                                        <td height="21" width="100">&nbsp;Hora</td>
                                                        <td height="21" width="199">&nbsp;Dia da Semana</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21" width="100">&nbsp;<?= $linhaDiaria['diaria_dt_saida'] ?></td>
                                                        <td height="21" width="100">&nbsp;<?= $linhaDiaria['diaria_hr_saida'] ?></td>
                                                        <td height="21" width="199">&nbsp;<?= $diaSemanaPartida ?></td>
                                                        <td height="21" width="100">&nbsp;<?= $linhaDiaria['diaria_dt_chegada'] ?></td>
                                                        <td height="21" width="100">&nbsp;<?= $linhaDiaria['diaria_hr_chegada'] ?></td>
                                                        <td height="21" width="199">&nbsp;<?= $diaSemanaChegada ?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="100">&nbsp;Redu&ccedil;&atilde;o 50%</td>
                                                        <td height="21" width="102">&nbsp;Qtde D&aacute;rais</td>
                                                        <td height="21" width="195">&nbsp;Valor Refer&ecirc;ncia</td>
                                                        <td height="21" width="98">&nbsp;Valor</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <?php                                                    
                                                    $valor = $linhaDiaria['diaria_valor'];
                                                    $valor = 'R$ '.number_format($valor, 2, ',', '.');                                                    

                                                    $valorRef = $linhaDiaria['diaria_valor_ref'];
                                                    $valorRef = 'R$ '.number_format($valorRef, 2, ',', '.');                                                          
                                                    ?>                                                        
                                                    <tr class="dataField">
                                                        <td height="21" width="85">&nbsp;<?= $desconto ?></td>
                                                        <td>&nbsp;<?= $linhaDiaria['diaria_qtde'] ?><input type="hidden" name="hdQtde" id="hdQtde" value="<?=$linhaDiaria['diaria_qtde']?>" style="width:75px; height:18px;" ></input></td>
                                                        <td height="21" width="100">&nbsp;<?= $valorRef ?></td>
                                                        <td>&nbsp;<?= $valor ?><input type="hidden" name="hdValor" id="hdValor" value="<?=$linhaDiaria['diaria_valor']?>" style="width:75px; height:18px;" ></input></td>
                                                        <td>&nbsp;<input type="hidden" name="txtValorReferencia" id="txtValorReferencia" value="<?=$linhaDiaria['diaria_valor_ref']?>" style="width:75px; height:18px;" ></input></td>
                                                    </tr>
                                                </table>
                                                <input type="hidden" id="controleRoteiro" name="controleRoteiro" value="<?=$controleRoteiro?>"/>
                                                <?php include "../Include/Inc_Linha.php" ?>
                                                <div id="roteiroAdicional1"></div>
                                                <div id="roteiroAdicional2"></div>
                                                <div id="roteiroAdicional3"></div>
                                                <div id="roteiroAdicional4"></div>
                                                <div id="roteiroAdicional5"></div>
                                                <div id="roteiroAdicional6"></div>
                                            </div>  
                                            <div id='resultCalculoTotal' style='display: none;'>
                                                <table width='800' border='0' cellpadding='0' cellspacing='0'>
                                                    <tr class='dataLabel'>
                                                        <td height='21'>&nbsp;Quantidade total de diárias: <span id='qtdeTotal' name='qtdeTotal' disabled='disabled'></span></td>
                                                        <td height='21'>Valor Total: <?='R$' . number_format($linhaDiaria['valor_total'], 2, ',', '.');?>
                                                            <!--<span id='totalDiarias' name='totalDiarias' disabled='disabled'></span>-->
                                                        </td>
														
														<!--<td height='21'>Valor Total: <span id='totalDiarias' name='totalDiarias' disabled='disabled'></span></td>-->
                                                    </tr>
                                                </table>                                                
                                            </div>
                                            <?php 
                                            if($controleRoteiro > 0)
                                            {?>
                                                
                                            <?php 
                                            }
                                            If ($linhaDiaria['diaria_justificativa_feriado'] != "") 
                                            { 
                                            ?>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel">&nbsp;Justificativa do Feriado</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td>&nbsp;<?= $linhaDiaria['diaria_justificativa_feriado'] ?></td>
                                                    </tr>
                                                </table>                                                
                                            <?php } ?>
                                            <?php If ($linhaDiaria['diaria_justificativa_fds'] != "") { ?>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel">&nbsp;Justificativa do Fim de Semana</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td>&nbsp;<?= $linhaDiaria['diaria_justificativa_fds'] ?></td>
                                                    </tr>
                                                </table>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </table> 
                                <?php include "../Include/Inc_Linha.php" ?>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel" width="320">&nbsp;Meio de Transporte</td>
                                                        <td height="21" class="dataLabel" width="478">&nbsp;Meio de Transporte Observa&ccedil;&atilde;o</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField">&nbsp;<?= f_ExibeMeioTransporte($linhaDiaria['meio_transporte_id']) ?></td>
                                                        <td height="21" class="dataField">&nbsp;<?= $linhaDiaria['diaria_transporte_obs']?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel" width="320">&nbsp;Motivo</td>
                                                        <td height="21" class="dataLabel" width="478">&nbsp;Sub-Motivo</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField">&nbsp;<?= f_ExibeMotivo($linhaDiaria['motivo_id']) ?></td>
                                                        <td height="21" class="dataField">&nbsp;<?= f_ExibeSubMotivo($linhaDiaria['sub_motivo_id']) ?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel">&nbsp;Descri&ccedil;&atilde;o</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField">&nbsp;<?= $linhaDiaria['diaria_descricao']?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel">&nbsp;Unidade de Custo</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField">&nbsp;<?= f_ExibeUnidadeCusto($linhaDiaria['diaria_unidade_custo']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataLabel">&nbsp;Projeto</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField">&nbsp;<?= f_ExibeProjeto($linhaDiaria['projeto_cd']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataLabel">&nbsp;A&ccedil;&atilde;o</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField">&nbsp;<?= f_ExibeAcao($linhaDiaria['acao_cd']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataLabel">&nbsp;Territ&oacute;rio</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField">&nbsp;<?= f_ExibeTerritorio($linhaDiaria['territorio_cd']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataLabel">&nbsp;Fonte</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField">&nbsp;<?= f_ExibeFonte($linhaDiaria['fonte_cd']) ?></td>
                                                    </tr>                                                    
                                                    <?php
                                                        if(($linhaDiaria['etapa_codigo']!= '')&&($linhaDiaria['etapa_codigo']!= 0))
                                                        {                                                                                                                    
                                                    ?>
                                                            <tr>
                                                                <td height="21" class="dataLabel">&nbsp;Meta / Etapa</td>
                                                            </tr>
                                                            <tr>
                                                                <td height="21" class="dataField">&nbsp;<?=$linhaDiaria['etapa_meta'].' - '.$linhaDiaria['etapa_codigo'].' - '.$linhaDiaria['etapa_ds']?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <?php include "IncludeLocal/Inc_HistoricoDiaria.php"; ?>
                                    <input name="txtCodigo" id="txtCodigo" type="hidden" value="<?= $codigo ?>"/>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <?php
                                    if ($MensagemErroBD != "") {
                                        echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
                                        echo "  <tr>";
                                        echo "    <td height='21' class='MensagemErro'>" . $MensagemErroBD . "</td>";
                                        echo "  </tr>";
                                        echo "  <tr>";
                                        echo "    <td><img src='../images/vazio.gif' width='1' height='10' border='0'></td>";
                                        echo "  </tr>";
                                        echo "</table>";
                                    }
                                    ?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td height="21" height="21" align="right">
                                                <?php
                                                if (isset($funcao)) 
                                                {
                                                    if ($funcao == "autorizar") 
                                                    {
                                                        echo "<input type='button' style=\"width:70px\" onClick=\"Javascript:Autorizar('$codigo');\" name=\"btnConsultar\" class=\"botao\" value='Autorizar'/>&nbsp;&nbsp";
                                                    } 
                                                    elseif ($funcao == "aprovar") 
                                                    {
                                                        echo "<input type='button' style=\"width:70px\" onClick=\"Javascript:Aprovar('$codigo');\" name=\"btnConsultar\" class=\"botao\" value='Aprovar' />&nbsp;&nbsp";
                                                    } 
                                                    elseif ($funcao == "preautorizar") 
                                                    {
                                                        echo "<input type='button' style=\"width:80px\" onClick=\"Javascript:PreAutorizar('$codigo');\" name=\"btnConsultar\" class=\"botao\" value='Pr&eacute;-Autorizar'/>&nbsp;&nbsp";
                                                    }
                                                    echo "<input type='button' style=\"width:70px\" onClick=\"Javascript:Devolver('$codigo');\" name=\"btnConsultar\" class=\"botao\" value='Devolver' />&nbsp;&nbsp";
                                                }
                                                if($PaginaLocal == 'SolicitacaoImprimirProcesso')
                                                {
                                                    echo "<input type='button' style=\"width:70px\" onClick=\"Javascript:window.location.href='$PaginaLocal".".php';\" name=\"btnConsultar\" class=\"botao\" value='Voltar'/>";
                                                }
                                                else
                                                {
                                                    echo "<input type='button' style=\"width:70px\" onClick=\"Javascript:window.location.href='$PaginaLocal"."inicio.php';\" name=\"btnConsultar\" class=\"botao\" value='Voltar'/>";
                                                }
                                                ?>									
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

