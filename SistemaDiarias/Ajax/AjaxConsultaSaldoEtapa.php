<?php
include "../../Include/Inc_Configuracao.php";

$etapaId         = $_POST['etapaId'];
$etapaAnt        = $_POST['etapaAnt'];
$valorReferencia = $_POST['valorReferencia'];
$valorDiaria     = $_POST['valorDiaria'];
$diariaId        = $_POST['diariaId'];
$valorDiariaAnt  = $_POST['valorAnt'];
$valorRefAnt     = $_POST['valorRefAnt'];

$sqlConsultaSaldo = "SELECT * FROM diaria.etapa WHERE etapa_id = $etapaId AND etapa_st = 0 ORDER BY etapa_meta, etapa_codigo";
$rsConsultaSaldo  = pg_query(abreConexao(),$sqlConsultaSaldo);
$linhaSaldo       = pg_fetch_assoc($rsConsultaSaldo);

if(($etapaAnt == '')||($etapaAnt == 0))
{
    if($valorReferencia > '124')
    {
        $nivel                = 'superior';  
        $saldoSuperiorInicial = $linhaSaldo['saldo_superior_inicio'];
        $saldoSuperior        = $linhaSaldo['saldo_superior'];

        if(($saldoSuperiorInicial != '')&&($saldoSuperiorInicial != 0))
        {
            if(($saldoSuperior != '')&&($saldoSuperior != 0))
            {
                if($saldoSuperiorInicial - ($saldoSuperior + (int)trim($valorDiaria)) < 0)
                {
                    $saldoDisponivel = $saldoSuperiorInicial - $saldoSuperior;
                    
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoDisponivel,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL SUPERIOR!</td>
                                </tr>            
                            </table>";                  
                }
                else
                {
                    $saldoSuperiorAtual = $saldoSuperior + (int)trim($valorDiaria);

                    echo "<input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoSuperiorAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivel' />";
                }
            }
            else
            {
                if(($saldoSuperiorInicial - (int)trim($valorDiaria)) < 0)
                {
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoSuperiorInicial,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL SUPERIOR!</td>
                                </tr>            
                            </table>";                 
                }
                else
                {
                    $saldoSuperiorAtual = (int)trim($valorDiaria);

                    echo "<input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoSuperiorAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivel' />";
                }
            }
        }
        else
        {
            //Caso o saldo exista saldo, será apresentada a mensagem de saldo indisponível.
            echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                            <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                        </tr>
                        <tr class='MensagemErro'>
                            <td height='10'>NÃO HÁ SALDO SUFICIENTE NESTA ETAPA PARA DIÁRIAS DE NÍVEL SUPERIOR!</td>
                        </tr>            
                    </table>"; 
        }
    }
    elseif($valorReferencia < '115')
    {
        $nivel                = 'medio';
        $saldoMedioInicial    = $linhaSaldo['saldo_medio_inicio'];
        $saldoMedio           = $linhaSaldo['saldo_medio'];

        if(($saldoMedioInicial != '')&&($saldoMedioInicial != 0))
        {
            if(($saldoMedio != '')&&($saldoMedio != 0))
            {
                if(($saldoMedioInicial - ($saldoMedio+(int)trim($valorDiaria))) < 0)
                {
                    $saldoDisponivel = $saldoMedioInicial - $saldoMedio;

                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoDisponivel,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL MÉDIO!</td>
                                </tr>            
                            </table>";                 
                }
                else
                {
                    $saldoMedioAtual = $saldoMedio + (int)trim($valorDiaria);

                    echo "<input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoMedioAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivel' />";
                }
            }
            else
            {
                if(($saldoMedioInicial - (int)trim($valorDiaria)) < 0)
                {
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoMedioInicial,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL MÉDIO!</td>
                                </tr>            
                            </table>";                 
                }
                else
                {
                    $saldoMedioAtual = (int)trim($valorDiaria);

                    echo "<input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoMedioAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivel' />";
                }
            }
        }
        else
        {
            //Caso o saldo exista saldo, será apresentada a mensagem de saldo indisponível.
            echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                            <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                        </tr>
                        <tr class='MensagemErro'>
                            <td height='10'>NÃO HÁ SALDO SUFICIENTE NESTA ETAPA PARA DIÁRIAS DE NÍVEL MÉDIO!</td>
                        </tr>            
                    </table>";        
        }
    }
}
else
{
    if($etapaAnt != $etapaId)
    {
        $sqlConsultaSaldoAnt = "SELECT * FROM diaria.etapa WHERE etapa_id = $etapaAnt ORDER BY etapa_meta, etapa_codigo";
        $rsConsultaSaldoAnt  = pg_query(abreConexao(),$sqlConsultaSaldoAnt);
        $linhaSaldoAnt       = pg_fetch_assoc($rsConsultaSaldoAnt);

        if($valorRefAnt == $valorReferencia)
        {
            if($valorReferencia > '114')
            {
                $nivel = 'superior';
                $saldoSuperiorAntAtual = $linhaSaldoAnt['saldo_superior'] - (int)trim($valorDiariaAnt);
                $saldoSuperiorAtual    = $linhaSaldo['saldo_superior'] + (int)trim($valorDiaria);
                $saldoDisponivel       = $linhaSaldo['saldo_superior_inicio'] - ((int)trim($valorDiaria) + $linhaSaldo['saldo_superior']);
                
                if($saldoDisponivel >= 0)
                {
                    echo "<input type='hidden' id='saldoEtapaAnt' name='saldoEtapaAnt' value='$saldoSuperiorAntAtual' />
                          <input type='hidden' id='saldoNivelAnt' name='saldoNivelAnt' value='$nivel' />
                          <input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoSuperiorAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivel' />";                                
                }
                else 
                {
                    $saldoDisponivel = $linhaSaldo['saldo_superior_inicio'] - $linhaSaldo['saldo_superior'];
                     
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoDisponivel,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL SUPERIOR!</td>
                                </tr>            
                            </table>"; 
                }
            }
            elseif($valorReferencia < '115')
            {
                $nivel = 'medio';                
                $saldoMedioAntAtual = $linhaSaldoAnt['saldo_medio'] - (int)trim($valorDiariaAnt);
                $saldoMedioAtual    = $linhaSaldo['saldo_medio'] + (int)trim($valorDiaria);
                $saldoDisponivel    = $linhaSaldo['saldo_medio_inicio'] - ((int)trim($valorDiaria) + $linhaSaldo['saldo_medio']);
                
                if($saldoDisponivel >= 0)
                {                
                    echo "<input type='hidden' id='saldoEtapaAnt' name='saldoEtapaAnt' value='$saldoMedioAntAtual' />
                          <input type='hidden' id='saldoNivelAnt' name='saldoNivelAnt' value='$nivel' />
                          <input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoMedioAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivel' />"; 
                }
                else
                {
                    $saldoDisponivel = $linhaSaldo['saldo_medio_inicio'] - $linhaSaldo['saldo_medio'];
                     
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoDisponivel,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL MÉDIO!</td>
                                </tr>            
                            </table>"; 
                }
            }
        }
        else
        {
            if($valorRefAnt > '114')
            {
                $nivelAnt              = 'superior';
                $saldoSuperiorAntAtual = $linhaSaldoAnt['saldo_superior'] - (int)trim($valorDiariaAnt);
                $nivelAtual            = 'medio';
                $saldoMedioAtual       = $linhaSaldo['saldo_medio'] + (int)trim($valorDiaria);
                $saldoDisponivel       = $linhaSaldo['saldo_medio_inicio'] - ((int)trim($valorDiaria) + $linhaSaldo['saldo_medio']);
                
                if($saldoDisponivel >= 0)
                {
                    echo "<input type='hidden' id='saldoEtapaAnt' name='saldoEtapaAnt' value='$saldoSuperiorAntAtual' />
                          <input type='hidden' id='saldoNivelAnt' name='saldoNivelAnt' value='$nivelAnt' />
                          <input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoMedioAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivelAtual' />"; 
                }
                else
                {
                    $saldoDisponivel = $linhaSaldo['saldo_medio_inicio'] - $linhaSaldo['saldo_medio'];
                     
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoDisponivel,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL MÉDIO!</td>
                                </tr>            
                            </table>"; 
                }
            }
            elseif($valorRefAnt < '115')
            {
                $nivelAnt           = 'medio';
                $saldoMedioAntAtual = $linhaSaldoAnt['saldo_medio'] - (int)trim($valorDiariaAnt);
                $nivelAtual         = 'superior';
                $saldoSuperiorAtual = $linhaSaldo['saldo_superior'] + (int)trim($valorDiaria);
                $saldoDisponivel    = $linhaSaldo['saldo_superior_inicio'] - ((int)trim($valorDiaria) + $linhaSaldo['saldo_superior']);
                
                if($saldoDisponivel >= 0)
                {
                    echo "<input type='hidden' id='saldoEtapaAnt' name='saldoEtapaAnt' value='$saldoMedioAntAtual' />
                          <input type='hidden' id='saldoNivelAnt' name='saldoNivelAnt' value='$nivelAnt' />
                          <input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoSuperiorAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivelAtual' />"; 
                }
                else
                {
                    $saldoDisponivel = $linhaSaldo['saldo_superior_inicio'] - $linhaSaldo['saldo_superior'];
                     
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoDisponivel,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL SUPERIOR!</td>
                                </tr>            
                            </table>"; 
                }
            }
        }
    }
    else
    {
        if(($valorRefAnt == $valorReferencia)&&($valorDiaria != $valorDiariaAnt))
        {
            if($valorReferencia > '114')
            {
                $nivel = 'superior';
                
                if($valorDiariaAnt < $valorDiaria)
                {
                    $valorDiariaAtual   = (int)trim($valorDiaria) - (int)trim($valorDiariaAnt);
                    $saldoSuperiorAtual = $linhaSaldo['saldo_superior'] + $valorDiariaAtual;
                }
                elseif($valorDiariaAnt > $valorDiaria)
                {
                    $valorDiariaAtual   = (int)trim($valorDiariaAnt) - (int)trim($valorDiaria);
                    $saldoSuperiorAtual = $linhaSaldo['saldo_superior'] - $valorDiariaAtual;
                }  
                
                $saldoDisponivel = $linhaSaldo['saldo_superior_inicio'] - $saldoSuperiorAtual;
                
                if($saldoDisponivel >= 0)
                {
                    echo "<input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoSuperiorAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivel' />"; 
                }
                else
                {
                    $saldoDisponivel = $linhaSaldo['saldo_superior_inicio'] - $linhaSaldo['saldo_superior'];
                     
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoDisponivel,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL SUPERIOR!</td>
                                </tr>            
                            </table>"; 
                }
            }
            elseif($valorReferencia < '115')
            {
                $nivel = 'medio';
                
                if($valorDiariaAnt < $valorDiaria)
                {
                    $valorDiariaAtual = (int)trim($valorDiaria) - (int)trim($valorDiariaAnt);
                    $saldoMedioAtual  = $linhaSaldo['saldo_medio'] + $valorDiariaAtual;
                }
                elseif($valorDiariaAnt > $valorDiaria)
                {
                    $valorDiariaAtual = (int)trim($valorDiariaAnt) - (int)trim($valorDiaria);
                    $saldoMedioAtual  = $linhaSaldo['saldo_medio'] - $valorDiariaAtual;
                }  
                
                $saldoDisponivel = $linhaSaldo['saldo_medio_inicio'] - $saldoMedioAtual;
                
                if($saldoDisponivel >= 0)
                {
                    echo "<input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoMedioAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivel' />"; 
                }
                else
                {
                    $saldoDisponivel = $linhaSaldo['saldo_medio_inicio'] - $linhaSaldo['saldo_medio'];                    
                     
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoDisponivel,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL MÉDIO!</td>
                                </tr>            
                            </table>"; 
                }
            }
        }
        elseif($valorRefAnt != $valorReferencia)
        {
            if($valorRefAnt > '114')
            {
                $nivelAnt              = 'superior';
                $saldoSuperiorAntAtual = $linhaSaldo['saldo_superior'] - (int)trim($valorDiariaAnt);
                $nivelAtual            = 'medio';
                $saldoMedioAtual       = $linhaSaldo['saldo_medio'] + (int)trim($valorDiaria);
                $saldoDisponivel       = $linhaSaldo['saldo_medio_inicio'] - $saldoMedioAtual;
                
                if($saldoDisponivel >= 0)
                {
                    echo "<input type='hidden' id='saldoEtapaAnt' name='saldoEtapaAnt' value='$saldoSuperiorAntAtual' />
                          <input type='hidden' id='saldoNivelAnt' name='saldoNivelAnt' value='$nivelAnt' />
                          <input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoMedioAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivelAtual' />"; 
                }
                else
                {
                    $saldoDisponivel = $linhaSaldo['saldo_medio_inicio'] - $linhaSaldo['saldo_medio'];
                     
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoDisponivel,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL MÉDIO!</td>
                                </tr>            
                            </table>"; 
                }
            }
            elseif($valorRefAnt < '115')
            {
                $nivelAnt           = 'medio';
                $saldoMedioAntAtual = $linhaSaldo['saldo_medio'] - (int)trim($valorDiariaAnt);
                $nivelAtual         = 'superior';
                $saldoSuperiorAtual = $linhaSaldo['saldo_superior'] + (int)trim($valorDiaria);
                $saldoDisponivel    = $linhaSaldo['saldo_superior_inicio'] - $saldoSuperiorAtual;
                
                if($saldoDisponivel >= 0)
                {
                    echo "<input type='hidden' id='saldoEtapaAnt' name='saldoEtapaAnt' value='$saldoMedioAntAtual' />
                          <input type='hidden' id='saldoNivelAnt' name='saldoNivelAnt' value='$nivelAnt' />
                          <input type='hidden' id='saldoEtapa' name='saldoEtapa' value='$saldoSuperiorAtual' />
                          <input type='hidden' id='saldoNivel' name='saldoNivel' value='$nivelAtual' />"; 
                }
                else
                {                    
                    $saldoDisponivel = $linhaSaldo['saldo_superior_inicio'] - $linhaSaldo['saldo_superior'];
                     
                    echo "1¬<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td height='10'><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>
                                </tr>
                                <tr class='MensagemErro'>
                                    <td height='10'>RESTAM APENAS R$ ".number_format($saldoDisponivel,2,',','.').", DE SALDO NESTA ETAPA PARA DIÁRIAS DE NÍVEL SUPERIOR!</td>
                                </tr>            
                            </table>"; 
                }
            }
        }
    }
}
?>
