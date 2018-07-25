<table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
    <tr class="dataTitulo">
        <td height="21" width="320" colspan="5">Hist&oacute;rico</td>
    </tr>
    <tr class="dataLabel">
        <td width="1%" height="21">#</td>
        <td width="40%" height="21">Nome</td>
        <td width="8%" height="21">Data</td>
        <td width="8%" height="21">Hora</td>
        <td width="19%" height="21">Status</td>
    </tr>
<?php	

$sqlVerificaDevolucao = "SELECT diaria_devolucao_ds, 
                                    m.motivo_ds,
                                    tu.tipo_usuario_ds,
                                    diaria_devolucao_dt,
                                    diaria_devolucao_hr,
                                    d.diaria_st,
                                    p.pessoa_nm
                               FROM diaria.diaria_devolucao d 
                               JOIN diaria.motivo m 
                                 ON d.motivo_id = m.motivo_id
                               JOIN dados_unico.funcionario F 
                                 ON F.funcionario_id = d.diaria_devolucao_func
                               JOIN seguranca.usuario U 
                                 ON U.pessoa_id = F.pessoa_id
                               JOIN seguranca.usuario_tipo_usuario tp 
                                 ON tp.pessoa_id = U.pessoa_id
                               JOIN seguranca.tipo_usuario tu 
                                 ON tu.tipo_usuario_id = tp.tipo_usuario_id
                               JOIN dados_unico.pessoa p
                                 ON U.pessoa_id = p.pessoa_id
                              WHERE diaria_id = ".$linhaDiaria['diaria_id']."
                                AND tu.sistema_id = 2
                              ORDER BY diaria_devolucao_dt DESC LIMIT 1"; 

$rsVerificaDevolucao = pg_query(abreConexao(), $sqlVerificaDevolucao);
$linhaDevolucao = pg_fetch_assoc($rsVerificaDevolucao);
$dataDevolucao    = date("d-m-Y", strtotime($linhaDevolucao['diaria_devolucao_dt']));

if($linhaDiaria['diaria_st'] == '7')
{
    /* Arquivada */
    $sqlHistorico = "SELECT to_char(diaria_arquivada_dt,'DD/MM/YYYY') AS diaria_arquivada_dt, 
                            diaria_arquivada_hr,
                            pessoa_nm
                    FROM diaria.diaria_arquivada A
                    JOIN diaria.diaria D
                        ON A.diaria_id = D.diaria_id
                    JOIN dados_unico.funcionario F
                        ON diaria_arquivada_func = F.funcionario_id
                    JOIN dados_unico.pessoa P
                        ON F.pessoa_id = P.pessoa_id
                    WHERE A.diaria_id = ".$codigo;

    $rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
    $historicoQTD   = pg_num_rows($rsHistorico);
    if($rsHistorico)
    {
        while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
        {
            $vetor[11] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_arquivada_dt'], "Hora" => $linhaHistorico['diaria_arquivada_hr'], "Tabela" => "Arquivada");
        }
    }
}

if(($linhaDiaria['diaria_st'] > '5')&&($linhaDiaria['diaria_st'] < '11'))
{
    /* Aprovação de Comprovação */
    $sqlHistorico = "SELECT to_char(diaria_aprovacao_dt,'DD/MM/YYYY') AS diaria_aprovacao_dt,
                            diaria_aprovacao_hr,
                            pessoa_nm
                    FROM diaria.diaria_aprovacao A
                    JOIN diaria.diaria D
                      ON A.diaria_id = D.diaria_id
                    JOIN dados_unico.funcionario F
                      ON diaria_aprovacao_func = F.funcionario_id
                    JOIN dados_unico.pessoa P
                      ON F.pessoa_id = P.pessoa_id
                   WHERE A.diaria_id = ".$codigo." 
                     AND aprovacao_final = TRUE  
                ORDER BY diaria_aprovacao_dt DESC 
                    LIMIT 1";

    $rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
    $historicoQTD   = pg_num_rows($rsHistorico);
    if($historicoQTD > 1)
    {
        while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
        {
            $vetor[9] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_aprovacao_dt'], "Hora" => $linhaHistorico['diaria_aprovacao_hr'], "Tabela" => "Aprovação de Comprovação");
        }
    }
}

if(($linhaDiaria['diaria_st'] > '3')&&($linhaDiaria['diaria_st'] < '11'))
{
    /* Comprovação */
    $sqlHistorico = "SELECT to_char(diaria_comprovacao_dt,'DD/MM/YYYY') AS diaria_comprovacao_dt, 
                            diaria_comprovacao_hr,
                            pessoa_nm
                    FROM diaria.diaria_comprovacao C
                    JOIN diaria.diaria D
                        ON C.diaria_id = D.diaria_id
                    JOIN dados_unico.funcionario F
                        ON C.diaria_comprovacao_comprovador = F.pessoa_id
                    JOIN dados_unico.pessoa P
                        ON F.pessoa_id = P.pessoa_id
                    WHERE C.diaria_id = ".$codigo;

    $rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
    $historicoQTD   = pg_num_rows($rsHistorico);
    if($rsHistorico)
    {
        while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
        {
            $vetor[8] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_comprovacao_dt'], "Hora" => $linhaHistorico['diaria_comprovacao_hr'], "Tabela" => "Comprovação");
        }
    }
}

if(($linhaDiaria['diaria_st'] > '2')&&($linhaDiaria['diaria_st'] < '11'))
{
    /* Execução */
    $sqlHistorico = "SELECT to_char(diaria_execucao_dt,'DD/MM/YYYY') AS diaria_execucao_dt,
                            diaria_execucao_hr,
                            pessoa_nm
                    FROM diaria.diaria_financeiro A
                    JOIN diaria.diaria D
                        ON A.diaria_id = D.diaria_id
                    JOIN dados_unico.funcionario F
                        ON diaria_financeiro_executante = F.funcionario_id
                    JOIN dados_unico.pessoa P
                        ON F.pessoa_id = P.pessoa_id
                    WHERE A.diaria_id = ".$codigo;

    $rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
    $historicoQTD   = pg_num_rows($rsHistorico);
    if($rsHistorico)
    {
        while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
        {
            $vetor[7] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_execucao_dt'], "Hora" => $linhaHistorico['diaria_execucao_hr'], "Tabela" => "Execução");
        }
    }
}

if(($linhaDiaria['diaria_st'] > '2')&&($linhaDiaria['diaria_st'] < '11'))
{
    /* Liquidação */
    $sqlHistorico  = "SELECT to_char(diaria_liquidacao_dt,'DD/MM/YYYY') AS diaria_liquidacao_dt,
                            diaria_liquidacao_hr,
                            pessoa_nm
                        FROM diaria.diaria_financeiro A
                        JOIN diaria.diaria D
                        ON A.diaria_id = D.diaria_id
                        JOIN dados_unico.funcionario F
                        ON diaria_financeiro_liquidante = F.funcionario_id
                        JOIN dados_unico.pessoa P
                        ON F.pessoa_id = P.pessoa_id
                    WHERE A.diaria_id = ".$codigo;

    $rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
    $historicoQTD   = pg_num_rows($rsHistorico);
    if($rsHistorico)
    {
        while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
        {
            $vetor[6] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_liquidacao_dt'], "Hora" => $linhaHistorico['diaria_liquidacao_hr'], "Tabela" => "Liquidação");
        }
    }
}

if(($linhaDiaria['diaria_st'] > '2')&&($linhaDiaria['diaria_st'] < '11'))
{
    /* Pré-Liquidação */
    $sqlHistorico = "SELECT to_char(diaria_preliquidacao_dt,'DD/MM/YYYY') AS diaria_preliquidacao_dt,
                            diaria_preliquidacao_hr,
                            pessoa_nm
                    FROM diaria.diaria_financeiro A
                    JOIN diaria.diaria D
                        ON A.diaria_id = D.diaria_id
                    JOIN dados_unico.funcionario F
                        ON diaria_financeiro_preliquidante = F.funcionario_id
                    JOIN dados_unico.pessoa P
                        ON F.pessoa_id = P.pessoa_id
                    WHERE A.diaria_id = ".$codigo;

    $rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
    $historicoQTD   = pg_num_rows($rsHistorico);
    if($rsHistorico)
    {
        while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
        {
            $vetor[5] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_preliquidacao_dt'], "Hora" => $linhaHistorico['diaria_preliquidacao_hr'], "Tabela" => "Pré-Liquidação");
        }
    }
}

if(($linhaDiaria['diaria_st'] > '1')&&($linhaDiaria['diaria_st'] < '11'))
{
    /* Empenho */
    $sqlHistorico = "SELECT to_char(diaria_dt_empenho,'DD/MM/YYYY') AS diaria_dt_empenho,
                            diaria_hr_empenho,
                            pessoa_nm
                    FROM diaria.diaria D
                    JOIN dados_unico.pessoa P
                        ON diaria_empenho_pessoa_id = P.pessoa_id
                    WHERE D.diaria_id = ".$codigo;

    $rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
    $historicoQTD   = pg_num_rows($rsHistorico);
    if($rsHistorico)
    {
        while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
        {
                if($linhaHistorico['diaria_dt_empenho'] != "" && $linhaHistorico['diaria_dt_empenho'] != " " && $linhaHistorico['diaria_dt_empenho'] != null)
                $vetor[4] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_dt_empenho'], "Hora" => $linhaHistorico['diaria_hr_empenho'], "Tabela" => "Empenho");
        }
    }
}

if(($linhaDiaria['diaria_st'] > '0')&&($linhaDiaria['diaria_st'] < '11'))
{   
    /* Aprovação */
    if($linhaDiaria['diaria_st'] > '5')
    {
        $Where = " AND diaria_aprovacao_dt < TO_DATE('".$vetor[4]["Data"]."','YYYY/MM/DD') ";
    }
    else
    {
        $Where = "";
    }
    
    $sqlHistorico = "SELECT to_char(diaria_aprovacao_dt,'DD/MM/YYYY') AS diaria_aprovacao_dt,
                        diaria_aprovacao_hr,
                        pessoa_nm
                    FROM diaria.diaria_aprovacao A
                    JOIN diaria.diaria D
                        ON A.diaria_id = D.diaria_id
                    JOIN dados_unico.funcionario F
                        ON diaria_aprovacao_func = F.funcionario_id
                    JOIN dados_unico.pessoa P
                        ON F.pessoa_id = P.pessoa_id
                    WHERE A.diaria_id = ".$codigo.$Where."
                        AND aprovacao_final = TRUE
                ORDER BY diaria_aprovacao_dt ASC
                    LIMIT 1";
    
    $rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
    $historicoQTD   = pg_num_rows($rsHistorico);
    if($rsHistorico)
    {
        while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
        {
            if($linhaDevolucao['diaria_devolucao_dt'] > '2014-03-01')
            {                
                if($dataDevolucao > $linhaHistorico['diaria_aprovacao_dt'])
                {
                    $vetor[12] = array ("Nome" => $linhaDevolucao['pessoa_nm'], "Data" => $linhaDevolucao['diaria_devolucao_dt'], "Hora" => $linhaDevolucao['diaria_devolucao_hr'], "Tabela" => "Devolução");                
                    $vetor[2] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_aprovacao_dt'], "Hora" => $linhaHistorico['diaria_aprovacao_hr'], "Tabela" => "Aprovação");
                }
                elseif(($dataDevolucao == $linhaHistorico['diaria_aprovacao_dt']) && ($linhaDevolucao['diaria_devolucao_hr'] > $linhaHistorico['diaria_aprovacao_hr']))
                {
                    $vetor[12] = array ("Nome" => $linhaDevolucao['pessoa_nm'], "Data" => $linhaDevolucao['diaria_devolucao_dt'], "Hora" => $linhaDevolucao['diaria_devolucao_hr'], "Tabela" => "Devolução");                
                    $vetor[2] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_aprovacao_dt'], "Hora" => $linhaHistorico['diaria_aprovacao_hr'], "Tabela" => "Aprovação");
                }
                else
                {
                    $vetor[2] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_aprovacao_dt'], "Hora" => $linhaHistorico['diaria_aprovacao_hr'], "Tabela" => "Aprovação");
                }                
            }
            else
            {
                $vetor[2] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_aprovacao_dt'], "Hora" => $linhaHistorico['diaria_aprovacao_hr'], "Tabela" => "Aprovação");
            }                        
        }
    }
}

if(($linhaDiaria['diaria_st'] >= '0')&&($linhaDiaria['diaria_st'] < '10'))
{
    /* Autorização */
    $sqlHistorico = "SELECT to_char(diaria_autorizacao_dt,'DD/MM/YYYY') AS diaria_autorizacao_dt,
                            diaria_autorizacao_hr,
                            pessoa_nm
                       FROM diaria.diaria_autorizacao A
                       JOIN diaria.diaria D
                         ON A.diaria_id = D.diaria_id
                       JOIN dados_unico.funcionario F
                         ON diaria_autorizacao_func = F.funcionario_id
                       JOIN dados_unico.pessoa P
                         ON F.pessoa_id = P.pessoa_id
                      WHERE A.diaria_id = ".$codigo;

    $rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
    $historicoQTD   = pg_num_rows($rsHistorico);
    if($rsHistorico)
    {
        while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
        {
            if($linhaDevolucao['diaria_devolucao_dt'] > '2014-03-01')
            {                
               // $vetor[1] = array ("Nome" => $linhaDevolucao['pessoa_nm'], "Data" => $linhaDevolucao['diaria_devolucao_dt'], "Hora" => $linhaDevolucao['diaria_devolucao_hr'], "Tabela" => "Devolução");
                $vetor[1] = array ("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_autorizacao_dt'], "Hora" => $linhaHistorico['diaria_autorizacao_hr'], "Tabela" => "Autorização");
            }
            else
            {
                $vetor[1] = array ("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_autorizacao_dt'], "Hora" => $linhaHistorico['diaria_autorizacao_hr'], "Tabela" => "Autorização");
            }
        }
    }
}

if($linhaDiaria['diaria_st'] >= '0')
{
    /* Pré-Autorização */
    $sqlHistorico = "SELECT to_char(diaria_pre_autorizacao_dt,'DD/MM/YYYY') AS diaria_pre_autorizacao_dt,
                            diaria_pre_autorizacao_hr,
                            pessoa_nm
                    FROM diaria.diaria_pre_autorizacao A
                    JOIN diaria.diaria D
                        ON A.diaria_id = D.diaria_id
                    JOIN dados_unico.funcionario F
                        ON diaria_pre_autorizacao_func = F.funcionario_id
                    JOIN dados_unico.pessoa P
                        ON F.pessoa_id = P.pessoa_id
                    WHERE A.diaria_id = ".$codigo;

    $rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
    $historicoQTD   = pg_num_rows($rsHistorico);
    if($rsHistorico)
    {
        while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
        {
            if($linhaDevolucao['diaria_devolucao_dt'] > '2014-03-01')
            {
                //$vetor[0] = array ("Nome" => $linhaDevolucao['pessoa_nm'], "Data" => $linhaDevolucao['diaria_devolucao_dt'], "Hora" => $linhaDevolucao['diaria_devolucao_hr'], "Tabela" => "Devolução");
                $vetor[0] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_pre_autorizacao_dt'], "Hora" => $linhaHistorico['diaria_pre_autorizacao_hr'], "Tabela" => "Pré-Autorização");
            }
            else
            {
                $vetor[0] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_pre_autorizacao_dt'], "Hora" => $linhaHistorico['diaria_pre_autorizacao_hr'], "Tabela" => "Pré-Autorização");
            }
        }
    }
}

/* Solicitação */
$sqlHistorico  = "SELECT to_char(diaria_dt_criacao,'DD/MM/YYYY') AS diaria_dt_criacao,
                         diaria_hr_criacao,
                         pessoa_nm
                    FROM diaria.diaria D
                    JOIN dados_unico.pessoa P
                      ON diaria_solicitante = P.pessoa_id
                   WHERE D.diaria_id = ".$codigo;

$rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
$historicoQTD   = pg_num_rows($rsHistorico);
if($rsHistorico)
{
    while ($linhaHistorico = pg_fetch_assoc($rsHistorico))
    {
            $vetor[3] = array("Nome" => $linhaHistorico['pessoa_nm'], "Data" => $linhaHistorico['diaria_dt_criacao'], "Hora" => $linhaHistorico['diaria_hr_criacao'], "Tabela" => "Solicitação");
    }
}
				
$cont   = 1;
$cor    = 1;
$reg    = $vetor;

if($reg)
{
    foreach($reg as $registro)
    {        
        if($cor == 1)
        {
            $classe = "dataField2";
        }
        else
        {
            $classe = "dataField";
        }
        $cor *= -1;

        echo "<tr height='21'>";
            echo "<td class='$classe'>&nbsp;<b>".$cont++."&nbsp;</b></td>";
            echo "<td class='$classe'>&nbsp;".$registro["Nome"]."</td>";
            echo "<td class='$classe'>&nbsp;".$registro["Data"]."</td>";
            echo "<td class='$classe'>&nbsp;".$registro["Hora"]."</td>";
            echo "<td class='$classe'>&nbsp;".$registro["Tabela"]."</td>";
        echo "</tr>";
    }
}
//$sqlHistorico   = "SELECT *                   
//                     FROM diaria.historico_diaria h
//                  ".$join." 
//                    WHERE h.diaria_id = ".$codigo."
//                    ORDER BY h.diaria_st DESC";
//
//$rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
//$historicoQTD   = pg_num_rows($rsHistorico);
//                     
//
//switch ($linhaDiaria['diaria_st']) 
//{
//    case 100: // PRÉ-AUTORIZAÇÃO
//        if($historicoQTD > 0)
//        {
//            $join = "";
//        }        
//        else
//        {
//            $sqlHistorico = "SELECT diaria_pre_autorizacao_dt AS data,
//                                    diaria_pre_autorizacao_hr AS hora,
//                                    pessoa_nm,
//                                    diaria_st
//                               FROM diaria.diaria_pre_autorizacao A
//                               JOIN diaria.diaria D
//                                 ON A.diaria_id = D.diaria_id
//                               JOIN dados_unico.funcionario F
//                                 ON diaria_pre_autorizacao_func = F.funcionario_id
//                               JOIN dados_unico.pessoa P
//                                 ON F.pessoa_id = P.pessoa_id
//                              WHERE A.diaria_id = ".$codigo;            
//        }
//        break;
//        
//    case 0:   // AUTORIZAÇÂO
//        if($historicoQTD > 0)
//        {
//            $join = "";
//        }        
//        else
//        {
//            $sqlHistorico = "SELECT diaria_autorizacao_dt AS data,
//                                    diaria_autorizacao_hr AS hora,
//                                    pessoa_nm,
//                                    diaria_st
//                               FROM diaria.diaria_autorizacao A
//                               JOIN diaria.diaria D
//                                 ON A.diaria_id = D.diaria_id
//                               JOIN dados_unico.funcionario F
//                                 ON diaria_autorizacao_func = F.funcionario_id
//                               JOIN dados_unico.pessoa P
//                                 ON F.pessoa_id = P.pessoa_id
//                              WHERE A.diaria_id = ".$codigo;           
//        }
//        break;
//        
//    case 1:   // APROVAÇÂO
//        if($historicoQTD > 0)
//        {
//            $join = "";
//        }        
//        else
//        {
//            $sqlHistorico = "SELECT diaria_aprovacao_dt AS data,
//                                    diaria_aprovacao_hr AS hora,
//                                    pessoa_nm,
//                                    diaria_st
//                               FROM diaria.diaria_aprovacao A
//                               JOIN diaria.diaria D
//                                 ON A.diaria_id = D.diaria_id
//                               JOIN dados_unico.funcionario F
//                                 ON diaria_aprovacao_func = F.funcionario_id
//                               JOIN dados_unico.pessoa P
//                                 ON F.pessoa_id = P.pessoa_id
//                              WHERE A.diaria_id = ".$codigo;            
//        }
//        break;
//    
//    case 2:   // EMPENHO  
//        if($historicoQTD > 0)
//        {
//            $join = "";
//        }        
//        else
//        {
//            $sqlHistorico = "SELECT diaria_dt_empenho AS data,
//                                    diaria_hr_empenho AS hora,
//                                    pessoa_nm,
//                                    diaria_st
//                               FROM diaria.diaria D
//                               JOIN dados_unico.pessoa P
//                                 ON diaria_empenho_pessoa_id = P.pessoa_id
//                              WHERE D.diaria_id = ".$codigo;
//        }
//        break;
//    
//    case 3:   // EXECUÇÂO   
//        if($historicoQTD > 0)
//        {
//            $join = "";
//        }        
//        else
//        {
//            $sqlHistorico = "SELECT diaria_execucao_dt AS data,
//                                    diaria_execucao_hr AS hora,
//                                    pessoa_nm,
//                                    diaria_st
//                               FROM diaria.diaria_financeiro A
//                               JOIN diaria.diaria D
//                                 ON A.diaria_id = D.diaria_id
//                               JOIN dados_unico.funcionario F
//                                 ON diaria_financeiro_executante = F.funcionario_id
//                               JOIN dados_unico.pessoa P
//                                 ON F.pessoa_id = P.pessoa_id
//                              WHERE A.diaria_id = ".$codigo;
//            $sqlHistorico = "SELECT diaria_liquidacao_dt AS data,
//                                    diaria_liquidacao_hr AS hora,
//                                    pessoa_nm,
//                                    diaria_st
//                               FROM diaria.diaria_financeiro A
//                               JOIN diaria.diaria D
//                                 ON A.diaria_id = D.diaria_id
//                               JOIN dados_unico.funcionario F
//                                 ON diaria_financeiro_liquidante = F.funcionario_id
//                               JOIN dados_unico.pessoa P
//                                 ON F.pessoa_id = P.pessoa_id
//                              WHERE A.diaria_id = ".$codigo;
//            $sqlHistorico = "SELECT diaria_preliquidacao_dt AS data,
//                                    diaria_preliquidacao_hr AS hora,
//                                    pessoa_nm,
//                                    diaria_st
//                               FROM diaria.diaria_financeiro A
//                               JOIN diaria.diaria D
//                                 ON A.diaria_id = D.diaria_id
//                               JOIN dados_unico.funcionario F
//                                 ON diaria_financeiro_preliquidante = F.funcionario_id
//                               JOIN dados_unico.pessoa P
//                                 ON F.pessoa_id = P.pessoa_id
//                              WHERE A.diaria_id = ".$codigo;
//            
//        }
//        break;
//    
//    case 4:   // COMPROVAÇÂO  
//        if($historicoQTD > 0)
//        {
//            $join = "";
//        }        
//        else
//        {
//                      
//        }
//        break;
//    
//    case 5:   // APROVAÇÂO DE COMPROVAÇÂO
//        if($historicoQTD > 0)
//        {
//            $join = "";
//        }        
//        else
//        {
//                        
//        }
//        break;
//    
//    case 6:   // AGUARDANDO ARQUIVAMENTO  
//        if($historicoQTD > 0)
//        {
//            $join = "";
//        }        
//        else
//        {
//            
//        }
//        break;
//    
//    case 7:   // ARQUIVADA  
//        if($historicoQTD > 0)
//        {
//            $join = "";
//        }        
//        else
//        {
//            $sqlHistorico = "SELECT diaria_arquivada_dt AS data, 
//                                    diaria_arquivada_hr AS hora,
//                                    pessoa_nm,
//                                    diaria_st
//                               FROM diaria.diaria_arquivada A
//                               JOIN diaria.diaria D
//                                 ON A.diaria_id = D.diaria_id
//                               JOIN dados_unico.funcionario F
//                                 ON diaria_arquivada_func = F.funcionario_id
//                               JOIN dados_unico.pessoa P
//                                 ON F.pessoa_id = P.pessoa_id
//                              WHERE A.diaria_id = ".$codigo;            
//        }
//        break;
//    
//    default: 
//        if($historicoQTD > 0)
//        {
//            $join = "";
//        }        
//        else
//        {            
//            $sqlHistorico = "SELECT diaria_dt_criacao AS data,
//                                    diaria_hr_criacao AS hora,
//                                    pessoa_nm,
//                                    diaria_st
//                               FROM diaria.diaria D
//                               JOIN dados_unico.pessoa P
//                                 ON diaria_solicitante = P.pessoa_id
//                              WHERE D.diaria_id = ".$codigo;              
//        }
//        break;
//}
//$rsHistorico    = pg_query(abreConexao(), $sqlHistorico);
//$historicoQTD   = pg_num_rows($rsHistorico);
//$linhaHistorico = pg_fetch_assoc($rsHistorico);
//$cor            = 1;
//$cont           = 1;
//    if($historicoQTD)
//    {
//        while($historicoQTD > $cont)
//        {
//            if($cor == 1)
//            {
//                $classe = "dataField";
//            }
//            else
//            {
//                $classe = "dataField2";
//            }
//            $cor *= -1;
//
//            echo "<tr height='21'>";
//                echo "  <td class='$classe'>&nbsp;<b>".$cont++."&nbsp;</b></td>";
//                echo "  <td class='$classe'>&nbsp;".$linhaHistorico["pessoa_nm"]."</td>";
//                echo "  <td class='$classe'>&nbsp;".$linhaHistorico["data"]."</td>";
//                echo "  <td class='$classe'>&nbsp;".$linhaHistorico["hora"]."</td>";
//                echo "  <td class='$classe'>&nbsp;".$StatusNome."</td>";
//            echo "</tr>";
//        }
//    }
?>
</table>