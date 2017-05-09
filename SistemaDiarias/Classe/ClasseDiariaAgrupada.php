<?php

//define o nome da pagina local para facilitar nos links
$PaginaLocal = "SolicitacaoDiariaAgrupada";
//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

// Limpa o POST para exibir todos agrupamentos depois de ter consultado todas as diárias de um único agrupamento.
if(!isset ($_GET)){
    unset ($_POST);
}

/**
 * Desagrupa diárias informadas e gera numero de processo individual
 * @param array<object> $arrayDiarias <p>Array de Diarias a ser desagrupadas</p>
 * @return boolean <p>Se todas as diárias forem atualizadas retorna <b>true</b>, senão retorna <b>false</b></p>
 */
function desagruparDiarias($arrayDiarias){
    if(empty ($arrayDiarias)){
        return false;
    }
    
    for ($index = 0; $index < count($arrayDiarias); $index++) {
        $sql = "UPDATE 
                    diaria.diaria
		SET 
                    super_sd = '0', diaria_agrupada = 0, diaria_processo = '".f_NumeroProcesso($arrayDiarias[$index]->diaria_numero)."'
		WHERE 
                    diaria_id = ".$arrayDiarias[$index]->diaria_id;
        
        if(!pg_query(abreConexao(),$sql)){
            return false;
        }
        
        $sql2 = "UPDATE 
                    diaria.diaria_aprovacao
		SET 
                    imp_processo_st = '0', diaria_imprimir_processo = '0'
		WHERE 
                    diaria_id = ".$arrayDiarias[$index]->diaria_id;
        
        if(!pg_query(abreConexao(),$sql2)){
            return false;
        }
    }
    return true;
}

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
               DISTINCT super_sd, diaria_processo, projeto_cd, fonte_cd, diaria_unidade_custo
            FROM 
                diaria.diaria d
            WHERE 
                diaria_st = 2 AND
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
                diaria_st = 2 AND
                diaria_cancelada = 0 AND
                diaria_excluida = 0 AND
                diaria_agrupada = 1 AND
                super_sd = '".$super_sd."'
            ORDER BY 
                diaria_dt_saida DESC, diaria_hr_saida ASC";

    $query = pg_query(abreConexao(), $sql);
    if($query){
        for($x=0;$x<pg_num_rows($query);$x++){
            $retorno[$x] = pg_fetch_object($query);
        }
    }
   return $retorno;
}

/** AÇÕES DO SISTEMA **/

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
 * Ação executada para buscar Diárias na base de dados ordenada por um parametro
 * @param String $cod <p>Parametro que será consultado na base de dados</p>
 * @return Query <p></p>
 */
function acaoBuscar($cod){
    if ($cod != '') {
        if ($cod == "diaria_dt_criacao") {
            $sqlConsulta = "SELECT
                                * 
                            FROM 
                                diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p 
                            WHERE 
                                (p.pessoa_id = f.pessoa_id) AND 
                                (d.diaria_beneficiario = f.pessoa_id) AND 
                                diaria_st = 2 AND 
                                diaria_excluida = 0 AND 
                                diaria_cancelada = 0 AND 
                                (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR diaria_numero ILIKE '%" . $RetornoFiltro . "%') 
                            ORDER BY extract(month From  " . $_GET['atributo'] . ") DESC , extract(day  From " . $_GET['atributo'] . ") ASC ";
            $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
        } else {
            $sqlConsulta = "SELECT 
                                * 
                            FROM 
                                diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p 
                            WHERE 
                                (p.pessoa_id = f.pessoa_id) AND 
                                (d.diaria_beneficiario = f.pessoa_id) AND 
                                diaria_st = 2 AND 
                                diaria_excluida = 0 AND 
                                diaria_cancelada = 0 AND 
                                (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR diaria_numero ILIKE '%" . $RetornoFiltro . "%') 
                            ORDER BY " . $_GET['atributo'] . " ASC";
            $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
        }
    }
    return $rsConsulta;
}
/**
 * Ação executada para consultar uma diaria a partir do código
 */
function acaoConsultar($Codigo) {
    $sqlConsulta = "SELECT 
                        * 
                    FROM 
                        diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p 
                    WHERE (p.pessoa_id = f.pessoa_id) AND 
                        (d.diaria_beneficiario = f.pessoa_id) AND 
                        d.diaria_id = " . $Codigo;
    return pg_query(abreConexao(), $sqlConsulta);
}

function acaoEmpenhar(){
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

        $sqlAltera = "UPDATE 
                        diaria.diaria 
                      SET 
                        diaria_devolvida = 0,
                        diaria_empenho = '" . $Empenho . "',
                        diaria_dt_empenho = '" . $DataEmpenho . "',
                        diaria_processo = '" . $Processo_diaria . "',
                        diaria_hr_empenho = '" . date("H:i:s") . "',                                            
                        diaria_empenho_pessoa_id = '" . $_SESSION['UsuarioCodigo'] . "'
                      WHERE 
                        diaria_id = " . $Codigo;
    } else {
        $sqlAltera = "UPDATE 
                        diaria.diaria 
                      SET 
                        diaria_devolvida = 0,
                        diaria_empenho = '" . $Empenho . "',
                        diaria_dt_empenho = '" . $DataEmpenho . "',                                           
                        diaria_hr_empenho = '" . date("H:i:s") . "',                                            
                        diaria_empenho_pessoa_id = '" . $_SESSION['UsuarioCodigo'] . "'
                      WHERE 
                        diaria_id = " . $Codigo;
    }
    pg_query(abreConexao(), $sqlAltera);

    echo "<script>";
    echo "alert('Dados GRAVADOS com sucesso. Para finalizar LIBERE o empenho.')";
    echo "</script>";
    echo "<script>window.location = 'SolicitacaoGestaoInicio.php ';</script>";
}


/**
 * Verifica se foi informada alguma ação
 */
   
if(isset ($AcaoSistema)){
    
    // verifica qual ação será executada
    switch ($AcaoSistema) {
        
        // se for desagrupar
        case "desagrupar":
            $desagrupado = desagruparDiarias(consultaDiariasPorGrupoId($_GET['d']));
            if($desagrupado){?>
                <script>
                    alert('Di\u00E1rias desagrupadas com sucesso.');
                    window.location = 'SolicitacaoDiariaAgrupadaInicio.php ';
                </script>
            <?php
            } else { ?>
                <script>
                    alert('Ocorreu um imprevisto no desagrupamento das di\u00E1rias.\nFavor verificar se o desagrupamento foi realizado conforme esperado');
                    window.location = 'SolicitacaoDiariaAgrupadaInicio.php ';
                </script>
            <?php
            }
            break;
        
        //se for consultar um agrupamento
        case "ssd":
            $agrupamentos = acaoSSD($_GET['ssd']);
            break;
        case "buscar":
            $rsConsulta = acaoBuscar($_GET['atributo']);
            break;
        case "consultar":
            $rsConsulta = acaoConsultar($_GET['cod']);
            break;
        case "empenhar":
            acaoEmpenhar();
            break;
        default:
            $agrupamentos = consultaAgrupamentos();
            break;
    }
} else{
    $agrupamentos = consultaAgrupamentos();
}

?>
