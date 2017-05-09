<?php
include "../../Include/Inc_Configuracao.php";

$cont           = $_POST['controle'];
$alterarRoteiro = $_POST['alterarRoteiro'.$cont];
$roteiro        = $cont + 1;
$codigo         = $_POST['codigo'];

if(strlen($_POST['txtValorRef']) > 5)
{
    $txtValorRef = substr($_POST['txtValorRef'], 0, 3);
}
else
{
    $txtValorRef = substr($_POST['txtValorRef'], 0, 2);
}

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

$sqlContultaDadosRoteiroComprovacao = "SELECT * FROM diaria.dados_roteiro_multiplo_comprovacao
                                        WHERE diaria_id = ".$codigo."
                                          AND dados_roteiro_comprovacao_status = 0  
                                          AND controle_roteiro_comprovacao = ".$cont;

$rsContultaDadosRoteiroComprovacao  = pg_query(abreConexao(),$sqlContultaDadosRoteiroComprovacao);
$linhaMultiploRoteiroComprovacao    = pg_fetch_assoc($rsContultaDadosRoteiroComprovacao);

$dtSaida           = $linhaMultiploRoteiroComprovacao['diaria_comprovacao_dt_saida'];
$hrSaida           = $linhaMultiploRoteiroComprovacao['diaria_comprovacao_hr_saida'];    
$dtChegada         = $linhaMultiploRoteiroComprovacao['diaria_comprovacao_dt_chegada'];
$hrChegada         = $linhaMultiploRoteiroComprovacao['diaria_comprovacao_hr_chegada'];    
$qtdDiarias        = $linhaMultiploRoteiroComprovacao['diaria_comprovacao_qtde'];
$valorDiaria       = $linhaMultiploRoteiroComprovacao['diaria_comprovacao_valor'];         

if ($linhaMultiploRoteiroComprovacao['diaria_comprovacao_desconto'] == "N") 
{
    $desconto = "Não";
} 
else 
{        
    $desconto = "Sim";
}

$diaSemanaSaida    = diasemana($dtSaida);
$diaSemanaChegada  = diasemana($dtChegada);


$result = "<table width='798' border='0' cellpadding='0' cellspacing='1'>
              <tr class='dataTitulo'>
                 <td height='21' colspan='2'>&nbsp;Roteiro $roteiro</td>
              </tr>
              <tr class='dataLabel'>
                 <td>&nbsp;Origem</td>
                 <td>&nbsp;Destino</td>
              </tr>";

$sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$codigo." AND controle_roteiro = ".$cont;
$rsRoteiro = pg_query(abreConexao(), $sqlRoteiro);

While($linhaRoteiro = pg_fetch_assoc($rsRoteiro)) 
{
    $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linhaRoteiro['roteiro_origem'];
    $rsRoteiroOrigem = pg_query(abreConexao(), $sqlRoteiroOrigem);
    $linhaOrigem = pg_fetch_assoc($rsRoteiroOrigem);
    $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linhaRoteiro['roteiro_destino'];
    $rsRoteiroDestino = pg_query(abreConexao(), $sqlRoteiroDestino);
    $linhaDestino = pg_fetch_assoc($rsRoteiroDestino);
    
    $result .= "<tr class='dataField' height='21'>";
    $result .= "  <td>&nbsp;" . $linhaOrigem['estado_uf'] . " - " . $linhaOrigem['municipio_ds']."</td>";
    $result .= "  <td>&nbsp;" . $linhaDestino['estado_uf'] . " - " . $linhaDestino['municipio_ds']."</td>";
    $result .= "</tr>";
}

$result .= "                
            </table>                    
            <table border='0' cellpadding='0' cellspacing='0' width='100%'>                
                <tr>
                    <td><img src='../Imagens/vazio.gif' width='1' height='4' border='0'/></td>
                </tr>
            </table>
            <table width='798' border='0' cellpadding='0' cellspacing='1'>
                <tr>
                    <td height='21' colspan='8' class='dataLabel'>&nbsp;Complemento do Roteiro</td>
                </tr>
                <tr class='dataField'>
                    <td height='21' colspan='8'>&nbsp;".$diariaComplementoPrevista."</td>
                </tr>
            </table>
            <table border='0' cellpadding='0' cellspacing='0' width='100%'>                
                <tr>
                    <td><img src='../Imagens/vazio.gif' width='1' height='4' border='0'/></td>
                </tr>
            </table>            
            <table width='798' border='0' cellpadding='0' cellspacing='1'>
                <tr class='dataTitulo'>
                    <td height='21' width='399' colspan='8'>Dados da Solicita&ccedil;&atilde;o</td>
                </tr>
                <tr class='dataTitulo'>
                    <td height='21' width='399' colspan='3'>Partida Prevista</td>
                    <td height='21' width='399' colspan='3'>Chegada Prevista</td>
                    <td height='21' width='160' colspan='2'>Quantidade e Valor Previstos</td>
                </tr>
                <tr class='dataLabel'>
                    <td height='21' width='80'>Data</td>
                    <td height='21' width='80'>Hora</td>
                    <td height='21' width='139'>Dia da Semana</td>
                    <td height='21' width='80'>Data</td>
                    <td height='21' width='80'>Hora</td>
                    <td height='21' width='139'>Dia da Semana</td>
                    <td height='21' width='100'>Qtde Di&aacute;rias</td>
                    <td height='21' width='100'>Valor Total</td>  
                </tr>
                <tr class='dataField'>
                    <td height='21' width='80'> $dtSaidaPrevista</td>
                    <td height='21' width='80'> $hrSaidaPrevista</td>
                    <td height='21' width='139'> $diaSemanaSaidaPrevista</td>
                    <td height='21' width='80'> $dtChegadaPrevista</td>
                    <td height='21' width='80'> $hrChegadaPrevista</td>
                    <td height='21' width='139'> $diaSemanaChegadaPrevista</td>
                    <td height='21' width='100'>$qtdDiariasPrevista</td>
                    <td height='21' width='100'>R$ ".number_format($valorDiariaPrevista, 2, ',', '.')."</td>  
                </tr> 
            </table>
            <table width='800' border='0' cellpadding='0' cellspacing='1'>
                <tr class='dataTitulo'>
                    <td height='21' width='399' colspan='8'>Dados da Comprova&ccedil;&atilde;o</td>
                </tr>
                <tr class='dataTitulo'>
                    <td height='21' width='359' colspan='3'>Partida Realizada</td>
                    <td height='21' width='359' colspan='3'>Chegada Realizada</td>
                    <td height='21' width='160' colspan='2'>Quantidade e Valor Efetivos</td>
                </tr>
                <tr class='dataLabel'>
                    <td height='21' width='80'>Data</td>
                    <td height='21' width='80'>Hora</td>
                    <td height='21' width='139'>Dia da Semana</td>
                    <td height='21' width='80'>Data</td>
                    <td height='21' width='80'>Hora</td>
                    <td height='21' width='139'>Dia da Semana</td>
                    <td height='21' width='100'>Qtde Di&aacute;rias</td>
                    <td height='21' width='100'>Valor Total</td> 
                </tr>
                <tr class='dataField'>
                    <td height='21' width='80'>$dtSaida</td>
                    <td height='21' width='80'>$hrSaida</td>
                    <td height='21' width='139'>$diaSemanaSaida</td>
                    <td height='21' width='80'>$dtChegada</td>
                    <td height='21' width='80'>$hrChegada</td>
                    <td height='21' width='139'>$diaSemanaChegada</td>
                    <td height='21' width='100'>$qtdDiarias</td>
                    <td height='21' width='100'>R$ ".number_format($valorDiaria, 2, ',', '.')."</td>
                </tr>                
            </table>
            <table width='100%' border='0' cellpadding='0' cellspacing='1'>										
                <tr class='dataLabel'>
                    <td height='21' width='120'>Redu&ccedil;&atilde;o 50%</td>
                    <td height='21' width='228' colspan='2'></td>
                    <td height='21' width='150'>Valor do Roteiro</td>
                    <td height='21' width='150'>A Restituir</td>
                    <td height='21' width='150'>A Receber</td>
                </tr>
                <tr class='dataField'>
                    <td height='21' >$desconto</td>
                    <td height='21' colspan='2'></td>
                    <td height='21' ></td>";        

    $percentualImprimir = (str_replace(",", ".", $Percentual) * 100);
    
    if($linhaMultiploRoteiroComprovacao['diaria_comprovacao_saldo'] != '')
    {
        $saldo = $linhaMultiploRoteiroComprovacao['diaria_comprovacao_saldo'];
        $saldo = 'R$ '.number_format($saldo, 2, ',', '.');                                                            
    }
    else
    {
        $saldo = 'R$ 0,00';
    }

    if ($linhaMultiploRoteiroComprovacao['diaria_comprovacao_saldo_tipo'] == "D")
    {                                                               
        $result .= "<td height='21'> ".$saldo."</td>
                       <td height='21'>R$ 0,00</td>";
    }
    else
    {	
        $result .= "<td height='21'>R$ 0,00</td>
                       <td height='21'>".$saldo."</td>";
    }     

    $result .= "</tr>
                    <tr>
                       <td height='21' class='dataLabel' colspan='6'>Resumo</td>
                   </tr>
                   <tr>
                       <td class='dataField' colspan='6'>
                           <textarea id='txtResumo' name='txtResumo' class='RealmenteInvisivel2' cols='128' rows='14' disabled='disabled'>".$linhaMultiploRoteiroComprovacao['diaria_resumo_comprovacao']."</textarea>                                                
                       </td>
                   </tr>                   
                </table>
            </div> 
        </td>
    </tr>
    </table>
    </td>
    </tr>
</table>";
echo $result;
?>
