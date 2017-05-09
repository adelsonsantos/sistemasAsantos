<?php
// define a pagina local para fins de especificação quando for utilizar componentes genéricos
$PaginaLocal   = "SolicitacaoImprimirProcesso";
$RetornoFiltro = $_GET['filtro'];
$cod           = $_GET['cod'];
$AcaoSistema   = $_GET['acao'];

if($_GET['orderby'] == null)
{
    $_GET['orderby'] = 'ASC';
}
else
{    
    if($_GET['orderby'] != 'ASC')
    {
        $_GET['orderby'] = 'ASC';             
    }
    else
    {
        $_GET['orderby'] = 'DESC';        
    }    
}

if (isset ($AcaoSistema))
{
    if ($AcaoSistema == "buscar")
    {
        $rsConsulta = acaoBuscar($_GET['atributo'],$_GET['orderby']);                                
    }
} 
else 
{
   $rsConsulta = acaoConsultar($RetornoFiltro);
}

function acaoConsultar($RetornoFiltro)
{
    // verifica se foi informado algum filtro de busca
    if ($RetornoFiltro != "") 
    {
        $condicao = " AND (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR diaria_numero ILIKE '%" . $RetornoFiltro . "%') ";
    }
    else
    {
        $condicao = "";
    }

    if ($_SESSION['Administrador'] != 1)
    {
        $sqlConsulta = "SELECT d.diaria_id,
                               d.diaria_numero, 
                               d.diaria_dt_saida, 
                               d.diaria_hr_saida, 
                               d.diaria_dt_chegada, 
                               d.diaria_hr_chegada, 
                               d.diaria_processo, 
                               d.diaria_st, 
                               pessoa_nm, 
                               d.diaria_unidade_custo, 
                               imp_processo_st, 
                               d.diaria_dt_criacao, 
                               d.diaria_hr_criacao  
                        FROM diaria.diaria d 
                        JOIN dados_unico.funcionario f 
                           ON d.diaria_beneficiario = f.pessoa_id 
                        JOIN dados_unico.pessoa p 
                           ON p.pessoa_id = f.pessoa_id 
                        JOIN diaria.diaria_aprovacao ap 
                           ON d.diaria_id = ap.diaria_id 
                        WHERE d.diaria_cancelada = 0 
                        AND d.diaria_excluida = 0 
                        AND d.diaria_agrupada = 0 
                        AND diaria_st = 2 
                        AND diaria_unidade_custo 
                           IN(
                                SELECT est_organizacional_id FROM diaria.autorizador_acp WHERE pessoa_id = ".$_SESSION['UsuarioCodigo']."
                             )  
                        ".$condicao."
                        AND ap.aprovacao_final = true 
                        ORDER BY imp_processo_st, diaria_dt_saida DESC";
    }
    else
    {
        $sqlConsulta = "SELECT d.diaria_id,
                               d.diaria_numero, 
                               d.diaria_dt_saida, 
                               d.diaria_hr_saida, 
                               d.diaria_dt_chegada, 
                               d.diaria_hr_chegada, 
                               d.diaria_processo, 
                               d.diaria_st, 
                               pessoa_nm, 
                               d.diaria_unidade_custo, 
                               imp_processo_st, 
                               d.diaria_dt_criacao, 
                               d.diaria_hr_criacao  
                        FROM diaria.diaria d 
                        JOIN dados_unico.funcionario f 
                           ON d.diaria_beneficiario = f.pessoa_id 
                        JOIN dados_unico.pessoa p 
                           ON p.pessoa_id = f.pessoa_id 
                        JOIN diaria.diaria_aprovacao ap 
                           ON d.diaria_id = ap.diaria_id 
                        WHERE d.diaria_cancelada = 0
                        AND d.diaria_excluida = 0 
                        AND d.diaria_agrupada = 0 
                        AND diaria_st = 2 
                        ".$condicao."
                        AND ap.aprovacao_final = true 
                        ORDER BY imp_processo_st, diaria_dt_saida DESC";           
    }            
    return pg_query(abreConexao(),$sqlConsulta);	
}	

function acaoBuscar($atributo,$ordenacao)
{       
    if($atributo == 'diaria_dt_saida')
    {
        $atributo = ",TO_DATE(diaria_dt_saida,'DD/MM/YYYY') ".$ordenacao;
    }
    elseif($atributo == 'diaria_dt_criacao')
    {
        $atributo = ",diaria_dt_criacao ".$ordenacao;
    }
    elseif($atributo == 'pessoa_nm')
    {
        $atributo = ",pessoa_nm ".$ordenacao;
    }   
    elseif($atributo == 'diaria_numero')
    {
        $atributo = ",pessoa_nm ".$ordenacao;
    }
    
    if ($_SESSION['Administrador'] != 1)
    {
        $sqlConsulta = "SELECT d.diaria_id,
                                   d.diaria_numero, 
                                   d.diaria_dt_saida, 
                                   d.diaria_hr_saida, 
                                   d.diaria_dt_chegada, 
                                   d.diaria_hr_chegada, 
                                   d.diaria_processo, 
                                   d.diaria_st, 
                                   pessoa_nm, 
                                   d.diaria_unidade_custo, 
                                   imp_processo_st, 
                                   d.diaria_dt_criacao, 
                                   d.diaria_hr_criacao  
                            FROM diaria.diaria d 
                            JOIN dados_unico.funcionario f 
                               ON d.diaria_beneficiario = f.pessoa_id 
                            JOIN dados_unico.pessoa p 
                               ON p.pessoa_id = f.pessoa_id 
                            JOIN diaria.diaria_aprovacao ap 
                               ON d.diaria_id = ap.diaria_id 
                            WHERE d.diaria_cancelada = 0 
                            AND d.diaria_excluida = 0 
                            AND d.diaria_agrupada = 0 
                            AND diaria_st = 2 
                            AND diaria_unidade_custo
                             IN (SELECT est_organizacional_id FROM diaria.autorizador_acp WHERE pessoa_id = ".$_SESSION['UsuarioCodigo'].")  
                       ORDER BY imp_processo_st ".$atributo;
    }
    else
    {
        $sqlConsulta = "SELECT d.diaria_id,
                                   d.diaria_numero, 
                                   d.diaria_dt_saida, 
                                   d.diaria_hr_saida, 
                                   d.diaria_dt_chegada, 
                                   d.diaria_hr_chegada, 
                                   d.diaria_processo, 
                                   d.diaria_st, 
                                   pessoa_nm, 
                                   d.diaria_unidade_custo, 
                                   imp_processo_st, 
                                   d.diaria_dt_criacao, 
                                   d.diaria_hr_criacao  
                            FROM diaria.diaria d 
                            JOIN dados_unico.funcionario f 
                               ON d.diaria_beneficiario = f.pessoa_id 
                            JOIN dados_unico.pessoa p 
                               ON p.pessoa_id = f.pessoa_id 
                            JOIN diaria.diaria_aprovacao ap 
                               ON d.diaria_id = ap.diaria_id 
                            WHERE d.diaria_cancelada = 0 
                            AND d.diaria_excluida = 0 
                            AND d.diaria_agrupada = 0 
                            AND diaria_st = 2  
                       ORDER BY imp_processo_st ".$atributo;
    }    
    return pg_query(abreConexao(), $sqlConsulta);    
}
?>
