<?php
include "Classe/ClasseDiariaComprovacao.php";
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
        <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE8'></meta>
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptDiariaComprovacaoConsultar.js"></script>
    </head>
    
    <body onload="WM_initializeToolbar(); VerificaRoteirosAdicionais();">
        <form name="Form" method="post">
            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td height="21" ><?php include "../Include/Inc_Topo.php" ?></td>
                </tr>
                <tr>
                    <td height="21" ><?php include "../Include/Inc_Aba.php" ?></td>
                </tr>
                <tr>
                    <td height="21" >
                        <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php" ?></td>
                                <td valign="top" align="left">
                                    <?php include "../Include/Inc_Titulo.php" ?>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td height="21" >
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="159" align="center">N&uacute;mero SD</td>
                                                        <td height="21" width="159" align="center">Solicitada em</td>
                                                        <td height="21" width="159" align="center">Comprovada em</td>
                                                        <td height="21" width="159" align="center">Processo</td>
                                                        <td height="21" width="159" align="center">Status</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21" align="center"><?=$linhaDiaria['diaria_numero']?></td>
                                                        <td height="21" align="center"><?=($linhaDiaria['diaria_dt_saida']) . " " . $linhaDiaria['diaria_hr_saida']?></td>
                                                        <td height="21" align="center"><?=f_FormataData($linhaDiaria['diaria_comprovacao_dt']) . " " . $linhaDiaria['diaria_comprovacao_hr']?></td>
                                                        <td height="21" align="center"><?=$linhaDiaria['diaria_processo']?></td>
                                                        <?php include "IncludeLocal/Inc_StatusDiaria.php"?>
                                                        <td height="21" align="center"><font color="#000099"><?=$StatusNome?></font></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                <?php include "../Include/Inc_Linha.php"?>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td height="21" >
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="159" align="center">N&ordm; Empenho</td>
                                                        <td height="21" width="159" align="center">Data Empenho</td>
                                                        <td height="21" width="159" align="center">Data Liquida&ccedil;&atilde;o</td>
                                                        <td height="21" width="159" align="center">Hora Liquida&ccedil;&atilde;o</td>
                                                        <td height="21" width="159" align="center">Data Execu&ccedil;&atilde;o</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21" align="center"><?=$linhaDiaria['diaria_empenho']?></td>
                                                        <td height="21" align="center"><?=f_FormataData($linhaDiaria['diaria_dt_empenho'])?></td>
                                                        <td height="21" align="center"><?=f_FormataData($linhaDiaria['diaria_financeiro_dt_obrigacao'])?></td>
                                                        <td height="21" align="center"><?=$linhaDiaria['diaria_financeiro_hr_obrigacao']?></td>
                                                        <td height="21" align="center"><?=f_FormataData($linhaDiaria['diaria_financeiro_dt_execucao'])?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                  <?php include "../Include/Inc_Linha.php"?>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td height="21" >
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="50%">Solicitante</td>
                                                        <td height="21" width="50%">Benefici&aacute;rio</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21" ><?=$linhaDiaria['solicitante_nm']?></td>
                                                        <td height="21" ><?=$linhaDiaria['beneficiario_nm']?></td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                <?php include "../Include/Inc_Linha.php"?>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td height="21" >
                                                <div id="roteiroAdicional">
                                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataTitulo">
                                                            <td height="21" colspan="8">Roteiro</td>
                                                        </tr>
                                                        <tr class="dataLabel">
                                                            <td height="21" colspan="4">Origem</td>
                                                            <td height="21" colspan="4">Destino</td>
                                                        </tr>
                                                        <?php
                                                        If ($controleRoteiro == 0) 
                                                        { 
                                                            $and = '';
                                                            $roteiro = '';
                                                        }   
                                                        else
                                                        {
                                                            $and = ' AND controle_roteiro_comprovacao = 0 ';
                                                            $roteiro = 1;
                                                        }
                                                        $sqlRoteiro = "SELECT roteiro_comprovacao_origem AS roteiro_origem, roteiro_comprovacao_destino AS roteiro_destino FROM diaria.roteiro_comprovacao WHERE diaria_id = ".$codigo." ".$and;
                                                        $rsRoteiro  = pg_query(abreConexao(), $sqlRoteiro);
                                                        $qtd        = pg_num_rows($rsRoteiro);

                                                        if($qtd == 0)
                                                        {
                                                            $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$codigo;
                                                            $rsRoteiro  = pg_query(abreConexao(), $sqlRoteiro);
                                                        }                                                                                                       

                                                        while ($linharsRoteiro = pg_fetch_assoc($rsRoteiro)) 
                                                        {
                                                            $sqlRoteiroOrigem       = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linharsRoteiro['roteiro_origem'];
                                                            $rsRoteiroOrigem        = pg_query(abreConexao(), $sqlRoteiroOrigem);
                                                            $linharsRoteiroOrigem   = pg_fetch_assoc($rsRoteiroOrigem);

                                                            $sqlRoteiroDestino      = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_destino'];
                                                            $rsRoteiroDestino       = pg_query(abreConexao(), $sqlRoteiroDestino);
                                                            $linharsRoteiroDestino  = pg_fetch_assoc($rsRoteiroDestino);
                                                            echo "<tr class='dataField'>";
                                                                echo "<td height='21' colspan='4'>&nbsp;".$linharsRoteiroOrigem['estado_uf']." - ".$linharsRoteiroOrigem['municipio_ds']."</td>";
                                                                echo "<td height='21' colspan='4'>&nbsp;".$linharsRoteiroDestino['estado_uf']." - ".$linharsRoteiroDestino['municipio_ds']."</td>";
                                                            echo "</tr>";
                                                        }
                                                        if($linhaDiaria['diaria_desconto']=='N')
                                                        {
                                                            $desconto = 'N&atilde;o';
                                                        }
                                                        else                                                    
                                                        {
                                                            $desconto = 'Sim';
                                                        }  
                                                        ?>
                                                        <tr>
                                                            <td height="21" colspan="8" class="dataLabel">Complemento do Roteiro</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21" colspan="8"><?= $linhaDiaria['diaria_roteiro_complemento']?></td>
                                                        </tr>
                                                        <tr class="dataTitulo">
                                                            <td height="21" width="399" colspan="8">Dados da Solicita&ccedil;&atilde;o</td>
                                                        </tr>
                                                        <tr class="dataTitulo">
                                                            <td height="21" width="359" colspan="3">Partida Prevista</td>
                                                            <td height="21" width="359" colspan="3">Chegada Prevista</td>
                                                            <td height="21" width="160" colspan="2">Quantidade e Valor Previstos</td>
                                                        </tr>
                                                        <tr class="dataLabel">
                                                            <td height="21" width="80">Data</td>
                                                            <td height="21" width="80">Hora</td>
                                                            <td height="21" width="139">Dia da Semana</td>
                                                            <td height="21" width="80">Data</td>
                                                            <td height="21" width="80">Hora</td>
                                                            <td height="21" width="139">Dia da Semana</td>
                                                            <td height="21" width="100">Qtde Di&aacute;rias</td>
                                                            <td height="21" width="100">Valor Total</td>                                                   
                                                        </tr>
                                                        <?php
                                                        $valor = $linhaDiaria['diaria_valor'];                                                                                                        
                                                        $valor = 'R$ '.number_format($valor, 2, ',', '.');                                                                                                          
                                                        ?>
                                                        <tr class="dataField">
                                                            <td height="21" ><?= $linhaDiaria['diaria_dt_saida'] ?></td>
                                                            <td height="21" ><?= $linhaDiaria['diaria_hr_saida'] ?></td>
                                                            <td height="21" ><?= diasemana($linhaDiaria['diaria_dt_saida'])?></td>
                                                            <td height="21" ><?= $linhaDiaria['diaria_dt_chegada'] ?></td>
                                                            <td height="21" ><?= $linhaDiaria['diaria_hr_chegada'] ?></td>
                                                            <td height="21" ><?= diasemana($linhaDiaria['diaria_dt_chegada'])?></td>  
                                                            <td height="21" ><?=$linhaDiaria['diaria_qtde'] ?></td>
                                                            <td height="21" ><?=$valor?></td> 
                                                        </tr>
                                                    </table>                                            
                                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataTitulo">
                                                            <td height="21" width="399" colspan="8">Dados da Comprova&ccedil;&atilde;o</td>
                                                        </tr>
                                                        <tr class="dataTitulo">
                                                            <td height="21" width="359" colspan="3">Partida Realizada</td>
                                                            <td height="21" width="359" colspan="3">Chegada Realizada</td>
                                                            <td height="21" width="160" colspan="2">Quantidade e Valor Efetivos</td>
                                                        </tr>
                                                        <tr class="dataLabel">
                                                            <td height="21" width="80">Data</td>
                                                            <td height="21" width="80">Hora</td>
                                                            <td height="21" width="139">Dia da Semana</td>
                                                            <td height="21" width="80">Data</td>
                                                            <td height="21" width="80">Hora</td>
                                                            <td height="21" width="139">Dia da Semana</td>
                                                            <td height="21" width="100">Qtde Di&aacute;rias</td>
                                                            <td height="21" width="100">Valor Total</td>                                                   
                                                        </tr>                                                    
                                                        <tr class="dataField">
                                                            <td height="21" width="80"><?= $linhaDiaria['diaria_comprovacao_dt_saida'] ?></td>
                                                            <td height="21" width="80"><?= $linhaDiaria['diaria_comprovacao_hr_saida'] ?></td>
                                                            <td height="21" width="139"><?= diasemana($linhaDiaria['diaria_comprovacao_dt_saida'])?></td>
                                                            <td height="21" width="80"><?= $linhaDiaria['diaria_comprovacao_dt_chegada'] ?></td>
                                                            <td height="21" width="80"><?= $linhaDiaria['diaria_comprovacao_hr_chegada'] ?></td>
                                                            <td height="21" width="139"><?= diasemana($linhaDiaria['diaria_comprovacao_dt_chegada'])?></td>  
                                                            <td height="21" width="100"><?=$linhaDiaria['diaria_comprovacao_qtde'] ?></td>
                                                      <?php                                                   
                                                        $valorComprovacao    = $linhaDiaria['diaria_comprovacao_valor'];                                                                                                        
                                                        $valorComprovacao    = 'R$ '.number_format($valorComprovacao, 2, ',', '.');                                                                                                         
                                                        $valorComprovacaoRef = $linhaDiaria['diaria_comprovacao_valor_ref'];
                                                        $valorComprovacaoRef = 'R$ '.number_format($valorComprovacaoRef, 2, ',', '.');                                                     
                                                      ?>
                                                            <td height="21" width="100"><?=$valorComprovacao ?></td> 
                                                        </tr>                                                
                                                    </table>
                                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataLabel">
                                                            <td height="21" width="120">Redu&ccedil;&atilde;o 50%</td>
                                                            <td height="21" width="228" colspan="2">Valor Refer&ecirc;ncia (Descri&ccedil;&atilde;o)</td>
                                                            <td height="21" width="150">Valor do Roteiro</td>
                                                            <td height="21" width="150">A Restituir</td>
                                                            <td height="21" width="150">A Receber</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21" ><?=$desconto?></td>
                                                            <td height="21" colspan="2"><?=f_ValorReferencia($linhaDiaria['diaria_beneficiario'],$linhaDiaria['diaria_comprovacao_dt_saida'])?></td>
                                                            <td height="21" ><?=$valorComprovacaoRef?></td>    
                                                            <?php
                                                            if($linhaDiaria['diaria_comprovacao_saldo'] != '')
                                                            {
                                                                $saldo = $linhaDiaria['diaria_comprovacao_saldo'];
                                                                $saldo = 'R$ '.number_format($saldo, 2, ',', '.');                                                            
                                                            }
                                                            else
                                                            {
                                                                $saldo = 'R$ 0,00';
                                                            }

                                                            if ($linhaDiaria['diaria_comprovacao_saldo_tipo'] == "D")
                                                            {                                                               
                                                                echo "<td height='21'> ".$saldo."</td>";
                                                                echo "<td height='21'>R$ 0,00</td>";
                                                            }
                                                            else
                                                            {	
                                                                echo "<td height='21'>R$ 0,00</td>";
                                                                echo "<td height='21'>".$saldo."</td>";
                                                            } 
                                                            if($controleRoteiro > 0)
                                                            {
                                                                echo "<tr>
                                                                         <td height='21' class='dataLabel' colspan='6'>Resumo</td>
                                                                     </tr>
                                                                     <tr>
                                                                         <td class='dataField' colspan='6'>
                                                                             <textarea id='txtResumo' name='txtResumo' class='RealmenteInvisivel2' cols='128' rows='14' disabled='disabled'>".$linhaDiaria['diaria_resumo_comprovacao']."</textarea>                                                
                                                                         </td>
                                                                     </tr>";
                                                            }
                                                            ?>                                             
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
                                                <?php
                                                if($controleRoteiro > 0)
                                                {
                                                    if($codigo != '')
                                                    {
                                                        if($linhaDiaria['saldo_tipo_total'] == 'D')
                                                        {
                                                            $saldoRestituir = number_format($linhaDiaria['saldo_total'], 2, ',', '.');
                                                            $saldoReceber   = '0,00';
                                                        }
                                                        elseif($saldoTipoTotal == 'C')
                                                        {
                                                            $saldoReceber   = number_format($linhaDiaria['saldo_total'], 2, ',', '.');
                                                            $saldoRestituir = '0,00';
                                                        }
                                                        else
                                                        {
                                                            $saldoRestituir = '0,00';
                                                            $saldoReceber   = '0,00';
                                                        }
                                                        echo"<div id='resultCalculoTotal'>
                                                                <table width='800' border='0' cellpadding='0' cellspacing='1'>
                                                                    <tr class='dataLabel'>
                                                                        <td height='21'>Quantidade total de diárias: ".$linhaDiaria['qtde_total']."</td>
                                                                        <td height='21'>Valor Total: R$ ".number_format($linhaDiaria['valor_total'], 2, ',', '.')."</td>
                                                                        <td height='21'>Total a restituir: $saldoRestituir</td>
                                                                        <td height='21'>Total a receber: $saldoReceber</td>
                                                                    </tr>
                                                                </table>                                                
                                                            </div>";
                                                    }
                                                }                                                
                                                If ($linhaDiaria['diaria_comprovacao_complemento'] == "1") 
                                                {
                                                ?>
                                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataLabel">
                                                            <td height="21">Justificativa do Complemento (Conforme Art. 4&ordm; par&aacute;grafo 2&ordm; do DECRETO N&ordm; 5.910 de Outubro de 1996.)</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21"><?=$linhaDiaria['diaria_comprovacao_complemento_justificativa']?></td>
                                                        </tr>
                                                    </table>
                                                <?php
                                                } 
                                                
                                                If ($linhaDiaria['diaria_comprovacao_justificativa_feriado'] != "") 
                                                {
                                                ?>
                                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                        <tr>
                                                            <td height="21" class="dataLabel">Justificativa do Feriado</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21"><?= $linhaDiaria['diaria_comprovacao_justificativa_feriado'] ?></td>
                                                        </tr>
                                                    </table>
                                                <?php                                                 
                                                }
                                                
                                                If ($linhaDiaria['diaria_comprovacao_justificativa_fds'] != "") 
                                                {
                                                ?>
                                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                        <tr>
                                                            <td height="21" class="dataLabel">Justificativa do Fim de Semana</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21"><?= $linhaDiaria['diaria_comprovacao_justificativa_fds'] ?></td>
                                                        </tr>
                                                    </table>
                                                <?php                                                 
                                                } 
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                <?php include "../Include/Inc_Linha.php" ?>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td height="21" >
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel" width="320">Meio de Transporte</td>
                                                        <td height="21" class="dataLabel" width="478">Meio de Transporte Observa&ccedil;&atilde;o</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField"><?= f_ExibeMeioTransporte($linhaDiaria['meio_transporte_id']) ?></td>
                                                        <td height="21" class="dataField"><?= $linhaDiaria['diaria_transporte_obs']?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel" width="320">Motivo</td>
                                                        <td height="21" class="dataLabel" width="478">Sub-Motivo</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField"><?= f_ExibeMotivo($linhaDiaria['motivo_id']) ?></td>
                                                        <td height="21" class="dataField"><?= f_ExibeSubMotivo($linhaDiaria['sub_motivo_id']) ?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel">Descri&ccedil;&atilde;o</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField"><?= $linhaDiaria['diaria_descricao']?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel">Unidade de Custo</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField"><?= f_ExibeUnidadeCusto($linhaDiaria['diaria_unidade_custo']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataLabel">Projeto</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField"><?= f_ExibeProjeto($linhaDiaria['projeto_cd']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataLabel">A&ccedil;&atilde;o</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField"><?= f_ExibeAcao($linhaDiaria['acao_cd']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataLabel">Territ&oacute;rio</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField"><?= f_ExibeTerritorio($linhaDiaria['territorio_cd']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataLabel">Fonte</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataField"><?= f_ExibeFonte($linhaDiaria['fonte_cd']) ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                <?php include "../Include/Inc_Linha.php";                                
                                if($controleRoteiro == 0)
                                {
                                ?>                                    
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td height="21" >
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel">Resumo</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="dataField">
                                                            <textarea name="teste" class="RealmenteInvisivel2" cols="128" rows="14" disabled="disabled"><?=$linhaDiaria['diaria_comprovacao_resumo']?></textarea>                                                
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>                                    
                                <?php
                                }
                                    include "../Include/Inc_Linha.php";
                                    include "IncludeLocal/Inc_HistoricoDiaria.php"; 
                                    ?>
                                    <input name="txtCodigo" id="txtCodigo" type="hidden" value="<?=$codigo?>"/>
                                    <?php
                                    include "../Include/Inc_Linha.php";
                                    
                                    If ($MensagemErroBD != "") 
                                    {
                                        echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
                                            echo "<tr>";
                                                echo "<td class='MensagemErro'>" . $MensagemErroBD . "</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                                echo "<td height='21' ><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>";
                                            echo "</tr>";
                                        echo "</table>";
                                    }
                                    ?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td align="right" height="25">
                                                <input type="button" style="width:70px" onclick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
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