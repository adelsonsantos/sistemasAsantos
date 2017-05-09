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

$dtSaida           = $linhaMultiploRoteiro['diaria_dt_saida'];
$hrSaida           = $linhaMultiploRoteiro['diaria_hr_saida'];    
$dtChegada         = $linhaMultiploRoteiro['diaria_dt_chegada'];
$hrChegada         = $linhaMultiploRoteiro['diaria_hr_chegada'];    
$qtdDiarias        = $linhaMultiploRoteiro['diaria_qtde'];
$valorDiaria       = $linhaMultiploRoteiro['diaria_valor'];    
$diariaComplemento = $linhaMultiploRoteiro['diaria_roteiro_complemento'];       

if ($linhaMultiploRoteiro['diaria_desconto'] == "N") 
{
    $descontoMarcado = "";
} 
else 
{        
    $descontoMarcado = "checked";
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
                    <td height='21' colspan='8'>&nbsp;".$diariaComplemento."</td>
                </tr>
            </table>
            <table border='0' cellpadding='0' cellspacing='0' width='100%'>                
                <tr>
                    <td><img src='../Imagens/vazio.gif' width='1' height='4' border='0'/></td>
                </tr>
            </table>            
            <table width='798' border='0' cellpadding='0' cellspacing='1'>
                <tr class='dataTitulo'>
                    <td height='21' width='399' colspan='3'>&nbsp;Partida Prevista</td>
                    <td height='21' width='399' colspan='3'>&nbsp;Chegada Prevista</td>
                </tr>
                <tr class='dataLabel'>
                    <td height='21' width='100'>&nbsp;Data</td>
                    <td height='21' width='100'>&nbsp;Hora</td>
                    <td height='21' width='199'>&nbsp;Dia da Semana</td>
                    <td height='21' width='100'>&nbsp;Data</td>
                    <td height='21' width='100'>&nbsp;Hora</td>
                    <td height='21' width='199'>&nbsp;Dia da Semana</td>
                </tr>
                <tr class='dataField'>
                    <td height='21' width='100'>&nbsp; $dtSaida</td>
                    <td height='21' width='100'>&nbsp; $hrSaida</td>
                    <td height='21' width='199'>&nbsp; $diaSemanaSaida</td>
                    <td height='21' width='100'>&nbsp; $dtChegada</td>
                    <td height='21' width='100'>&nbsp; $hrChegada</td>
                    <td height='21' width='199'>&nbsp; $diaSemanaChegada</td>
                </tr>
            </table>
            <table width='798' border='0' cellpadding='0' cellspacing='1'>
                <tr class='dataLabel'>
                    <td height='21' width='100'>&nbsp;Redu&ccedil;&atilde;o 50%</td>
                    <td height='21' width='102'>&nbsp;Qtde D&aacute;rais</td>
                    <td height='21' width='195'>&nbsp;Valor Refer&ecirc;ncia</td>
                    <td height='21' width='98'>&nbsp;Valor</td>
                    <td>&nbsp;</td>
                </tr>";

                $valor = $valorDiaria;
                $valor = 'R$ '.number_format($valor, 2, ',', '.');                                                                    
                $valorRef = 'R$ '.number_format($txtValorRef, 2, ',', '.');                                                          

    $result .=" <tr class='dataField'>
                    <td height='21' width='85'>&nbsp; $desconto</td>
                    <td>&nbsp; $qtdDiarias<input type='hidden' name='hdQtde$cont' id='hdQtde$cont' value='$qtdDiarias' style='width:75px; height:18px;'></input></td>
                    <td height='21' width='100'>&nbsp;$valorRef</td>
                    <td>&nbsp;$valor<input type='hidden' name='hdValor$cont' id='hdValor$cont' value='$valorDiaria' style='width:75px; height:18px;'></input></td>
                    <td>&nbsp;</td>
                </tr>
            </table>";
echo $result;
?>
