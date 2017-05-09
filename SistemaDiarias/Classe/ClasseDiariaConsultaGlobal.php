<?php
$PaginaLocal = "SolicitacaoConsultaGlobal";

$StatusSolicitacao = $_GET['Status'];
$AnoSolicitacao    = $_GET['ano'];

if ($StatusSolicitacao == "")
{
    $StatusSolicitacao= 0;
    $PesquisaDevolvida= 0;
}

if ($StatusSolicitacao == 9)
{
    $PesquisaDevolvida = 0;
    $PesquisaExcluida  = 1;
    $StatusSolicitacao = 0;
}
elseif ($StatusSolicitacao == 8)
{
    $PesquisaDevolvida = 1;
    $PesquisaExcluida  = 0;
    $StatusSolicitacao = 0;
}
else
{
    $PesquisaExcluida  = 0;
    $PesquisaDevolvida = 0;
}

if(($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
{
    if($RetornoFiltro != "")
    {
        $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) and (pessoa_nm ILIKE '%" .$RetornoFiltro. "%' OR diaria_numero ILIKE '%" .$RetornoFiltro."%') and diaria_numero like '%".$AnoSolicitacao."%' ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC";
    }
    else
    {
        if(($PesquisaExcluida == 1)&&($PesquisaDevolvida == 0))
        {
            $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_excluida = ".$PesquisaExcluida." and diaria_numero like '%".$AnoSolicitacao."%' ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC";
        }
        elseif(($PesquisaExcluida == 0)&&($PesquisaDevolvida == 1))
        {
            $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id)  AND diaria_devolvida = ".$PesquisaDevolvida." and diaria_numero like '%".$AnoSolicitacao."%' ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC";
        }
        else
        {
            $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id)  AND diaria_excluida = 0 and (diaria_st = ".$StatusSolicitacao.") and diaria_numero like '%".$AnoSolicitacao."%'  ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC";
        }
    }

    if($PesquisaExcluida == 1)
    {
        $StatusSolicitacao = 12;
    }
    elseif ($PesquisaDevolvida == 1)
    {
        $StatusSolicitacao = 11;
    }

    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
}

?>
