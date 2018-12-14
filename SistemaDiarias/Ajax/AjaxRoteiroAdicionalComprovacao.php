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

$codigo = $_POST['codigo'];

$sqlConsultaDiaria = "SELECT diaria_beneficiario,diaria_dt_criacao,diaria_comprovada FROM diaria.diaria WHERE diaria_id =".$codigo;
$rsContultaDiaria  = pg_query(abreConexao(),$sqlConsultaDiaria);
$linhaDiaria       = pg_fetch_assoc($rsContultaDiaria);

$sqlContultaDadosRoteiro = "SELECT * FROM diaria.dados_roteiro_multiplo
                                WHERE diaria_id = ".$codigo."
                                  AND dados_roteiro_status = 0  
                                  AND controle_roteiro = ".$cont;

$rsContultaDadosRoteiro  = pg_query(abreConexao(),$sqlContultaDadosRoteiro);
$linhaMultiploRoteiro    = pg_fetch_assoc($rsContultaDadosRoteiro);

$dtSaidaPrevista           = $linhaMultiploRoteiro['diaria_dt_saida'];
$hrSaidaPrevista           = $linhaMultiploRoteiro['diaria_hr_saida'];    
$dtChegadaPrevista         = $linhaMultiploRoteiro['diaria_dt_chegada'];
$hrChegadaPrevista         = $linhaMultiploRoteiro['diaria_hr_chegada'];    
$qtdDiariasPrevista        = $linhaMultiploRoteiro['diaria_qtde'];
$valorDiariaPrevista       = $linhaMultiploRoteiro['diaria_valor'];    
$diariaComplementoPrevista = $linhaMultiploRoteiro['diaria_roteiro_complemento']; 

$diaSemanaSaidaPrevista    = diasemana($dtSaidaPrevista);
$diaSemanaChegadaPrevista  = diasemana($dtChegadaPrevista);

if($linhaDiaria['diaria_comprovada'] == 0)
{
    $dtSaida           = $dtSaidaPrevista;
    $hrSaida           = $hrSaidaPrevista;    
    $dtChegada         = $dtChegadaPrevista;
    $hrChegada         = $hrChegadaPrevista;    
    $qtdDiarias        = $qtdDiariasPrevista;
    $valorDiaria       = $valorDiariaPrevista;    
    $diariaComplemento = $diariaComplementoPrevista; 
    $desconto          = $linhaMultiploRoteiro['diaria_desconto'];
}
else 
{
    $sqlContultaDadosRoteiro = "SELECT * FROM diaria.dados_roteiro_multiplo_comprovacao
                                WHERE diaria_id = ".$codigo."
                                  AND dados_roteiro_comprovacao_status = 0  
                                  AND controle_roteiro_comprovacao = ".$cont;

    $rsContultaDadosRoteiro  = pg_query(abreConexao(),$sqlContultaDadosRoteiro);
    $linhaMultiploRoteiro    = pg_fetch_assoc($rsContultaDadosRoteiro);

    $dtSaida           = $linhaMultiploRoteiro['diaria_comprovacao_dt_saida'];
    $hrSaida           = $linhaMultiploRoteiro['diaria_comprovacao_hr_saida'];    
    $dtChegada         = $linhaMultiploRoteiro['diaria_comprovacao_dt_chegada'];
    $hrChegada         = $linhaMultiploRoteiro['diaria_comprovacao_hr_chegada'];    
    $qtdDiarias        = $linhaMultiploRoteiro['diaria_comprovacao_qtde'];
    $valorDiaria       = $linhaMultiploRoteiro['diaria_comprovacao_valor'];    
    $diariaComplemento = $linhaMultiploRoteiro['diaria_roteiro_comprovacao_complemento']; 
    $resumo            = $linhaMultiploRoteiro['diaria_resumo_comprovacao'];
    $desconto          = $linhaMultiploRoteiro['diaria_comprovacao_desconto'];
}  

If ($desconto == "N") 
{
    $descontoMarcado = "";
} 
Else 
{        
    $descontoMarcado = "checked";
}
$diaSemanaSaida    = diasemana($dtSaida);
$diaSemanaChegada  = diasemana($dtChegada);


$resultado = "  <input type='hidden' name='txtAlterouCalculo$cont' id='txtAlterouCalculo$cont' value='0'/>
                <table cellpadding='0' cellspacing='1' class='TabelaFormulario' border='0' width='100%'>
                    <tr class='dataTitulo'>
                        <td height='21' width='50%'>&nbsp;".$roteiro."º Roteiro  <span id='roteiroExMsg$cont'></span><input id='roteiroExcluido$cont' name='roteiroExcluido$cont' type='hidden'></input></td>
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

                                    if ($j == 0) 
                                    {
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
                                                    <td height='21' colspan='2' align='right'><input type='button' style='width:85px;' value='Alterar Roteiro' onclick='AlterarRoteiro($cont);'>&nbsp;<input type='hidden' name='txtPercentual$cont' id='txtPercentual$cont' value= '".$Percentual."' /></td>
                                                </tr>";
                            }

                            $resultado .= " </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>  
                            <div id='RoteiroAdicionado$cont'></div>
                            <table width='800' border='0' cellpadding='0' cellspacing='1'>
                                <tr>
                                    <td height='21' colspan='9' class='dataLabel'>&nbsp;Complemento do Roteiro</td>
                                </tr>
                                <tr>
                                    <td height='21' colspan='9' class='dataField'>&nbsp;<input type='text' name='txtRoteiroComplemento$cont' id='txtRoteiroComplemento$cont' style='width:798px;' disabled='disabled' value='".$diariaComplementoPrevista."'/></td>
                                </tr> 
                                <tr class='dataTitulo'>
                                    <td height='21' width='250' colspan='3'>Partida Prevista</td>
                                    <td height='21' width='250' colspan='3'>Chegada Prevista</td>
                                    <td height='21' width='298' colspan='3'>Quantidade e Valor Previstos</td>
                                </tr>
                                <tr class='dataLabel'>
                                    <td height='21' width='90' align='center'>Data</td>
                                    <td height='21' width='60' align='center'>Hora</td>
                                    <td height='21' width='100' align='center'>Dia da Semana</td>
                                    <td height='21' width='90' align='center'>Data</td>
                                    <td height='21' width='60' align='center'>Hora</td>
                                    <td height='21' width='100' align='center'>Dia da Semana</td>
                                    <td height='21' width='98' >Qtde Di&aacute;rias</td>
                                    <td height='21' width='100' >Valor Unitário</td>
                                    <td height='21' width='100' >Valor Total</td>                                                   
                                </tr>
                                <tr class='dataField'>
                                    <td height='21' align='center' >$dtSaidaPrevista</td>
                                    <td height='21' align='center' >$hrSaidaPrevista</td>
                                    <td height='21' align='center' >$diaSemanaSaidaPrevista</td>
                                    <td height='21' align='center' >$dtChegadaPrevista</td>
                                    <td height='21' align='center' >$hrChegadaPrevista</td>
                                    <td height='21' align='center' >$diaSemanaChegadaPrevista</td>  
                                    <td height='21' >$qtdDiariasPrevista</td>
                                    <td height='21' >R$ ".number_format($txtValorRef, 2, ',', '.')."</td>
                                    <td height='21' >R$ ".number_format($valorDiariaPrevista, 2, ',', '.')."</td> 
                                </tr> 
                            </table>
                            <table width='800' border='0' cellpadding='0' cellspacing='1'>
                                <tr class='dataTitulo'>
                                    <td height='21' width='399' colspan='4'>&nbsp;Partida Realizada</td>
                                    <td height='21' width='399' colspan='4'>&nbsp;Chegada Realizada</td>
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
                                    <td height='21' width='80'><input id='dataPartida$cont' type='text' name='txtDataPartida$cont' maxlength='10' style=' width:75px;height:15px;'  value='".$dtSaida."' onchange='computeControle(this,1,$cont);PedeNovoCalculo($cont);'/>
                                    
                                    
                                    <script>
                                        var DtOld = document.getElementById('dataPartida$cont').value;
                                    </script>
                                    </td>
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
                                    <td height='21' width='100'>Redu&ccedil;&atilde;o 50%</td>
                                    <td height='21' width='181'>Valor Refer&ecirc;ncia (Descri&ccedil;&atilde;o)</td>
                                    <td height='21' width='119'>Valor do Roteiro</td>
                                    <td height='21' width='100'>Qtde Di&aacute;rias</td>
                                    <td height='21' width='100'>Valor Total</td>
                                    <td height='21' width='99'>A Restituir</td>
                                    <td height='21' width='99'>A Receber</td>
                                </tr>											
                                <tr class='dataField'>";             

                                    $percentualImprimir = (str_replace(",", ".", $Percentual) * 100);

                   $resultado .= "  <td height='21' width='100'>&nbsp;<input type='checkbox' name='chkDesconto$cont' id='chkDesconto$cont' class='checkbox' ".$descontoMarcado."  onChange='PedeNovoCalculo($cont);'/>&nbsp;Sim</td>
                                    <td height='21' width='181' valign='middle'>".$_POST['valorRef']."</td>
                                    <td height='21' width='318' colspan='3' valign='middle'>
                                        <div id='QtdeDiariaAlterar$cont'> 
                                            <table width='330' border='0' cellpadding='0' cellspacing='1'>
                                                <tr class='dataField'>
                                                    <td height='21' width='118'>+".$percentualImprimir.'%  R$ '.number_format($txtValorRef, 2, ',', '.')."</td>
                                                    <td height='21' width='100'>$qtdDiarias<input type='hidden' id='hdQtdeDiaria$cont' name='hdQtdeDiaria$cont' value='$qtdDiarias'/></td>
                                                    <td height='21' width='100'>R$ ".number_format($valorDiaria, 2, ',', '.')."<input type='hidden' id='hdValorDiaria$cont' name='hdValorDiaria$cont' value='$valorDiaria'/></td>
                                                </tr>
                                            </table>
                                        </div>                                
                                    </td>
                                    <td height='21' width='198' colspan='2'>
                                        <div id='diariaSaldo$cont'>
                                            <table width='198' border='0' cellpadding='0' cellspacing='0'>
                                                <tr class='dataField'>";                                            
                                                    if($linhaMultiploRoteiro['diaria_comprovacao_saldo'] != '')
                                                    {
                                                        $saldo = $linhaMultiploRoteiro['diaria_comprovacao_saldo'];
                                                        if(substr($saldo,0,3) != 'R$ ')
                                                        {
                                                            $saldo = 'R$ '.number_format($saldo, 2, ',', '.');
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $saldo = 'R$ 0,00';
                                                    }
                                                    if ($linhaMultiploRoteiro['diaria_comprovacao_saldo_tipo'] == "D")
                                                    {                                                                                
                                                        $resultado.=  "<td height='21'>$saldo</td>
                                                                       <td height='21'>R$ 0,00</td>";
                                                    }
                                                    else
                                                    {	
                                                        $resultado .= "<td height='21'>R$ 0,00</td>
                                                                       <td height='21'>$saldo</td>";
                                                    }                                              
                                    $resultado .= "</tr>
                                            </table>
                                        </div> 
                                    </td>
                                </tr>
                                <tr class='dataLabelSemBold'>
                                    <td height='21' width='798' colspan='7' align='right'><input id='calcular$cont' type='button' name='btnCalcular$cont' style='width:125px;height:18px;' value='Calcular Di&aacute;ria' onclick=\"Javascript:CalcularComprovacao($('#dataPartida$cont').val(), $('#dataChegada$cont').val(), $('#horaPartida$cont').val(), $('#horaChegada$cont').val(), ".$linhaDiaria['diaria_beneficiario'].", $('#chkDesconto$cont').is(':checked'), $('#txtDataAtual').val(), ".$valorDiariaPrevista.", $('#dataPartida$cont').val(), $cont, DtOld);\"/></td>                                    
                                </tr>
                            </table>
                            <table border='0' cellpadding='0' cellspacing='0' width='100%'>                
                                <tr>
                                   <td><img src='../Imagens/vazio.gif' width='1' height='4' border='0'/></td>
                                </tr>
                            </table>
                            <table width='798' border='0' cellpadding='1' cellspacing='1'>   
                                <tr class='dataTitulo'>
                                    <td height='21' width='319'>Resumo</td>
                                    <td height='21' width='479' align='right'>M&aacute;ximo permitido 3000 caracteres <input type='text' id='QtdResumo$cont' name='QtdResumo$cont' style='width:35px; height:12px;' class='Oculto'/> M&aacute;ximo permitido 25 linhas</td>                                                                                        
                                </tr>
                                <tr class='dataField'>
                                    <td width='798' colspan='2'><textarea name='txtResumo$cont' id='txtResumo$cont' cols='130' rows='15' onkeyup='ContarResumoComprovacao(this,3000,$cont);ContarResumoLinha(this.value)'>$resumo</textarea></td>                                                                                        
                                </tr>
                            </table>
                            </td>
                        </tr>
                    </table>
                    <input name='reCalcular$cont' id='reCalcular$cont' type='hidden' value='0' />
                    <input name='alterarRoteiro$cont' id='alterarRoteiro$cont' type='hidden' value='0'/>
                    <input type='hidden' id='calculo$cont' name='Calculo$cont' value='0'/>   
                    <input name='diariaValorOld' id='diariaValorOld' type='hidden' value='".$valorDiaria."'/>
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