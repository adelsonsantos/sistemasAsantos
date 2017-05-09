<?php
include "../../Include/Inc_Configuracao.php";

$mes    = $_POST['mes'];
$dia    = $_POST['dia'];
$ano    = $_POST['ano'];
$mesAnt = $mes - 1;
$anoAnt = $ano - 1;

//VERIFICA O SALDO QUE NÃO FOI UTILIZADO NO MÊS ANTERIOR

$sqlConsultaSaldoAnt = "SELECT id_saldo,id_saldo_projeto,id_saldo_fonte,saldo_mes,saldo_valor,saldo_valor_inicial,DATE_PART('YEAR', data_criacao) AS ano
                          FROM diaria.saldo_projeto_fonte
                         WHERE saldo_mes = ".$mesAnt."
                           AND saldo_st <> 2  
                           AND DATE_PART('YEAR', data_criacao) = '".$ano."'";

$rsSaldoAnt    = pg_query(abreConexao(), $sqlConsultaSaldoAnt);
$linhaSaldoAnt = pg_fetch_assoc($rsSaldoAnt);

if(($mes > 1)&&($mes <= 12))
{
    //VERIFICA O SALDO DO MÊS ATUAL
    while($linhaSaldoAnt = pg_fetch_assoc($rsSaldoAnt)) 
    {
        $sqlConsultaSaldo = "SELECT id_saldo,id_saldo_projeto,id_saldo_fonte,saldo_mes,saldo_valor,saldo_valor_inicial
                               FROM diaria.saldo_projeto_fonte
                              WHERE saldo_mes = ".$mes."
                                AND DATE_PART('YEAR', data_criacao) = '$ano' 
                                AND saldo_st = 0  
                                AND id_saldo_projeto = ".$linhaSaldoAnt['id_saldo_projeto']."
                                AND id_saldo_fonte = '".$linhaSaldoAnt['id_saldo_fonte']."'";


        $rsSaldo    = pg_query(abreConexao(), $sqlConsultaSaldo);
        $linhaSaldo = pg_fetch_assoc($rsSaldo);

        if(($linhaSaldo != '')&&($linhaSaldoAnt['saldo_valor'] > 0))
        {
            $saldoAtualizado = $linhaSaldo['saldo_valor'] + $linhaSaldoAnt['saldo_valor'];

            $insereSaldo = "UPDATE diaria.saldo_projeto_fonte 
                               SET saldo_valor = ".$saldoAtualizado.",
                                   saldo_st = 1
                             WHERE id_saldo_projeto = ".$linhaSaldo['id_saldo_projeto']."
                               AND id_saldo_fonte = '".$linhaSaldo['id_saldo_fonte']."'  
                               AND DATE_PART('YEAR', data_criacao) = '$ano'    
                               AND saldo_mes =".$mes;

            pg_query(abreConexao(), $insereSaldo);
            
            $insereSaldoAnt = "UPDATE diaria.saldo_projeto_fonte 
                                  SET saldo_valor = 0,
                                      saldo_st = 3
                                WHERE id_saldo_projeto = ".$linhaSaldo['id_saldo_projeto']."
                                  AND id_saldo_fonte = '".$linhaSaldo['id_saldo_fonte']."'  
                                  AND DATE_PART('YEAR', data_criacao) = '$ano'
                                  AND saldo_mes =".$mesAnt;
            
            pg_query(abreConexao(), $insereSaldoAnt);
        }
    }
}
else
{
    if($linhaSaldoAnt == '')
    {
        $insereSaldo = " UPDATE diaria.saldo_projeto_fonte 
                            SET saldo_st = 2
                          WHERE DATE_PART('YEAR', data_criacao) = '".$anoAnt."'";
    }
}
?>
