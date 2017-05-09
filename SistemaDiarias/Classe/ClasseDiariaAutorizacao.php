<?php
//define o nome da pagina local para facilitar nos links

if ($_GET['pagina'] == "")
{ 
    $PaginaLocal = "SolicitacaoAutorizacao";
}
else 
{
    $PaginaLocal = $_GET['pagina'];		
}	

//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;
$_SESSION['OrigemPagina']   = "SolicitacaoAutorizacao";


$Roteiro = $_GET['roteiro'];

if (($AcaoSistema == "buscar")||($AcaoSistema == ""))
{
    if ($_SESSION['Administrador'] != 1) 
    {
        if ($RetornoFiltro != "")
        {
            $and = " AND (pessoa_nm ILIKE '%".$RetornoFiltro."%' OR diaria_numero ILIKE '%".$RetornoFiltro."%') ";
        }
        else
        {
            $and = " ";            
        }
        
        if ($_GET['atributo']!='')
        {
            $orderBy = " ORDER BY diaria_devolvida DESC, extract(month From  ".$_GET['atributo'].") DESC , extract(day  From ".$_GET['atributo'].") ASC ";
        }
        else
        {
            $orderBy = " ORDER BY diaria_devolvida DESC, TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC ";
        }
        
        $sqlConsulta ="SELECT * 
                         FROM diaria.diaria d 
                         JOIN dados_unico.pessoa p ON p.pessoa_id = d.diaria_beneficiario 
                        WHERE diaria_unidade_custo 
                              IN(
                                 SELECT est_organizacional_id
                                   FROM diaria.autorizador_acp acp 
                                  WHERE pessoa_id = ".$_SESSION['UsuarioCodigo']."
                                )
                        AND diaria_st = 0 
                        AND diaria_cancelada = 0 
                        AND diaria_excluida = 0 
                        AND diaria_devolvida != 1
                        ".$and
                        .$orderBy;
    }
    else
    {
        if ($RetornoFiltro != "")
        {
            $and = " AND (pessoa_nm ILIKE '%".$RetornoFiltro."%' OR diaria_numero ILIKE '%".$RetornoFiltro."%') ";
        }
        else
        {
            $and = " ";            
        }
        
        if ($_GET['atributo']!='')
        {
            $orderBy = " ORDER BY diaria_devolvida DESC, extract(month From  ".$_GET['atributo'].") DESC , extract(day  From ".$_GET['atributo'].") ASC ";
        }
        else
        {
            $orderBy = " ORDER BY diaria_devolvida DESC, TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC ";
        }
        
        $sqlConsulta ="SELECT * 
                             FROM diaria.diaria d
                             JOIN dados_unico.pessoa p 
                               ON p.pessoa_id = d.diaria_beneficiario                            
                            WHERE date_part('Year', diaria_dt_criacao) NOT IN (2011,2010)
                              AND diaria_st = 0 
                              AND diaria_cancelada = 0 
                              AND diaria_excluida = 0 
                              AND diaria_devolvida != 1 
                              ".$and
                              .$orderBy;
    }			
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
}

ElseIf ($AcaoSistema == "autorizar")
{
    $Date       = date("Y-m-d");
    $Codigo     = $_GET['cod'];
    $Time       = date("H:i:s");
    $sqlAltera  = "UPDATE diaria.diaria SET diaria_st = 1, diaria_devolvida = 0 WHERE diaria_id IN (" .$Codigo. ")";
    pg_query(abreConexao(),$sqlAltera);

    $sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " .$_SESSION['UsuarioCodigo'];

    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    $linha      = pg_fetch_assoc($rsConsulta);
    $sqlInsere  = "INSERT INTO diaria.diaria_autorizacao (diaria_id, diaria_autorizacao_func, diaria_autorizacao_func_exec, diaria_autorizacao_dt, diaria_autorizacao_hr) VALUES (" .$Codigo. ", " .$linha['funcionario_id'].", 1, '" .$Date."', '" .$Time. "')";

    pg_query(abreConexao(),$sqlInsere);

    echo "<script>alert(\"Diária Autorizada com Sucesso.!!!\");</script>";	
    echo "<script>window.location = 'SolicitacaoAutorizacaoInicio.php ';</script>";
}
?>
