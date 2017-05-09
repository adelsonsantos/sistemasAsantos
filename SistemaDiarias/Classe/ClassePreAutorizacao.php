<?php
include "../Include/Inc_Configuracao.php";

$PaginaLocal = 'SolicitacaoPreAutorizacao';

$Roteiro = $_GET['roteiro'];
$diaria_tipo_local = "Coordenadoria";

if(empty($_GET['filtro'])== false)
{
    $retornoFiltro = $_GET['filtro'];
    
    if ($_SESSION['Administrador'] != 1) 
    {
        $idCoordenadoria   = $_SESSION['UsuarioCoordenadoria'];

        $sqlPreAutorizacao = "   SELECT diaria_id,
                                        diaria_numero,
                                        diaria_dt_saida,
                                        diaria_hr_saida,
                                        diaria_dt_chegada,
                                        diaria_hr_chegada,
                                        diaria_processo,
                                        diaria_st,
                                        pessoa_nm,
                                        diaria_unidade_custo,
                                        diaria_devolvida
                                   FROM diaria.diaria d, 
                                        dados_unico.funcionario f, 
                                        dados_unico.pessoa p 
                                  WHERE (p.pessoa_id = f.pessoa_id) 
                                    AND (d.diaria_beneficiario = f.pessoa_id) 
                                    AND diaria_st = 100 
                                    AND diaria_excluida = 0 
                                    AND diaria_local_solicitacao = '$diaria_tipo_local' 
                                    AND d.id_coordenadoria = $idCoordenadoria 
                                    AND diaria_cancelada = 0
                                    AND diaria_devolvida != 1
                                    AND (pessoa_nm ILIKE '%".$retornoFiltro."%' OR diaria_numero ILIKE '%".$retornoFiltro."%')
                               ORDER BY diaria_devolvida DESC, TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";
    }
    else 
    {
        $sqlPreAutorizacao = "   SELECT diaria_id,diaria_numero,diaria_dt_saida,
                                        diaria_hr_saida,diaria_dt_chegada,diaria_hr_chegada,
                                        diaria_processo,diaria_st,pessoa_nm,diaria_unidade_custo,diaria_devolvida 
                                   FROM diaria.diaria d, dados_unico.funcionario f,dados_unico.pessoa p 
                                  WHERE (p.pessoa_id = f.pessoa_id) 
                                    AND (d.diaria_beneficiario = f.pessoa_id) 
                                    AND diaria_st = 100 
                                    AND diaria_excluida = 0 
                                    AND diaria_local_solicitacao = '$diaria_tipo_local' 
                                    AND diaria_cancelada = 0 
                                    AND diaria_devolvida != 1
                                    AND (pessoa_nm ILIKE '%".$retornoFiltro."%' OR diaria_numero ILIKE '%".$retornoFiltro."%')
                               ORDER BY diaria_devolvida DESC, TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";
    }
}
else
{
    if ($_SESSION['Administrador'] != 1) 
    {
        $idCoordenadoria   = $_SESSION['UsuarioCoordenadoria'];

        $sqlPreAutorizacao = "   SELECT diaria_id,
                                        diaria_numero,
                                        diaria_dt_saida,
                                        diaria_hr_saida,
                                        diaria_dt_chegada,
                                        diaria_hr_chegada,
                                        diaria_processo,
                                        diaria_st,
                                        pessoa_nm,
                                        diaria_unidade_custo,
                                        diaria_devolvida
                                   FROM diaria.diaria d, 
                                        dados_unico.funcionario f, 
                                        dados_unico.pessoa p 
                                  WHERE (p.pessoa_id = f.pessoa_id) 
                                    AND (d.diaria_beneficiario = f.pessoa_id) 
                                    AND diaria_st = 100 
                                    AND diaria_excluida = 0 
                                    AND diaria_local_solicitacao = '$diaria_tipo_local' 
                                    AND d.id_coordenadoria = $idCoordenadoria 
                                    AND diaria_cancelada = 0 
                                    AND diaria_devolvida != 1
                               ORDER BY diaria_devolvida DESC, TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";
    }
    else 
    {
        $sqlPreAutorizacao = "   SELECT diaria_id,diaria_numero,diaria_dt_saida,
                                        diaria_hr_saida,diaria_dt_chegada,diaria_hr_chegada,
                                        diaria_processo,diaria_st,pessoa_nm,diaria_unidade_custo,diaria_devolvida 
                                   FROM diaria.diaria d, dados_unico.funcionario f,dados_unico.pessoa p 
                                  WHERE (p.pessoa_id = f.pessoa_id) 
                                    AND (d.diaria_beneficiario = f.pessoa_id) 
                                    AND diaria_st = 100 
                                    AND diaria_excluida = 0 
                                    AND diaria_local_solicitacao = '$diaria_tipo_local' 
                                    AND diaria_cancelada = 0 
                                    AND diaria_devolvida != 1
                               ORDER BY diaria_devolvida DESC, TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";
    }
}
$consultaPreAutorizacao = pg_query(abreConexao(),$sqlPreAutorizacao);
?>
