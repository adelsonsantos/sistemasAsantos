<?php

//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

//define o nome da pagina local para facilitar nos links
$PaginaLocal = "SolicitacaoDiariaAgrupadaExecucao";


/**
 * Retorna array de objetos Diaria que estejam informadas no grupo recbido como parametro
 * @param String $stringId <p>String contendo id das Diárias a ser buscadas separadas por vírgula.<br/>Ex:'1111,2222,1234'</p>
 * @return Array[Object] <p>Array de objetos Diária retornado da base de dados</p>
 */
function consultaDiariasPorGrupoId($stringId){
    $retorno = array();
    $sql = "SELECT d.diaria_id, d.diaria_numero
            FROM diaria.diaria d
            WHERE d.diaria_id in ($stringId)";
    
    $query = pg_query(abreConexao(), $sql);
    if($query){
        for($x=0;$x<pg_num_rows($query);$x++){
            $retorno[$x] = pg_fetch_object($query);
        }
    }
    return $retorno;
}

/**
 * Retorna os números de SD dos agrupamentos de diárias que não estejam canceladas, excluidas e devolvidas
 * @return array <p> Array de objetos</p>
 */
function consultaAgrupamentos(){
    $retorno = array();
    $sql = "SELECT 
               DISTINCT super_sd, diaria_processo, projeto_cd, fonte_cd
            FROM 
                diaria.diaria d
            WHERE 
                diaria_st = 3 AND
                diaria_cancelada = 0 AND
                diaria_excluida = 0 AND
                diaria_agrupada = 1
            ORDER BY super_sd";

    $query = pg_query(abreConexao(), $sql);
    if($query){
        for($x=0;$x<pg_num_rows($query);$x++){
            $retorno[$x] = pg_fetch_object($query);
        }
    }
    return $retorno;
}

/**
 * Retorna todas as diárias de um agrupamento
 * @param String $super_sd <p>Número da Solitação de um agrupamento</p>
 * @return array[object] <p>Array de diárias que pertencem ao agrupamento</p>
 */
function consultaDiariasAgrupadasPorSD($super_sd){
    $retorno = array();
    $sql = "SELECT 
                * 
            FROM 
                diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p
            WHERE 
                (p.pessoa_id = f.pessoa_id) AND 
                (d.diaria_beneficiario = f.pessoa_id) AND 
                diaria_st = 3 AND
                diaria_cancelada = 0 AND
                diaria_excluida = 0 AND
                diaria_agrupada = 1 AND
                super_sd = '".$super_sd."'";

    $query = pg_query(abreConexao(), $sql);
    if($query){
        for($x=0;$x<pg_num_rows($query);$x++){
            $retorno[$x] = pg_fetch_object($query);
        }
    }
   return $retorno;
}




// ******************* AÇÕES DO SISTEMA PARA EXECUÇÃO ************************* //

/**
 * Ação executada quando o parametro de ação GET for ssd
 * @param String $superSD <p>Número da Solitação de um agrupamento.<br>Será passado como parametro para a função consultaDiariasAgrupadasPorSD()</p>
 * @return array[object] <p>Array de diárias que pertencem ao agrupamento</p>
 */
function acaoSSD($superSD) {
    // se foi informado um agrupamento, consulta todas as diárias deste agrupamento
    if (isset($superSD)) {
        return consultaDiariasAgrupadasPorSD($superSD);
    }
}

/**
 * Busca diária que condiz com parametro recebido
 * @param String $Filtro <p>Parametro de busca nome do beneficiário ou número da SD</p>
 * @return query <p>Resultado da Consulta</p> 
 */
function acaoBuscar($Filtro) {
    if ($Filtro != "") {
        $where = " AND (pessoa_nm ILIKE '%" . $Filtro . "%' OR diaria_numero ILIKE '%" . $Filtro . "%')";
    } else {
        $where = "";
    }
    $sqlConsulta = "SELECT * 
                    FROM 
                        diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, dados_unico.pessoa_fisica pf 
                    WHERE 
                        (f.pessoa_id = pf.pessoa_id) AND 
                        (p.pessoa_id = f.pessoa_id) AND 
                        (d.diaria_beneficiario = f.pessoa_id) AND 
                        diaria_st = 3 AND
                        diaria_devolvida = 0 AND 
                        diaria_cancelada = 0 AND 
                        diaria_agrupada = 1 
                        $where 
                    ORDER BY diaria_numero";
    return pg_query(abreConexao(), $sqlConsulta);
}

function acaoConsultar($Codigo) {
    // Busca dados financeiros da diária
    $sqlFinanceiro      = "SELECT * FROM diaria.diaria_financeiro WHERE diaria_id = " . $Codigo;
    $rsFinanceiro       = pg_query(abreConexao(), $sqlFinanceiro);
    $linharsFinanceiro  = pg_fetch_assoc($rsFinanceiro);

    // Busca dados do Beneficiário
    $sqlConsulta = "SELECT * 
                    FROM 
                        diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, dados_unico.pessoa_fisica pf 
                    WHERE 
                        (pf.pessoa_id = f.pessoa_id) AND 
                        (p.pessoa_id = f.pessoa_id) AND 
                        (d.diaria_beneficiario = f.pessoa_id) AND 
                        d.diaria_id = " . $Codigo;
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
    $linhaConsulta = pg_fetch_assoc($rsConsulta);
    
    // Se forem encontrados os dados do beneficiário
    If ($linhaConsulta) {
        $Numero             = $linhaConsulta['diaria_numero'];
        $PessoaCodigo       = $linhaConsulta['pessoa_id'];
        $Beneficiario       = $linhaConsulta['diaria_beneficiario'];
        $DataPartida        = $linhaConsulta['diaria_dt_saida'];
        $HoraPartida        = $linhaConsulta['diaria_hr_saida'];
        $DataChegada        = $linhaConsulta['diaria_dt_chegada'];
        $HoraChegada        = $linhaConsulta['diaria_hr_chegada'];
        $Desconto           = $linhaConsulta['diaria_desconto'];
        $Qtde               = $linhaConsulta['diaria_qtde'];
        $Valor              = $linhaConsulta['diaria_valor'];
        $ValorRef           = $linhaConsulta['diaria_valor_ref'];
        $UnidadeCusto       = $linhaConsulta['diaria_unidade_custo'];
        $Status             = $linhaConsulta['diaria_st'];
        $DataCriacao        = $linhaConsulta['diaria_dt_criacao'];
        $HoraCriacao        = $linhaConsulta['diaria_hr_criacao'];
        $Processo           = $linhaConsulta['diaria_processo'];
        $Empenho            = $linhaConsulta['diaria_empenho'];
        $DataEmpenho        = $linhaConsulta['diaria_dt_empenho'];
        $CPF                = $linhaConsulta['pessoa_fisica_cpf'];
        $Matricula          = $linhaConsulta['funcionario_matricula'];
        $DiariaComprovada   = $linhaConsulta['diaria_comprovada'];
        $DataEmpenho        = f_FormataData($DataEmpenho);
        $DataObrigacao      = $linharsFinanceiro['diaria_financeiro_dt_obrigacao'];
        $DataObrigacao      = f_FormataData($DataObrigacao);
        $Diaria_agrupada    = $linhaConsulta['diaria_agrupada'];
        $Diaria_Super_SD    = $linhaConsulta['super_sd'];

        If ($Desconto == "N") {
            $Desconto = "N&atilde;o";
        } Else {
            $Desconto = "Sim";
        }
        // busca os dados bancarios do Beneficiário
        $sqlBanco = "SELECT * 
                     FROM dados_unico.banco b, dados_unico.dados_bancarios db 
                     WHERE (b.banco_id = db.banco_id) AND pessoa_id = " . $PessoaCodigo;
        $rsBanco = pg_query(abreConexao(), $sqlBanco);
    }
}

function acaoExecutar($Codigo,$DataObrigacao) {
    $Date           = date("Y-m-d");
    $Time           = date("H:i:s");

    $sql_grupo          = "Select diaria_agrupada,super_sd from diaria.diaria where diaria_id = $Codigo";
    $consulta           = pg_query(abreConexao(), $sql_grupo);
    $tupla              = pg_fetch_assoc($consulta);
    $diaria_agrupada    = $tupla['diaria_agrupada'];
    $Super_SD           = $tupla['super_sd'];

    if ($diaria_agrupada == 0) {

        $sql1 = "SELECT diaria_comprovada FROM diaria.diaria d WHERE d.diaria_id = " . $Codigo;
        $rs1 = pg_query(abreConexao(), $sql1);
        $linhars1 = pg_fetch_assoc($rs1);
        $DiariaComprovada = $linhars1['diaria_comprovada'];

        if ($DiariaComprovada == "1") {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 5 WHERE diaria_id = " . $Codigo;
            pg_query(abreConexao(), $sqlAltera);
        } else {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 4 WHERE diaria_id = " . $Codigo;
            pg_query(abreConexao(), $sqlAltera);
        }

        $sqlConsulta = "SELECT funcionario_id 
                        FROM dados_unico.funcionario 
                        WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
        $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
        $linhaConsulta = pg_fetch_assoc($rsConsulta);
        /* Pré-Liquidar */
        $DataObrigacao = $_POST['txtDataPreLiquidar'];
        $HoraObrigacao = $_POST['txtHoraPreLiquidar'];
        $sqlInsere = "INSERT INTO diaria.diaria_financeiro ( 
                        diaria_id, 
                        diaria_financeiro_dt_obrigacao, 
                        diaria_financeiro_hr_obrigacao, 
                        diaria_financeiro_preliquidante, 
                        diaria_preliquidacao_dt, 
                        diaria_preliquidacao_hr 
                      ) VALUES (
                        " . $Codigo . ",
                        '" . $DataObrigacao . "',
                        '" . $HoraObrigacao . "',
                        " . $linhaConsulta['funcionario_id'] . ",
                        '" . $Date . "',
                        '" . $Time . "')";
        pg_query(abreConexao(), $sqlInsere);

        /* Liquidar */
        $DataObrigacao = $_POST['txtDataLiquidar'];
        $HoraObrigacao = $_POST['txtHoraLiquidar'];
        $sqlAltera = "UPDATE 
                        diaria.diaria_financeiro 
                     SET 
                        diaria_financeiro_dt_obrigacao = '" . $DataObrigacao . "',	
                        diaria_financeiro_hr_obrigacao = '" . $HoraObrigacao . "',
                        diaria_financeiro_liquidante   = " . $linhaConsulta['funcionario_id'] . ",
                        diaria_liquidacao_dt = '" . $Date . "',
                        diaria_liquidacao_hr = '" . $Time . "'	
                     WHERE 
                        diaria_id = " . $Codigo;
        pg_query(abreConexao(), $sqlAltera);

        $DataObrigacao = $_POST['txtData'];
        $sqlAltera = "UPDATE 
                        diaria.diaria_financeiro 
                      SET 
                        diaria_financeiro_dt_execucao = '" . $DataObrigacao . "', 
                        diaria_financeiro_executante = " . $linhaConsulta['funcionario_id'] . ", 
                        diaria_execucao_dt = '" . $Date . "', 
                        diaria_execucao_hr = '" . $Time . "' 
                      WHERE diaria_id = " . $Codigo;

        pg_query(abreConexao(), $sqlAltera);
        echo "<script>alert('Execução feita com Sucesso!!!');</script>";
        echo "<script>window.location = 'SolicitacaoFinanceiroExecucaoInicio.php ';</script>";
    } else {

        $Sql = "Select diaria_id from diaria.diaria where super_sd = '$Super_SD'";
        $Consulta = pg_query(abreConexao(), $Sql);

        while ($tupla = pg_fetch_assoc($Consulta)) {
            //*** Tabela Diária ***** ////
            $Codigo = $tupla['diaria_id'];
            $sql1 = "SELECT diaria_comprovada FROM diaria.diaria d WHERE d.diaria_id = " . $Codigo;
            $rs1 = pg_query(abreConexao(), $sql1);
            $linhars1 = pg_fetch_assoc($rs1);
            $DiariaComprovada = $linhars1['diaria_comprovada'];

            if ($DiariaComprovada == "1") {
                $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 5 WHERE diaria_id = " . $Codigo;
                pg_query(abreConexao(), $sqlAltera);
            } else {
                $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 4 WHERE diaria_id = " . $Codigo;
                pg_query(abreConexao(), $sqlAltera);
            }

            $sqlConsulta = "SELECT funcionario_id 
                            FROM dados_unico.funcionario 
                            WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
            $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
            $linhaConsulta = pg_fetch_assoc($rsConsulta);
            /* Pré-Liquidar */
            $DataObrigacao = $_POST['txtDataPreLiquidar'];
            $HoraObrigacao = $_POST['txtHoraPreLiquidar'];
            $sqlInsere = "INSERT INTO diaria.diaria_financeiro ( 
                                diaria_id, 
                                diaria_financeiro_dt_obrigacao, 
                                diaria_financeiro_hr_obrigacao, 
                                diaria_financeiro_preliquidante, 
                                diaria_preliquidacao_dt, 
                                diaria_preliquidacao_hr 
                          ) VALUES (
                                " . $Codigo . ",
                                '" . $DataObrigacao . "',
                                '" . $HoraObrigacao . "',
                                 " . $linhaConsulta['funcionario_id'] . ",
                                '" . $Date . "',
                                '" . $Time . "')";
            pg_query(abreConexao(), $sqlInsere);

            /* Liquidar */
            $DataObrigacao = $_POST['txtDataLiquidar'];
            $HoraObrigacao = $_POST['txtHoraLiquidar'];
            $sqlAltera = "UPDATE 
                            diaria.diaria_financeiro 
                          SET diaria_financeiro_dt_obrigacao = '" . $DataObrigacao . "',	
                            diaria_financeiro_hr_obrigacao = '" . $HoraObrigacao . "',
                            diaria_financeiro_liquidante   = " . $linhaConsulta['funcionario_id'] . ",
                            diaria_liquidacao_dt = '" . $Date . "',
                            diaria_liquidacao_hr = '" . $Time . "'	
                         WHERE diaria_id = " . $Codigo;
            pg_query(abreConexao(), $sqlAltera);

            $DataObrigacao = $_POST['txtData'];
            $sqlAltera = "UPDATE 
                            diaria.diaria_financeiro 
                          SET 
                            diaria_financeiro_dt_execucao = '" . $DataObrigacao . "', 
                            diaria_financeiro_executante = " . $linhaConsulta['funcionario_id'] . ", 
                            diaria_execucao_dt = '" . $Date . "', 
                            diaria_execucao_hr = '" . $Time . "' 
                          WHERE diaria_id = " . $Codigo;

            pg_query(abreConexao(), $sqlAltera);
        }
        echo "<script>alert('Execução feita com Sucesso!!!');</script>";
        echo "<script>window.location = 'SolicitacaoFinanceiroExecucaoInicio.php ';</script>";
    }
}

function acaoExecutarTodas(){
    $Date = date("Y-m-d");
    $Time = date("H:i:s");
    $DataObrigacao = $Date;
    $HoraObrigacao = $Time;
    $sql = "SELECT diaria_id,diaria_comprovada FROM diaria.diaria d WHERE d.diaria_id in ($Codigo)";
    $rs = pg_query(abreConexao(), $sql);

    while ($linhars = pg_fetch_assoc($rs)) {

        $Diaria_Id = $linhars['diaria_id'];
        $DiariaComprovada = $linhars['diaria_comprovada'];

        if ($DiariaComprovada == "1") {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 5 WHERE diaria_id = " . $Diaria_Id;
            pg_query(abreConexao(), $sqlAltera);
        } else {
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 4 WHERE diaria_id = " . $Diaria_Id;
            pg_query(abreConexao(), $sqlAltera);
        }

        $sqlConsulta = "SELECT funcionario_id 
                        FROM dados_unico.funcionario 
                        WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
        $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
        $linhaConsulta = pg_fetch_assoc($rsConsulta);
        /* Pré-Liquidar */
        $sqlInsere = "INSERT INTO diaria.diaria_financeiro ( 
                        diaria_id, 
                        diaria_financeiro_dt_obrigacao, 
                        diaria_financeiro_hr_obrigacao, 
                        diaria_financeiro_preliquidante, 
                        diaria_preliquidacao_dt, 
                        diaria_preliquidacao_hr 
                      ) VALUES (
                        ".$Diaria_Id.",
                        '".$DataObrigacao."',
                        '".$HoraObrigacao."',
                        ".$linhaConsulta['funcionario_id'].",
                        '".$Date."',
                        '".$Time."')";
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
    echo "<script>alert('Execução feita com Sucesso!!!');</script>";
    echo "<script>window.location = 'SolicitacaoFinanceiroExecucaoInicio.php ';</script>";
}




If (($AcaoSistema == "buscar") || ($AcaoSistema == "")) {

} ElseIf ($AcaoSistema == "consultar") {

    $Codigo = $_GET['cod'];
    
} else if ($AcaoSistema == "executar") {
    $Codigo         = $_POST['txtCodigo'];
    $DataObrigacao  = $_POST['txtData'];
    
} /* * **** Ação que executa todas as Diárias selecionadas para serem executadas de uma unica vez ******** */ 
else if ($AcaoSistema == "ExecutarTodasDiarias") {

    $Codigo = $_GET['Codigos'];
    
}

if($AcaoSistema){
    switch ($AcaoSistema) {
        case "ssd"      : $diariasAgrupadas = acaoSSD($_GET['ssd']);
            break;
        case "buscar"   : $rsConsulta = acaoBuscar($RetornoFiltro);
            break;
        case "consultar": $rsConsulta = acaoConsultar($_GET['cod']);
            break;
        case "executar" : $rsConsulta = acaoExecutar($_POST['txtCodigo'], $_POST['txtData']);
            break;
        case "ExecutarTodasDiarias": 
            break;
        default: $agrupamentos = consultaAgrupamentos();
            break;
    }
} else {
    $agrupamentos = consultaAgrupamentos();
}
?>
