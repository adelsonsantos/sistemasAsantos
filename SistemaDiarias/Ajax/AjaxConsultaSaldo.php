<?php
include "../../Include/Inc_Configuracao.php";
include "../IncludeLocal/Inc_FuncoesDiarias.php";

$codigoProjeto = trim($_POST['projetoId']);
$codigoFonte   = trim($_POST['fonteId']);
$dataPartida   = trim($_POST['dataPartida']);
$mes           = substr($dataPartida,3,2);
$valorDiaria   = trim($_POST['valorDiaria']);
$projetoAnt    = trim($_POST['projetoAnt']);
$fonteAnt      = trim($_POST['fonteAnt']);
$valorAnt      = trim($_POST['valorAnt']);
$dataPartAnt   = trim($_POST['dataPartAnt']);
$mesAnt        = substr($dataPartAnt,3,2);
$ano           = date("Y");

if($mes != '')
{
    $sqlConsultaEtapa = "SELECT * FROM diaria.etapa WHERE projeto_id = ".$codigoProjeto." AND fonte_id = '".$codigoFonte."' AND etapa_st = 0 ORDER BY etapa_meta, etapa_codigo";
    $rsConsultaEtapa  = pg_query(abreConexao(),$sqlConsultaEtapa);
    $linhaEtapa       = pg_fetch_assoc($rsConsultaEtapa);
    
    if(($linhaEtapa == '')||($linhaEtapa == 0))
    {        
        if(($codigoFonte != 'XX')&&($codigoProjeto != '1000'))
        {
            $sqlConsulta = "SELECT * FROM diaria.saldo_projeto_fonte WHERE id_saldo_projeto = ".$codigoProjeto." AND saldo_st <> 2 AND DATE_PART('YEAR', data_criacao) = '$ano' AND id_saldo_fonte ='".$codigoFonte."' AND saldo_mes =".$mes; 
            $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);
            $linha       = pg_fetch_assoc($rsConsulta);
            //Caso exista saldo na fonte selecionada em determinado projeto o valor da diária será abatido no saldo.
            if(($linha['saldo_valor']!='')&&($linha['saldo_valor'] > 0))
            {
                if((int)$valorDiaria <= (int)$linha['saldo_valor'])
                {
                    $saldoSubtraido = ((int)$linha['saldo_valor']-(int)$valorDiaria);
                    //Caso o projeto ou a fonte tenha sido alterado e antes desta alteração o valor deles tenha sido diferente de 0 ou de XX, o valor do saldo anterior será passado para realizar a devolução.                    
                    if(($projetoAnt != $codigoProjeto)||($fonteAnt != $codigoFonte))
                    {            
                        if(($fonteAnt != '')&&($fonteAnt != 'XX')&&($projetoAnt != '')&&($projetoAnt != '1000'))
                        {
                            $sqlConsultaAnt = "SELECT * FROM diaria.saldo_projeto_fonte WHERE id_saldo_projeto = ".$projetoAnt." AND saldo_st <> 2 AND DATE_PART('YEAR', data_criacao) = '$ano' AND id_saldo_fonte ='".$fonteAnt."' AND saldo_mes ='".$mesAnt."'"; 
                            $rsConsultaAnt  = pg_query(abreConexao(),$sqlConsultaAnt);
                            $linhaAnt       = pg_fetch_assoc($rsConsultaAnt);

                            $valorAnt = ((int)$linhaAnt['saldo_valor'] + (int)$valorAnt);

                            echo "<input type='hidden' id='saldoValorAnt' name='saldoValorAnt' value='$valorAnt' />
                                  <input type='hidden' id='saldoValorSub' name='saldoValorSub' value='$saldoSubtraido' />";
                        }
                        else
                        {
                            echo "<input type='hidden' id='saldoValorSub' name='saldoValorSub' value='$saldoSubtraido' />";
                        }
                    }
                    else
                    {
                        if($mes == $mesAnt)
                        {
                            if($valorDiaria > $valorAnt)
                            {
                                $valorDiaria = ((int)$valorDiaria - (int)$valorAnt);
                                $saldoSubtraido = ((int)$linha['saldo_valor'] - $valorDiaria);
                                echo "<input type='hidden' id='saldoValorSub' name='saldoValorSub' value='$saldoSubtraido' />";
                            }
                            elseif($valorDiaria < $valorAnt)
                            {
                                $valorAnt = ((int)$valorAnt - (int)$valorDiaria);
                                $saldoSubtraido = ((int)$linha['saldo_valor'] + $valorAnt);
                                echo "<input type='hidden' id='saldoValorSub' name='saldoValorSub' value='$saldoSubtraido' />";
                            }
                        }
                        else
                        {
                            $sqlConsultaAnt = "SELECT * FROM diaria.saldo_projeto_fonte WHERE id_saldo_projeto = ".$projetoAnt." AND DATE_PART('YEAR', data_criacao) = '$ano' AND id_saldo_fonte ='".$fonteAnt."' AND saldo_mes ='".$mesAnt."'"; 
                            $rsConsultaAnt  = pg_query(abreConexao(),$sqlConsultaAnt);
                            $linhaAnt       = pg_fetch_assoc($rsConsultaAnt);
                            $valorAnt       = ((int)$linhaAnt['saldo_valor'] + (int)$valorAnt);

                            echo "<input type='hidden' id='saldoValorAnt' name='saldoValorAnt' value='$valorAnt' />
                                  <input type='hidden' id='saldoValorSub' name='saldoValorSub' value='$saldoSubtraido' />";
                        }
                    }
                }
                else
                {
                    //Caso o saldo seja 0 ou não exista saldo, será apresentada a mensagem de saldo indisponível.
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                            <tr>
                                <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                            </tr>
                            <tr class='MensagemErro'>
                                <td height='10'>NÃO HÁ SALDO SUFICIENTE NESTE PROJETO PARA ESTA FONTE! O VALOR DISPONÍVEL É DE R$ ".number_format((int)$linha['saldo_valor'], 2, ',', '.')."</td>
                            </tr>            
                         </table>";
                }
            }
            else
            {
                //Caso o saldo seja 0 ou não exista saldo, será apresentada a mensagem de saldo indisponível.
                echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                            <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                        </tr>
                        <tr class='MensagemErro'>
                            <td height='10'>NÃO HÁ SALDO DISPONÍVEL NESTE PROJETO PARA ESTA FONTE !</td>
                        </tr>            
                     </table>";
            }    
        }
        else 
        {
            if(($fonteAnt != '')&&($fonteAnt != 'XX')&&($projetoAnt != '')&&($projetoAnt != '1000'))
            {
                $sqlConsultaAnt = "SELECT * FROM diaria.saldo_projeto_fonte WHERE id_saldo_projeto = ".$projetoAnt." AND saldo_st <> 2 AND DATE_PART('YEAR', data_criacao) = '$ano' AND id_saldo_fonte ='".$fonteAnt."' AND saldo_mes ='".$mesAnt."'"; 
                $rsConsultaAnt  = pg_query(abreConexao(),$sqlConsultaAnt);
                $linhaAnt       = pg_fetch_assoc($rsConsultaAnt);
                $valorAnt       = ((int)$linhaAnt['saldo_valor'] + (int)$valorAnt);

                echo "<input type='hidden' id='saldoValorAnt' name='saldoValorAnt' value='$valorAnt' />";
            }
        }
    }
    else
    {
        f_ComboEtapas('cmbEtapa','783', '0','onchange="VerificaSaldoEtapa()"','114',$codigoProjeto,$codigoFonte);
    }
}
else
{
    //Caso o saldo seja 0 ou não exista saldo, será apresentada a mensagem de saldo indisponível.
    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
            <tr>
                <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
            </tr>
            <tr class='MensagemErro'>
                <td height='10'>FAVOR O INFORMAR CALCULAR A DIÁRIA!</td>
            </tr>            
         </table>";
}
?>

