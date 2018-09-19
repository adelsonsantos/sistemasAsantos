<?php
include "../Include/Inc_Configuracao.php";

$_SESSION['ArrayContador'] = 0;
$acaoSistema     = $_GET['acao'];  
$alterouCalculo  = 1;
$diariaCalculada = 0;

if ($_GET['pagina'] == "") 
{
    $PaginaLocal = "Solicitacao";
} 
else 
{
    $PaginaLocal = $_GET['pagina'];
}

switch ($acaoSistema)
{     
    case "consultar":         
        $linhaDiaria = Consultar($cod);          
    break;

    case "comprovar":         
        Comprovar($PaginaLocal);
    break;

    default:
        $rsConsulta = Buscar();
    break;
}

function Buscar()
{    
    global $RetornoFiltro,$display;
    
    if ($_SESSION['Administrador'] != 1) 
    {
        $sqlConsulta = "SELECT usuario_diaria FROM seguranca.usuario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
        $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
        $linha = pg_fetch_assoc($rsConsulta);
        If ($linha) 
        {
            $AcessoSolicitaDiaria = $linha['usuario_diaria'];
        }
    }        
    
    $RetornoFiltro = $_GET['filtro'];
    
    if ($_SESSION['Administrador'] != 1) 
    {
        If ($RetornoFiltro != "") 
        {
            $display     = 'inline';
            $sqlConsulta = "SELECT diaria_id,
                                    diaria_numero,
                                    diaria_solicitante,
                                    diaria_beneficiario,
                                    diaria_dt_saida,
                                    diaria_hr_saida,
                                    diaria_dt_chegada,
                                    diaria_hr_chegada,
                                    diaria_processo,
                                    diaria_comprovada,
                                    diaria_st,
                                    pessoa_nm,
                                    diaria_local_solicitacao,
                                    diaria_devolvida
                             FROM dados_unico.pessoa p
                             JOIN dados_unico.funcionario f
                               ON f.pessoa_id = p.pessoa_id
                             JOIN diaria.diaria d
                               ON d.diaria_beneficiario = p.pessoa_id
                            WHERE (diaria_beneficiario = " . $_SESSION['UsuarioCodigo'] . " OR diaria_solicitante = " . $_SESSION['UsuarioCodigo'] . ") 
                              AND diaria_excluida = 0 AND diaria_comprovada = 1 AND (diaria_st = 10) AND (pessoa_nm ILIKE '%".$RetornoFiltro."%' 
                               OR diaria_numero ILIKE '%".$RetornoFiltro."%') 
                         ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";            
        } 
        Else 
        {
            $display     = 'none';
            $sqlConsulta = "SELECT diaria_id,
                                    diaria_numero,
                                    diaria_solicitante,
                                    diaria_beneficiario,
                                    diaria_dt_saida,
                                    diaria_hr_saida,
                                    diaria_dt_chegada,
                                    diaria_hr_chegada,
                                    diaria_processo,
                                    diaria_comprovada,
                                    diaria_st,
                                    pessoa_nm,
                                    diaria_local_solicitacao,
                                    diaria_devolvida
                             FROM dados_unico.pessoa p
                             JOIN dados_unico.funcionario f
                               ON f.pessoa_id = p.pessoa_id
                             JOIN diaria.diaria d
                               ON d.diaria_beneficiario = p.pessoa_id
                            WHERE (diaria_beneficiario = " . $_SESSION['UsuarioCodigo'] . " OR diaria_solicitante = " . $_SESSION['UsuarioCodigo'] . ") 
                              AND diaria_excluida = 0 AND diaria_comprovada = 1 AND (diaria_st = 10) 
                         ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";
        }
    }
    else
    {
        If ($RetornoFiltro != "") 
        {
            $display     = 'inline';
            $sqlConsulta = "SELECT  diaria_id,
                                    diaria_numero,
                                    diaria_solicitante,
                                    diaria_beneficiario,
                                    diaria_dt_saida,
                                    diaria_hr_saida,
                                    diaria_dt_chegada,
                                    diaria_hr_chegada,
                                    diaria_comprovada,
                                    diaria_processo,
                                    diaria_st,
                                    pessoa_nm,
                                    diaria_local_solicitacao,
                                    diaria_devolvida
                             FROM dados_unico.pessoa p
                             JOIN dados_unico.funcionario f
                               ON f.pessoa_id = p.pessoa_id
                             JOIN diaria.diaria d
                               ON d.diaria_beneficiario = p.pessoa_id
                            WHERE diaria_excluida = 0 AND diaria_comprovada = 1 AND (diaria_st = 10) 
                              AND (pessoa_nm ILIKE '%".$RetornoFiltro."%' OR diaria_numero ILIKE '%".$RetornoFiltro."%') 
                              AND date_part('Year', diaria_dt_criacao) NOT IN (2011,2010)
                         ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";
        } 
        Else 
        {
            $display     = 'none';            
            $sqlConsulta = "SELECT  diaria_id,
                                    diaria_numero,
                                    diaria_solicitante,
                                    diaria_beneficiario,
                                    diaria_dt_saida,
                                    diaria_hr_saida,
                                    diaria_dt_chegada,
                                    diaria_hr_chegada,
                                    diaria_processo,
                                    diaria_comprovada,
                                    diaria_st,
                                    pessoa_nm,
                                    diaria_local_solicitacao,
                                    diaria_devolvida
                             FROM dados_unico.pessoa p
                             JOIN dados_unico.funcionario f
                               ON f.pessoa_id = p.pessoa_id
                             JOIN diaria.diaria d
                               ON d.diaria_beneficiario = p.pessoa_id
                            WHERE diaria_excluida = 0 AND diaria_comprovada = 1 AND (diaria_st = 10) 
                              AND date_part('Year', diaria_dt_criacao) NOT IN (2011,2010) 
                         ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";
        }
    }
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
 
    return $rsConsulta;  
}

function Consultar($cod)
{      
   //Definindo variaveis globais
    global $codigo,$alterouCalculo,$alterarRoteiro,$descontoMarcado,$desconto,$contador,$i,$atual,$controleRoteiro;
    //Captura o valor das variáveis    
    if($cod == '')
    {
        $codigo = $_GET['cod'];   
    }
    else
    {
        $codigo = $cod;
    }
    $sqlConsulta     = "SELECT qtde_roteiros FROM diaria.diaria WHERE diaria_id = ".$codigo;
    $rsConsulta      = pg_query(abreConexao(), $sqlConsulta);
    $linhaDiaria     = pg_fetch_assoc($rsConsulta);
    $controleRoteiro = $linhaDiaria['qtde_roteiros'];
    
    $alterarRoteiro   = $_GET['alterarRoteiro'];
    $alterouCalculo   = $_GET['recalcular'];   
    $atual            = date('d/m/Y');
    $sqlComprovacao   = "SELECT diaria_id FROM diaria.diaria_comprovacao WHERE diaria_id = ".$codigo;
    
    $rsComprovacao    = pg_query(abreConexao(), $sqlComprovacao);
    $linhaComprovacao = pg_fetch_assoc($rsComprovacao);
    
    if (!$linhaComprovacao) 
    {
        $comprovada = 0;
    }
    else 
    {
        $comprovada = 1;
    }
    
    if ($alterarRoteiro == "") 
    {
        $alterarRoteiro = 0;
    }    

    if ($alterouCalculo == "") 
    {
        $alterouCalculo = 0;
    }
    
    //Consulta dados da diaria
    if($comprovada == 0) 
    {
        if($controleRoteiro == 0)
        {
            //$sqlConsulta = "SELECT * FROM diaria.diaria d, diaria.diaria_motivo dm WHERE (d.diaria_id = dm.diaria_id) AND d.diaria_id = ".$codigo;
            $sqlConsultaDiaria = "   SELECT d.diaria_roteiro_complemento,
                                        d.diaria_descricao,	
                                        d.diaria_solicitante,
                                        d.diaria_beneficiario,
                                        d.diaria_id,
                                        d.diaria_numero,
                                        d.diaria_st,
                                        d.diaria_dt_criacao,
                                        d.diaria_dt_saida,
                                        d.diaria_hr_saida,
                                        d.diaria_dt_chegada,
                                        d.diaria_hr_chegada,
                                        d.diaria_qtde,
                                        d.diaria_valor,
                                        d.diaria_beneficiario,
                                        d.diaria_valor_ref,
                                        d.meio_transporte_id,
                                        d.diaria_devolvida,
                                        d.diaria_transporte_obs,
                                        d.diaria_justificativa_fds,
                                        d.diaria_comprovada,
                                        diaria_justificativa_feriado,
                                        dm.motivo_id,
                                        dm.sub_motivo_id,
                                        d.diaria_unidade_custo,
                                        d.projeto_cd,
                                        d.acao_cd,
                                        d.territorio_cd,
                                        d.fonte_cd,
                                        d.diaria_desconto,                                        
                                        p.pessoa_nm AS solicitante_nm, 
                                        pe.pessoa_nm AS beneficiario_nm
                                 FROM diaria.diaria d
                                 JOIN diaria.diaria_motivo dm
                                   ON d.diaria_id = dm.diaria_id
                                 JOIN dados_unico.pessoa p
                                   ON p.pessoa_id = d.diaria_solicitante
                                 JOIN dados_unico.pessoa pe
                                   ON pe.pessoa_id = d.diaria_beneficiario
                                WHERE d.diaria_id =".$codigo;
        }
        else
        {
            $sqlConsultaDiaria = "   SELECT d.diaria_roteiro_complemento,
                                        d.diaria_descricao,	
                                        d.diaria_solicitante,
                                        d.diaria_beneficiario,
                                        d.diaria_id,
                                        d.diaria_numero,
                                        d.diaria_st, 
                                        d.diaria_devolvida,
                                        d.meio_transporte_id,                                        
                                        d.diaria_transporte_obs,
                                        d.diaria_comprovada,
                                        d.diaria_unidade_custo,
                                        d.projeto_cd,
                                        d.acao_cd,
                                        d.territorio_cd,
                                        d.fonte_cd,
                                        d.diaria_qtde AS qtde_total,
                                        d.diaria_valor AS valor_total,
                                        drm.diaria_dt_saida,
                                        drm.diaria_hr_saida,
                                        drm.diaria_dt_chegada,
                                        drm.diaria_hr_chegada,
                                        drm.diaria_qtde,
                                        drm.diaria_desconto,
                                        drm.diaria_valor,
                                        drm.diaria_roteiro_complemento,                                                                                     
                                        controle_roteiro,
                                        dm.motivo_id,
                                        dm.sub_motivo_id,                                        
                                        p.pessoa_nm AS solicitante_nm, 
                                        pe.pessoa_nm AS beneficiario_nm
                                 FROM diaria.diaria d
                                 JOIN diaria.diaria_motivo dm
                                   ON d.diaria_id = dm.diaria_id
                                 JOIN dados_unico.pessoa p
                                   ON p.pessoa_id = d.diaria_solicitante
                                 JOIN dados_unico.pessoa pe
                                   ON pe.pessoa_id = d.diaria_beneficiario
                                 JOIN diaria.dados_roteiro_multiplo drm
                                   ON drm.diaria_id = d.diaria_id 
                                WHERE controle_roteiro = 0                    
                                  AND dados_roteiro_status = 0 
                                  AND d.diaria_id =".$codigo;
        }
        
        $rsConsultaDiaria    = pg_query(abreConexao(), $sqlConsultaDiaria);
        $linhaConsultaDiaria = pg_fetch_assoc($rsConsultaDiaria);
        
        $sqlRoteiro    = "SELECT roteiro_comprovacao_origem, roteiro_comprovacao_destino FROM diaria.roteiro_comprovacao WHERE diaria_id = ".$codigo;
        $rsRoteiro     = pg_query(abreConexao(), $sqlRoteiro);
        $qtdDeRegistro = pg_fetch_row($rsRoteiro);
        $contador      = count($qtdDeRegistro);
        $i             = 1;
        
        if ($linhaConsultaDiaria['diaria_desconto'] == "N") 
        {
            $desconto        = "N&atilde;o";
            $descontoMarcado = "";
        } 
        else 
        {
            $desconto        = "Sim";
            $descontoMarcado = "checked";
        }        
        return $linhaConsultaDiaria;
    } 
    elseif($comprovada == 1) 
    {
        if($controleRoteiro == 0)
        {
            $sqlConsultaComprovada = "  SELECT  d.diaria_roteiro_complemento,
                                                d.diaria_descricao,
                                                dc.diaria_comprovacao_resumo,
                                                d.diaria_solicitante,
                                                d.diaria_beneficiario,
                                                dc.diaria_comprovacao_dt,
                                                dc.diaria_comprovacao_hr,
                                                d.diaria_dt_criacao,
                                                d.diaria_numero,
                                                d.diaria_id,
                                                d.diaria_st,
                                                d.diaria_dt_saida,
                                                d.diaria_hr_saida,
                                                d.diaria_dt_chegada,
                                                d.diaria_hr_chegada,                                                
                                                d.diaria_qtde,
                                                d.diaria_valor,
                                                d.diaria_comprovada,
                                                d.diaria_processo,
                                                d.diaria_empenho,
                                                d.diaria_devolvida,
                                                d.diaria_descricao,
                                                d.diaria_dt_empenho,
                                                d.diaria_beneficiario,
                                                d.diaria_valor_ref,
                                                dc.diaria_comprovacao_justificativa_feriado,
                                                dc.diaria_comprovacao_justificativa_fds,
                                                dc.diaria_comprovacao_complemento,
                                                dc.diaria_comprovacao_complemento_justificativa,
                                                dc.diaria_comprovacao_resumo,
                                                dc.diaria_comprovacao_dt_saida,
                                                dc.diaria_comprovacao_hr_saida,
                                                dc.diaria_comprovacao_dt_chegada,
                                                dc.diaria_comprovacao_hr_chegada,
                                                dc.diaria_comprovacao_qtde,
                                                dc.diaria_comprovacao_valor,
                                                dc.diaria_comprovacao_saldo,
                                                dc.diaria_comprovacao_saldo_tipo,
                                                dc.diaria_comprovacao_valor_ref,
                                                d.meio_transporte_id,
                                                d.diaria_transporte_obs,
                                                dm.motivo_id,
                                                dm.sub_motivo_id,
                                                d.diaria_unidade_custo,
                                                d.projeto_cd,
                                                d.acao_cd,
                                                d.territorio_cd,
                                                d.fonte_cd,
                                                d.diaria_desconto,                                            
                                                p.pessoa_nm AS solicitante_nm, 
                                                pe.pessoa_nm AS beneficiario_nm
                                      FROM diaria.diaria d
                                      JOIN diaria.diaria_comprovacao dc
                                        ON dc.diaria_id = d.diaria_id  
                                      JOIN diaria.diaria_motivo dm
                                        ON (dc.diaria_id = dm.diaria_id)
                                      JOIN dados_unico.pessoa p
                                        ON p.pessoa_id = d.diaria_solicitante
                                      JOIN dados_unico.pessoa pe
                                        ON pe.pessoa_id = d.diaria_beneficiario
                                     WHERE dc.diaria_id =".$codigo;
        }
        else
        {
            $sqlConsultaComprovada = "  SELECT  d.diaria_roteiro_complemento,
                                                d.diaria_descricao,                                                
                                                d.diaria_solicitante,
                                                d.diaria_beneficiario,                                                
                                                d.diaria_dt_criacao,
                                                d.diaria_numero,
                                                d.diaria_id,
                                                d.diaria_st,
                                                d.diaria_dt_saida,
                                                d.diaria_hr_saida,
                                                d.diaria_dt_chegada,
                                                d.diaria_hr_chegada,
                                                d.diaria_qtde AS qtde_total_previsto,
                                                d.diaria_valor AS valor_total_previsto,
                                                d.diaria_comprovada,
                                                d.diaria_processo,
                                                d.diaria_empenho,
                                                d.diaria_devolvida,
                                                d.diaria_descricao,
                                                d.diaria_dt_empenho,
                                                d.diaria_beneficiario,
                                                d.diaria_valor_ref, 
                                                d.meio_transporte_id,
                                                d.diaria_transporte_obs,
                                                d.diaria_unidade_custo,
                                                d.projeto_cd,
                                                d.acao_cd,
                                                d.territorio_cd,
                                                d.fonte_cd,
                                                d.diaria_desconto,
                                                drm.diaria_dt_saida,
                                                drm.diaria_hr_saida,
                                                drm.diaria_dt_chegada,
                                                drm.diaria_hr_chegada,
                                                drm.diaria_qtde,
                                                drm.diaria_desconto,
                                                drm.diaria_valor,
                                                drm.diaria_roteiro_complemento,   
                                                dc.diaria_comprovacao_dt,
                                                dc.diaria_comprovacao_hr,
                                                dc.diaria_comprovacao_justificativa_feriado,
                                                dc.diaria_comprovacao_justificativa_fds,
                                                dc.diaria_comprovacao_valor_ref,
                                                dc.diaria_comprovacao_qtde AS qtde_total,
                                                dc.diaria_comprovacao_valor AS valor_total,
                                                dc.diaria_comprovacao_complemento_justificativa,
                                                dc.diaria_comprovacao_saldo AS saldo_total,
                                                dc.diaria_comprovacao_saldo_tipo AS saldo_tipo_total,
                                                drmc.diaria_comprovacao_desconto,                                                                                
                                                drmc.diaria_roteiro_comprovacao_complemento,                                                
                                                drmc.diaria_resumo_comprovacao,
                                                drmc.diaria_comprovacao_dt_saida,
                                                drmc.diaria_comprovacao_hr_saida,
                                                drmc.diaria_comprovacao_dt_chegada,
                                                drmc.diaria_comprovacao_hr_chegada,
                                                drmc.diaria_comprovacao_qtde,
                                                drmc.diaria_comprovacao_valor,
                                                drmc.diaria_comprovacao_saldo,
                                                drmc.diaria_comprovacao_saldo_tipo,                                                 
                                                dm.motivo_id,
                                                dm.sub_motivo_id,                                                                                            
                                                p.pessoa_nm AS solicitante_nm, 
                                                pe.pessoa_nm AS beneficiario_nm
                                      FROM diaria.diaria d
                                      JOIN diaria.dados_roteiro_multiplo drm
                                        ON drm.diaria_id = d.diaria_id 
                                      JOIN diaria.diaria_comprovacao dc
                                        ON dc.diaria_id = d.diaria_id  
                                      JOIN diaria.dados_roteiro_multiplo_comprovacao drmc
                                        ON drmc.diaria_id = d.diaria_id   
                                      JOIN diaria.diaria_motivo dm
                                        ON (dc.diaria_id = dm.diaria_id)
                                      JOIN dados_unico.pessoa p
                                        ON p.pessoa_id = d.diaria_solicitante
                                      JOIN dados_unico.pessoa pe
                                        ON pe.pessoa_id = d.diaria_beneficiario
                                     WHERE dc.diaria_id =".$codigo."
                                       AND controle_roteiro = 0 
                                       AND controle_roteiro_comprovacao = 0
                                       AND dados_roteiro_status = 0";
        }
        
        $alterouCalculo       = 0;        
        $rsConsultaComprovada = pg_query(abreConexao(), $sqlConsultaComprovada);
        $linhaConsultaDiaria  = pg_fetch_assoc($rsConsultaComprovada);   
        
        if ($linhaConsultaDiaria['diaria_desconto'] == "N") 
        {
            $desconto         = "N&atilde;o";
            $descontoMarcado  = "";
        } 
        else 
        {
            $desconto         = "Sim";
            $descontoMarcado  = "checked";
        }        
        return $linhaConsultaDiaria;
    }  
}

function Comprovar($PaginaLocal)
{    
    //CAPTURA OS VALORES DOS CAMPOS
    $codigo                   = $_POST['txtCodigo'];    
    $date                     = date('Y-m-d');
    $time                     = date('H:m:s');       
    $justificativaFeriado     = TrataSqlInj($_POST['txtJustificativaFeriado']);
    $justificativaFimSemana   = TrataSqlInj($_POST['txtJustificativaFimSemana']);
    $complementoJustificativa = TrataSqlInj($_POST['txtComplemento']);        
    $diariaSt                 = $_POST['txtDiariaSt'];        
    $diariaDevolvida          = $_POST['diariaDevolvida'];    
    $valorRef                 = $_POST['txtNovoValorRef'];  
    $controle                 = $_POST['controleRoteiro'];


    
    if($diariaSt == '4')
    {
        $controleRoteiro = $_POST['controleRoteiro'];
    }
    elseif($diariaSt == '10')
    {
        if($controle > 0)
        {
            $controleRoteiro = $_POST['controleRoteiro'] - 1;
        }                
        else
        {
            $controleRoteiro = $_POST['controleRoteiro'];
        }
    }
    
    if($desconto == 'on')
    {
        $desconto = 'S';
    }
    else
    {
        $desconto = 'N';
    }    
    //Verifica se existe roteiro multiplo     
    if($controle > 0)
    {                        
        $Valor        = $_POST['totalDiarias'];
        $DataPartida  = $_POST['txtDataPartida'];
        $HoraPartida  = $_POST['txtHoraPartida'];
        $DataChegada  = $_POST['txtDataChegada'.$controleRoteiro];
        $HoraChegada  = $_POST['txtHoraChegada'.$controleRoteiro];
        $valorRef     = $_POST['txtNovoValorRef'.$controleRoteiro];
        $cont         = 0;
        $TxtResumo    = '';
        
        while($controle > $cont)
        {
            if($_POST['totalRestituir'] != '')
            {
                $Saldo     = $_POST['totalRestituir'];
                $SaldoTipo = 'D';
            }
            elseif($_POST['totalReceber'] != '')
            {
                $Saldo     = $_POST['totalReceber'];
                $SaldoTipo = 'C';
            }
            else
            {
                $Saldo     = '';
                $SaldoTipo = '';
            }
            
            if($cont == 0)
            {
                $dataPartida[$cont]        = $_POST['txtDataPartida'];
                $horaPartida[$cont]        = $_POST['txtHoraPartida'];
                $dataChegada[$cont]        = $_POST['txtDataChegada'];
                $horaChegada[$cont]        = $_POST['txtHoraChegada'];
                $qtde[$cont]               = $_POST['txtQtdDiarias'];
                $valor[$cont]              = $_POST['txtNovoValorTotal'];
                $roteiroComplemento[$cont] = TrataSqlInj($_POST['txtRoteiroComplemento']);
                $txtResumo[$cont]          = TrataSqlInj($_POST['txtResumo'.$cont]);
                $saldoValor[$cont]         = $_POST['txtSaldo'];
                $saldoTipo[$cont]          = $_POST['txtSaldoTipo'];
                $alterarRoteiro[$cont]     = $_POST['alterarRoteiro'];
                $valorRef[$cont]           = $_POST['txtNovoValorRef'];
                
                If ($_POST['chkDesconto'] == "on") 
                {
                    $desconto[$cont] = "S";
                } 
                Else 
                {
                    $desconto[$cont] = "N";
                }
                $Qtde = $Qtde + $qtde[$cont];
            }
            else
            {
                $dataPartida[$cont]        = $_POST['txtDataPartida'.$cont];
                $horaPartida[$cont]        = $_POST['txtHoraPartida'.$cont];
                $dataChegada[$cont]        = $_POST['txtDataChegada'.$cont];
                $horaChegada[$cont]        = $_POST['txtHoraChegada'.$cont];
                $qtde[$cont]               = $_POST['txtQtdDiarias'.$cont];
                $valor[$cont]              = $_POST['txtNovoValorTotal'.$cont];
                $roteiroComplemento[$cont] = TrataSqlInj($_POST['txtRoteiroComplemento'.$cont]);
                $txtResumo[$cont]          = TrataSqlInj($_POST['txtResumo'.$cont]);
                $saldoValor[$cont]         = $_POST['txtSaldo'.$cont];
                $saldoTipo[$cont]          = $_POST['txtSaldoTipo'.$cont];
                $alterarRoteiro[$cont]     = $_POST['alterarRoteiro'.$cont];
                $valorRef[$cont]           = $_POST['txtNovoValorRef'.$cont];

                If ($_POST['chkDesconto'.$cont] == "on") 
                {
                    $desconto[$cont] = "S";                    
                } 
                Else 
                {
                    $desconto[$cont] = "N";
                }
                $Qtde = $Qtde + $qtde[$cont];
                $Desconto = $desconto[$cont];
            }          
            $cont ++;
        }
    }
    else
    {
        $DataPartida        = $_POST['txtDataPartida'];
        $HoraPartida        = $_POST['txtHoraPartida'];
        $DataChegada        = $_POST['txtDataChegada'];
        $HoraChegada        = $_POST['txtHoraChegada'];        
        $Desconto           = $_POST['chkDesconto'];
        $Qtde               = $_POST['txtQtdDiarias'];    
        $Valor              = $_POST['txtNovoValorTotal'];
        $Saldo              = $_POST['txtSaldo'];
        $SaldoTipo          = $_POST['txtSaldoTipo']; 
        $TxtResumo          = TrataSqlInj($_POST['txtResumo']);
        $AlterarRoteiro     = $_POST['alterarRoteiro'];
        $RoteiroComplemento = $_POST['txtRoteiroComplemento'];
        $valorRef           = $_POST['txtNovoValorRef'];
    }


    if($controle > 0){
        $newValorRef = $valorRef[0];
    }else{
        $newValorRef = $_POST['txtNovoValorRef'];
    }

    //VERIFICA SE O STATUS DA DI�RIA ESTA CORRETO
    if($diariaSt == '4')
    {
        $BeginTrans = "BEGIN WORK";
        pg_query(abreConexao(), $BeginTrans);
         
        if($diariaDevolvida == 0)
        {                        
            //INSERE A COMPROVA��O DA DI�RIA NA TABELA diaria_comprovacao
            $sqlInsere = "  INSERT INTO diaria.diaria_comprovacao 
                                        (diaria_id, diaria_comprovacao_comprovador, diaria_comprovacao_dt_saida, diaria_comprovacao_hr_saida, 
                                        diaria_comprovacao_dt_chegada, diaria_comprovacao_hr_chegada, diaria_comprovacao_valor_ref, diaria_comprovacao_desconto, 
                                        diaria_comprovacao_qtde, diaria_comprovacao_valor,diaria_comprovacao_justificativa_feriado, 
                                        diaria_comprovacao_justificativa_fds, diaria_comprovacao_saldo, diaria_comprovacao_saldo_tipo,diaria_comprovacao_dt, 
                                        diaria_comprovacao_hr, diaria_comprovacao_st, diaria_comprovacao_empenho, diaria_comprovacao_dt_empenho, 
                                        diaria_comprovacao_resumo, diaria_comprovacao_complemento, diaria_comprovacao_complemento_justificativa, diaria_comprovacao_relatorio, diaria_comprovacao_controle) 
                                VALUES (".$codigo.", ".$_SESSION['UsuarioCodigo'].", '".$DataPartida."', '".$HoraPartida."', '".$DataChegada."', 
                                        '".$HoraChegada."', '".$newValorRef."', '".$Desconto."', '".$Qtde."', '".$Valor."', '".$justificativaFeriado."', 
                                        '".$justificativaFimSemana."', '".$Saldo."', '".$SaldoTipo."', '".$date."', '".$time."', NULL, NULL, NULL, 
                                        '".$TxtResumo."', 0, '".$complementoJustificativa."', NULL, $controle)";            
                        
            pg_query(abreConexao(), $sqlInsere);            
            //ALTERA O STATUS DA DI�RIA INDICANDO QUE A MESMA FOI COMPROVADA
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 10, diaria_comprovada = 1, diaria_devolvida = 0 WHERE diaria_id = " . $codigo;
            pg_query(abreConexao(), $sqlAltera);
        }
        else
        {
            $sqlAltera = " UPDATE diaria.diaria_comprovacao 
                          SET diaria_comprovacao_comprovador                = ".$_SESSION['UsuarioCodigo'].",
                              diaria_comprovacao_dt_saida                   = '".$DataPartida."',
                              diaria_comprovacao_hr_saida                   = '".$HoraPartida."',
                              diaria_comprovacao_dt_chegada                 = '".$DataChegada."',
                              diaria_comprovacao_hr_chegada                 = '".$HoraChegada."',
                              diaria_comprovacao_valor_ref                  = '".$newValorRef."',
                              diaria_comprovacao_desconto                   = '".$Desconto."',
                              diaria_comprovacao_qtde                       = '".$Qtde."',
                              diaria_comprovacao_valor                      = '".$Valor."',
                              diaria_comprovacao_justificativa_feriado      = '".$justificativaFeriado."',
                              diaria_comprovacao_justificativa_fds          = '".$justificativaFimSemana."',
                              diaria_comprovacao_saldo                      = '".$Saldo."',
                              diaria_comprovacao_saldo_tipo                 = '".$SaldoTipo."',
                              diaria_comprovacao_dt                         = '".$date."',
                              diaria_comprovacao_hr                         = '".$time."',
                              diaria_comprovacao_st                         = NULL,
                              diaria_comprovacao_empenho                    = NULL,
                              diaria_comprovacao_dt_empenho                 = NULL,
                              diaria_comprovacao_resumo                     = '".$TxtResumo."',
                              diaria_comprovacao_complemento                = 0,
                              diaria_comprovacao_complemento_justificativa  = '".$complementoJustificativa."',
                              diaria_comprovacao_relatorio                  = NULL
                        WHERE diaria_id = ".$codigo;
        
            pg_query(abreConexao(), $sqlAltera);
            //ALTERA O STATUS DA DI�RIA INDICANDO QUE A MESMA FOI COMPROVADA
            $sqlAltera = "UPDATE diaria.diaria SET diaria_st = 10, diaria_comprovada = 1, diaria_devolvida = 0 WHERE diaria_id = " . $codigo;
            pg_query(abreConexao(), $sqlAltera);
        }
        //INSERE A COMPROVA��O NA TABELA DE HIST�RICO
        $sqlInsereHistorico = " INSERT INTO diaria.diaria_comprovacao_historico 
                                    (diaria_id, diaria_comprovacao_comprovador, diaria_comprovacao_dt_saida, diaria_comprovacao_hr_saida, 
                                    diaria_comprovacao_dt_chegada, diaria_comprovacao_hr_chegada, diaria_comprovacao_valor_ref, diaria_comprovacao_desconto, 
                                    diaria_comprovacao_qtde, diaria_comprovacao_valor,diaria_comprovacao_justificativa_feriado, 
                                    diaria_comprovacao_justificativa_fds, diaria_comprovacao_saldo, diaria_comprovacao_saldo_tipo,diaria_comprovacao_dt, 
                                    diaria_comprovacao_hr, diaria_comprovacao_st, diaria_comprovacao_empenho, diaria_comprovacao_dt_empenho, 
                                    diaria_comprovacao_resumo, diaria_comprovacao_complemento, diaria_comprovacao_complemento_justificativa, diaria_comprovacao_relatorio) 
                             VALUES (".$codigo.", ".$_SESSION['UsuarioCodigo'].", '".$DataPartida."', '".$HoraPartida."', '".$DataChegada."', 
                                    '".$HoraChegada."', '".$newValorRef."', '".$Desconto."', '".$Qtde."', '".$Valor."', '".$justificativaFeriado."', 
                                    '".$justificativaFimSemana."', '".$Saldo."', '".$SaldoTipo."', '".$date."', '".$time."', NULL, NULL, NULL, 
                                    '".$TxtResumo."', 0, '".$complementoJustificativa."', NULL)";       
        
        pg_query(abreConexao(), $sqlInsereHistorico);          
        
        // Verifica se existem roteiros multiplos
        if($controle > 0)
        {      
            $cont = 0;
            while($cont < $controle)
            {
                $sqlDadosRoteiro = 
                "INSERT INTO diaria.dados_roteiro_multiplo_comprovacao
                 (  
                    diaria_id,                                                
                    diaria_comprovacao_dt_saida,
                    diaria_comprovacao_hr_saida,
                    diaria_comprovacao_dt_chegada,
                    diaria_comprovacao_hr_chegada,
                    diaria_comprovacao_qtde,
                    diaria_comprovacao_desconto,
                    diaria_comprovacao_valor,
                    diaria_roteiro_comprovacao_complemento,
                    diaria_resumo_comprovacao,
                    controle_roteiro_comprovacao,
                    dados_roteiro_comprovacao_status,
                    diaria_comprovacao_saldo,
                    diaria_comprovacao_saldo_tipo,
                    diaria_comprovacao_valor_ref)
                VALUES 
                (
                    ".$codigo.",
                    '$dataPartida[$cont]',
                    '$horaPartida[$cont]',      
                    '$dataChegada[$cont]',   
                    '$horaChegada[$cont]',      
                    '$qtde[$cont]',  
                    '$desconto[$cont]',
                    '$valor[$cont]',  
                    '$roteiroComplemento[$cont]',
                    '$txtResumo[$cont]',                                                            
                    $cont,
                    0,
                    '$saldoValor[$cont]',
                    '$saldoTipo[$cont]',
                    '$valorRef[$cont]'                  
                )"; 
                pg_query(abreConexao(), $sqlDadosRoteiro);
                
                    // SE O ROTEIRO FOR ALTERADO CAPTURA A ALTERAÇÃO E GRAVA NA TEABELA DE COMPROVAÇÃO ROTEIRO
                if($alterarRoteiro[$cont] == 1)
                {
                    For ($i = 1; $i <= $_SESSION['ContadorDestino'][$cont]; $i++) 
                    {
                        $sqlInsere = "INSERT INTO diaria.roteiro_comprovacao
                                                  (diaria_id, roteiro_comprovacao_origem, roteiro_comprovacao_destino, controle_roteiro_comprovacao) 
                                           VALUES (".$codigo.", ".$_SESSION['ViagemOrigem'][$cont][$i].", ".$_SESSION['ViagemDestino'][$cont][$i].", $cont)";
                        pg_query(abreConexao(), $sqlInsere);
                    }
                }
                // SE NÃO HOUVER ALTERAÇÃO NO ROTEIRO CAPTURA O DA SOLICITAÇÃO E GRAVA NA TEABELA DE COMPROVAÇÃO ROTEIRO
                else
                {
                    $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE controle_roteiro =$cont AND diaria_id = ".$codigo;
                    $rsRoteiro  = pg_query(abreConexao(), $sqlRoteiro);

                    while ($linha = pg_fetch_assoc($rsRoteiro))
                    {
                        $sqlInsere = "INSERT INTO diaria.roteiro_comprovacao
                                                  (diaria_id, roteiro_comprovacao_origem, roteiro_comprovacao_destino, controle_roteiro_comprovacao) 
                                           VALUES (".$codigo.", ".$linha['roteiro_origem'].", ".$linha['roteiro_destino'].", $cont)";
                        pg_query(abreConexao(), $sqlInsere);                        
                    }
                }
                $cont ++;
            }            
        }
        else 
        {
            // SE O ROTEIRO FOR ALTERADO CAPTURA A ALTERAÇÃO E GRAVA NA TEABELA DE COMPROVAÇÃO ROTEIRO
            if($AlterarRoteiro == 1)
            {
                For ($i = 1; $i <= $_SESSION['ContadorDestino'][$controleRoteiro]; $i++) 
                {
                    $sqlInsere = "INSERT INTO diaria.roteiro_comprovacao
                                              (diaria_id, roteiro_comprovacao_origem, roteiro_comprovacao_destino) 
                                       VALUES (".$codigo.", ".$_SESSION['ViagemOrigem'][$controleRoteiro][$i].", ".$_SESSION['ViagemDestino'][$controleRoteiro][$i].")";
                    pg_query(abreConexao(), $sqlInsere);
                }
            }
            // SE NÃO HOUVER ALTERAÇÃO NO ROTEIRO CAPTURA O DA SOLICITAÇÃO E GRAVA NA TEABELA DE COMPROVAÇÃO ROTEIRO
            else
            {
                $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$codigo;
                $rsRoteiro  = pg_query(abreConexao(), $sqlRoteiro);

                while ($linha = pg_fetch_assoc($rsRoteiro))
                {
                    $sqlInsere = "INSERT INTO diaria.roteiro_comprovacao
                                              (diaria_id, roteiro_comprovacao_origem, roteiro_comprovacao_destino) 
                                       VALUES (".$codigo.", ".$linha['roteiro_origem'].", ".$linha['roteiro_destino'].")";
                    pg_query(abreConexao(), $sqlInsere);
                }
            }
        }        
                
        If ($Err != 0) 
        {
            $RollbackTrans = "ROLLBACK";
            pg_query(abreConexao(), $RollbackTrans);
            echo $Err;
            
            //REDIRECIONA PARA P�GINA INICIAL E DISPARA � IMPRESS�O
            echo "<script>(window.location ='SolicitacaoComprovar.php?cod=".$codigo."');</script>";
        } 
        Else 
        {
            $CommitTrans = "COMMIT";
            pg_query(abreConexao(), $CommitTrans);
            
            //REDIRECIONA PARA P�GINA INICIAL E DISPARA � IMPRESS�O
            echo "<script>(window.location ='".$PaginaLocal."Inicio.php?cod=".$codigo."&imprimir=1');</script>";
        }
        exit;
    }
    elseif($diariaSt == '10')
    {        
        $BeginTrans = "BEGIN WORK";
        pg_query(abreConexao(), $BeginTrans);
        
        //ATUALIZA A COMPROVAÇÃO DA DIÁRIA NA TABELA diaria_comprovacao
        $sqlAltera = " UPDATE diaria.diaria_comprovacao 
                          SET diaria_comprovacao_comprovador                = ".$_SESSION['UsuarioCodigo'].",
                              diaria_comprovacao_dt_saida                   = '".$DataPartida."',
                              diaria_comprovacao_hr_saida                   = '".$HoraPartida."',
                              diaria_comprovacao_dt_chegada                 = '".$DataChegada."',
                              diaria_comprovacao_hr_chegada                 = '".$HoraChegada."',
                              diaria_comprovacao_valor_ref                  = '".$newValorRef."',
                              diaria_comprovacao_desconto                   = '".$Desconto."',
                              diaria_comprovacao_qtde                       = '".$Qtde."',
                              diaria_comprovacao_valor                      = '".$Valor."',
                              diaria_comprovacao_justificativa_feriado      = '".$justificativaFeriado."',
                              diaria_comprovacao_justificativa_fds          = '".$justificativaFimSemana."',
                              diaria_comprovacao_saldo                      = '".$Saldo."',
                              diaria_comprovacao_saldo_tipo                 = '".$SaldoTipo."',
                              diaria_comprovacao_dt                         = '".$date."',
                              diaria_comprovacao_hr                         = '".$time."',
                              diaria_comprovacao_st                         = NULL,
                              diaria_comprovacao_empenho                    = NULL,
                              diaria_comprovacao_dt_empenho                 = NULL,
                              diaria_comprovacao_resumo                     = '".$TxtResumo."',
                              diaria_comprovacao_complemento                = 0,
                              diaria_comprovacao_complemento_justificativa  = '".$complementoJustificativa."',
                              diaria_comprovacao_relatorio                  = NULL
                        WHERE diaria_id = ".$codigo;
        
        pg_query(abreConexao(), $sqlAltera);
        
        //INSERE A COMPROVA��O NA TABELA DE HIST�RICO
        $sqlInsereHistorico = " INSERT INTO diaria.diaria_comprovacao_historico 
                                    (diaria_id, diaria_comprovacao_comprovador, diaria_comprovacao_dt_saida, diaria_comprovacao_hr_saida, 
                                    diaria_comprovacao_dt_chegada, diaria_comprovacao_hr_chegada, diaria_comprovacao_valor_ref, diaria_comprovacao_desconto, 
                                    diaria_comprovacao_qtde, diaria_comprovacao_valor,diaria_comprovacao_justificativa_feriado, 
                                    diaria_comprovacao_justificativa_fds, diaria_comprovacao_saldo, diaria_comprovacao_saldo_tipo,diaria_comprovacao_dt, 
                                    diaria_comprovacao_hr, diaria_comprovacao_st, diaria_comprovacao_empenho, diaria_comprovacao_dt_empenho, 
                                    diaria_comprovacao_resumo, diaria_comprovacao_complemento, diaria_comprovacao_complemento_justificativa, diaria_comprovacao_relatorio) 
                             VALUES (".$codigo.", ".$_SESSION['UsuarioCodigo'].", '".$DataPartida."', '".$HoraPartida."', '".$DataChegada."', 
                                    '".$HoraChegada."', '".$valorRef."', '".$Desconto."', '".$Qtde."', '".$Valor."', '".$justificativaFeriado."', 
                                    '".$justificativaFimSemana."', '".$Saldo."', '".$SaldoTipo."', '".$date."', '".$time."', NULL, NULL, NULL, 
                                    '".$TxtResumo."', 0, '".$complementoJustificativa."', NULL)";       
        
        pg_query(abreConexao(), $sqlInsereHistorico);  
        
        // Verifica se existem roteiros multiplos
        if($controle > 0)
        {      
            $cont = 0;
            while($cont < $controle)
            {
                $sqlDadosRoteiro = 
                "UPDATE diaria.dados_roteiro_multiplo_comprovacao
                    SET diaria_comprovacao_dt_saida = '$dataPartida[$cont]',
                        diaria_comprovacao_hr_saida = '$horaPartida[$cont]',
                        diaria_comprovacao_dt_chegada = '$dataChegada[$cont]',
                        diaria_comprovacao_hr_chegada = '$horaChegada[$cont]',
                        diaria_comprovacao_qtde = '$qtde[$cont]',
                        diaria_comprovacao_desconto = '$desconto[$cont]',
                        diaria_comprovacao_valor = '$valor[$cont]',
                        diaria_roteiro_comprovacao_complemento = '$roteiroComplemento[$cont]',
                        diaria_resumo_comprovacao = '$txtResumo[$cont]',                        
                        dados_roteiro_comprovacao_status = 0,
                        diaria_comprovacao_saldo = '$saldoValor[$cont]',
                        diaria_comprovacao_saldo_tipo = '$saldoTipo[$cont]',
                        diaria_comprovacao_valor_ref = '$valorRef[$cont]'
                  WHERE diaria_id = ".$codigo."
                    AND controle_roteiro_comprovacao = $cont";                
     
                pg_query(abreConexao(), $sqlDadosRoteiro);
                
                    // SE O ROTEIRO FOR ALTERADO CAPTURA A ALTERAÇÃO E GRAVA NA TEABELA DE COMPROVAÇÃO ROTEIRO
                if($alterarRoteiro[$cont] == 1)
                {
                    $sqlDelete = " DELETE FROM diaria.roteiro_comprovacao
                                    WHERE diaria_id = ".$codigo." 
                                      AND controle_roteiro_comprovacao =".$cont;
                    pg_query(abreConexao(), $sqlDelete);
                    For ($i = 1; $i <= $_SESSION['ContadorDestino'][$cont]; $i++) 
                    {
                        $sqlInsere = "INSERT INTO diaria.roteiro_comprovacao
                                                  (diaria_id, roteiro_comprovacao_origem, roteiro_comprovacao_destino, controle_roteiro_comprovacao) 
                                           VALUES (".$codigo.", ".$_SESSION['ViagemOrigem'][$cont][$i].", ".$_SESSION['ViagemDestino'][$cont][$i].", $cont)";
                        pg_query(abreConexao(), $sqlInsere);
                    }
                }
                $cont ++;
            }           
        }
        else
        {
            if($AlterarRoteiro == 1)
            {
                $sqlDelete = "DELETE FROM diaria.roteiro_comprovacao
                                    WHERE diaria_id = ".$codigo;
                pg_query(abreConexao(), $sqlDelete);
                For ($i = 1; $i <= $_SESSION['ContadorDestino'][$controleRoteiro]; $i++) 
                {
                   $sqlInsere = "INSERT INTO diaria.roteiro_comprovacao
                                             (diaria_id, roteiro_comprovacao_origem, roteiro_comprovacao_destino) 
                                      VALUES (".$codigo.", ".$_SESSION['ViagemOrigem'][$controleRoteiro][$i].", ".$_SESSION['ViagemDestino'][$controleRoteiro][$i].")";
                    pg_query(abreConexao(), $sqlInsere);
                }
            }
        }                        
        //REDIRECIONA PARA P�GINA INICIAL E DISPARA � IMPRESS�O
        If ($Err != 0) 
        {
            $RollbackTrans = "ROLLBACK";
            pg_query(abreConexao(), $RollbackTrans);
            echo $Err;
            
            //REDIRECIONA PARA P�GINA INICIAL E DISPARA � IMPRESS�O
            echo "<script>(window.location ='SolicitacaoComprovar.php?cod=".$codigo."');</script>";
        } 
        Else 
        {
            $CommitTrans = "COMMIT";
            pg_query(abreConexao(), $CommitTrans);
            
            //REDIRECIONA PARA P�GINA INICIAL E DISPARA � IMPRESS�O
            echo "<script>(window.location ='SolicitacaoAlterarComprovacaoInicio.php?cod=".$codigo."&imprimir=1');</script>";
        }        
        exit;
    }
    echo "<script>(window.location ='".$PaginaLocal."Inicio.php);</script>";
}

?>

