<?php
include "../Include/Inc_Configuracao.php";
// Definindo Pagina Local
$Codigo        = $_GET['cod'];
$RetornoFiltro = $_GET['filtro'];

if ($_GET['pagina'] == "") 
{
    $PaginaLocal = "SolicitacaoFinanceiroExecucao";
} 
else 
{
    $PaginaLocal = $_GET['pagina'];
}

//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;
If (($AcaoSistema == "buscar") || ($AcaoSistema == "")) 
{    
    If ($RetornoFiltro != "") 
    {
        $sqlConsulta = "SELECT * 
                           FROM diaria.diaria d
                           JOIN dados_unico.pessoa p
                             ON d.diaria_beneficiario = p.pessoa_id
                          WHERE diaria_devolvida = 0 
                            AND diaria_cancelada = 0 
                            AND diaria_agrupada = 0 
                            AND diaria_excluida = 0
                            AND diaria_st = 3
                            AND (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' 
                             OR diaria_numero ILIKE '%" . $RetornoFiltro . "%')
                       ORDER BY diaria_numero";
    }
    Else 
    {
        $sqlConsulta = " SELECT * 
                           FROM diaria.diaria d
                           JOIN dados_unico.pessoa p
                             ON d.diaria_beneficiario = p.pessoa_id
                          WHERE diaria_devolvida = 0 
                            AND diaria_cancelada = 0 
                            AND diaria_agrupada = 0 
                            AND diaria_excluida = 0
                            AND diaria_st = 3
                       ORDER BY diaria_numero";            
    }
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
} 
ElseIf ($AcaoSistema == "consultar") 
{
    $Codigo = $_GET['cod'];
    $sqlConsulta = " SELECT * 
                     FROM diaria.diaria d
                     JOIN dados_unico.funcionario f
                       ON d.diaria_beneficiario = f.pessoa_id
                     JOIN dados_unico.pessoa p
                       ON p.pessoa_id = f.pessoa_id
                     JOIN dados_unico.pessoa_fisica pf 
                       ON pf.pessoa_id = f.pessoa_id
                    WHERE d.diaria_id = " . $Codigo;   
        
    $rsConsulta    = pg_query(abreConexao(), $sqlConsulta);
    $linhaConsulta = pg_fetch_assoc($rsConsulta);

    If ($linhaConsulta) 
    {
        $Numero           = $linhaConsulta['diaria_numero'];
        $PessoaCodigo     = $linhaConsulta['pessoa_id'];
        $Beneficiario     = $linhaConsulta['diaria_beneficiario'];
        $DataPartida      = $linhaConsulta['diaria_dt_saida'];
        $HoraPartida      = $linhaConsulta['diaria_hr_saida'];
        $DataChegada      = $linhaConsulta['diaria_dt_chegada'];
        $HoraChegada      = $linhaConsulta['diaria_hr_chegada'];
        $Desconto         = $linhaConsulta['diaria_desconto'];
        $Qtde             = $linhaConsulta['diaria_qtde'];
        $Valor            = $linhaConsulta['diaria_valor'];
        $ValorRef         = $linhaConsulta['diaria_valor_ref'];
        $UnidadeCusto     = $linhaConsulta['diaria_unidade_custo'];
        $Status           = $linhaConsulta['diaria_st'];
        $DataCriacao      = $linhaConsulta['diaria_dt_criacao'];
        $HoraCriacao      = $linhaConsulta['diaria_hr_criacao'];
        $Processo         = $linhaConsulta['diaria_processo'];
        $Empenho          = $linhaConsulta['diaria_empenho'];
        $DataEmpenho      = $linhaConsulta['diaria_dt_empenho'];
        $CPF              = $linhaConsulta['pessoa_fisica_cpf'];
        $Matricula        = $linhaConsulta['funcionario_matricula'];
        $DiariaComprovada = $linhaConsulta['diaria_comprovada'];
        
        $DataEmpenho      = f_FormataData($DataEmpenho);
        $DataCriacao      = f_FormataData($DataCriacao);
        
        
        $sqlFinanceiro     = "SELECT * FROM diaria.diaria_financeiro WHERE diaria_id = " . $Codigo;
        $rsFinanceiro      = pg_query(abreConexao(), $sqlFinanceiro);       
        $linharsFinanceiro = pg_fetch_assoc($rsFinanceiro);
        
        $DataObrigacao     = $linharsFinanceiro['diaria_financeiro_dt_obrigacao'];
        $DataObrigacao     = f_FormataData($DataObrigacao);

        // Acresecentados por Erinaldo em 28/04/2011
        $Diaria_agrupada   = $linhaConsulta['diaria_agrupada'];
        $Diaria_Super_SD   = $linhaConsulta['super_sd'];

        If ($Desconto == "N") 
        {
            $Desconto = "N&atilde;o";
        }
        Else 
        {
            $Desconto = "Sim";
        }

        $sqlBanco = "SELECT * FROM dados_unico.banco b, dados_unico.dados_bancarios db WHERE (b.banco_id = db.banco_id) AND pessoa_id = " . $PessoaCodigo;
        $rsBanco  = pg_query(abreConexao(), $sqlBanco);
    }
} 
else if ($AcaoSistema == "executar") 
{
    $Codigo         = $_POST['txtCodigo'];
    $DataObrigacao  = $_POST['txtData'];
    $Date           = date("Y-m-d");
    $Time           = date("H:i:s");

    $sql_grupo  = "Select diaria_agrupada,super_sd from diaria.diaria where diaria_id = $Codigo";
    $consulta   = pg_query(abreConexao(), $sql_grupo);
    $tupla      = pg_fetch_assoc($consulta);
    
    $diaria_agrupada = $tupla['diaria_agrupada'];
    $Super_SD        = $tupla['super_sd'];

    if ($diaria_agrupada == 0)
    {
        $sql1     = "SELECT diaria_comprovada FROM diaria.diaria d WHERE d.diaria_id = " . $Codigo;
        $rs1      = pg_query(abreConexao(), $sql1);
        $linhars1 = pg_fetch_assoc($rs1);
        
        $DiariaComprovada = $linhars1['diaria_comprovada'];

        if ($DiariaComprovada == "1") 
        {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 5 WHERE diaria_id = " . $Codigo;
            pg_query(abreConexao(), $sqlAltera);
        }
        else 
        {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 4 WHERE diaria_id = " . $Codigo;
            pg_query(abreConexao(), $sqlAltera);
        }

        $sqlConsulta   = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
        $rsConsulta    = pg_query(abreConexao(), $sqlConsulta);
        $linhaConsulta = pg_fetch_assoc($rsConsulta);
        /* Pré-Liquidar */
        $DataObrigacao = $_POST['txtDataPreLiquidar'];
        $HoraObrigacao = $_POST['txtHoraPreLiquidar'];
        $sqlInsere     = "INSERT INTO diaria.diaria_financeiro 
                                      (diaria_id, 
                                       diaria_financeiro_dt_obrigacao, 
                                       diaria_financeiro_hr_obrigacao, 
                                       diaria_financeiro_preliquidante, 
                                       diaria_preliquidacao_dt, 
                                       diaria_preliquidacao_hr 
                                       )
                                VALUES (" . $Codigo . ",
                                        '" . $DataObrigacao . "',
                                        '" . $HoraObrigacao . "',
                                        " . $linhaConsulta['funcionario_id'] . ",
                                        '" . $Date . "',
                                        '" . $Time . "')";
        
        pg_query(abreConexao(), $sqlInsere);

        /* Liquidar */
        $DataObrigacao = $_POST['txtDataLiquidar'];
        $HoraObrigacao = $_POST['txtHoraLiquidar'];
        $sqlAltera = "UPDATE diaria.diaria_financeiro 
                         SET diaria_financeiro_dt_obrigacao = '" . $DataObrigacao . "',	
                             diaria_financeiro_hr_obrigacao = '" . $HoraObrigacao . "',
                             diaria_financeiro_liquidante   = " . $linhaConsulta['funcionario_id'] . ",
                             diaria_liquidacao_dt = '" . $Date . "',
                             diaria_liquidacao_hr = '" . $Time . "'	
                       WHERE diaria_id = " . $Codigo;
        
        pg_query(abreConexao(), $sqlAltera);

        $DataObrigacao = $_POST['txtData'];
        $sqlAltera     = "UPDATE diaria.diaria_financeiro 
                             SET diaria_financeiro_dt_execucao = '" . $DataObrigacao . "',
                                 diaria_financeiro_executante = " . $linhaConsulta['funcionario_id'] . ",
                                 diaria_execucao_dt = '" . $Date . "',
                                 diaria_execucao_hr = '" . $Time . "'
                           WHERE diaria_id = " . $Codigo;

        pg_query(abreConexao(), $sqlAltera);
        echo "<script>alert('Execução realizada com Sucesso!!!');</script>";
        echo "<script>window.location = 'SolicitacaoFinanceiroExecucaoInicio.php ';</script>";
    } 
    else 
    {
        $Sql      = "Select diaria_id from diaria.diaria where super_sd = '$Super_SD'";
        $Consulta = pg_query(abreConexao(), $Sql);

        while ($tupla = pg_fetch_assoc($Consulta)) 
        {
            //*** Tabela Diária ***** ////
            $Codigo     = $tupla['diaria_id'];
            $sql1       = "SELECT diaria_comprovada FROM diaria.diaria d WHERE d.diaria_id = " . $Codigo;
            $rs1        = pg_query(abreConexao(), $sql1);
            $linhars1   = pg_fetch_assoc($rs1);
            
            $DiariaComprovada = $linhars1['diaria_comprovada'];

            if ($DiariaComprovada == "1") 
            {
                $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 5 WHERE diaria_id = " . $Codigo;
                pg_query(abreConexao(), $sqlAltera);
            }
            else 
            {
                $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 4 WHERE diaria_id = " . $Codigo;
                pg_query(abreConexao(), $sqlAltera);
            }

            $sqlConsulta   = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
            $rsConsulta    = pg_query(abreConexao(), $sqlConsulta);
            $linhaConsulta = pg_fetch_assoc($rsConsulta);
            /* Pré-Liquidar */
            $DataObrigacao = $_POST['txtDataPreLiquidar'];
            $HoraObrigacao = $_POST['txtHoraPreLiquidar'];
            
            $sqlInsere     = "INSERT INTO diaria.diaria_financeiro 
                                          (diaria_id, 
                                           diaria_financeiro_dt_obrigacao, 
                                           diaria_financeiro_hr_obrigacao, 
                                           diaria_financeiro_preliquidante, 
                                           diaria_preliquidacao_dt, 
                                           diaria_preliquidacao_hr 
                                          )
                                   VALUES (" . $Codigo . ",
                                           '" . $DataObrigacao . "',
                                           '" . $HoraObrigacao . "',
                                           " . $linhaConsulta['funcionario_id'] . ",
                                           '" . $Date . "',
                                           '" . $Time . "'
                                          )";
            
            pg_query(abreConexao(), $sqlInsere);

            /* Liquidar */
            $DataObrigacao = $_POST['txtDataLiquidar'];
            $HoraObrigacao = $_POST['txtHoraLiquidar'];
            
            $sqlAltera = "UPDATE diaria.diaria_financeiro 
                             SET diaria_financeiro_dt_obrigacao = '" . $DataObrigacao . "',	
                                 diaria_financeiro_hr_obrigacao = '" . $HoraObrigacao . "',
				 diaria_financeiro_liquidante   = " . $linhaConsulta['funcionario_id'] . ",
				 diaria_liquidacao_dt = '" . $Date . "',
				 diaria_liquidacao_hr = '" . $Time . "'	
                           WHERE diaria_id = " . $Codigo;
            
            pg_query(abreConexao(), $sqlAltera);

            $DataObrigacao = $_POST['txtData'];
            
            $sqlAltera     = "UPDATE diaria.diaria_financeiro 
                                 SET diaria_financeiro_dt_execucao = '" . $DataObrigacao . "', 
                                     diaria_financeiro_executante = " . $linhaConsulta['funcionario_id'] . ", 
                                     diaria_execucao_dt = '" . $Date . "', 
                                     diaria_execucao_hr = '" . $Time . "' 
                               WHERE diaria_id = " . $Codigo;

            pg_query(abreConexao(), $sqlAltera);
        }
        echo "<script>alert('Execução realizada com Sucesso!!!');</script>";
        echo "<script>window.location = 'SolicitacaoFinanceiroExecucaoInicio.php ';</script>";
    }
} /* * **** Ação que executa todas as Diárias selecionadas para serem executadas de uma unica vez ******** */ 
else if ($AcaoSistema == "ExecutarTodasDiarias") 
{
    $Codigo        = $_GET['Codigos'];
    $Date          = date("Y-m-d");
    $Time          = date("H:i:s");
    $DataObrigacao = $Date;
    $HoraObrigacao = $Time;
    
    $sql           = "SELECT diaria_id,diaria_comprovada FROM diaria.diaria d WHERE d.diaria_id in ($Codigo)";
    $rs            = pg_query(abreConexao(), $sql);

    while ($linhars = pg_fetch_assoc($rs)) 
    {
        $Diaria_Id        = $linhars['diaria_id'];
        $DiariaComprovada = $linhars['diaria_comprovada'];

        if ($DiariaComprovada == "1") 
        {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 5 WHERE diaria_id = " . $Diaria_Id;
            pg_query(abreConexao(), $sqlAltera);
        }
        else 
        {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 4 WHERE diaria_id = " . $Diaria_Id;
            pg_query(abreConexao(), $sqlAltera);
        }

        $sqlConsulta   = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
        $rsConsulta    = pg_query(abreConexao(), $sqlConsulta);
        $linhaConsulta = pg_fetch_assoc($rsConsulta);
        /* Pré-Liquidar */
        $sqlInsere     = "INSERT INTO diaria.diaria_financeiro 
                                      ( diaria_id, 
					diaria_financeiro_dt_obrigacao, 
					diaria_financeiro_hr_obrigacao, 
					diaria_financeiro_preliquidante, 
					diaria_preliquidacao_dt, 
					diaria_preliquidacao_hr 
                                       ) 
                                VALUES (" . $Diaria_Id . ",
                                        '" . $DataObrigacao . "',
                                        '" . $HoraObrigacao . "',
                                        " . $linhaConsulta['funcionario_id'] . ",
                                        '" . $Date . "',
                                        '" . $Time . "'
                                       )";
        //echo $sqlInsere."<br>";
        pg_query(abreConexao(), $sqlInsere);

        /* Liquidar */
        $sqlAltera = "UPDATE diaria.diaria_financeiro 
                         SET diaria_financeiro_dt_obrigacao = '" . $DataObrigacao . "',	
                             diaria_financeiro_hr_obrigacao = '" . $HoraObrigacao . "',
                             diaria_financeiro_liquidante   = " . $linhaConsulta['funcionario_id'] . ",
                             diaria_liquidacao_dt = '" . $Date . "',
                             diaria_liquidacao_hr = '" . $Time . "'	
                       WHERE diaria_id = " . $Diaria_Id;
        //echo $sqlAltera."<br>";
        pg_query(abreConexao(), $sqlAltera);

        $sqlAltera = "UPDATE diaria.diaria_financeiro
                         SET diaria_financeiro_dt_execucao = '$DataObrigacao',
                             diaria_financeiro_executante = " . $linhaConsulta['funcionario_id'] . ",
                             diaria_execucao_dt = '$Date', diaria_execucao_hr = '$Time'
                       WHERE diaria_id = " . $Diaria_Id;

        //echo $sqlAltera."<br>";				
        pg_query(abreConexao(), $sqlAltera);
    }
    echo "<script>alert('Execução realizada com Sucesso!!!');</script>";
    echo "<script>window.location = 'SolicitacaoFinanceiroExecucaoInicio.php ';</script>";
}
?>
