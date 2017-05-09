<?php

//define o nome da pagina local para facilitar nos links
$PaginaLocal = "SolicitacaoDiariaAgrupadaEmpenho";
//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

// Limpa o POST para exibir todos agrupamentos depois de ter consultado todas as diárias de um único agrupamento.
if(!isset ($_GET)){
    unset ($_POST);
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
               DISTINCT super_sd, diaria_processo, projeto_cd, fonte_cd, diaria_devolvida 
            FROM 
                diaria.diaria d, diaria.diaria_aprovacao a
            WHERE 
                diaria_st = 2 AND
                diaria_cancelada = 0 AND
                diaria_excluida = 0 AND
                diaria_agrupada = 1 AND
                d.diaria_id = a.diaria_id AND
                imp_processo_st = 1 AND
                aprovacao_final = true
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
                diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, diaria.diaria_aprovacao da
            WHERE 
                (p.pessoa_id = f.pessoa_id) AND 
                (d.diaria_beneficiario = f.pessoa_id) AND 
                diaria_st IN (2,6) AND
                d.diaria_id = da.diaria_id AND 
                da.imp_processo_st = 1 AND 
                da.aprovacao_final = true AND
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

/**
 * Consulta os Ids das Diárias de um Grupo
 * @param String $super_sd <p>Número de SD do Grupo</p>
 * @return String <p>ids das diárias do agrupamento separadas por vírgula</p>
 */
function consultaIdDiariasPorSD($super_sd){
    $retorno = "";
    $sql = "SELECT 
                d.diaria_id 
            FROM 
                diaria.diaria d
            WHERE 
                super_sd = '".$super_sd."'
            ORDER BY 
                diaria_dt_saida DESC, diaria_hr_saida ASC";

    $query = pg_query(abreConexao(), $sql);
    if($query){
        while ($diaria = pg_fetch_object($query)) {
            if ($retorno == ""){
                $retorno = $diaria->diaria_id;
            } else {
                $retorno .= ','.$diaria->diaria_id;
            }
        }
    }
    return $retorno;
}
/**
 * Verifica se todas as Diarias Agrupadas na SD recebida como parametro tem numero de empenho
 * @param String $super_sd <p>Número de SD do Agrupamento</p>
 * @return boolean <p>Verdadeiro se todas as diárias foram empenhadas e Falso se alguma diária do agrupamento ainda não foi empenhada</p>
 */
function verificaEmpenhoSSD($super_sd){
    $liberaEmpenho = TRUE;
    $sql = "SELECT 
                diaria_empenho 
            FROM 
                diaria.diaria d
            WHERE 
                super_sd = '".$super_sd."'";
    
    $query = pg_query(abreConexao(),$sql);
    if($query){
        while ($retorno = pg_fetch_object($query)){
            if($retorno->diaria_empenho == ""){
                $liberaEmpenho = FALSE;
            }
        }
    }
    return $liberaEmpenho;
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
 * @return Query <p>Resultado da consulta a base de dados</p>
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
                                diaria_agrupada = 1 AND 
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
                                diaria_agrupada = 1 AND 
                                (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR diaria_numero ILIKE '%" . $RetornoFiltro . "%') 
                            ORDER BY " . $_GET['atributo'] . " ASC";
            $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
        }
    }
    return $rsConsulta;
}

/**
 * Ação executada para Consultar os dados da diária cujo id foi recebido como parametro
 * @param integer $Codigo <p>Id da Diária a ser consultada</p>
 * @return query <p>Resultado da consulta a base de dados</p> 
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

/**
 * Libera Empenho de todas as diárias dos Agrupamentos recebidos como parâmetro
 * @param String $SSD <p>Números da super_sd das diárias a liberar empenho</p>
 */
function acaoLiberarEmpenho($SSD){
    $sqlID = "UPDATE 
                diaria.diaria 
              SET 
                diaria_st = 3,
                diaria_devolvida = 0
              WHERE 
                super_sd in ($SSD)";
    $query = pg_query(abreConexao(),$sqlID);
}

/**
 * Verifica se foi informada alguma ação
 */

if(isset ($AcaoSistema)){
    
    // verifica qual ação será executada
    switch ($AcaoSistema) {
        
        //se for consultar um agrupamento
        case "ssd":
            $diariasAgrupadas = acaoSSD($_GET['ssd']);
            break;
        case "buscar":
            $rsConsulta = acaoBuscar($_GET['atributo']);
            break;
        case "consultar":
            $rsConsulta = acaoConsultar($_GET['cod']);
            break;
        case "liberarEmpenho":
            acaoLiberarEmpenho($_GET['ssd']);
            echo "<script>alert(\"Empenhos Liberados com Sucesso.!!!\");</script>";
            echo "<script>window.location = 'SolicitacaoDiariaAgrupadaEmpenhoInicio.php ';</script>";
        default:
            $agrupamentos = consultaAgrupamentos();
            break;
    }
} else{
    $agrupamentos = consultaAgrupamentos();
}

?>