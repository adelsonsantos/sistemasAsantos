<?php

//define o nome da pagina local para facilitar nos links
$PaginaLocal = "SolicitacaoAgruparDiaria";
//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

// se a página foi recarregada com projeto informado
if(isset ($_GET['p'])){
    // codigo que sera exibido selecionado
    $codigoEscolhido = $_GET['p'];
    
    // se a fonte foi selecionada
    if(isset ($_GET['f'])){
        // fonte que será exibida selecionada
        $fonteEscolhida = $_GET['f'];
        // visibilidade do combo de fonte
        $display="block";
        
        $sqlConsulta = "SELECT 
                            * 
                        FROM 
                            diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p
                        WHERE 
                            (p.pessoa_id = f.pessoa_id) AND 
                            (d.diaria_beneficiario = f.pessoa_id) AND 
                            diaria_st = 2 AND
                            diaria_cancelada = 0 AND
                            diaria_excluida = 0 AND
                            diaria_indvidual = 0 AND
                            diaria_devolvida = 0 AND
                            projeto_cd = ".$codigoEscolhido." AND
                            fonte_cd = '".$fonteEscolhida."'
                        ORDER BY 
                            diaria_dt_saida DESC, diaria_hr_saida ASC";

        $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
    } else{
        $display ="none";
    }
} else {
    $display = "none";
}

/* * *************************************************
 * ***************** A��o BUSCAR* *******************
 * ************************************************* */

If (($AcaoSistema == "buscar")) {
    if ($_GET['atributo'] != '') {
        $cod = $_GET['atributo'];

        if ($cod == "diaria_dt_criacao") {
            $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 2 AND diaria_excluida = 0 AND diaria_cancelada = 0 AND (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR diaria_numero ILIKE '%" . $RetornoFiltro . "%') ORDER BY extract(month From  " . $_GET['atributo'] . ") DESC , extract(day  From " . $_GET['atributo'] . ") ASC ";
            $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
        } else {
            $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND diaria_st = 2 AND diaria_excluida = 0 AND diaria_cancelada = 0 AND (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR diaria_numero ILIKE '%" . $RetornoFiltro . "%') ORDER BY " . $_GET['atributo'] . " ASC";
            $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
        }
    }
}

/* * *************************************************
 * ***************** A��o CONSULTAR *******************
 * ************************************************* */
 ElseIf ($AcaoSistema == "consultar") {
    $Codigo = $_GET['cod'];

    $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = " . $Codigo;
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
}

/* * *************************************************
 * ***************** A��o EMPENHAR *******************
 * ************************************************* */
elseif ($AcaoSistema == "empenhar") {
    $Codigo = $_POST['txtCodigo'];
    $Empenho = $_POST['txtEmpenho'];
    $DataEmpenho = $_POST['txtDataEmpenho'];
    $Numero_diaria = $_POST['txtNumeroDiaria'];

    $sql = "Select diaria_processo from diaria.diaria where diaria_id = $Codigo";
    $rsConsulta = pg_query(abreConexao(), $sql);
    $tupla = pg_fetch_assoc($rsConsulta);
    $processo_diaria = $tupla['diaria_processo'];

    if ($processo_diaria == "") {
        $Processo_diaria = f_NumeroProcesso($Numero_diaria);

        $sqlAltera = "UPDATE diaria.diaria SET  diaria_devolvida = 0,
                                            diaria_empenho = '" . $Empenho . "',
                                            diaria_dt_empenho = '" . $DataEmpenho . "',
                                            diaria_processo = '" . $Processo_diaria . "',
                                            diaria_hr_empenho = '" . date("H:i:s") . "',                                            
                                            diaria_empenho_pessoa_id = '" . $_SESSION['UsuarioCodigo'] . "'
                                            WHERE diaria_id = " . $Codigo;
    } else {
        $sqlAltera = "UPDATE diaria.diaria SET  diaria_devolvida = 0,
                                            diaria_empenho = '" . $Empenho . "',
                                            diaria_dt_empenho = '" . $DataEmpenho . "',                                           
                                            diaria_hr_empenho = '" . date("H:i:s") . "',                                            
                                            diaria_empenho_pessoa_id = '" . $_SESSION['UsuarioCodigo'] . "'
                                            WHERE diaria_id = " . $Codigo;
    }
    // echo  $sqlAltera;
    pg_query(abreConexao(), $sqlAltera);

    echo "<script>";
    echo "alert('Dados GRAVADOS com sucesso. Para finalizar LIBERE o empenho.')";
    echo "</script>";
    echo "<script>window.location = 'SolicitacaoGestaoInicio.php ';</script>";
}
?>
