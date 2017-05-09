<?php
include "../Include/Inc_Configuracao.php";

$dataInicio = $_GET['dataInicio'];
$dataFim    = $_GET['dataFim'];
$status     = $_GET['status'];

if(($_GET['diretoria'] != '')&&($_GET['diretoria'] != 0))
{
    $condicao = " AND diaria_unidade_custo =".$_GET['diretoria']." AND pedido_empenho <> 1 ";
    $filtro = "Diretoria: ".$_GET['dsDiretoria'];
}
else
{
    $condicao = " AND pedido_empenho <> 1 ";
    $filtro = "";
}

$sqlConsulta = "SELECT diaria_numero, diaria_dt_saida, diaria_hr_saida, diaria_dt_chegada, diaria_hr_chegada, diaria_empenho, diaria_valor, est_organizacional_sigla, pessoa_nm
                  FROM diaria.diaria d
                  JOIN dados_unico.est_organizacional est 
                    ON d.diaria_unidade_custo = est.est_organizacional_id
                  JOIN dados_unico.pessoa p
                    ON d.diaria_beneficiario = p.pessoa_id
                 WHERE diaria_st = '$status'
                   ".$condicao." 
                   AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') 
                        BETWEEN TO_DATE('$dataInicio', 'DD/MM/YYYY') 
                            AND TO_DATE('$dataFim', 'DD/MM/YYYY'))
              ORDER BY diaria_dt_saida, diaria_hr_saida";

$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
?>
