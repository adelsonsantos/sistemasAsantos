<?php
include "../../Include/Inc_Configuracao.php";

$Beneficiario = $_POST['beneficiario'];
$diaria_id    = $_POST['diaria_id'];
$dataPartida  = $_POST['dataPartida'];
$dataChegada  = $_POST['dataChegada'];
$numeroSD     = $_POST['numeroSd'];

$sqlBloqueio    = "SELECT diaria_id, diaria_dt_chegada, diaria_st, diaria_numero,diaria_comprovada 
                     FROM diaria.diaria 
                    --WHERE ((diaria_st >= 3 ) AND (diaria_st <= 5)) 
                    WHERE diaria_st in (3, 4, 5, 10) 
                      AND diaria_excluida = 0 
                      AND (diaria_beneficiario = " .$Beneficiario. ")
                      AND diaria_numero <> '$numeroSD'";

$rsBloqueio             = pg_query(abreConexao(),$sqlBloqueio);
$ContadorAtraso         = 0;
$ContadorVirtual        = 0;
$PossuiBloqueio         = 0;
$BloqueioSei            = 0;
$NumeroDiariaVirtual    = "";
$NumeroDiariaAtrasada   = "";


$sqlBloqueioFinanceiro ="SELECT pessoa_bloq_diaria from dados_unico.pessoa where pessoa_bloq_diaria = 1 and pessoa_id = ".$Beneficiario;

$rsBloqueioFinanceiro = pg_query(abreConexao(),$sqlBloqueioFinanceiro);

$sqlConsultaUltimoBloqueio = "SELECT * FROM diaria.bloqueio_servidor blo  WHERE (blo.pessoa_id = ".$Beneficiario.") order by bloqueio_servidor_id desc limit 1";
$rsConsultaUltimoBloqueio  = pg_query(abreConexao(),$sqlConsultaUltimoBloqueio);
$linha7             = pg_fetch_assoc($rsConsultaUltimoBloqueio);

$descricaoBloqueio = $linha7['bloqueio_descricao'];

if(pg_num_rows($rsBloqueioFinanceiro) > 0)
{
    $PossuiBloqueio = 1;

    $html = "<table width='100%' border='0' cellpadding='0' cellspacing='1'>
                    <tr class='dataLabelSemBold'>
                        <td class='MensagemErro'>&nbsp;BLOQUEADO - $descricaoBloqueio.</td>
                    </tr>
                </table>";
}



if($diaria_id != '')
{
    $condicaoAlteracao = " AND diaria_id <> ".$diaria_id." ";
    $condicaoConflito  = " AND diaria_id != ".$diaria_id." ";
}
else
{
    $condicaoAlteracao = "";
    $condicaoConflito  = "";
}

if($dataPartida != '')
{
    //Limite anual de diarias {
    $sqlQtdMax   = "SELECT diaria_qtde
                      FROM diaria.diaria 
                      JOIN dados_unico.pessoa du 
                        ON du.pessoa_id = diaria_beneficiario
                     WHERE diaria_beneficiario = ".$Beneficiario." 
                       AND diaria_excluida = 0 
                       ".$condicaoAlteracao."
                       AND SUBSTRING(diaria_dt_saida,7) = SUBSTRING('".$dataPartida."',7)
                  ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYY')";

    $rsQtdMax = pg_query(abreConexao(),$sqlQtdMax);							 

    $qtdSoma  = 0;

    while($linhaQtdMax = pg_fetch_assoc($rsQtdMax))
    {        
        $qtdSoma = $qtdSoma + $linhaQtdMax['diaria_qtde'];       
    }
    // }

    //Limite Mensal {
    $sqlQtdMes   = "SELECT diaria_qtde
                      FROM diaria.diaria 
                      JOIN dados_unico.pessoa du 
                        ON du.pessoa_id = diaria_beneficiario
                     WHERE diaria_beneficiario = ".$Beneficiario." 
                       AND diaria_excluida = 0  
                       ".$condicaoAlteracao."
                       AND SUBSTRING(diaria_dt_saida,4) = SUBSTRING('".$dataPartida."',4)
                  ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYY')";

    $rsQtdMes = pg_query(abreConexao(),$sqlQtdMes);							 

    $qtdSomaMes  = 0;
    $acressimoServidor = 5;

    while($linhaQtdMes = pg_fetch_assoc($rsQtdMes))
    {        
        $qtdSomaMes = $qtdSomaMes + $linhaQtdMes['diaria_qtde'];
    }
    // }

    //$qtdSomaMes = $qtdSomaMes - $acressimoServidor;
}

While($linha = pg_fetch_assoc($rsBloqueio))
{
    //Diaria Pendente de Documentação.
    If ($linha['diaria_comprovada'] == "1")// diaria comprovada, mas nao autorizada nem aprovada
    {	
        $ContadorVirtual = $ContadorVirtual + 1;
    }
    Else
    {

        $dataBanco = $linha['diaria_dt_chegada'];
        $dataBanco = explode("-", $dataBanco); 
        //A função mktime recebe os argumentos (hora, minuto, segundos, mes, dia, ano).
        $diaBanco  = mktime(0,0,0,$dataBanco[1],$dataBanco[0],$dataBanco[2]);

        $dataAtual = date("Y-m-d");
        $dataAtual = explode("-", $dataAtual);
        $diaAtual  = mktime(0,0,0,$dataAtual[1],$dataAtual[0],$dataAtual[2]);

        $diferencaDataTempo = ($diaAtual-$diaBanco);
        //converte o tempo em dias
        $DiferencaDias = round(($diferencaDataTempo/60/60/24));
        //modulo da diferenca
        if($DiferencaDias < 0)
        {  
            $DiferencaDias = $DiferencaDias * (-1);
        }
        //Diaria com Prazo de chegada superior a 5 dias .. sem Comprovação .
        If ($DiferencaDias > 5)
        {
            $ContadorAtraso = $ContadorAtraso + 1;
            $NumeroDiariaAtrasada = $NumeroDiariaAtrasada."(" .$linha['diaria_numero'].") ";
        }
    }
    $NumeroDiariaVirtual = $NumeroDiariaVirtual. "(" .$linha['diaria_numero']. ") ";
}

if(($dataPartida != '') && ($dataChegada != ''))
{
    $dataPartida = dataToDB($dataPartida);
    $dataChegada = dataToDB($dataChegada);    
    
    $sqlConflito = "SELECT diaria_id,
                           diaria_numero,
                           diaria_dt_saida,
                           diaria_dt_chegada,
                           qtde_roteiros
                      FROM diaria.diaria
                     WHERE diaria_beneficiario = $Beneficiario
                       AND diaria_excluida = 0 
                       ".$condicaoConflito."
                       AND ( 
                                (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) OVERLAPS (DATE'$dataPartida', DATE'$dataChegada')
                              OR 
                                (
                                   (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') BETWEEN '$dataPartida' AND '$dataChegada') 
                                 OR 
                                   (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$dataPartida' AND '$dataChegada')
                                )
                            )";        

    $rsConflito = pg_query(abreConexao(),$sqlConflito);	

    While($linhaConflito = pg_fetch_assoc($rsConflito))
    {
        $numeroConflito  = $linhaConflito['diaria_numero'];
        
        if($linhaConflito['qtde_roteiros'] > 0)
        {            
            $sqlConflitoMultiplo ="SELECT diaria_id, diaria_dt_saida, diaria_dt_chegada, dados_roteiro_status 
                                    FROM diaria.dados_roteiro_multiplo 
                                   WHERE diaria_id = ".$linhaConflito['diaria_id']." 
                                     AND dados_roteiro_status = 0
                                     AND ( (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) 
                                OVERLAPS (DATE'$dataPartida', DATE'$dataChegada') OR ( (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') 
                                 BETWEEN '$dataPartida' AND '$dataChegada') OR (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$dataPartida' AND '$dataChegada') ) )";
            
            $rsConflitoMultiplo = pg_query(abreConexao(),$sqlConflitoMultiplo);
            
            While($linhaConflitoMultiplo = pg_fetch_assoc($rsConflitoMultiplo))
            {                
                $periodoConflito = $linhaConflitoMultiplo['diaria_dt_saida']." / ".$linhaConflitoMultiplo['diaria_dt_chegada']; 
            }
            $rsConflito = $rsConflitoMultiplo;
        }
        else
        {            
            $periodoConflito = $linhaConflito['diaria_dt_saida']." / ".$linhaConflito['diaria_dt_chegada'];   
        }        
    }

    if(pg_num_rows($rsConflito) > 0)
    {
        $PossuiBloqueio = 1;

        $html = "<table width='100%' border='0' cellpadding='0' cellspacing='1'>
                    <tr class='dataLabelSemBold'>
                        <td class='MensagemErro'>&nbsp;CONFLITO - Já existe uma solicitação deste beneficiário neste período. Número da SD: ".$numeroConflito."  Período: ".$periodoConflito."</td>
                    </tr>
                </table>";
    }
}

if(pg_num_rows($rsBloqueio) > 2){
    $PossuiBloqueio = 1;

    $html = "<table width='100%' border='0' cellpadding='0' cellspacing='1'>
                <tr class='dataLabelSemBold'>
                    <td class='MensagemErro'>&nbsp;BLOQUEADO - Beneficiário com pendência de comprovação. Número(s) da(s) SD(s): ".$NumeroDiariaVirtual."</td>
                </tr>
            </table>";
}

If ($ContadorVirtual > 2)
{
    $PossuiBloqueio = 1;
    
    $html = "<table width='100%' border='0' cellpadding='0' cellspacing='1'>
                <tr class='dataLabelSemBold'>
                    <td class='MensagemErro'>&nbsp;BLOQUEADO - Beneficiário com comprovação pendente de documentação. Número(s) da(s) SD: ".$NumeroDiariaVirtual."</td>
                </tr>
            </table>";
}

If ($ContadorAtraso > 2)
{
    $PossuiBloqueio = 1;

    $html.= "<table width='100%' border='0' cellpadding='0' cellspacing='1'>
                <tr class='dataLabelSemBold'>
                    <td class='MensagemErro'>&nbsp;BLOQUEADO - Beneficiário com solicitação pendente de comprovação. Número(s) da(s) SD: ".$NumeroDiariaAtrasada."</td>
                </tr>
            </table>";
}

if($qtdSoma >= 180)
{
    $PossuiBloqueio = 1;
    
    $html.= " <table width='100%' border='0' cellpadding='0' cellspacing='1'>
                 <tr class='dataLabelSemBold'>
                     <td class='MensagemErro'>&nbsp;BLOQUEADO - O Beneficiário excedeu o limite anual de Diárias.</td>
                 </tr>
              </table> ";
}

if($qtdSomaMes >= 15)
{
    if($Beneficiario == 5894 || $Beneficiario == 2219 || $Beneficiario== 1217 || $Beneficiario==1225  ){
        if($qtdSomaMes >= 23){
            $PossuiBloqueio = 1;

            $html .= " <table width='100%' border='0' cellpadding='0' cellspacing='1'>
                 <tr class='dataLabelSemBold'>
                     <td class='MensagemErro'>&nbsp;BLOQUEADO - O Beneficiário excedeu o limite mensal de " . $qtdSomaMes . " Diárias.</td>
                 </tr>
              </table> ";
        }
    } elseif($Beneficiario == 5894 || $Beneficiario == 1427 || $Beneficiario == 5567){
        if($qtdSomaMes >= 20){
            $PossuiBloqueio = 1;

            $html .= " <table width='100%' border='0' cellpadding='0' cellspacing='1'>
                 <tr class='dataLabelSemBold'>
                     <td class='MensagemErro'>&nbsp;BLOQUEADO - O Beneficiário excedeu o limite mensal de " . $qtdSomaMes . " Diárias.</td>
                 </tr>
              </table> ";
        }
    }
    else {
        $PossuiBloqueio = 1;

        $html .= " <table width='100%' border='0' cellpadding='0' cellspacing='1'>
                 <tr class='dataLabelSemBold'>
                     <td class='MensagemErro'>&nbsp;BLOQUEADO - O Beneficiário excedeu o limite mensal de " . $qtdSomaMes . " Diárias2.</td>
                 </tr>
              </table> ";
    }
}

$html.= "<input type='hidden' id='txtBloqueio' name='txtBloqueio' style= 'width:35px;' class='Oculto' value = '".$PossuiBloqueio."' />
         <input type='hidden' id='QtdDiaria' name='QtdDiaria' value = '".$qtdSoma."' ></input>
         <input type='hidden' id='QtdDiariaMes' name='QtdDiariaMes' value = '".$qtdSomaMes."' ></input>";

print $html;
?>
