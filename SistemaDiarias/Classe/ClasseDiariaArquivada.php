<?php

if ($_GET['pagina'] == "")
{ 
    $PaginaLocal = "SolicitacaoArquivada";
}
else 
{
    $PaginaLocal = $_GET['pagina'];		
}	
If (($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
{
    if ($_SESSION['Administrador'] != 1) 
    {
        If ($RetornoFiltro != "")
        {
                $sqlConsulta = "SELECT diaria_id,
                                        diaria_numero,
                                        diaria_solicitante,
                                        diaria_beneficiario,
                                        diaria_dt_saida,
                                        diaria_hr_saida,
                                        diaria_dt_chegada,
                                        diaria_hr_chegada,
                                        diaria_processo,
                                        diaria_st,
                                        diaria_comprovada,
                                        pessoa_nm 
                                FROM dados_unico.pessoa p
                                JOIN dados_unico.funcionario f
                                ON f.pessoa_id = p.pessoa_id
                                JOIN diaria.diaria d
                                ON d.diaria_beneficiario = p.pessoa_id
                                WHERE (diaria_beneficiario = " .$_SESSION['UsuarioCodigo']. " OR diaria_solicitante = " .$_SESSION['UsuarioCodigo']. ") AND diaria_excluida = 0 AND (diaria_st = 7) AND (pessoa_nm ILIKE '%" .$RetornoFiltro. "%' OR diaria_numero ILIKE '%" .$RetornoFiltro. "%') ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC";
        }
        Else
        {	$sqlConsulta = "SELECT diaria_id,
                                        diaria_numero,
                                        diaria_solicitante,
                                        diaria_beneficiario,
                                        diaria_dt_saida,
                                        diaria_hr_saida,
                                        diaria_dt_chegada,
                                        diaria_hr_chegada,
                                        diaria_processo,
                                        diaria_st,
                                        diaria_comprovada,
                                        pessoa_nm 
                                FROM dados_unico.pessoa p
                                JOIN dados_unico.funcionario f
                                ON f.pessoa_id = p.pessoa_id
                                JOIN diaria.diaria d
                                ON d.diaria_beneficiario = p.pessoa_id
                                WHERE (diaria_beneficiario = " .$_SESSION['UsuarioCodigo']. " OR diaria_solicitante = " .$_SESSION['UsuarioCodigo']. ") AND diaria_excluida = 0 AND (diaria_st = 7)  ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC";
        }		
    }
    else
    {
        If ($RetornoFiltro != "")
        {
                $sqlConsulta = "SELECT diaria_id,
                                        diaria_numero,
                                        diaria_solicitante,
                                        diaria_beneficiario,
                                        diaria_dt_saida,
                                        diaria_hr_saida,
                                        diaria_dt_chegada,
                                        diaria_hr_chegada,
                                        diaria_processo,
                                        diaria_st,
                                        diaria_comprovada,
                                        pessoa_nm 
                                FROM dados_unico.pessoa p
                                JOIN dados_unico.funcionario f
                                ON f.pessoa_id = p.pessoa_id
                                JOIN diaria.diaria d
                                ON d.diaria_beneficiario = p.pessoa_id
                                WHERE diaria_excluida = 0 AND (diaria_st = 7) AND (pessoa_nm ILIKE '%" .$RetornoFiltro. "%' OR diaria_numero ILIKE '%" .$RetornoFiltro. "%') ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC";
        }
        Else
        {	$sqlConsulta = "SELECT diaria_id,
                                        diaria_numero,
                                        diaria_solicitante,
                                        diaria_beneficiario,
                                        diaria_dt_saida,
                                        diaria_hr_saida,
                                        diaria_dt_chegada,
                                        diaria_hr_chegada,
                                        diaria_processo,
                                        diaria_st,
                                        diaria_comprovada,
                                        pessoa_nm 
                                FROM dados_unico.pessoa p
                                JOIN dados_unico.funcionario f
                                ON f.pessoa_id = p.pessoa_id
                                JOIN diaria.diaria d
                                ON d.diaria_beneficiario = p.pessoa_id
                                WHERE diaria_excluida = 0 AND (diaria_st = 7) AND date_part('Year', diaria_dt_criacao) = '".date('Y')."' ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC";
        }
    }
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
}
?>
