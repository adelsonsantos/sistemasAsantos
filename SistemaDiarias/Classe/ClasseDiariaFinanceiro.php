<?php

//define o nome da pagina local para facilitar nos links
$PaginaLocal = "SolicitacaoFinanceiro";

//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

if (($AcaoSistema == "buscar") || ($AcaoSistema == ""))
{
    if ($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Liquidante") 
    {
        $FiltroSQL = " AND (diaria_st = 3)";
    }
    elseif ($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "PreLiquidante") 
    {
        $FiltroSQL = " AND (diaria_st = 3)";
    }

    if ($RetornoFiltro != "") 
    {
        $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, dados_unico.pessoa_fisica pf WHERE (f.pessoa_id = pf.pessoa_id) AND d.diaria_excluida =0 AND  (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) " . $FiltroSQL . " AND diaria_devolvida = 0 AND diaria_cancelada = 0 AND (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR diaria_numero ILIKE '%" . $RetornoFiltro . "%') ORDER BY diaria_numero";
    }
    else 
    {
        $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, dados_unico.pessoa_fisica pf WHERE (f.pessoa_id = pf.pessoa_id) AND d.diaria_excluida =0 AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) " . $FiltroSQL . " AND diaria_devolvida = 0 AND diaria_cancelada = 0 ORDER BY diaria_numero";
    }

    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
    
} 
elseif ($AcaoSistema == "consultar") 
{
    $codigo = $_GET['cod'];
    
    $sqlConsulta     = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, dados_unico.pessoa_fisica pf WHERE (pf.pessoa_id = f.pessoa_id) AND (p.pessoa_id = f.pessoa_id) AND d.diaria_excluida =0 AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = " . $codigo;
    $rsConsulta      = pg_query(abreConexao(), $sqlConsulta);
    $linhaDiaria = pg_fetch_assoc($rsConsulta);

    If ($linhaDiaria)
    {
        $Numero          = $linhaDiaria['diaria_numero'];
        $PessoaCodigo    = $linhaDiaria['pessoa_id'];
        $Beneficiario    = $linhaDiaria['diaria_beneficiario'];
        $DataPartida     = $linhaDiaria['diaria_dt_saida'];
        $HoraPartida     = $linhaDiaria['diaria_hr_saida'];
        $DataChegada     = $linhaDiaria['diaria_dt_chegada'];
        $HoraChegada     = $linhaDiaria['diaria_hr_chegada'];
        $Desconto        = $linhaDiaria['diaria_desconto'];
        $Qtde            = $linhaDiaria['diaria_qtde'];
        $Valor           = $linhaDiaria['diaria_valor'];
        $ValorRef        = $linhaDiaria['diaria_valor_ref'];
        $UnidadeCusto    = $linhaDiaria['diaria_unidade_custo'];
        $Status          = $linhaDiaria['diaria_st'];
        $DataCriacao     = $linhaDiaria['diaria_dt_criacao'];
        $HoraCriacao     = $linhaDiaria['diaria_hr_criacao'];
        $Processo        = $linhaDiaria['diaria_processo'];
        $Empenho         = $linhaDiaria['diaria_empenho'];
        $DataEmpenho     = $linhaDiaria['diaria_dt_empenho'];
        $CPF             = $linhaDiaria['pessoa_fisica_cpf'];
        $Matricula       = $linhaDiaria['funcionario_matricula'];
        $Diaria_agrupada = $linhaDiaria['diaria_agrupada'];
        $Diaria_Super_SD = $linhaDiaria['super_sd'];

        $DataEmpenho     = f_FormataData($DataEmpenho);
    }
    If ($Status == 4) 
    {
        $sqlFinanceiro     = "SELECT * FROM diaria.diaria_financeiro WHERE diaria_id = " . $codigo;
        $rsFinanceiro      = pg_query(abreConexao(), $sqlFinanceiro);
        $linharsFinanceiro = pg_fetch_assoc($rsFinanceiro);

        $sqlPessoa = "SELECT pessoa_nm FROM dados_unico.pessoa p, dados_unico.funcionario f WHERE (f.pessoa_id = p.pessoa_id) and funcionario_id = " . $linharsFinanceiro['diaria_financeiro_preliquidante'];
        $rsPessoa  = pg_query(abreConexao(), $sqlPessoa);

        $DataObrigacao = $linharsFinanceiro['diaria_financeiro_dt_obrigacao'];
        $HoraObrigacao = $linharsFinanceiro['diaria_financeiro_hr_obrigacao'];
        $DataObrigacao = f_FormataData($DataObrigacao);
    }

    If ($Desconto == "N") 
    {
        $Desconto = "Não";
    }
    Else 
    {
        $Desconto = "Sim";
    }

    $sqlBanco = "SELECT * FROM dados_unico.banco b, dados_unico.dados_bancarios db WHERE (b.banco_id = db.banco_id) AND pessoa_id = " . $PessoaCodigo;
    $rsBanco  = pg_query(abreConexao(), $sqlBanco);
}
ElseIf ($AcaoSistema == "preliquidar") 
{
    $codigo        = $_POST['txtCodigo'];
    $DataObrigacao = $_POST['txtDataObrigacao'];
    $HoraObrigacao = $_POST['txtHoraObrigacao'];
    $Date          = date("Y-m-d");
    $Time          = date("H:i:s");
    $sqlAltera     = "UPDATE diaria.diaria SET diaria_st = 3 WHERE diaria_id = " . $codigo;

    pg_query(abreConexao(), $sqlAltera);

    $sqlConsulta     = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
    $rsConsulta      = pg_query(abreConexao(), $sqlConsulta);
    $linhaDiaria = pg_fetch_assoc($rsConsulta);

    $sqlInsere = "INSERT INTO diaria.diaria_financeiro (diaria_id, diaria_financeiro_dt_obrigacao, diaria_financeiro_hr_obrigacao, diaria_financeiro_preliquidante, diaria_preliquidacao_dt, diaria_preliquidacao_hr) VALUES (" . $codigo . ", '" . $DataObrigacao . "','" . $HoraObrigacao . "', " . $linhaDiaria['funcionario_id'] . ", '" . $Date . "', '" . $Time . "')";

    pg_query(abreConexao(), $sqlInsere);

    echo "<script>window.location = 'SolicitacaoFinanceiroInicio.php ';</script>";
}
ElseIf ($AcaoSistema == "liquidar") 
{
    $Date          = date("Y-m-d");
    $Time          = date("H:i:s");
    $codigo        = $_POST['txtCodigo'];
    $DataObrigacao = $_POST['txtDataObrigacao'];
    $HoraObrigacao = $_POST['txtHoraObrigacao'];

    $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 3 WHERE diaria_id = " . $codigo;
    pg_query(abreConexao(), $sqlAltera);

    $sqlConsulta     = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
    $rsConsulta      = pg_query(abreConexao(), $sqlConsulta);
    $linhaDiaria = pg_fetch_assoc($rsConsulta);

    $sqlAltera = "UPDATE diaria.diaria_financeiro SET diaria_financeiro_dt_obrigacao = '" . $DataObrigacao . "', diaria_financeiro_hr_obrigacao = '" . $HoraObrigacao . "',diaria_financeiro_liquidante = " . $linhaDiaria['funcionario_id'] . ",diaria_liquidacao_dt = '" . $Date . "',diaria_liquidacao_hr = '" . $Time . "'	WHERE diaria_id = " . $codigo;

    pg_query(abreConexao(), $sqlAltera);

    echo "<script>window.location = 'SolicitacaoFinanceiroInicio.php ';</script>";
}
ElseIf ($AcaoSistema == "executar") 
{
    $Date          = date("Y-m-d");
    $Time          = date("H:i:s");
    $codigo        = $_POST['txtCodigo'];
    $DataObrigacao = $_POST['txtData'];

    $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 4 WHERE diaria_id = " . $codigo;
    pg_query(abreConexao(), $sqlAltera);

    $sqlConsulta     = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
    $rsConsulta      = pg_query(abreConexao(), $sqlConsulta);
    $linhaDiaria = pg_fetch_assoc($rsConsulta);

    $sqlAltera = "UPDATE diaria.diaria_financeiro SET diaria_financeiro_dt_execucao = '" . $DataObrigacao . "',diaria_financeiro_executante = " . $linhaDiaria['funcionario_id'] . ", diaria_execucao_dt = '" . $Date . "',  diaria_execucao_hr = '" . $Time . "' WHERE diaria_id = " . $codigo;

    pg_query(abreConexao(), $sqlAltera);

    echo "<script>window.location = 'SolicitacaoFinanceiroInicio.php ';</script>";
}
?>
