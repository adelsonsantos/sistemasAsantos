<?php
include "../../Include/Inc_Configuracao.php";

$cont           = $_POST['controle'];
$alterarRoteiro = $_POST['alterarRoteiro'.$cont];
$valorRef       = $_POST['valorRef'];
$roteiro        = $cont + 1;

if(strlen($_POST['txtValorRef']) > 5)
{
    $txtValorRef = substr($_POST['txtValorRef'], 0, 3);
}
else
{
    $txtValorRef = substr($_POST['txtValorRef'], 0, 2);
}

if($_POST['codigo'] != '')
{
    $codigo = $_POST['codigo'];
    
    $sqlContultaDadosRoteiro = "SELECT * FROM diaria.dados_roteiro_multiplo
                                WHERE diaria_id = ".$codigo."
                                  AND dados_roteiro_status = 0  
                                  AND controle_roteiro = ".$cont;
    
    $rsContultaDadosRoteiro  = pg_query(abreConexao(),$sqlContultaDadosRoteiro);
    $linhaMultiploRoteiro    = pg_fetch_assoc($rsContultaDadosRoteiro);
    
    $dtSaida           = $linhaMultiploRoteiro['diaria_dt_saida'];
    $hrSaida           = $linhaMultiploRoteiro['diaria_hr_saida'];    
    $dtChegada         = $linhaMultiploRoteiro['diaria_dt_chegada'];
    $hrChegada         = $linhaMultiploRoteiro['diaria_hr_chegada'];    
    $qtdDiarias        = $linhaMultiploRoteiro['diaria_qtde'];
    $valorDiaria       = $linhaMultiploRoteiro['diaria_valor'];    
    $diariaComplemento = $linhaMultiploRoteiro['diaria_roteiro_complemento'];       
    
    If(($linhaMultiploRoteiro['diaria_desconto'] == "N")||($linhaMultiploRoteiro['diaria_desconto'] == '')) 
    {
        $descontoMarcado = "";
    } 
    Else 
    {        
        $descontoMarcado = "checked";
    }
    $diaSemanaSaida    = diasemana($dtSaida);
    $diaSemanaChegada  = diasemana($dtChegada);
}

$resultado = "  <input type='hidden' name='txtAlterouCalculo$cont' id='txtAlterouCalculo$cont' value=''/>
                <table cellpadding='0' cellspacing='1' class='TabelaFormulario' border='0' width='100%'>
                    <tr class='dataTitulo'>
                        <td height='21' width='50%'>&nbsp;".$roteiro."º Roteiro  <span id='roteiroExMsg$cont'></span><input id='roteiroExcluido$cont' name='roteiroExcluido$cont' type='hidden'></input><input type='hidden' id='qtdeRoteiros$cont' name='qtdeRoteiros$cont' value='$roteiro'/></td>
                        <td height='21' width='50%' align='right'><big>+</big> /-</td>
                    </tr> 
                </table>¬                          
                <table width='800' border='0' cellpadding='0' cellspacing='0' class='TabelaFormulario'>
                    <tr>                                                 
                        <td>
                            <table cellpadding='0' cellspacing='1' border='0' width='100%'>
                                <tr class='dataTitulo'>
                                    <td height='21' >&nbsp;Roteiro</td>
                                    <td height='21' align='right'><span id='minimizarRoteiro$cont' onclick='Javascript:EsconderRoteiro($cont)' style='display: none'><big>-</big> /+</span></td>
                                </tr>
                                <tr class='dataLabel'>
                                    <td height='21' width='50%'>&nbsp;Origem</td>
                                    <td height='21' width='50%'>&nbsp;Destino</td>
                                </tr>
                                <tr>
                                    <td colspan='2'>
                                        <div id='montarRoteiro$cont'>
                                            <table cellpadding='0' cellspacing='0' border='0' width='100%'>";  
        if ($alterarRoteiro == 1) 
        {     
            $resultado .= "<tr>
                                <td height='21'>
                                    <table cellpadding='0' cellspacing='1' border='0' width='400'>
                                        <tr class='dataField'>
                                            <td height='21' width='50'>&nbsp;".f_ComboEstado("cmbRoteiroOrigemUF".$cont,"onChange='Javascript:MudaComboCidadeOrigem(\"\",$cont);'" , "")."</td>
                                            <td height='21'><span id='RoteiroOrigem$cont'>".f_ComboMunicipio("cmbRoteiroOrigemMunicipio".$cont, "", "")."</span></td>
                                        </tr>
                                    </table>
                                </td>
                                <td height='21' class='dataField'>
                                    <table cellpadding='0' cellspacing='1' border='0' width='400'>
                                        <tr class='dataField'>
                                            <td height='21' width='50'>&nbsp;".f_ComboEstado("cmbRoteiroDestinoUF".$cont, "onChange='Javascript:MudaComboCidadeDestino(\"\",$cont);'", "")."</td>
                                            <td height='21'>
                                                <span id='RoteiroDestino$cont'>".f_ComboMunicipio("cmbRoteiroDestinoMunicipio".$cont, "", "")."</span>
                                            </td>
                                            <td height='21'>
                                                <input type='button' name='btnAdicionar' id='btnAdicionar' style='width:65px; height:18px;' value='Adicionar' onclick='Javascript:AdicionarDadosRoteiro($cont);' /> &nbsp;
                                                <input type='button' name='btnLimpar' id='btnLimpar' value='Limpar' style='width:65px; height:18px;' onclick='Javascript:LimparDadosRoteiro($cont);'/>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>";

        } 
        else 
        {
            $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$codigo." AND controle_roteiro = ".$cont;
            $rsRoteiro = pg_query(abreConexao(), $sqlRoteiro);

            $j = 0;

            while ($linha = pg_fetch_assoc($rsRoteiro))
            {
                $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linha['roteiro_origem'];
                $rsRoteiroOrigem  = pg_query(abreConexao(), $sqlRoteiroOrigem);
                $linhaOrigem      = pg_fetch_assoc($rsRoteiroOrigem);

                $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linha['roteiro_destino'];
                $rsRoteiroDestino  = pg_query(abreConexao(), $sqlRoteiroDestino);
                $linhaDestino      = pg_fetch_assoc($rsRoteiroDestino);

                $resultado .=  "<tr class='dataField' id='roteiroCadastrado$cont'>
                                    <td height='21'>&nbsp;".$linhaOrigem['estado_uf']." - ".$linhaOrigem['municipio_ds']."</td>
                                    <td height='21'>&nbsp;".$linhaDestino['estado_uf']." - ".$linhaDestino['municipio_ds']."</td>
                                </tr>";

                if ($j == 0) {
                    //verifica se o municipio eh da bahia
                    $sqlConsultaUF = "SELECT estado_uf FROM dados_unico.municipio WHERE municipio_cd = ".$linhaDestino['municipio_cd'];
                    $rsConsultaUF  = pg_query(abreConexao(), $sqlConsultaUF);
                    $linhaUF       = pg_fetch_assoc($rsConsultaUF);

                    if (mb_strtoupper($linhaUF['estado_uf']) != "BA")
                    {
                        //verifica o percentual do municipio para calculo
                        $sqlConsultaCidade = "SELECT percentual_ds FROM diaria.percentual_capital pc, diaria.percentual p WHERE (pc.percentual_id = p.percentual_id) AND municipio_cd = ".$linhaDestino['municipio_cd'];
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
                    }
                    else 
                    {
                        if (mb_strtoupper($linhaDestino['municipio_ds']) == "SALVADOR") 
                        {
                            //verifica o percentual do municipio para calculo
                            $sqlConsultaCidade = "SELECT percentual_ds FROM diaria.percentual_capital pc, diaria.percentual p WHERE (pc.percentual_id = p.percentual_id) AND municipio_cd = ".$linhaOrigem['municipio_cd'];
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
            $resultado .= " <tr class=dataField>
                                <td height='21' colspan='2' align='right'><input type='button' style='width:85px;' value='Alterar Roteiro' onClick='AlterarRoteiro($cont);'>&nbsp;<input type='hidden' name='txtPercentual' id='txtPercentual' value= '".$Percentual."' /></td>
                            </tr>";
        }

    $resultado .= "                 </table>
                                </div>
                            </td>
                        </tr>
                    </table>  
                    <div id='RoteiroAdicionado$cont'></div>
                    <table width='800' border='0' cellpadding='0' cellspacing='1'>
                        <tr>
                            <td height='21' colspan='8' class='dataLabel'>&nbsp;Complemento do Roteiro</td>
                        </tr>
                        <tr>
                            <td height='21' colspan='8' class='dataField'>&nbsp;<input type='text' name='txtRoteiroComplemento$cont' id='txtRoteiroComplemento$cont' style='width:750px;' maxlentgh='120' value='".$diariaComplemento."'/></td>
                        </tr>
                        <tr class='dataTitulo'>
                            <td height='21' width='399' colspan='4'>&nbsp;Partida Prevista</td>
                            <td height='21' width='399' colspan='4'>&nbsp;Chegada Prevista</td>
                        </tr>
                        <tr class='dataLabel'>
                            <td height='21' width='100' colspan='2'>&nbsp;Data</td>
                            <td height='21' width='100'>&nbsp;Hora</td>
                            <td height='21' width='199'>&nbsp;Dia da Semana</td>
                            <td height='21' width='100' colspan='2'>&nbsp;Data</td>
                            <td height='21' width='100'>&nbsp;Hora</td>
                            <td height='21' width='199'>&nbsp;Dia da Semana</td>
                        </tr>
                        <tr class='dataField'>
                            <td height='21' width='80'><input id='dataPartida$cont' type='text' name='txtDataPartida$cont' maxlength='10' style=' width:75px;height:15px;'  value='".$dtSaida."' onchange='computeControle(this,1,$cont);PedeNovoCalculo($cont);'/></td>
                            <td height='21' width='20'><a href='#' onclick=\"javascript:displayCalendar(document.getElementById('dataPartida$cont'),'dd/mm/yyyy',this);\"><img src='../Icones/ico_calendario.gif' border='0' align='Mostrar Calendário' width='18' /></a></td>
                            <td height='21' width='100'><input id='horaPartida$cont' type='text' name='txtHoraPartida$cont' maxlength='5' style=' width:75px;height:15px;' onkeyup='mascaraHora(this.value, document.Form.txtHoraPartida$cont);PedeNovoCalculo($cont);' onkeypress='mascaraNumero(event, this);' value='".$hrSaida."' onchange='PedeNovoCalculo($cont);'/></td>
                            <td height='21' width='199'><input id='diaPartida$cont' type='text' name='txtPartidaSemana$cont' class='Oculto' value='".$diaSemanaSaida."'/></td>
                            <td height='21' width='80'><input id='dataChegada$cont' type='text' name='txtDataChegada$cont' maxlength='10' style='width:75px;height:15px;'  value='".$dtChegada."' onchange='computeControle(this,2,$cont);PedeNovoCalculo($cont)'/></td>
                            <td height='21' width='20'><a href='#' onclick=\"javascript:displayCalendar(document.getElementById('dataChegada$cont'),'dd/mm/yyyy',this);\"><img src='../Icones/ico_calendario.gif' border='0' align='Mostrar Calendário' width='18'/></a></td>
                            <td height='21' width='100'>&nbsp;<input id='horaChegada$cont' type='text' name='txtHoraChegada$cont' maxlength='5' style=' width:75px;height:15px;' onkeyup='mascaraHora(this.value, document.Form.txtHoraChegada$cont);PedeNovoCalculo($cont);' onkeypress='mascaraNumero(event, this);' value='".$hrChegada."' onchange='PedeNovoCalculo($cont);'/></td>
                            <td height='21' width='199'>&nbsp;<input id='diaChegada$cont' type='text' name='txtChegadaSemana$cont' class='Oculto' value='".$diaSemanaChegada."' /></td>
                        </tr>
                    </table>
                    <table width='100%' border='0' cellpadding='0' cellspacing='1'>										
                        <tr class='dataLabel'>
                            <td height='21' width='100'>&nbsp;Redu&ccedil;&atilde;o 50%</td>
                            <td height='21' width='181'>&nbsp;Valor Refer&ecirc;ncia (Descri&ccedil;&atilde;o)</td>
                            <td height='21' width='116'>&nbsp;Valor do Roteiro</td>
                            <td height='21' width='104'>&nbsp;Qtde Di&aacute;rias</td>
                            <td height='21' width='110'>&nbsp;Valor Total</td>
                            <td height='21' width='189' colspan='3'>&nbsp;</td>
                        </tr>											
                        <tr class='dataField'>";             
    
                            $percentualImprimir = (str_replace(",", ".", $Percentual) * 100);

           $resultado .= "  <td height='21' width='100'>&nbsp;<input type='checkbox' name='chkDesconto$cont' id='chkDesconto$cont' class='checkbox' ".$descontoMarcado."  onChange='PedeNovoCalculo($cont);'/>&nbsp;Sim</td>
                            <td height='21' width='181' valign='middle'>".$_POST['valorRef']."</td>
                            <td height='21' width='330' colspan='3' valign='middle'>
                                <div id='QtdeDiariaAlterar$cont'> 
                                    <table width='330' border='0' cellpadding='0' cellspacing='1'>
                                        <tr class='dataField'>
                                            <td height='21' width='126'>+".$percentualImprimir.'%  R$ '.number_format($txtValorRef, 2, ',', '.')."</td>
                                            <td height='21' width='102'><input type='text' id='qtdeDiaria$cont' value='".$qtdDiarias."' style='width:70px;' disabled/><input type='hidden' id='hdQtdeDiaria$cont' name='hdQtdeDiaria$cont' value='$qtdDiarias'/></td>
                                            <td height='21' width='102'><input type='text' id='valorDiaria$cont' value='R$ ".number_format($valorDiaria, 2, ',', '.')."'  style=' width:70px;' disabled/><input type='hidden' id='hdValorDiaria$cont' name='hdValorDiaria$cont' value='$valorDiaria'/></td>
                                        </tr>
                                    </table>
                                </div>
                                <div id='QtdeDiaria$cont' style='display:none'>&nbsp;</div>
                            </td>
                            <td height='21' width='139'><input id='calcular$cont' type='button' name='btnCalcular$cont' style='width:125px;height:18px;' value='Calcular Di&aacute;ria' onClick=\"CalcularDiaria($('#dataPartida$cont').val(), $('#dataChegada$cont').val(), $('#horaPartida$cont').val(), $('#horaChegada$cont').val(), $('#cmbBeneficiario').val(), $('#chkDesconto$cont').is(':checked'), $('#txtDataAtual').val(), $cont);\"/></td>
                            <td height='21' width='25' align='right'><a onclick='RemoverRoteiro($cont);'><img alt='' src='../Icones/ico_excluir.png' width='18' title='Remover roteiro.'/></a></td>
                            <td height='21' width='25' align='right'><span id='btnAdicionarRoteiro$cont' name='btnAdicionarRoteiro$cont'><a onclick='RoteiroAdicional($cont);'><img src='../Icones/ico_adicionar2.png' border='0' align='Mostrar Calendário' width='18' title='Adicionar novo roteiro.'/></a></span></td>
                        </tr>
                    </table>
                    <input name='reCalcular$cont' id='reCalcular$cont' type='hidden' value='0' />
                    <input name='alterarRoteiro$cont' id='alterarRoteiro$cont' type='hidden' value='0'/>
                    <input type='hidden' id='calculo$cont' name='Calculo$cont' value='0'/>    
                </td>
            </tr>
        </table>¬    
        <table border='0' cellpadding='0' cellspacing='0' width='100%'>                
            <tr>
               <td><img src='../Imagens/vazio.gif' width='1' height='4' border='0'/></td>
            </tr>
        </table>";
           
echo $resultado;
?>