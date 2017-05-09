<?php
//include "../Include/Inc_FuncaoDiarias.php";
//define o nome da pagina local para facilitar nos links
$PaginaLocal = "SolicitacaoAprovacao";

//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

$Roteiro = $_GET['roteiro'];


If (($AcaoSistema == "buscar") || ($AcaoSistema == "")) 
{
    If ($RetornoFiltro != "")
    {
        $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 1 AND diaria_devolvida = 0 AND diaria_cancelada = 0 AND diaria_excluida = 0 AND (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR diaria_numero ILIKE '%" . $RetornoFiltro . "%') ORDER BY diaria_dt_saida DESC, diaria_hr_saida ASC";
    } 
    Else 
    {
        $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 1 AND diaria_devolvida = 0 AND diaria_cancelada = 0 AND diaria_excluida = 0 ORDER BY diaria_dt_saida DESC, diaria_hr_saida ASC";
    }

    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
}
ElseIf ($AcaoSistema == "aprovar") 
{
    $Date = date("Y-m-d");
    $Codigo = $_GET['cod'];
    $Time = date("H:i:s");

    $sql = "Select diaria_numero from diaria.diaria where diaria_id = $Codigo";
    $consulta = pg_query(abreConexao(), $sql);
    $tupla = pg_fetch_assoc($consulta);
    $numeroSD = $tupla['diaria_numero'];

    $numeroProcesso = f_NumeroProcesso($numeroSD);

    $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 2, diaria_processo = '$numeroProcesso' WHERE diaria_id IN (" . $Codigo . ")";
    pg_query(abreConexao(), $sqlAltera);
    
    if ($_SESSION['Administrador'] != 1) 
    {
        $sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
    }
    else
    {
        $sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario";
    }
    
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);

    $rsConsulta = pg_fetch_assoc($rsConsulta);

    // altera os registros anteriores para false no campo aprovacao_final caso haja aprovação anterior para a mesma diária
    $sqlAtualiza = "UPDATE diaria.diaria_aprovacao SET aprovacao_final = false WHERE diaria_id=" . $Codigo;
    pg_query(abreConexao(), $sqlAtualiza);

    //grava nova aprovação
    $diaria_imprimir_processo = 1;
    $sqlInsere = "INSERT INTO diaria.diaria_aprovacao (diaria_id, diaria_aprovacao_func, diaria_aprovacao_func_exec, diaria_aprovacao_dt, diaria_aprovacao_hr,diaria_imprimir_processo) VALUES (" . $Codigo . ", " . $rsConsulta['funcionario_id'] . ", 1,'" . $Date . "', '" . $Time . "'," . $diaria_imprimir_processo . ")";

    pg_query(abreConexao(), $sqlInsere);

    echo "<script>window.location = 'SolicitacaoAprovacaoInicio.php ';</script>";
}
?>
