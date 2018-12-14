<?php
include "Classe/ClasseDiariaComprovacao.php";

unset($_SESSION['ContadorDestino']);
unset($_SESSION['RelacaoViagem']);
unset($_SESSION['ViagemOrigem']);
unset($_SESSION['ViagemDestino']);
unset($_SESSION['PossuiRoteiro']);
unset($_SESSION['PercentualRecebido']);
unset($_SESSION['ErroRoteiro']);
unset($_SESSION['NumeroDiarias']);
unset($_SESSION['PossuiFeriado']);
unset($_SESSION['PossuiFimSemana']);
unset($_SESSION['ValorTotal']);
unset($_SESSION['ValorPercentual']);
unset($_SESSION['Origem']);

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
        <link type="text/css" rel="stylesheet" href="../css/estilo.css"/>
        <link type="text/css" rel="stylesheet" href="../css/dhtmlgoodies_calendar.css"/>        
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>        
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>        
        <script type="text/javascript" language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>
        <script type="text/javascript" language="javascript" src="JavaScript/Diaria.js"></script>
        <script type="text/javascript" language="javascript" src="funcoes.js"></script>
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptDiariaComprovar.js"></script>        
    </head>
    
    <body onload="Javascript:WM_initializeToolbar();VerificaRoteirosAdicionais();">
        <form name="Form" method="post" action="">
            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><?php include "../Include/Inc_Topo.php" ?></td>
                </tr>
                <tr>
                    <td><?php include "../Include/Inc_Aba.php" ?></td>
                </tr>
                <tr>
                    <td>
                        <table align="left" width="990" cellspacing="0" cellpadding="1" border="0">
                            <tr>
                                <td height="21" valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php" ?></td>
                                <td height="21" valign="top" align="left">
                                    <table cellpadding="1" cellspacing="1" border="0" width="800" class="TabModulo">
                                        <tr>
                                            <td height="21" align="left" class="titulo_pagina">Di&aacute;ria \ Comprova&ccedil;&atilde;o</td>
                                            <td height="21" width="20" align="right">
                                                <table cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td height="21" align="right"><a href="Javascript:history.back(-1)"><img src="../Imagens/voltar.gif" border="0"/></a></td>
                                                        <td height="21" width="21" align="left"><a href="Javascript:history.back(-1)" class="Voltarlink">Voltar</a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table cellpadding="0" cellspacing="0" border="0" width="800">
                                        <tr>
                                            <td height="21">
                                                <table cellpadding="0" cellspacing="0" border="0" width="800">
                                                    <tr>
                                                        <!-- *********************************************************** ABA DIÁRIA *********************************************************** -->
                                                        <td>
                                                            <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba1_on">
                                                                <tr>
                                                                    <td width="7" align="left" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_esq_on.gif" width="7" height="18" alt="" /></td>
                                                                    <td background="../Imagens/bgaba_on.gif" align="center" class="linktab" width="160">Di&aacute;ria</td>
                                                                    <td width="7" align="right" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_dir_on.gif" width="7" height="18" alt="" /></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18" alt=""/></td>
                                                        <td>
                                                            <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba1_off" style="cursor:hand;display:none">
                                                                <tr>
                                                                    <td width="7" align="left" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_esq_off.gif" width="7" height="18" alt="" /></td>
                                                                    <td background="../Imagens/bgaba_off.gif" align="center" width="160"><a class="linktab" href="#" onClick="mostra_obj_id(aba1_on); esconde_obj_id(aba1_off); mostra_obj_id(formaba1);
                                                                        mostra_obj_id(aba2_off); esconde_obj_id(aba2_on); esconde_obj_id(formaba2); mostra_obj_id(aba3_off); esconde_obj_id(aba3_on); esconde_obj_id(formaba3);">Di&aacute;ria</a></td>
                                                                    <td width="7" align="right" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_dir_off.gif" width="7" height="18" alt="" /></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18" alt="" /></td>
                                                        <!-- *********************************************************** ABA PROJETO *********************************************************** -->
                                                        <td>
                                                            <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba2_on" style="cursor:hand;display:none">
                                                                <tr>
                                                                    <td width="7" align="left" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_esq_on.gif" width="7" height="18" alt="" /></td>
                                                                    <td background="../Imagens/bgaba_on.gif" align="center" class="linktab" width="160">Projeto</td>
                                                                    <td width="7" align="right" background="../Imagens/bgaba_on.gif"><img src="../Imagens/aba_dir_on.gif" width="7" height="18" alt="" /></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18" alt="" /></td>
                                                        <td>
                                                            <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba2_off">
                                                                <tr>
                                                                    <td width="7" align="left" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_esq_off.gif" width="7" height="18" alt="" /></td>
                                                                    <td background="../Imagens/bgaba_off.gif" align="center" width="160"><a class="linktab" href="#" onClick="esconde_obj_id(aba1_on); mostra_obj_id(aba1_off); esconde_obj_id(formaba1); esconde_obj_id(aba3_on); mostra_obj_id(aba3_off); esconde_obj_id(formaba3); esconde_obj_id(aba2_off); mostra_obj_id(aba2_on); mostra_obj_id(formaba2);">Projeto</a></td>
                                                                    <td width="7" align="right" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_dir_off.gif" width="7" height="18" alt="" /></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18" alt="" /></td>
                                                        <?php
                                                            if($controleRoteiro == 0)
                                                            {
                                                            ?>
                                                            <td>
                                                            <!-- *********************************************************** ABA RESUMO *********************************************************** -->
                                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba3_on" style="cursor:hand;display:none">
                                                                    <tr>
                                                                        <td width="7" align="left" background="../Imagens/bgaba_on.gif" ><img src="../Imagens/aba_esq_on.gif" width="7" height="18" alt="" /></td>
                                                                        <td background="../Imagens/bgaba_on.gif" align="center" class="linktab" width="160" >Resumo</td>
                                                                        <td width="7" align="right" background="../Imagens/bgaba_on.gif" ><img src="../Imagens/aba_dir_on.gif" width="7" height="18" alt="" /></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td width="1"><img src="../Imagens/separa_aba.gif" width="1" height="18" alt="" /></td>                                                        
                                                            <td>
                                                                <table cellpadding="0" width="100%" cellspacing="0" border="0" id="aba3_off">
                                                                    <tr>
                                                                        <td width="7" align="left" background="../Imagens/bgaba_off.gif" ><img src="../Imagens/aba_esq_off.gif" width="7" height="18" alt="" /></td>
                                                                        <td background="../Imagens/bgaba_off.gif" align="center" width="160" ><a class="linktab" href="#" onClick="esconde_obj_id(aba1_on); mostra_obj_id(aba1_off); esconde_obj_id(formaba1); esconde_obj_id(aba2_on); mostra_obj_id(aba2_off);  esconde_obj_id(formaba2); esconde_obj_id(aba3_off); mostra_obj_id(aba3_on); mostra_obj_id(formaba3);">Resumo</a></td>
                                                                        <td width="7" align="right" background="../Imagens/bgaba_off.gif" ><img src="../Imagens/aba_dir_off.gif" width="7" height="18" alt="" /></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        <?php
                                                            }
                                                            else
                                                            {
                                                        ?>
                                                            <!-- *********************************************************** ABA RESUMO *********************************************************** -->
                                                            <td>                                                            
                                                                <span id="aba3_on"></span>
                                                            </td>
                                                            <td width="1"></td>                                                        
                                                            <td>
                                                                <span id="aba3_off"><img src="../Imagens/bgaba_off.gif" width="1" height="10" alt="" /></span>                                                               
                                                            </td>
                                                        <?php
                                                            }
                                                        ?>
                                                        <td width="1"><img id="IMG_Seperacao" src="../Imagens/separa_aba.gif" style="width:440px;" height="18" alt="" /></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" class="tabFiltro"><img src="../Imagens/vazio.gif" width="1" height="10" alt="" /></td>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <!-- *********************************************************** DIV DIÁRIA *********************************************************** -->
                                    <div id="formaba1" style="display:block">
                                        <table width="798" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                            <tr>									
                                                <td height="21">
                                                    <table width="798" border="0" cellpadding="1" cellspacing="1">
                                                        <tr class="dataLabel">
                                                            <td height="21" width="50%">Solicitante</td>
                                                            <td height="21" width="50%">Benefici&aacute;rio</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21"><?= $linhaDiaria['solicitante_nm']?></td>
                                                            <td height="21"><?= $linhaDiaria['beneficiario_nm']?></td>
                                                        </tr>
                                                    </table>
                                                    <div id="roteiroAdicional">                                                         
                                                        <div id="mostrar0" onclick="Javascript:ExpandirRoteiro(0)" style="display: none">
                                                            <table cellpadding="0" cellspacing="1" class="TabelaFormulario" border="0" width="100%">
                                                                <tr class="dataTitulo">
                                                                    <td height="21" width="50%">&nbsp;1º Roteiro <span id="roteiroExMsg0"></span><input id="roteiroExcluido0" name="roteiroExcluido0" type="hidden"></input></td>
                                                                    <td height="21" width="50%" align="right"><big>+</big> /-</td>
                                                                </tr> 
                                                            </table>
                                                        </div>
                                                        <div id="roteiroAdicional0">
                                                            <table width='800' border='0' cellpadding='0' cellspacing='0' class='TabelaFormulario'>
                                                                <tr>                                                 
                                                                    <td>
                                                                        <input type="hidden" name="txtAlterouCalculo" id="txtAlterouCalculo" value="<?=$alterouCalculo?>"/>
                                                                        <table cellpadding="1" cellspacing="1" border="0" width="100%">
                                                                            <tr class="dataTitulo">
                                                                                <td height="21" width="50%">Roteiro</td>
                                                                                <td height="21" width="50%" align="right"><span id="minimizarRoteiro0" onclick="Javascript:EsconderRoteiro(0)" style="display: none"><big>-</big>  /+</span></td>
                                                                            </tr>
                                                                            <tr class="dataLabel">
                                                                                <td height="21" width="50%">Origem</td>
                                                                                <td height="21" width="50%">Destino</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2">                                                                        
                                                                                    <div id="montarRoteiro">
                                                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                                        <?php
                                                                                        if ($alterarRoteiro == 1) 
                                                                                        { 
                                                                                        ?>
                                                                                            <tr>
                                                                                                <td height="21">
                                                                                                    <table cellpadding="1" cellspacing="1" border="0" width="100%">
                                                                                                        <tr class="dataField">
                                                                                                            <td height="21" width="50"><?= f_ComboEstado("cmbRoteiroOrigemUF","onChange='Javascript:MudaComboCidadeOrigem(\"\",\"\");'" , "") ?></td>
                                                                                                            <td height="21"><div id="RoteiroOrigem"><?= f_ComboMunicipio("cmbRoteiroOrigemMunicipio", "", "") ?></div></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td height="21" class="dataField">
                                                                                                    <table cellpadding="1" cellspacing="1" border="0" width="399">
                                                                                                        <tr class="dataField">
                                                                                                            <td height="21" width="50"><?= f_ComboEstado("cmbRoteiroDestinoUF", "onChange='Javascript:MudaComboCidadeDestino(\"\",\"\");'", "") ?></td>
                                                                                                            <td height="21">
                                                                                                                <div id="RoteiroDestino"><?= f_ComboMunicipio("cmbRoteiroDestinoMunicipio", "", "") ?></div>
                                                                                                            </td>
                                                                                                            <td height="21">
                                                                                                                <input type="button" name="btnAdicionar" id="btnAdicionar" style="width:65px; height:18px;" value="Adicionar" onclick="Javascript:AdicionarDadosRoteiro('');" />                                                                             
                                                                                                                <input type="button" name="btnLimpar" id="btnLimpar" value="Limpar" style="width:65px; height:18px;" onclick="Javascript:LimparDadosRoteiro('');"/>                                                                                                                                                           
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        <?php
                                                                                        } 
                                                                                        else
                                                                                        {         
                                                                                            If ($controleRoteiro == 0) 
                                                                                            { 
                                                                                                $and = '';
                                                                                            }                                                                                   
                                                                                            
                                                                                            $dataSaidaPrevista      = $linhaDiaria['diaria_dt_saida'];
                                                                                            $horaSaidaPrevista      = $linhaDiaria['diaria_hr_saida'];
                                                                                            $dataChegadaPrevista    = $linhaDiaria['diaria_dt_chegada'];
                                                                                            $horaChegadaPrevista    = $linhaDiaria['diaria_hr_chegada'];
                                                                                            $qtdeDiariasPrevista    = $linhaDiaria['diaria_qtde'];
                                                                                            $valorDiariaPrevista    = $linhaDiaria['diaria_valor'];
                                                                                            $descontoPrevisto       = $linhaDiaria['diaria_desconto'];
                                                                                            
                                                                                            if($linhaDiaria['diaria_comprovada'] == 0)
                                                                                            {
                                                                                                if($controleRoteiro > 0)
                                                                                                {
                                                                                                    $and        = ' AND controle_roteiro = 0 ';
                                                                                                    $valorTotal = $linhaDiaria['valor_total'];
                                                                                                    $qtdeTotal  = $linhaDiaria['qtde_total'];
                                                                                                    $valorTotalPrevisto = $valorTotal;
                                                                                                    $qtdeTotalPrevisto  = $qtdeTotal;
                                                                                                }
                                                                                                
                                                                                                $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$codigo." ".$and;
                                                                                                $rsRoteiro  = pg_query(abreConexao(), $sqlRoteiro);
                                                                                                $j          = 0;
                                                                                                
                                                                                                $dataSaida              = $linhaDiaria['diaria_dt_saida'];
                                                                                                $horaSaida              = $linhaDiaria['diaria_hr_saida']; 
                                                                                                $dataChegada            = $linhaDiaria['diaria_dt_chegada'];       
                                                                                                $horaChegada            = $linhaDiaria['diaria_hr_chegada'];
                                                                                                $qtdeDiarias            = $linhaDiaria['diaria_qtde'];
                                                                                                $valorRef               = $linhaDiaria['diaria_valor_ref'];
                                                                                                $valorDiaria            = $linhaDiaria['diaria_valor'];                                                                                                
                                                                                                $justificativaFimSemana = $linhaDiaria['diaria_justificativa_fds'];
                                                                                                $justificativaFeriado   = $linhaDiaria['diaria_justificativa_feriado'];                                                                                                                                                                                                                                                                                                                                                                                               
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                if($controleRoteiro > 0)
                                                                                                {
                                                                                                    $and                = ' AND controle_roteiro_comprovacao = 0 ';
                                                                                                    $valorTotal         = $linhaDiaria['valor_total'];                                                                                                    
                                                                                                    $qtdeTotal          = $linhaDiaria['qtde_total'];
                                                                                                    $saldoTipoTotal     = $linhaDiaria['saldo_tipo_total'];                                                                                                    
                                                                                                    $valorTotalPrevisto = $linhaDiaria['valor_total_previsto'];
                                                                                                    $qtdeTotalPrevisto  = $linhaDiaria['qtde_total_previsto'];
                                                                                                    $resumo             = $linhaDiaria['diaria_resumo_comprovacao'];
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    $resumo             = $linhaDiaria['diaria_comprovacao_resumo'];
                                                                                                }
                                                                                                $dataSaida              = $linhaDiaria['diaria_comprovacao_dt_saida'];
                                                                                                $horaSaida              = $linhaDiaria['diaria_comprovacao_hr_saida'];
                                                                                                $dataChegada            = $linhaDiaria['diaria_comprovacao_dt_chegada'];
                                                                                                $horaChegada            = $linhaDiaria['diaria_comprovacao_hr_chegada'];
                                                                                                $qtdeDiarias            = $linhaDiaria['diaria_comprovacao_qtde'];
                                                                                                $valorRef               = $linhaDiaria['diaria_valor_ref'];
                                                                                                $desconto               = $linhaDiaria['diaria_comprovacao_desconto'];
                                                                                                $valorDiaria            = $linhaDiaria['diaria_comprovacao_valor'];                                                                                                
                                                                                                $justificativaFimSemana = $linhaDiaria['diaria_comprovacao_justificativa_fds'];
                                                                                                $justificativaFeriado   = $linhaDiaria['diaria_comprovacao_justificativa_feriado'];                                                                                                                                                                                                                                                                                                                                                                                                   
                                                                                                
                                                                                                $sqlRoteiro = "SELECT roteiro_comprovacao_origem AS roteiro_origem, roteiro_comprovacao_destino AS roteiro_destino FROM diaria.roteiro_comprovacao WHERE diaria_id = ".$codigo." ".$and;
                                                                                                $rsRoteiro  = pg_query(abreConexao(), $sqlRoteiro);
                                                                                                $j          = 0;
                                                                                            }

                                                                                            while ($linha = pg_fetch_assoc($rsRoteiro))
                                                                                            {
                                                                                                $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linha['roteiro_origem'];
                                                                                                $rsRoteiroOrigem  = pg_query(abreConexao(), $sqlRoteiroOrigem);
                                                                                                $linhaOrigem      = pg_fetch_assoc($rsRoteiroOrigem);

                                                                                                $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linha['roteiro_destino'];
                                                                                                $rsRoteiroDestino  = pg_query(abreConexao(), $sqlRoteiroDestino);
                                                                                                $linhaDestino      = pg_fetch_assoc($rsRoteiroDestino);

                                                                                                echo "<tr class='dataField' id='roteiroCadastrado'>";
                                                                                                    echo "<td height='21'>&nbsp;".$linhaOrigem['estado_uf']." - ".$linhaOrigem['municipio_ds']."</td>";
                                                                                                    echo "<td height='21'>&nbsp;".$linhaDestino['estado_uf']." - ".$linhaDestino['municipio_ds']."</td>";
                                                                                                echo "</tr>";

                                                                                                if ($j == 0) 
                                                                                                {
                                                                                                    //verifica se o municipio eh da bahia
                                                                                                    $sqlConsultaUF = "SELECT estado_uf FROM dados_unico.municipio WHERE municipio_cd = ".$linhaDestino['municipio_cd'];
                                                                                                    $rsConsultaUF = pg_query(abreConexao(), $sqlConsultaUF);

                                                                                                    $linhaUF = pg_fetch_assoc($rsConsultaUF);

                                                                                                    if ($linhaUF['estado_uf'] != "BA") 
                                                                                                    {
                                                                                                        //verifica o percentual do municipio para calculo
                                                                                                        $sqlConsultaCidade = "SELECT percentual_ds FROM diaria.percentual_capital pc, diaria.percentual p WHERE (pc.percentual_id = p.percentual_id) AND municipio_cd = ".$linhaDestino['municipio_cd'];
                                                                                                        $rsConsultaCidade = pg_query(abreConexao(), $sqlConsultaCidade);

                                                                                                        $linhaCidade = pg_fetch_assoc($rsConsultaCidade);

                                                                                                        if ($linhaCidade) 
                                                                                                        {
                                                                                                            $Percentual = $linhaCidade['percentual_ds'];
                                                                                                        } 
                                                                                                        else 
                                                                                                        {
                                                                                                            $sql3 = "SELECT percentual_ds FROM diaria.percentual WHERE percentual_id = 2";
                                                                                                            $rs3  = pg_query(abreConexao(), $sql3);

                                                                                                            $linhars3   = pg_fetch_assoc($rs3);
                                                                                                            $Percentual = $linhars3['percentual_ds']; //recebe valor padrao de calculo
                                                                                                        }                                                                        
                                                                                                    } 
                                                                                                    else 
                                                                                                    { //Alterar por Rodolfo . 03-09-2008

                                                                                                        if ($linhaDestino['municipio_ds'] == "SALVADOR") 
                                                                                                        {
                                                                                                            //verifica o percentual do municipio para calculo
                                                                                                            $sqlConsultaCidade = "SELECT percentual_ds FROM diaria.percentual_capital pc, diaria.percentual p WHERE (pc.percentual_id = p.percentual_id) AND municipio_cd = " . $linhaOrigem['municipio_cd'];
                                                                                                            $rsConsultaCidade  = pg_query(abreConexao(), $sqlConsultaCidade);

                                                                                                            $linhaCidade = pg_fetch_assoc($rsConsultaCidade);

                                                                                                            if ($linhaCidade) 
                                                                                                            {
                                                                                                                $Percentual = $linhaCidade['percentual_ds'];
                                                                                                            } 
                                                                                                            else 
                                                                                                            {
                                                                                                                $sql3 = "SELECT percentual_ds FROM diaria.percentual WHERE percentual_id = 3";
                                                                                                                $rs3 = pg_query(abreConexao(), $sql3);                                                                                
                                                                                                                $linhars3 = pg_fetch_assoc($rs3);
                                                                                                                $Percentual = $linhars3['percentual_ds']; //recebe valor padrao de calculo
                                                                                                            }
                                                                                                        } 
                                                                                                        else 
                                                                                                        {
                                                                                                            $Percentual = 0; //nao altera o calculo, so para cidades da bahia
                                                                                                        }
                                                                                                    }
                                                                                                    $j = 1;
                                                                                                }
                                                                                            }
                                                                                            //botao para alterar roteiro e campo q grava o percentual do roteiro
                                                                                            echo "<tr class=dataField>";                                                                                    
                                                                                                echo "<td height='21' colspan=2 align=right><input type=button style=width:85px; value='Alterar Roteiro' onclick=AlterarRoteiro('');>&nbsp;<input type=hidden name='txtPercentual' id='txtPercentual' value= '".$Percentual."' /></td>";
                                                                                            echo "</tr>";                                                     
                                                                                        }?>
                                                                                    </table>
                                                                                </div>
                                                                            </td>
                                                                        </tr>                                                                                                                            
                                                                    </table>
                                                                    <div id="RoteiroAdicionado"></div> 
                                                                    <table width="798" border="0" cellpadding="1" cellspacing="1">    
                                                                        <tr>
                                                                            <td height="21" colspan="9" class="dataLabel">Complemento do Roteiro</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="21" colspan="9" class="dataField">&nbsp;<input type="text" name="txtRoteiroComplemento" id="txtRoteiroComplemento" style="width:798px;" disabled="disabled" value="<?=$linhaDiaria['diaria_roteiro_complemento'];?>"/></td>
                                                                        </tr>
                                                                        <tr class="dataTitulo">
                                                                            <td height="21" width="250" colspan="3">Partida Prevista</td>
                                                                            <td height="21" width="250" colspan="3">Chegada Prevista</td>
                                                                            <td height="21" width="298" colspan="3">Quantidade e Valor Previstos</td>
                                                                        </tr>
                                                                        <tr class="dataLabel">
                                                                            <td height="21" width="90" align="center">Data</td>
                                                                            <td height="21" width="60" align="center">Hora</td>
                                                                            <td height="21" width="100" align="center">Dia da Semana</td>
                                                                            <td height="21" width="90" align="center">Data</td>
                                                                            <td height="21" width="60" align="center">Hora</td>
                                                                            <td height="21" width="100" align="center">Dia da Semana</td>
                                                                            <td height="21" width="98" >Qtde Di&aacute;rias</td>
                                                                            <td height="21" width="100" >Valor Unitário</td>
                                                                            <td height="21" width="100" >Valor Total</td>                                                   
                                                                        </tr>
                                                                        <tr class="dataField">
                                                                            <td height="21" align="center" ><?= $dataSaidaPrevista?></td>
                                                                            <td height="21" align="center" ><?= $horaSaidaPrevista?></td>
                                                                            <td height="21" align="center" ><?= diasemana($dataSaidaPrevista)?></td>
                                                                            <td height="21" align="center" ><?= $dataChegadaPrevista?></td>
                                                                            <td height="21" align="center" ><?= $horaChegadaPrevista?></td>
                                                                            <td height="21" align="center" ><?= diasemana($dataChegadaPrevista)?></td>  
                                                                            <td height="21" ><?= $qtdeDiariasPrevista?></td>
                                                                            <td height="21" ><?='R$ '.number_format($valorRef, 2, ',', '.')?></td>
                                                                            <td height="21" ><?='R$ '.number_format($valorDiariaPrevista, 2, ',', '.')?></td> 
                                                                        </tr>
                                                                    </table>     
                                                                    <table width="798" border="0" cellpadding="1" cellspacing="1">                                                        
                                                                        <tr class="dataTitulo">
                                                                            <td height="21" width="399" colspan="4">Partida Realizada</td>
                                                                            <td height="21" width="399" colspan="4">Chegada Realizada</td>
                                                                        </tr>
                                                                        <tr class="dataLabel">
                                                                            <td height="21" width="100" colspan="2">Data</td>
                                                                            <td height="21" width="100">Hora</td>
                                                                            <td height="21" width="199">Dia da Semana</td>
                                                                            <td height="21" width="100" colspan="2">&nbsp;Data</td>
                                                                            <td height="21" width="100">Hora</td>
                                                                            <td height="21" width="199">Dia da Semana</td>
                                                                        </tr>
                                                                        <tr class="dataField">
                                                                            <td height="21" width="80"><input id="dataPartida" type="text" name="txtDataPartida" maxlength="10" style=" width:75px;height:15px;"  value="<?=$dataSaida?>" onchange="compute(this,1);PedeNovoCalculo('');"/></td>
                                                                            <td height="21" width="20"><a href="#" onclick="javascript:displayCalendar(document.getElementById('dataPartida'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18" /></a></td>
                                                                            <td height="21" width="100"><input id="horaPartida" type="text" name="txtHoraPartida" maxlength="5" style=" width:75px;height:15px;" onkeyup="mascaraHora(this.value, document.Form.txtHoraPartida);PedeNovoCalculo('');" onkeypress="mascaraNumero(event, this);" value="<?=$horaSaida?>" onchange="PedeNovoCalculo('');"/></td>
                                                                            <td height="21" width="199"><input id="diaPartida" type="text" name="txtPartidaSemana" class="Oculto" value="<?= diasemana($dataSaida)?>"/></td>
                                                                            <td height="21" width="80"><input id="dataChegada" type="text" name="txtDataChegada" maxlength="10" style="width:75px;height:15px;"  value="<?=$dataChegada?>" onchange="compute(this,2);PedeNovoCalculo('')"/></td>
                                                                            <td height="21" width="20"><a href="#" onclick="javascript:displayCalendar(document.getElementById('dataChegada'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18"/></a></td>
                                                                            <td height="21" width="100"><input id="horaChegada" type="text" name="txtHoraChegada" maxlength="5" style=" width:75px;height:15px;" onkeyup="mascaraHora(this.value, document.Form.txtHoraChegada);PedeNovoCalculo('');" onkeypress="mascaraNumero(event, this);" value="<?=$horaChegada?>" onchange="PedeNovoCalculo('');"/></td>
                                                                            <td height="21" width="199"><input id="diaChegada" type="text" name="txtChegadaSemana" class="Oculto" value="<?= diasemana($dataChegada)?>" /></td>
                                                                        </tr>
                                                                    </table>
                                                                    <table width="798" border="0" cellpadding="1" cellspacing="1">										
                                                                        <tr class="dataLabel">
                                                                            <td height="21" width="100">Redu&ccedil;&atilde;o 50%</td>
                                                                            <td height="21" width="181">Valor Refer&ecirc;ncia (Descri&ccedil;&atilde;o)</td>
                                                                            <td height="21" width="119">Valor do Roteiro</td>
                                                                            <td height="21" width="100">Qtde Di&aacute;rias</td>
                                                                            <td height="21" width="100">Valor Total</td>
                                                                            <td height="21" width="99">A Restituir</td>
                                                                            <td height="21" width="99">A Receber</td>
                                                                        </tr>											
                                                                        <tr class="dataField">
                                                                            <?php
                                                                            if ($linhaDiaria['diaria_beneficiario'] != "") 
                                                                            {
                                                                                echo "<script type='text/javascript' language='javascript'>";                                                          
                                                                                    echo "Javascript:ConsultaValorRef(".$linhaDiaria['diaria_beneficiario'].",'".$dataSaida."');";
                                                                                echo "</script>";
                                                                            }
                                                                            $percentualImprimir = (str_replace(",", ".", $Percentual) * 100);                                                             
                                                                            ?>
                                                                            <td height="21" width="100">
                                                                                <input type="checkbox" name="chkDesconto" id="chkDesconto" class="checkbox" <?=$descontoMarcado?>  onchange="Javascript:PedeNovoCalculo('');"/>Sim
                                                                            </td>
                                                                            <td height="21" width="181">
                                                                                <div id="ValorRef">
                                                                                    <input type="hidden" name="txtValorReferencia" id="txtValorReferencia" value="<?=$valorRef?>" style=" width:75px; height:18px;" />
                                                                                </div>
                                                                            </td>
                                                                            <td height="21" width="318" colspan="3" >
                                                                                <div id="QtdeDiariaAlterar"> 
                                                                                    <table width="318" border="0" cellpadding="0" cellspacing="0">
                                                                                        <tr class="dataField">                                                                           
                                                                                            <td height="21" width="118"><?='+'.$percentualImprimir.'% R$ '.number_format($valorRef, 2, ',', '.')?></td>
                                                                                            <td height="21" width="100"><?=$qtdeDiarias?><input type='hidden' id='hdQtdeDiaria' name='hdQtdeDiaria' value='<?=$qtdeDiarias?>'/></td>
                                                                                            <td height="21" width="100"><?='R$ '.number_format($valorDiaria, 2, ',', '.')?><input type='hidden' id='hdValorDiaria' name='hdValorDiaria' value='<?=$valorDiaria?>'/></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>                                                                
                                                                            </td>
                                                                            <td height="21" width="198" colspan="2">
                                                                                <div id="diariaSaldo">
                                                                                    <table width="198" border="0" cellpadding="0" cellspacing="0">
                                                                                        <tr class="dataField">
                                                                                            <?php

                                                                                            if($linhaDiaria['diaria_comprovacao_saldo'] != '')
                                                                                            {
                                                                                                $saldo = $linhaDiaria['diaria_comprovacao_saldo'];
                                                                                                if(substr($saldo,0,3) != 'R$ ')
                                                                                                {
                                                                                                    $saldo = 'R$ '.number_format($saldo, 2, ',', '.');
                                                                                                }
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                $saldo = 'R$ 0,00';
                                                                                            }


                                                                                            if ($linhaDiaria['diaria_comprovacao_saldo_tipo'] == "D")
                                                                                            {                                                                                
                                                                                                echo "<td height='21'>$saldo</td>";
                                                                                                echo "<td height='21'>R$ 0,00</td>";
                                                                                            }
                                                                                            else
                                                                                            {	
                                                                                                echo "<td height='21'>R$ 0,00</td>";
                                                                                                echo "<td height='21'>$saldo</td>";
                                                                                            }  
                                                                                            ?> 
                                                                                        </tr>
                                                                                    </table>
                                                                                </div> 
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="dataLabelSemBold">
                                                                            <td height="21" width="798" colspan="7" align="right">
                                                                                <input id="calcular" type="button" name="btnCalcular" style=" width:125px;height:18px;" value="Calcular Di&aacute;ria" onclick="Javascript:CalcularComprovacao($('#dataPartida').val(), $('#dataChegada').val(), $('#horaPartida').val(), $('#horaChegada').val(), <?=$linhaDiaria['diaria_beneficiario']?>, $('#chkDesconto').is(':checked'), $('#txtDataAtual').val(), <?=$linhaDiaria['diaria_valor']?>, $('#dataPartida').val(),'', 0);"/>
                                                                            </td>                                                                            
                                                                        </tr>
                                                                    </table>
                                                                    <?php
                                                                    if($controleRoteiro > 0)
                                                                    {

                                                                        include "../Include/Inc_Linha.php";
                                                                    ?>
                                                                        <table width="798" border="0" cellpadding="1" cellspacing="1">   
                                                                            <tr class="dataTitulo">
                                                                                <td height="21" width="319">Resumo</td>
                                                                                <td height="21" width="479" align="right">M&aacute;ximo permitido 3000 caracteres <input type="text" id="QtdResumo" name="QtdResumo" style=" width:35px; height:12px;" class="Oculto"/> M&aacute;ximo permitido 25 linhas</td>                                                                                        
                                                                            </tr>
                                                                            <tr class="dataField">
                                                                                <td width="798" colspan="2"><textarea name="txtResumo0" id="txtResumo0" cols="130" rows="15" onkeyup="ContarResumoComprovacao(this,3000,'');ContarResumoLinha(this.value)"><?=$resumo?></textarea></td>                                                                                        
                                                                            </tr>
                                                                        </table>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <input type="hidden" id="controleRoteiro" name="controleRoteiro" value="<?=$controleRoteiro?>"/>
                                                    <?php include "../Include/Inc_Linha.php" ?>                                                    
                                                    <div id="mostrar1" onclick="Javascript:ExpandirRoteiro(1)" style="display: none"></div>
                                                    <div id="roteiroAdicional1"></div>
                                                    <div id="espaco1"></div>
                                                    <div id="mostrar2" onclick="Javascript:ExpandirRoteiro(2)" style="display: none"></div>
                                                    <div id="roteiroAdicional2"></div>
                                                    <div id="espaco2"></div>
                                                    <div id="mostrar3" onclick="Javascript:ExpandirRoteiro(3)" style="display: none"></div>
                                                    <div id="roteiroAdicional3"></div>
                                                    <div id="espaco3"></div>
                                                    <div id="mostrar4" onclick="Javascript:ExpandirRoteiro(4)" style="display: none"></div>
                                                    <div id="roteiroAdicional4"></div>
                                                    <div id="espaco4"></div>
                                                    <div id="mostrar5" onclick="Javascript:ExpandirRoteiro(5)" style="display: none"></div>
                                                    <div id="roteiroAdicional5"></div>
                                                    <div id="espaco5"></div>
                                                    <div id="mostrar6" onclick="Javascript:ExpandirRoteiro(6)" style="display: none"></div>
                                                    <div id="roteiroAdicional6"></div>
                                                    <div id="espaco6"></div>
                                                </div>
                                                <div id="tableBloqueio" style="display: none;"></div> 
                                                <div id="calculoRoteiroAdicional" style="display: none;">
                                                    <table width="800" border="0" cellpadding="0" cellspacing="1">
                                                        <tr>
                                                            <td align="right">
                                                                <input type="button" id="calcularRoteiro" name="btnCalcularRoteiro" style="width:140px;height:18px;" class="buttonOn" value="Calcular Total de Diárias" onclick="CalcularTotalDiarias();"/>
                                                                <input type="hidden" id="calculoTotalDiarias" name="calculoTotalDiarias" value="0"/>
                                                            </td>
                                                        </tr>
                                                    </table>                                            
                                                </div>   
                                                <?php                                               
                                                if($controleRoteiro > 0)
                                                {
                                                    if($codigo != '')
                                                    {
                                                        if($saldoTipoTotal == 'D')
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
                                                                <table width='800' border='0' cellpadding='0' cellspacing='0' class='TabelaFormulario'>
                                                                    <tr class='dataLabel'>
                                                                        <td height='21'>Quantidade total de diárias: <span id='spQtde'>".$qtdeTotal."</span> <input type='hidden' id='qtdeTotal' name='qtdeTotal' value='".$qtdeTotal."'/></td>
                                                                        <td height='21'>Valor Total: <span id='spValorTotal'>R$ ".number_format($valorTotal, 2, ',', '.')."</span> <input type='hidden' id='totalDiarias' name='totalDiarias' value='".$valorTotal."'/> <input type='hidden' name='txtSaldoTotalTipo' id='txtSaldoTotalTipo' value=''/></td>
                                                                        <td height='21'>Total a restituir: <span id='spTotalRestituir'>R$ $saldoRestituir</span> <input type='hidden' id='totalRestituir' name='totalRestituir' value='$saldoRestituir'/></td>
                                                                        <td height='21'>Total a receber: <span id='spTotalReceber'>R$ $saldoReceber</span> <input type='hidden' id='totalReceber' name='totalReceber' value='$saldoReceber'/></td>
                                                                    </tr>
                                                                </table>                                                
                                                            </div>";
                                                    }
                                                }                                       
                                                include "../Include/Inc_Linha.php"; 
                                                ?>  
                                                <div id="MostrarResumoBloqueio">
                                                    <?php 
                                                    include "IncludeLocal/Inc_Regra_Bloqueio.php";

                                                    if ($ContadorVirtual > 2) 
                                                    {
                                                        echo "<table width='798' border='0' cellpadding='1' cellspacing='1'>";
                                                            echo "<tr class='dataLabelSemBold'>";
                                                                echo "<td class='MensagemErro' height='21'>BLOQUEADO - Beneficiário com comprovação pendente de documentação. Número(s) da(s) SD: " . $NumeroDiariaVirtual . "</td>";
                                                            echo "</tr>";
                                                        echo "</table>";
                                                    }
                                                    if ($ContadorAtraso > 1) 
                                                    {
                                                        echo "<table width='798' border='0' cellpadding='1' cellspacing='1'>";
                                                            echo "<tr class='dataLabelSemBold'>";
                                                                echo "<td class='MensagemErro' height='21'>BLOQUEADO - Beneficiário com solicitação pendente de comprovação. Número(s) da(s) SD: " . $NumeroDiariaAtrasada . "</td>";
                                                            echo "</tr>";
                                                        echo "</table>";
                                                    }
                                                    ?>                                                    
                                                </div>  
                                                <div id="ComplementoValor" style="display:none;">                                                        
                                                    <table width="798" border="0" cellpadding="1" cellspacing="1">                                                
                                                        <tr class="dataField"> 
                                                            <td height="21" colspan="2">
                                                                <input type="checkbox" name="chkComplemento" id="chkComplemento" class="checkbox" onclick="Javascript:CalcularComprovacao($('#dataPartida').val(), $('#dataChegada').val(), $('#horaPartida').val(), $('#horaChegada').val(), <?=$linhaDiaria['diaria_beneficiario']?>, $('#chkDesconto').is(':checked'), $('#txtDataAtual').val(), <?=$linhaDiaria['diaria_valor']?>,$('#dataPartida').val(),'', 0);"/>&nbsp;Complemento de di&aacute;ria, conforme Art. 4&deg; par&aacute;grafo 2&deg; do DECRETO N&deg; 5.910 de Outubro de 1996.
                                                            </td>
                                                        </tr>
                                                        <tr class="dataLabel">
                                                            <td height="21" width="50%">Justificativa do Complemento</td>
                                                            <td height="21" width="50%" align="right">M&aacute;ximo permitido 100 caracteres&nbsp;<input type="text" id="QtdeComplemento" name="QtdeComplemento" style=" width:35px;" class="Oculto"/></td>
                                                        </tr>                                                                                                                                                        
                                                        <tr class="dataField">
                                                            <td colspan="2"><textarea name="txtComplemento" id="txtComplemento" style=" width:789px; height:30px" maxlenght="100" onkeyup="ContarComplemento(this,100)"><?= $linhaDiaria['diaria_comprovacao_complemento_justificativa']; ?></textarea></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <table width="798" border="0" cellpadding="1" cellspacing="1">
                                                    <tr>
                                                        <td>                                                                
                                                            <table width="798" border="0" cellpadding="0" cellspacing="0">
                                                                <tr class="dataLabel">
                                                                    <td>
                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                            <tr>
                                                                                <td height="21" width="50%" class="dataLabel">Justificativa do Final de Semana</td>
                                                                                <td height="21" width="50%" class="dataLabelSemBold" align="right">M&aacute;ximo permitido 255 caracteres&nbsp;<input type="text" id="QtdFimSemana" name="QtdFimSemana" style=" width:35px;" class="Oculto"/></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr class="dataField">                                                                        
                                                                    <td height="21"><textarea name="txtJustificativaFimSemana" id="txtJustificativaFimSemana" style=" width:789px; height:45px" maxlenght="255" onkeyup="ContarJustificativaFimSemana(this,255)"><?=$justificativaFimSemana?></textarea></td>
                                                                </tr>
                                                            </table>
                                                            <table width="798" border="0" cellpadding="0" cellspacing="0">
                                                                <tr class="dataLabel">
                                                                    <td>
                                                                        <table width="798" cellpadding="0" cellspacing="0" border="0">
                                                                            <tr>
                                                                                <td height="21" width="50%" class="dataLabel">Justificativa do Feriado</td>
                                                                                <td height="21" width="50%" class="dataLabelSemBold" align="right">M&aacute;ximo permitido 255 caracteres&nbsp;<input type="text" id="QtdFeriado" name="QtdFeriado" style=" width:35px;" class="Oculto"/></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr class="dataField">                                                                        
                                                                    <td height="21"><textarea name="txtJustificativaFeriado" id="txtJustificativaFeriado" style=" width:789px; height:45px;" maxlenght="255" onkeyup="ContarJustificativaFeriado(this,255)"><?=$justificativaFeriado?></textarea></td>
                                                                </tr>
                                                            </table>
                                                            <input type="hidden" id="calculo" name="Calculo" value="<?=$diariaCalculada?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>                                    
                                <!-- *********************************************************** DIV PROJETO *********************************************************** -->
                                <div id="formaba2" style="display:none">
                                    <table width="798" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td>
                                                <table width="798" border="0" cellpadding="1" cellspacing="1">
                                                    <tr >
                                                        <td height="21" class="dataLabel" width="320">Meio de Transporte</td>
                                                        <td height="21" class="dataLabel" width="478">Meio de Transporte Observa&ccedil;&atilde;o</td>
                                                    </tr>
                                                    <tr >                                                            
                                                        <td height="21" class="dataField"><?= f_ExibeMeioTransporte($linhaDiaria['meio_transporte_id']) ?></td>
                                                        <td height="21" class="dataField"><?= $linhaDiaria['diaria_transporte_obs']?></td>
                                                    </tr>
                                                </table>
                                                <table width="800" border="0" cellpadding="1" cellspacing="1">
                                                    <tr >
                                                        <td height="21" class="dataLabel" width="320">Motivo</td>
                                                        <td height="21" class="dataLabel" width="478">Sub-Motivo</td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataField"><?= f_ExibeMotivo($linhaDiaria['motivo_id']) ?></td>
                                                        <td height="21" class="dataField"><div id="SubMotivo"><?= f_ExibeSubMotivo($linhaDiaria['sub_motivo_id']) ?></div></td>
                                                    </tr>
                                                </table>
                                                <table width="800" border="0" cellpadding="1" cellspacing="1">
                                                    <tr >
                                                        <td height="21" class="dataLabel">Descri&ccedil;&atilde;o da Di&aacute;ria</td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataField"><?= $linhaDiaria['diaria_descricao']?></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="1" cellspacing="1">
                                                    <tr >
                                                        <td height="21" class="dataLabel">Unidade de Custo</td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataField"><?= f_ExibeUnidadeCusto($linhaDiaria['diaria_unidade_custo']) ?></td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataLabel">Projeto</td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataField"><?= f_ExibeProjeto($linhaDiaria['projeto_cd']) ?> </td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataLabel">A&ccedil;&atilde;o</td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataField"><?= f_ExibeAcao($linhaDiaria['acao_cd']) ?></td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataLabel">Territ&oacute;rio</td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataField"><?= f_ExibeTerritorio($linhaDiaria['territorio_cd']) ?></td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataLabel">Fonte</td>
                                                    </tr>
                                                    <tr >
                                                        <td height="21" class="dataField"><div id="Fonte"><?= f_ExibeFonte($linhaDiaria['fonte_cd']) ?></div></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- *********************************************************** DIV RESUMO *********************************************************** -->
                                <div id="formaba3" style="display:none">
                                    <table width="798" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">   
                                        <tr class="dataLabel">
                                            <td>
                                                <table width="798" cellpadding="1" cellspacing="1" border="0">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="319">Resumo</td>
                                                        <td height="21" width="479" align="right">M&aacute;ximo permitido 3000 caracteres<input type="text" id="QtdResumo" name="QtdResumo" style=" width:35px;" class="Oculto"/>M&aacute;ximo permitido 25 linhas</td>                                                                                        
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr> 
                                        <tr class="dataField">
                                            <td width="798"><textarea name="txtResumo" id="txtResumo" cols="154" rows="22" onkeyup="ContarResumo(this,3000);ContarResumoLinha(this.value)"><?=$resumo?></textarea></td>                                                                                        
                                        </tr>
                                    </table>                                                           
                                </div>
                                <input name="roteirosExcluidos" id="roteirosExcluidos" type="hidden" value="0"/>
                                <input name="alterarTotalDiarias" id="alterarTotalDiarias" type="hidden" value="0"/>
                                <input name="txtCodigo" id="txtCodigo" type="hidden" value="<?=$codigo?>"/>
                                <input name="diariaValorOld" id="diariaValorOld" type="hidden" value="<?=$valorDiariaPrevista?>"></input>                                    
                                <input name="diariaValorOldTotal" id="diariaValorOldTotal" type="hidden" value="<?=$valorTotalPrevisto?>"/>                                    
                                <input name="txtComprovada" id="txtComprovada" type="hidden" value="<?=$comprovada?>"/>                                    
                                <input name="txtDataSaidaSolicitada" id="txtDataSaidaSolicitada" type="hidden" value="<?=$dataSaidaPrevista?>"/>                                    
                                <input name="txtDiariaSt" id="txtDiariaSt" type="hidden" value="<?=$linhaDiaria['diaria_st']?>"/>  
                                <input type="hidden" id="hdBeneficiario" name="hdBeneficiario" value="<?=$linhaDiaria['diaria_beneficiario']?>"/>
                                <input type="hidden" id="hdNumeroDiaria" name="hdNumeroDiaria" value="<?=$linhaDiaria['diaria_numero']?>"/>
                                <input type="hidden" id="txtAlterouRoteiro" name="txtAlterouRoteiro" value="<?=$_GET['alterarRoteiro']?>"/>
                                <input name="alterarRoteiro" id="alterarRoteiro" type="hidden" value="<?=$alterarRoteiro?>"/>
                                <input name="diariaDevolvida" id="diariaDevolvida" type="hidden" value="<?=$linhaDiaria['diaria_devolvida']?>"/>
                                <input name="reCalcular" id="reCalcular" type="hidden" value="0"/>
                                <input name="txtNovaSaida" id="txtNovaSaida" type="hidden" value=""/>
                                <input name="txtNovaChegada" id="txtNovaChegada" type="hidden" value=""/>
                                <input name="txtDataAtual" id="txtDataAtual" type="hidden" value="<?= $atual ?>"/>
                                <input name="txtExisteCampoComplemento" id="txtExisteCampoComplemento" type="hidden" value=""/>
                                <input name="txtValorCampoComplemento" id="txtValorCampoComplemento" type="hidden" value=""/>
                        <?php   If (substr($qtdeTotal, 2) == ".6") 
                                {?><!--
                                    <script>
                                        document.getElementById("ComplementoValor").style.display = '';
                                        document.Form.txtValorCampoComplemento.value = 1;
                                    </script>-->
                        <?php   }?>
                                <?php include "../Include/Inc_Linha.php" ?>
                                <table border="0" cellpadding="1" cellspacing="1" width="798">
                                    <tr>
                                        <td height="21" align="right">
                                            <input type="button" style="width:70px" onclick="Javascript:GravarFormComprovacao(document.Form);" name="btnGravar" class="botao" value="Gravar"/>
                                            <input type="button" style="width:70px" onclick="Javascript:window.location.href='SolicitacaoInicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>
            <div id="data" style="display:none"></div>
        </form>
    </body>
</html>