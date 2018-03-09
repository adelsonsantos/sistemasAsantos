<?php
include "Classe/ClasseDiaria.php";

$sql_        = "SELECT tipo_usuario_id 
                FROM seguranca.usuario_tipo_usuario
                WHERE pessoa_id = ".$_SESSION['UsuarioCodigo'];
$Consulta    = pg_query(abreConexao(), $sql_);
$tupla       = pg_fetch_assoc($Consulta);
$tipoUsuario = $tupla['tipo_usuario_id'];

if ($tipoUsuario == 4) 
{
    header("Location: Login.php?erro=1");
}

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

if ($Beneficiario == "") 
{
    $Beneficiario = $_SESSION['UsuarioCodigo'];
}

if(($linhaDiaria['id_coordenadoria'] == '')||($linhaDiaria['id_coordenadoria'] == 0))
{
    $idCoordenadoria = $_SESSION['UsuarioCoordenadoria'];
}
else
{
    $idCoordenadoria = $linhaDiaria['id_coordenadoria'];
}
// Testa se é uma nova solicitação ou edição.
// Caso seja nova solicitação, é zerado qualquer data retornada para evitar erros de calculo de valores.
// Caso seja edição, os valores são mantidos
if (($PaginaLocal == "Solicitacao" && $diaria_devolvida != "1") && $acaoSistema != "consultar") 
{
    if ($DataPartida != "") 
    {
        $DataPartida = "";
        $DataChegada = "";
    }        
    if (($HoraChegada != "" || $HoraPartida != "") && $acaoSistema != "consultar") 
    {
        $HoraChegada = "";
        $HoraPartida = "";
    }
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
        <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE8'></meta>
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery.maskedinput-1.2.2.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/mascaras.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptAjax.js"></script>
        <script type="text/javascript" language="javascript" src="JavaScript/Diaria.js"></script>
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptDiariaCadastrar.js"></script>
    </head>
    
    <body onload="Foco(document.Form);WM_initializeToolbar();HabCoordenadoria();ChecaEtapa();VerificaRoteirosAdicionais();">
        <form id="Form" name="Form" method="post" action="">
            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td height="21"><?php include "../Include/Inc_Topo.php" ?></td>
                </tr>
                <tr>
                    <td height="21"><?php include "../Include/Inc_Aba.php" ?></td>
                </tr>
                <tr>
                    <td height="21">
                        <table align="left" width="990" cellspacing="0" cellpadding="1" border="0">
                            <tr>
                                <td height="21" width="190" valign="top" align="left" ><?php include "../Include/Inc_Menu.php" ?></td>
                                <td height="21" valign="top" align="left">
                                    <?php include "../Include/Inc_Titulo.php" ?>
                                    <?php include "../Include/Inc_Linha.php" ?>                                      
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr>
                                            <td height="21">
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
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
                                                                    <td background="../Imagens/bgaba_off.gif" align="center" width="160"><a class="linktab" href="#" onclick="mostra_obj_id(aba1_on); esconde_obj_id(aba1_off); mostra_obj_id(formaba1);
                                                                        mostra_obj_id(aba2_off); esconde_obj_id(aba2_on); esconde_obj_id(formaba2);
                                                                        //mostra_obj_id(aba3_off); esconde_obj_id(aba3_on); esconde_obj_id(formaba3);">Di&aacute;ria</a></td>
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
                                                                    <td background="../Imagens/bgaba_off.gif" align="center" width="160"><a class="linktab" href="#" onClick="esconde_obj_id(aba1_on); mostra_obj_id(aba1_off); esconde_obj_id(formaba1);
                                                                        //esconde_obj_id(aba3_on); mostra_obj_id(aba3_off); esconde_obj_id(formaba3);
                                                                        esconde_obj_id(aba2_off); mostra_obj_id(aba2_on); mostra_obj_id(formaba2);">Projeto</a></td>
                                                                    <td width="7" align="right" background="../Imagens/bgaba_off.gif"><img src="../Imagens/aba_dir_off.gif" width="7" height="18" alt="" /></td>
                                                                </tr>
                                                            </table>
                                                        </td>
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
                                    <!--DIV DA ABA DIARIAS-->
                                    <div id="formaba1" style="display:block">
                                        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                            <tr>									
                                                <td>
                                                    <table width="800" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataLabel">                                                        
                                                            <td height="21">&nbsp;Local da Solicita&ccedil;&atilde;o:</td>									
                                                            <td height="21">													
                                                                <input type="radio" class="radio" id="radioCapital" name="radioCoordenadoria" value="Sede" <?=$checkCaptal?> onclick="HabCoordenadoria()" />Sede&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" class="radio" id="radioInterior" name="radioCoordenadoria" value="Coordenadoria" <?=$checkInterior?> onclick="HabCoordenadoria()" />Coordenadoria&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <div id="campoCordenadoria" style="display:none">
                                                                    <?= f_ComboCordenadoriasInterior('comboCordenadoriaInterior', '150', $idCoordenadoria) ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="dataLabel">
                                                            <td height="21" width="50%">&nbsp;Solicitante</td>
                                                            <td height="21" width="50%">&nbsp;Benefici&aacute;rio</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21">&nbsp;<?=$_SESSION['UsuarioNome']?></td>
                                                            <td height="21">&nbsp;<?= ComboBeneficiario($linhaDiaria['diaria_beneficiario'], "onChange=Javascript:ConsultaValorRef('','');PedeNovoCalculo('');") ?>&nbsp;*</td>
                                                        </tr>
                                                    </table>  
                                                </td>                                                    
                                            </tr>
                                        </table>
                                        <?php include "../Include/Inc_Linha.php" ?>    
                                        <div id="roteiroAdicional">                                            
                                            <div id="mostrar0" onclick="Javascript:ExpandirRoteiro(0)" style="display: none">
                                                <table cellpadding="0" cellspacing="1" class="TabelaFormulario" border="0" width="100%">
                                                    <tr class="dataTitulo">
                                                        <td height="21" width="50%">&nbsp;1º Roteiro <span id="roteiroExMsg0"></span><input id="roteiroExcluido0" name="roteiroExcluido0" type="hidden"></input><input type='hidden' id='qtdeRoteiros' name='qtdeRoteiros' value=''/></td>
                                                        <td height="21" width="50%" align="right"><big>+</big> /-</td>
                                                    </tr> 
                                                </table>
                                            </div>
                                            <div id="roteiroAdicional0">
                                                <input type="hidden" name="txtAlterouCalculo" id="txtAlterouCalculo" value="<?=$alterouCalculo?>"/>
                                                <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                                    <tr>                                                 
                                                        <td>                                                                                                                     
                                                            <table cellpadding="0" cellspacing="1" border="0" width="100%">
                                                                <tr class="dataTitulo">
                                                                    <td height="21" width="50%">&nbsp;Roteiro</td>
                                                                    <td height="21" width="50%" align="right"><span id="minimizarRoteiro0" onclick="Javascript:EsconderRoteiro(0)" style="display: none"><big>-</big>  /+</span></td>
                                                                </tr>                                                            
                                                                <tr class="dataLabel">                                                                    
                                                                    <td height="21" width="50%">&nbsp;Origem</td>
                                                                    <td height="21" width="50%">&nbsp;Destino</td>
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
                                                                                        <table cellpadding="0" cellspacing="1" border="0" width="400">
                                                                                            <tr class="dataField">
                                                                                                <td height="21" width="50">&nbsp;<?= f_ComboEstado("cmbRoteiroOrigemUF","onChange='Javascript:MudaComboCidadeOrigem(\"\",\"\");'" , "") ?></td>
                                                                                                <td height="21" ><span id="RoteiroOrigem"><?= f_ComboMunicipio("cmbRoteiroOrigemMunicipio", "", "") ?></span></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                    <td height="21" class="dataField">
                                                                                        <table cellpadding="0" cellspacing="1" border="0" width="400">
                                                                                            <tr class="dataField">
                                                                                                <td height="21" width="50">&nbsp;<?= f_ComboEstado("cmbRoteiroDestinoUF", "onChange='Javascript:MudaComboCidadeDestino(\"\",\"\");'", "") ?></td>
                                                                                                <td height="21">
                                                                                                    <span id="RoteiroDestino"><?= f_ComboMunicipio("cmbRoteiroDestinoMunicipio", "", "") ?></span>
                                                                                                </td>
                                                                                                <td height="21">
                                                                                                    <input type="button" name="btnAdicionar" id="btnAdicionar" style="width:65px; height:18px;" value="Adicionar" onclick="Javascript:AdicionarDadosRoteiro('');" /> &nbsp;
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
                                                                                else
                                                                                {
                                                                                    $and = ' AND controle_roteiro = 0 ';
                                                                                }
                                                                                $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = " . $codigo." ".$and;
                                                                                $rsRoteiro = pg_query(abreConexao(), $sqlRoteiro);

                                                                                $j = 0;

                                                                                while ($linha = pg_fetch_assoc($rsRoteiro))
                                                                                {
                                                                                    $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linha['roteiro_origem'];
                                                                                    $rsRoteiroOrigem  = pg_query(abreConexao(), $sqlRoteiroOrigem);
                                                                                    $linhaOrigem      = pg_fetch_assoc($rsRoteiroOrigem);

                                                                                    $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linha['roteiro_destino'];
                                                                                    $rsRoteiroDestino  = pg_query(abreConexao(), $sqlRoteiroDestino);
                                                                                    $linhaDestino      = pg_fetch_assoc($rsRoteiroDestino);

                                                                                    echo "<tr class='dataField' id='roteiroCadastrado'>";
                                                                                        echo "<td height='21'>&nbsp;" . $linhaOrigem['estado_uf'] . " - " . $linhaOrigem['municipio_ds'] . "</td>";
                                                                                        echo "<td height='21'>&nbsp;" . $linhaDestino['estado_uf'] . " - " . $linhaDestino['municipio_ds'] . "</td>";
                                                                                    echo "</tr>";

                                                                                    if ($j == 0) {
                                                                                        //verifica se o municipio eh da bahia
                                                                                        $sqlConsultaUF = "SELECT estado_uf FROM dados_unico.municipio WHERE municipio_cd = " . $linhaDestino['municipio_cd'];
                                                                                        $rsConsultaUF  = pg_query(abreConexao(), $sqlConsultaUF);
                                                                                        $linhaUF       = pg_fetch_assoc($rsConsultaUF);

                                                                                        if (mb_strtoupper($linhaUF['estado_uf']) != "BA")
                                                                                        {
                                                                                            //verifica o percentual do municipio para calculo
                                                                                            $sqlConsultaCidade = "SELECT percentual_ds FROM diaria.percentual_capital pc, diaria.percentual p WHERE (pc.percentual_id = p.percentual_id) AND municipio_cd = " . $linhaDestino['municipio_cd'];
                                                                                            $rsConsultaCidade  = pg_query(abreConexao(), $sqlConsultaCidade);
                                                                                            $linhaCidade       = pg_fetch_assoc($rsConsultaCidade);

                                                                                            if ($linhaCidade)
                                                                                            {
                                                                                                $Percentual = $linhaCidade['percentual_ds'];
                                                                                            }
                                                                                            else 
                                                                                            {
                                                                                                $sql3       = "SELECT percentual_ds FROM diaria.percentual WHERE percentual_id = 2";
                                                                                                $rs3        = pg_query(abreConexao(), $sql3);
                                                                                                $linhars3   = pg_fetch_assoc($rs3);                                                                           
                                                                                                $Percentual = $linhars3['percentual_ds']; //recebe valor padrao de calculo
                                                                                            }
                                                                                        } //Alterar por Rodolfo . 03-09-2008
                                                                                        else 
                                                                                        {
                                                                                            if (mb_strtoupper($linhaDestino['municipio_ds']) == "SALVADOR") 
                                                                                            {
                                                                                                //verifica o percentual do municipio para calculo
                                                                                                $sqlConsultaCidade = "SELECT percentual_ds FROM diaria.percentual_capital pc, diaria.percentual p WHERE (pc.percentual_id = p.percentual_id) AND municipio_cd = " . $linhaOrigem['municipio_cd'];
                                                                                                $rsConsultaCidade  = pg_query(abreConexao(), $sqlConsultaCidade);                                                                            
                                                                                                $linhaCidade       = pg_fetch_assoc($rsConsultaCidade);

                                                                                                if ($linhaCidade) 
                                                                                                {
                                                                                                    $Percentual = $linhaCidade['percentual_ds'];
                                                                                                } 
                                                                                                else 
                                                                                                {
                                                                                                    $sql3       = "SELECT percentual_ds FROM diaria.percentual WHERE percentual_id = 3";
                                                                                                    $rs3        = pg_query(abreConexao(), $sql3);                                                                                
                                                                                                    $linhars3   = pg_fetch_assoc($rs3);
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
                                                                                    echo "<td height='21' colspan=2 align=right><input type=button style=width:85px; value='Alterar Roteiro' onClick=AlterarRoteiro('');>&nbsp;<input type=hidden name='txtPercentual' id='txtPercentual' value= '".$Percentual."' /></td>";
                                                                                echo "</tr>";
                                                                            }
                                                                            ?> 
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>                                                              
                                                            <div id="RoteiroAdicionado"></div>
                                                            <table width="800" border="0" cellpadding="0" cellspacing="1">
                                                                <tr>
                                                                    <td height="21" colspan="8" class="dataLabel">&nbsp;Complemento do Roteiro</td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="21" colspan="8" class="dataField">&nbsp;<input type="text" name="txtRoteiroComplemento" id="txtRoteiroComplemento" style="width:750px;" maxlength="120" value="<?=$linhaDiaria['diaria_roteiro_complemento'];?>"/></td>
                                                                </tr>
                                                                <tr class="dataTitulo">
                                                                    <td height="21" width="399" colspan="4">&nbsp;Partida Prevista</td>
                                                                    <td height="21" width="399" colspan="4">&nbsp;Chegada Prevista</td>
                                                                </tr>
                                                                <tr class="dataLabel">
                                                                    <td height="21" width="100" colspan="2">&nbsp;Data</td>
                                                                    <td height="21" width="100">&nbsp;Hora</td>
                                                                    <td height="21" width="199">&nbsp;Dia da Semana</td>
                                                                    <td height="21" width="100" colspan="2">&nbsp;Data</td>
                                                                    <td height="21" width="100">&nbsp;Hora</td>
                                                                    <td height="21" width="199">&nbsp;Dia da Semana</td>
                                                                </tr>
                                                                <tr class="dataField">
                                                                    <td height="21" width="80"><input id="dataPartida" type="text" name="txtDataPartida" maxlength="10" style=" width:75px;height:15px;"  value="<?=$linhaDiaria['diaria_dt_saida']?>" onchange="computeControle(this,1,'');PedeNovoCalculo('');"/></td>
                                                                    <td height="21" width="20"><a href="#" onclick="javascript:displayCalendar(document.getElementById('dataPartida'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18" /></a></td>
                                                                    <td height="21" width="100"><input id="horaPartida" type="text" name="txtHoraPartida" maxlength="5" style=" width:75px;height:15px;" onkeyup="mascaraHora(this.value, document.Form.txtHoraPartida);PedeNovoCalculo('');" onkeypress="mascaraNumero(event, this);" value="<?=$linhaDiaria['diaria_hr_saida']?>" onchange="PedeNovoCalculo('');"/></td>
                                                                    <td height="21" width="199"><input id="diaPartida" type="text" name="txtPartidaSemana" class="Oculto" value="<?= $diaSemanaPartida?>"/></td>
                                                                    <td height="21" width="80"><input id="dataChegada" type="text" name="txtDataChegada" maxlength="10" style="width:75px;height:15px;"  value="<?=$linhaDiaria['diaria_dt_chegada']?>" onchange="computeControle(this,2,'');PedeNovoCalculo('')"/></td>
                                                                    <td height="21" width="20"><a href="#" onclick="javascript:displayCalendar(document.getElementById('dataChegada'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18"/></a></td>
                                                                    <td height="21" width="100">&nbsp;<input id="horaChegada" type="text" name="txtHoraChegada" maxlength="5" style=" width:75px;height:15px;" onkeyup="mascaraHora(this.value, document.Form.txtHoraChegada);PedeNovoCalculo('');" onkeypress="mascaraNumero(event, this);" value="<?=$linhaDiaria['diaria_hr_chegada']?>" onchange="PedeNovoCalculo('');"/></td>
                                                                    <td height="21" width="199">&nbsp;<input id="diaChegada" type="text" name="txtChegadaSemana" class="Oculto" value="<?= $diaSemanaChegada?>" /></td>
                                                                </tr>
                                                            </table>
                                                            <table width="100%" border="0" cellpadding="0" cellspacing="1">										
                                                                <tr class="dataLabel">
                                                                    <td height="21" width="100">&nbsp;Redu&ccedil;&atilde;o 50%</td>
                                                                    <td height="21" width="181">&nbsp;Valor Refer&ecirc;ncia (Descri&ccedil;&atilde;o)</td>
                                                                    <td height="21" width="116">&nbsp;Valor do Roteiro</td>
                                                                    <td height="21" width="104">&nbsp;Qtde Di&aacute;rias</td>
                                                                    <td height="21" width="110">&nbsp;Valor Total</td>
                                                                    <td height="21" width="189" colspan="3">&nbsp;</td>
                                                                </tr>											
                                                                <tr class="dataField">
                                                                    <?php
                                                                    //var_dump($linhaDiaria['diaria_numero']);
                                                                    if ($linhaDiaria['diaria_beneficiario'] != "") 
                                                                    {
                                                                        echo "<script type='text/javascript' language='javascript'>";                                                          
                                                                            echo "ConsultaValorRef(".$linhaDiaria['diaria_beneficiario'].",'".$linhaDiaria['diaria_dt_saida']."');";
                                                                        echo "</script>";
                                                                    }
                                                                    $percentualImprimir = (str_replace(",", ".", $Percentual) * 100);
                                                                    ?>
                                                                    <td height="21" width="100">&nbsp;<input type="checkbox" name="chkDesconto" id="chkDesconto" class="checkbox" <?=$descontoMarcado?>  onchange="PedeNovoCalculo('');"/>&nbsp;Sim</td>
                                                                    <td height="21" width="181" valign="middle">
                                                                        <div id="ValorRef">
                                                                            <input type="hidden" name="txtValorReferencia" id="txtValorReferencia" value="<?=$linhaDiaria['diaria_valor_ref']?>" style="width:75px; height:18px;" ></input>
                                                                        </div>
                                                                    </td>
                                                                    <td height="21" width="330" colspan="3" valign="middle">
                                                                        <div id="QtdeDiariaAlterar" style='display:none'> 
                                                                            <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                                                                <tr class="dataField">
                                                                                    <td height="21" width="116">&nbsp;<?= '+'.$percentualImprimir.'%  R$ '.number_format($linhaDiaria['diaria_valor_ref'], 2, ',', '.')?></td>
                                                                                    <td height="21" width="104"><input disabled="disabled" type="text" id="qtdeDiaria" name="qtdeDiaria" value="<?=$linhaDiaria['diaria_qtde']?>" style='width:70px;'/><input id="hdQtdeDiaria" name="hdQtdeDiaria" type="hidden" value="<?=$linhaDiaria['diaria_qtde']?>" /></td>
                                                                                    <td height="21" width="110"><input disabled="disabled" type="text" id="valorDiaria" name="valorDiaria" value="<?='R$ '.number_format($linhaDiaria['diaria_valor'], 2, ',', '.')?>" style='width:70px;'/><input id="hdValorDiaria" name="hdValorDiaria" type="hidden" value="<?=$linhaDiaria['diaria_valor']?>"/></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <div id="QtdeDiaria" style="display:none">&nbsp;</div>
                                                                    </td>
                                                                    <td height="21" width="139"><input id="calcular" type="button" name="btnCalcular" style="width:125px;height:18px;" value="Calcular Di&aacute;ria" onclick="CalcularDiaria($('#dataPartida').val(), $('#dataChegada').val(), $('#horaPartida').val(), $('#horaChegada').val(), $('#cmbBeneficiario').val(), $('#chkDesconto').is(':checked'), $('#txtDataAtual').val(), '');"/></td>
                                                                    <?php
                                                                    if(($codigo != '')&&($controleRoteiro == 0))
                                                                    {?>
                                                                        <td height="21"></td>
                                                                        <td height="21"></td>
                                                                    <?php
                                                                    }
                                                                    else
                                                                    {?>
                                                                        <td height="21" width="25" align="right"><span id="btnRemover0" style="display: none;"><a onclick="RemoverRoteiro('');"><img alt="" src="../Icones/ico_excluir.png" width="18" title="Remover roteiro."/></a></span></td>
                                                                        <td height="21" width="25" align="right"><span id="btnAdicionarRoteiro"><a onclick="RoteiroAdicional('');"><img alt="" src="../Icones/ico_adicionar2.png" width="18" title="Adicionar novo roteiro."/></a></span></td>
                                                                    <?php
                                                                    }?>                                                                    
                                                                </tr>
                                                            </table>                                                    
                                                        </td>
                                                    </tr>
                                                </table>
                                                <input type="hidden" id="calculo" name="Calculo" value="<?=$diariaCalculada?>" />
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
                                        <div id="tableBloqueio"> </div>
                                        <div id="calculoRoteiroAdicional" style="display: none;">
                                            <table width="800" border="0" cellpadding="0" cellspacing="1">
                                                <tr>
                                                    <td align="right">
                                                        <input type="button" id="calcularRoteiro" name="btnCalcularRoteiro" style="width:140px;height:18px;" value="Calcular Total de Diárias" onclick="CalcularTotalDiarias();"/>
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
                                                echo"<div id='resultCalculoTotal'>
                                                        <table width='800' border='0' cellpadding='0' cellspacing='0' class='TabelaFormulario'>
                                                            <tr class='dataLabel'>
                                                                <td height='21'>Quantidade total de diárias: <input type='text' id='qtdeTotal' name='qtdeTotal' value='".$linhaDiaria['qtde_total']."' disabled='disabled'/></td>
                                                                <td height='21'>Valor Total: <input type='text' id='totalDiarias' name='totalDiarias' value='".$linhaDiaria['valor_total']."' disabled='disabled'/></td>
                                                            </tr>
                                                        </table>                                                
                                                    </div>";
                                            }
                                        }
                                        else
                                        {
                                            echo"<div id='resultCalculoTotal' style='display: none;'>
                                                    <table width='800' border='0' cellpadding='0' cellspacing='0' class='TabelaFormulario'>
                                                        <tr class='dataLabel'>
                                                            <td height='21'>Quantidade total de diárias: <input type='text' id='qtdeTotal' name='qtdeTotal' value='' disabled='disabled'/></td>
                                                            <td height='21'>Valor Total: <input type='text' id='totalDiarias' name='totalDiarias' value='' disabled='disabled'/></td>
                                                        </tr>
                                                    </table>                                                
                                                </div>";
                                        }                                        
                                        include "../Include/Inc_Linha.php"; 
                                        ?>                                         
                                        <table width="800" border="0" cellpadding="0" cellspacing="1" class="TabelaFormulario">
                                            <tr>
                                                <td height="21">
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataLabel">
                                                            <td height="21">
                                                                <table width="100%" cellpadding="0" cellspacing="1" border="0">
                                                                    <tr>
                                                                        <td height="21" width="50%" class="dataLabel">&nbsp;Justificativa do Final de Semana</td>
                                                                        <td height="21" width="50%" class="dataLabelSemBold" align="right">M&aacute;ximo permitido 255 caracteres&nbsp;<input type="text" id="QtdFimSemana" name="QtdFimSemana" style=" width:35px;" class="Oculto"/>&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21">&nbsp;<textarea name="txtJustificativaFimSemana" id="txtJustificativaFimSemana" style=" width:789px; height:45px" maxlenght="255" onKeyUp="ContarJustificativaFimSemana(this,255)"><?=$linhaDiaria['diaria_justificativa_fds']?></textarea></td>
                                                        </tr>
                                                    </table>
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataLabel">
                                                            <td height="21">
                                                                <table width="100%" cellpadding="0" cellspacing="1" border="0">
                                                                    <tr>
                                                                        <td height="21" width="50%" class="dataLabel">&nbsp;Justificativa do Feriado</td>
                                                                        <td height="21" width="50%" class="dataLabelSemBold" align="right">M&aacute;ximo permitido 255 caracteres&nbsp;<input type="text" id="QtdFeriado" name="QtdFeriado" style=" width:35px;"  class="Oculto"/>&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21">&nbsp;<textarea name="txtJustificativaFeriado" id="txtJustificativaFeriado" style=" width:789px; height:45px" maxlenght="255" onKeyUp="ContarJustificativaFeriado(this,255)"><?= $linhaDiaria['diaria_justificativa_feriado'] ?></textarea></td>
                                                        </tr>
                                                    </table>                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!--DIV DA ABA PROJETO-->
                                    <div id="formaba2" style="display:none">
                                        <table width="800" border="0" cellpadding="0" cellspacing="1" class="TabelaFormulario">
                                            <tr>
                                                <td height="21">
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataLabel">
                                                            <td height="21" width="320">&nbsp;Meio de Transporte</td>
                                                            <td height="21" width="478">&nbsp;Observa&ccedil;&atilde;o</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21">&nbsp;<?= f_ComboMeioTransporte($linhaDiaria['meio_transporte_id']) ?></td>
                                                            <td height="21">&nbsp;<input name="txtMeioTransporteObservacao" id="txtMeioTransporteObservacao" maxlength="255" type="text" value="<?= $linhaDiaria['diaria_transporte_obs'] ?>" style=" width:465px;"/></td>
                                                        </tr>
                                                    </table>
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataLabel">
                                                            <td height="21"width="320">&nbsp;Motivo</td>
                                                            <td height="21"width="478">&nbsp;Sub-Motivo</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21">&nbsp;<?= ComboMotivoDiaria($linhaDiaria['motivo_id'], 3, "") ?></td>
                                                            <td height="21">&nbsp;<?= ComboSubMotivoDiaria($linhaDiaria['sub_motivo_id']) ?></td>
                                                        </tr>
                                                    </table>
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataLabel">
                                                            <td height="21">
                                                                <table width="100%" cellpadding="0" cellspacing="1" border="0">
                                                                    <tr>
                                                                        <td height="21" width="50%" class="dataLabel">&nbsp;Detalhe do Motivo</td>
                                                                        <td height="21" width="50%" class="dataLabelSemBold" align="right">M&aacute;ximo permitido 600 caracteres&nbsp;<input type="text" id="QtdDescricao" name="QtdDescricao" style=" width:35px;" readonly class="Oculto"/>&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21">&nbsp;<textarea name="txtDescricao" id="txtDescricao" style=" width:789px; height:45px" maxlenght="600" onKeyUp="ContarDescricao(this,600)"><?= $linhaDiaria['diaria_descricao']?></textarea></td>
                                                        </tr>
                                                    </table>
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                                        <tr class="dataLabel">
                                                            <td height="21">&nbsp;Unidade de Custo</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21">&nbsp;<?= ComboACP($linhaDiaria['diaria_unidade_custo'], "onChange=MandaID(this.value,'AjaxProjeto')") ?></td>
                                                        </tr>
                                                        <tr class="dataLabel">
                                                            <td height="21" >&nbsp;Projeto</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21"><div id="Projeto">&nbsp<?= f_ComboProjeto($linhaDiaria['projeto_cd'], "onChange=MandaID(this.value,'AjaxAcao','projeto_cd')") ?></div></td>
                                                        </tr>
                                                        <tr class="dataLabel">
                                                            <td height="21">&nbsp;Produto</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <?php if ($linhaDiaria['acao_cd'] != "") { ?>
                                                                <td height="21">
                                                                    <div id="Acao">&nbsp;
                                                                        <?= f_ComboAcao($linhaDiaria['acao_cd'], $linhaDiaria['projeto_cd'], "onchange=MandaID(this.value,'AjaxTerritorio','acao_cd')") ?>
                                                                    </div>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td height="21"><div id="Acao">&nbsp;<?= f_ComboAcao('', '', "disabled") ?></div></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr class="dataLabel">
                                                            <td height="21">&nbsp;Territ&oacute;rio</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <?php if ($linhaDiaria['territorio_cd'] != "")
                                                                { ?>
                                                                <td height="21">
                                                                    <div id="Territorio">&nbsp;
                                                                        <?= f_ComboTerritorio($linhaDiaria['acao_cd'], $linhaDiaria['territorio_cd'], "onchange=MandaID(this.value,'AjaxFonte','territorio_cd')", "785") ?>
                                                                    </div>
                                                                </td>
                                                            <?php } 
                                                                else 
                                                                  { ?>
                                                                <td height="21"><div id="Territorio">&nbsp;<?= f_ComboTerritorio('', '', "disabled", "785") ?></div></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr class="dataLabel">
                                                            <td height="21">&nbsp;Fonte</td>
                                                        </tr>
                                                        <tr class="dataField">
                                                            <td height="21">
                                                                <div id="Fonte">
                                                                    &nbsp;<?= f_ComboFonte($linhaDiaria['fonte_cd'], "784",'onchange="VerificaSaldo()"') ?>
                                                                </div>
                                                            </td>
                                                        </tr>                                                          
                                                        <tr class='dataLabel'>
                                                            <td height='21'><span id="desEtapa" style="display:none">&nbsp;Etapa</span></td>
                                                        </tr>
                                                        <tr class='dataField'>
                                                            <td height='21'>&nbsp;  
                                                                <span id="spEtapa" style="display:none"><?=f_ComboEtapas('cmbEtapa','783', $linhaDiaria['etapa_id'],'onchange="VerificaSaldoEtapa()"','114',$linhaDiaria['projeto_cd'],$linhaDiaria['fonte_cd']);?></span>
                                                            </td>
                                                        </tr>                                                        
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>    
                                    <span id="saldoResultado"></span>
                                    <?php
                                    $Atual = (date("d/m/Y"));
                                    ?>
                                    <input name="roteirosExcluidos" id="roteirosExcluidos" type="hidden" value="0"/>
                                    <input name="alterarTotalDiarias" id="alterarTotalDiarias" type="hidden" value="0"/>                                    
                                    <input name="valorTotalDiarias" id="valorTotalDiarias" type="hidden" value="0"/>                                    
                                    <input name="NovoValorTotalDiarias" id="NovoValorTotalDiarias" type="hidden" value="0"/>                                    
                                    <input name="txtCodigo" id="txtCodigo" type="hidden" value="<?=$codigo?>"/>
                                    <input name="txtStatus" id="txtStatus" type="hidden" value="<?=$linhaDiaria['diaria_st']?>"/>
                                    <input name="txtNumero" id="txtNumero" type="hidden" value="<?=$linhaDiaria['diaria_numero']?>"/>
                                    <input name="txtValor" id="txtValor" type="hidden" value="<?=$linhaDiaria['diaria_valor']?>"/>                                    
                                    <input name="txtFonte" id="txtFonte" type="hidden" value="<?=$linhaDiaria['fonte_cd']?>"/>                                    
                                    <input name="txtProjeto" id="txtProjeto" type="hidden" value="<?=$linhaDiaria['projeto_cd']?>"/>                                    
                                    <input name="txtEtapa" id="txtEtapa" type="hidden" value="<?=$linhaDiaria['etapa_id']?>"/>                                    
                                    <input name="dtDiariaAnt" id="dtDiariaAnt" type="hidden" value="<?=$linhaDiaria['diaria_dt_saida']?>"/>                                    
                                    <input name="txtHoraCriacao" id="txtHoraCriacao" type="hidden" value="<?=$linhaDiaria['diaria_hr_criacao']?>"/>
                                    <input name="txtValorRefAnt" id="txtValorRefAnt" type="hidden" value="<?=$linhaDiaria['diaria_valor_ref']?>"/>                                    
                                    <input name="txtNovaSaida" id="txtNovaSaida" type="hidden" value=""/>
                                    <input name="txtNovaChegada" id="txtNovaChegada" type="hidden" value=""/>
                                    <input name="txtDataAtual" id="txtDataAtual" type="hidden" value="<?=$Atual?>"/>
                                    <input name="reCalcular" id="reCalcular" type="hidden" value="0" /> 
                                    <input name="alterarRoteiro" id="alterarRoteiro" type="hidden" value="<?=$alterarRoteiro?>"/>
                                    <input name="txthorasAcesso" id="txthorasAcesso" type="hidden" value="<?=$HoraAcesso?>"/>
                                    <input name="txtBeneficiarioTemp" id="txtBeneficiarioTemp" type="hidden" value="<?=$linhaDiaria['diaria_beneficiario']?>"/>                                    
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <?php                                    
                                    if($MensagemErroBD != "") 
                                    {
                                        echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
                                            echo "<tr class='MensagemErro'>";
                                                echo "<td height='21'>" . $MensagemErroBD . "</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                                echo "<td height='21'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>";
                                            echo "</tr>";
                                        echo "</table>";
                                    }
                                    ?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td height="21" align="right">
                                                <input type="button" style="width:70px" onClick="Javascript:GravarFormDiaria(document.Form);" name="btnGravar" id="btnGravar" class="botao" value="Gravar"/>&nbsp;&nbsp;&nbsp;
                                                <input type="button" style="width:70px" onClick="JavaScript:window.location.href='<?=$PaginaLocal?>Inicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
                                            </td>
                                        </tr>
                                    </table>
                                    <input type="hidden" id="pagina" value="<?=$PaginaLocal?>" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
