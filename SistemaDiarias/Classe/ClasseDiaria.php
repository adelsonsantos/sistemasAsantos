<?php
include "../Include/Inc_Configuracao.php";
include "IncludeLocal/Inc_FuncoesDiarias.php";
//define o nome da pagina local para facilitar nos links
if(empty($_GET['acao'])== false)
{
    $acaoSistema = $_GET['acao'];
}
else
{
    $acaoSistema = '';
}

if(empty($_GET['pagina']) == true)
{
    $PaginaLocal = "Solicitacao";
}
else
{
    $PaginaLocal = $_GET['pagina'];
}

//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 1;
$_SESSION['ArrayContador']  = 0;

$alterarRoteiro  = 1;
$AlterouCalculo  = 0;
$DiariaCalculada = 0;
$horaCriacao     = date("H:i:s");
$rsConsulta      = '';
$linha           = '';

switch ($acaoSistema)
{
    case '':
        $rsConsulta = Inicializar();
    break;
        
    case "consultar":  
        $linhaDiaria = Consultar();           
    break;

    case "incluir":         
        Incluir($PaginaLocal);
    break;
    
    case "alterar":        
        Alterar($PaginaLocal);
    break;

    case "excluir":        
        Excluir($PaginaLocal);
    break;
}

/*******************************************************************************
      Consulta o usuário para verificar se tem direito a solicitar diária
*******************************************************************************/
$sqlConsultaPermissao  = "SELECT pessoa_id 
                            FROM seguranca.usuario_tipo_usuario
                           WHERE pessoa_id = ".$_SESSION['UsuarioCodigo']."
                             AND (tipo_usuario_id = 30 OR tipo_usuario_id = 11 OR tipo_usuario_id = 5 OR tipo_usuario_id = 31)";

$consultaPermissao      = pg_query(abreConexao(),$sqlConsultaPermissao);
$linhaConsultaPermissao = pg_fetch_assoc($consultaPermissao);

function Inicializar()
{    
    global $RetornoFiltro,$display;
    
    if ($_SESSION['Administrador'] != 1) 
    {
        $sqlConsulta = "SELECT  usuario_diaria FROM seguranca.usuario WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'];
        $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
        $linha = pg_fetch_assoc($rsConsulta);
        If ($linha) 
        {
            $AcessoSolicitaDiaria = $linha['usuario_diaria'];
        }
    }
    
    if(empty($_GET['filtro'])== false)
    {
        $RetornoFiltro = $_GET['filtro'];
    }
    else
    {
        $RetornoFiltro = '';
    }
    
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
                            WHERE (diaria_beneficiario = " . $_SESSION['UsuarioCodigo'] . " OR diaria_solicitante = " . $_SESSION['UsuarioCodigo'] . ") AND diaria_excluida = 0 AND (diaria_st <> 7) AND (pessoa_nm ILIKE '%".$RetornoFiltro."%' OR diaria_numero ILIKE '%".$RetornoFiltro."%') ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";
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
                            WHERE (diaria_beneficiario = " . $_SESSION['UsuarioCodigo'] . " OR diaria_solicitante = " . $_SESSION['UsuarioCodigo'] . ") AND diaria_excluida = 0 AND (diaria_st <> 7) ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";
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
                            WHERE diaria_excluida = 0 AND (diaria_st <> 7) AND (pessoa_nm ILIKE '%".$RetornoFiltro."%' OR diaria_numero ILIKE '%".$RetornoFiltro."%') AND date_part('Year', diaria_dt_criacao) NOT IN (2011,2010)
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
                            WHERE diaria_excluida = 0 AND (diaria_st <> 7) AND date_part('Year', diaria_dt_criacao) NOT IN (2011,2010)
                            ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC, diaria_hr_saida ASC";            
        }
    }    
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
 
    return $rsConsulta;   
}

function Consultar()
{          
   //Definindo variaveis globais
    global $codigo,$roteiro,$alterouCalculo,$alterarRoteiro,$diaSemanaPartida,$diaSemanaChegada,$diariaCalculada,$descontoMarcado,$desconto,$checkInterior,$checkCaptal,$dataCriacao,$controleRoteiro;
    
    If ($codigo == "") 
    {
        $codigo = $_GET['cod'];        
    }

    $alterarRoteiro  = $_GET['alterarRoteiro'];
    $alterouCalculo  = $_GET['reCalcular'];
    $diariaCalculada = 1;
    
    $sqlConsulta     = "SELECT qtde_roteiros FROM diaria.diaria WHERE diaria_id = ".$codigo;
    $rsConsulta      = pg_query(abreConexao(), $sqlConsulta);
    $linhaDiaria     = pg_fetch_assoc($rsConsulta);             
    
    if($linhaDiaria['qtde_roteiros'] == 0)
    {
        $sqlConsulta = "SELECT * 
                        FROM diaria.diaria d
                        JOIN dados_unico.pessoa p
                        ON d.diaria_beneficiario = p.pessoa_id
                        JOIN dados_unico.funcionario f
                        ON p.pessoa_id = f.pessoa_id
                        JOIN dados_unico.pessoa_fisica pf
                        ON p.pessoa_id = pf.pessoa_id
                        JOIN diaria.diaria_motivo dm
                        ON d.diaria_id = dm.diaria_id
                        LEFT JOIN diaria.etapa e
                        ON e.etapa_id = d.etapa_id 
                        WHERE d.diaria_id = ".$codigo;
    }
    else
    {  
        $controleRoteiro = $linhaDiaria['qtde_roteiros'] - 1;
        
        $sqlConsulta = "SELECT d.diaria_id,
                        d.diaria_numero,
                        d.diaria_qtde AS qtde_total,
                        d.diaria_valor AS valor_total,
                        diaria_solicitante,
                        diaria_beneficiario,
                        drm.diaria_dt_saida,
                        drm.diaria_hr_saida,
                        drm.diaria_dt_chegada,
                        drm.diaria_hr_chegada,
                        drm.diaria_qtde,
                        drm.diaria_desconto,
                        drm.diaria_valor,
                        drm.diaria_roteiro_complemento,
                        controle_roteiro,
                        diaria_justificativa_feriado,
                        meio_transporte_id,
                        diaria_transporte_obs,
                        diaria_descricao,
                        diaria_unidade_custo,
                        projeto_cd,
                        acao_cd,
                        territorio_cd,
                        fonte_cd,
                        diaria_st,
                        d.diaria_valor_ref,
                        diaria_cancelada,
                        diaria_devolvida,
                        diaria_dt_criacao,
                        diaria_hr_criacao,
                        diaria_justificativa_fds,
                        diaria_processo,
                        diaria_empenho,
                        diaria_dt_empenho,
                        diaria_excluida,
                        diaria_comprovada,
                        diaria_processo_fisico,
                        diaria_empenho_pessoa_id,
                        diaria_hr_empenho,
                        diaria_extrato_empenho,
                        convenio_id,
                        indenizacao,
                        ger_id,
                        diaria_local_solicitacao,
                        id_coordenadoria,
                        data_viagem_saida,
                        data_viagem_chegada,
                        super_sd,
                        diaria_agrupada,
                        imp_diaria_agrupa,
                        diaria_indvidual,
                        diaria_dt_alteracao,
                        e.etapa_id,
                        pedido_empenho,                       
                        qtde_roteiros,
                        p.pessoa_id,
                        pessoa_nm,
                        funcionario_id,
                        funcionario_tipo_id,
                        funcao_id,
                        cargo_permanente,
                        funcionario_matricula,
                        funcionario_ramal,
                        funcionario_email,
                        funcionario_dt_admissao,
                        funcionario_dt_demissao,
                        funcionario_orgao_origem,
                        cargo_temporario,
                        funcionario_orgao_destino,
                        est_organizacional_lotacao_id,
                        pessoa_fisica_sexo,
                        pessoa_fisica_cpf,
                        pessoa_fisica_dt_nasc,
                        pessoa_fisica_rg,
                        pessoa_fisica_cnh,
                        nivel_escolar_id,
                        motivo_id,
                        sub_motivo_id,
                        e.etapa_id,
                        etapa_ds,
                        projeto_id,
                        saldo_superior,
                        saldo_medio,
                        etapa_st,
                        etapa_codigo,
                        fonte_id,
                        etapa_data_criacao,
                        etapa_data_atualizacao,
                        etapa_meta,
                        saldo_superior_inicio,
                        saldo_medio_inicio	
                    FROM diaria.diaria d
                    JOIN dados_unico.pessoa p
                    ON d.diaria_beneficiario = p.pessoa_id
                    JOIN dados_unico.funcionario f
                    ON p.pessoa_id = f.pessoa_id
                    JOIN dados_unico.pessoa_fisica pf
                    ON p.pessoa_id = pf.pessoa_id
                    JOIN diaria.diaria_motivo dm
                    ON d.diaria_id = dm.diaria_id
                    LEFT JOIN diaria.etapa e
                    ON e.etapa_id = d.etapa_id 
                    JOIN diaria.dados_roteiro_multiplo drm
                    ON drm.diaria_id = d.diaria_id                            
                    WHERE drm.controle_roteiro = 0                    
                    AND dados_roteiro_status = 0
                    AND d.diaria_id = ".$codigo;
    }            
   
    $rsConsulta  = pg_query(abreConexao(), $sqlConsulta);
    $linhaDiaria = pg_fetch_assoc($rsConsulta);    
    
    If ($alterarRoteiro == "") 
    {
        $alterarRoteiro = 0;
    }
    If ($alterouCalculo == "")
    {
        $alterouCalculo = 1;
    }
    if($linhaDiaria)
    {        
        //TRATANDO OS VALORES RECUPERADOS 
        $dataCriacao = f_FormataData($linhaDiaria['diaria_dt_criacao']);        

        if($linhaDiaria['diaria_local_solicitacao'] == 'Sede')
        {
            $checkCaptal = 'checked';
        }
        else
        {
            $checkInterior = 'checked';
        }
        
        $diaSemanaPartida       = diasemana($linhaDiaria['diaria_dt_saida']);
        $diaSemanaChegada       = diasemana($linhaDiaria['diaria_dt_chegada']);
        
        If ($linhaDiaria['diaria_desconto'] == "N") 
        {
            $desconto = "Não";
            $descontoMarcado = "";
        } 
        Else 
        {
            $desconto = "Sim";
            $descontoMarcado = "checked";
        }
        
        If ($controleRoteiro == 0) 
        { 
            $and = '';
        }   
        else
        {
            $and = ' AND controle_roteiro = 0 ';
        }
            //MONTA A LISTA DE ROTEIROS HÀ SEREM EXIBIDOS NA CONSULTA        
        If ($alterarRoteiro == 0) 
        {
            $sqlRoteiro =   "SELECT diaria_id,
                                    r.roteiro_origem,
                                    mo.municipio_cd,
                                    r.roteiro_destino,
                                    md.municipio_cd,
                                    mo.municipio_ds AS municipio_origem,
                                    mo.estado_uf AS estado_origem,
                                    md.municipio_ds AS municipio_destino,
                                    md.estado_uf AS estado_destino
                                FROM diaria.roteiro r
                                JOIN dados_unico.municipio mo 
                                ON mo.municipio_cd = r.roteiro_origem
                                JOIN dados_unico.municipio md
                                ON md.municipio_cd = r.roteiro_destino
                                WHERE diaria_id = ".$codigo." ".$and;

            $rsRoteiro      = pg_query(abreConexao(), $sqlRoteiro);
            $qtdRegistro    = pg_num_rows($rsRoteiro);            
            $i              = 1;

            while ($linhaRotero = pg_fetch_assoc($rsRoteiro)) 
            {
                If ($i == 1) 
                {
                    $Inicio = $linhaRotero['municipio_origem'] . "(" . $linhaRotero['estado_origem'] . ")" . " / " . $linhaRotero['municipio_destino'] . "(" . $linhaRotero['estado_destino'] . ")";
                } 
                Elseif (($i != 1) && ($i < $qtdRegistro)) 
                {
                    $Meio = " / " . $linhaRotero['municipio_origem'] . "(" . $linhaRotero['estado_origem'] . ")" . " / " . $linhaRotero['municipio_destino'] . "(" . $linhaRotero['estado_destino'] . ")";
                } 
                Elseif ($i == $qtdRegistro) 
                {
                    $Final = " / " . $linhaRotero['municipio_origem'] . "(" . $linhaRotero['estado_origem'] . ")";
                }

                $i = $i ++;
            }
            $roteiro = $Inicio . $Meio . $Final;
        }
    }
    return $linhaDiaria;
}

function Incluir($PaginaLocal)
{      
    //pega numeracao de diaria
    $sqlConsulta                = "SELECT diaria_numero FROM diaria.diaria_numero";
    $rsConsulta                 = pg_query(abreConexao(), $sqlConsulta);
    $linhaNumero                = pg_fetch_assoc($rsConsulta);  
    
    $Numero                     = $linhaNumero['diaria_numero'];
    $Solicitante                = $_SESSION['UsuarioCodigo'];
    $Beneficiario               = $_POST['cmbBeneficiario'];    
    $ValorRef                   = $_POST['txtNovoValorRef'];    
    $JustificativaFeriado       = TrataSqlInj($_POST['txtJustificativaFeriado']); 
    $JustificativaFimSemana     = TrataSqlInj($_POST['txtJustificativaFimSemana']);
    $MeioTransporte             = $_POST['cmbMeioTransporte'];
    $TransporteObservacao       = TrataSqlInj($_POST['txtMeioTransporteObservacao']);    
    $Motivo                     = $_POST['cmbMotivoDiaria'];
    $SubMotivo                  = $_POST['cmbSubMotivoDiaria'];
    $Descricao                  = TrataSqlInj($_POST['txtDescricao']);
    $UnidadeCusto               = $_POST['cmbUnidadeCusto'];
    $Projeto                    = $_POST['cmbProjeto'];
    $Acao                       = $_POST['cmbAcao'];
    $Territorio                 = $_POST['cmbTerritorio'];
    $Fonte                      = $_POST['cmbFonte'];
    $Etapa                      = $_POST['cmbEtapa'];
    $Diaria_local_solicitacao   = $_POST['radioCoordenadoria']; // Atributo Novo Colocado por Erinaldo em 19/02/2011
    $Id_coordenadoria           = $_POST['comboCordenadoriaInterior']; // Atributo Novo Colocado por Erinaldo em 19/02/2011	
        
    //Capiturando valores dos multiplos roteiros
    if($_POST['controleRoteiro'] > 0)
    {
        $qtdeRoteiros = $_POST['controleRoteiro']+1;        
        $controle     = $_POST['controleRoteiro'];
        $Valor        = $_POST['NovoValorTotalDiarias'];
        $DataPartida  = $_POST['txtDataPartida'];
        $HoraPartida  = $_POST['txtHoraPartida'];
        $DataChegada  = $_POST['txtDataChegada'.$_POST['controleRoteiro']];
        $HoraChegada  = $_POST['txtHoraChegada'.$_POST['controleRoteiro']];        
        
        while($controle >= 0)
        {
            if($controle == 0)
            {
                $dataPartida[$controle]        = $_POST['txtDataPartida'];
                $horaPartida[$controle]        = $_POST['txtHoraPartida'];
                $dataChegada[$controle]        = $_POST['txtDataChegada'];
                $horaChegada[$controle]        = $_POST['txtHoraChegada'];
                $qtde[$controle]               = $_POST['txtQtdDiarias'];
                $valor[$controle]              = $_POST['txtNovoValor'];
                $roteiroComplemento[$controle] = TrataSqlInj($_POST['txtRoteiroComplemento']);
                
                If ($_POST['chkDesconto'] == "on") 
                {
                    $desconto[$controle] = "S";
                } 
                Else 
                {
                    $desconto[$controle] = "N";
                }
                $Qtde = $Qtde + $qtde[$controle];
            }
            else
            {
                $dataPartida[$controle]        = $_POST['txtDataPartida'.$controle];
                $horaPartida[$controle]        = $_POST['txtHoraPartida'.$controle];
                $dataChegada[$controle]        = $_POST['txtDataChegada'.$controle];
                $horaChegada[$controle]        = $_POST['txtHoraChegada'.$controle];
                $qtde[$controle]               = $_POST['txtQtdDiarias'.$controle];
                $valor[$controle]              = $_POST['txtNovoValor'.$controle];
                $roteiroComplemento[$controle] = TrataSqlInj($_POST['txtRoteiroComplemento'.$controle]);
                
                If ($_POST['chkDesconto'.$controle] == "on") 
                {
                    $desconto[$controle] = "S";                    
                } 
                Else 
                {
                    $desconto[$controle] = "N";
                }
                $Qtde = $Qtde + $qtde[$controle];
                $Desconto = $desconto[$controle];
            }           
            $controle --;
        }        
    }
    else         
    {                
        $qtdeRoteiros       = 0;
        $DataPartida        = $_POST['txtDataPartida'];
        $HoraPartida        = $_POST['txtHoraPartida'];
        $DataChegada        = $_POST['txtDataChegada'];
        $HoraChegada        = $_POST['txtHoraChegada'];
        $Qtde               = $_POST['txtQtdDiarias'];
        $Valor              = $_POST['txtNovoValor'];
        $RoteiroComplemento = TrataSqlInj($_POST['txtRoteiroComplemento']);
        
        If ($_POST['chkDesconto'] == "on") 
        {
            $Desconto = "S";
        } 
        Else 
        {
            $Desconto = "N";
        }
    }

    if($Etapa == '')
    {
        $Etapa = 0;
    }
      
    //verifica se ja existe o numero da diaria
    $sqlConsulta = "SELECT diaria_numero FROM diaria.diaria WHERE diaria_numero = '".$Numero."'";
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
    
    //cria padrao de numeracao 2008XXXXXX
    $NovoNumero  = $Numero + 1;
    $Tamanho     = strlen($Numero);
    $TamanhoZero = 5 - $Tamanho;

    For ($i = 1; $i <= $TamanhoZero; $i++) 
    {
        $Numero = "0" . $Numero;
    }

    $Numero = date("Y") . $Numero;
    //fim do criar padrao       
    If (pg_fetch_row($rsConsulta) == 0) 
    {
        //inicia transação no banco        
        $Date       = date("Y-m-d");
        $Time       = date("H:i:s"); 
        if($_POST['controleRoteiro'] > 0)
        {
            $controle = $_POST['controleRoteiro'];
            while($controle >= 0)
            {
                $Partida = dataToDB($dataPartida[$controle]);
                $Chegada = dataToDB($dataChegada[$controle]);
                // Procura por uma diária com o mesmo periodo ou dentro do periodo solicitado
                $existe_viagem = 0;

                $sql = "SELECT diaria_id,
                               diaria_dt_chegada,
                               diaria_dt_chegada,
                               qtde_roteiros
                          FROM diaria.diaria
                         WHERE diaria_beneficiario = $Beneficiario
                           AND diaria_excluida = 0 
                           AND ( 
                                    (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) OVERLAPS (DATE'$Partida', DATE'$Chegada')
                                  OR 
                                    (
                                       (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada') 
                                     OR 
                                       (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada')
                                    )
                                )";

                $consulta = pg_query(abreConexao(),$sql);

                if(pg_num_rows($consulta) > 0) 
                {
                    while($linhaConflito = pg_fetch_assoc($consulta))
                    {
                        if($linhaConflito['qtde_roteiros'] > 0)
                        {
                            $sqlConflitoMultiplo ="SELECT diaria_id, diaria_dt_saida, diaria_dt_chegada, dados_roteiro_status 
                                                    FROM diaria.dados_roteiro_multiplo 
                                                   WHERE diaria_id = ".$linhaConflito['diaria_id']." 
                                                     AND dados_roteiro_status = 0
                                                     AND ( (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) 
                                                OVERLAPS (DATE'$Partida', DATE'$Chegada') OR ( (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') 
                                                 BETWEEN '$Partida' AND '$Chegada') OR (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada') ) )";

                            $rsConflitoMultiplo = pg_query(abreConexao(),$sqlConflitoMultiplo);
                            
                            if(pg_num_rows($rsConflitoMultiplo) > 0)
                            {
                                $existeViagem = 1; 
                            }
                            else
                            {
                                $existeViagem = 0;
                            }
                        }
                        else
                        {
                            $existeViagem = 1;
                        }
                    }                    
                }
                $controle --;
            }
            if($existeViagem >= 1)
            {
                $existe_viagem = 1;
            }
            else
            {
                $existe_viagem = 0;
            }
        }
        else 
        {
            $Partida = dataToDB($DataPartida);
            $Chegada = dataToDB($DataChegada);
            // Procura por uma diária com o mesmo periodo ou dentro do periodo solicitado
            $existe_viagem = 0;

            $sql = "SELECT diaria_id,
                           diaria_dt_chegada,
                           diaria_dt_chegada,
                           qtde_roteiros
                      FROM diaria.diaria
                     WHERE diaria_beneficiario = $Beneficiario
                       AND diaria_excluida = 0 
                       AND ( 
                                (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) OVERLAPS (DATE'$Partida', DATE'$Chegada')
                              OR 
                                (
                                   (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada') 
                                 OR 
                                   (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada')
                                )
                            )";
            
            $consulta = pg_query(abreConexao(),$sql);

            if (pg_num_rows($consulta) > 0) 
            {
                while($linhaConflito = pg_fetch_assoc($consulta))
                {
                    if($linhaConflito['qtde_roteiros'] > 0)
                    {
                        $sqlConflitoMultiplo ="SELECT diaria_id, diaria_dt_saida, diaria_dt_chegada, dados_roteiro_status 
                                                FROM diaria.dados_roteiro_multiplo 
                                               WHERE diaria_id = ".$linhaConflito['diaria_id']." 
                                                 AND dados_roteiro_status = 0
                                                 AND ( (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) 
                                            OVERLAPS (DATE'$Partida', DATE'$Chegada') OR ( (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') 
                                             BETWEEN '$Partida' AND '$Chegada') OR (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada') ) )";

                        $rsConflitoMultiplo = pg_query(abreConexao(),$sqlConflitoMultiplo);
                        
                        if(pg_num_rows($rsConflitoMultiplo) > 0)
                        {
                            $existeViagem = 1; 
                        }
                        else
                        {
                            $existeViagem = 0;
                        }
                    }
                    else
                    {
                        $existe_viagem = 1;
                    }
                }                
            } 
            else 
            {
                $existe_viagem = 0;
            }
        }                
        
        // CASO NÂO EXISTA UMA DIÁRIA NO PERÍODO SOLICITADO CONCRETIZA A DIÁRIA.		
        if ($existe_viagem == 0) 
        {         
            $BeginTrans = "BEGIN WORK";
            pg_query(abreConexao(), $BeginTrans); 
            
            // Executa a Inserção na Tabela diaria      
            if ($Diaria_local_solicitacao == "Coordenadoria") 
            {
                $Diaria_st = 100;
            }
            else
            {
                $Diaria_st = 0;
            }    
            
            $sqlInsere = "INSERT INTO diaria.diaria 
                                    (diaria_numero, 
                                    diaria_solicitante, 
                                    diaria_beneficiario, 
                                    diaria_dt_saida, 
                                    diaria_hr_saida,
                                    diaria_dt_chegada, 
                                    diaria_hr_chegada, 
                                    diaria_valor_ref, 
                                    diaria_desconto, 
                                    diaria_qtde, 
                                    diaria_valor, 
                                    diaria_justificativa_feriado, 
                                    diaria_justificativa_fds, meio_transporte_id, 
                                    diaria_transporte_obs, 
                                    diaria_descricao, 
                                    diaria_unidade_custo,
                                    projeto_cd, 
                                    acao_cd, 
                                    territorio_cd, 
                                    fonte_cd,
                                    diaria_st,
                                    diaria_dt_criacao, 
                                    diaria_hr_criacao, 
                                    diaria_roteiro_complemento, 
                                    diaria_local_solicitacao,
                                    id_coordenadoria,
                                    data_viagem_saida, 
                                    data_viagem_chegada,
                                    etapa_id,
                                    qtde_roteiros)
                        VALUES      ('$Numero',
                                    '$Solicitante',
                                    '$Beneficiario',
                                    '$DataPartida',
                                    '$HoraPartida',
                                    '$DataChegada',
                                    '$HoraChegada',
                                    '$ValorRef',
                                    '$Desconto',
                                    '$Qtde',
                                    '$Valor',
                                    '$JustificativaFeriado',
                                    '$JustificativaFimSemana',
                                    '$MeioTransporte',
                                    '$TransporteObservacao', 
                                    '$Descricao',
                                    '$UnidadeCusto',
                                    '$Projeto',
                                    '$Acao',
                                    '$Territorio',
                                    '$Fonte',
                                    '$Diaria_st',
                                    '$Date',
                                    '$Time',
                                    '$RoteiroComplemento',
                                    '$Diaria_local_solicitacao',
                                    '$Id_coordenadoria',
                                    NULL,
                                    NULL,
                                    $Etapa,
                                    $qtdeRoteiros)                
                        RETURNING diaria_id";    
            $rsCodigo = pg_query(abreConexao(), $sqlInsere);
            // Fim da Inserção na Tabela Diária e recupera o ID da diária inserida
            $ultimoIdDiaria = pg_fetch_array($rsCodigo);                                               
            
            $sqlInsere = "INSERT INTO diaria.diaria_motivo 
                                    (diaria_id, motivo_id, sub_motivo_id) 
                                VALUES (".$ultimoIdDiaria['diaria_id'].", ".$Motivo.", ".$SubMotivo.")";
            
            pg_query(abreConexao(), $sqlInsere);
            
            // Controle para inserção em multiplus roteiros
            if($_POST['controleRoteiro'] > 0)
            {                               
                $controle = $_POST['controleRoteiro'];
                
                while($controle >= 0)
                {
                    $sqlDadosRoteiro = 
                    "INSERT INTO diaria.dados_roteiro_multiplo
                     (  
                        diaria_id,                                                
                        diaria_dt_saida,
                        diaria_hr_saida,
                        diaria_dt_chegada,
                        diaria_hr_chegada,
                        diaria_qtde,
                        diaria_desconto,
                        diaria_valor,
                        diaria_roteiro_complemento,
                        controle_roteiro,
                        dados_roteiro_status)
                    VALUES 
                    (
                        ".$ultimoIdDiaria['diaria_id'].",
                        '$dataPartida[$controle]',
                        '$horaPartida[$controle]',      
                        '$dataChegada[$controle]',   
                        '$horaChegada[$controle]',      
                        '$qtde[$controle]',  
                        '$desconto[$controle]',
                        '$valor[$controle]',            
                        '$roteiroComplemento[$controle]',
                        $controle,
                        0
                    )"; 
                    pg_query(abreConexao(), $sqlDadosRoteiro);
                    
                    For ($i = 1; $i <= $_SESSION['ContadorDestino'][$controle]; $i++) 
                    {
                        $sqlInsere = "INSERT INTO diaria.roteiro
                                                  (diaria_id, roteiro_origem, roteiro_destino, controle_roteiro) 
                                           VALUES (".$ultimoIdDiaria['diaria_id'].", ".$_SESSION['ViagemOrigem'][$controle][$i].", ".$_SESSION['ViagemDestino'][$controle][$i].", $controle)";                        
                        pg_query(abreConexao(), $sqlInsere);
                    }
                    $controle --;
                }
            }
            else
            {
                For ($i = 1; $i <= $_SESSION['ContadorDestino'][0]; $i++) 
                {
                    $sqlInsere = "INSERT INTO diaria.roteiro
                                              (diaria_id, roteiro_origem, roteiro_destino) 
                                       VALUES (".$ultimoIdDiaria['diaria_id'].", ".$_SESSION['ViagemOrigem'][0][$i].", ".$_SESSION['ViagemDestino'][0][$i].")";
                    pg_query(abreConexao(), $sqlInsere);
                }
            }            
            /*
            ' ********************************************************************
            ' Bloqueia o acesso ao sistema de diária após a solicitação
            '*********************************************************************
            */
            $sqlAltera = "UPDATE seguranca.usuario 
                        SET usuario_diaria = 0  
                        WHERE pessoa_id = ".$Beneficiario;
            pg_query(abreConexao(), $sqlAltera);
            /*
            ' ********************************************************************
            ' Registra o Numero da Diária que foi autorizada para o usuário.
            '*********************************************************************
            */

            $sqlConsulta = "SELECT MAX(diaria_liberacao_id)as total 
                            FROM diaria.diaria_liberacao 
                            WHERE diaria_beneficiario = ".$Beneficiario;

            $rsConsulta     = pg_query(abreConexao(), $sqlConsulta);
            $linhaLiberacao = pg_fetch_assoc($rsConsulta);

            If ($linhaLiberacao['total'] > 0)
            {
                $NumeroLiberacao = $linhaLiberacao['total'];
            }
            else
            {
                $NumeroLiberacao = 0;
            }
            $sqlAltera = "UPDATE diaria.diaria_liberacao 
                        SET diaria_id = ".$ultimoIdDiaria['diaria_id']."  
                        WHERE diaria_beneficiario = ".$Beneficiario."
                        AND diaria_liberacao_id = ".$NumeroLiberacao;
            pg_query(abreConexao(), $sqlAltera);

            //altera o numero da proxima diaria
            $sqlAltera = "UPDATE diaria.diaria_numero 
                        SET diaria_numero = " . $NovoNumero;            
            pg_query(abreConexao(), $sqlAltera);

            If ($Err != 0) 
            {
                $RollbackTrans = "ROLLBACK";
                pg_query(abreConexao(), $RollbackTrans);
                echo $Err;
            } 
            Else 
            {
                $CommitTrans = "COMMIT";
                pg_query(abreConexao(), $CommitTrans);
                 
                $saldoValorSub = trim($_POST['saldoValorSub']);
                
                if($Etapa == 0)
                {
                    $dataAlteracao = date("Y/m/d");                    
                    //Caso não exista etapa os saldos atualizados serão dos projetos e fontes
                    if((($Fonte != 'XX')&&($Fonte != '0'))&&(($Projeto != '')&&($Projeto != '1000')))
                    {
                        $ano        = date("Y");
                        $sqlAltera  = "UPDATE diaria.saldo_projeto_fonte
                                          SET saldo_valor =".$saldoValorSub.",
                                              data_atualizacao = '".$dataAlteracao."'
                                        WHERE id_saldo_projeto =".$Projeto."
                                          AND id_saldo_fonte ='".$Fonte."'
                                          AND DATE_PART('YEAR', data_criacao) = '$ano'
                                          AND saldo_mes = '".substr($DataPartida,3,2)."'";

                        pg_query(abreConexao(), $sqlAltera);
                    }
                }
                else
                {
                    $saldoEtapa        = $_POST['saldoEtapa'];
                    $diariaNivelEsc    = $_POST['saldoNivel']; 
                    
                    if($diariaNivelEsc == 'superior')
                    {
                        $sqlUpdate = "UPDATE diaria.etapa
                                         SET saldo_superior = ".$saldoEtapa."
                                       WHERE etapa_id = ".$Etapa;                                                                                               
                    }
                    else
                    {
                        $sqlUpdate = "UPDATE diaria.etapa
                                         SET saldo_medio = ".$saldoEtapa."
                                       WHERE etapa_id = ".$Etapa;                  
                    }
                    pg_query(abreConexao(), $sqlUpdate); 
                }
            }            
        } 
        else 
        {   // Fim Se já existe uma diária com o mesmo periodo ou dentro do periodo solicitado               
            echo "<script>alert(\"Você não pode Solicitar uma Diária para o período solicitado, pois já existe uma diária neste período para o beneficiário informado!!!\");</script>";
            echo "<script>return false;</script>";
            echo "<script>window.location = '".$PaginaLocal."Inicio.php';</script>";          
            exit;
        }
        echo "<script>window.location = '".$PaginaLocal."Inicio.php';</script>";
    } 
    Else 
    {
        $MensagemErroBD = "NÚMERO DE DIÁRIA JÁ EXISTE, CONTACTE O ADMINISTRADOR.";
    }
   // Fim da Ação Sistema "INCLUIR" 
    exit;
}

function Alterar($PaginaLocal)
{        
    $codigo         = $_POST['txtCodigo'];
    $status         = $_POST['txtStatus'];     
    
    //CAPTURA OS VALORES E ATRIBUI NAS VARIÁVEIS   
    $DataPartida  = $_POST['txtDataPartida'];
    $HoraPartida  = $_POST['txtHoraPartida'];        
    $justificativaFeriado     = TrataSqlInj($_POST['txtJustificativaFeriado']);
    $justificativaFimSemana   = TrataSqlInj($_POST['txtJustificativaFimSemana']);
    $meioTransporte           = $_POST['cmbMeioTransporte'];
    $transporteObservacao     = TrataSqlInj($_POST['txtMeioTransporteObservacao']);
    $motivo                   = $_POST['cmbMotivoDiaria'];
    $subMotivo                = $_POST['cmbSubMotivoDiaria'];
    $descricao                = TrataSqlInj($_POST['txtDescricao']);
    $RoteiroComplemento       = TrataSqlInj($_POST['txtRoteiroComplemento']);
    $unidadeCusto             = $_POST['cmbUnidadeCusto'];    
    $acao                     = $_POST['cmbAcao'];
    $territorio               = $_POST['cmbTerritorio'];    
    $novoCalculo              = $_POST['txtNovoCalculo'];
    $id_beneficiario          = $_POST['cmbBeneficiario'];   
    $numero                   = $_POST['txtNumero'];    
    $diaria_local_solicitacao = $_POST['radioCoordenadoria']; // Atributo Novo Colocado por Erinaldo em 19/02/2011
    $id_coordenadoria         = $_POST['comboCordenadoriaInterior'];
    
    $fonte         = trim($_POST['cmbFonte']);
    $projeto       = trim($_POST['cmbProjeto']);
    $saldoValorSub = trim($_POST['saldoValorSub']);
    $fonteAnte     = trim($_POST['txtFonte']);
    $projetoAnte   = trim($_POST['txtProjeto']);
    $saldoAnte     = trim($_POST['saldoValorAnt']);
    $diariaAnte    = trim($_POST['dtDiariaAnt']);    
    $etapaId       = trim($_POST['cmbEtapa']);
    $etapaIdAnt    = $_POST['txtEtapa'];      
    
    if($_POST['txtNovoValorRef'] != '')
    {
        $valorRef = $_POST['txtNovoValorRef'];
    }
    else
    {
        $valorRef = $_POST['txtValorReferencia'];
    }
    
    if($_POST['roteirosExcluidos'] > 0)
    {
        if(($_POST['qtdeRoteiros'.$_POST['controleRoteiro']] - $_POST['roteirosExcluidos']) > 1)
        {
            $qtdeRoteiros = $_POST['qtdeRoteiros'.$_POST['controleRoteiro']] - $_POST['roteirosExcluidos'];
        }
        else 
        {
            $qtdeRoteiros = 0;
        }        
    }
    else 
    {
        $qtdeRoteiros = $_POST['qtdeRoteiros'.$_POST['controleRoteiro']];
    }   
          
    //Capiturando valores dos multiplos roteiros
    if($qtdeRoteiros > 0)
    {        
        $controle     = $_POST['controleRoteiro'];   
        if($_POST['NovoValorTotalDiarias'] != '')
        {
            $novoCalculo = 1;
        }
        $Valor        = $_POST['NovoValorTotalDiarias'];        
        $DataChegada  = $_POST['txtDataChegada'.($_POST['controleRoteiro'])];
        $HoraChegada  = $_POST['txtHoraChegada'.($_POST['controleRoteiro'])];        
         
        while($controle >= 0)
        {                   
            if($controle == 0)
            {
                if($_POST['hdValorDiaria'] == NULL)
                {
                    $qtde[$controle]  = $_POST['txtQtdDiarias'];
                    $valor[$controle] = $_POST['txtNovoValor'];
                }
                else
                {
                    $qtde[$controle]  = $_POST['hdQtdeDiaria'];
                    $valor[$controle] = $_POST['hdValorDiaria'];
                }
                
                $dataPartida[$controle]        = $_POST['txtDataPartida'];
                $horaPartida[$controle]        = $_POST['txtHoraPartida'];
                $dataChegada[$controle]        = $_POST['txtDataChegada'];
                $horaChegada[$controle]        = $_POST['txtHoraChegada'];                
                $alterarRoteiro[$controle]     = $_POST['alterarRoteiro'];
                $roteiroComplemento[$controle] = TrataSqlInj($_POST['txtRoteiroComplemento']);

                If ($_POST['chkDesconto'] == "on") 
                {
                    $desconto[$controle] = "S";
                } 
                Else 
                {
                    $desconto[$controle] = "N";
                }
                $Qtde = $Qtde + $qtde[$controle];
            }
            else
            {
                if($_POST['hdValorDiaria'.$controle] == NULL)
                {
                    $qtde[$controle]  = $_POST['txtQtdDiarias'.$controle];
                    $valor[$controle] = $_POST['txtNovoValor'.$controle];
                }
                else
                {
                    $qtde[$controle]  = $_POST['hdQtdeDiaria'.$controle];
                    $valor[$controle] = $_POST['hdValorDiaria'.$controle];
                }
                $dataPartida[$controle]        = $_POST['txtDataPartida'.$controle];
                $horaPartida[$controle]        = $_POST['txtHoraPartida'.$controle];
                $dataChegada[$controle]        = $_POST['txtDataChegada'.$controle];
                $horaChegada[$controle]        = $_POST['txtHoraChegada'.$controle];                
                $alterarRoteiro[$controle]     = $_POST['alterarRoteiro'.$controle];
                $roteiroComplemento[$controle] = TrataSqlInj($_POST['txtRoteiroComplemento'.$controle]);

                If ($_POST['chkDesconto'.$controle] == "on") 
                {
                    $desconto[$controle] = "S";                    
                } 
                Else 
                {
                    $desconto[$controle] = "N";
                }
                $Qtde = $Qtde + $qtde[$controle];
                $Desconto = $desconto[$controle];
            }             
            $roteiroExcluido[$controle] = $_POST['roteiroExcluido'.$controle];             
            $controle --;
        }        
    }
    else         
    {                
        $qtdeRoteiros       = 0;
        $alterarRoteiro     = $_POST['alterarRoteiro'];        
        $DataChegada        = $_POST['txtDataChegada'];
        $HoraChegada        = $_POST['txtHoraChegada'];        
        $Qtde               = $_POST['txtQtdDiarias'];
        $Valor              = $_POST['txtNovoValor'];                        
        
        If ($_POST['chkDesconto'] == "on") 
        {
            $Desconto = "S";
        } 
        Else 
        {
            $Desconto = "N";
        }
    }        
    
    if($etapaId != '')
    {
        $adicionaEtapa = " etapa_id = '$etapaId' ,";
    }
    else 
    {
        $adicionaEtapa = " etapa_id = 0,";
    }

    //TRATA OS VALORES ANTES DA INSERÇÃO
    $dataAlteracao    = date("Y/m/d");            
    
    // Testa se já existe diária para o período para o qual esta diária foi alterada        
    if($qtdeRoteiros > 0)
    {
        $controle = $qtdeRoteiros;
        
        while($controle >= 0)
        {            
            if(($dataPartida[$controle] != '')&&($dataChegada[$controle] != ''))
            {
                $Partida = dataToDB($dataPartida[$controle]);
                $Chegada = dataToDB($dataChegada[$controle]);      
                $mudancaPeriodo = 0;
            }
            elseif(($dataPartida[$controle] != '')||($dataChegada[$controle] != ''))
            {
                //Consulta a diária antes da alteração para validar algumas alterações
                $sqlConsultaDiaria   = "SELECT * FROM diaria.dados_roteiro_multiplo WHERE diaria_id = ".$codigo." AND controle_roteiro = ".$controle;
                $rsConsultaDiaria    = pg_query(abreConexao(), $sqlConsultaDiaria);
                $linhaConsultaDiaria = pg_fetch_assoc($rsConsultaDiaria);

                if($dataPartida != '')
                {
                    $Partida = dataToDB($dataPartida[$controle]);
                    $Chegada = dataToDB($linhaConsultaDiaria['diaria_dt_chegada']);
                }
                else 
                {
                    $Partida = dataToDB($linhaConsultaDiaria['diaria_dt_saida']);
                    $Chegada = dataToDB($dataChegada[$controle]);
                }
                $mudancaPeriodo = 0;
            }            
            else
            {
                $mudancaPeriodo = 1;
                $existe_viagem  = 0;
            }
            
            if($mudancaPeriodo == 0)
            {
                // Procura por uma diária com o mesmo periodo ou dentro do periodo solicitado
                $sqlTesteSeExiste = "SELECT diaria_id,
                                    diaria_numero,
                                    diaria_dt_saida,
                                    diaria_dt_chegada,
                                    qtde_roteiros
                             FROM diaria.diaria
                            WHERE diaria_beneficiario = $id_beneficiario
                              AND diaria_numero != '".$numero."'
                              AND diaria_excluida = 0                        
                              AND ( 
                                    (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) OVERLAPS (DATE'$Partida', DATE'$Chegada')
                                  OR 
                                    (
                                       (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada') 
                                     OR 
                                       (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada')
                                    )
                                )";

                $existe_viagem = 0;

                $consulta = pg_query(abreConexao(), $sqlTesteSeExiste);
                
                if(pg_num_rows($consulta) > 0) 
                {
                    while($linhaConflito = pg_fetch_assoc($consulta))
                    {
                        if($linhaConflito['qtde_roteiros'] > 0)
                        {
                            $sqlConflitoMultiplo ="SELECT diaria_id, diaria_dt_saida, diaria_dt_chegada, dados_roteiro_status 
                                                    FROM diaria.dados_roteiro_multiplo 
                                                   WHERE diaria_id = ".$linhaConflito['diaria_id']." 
                                                     AND dados_roteiro_status = 0
                                                     AND ( (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) 
                                                OVERLAPS (DATE'$Partida', DATE'$Chegada') OR ( (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') 
                                                 BETWEEN '$Partida' AND '$Chegada') OR (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada') ) )";

                            $rsConflitoMultiplo = pg_query(abreConexao(),$sqlConflitoMultiplo);
                            
                            if(pg_num_rows($rsConflitoMultiplo) > 0)
                            {
                                $existeViagem = 1; 
                            }
                            else
                            {
                                $existeViagem = 0;
                            }
                        }
                        else
                        {
                            $existeViagem = 1;
                        }
                    }                    
                } 
            }
            $controle --;
        }
        
        if($existeViagem >= 1)
        {
            $existe_viagem = 1;
        }
        else
        {
            $existe_viagem = 0;
        }
    }
    else 
    {                
        if(($dataPartida != '')&&($dataChegada != ''))
        {
            $Partida = dataToDB($dataPartida);
            $Chegada = dataToDB($dataChegada);            
        }
        elseif(($dataPartida != '')||($dataChegada != ''))
        {
            //Consulta a diária antes da alteração para validar algumas alterações
            $sqlConsultaDiaria   = "SELECT * FROM diaria.diaria WHERE diaria_id = ".$codigo;
            $rsConsultaDiaria    = pg_query(abreConexao(), $sqlConsultaDiaria);
            $linhaConsultaDiaria = pg_fetch_assoc($rsConsultaDiaria);
            
            if($dataPartida != '')
            {
                $Partida = dataToDB($dataPartida);
                $Chegada = dataToDB($linhaConsultaDiaria['diaria_dt_chegada']);
            }
            else 
            {
                $Partida = dataToDB($linhaConsultaDiaria['diaria_dt_saida']);
                $Chegada = dataToDB($dataChegada);
            }
        }
        else
        {
            $mudancaPeriodo = 1;
            $existe_viagem  = 0;
        }
        
        if($mudancaPeriodo != 1)
        {
            // Procura por uma diária com o mesmo periodo ou dentro do periodo solicitado
            $existe_viagem = 0;    

            $sqlTesteSeExiste = "SELECT diaria_id,
                                    diaria_numero,
                                    diaria_dt_saida,
                                    diaria_dt_chegada
                             FROM diaria.diaria
                            WHERE diaria_beneficiario = $id_beneficiario
                              AND diaria_numero != '".$numero."'
                              AND diaria_excluida = 0                        
                              AND ( 
                                    (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) OVERLAPS (DATE'$Partida', DATE'$Chegada')
                                  OR 
                                    (
                                       (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada') 
                                     OR 
                                       (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada')
                                    )
                                )";            
            $consulta = pg_query(abreConexao(), $sqlTesteSeExiste);
            
            if(pg_num_rows($consulta) > 0) 
            {
                while($linhaConflito = pg_fetch_assoc($consulta))
                {
                    if($linhaConflito['qtde_roteiros'] > 0)
                    {
                        $sqlConflitoMultiplo ="SELECT diaria_id, diaria_dt_saida, diaria_dt_chegada, dados_roteiro_status 
                                                FROM diaria.dados_roteiro_multiplo 
                                               WHERE diaria_id = ".$linhaConflito['diaria_id']." 
                                                 AND dados_roteiro_status = 0
                                                 AND ( (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) 
                                            OVERLAPS (DATE'$Partida', DATE'$Chegada') OR ( (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') 
                                             BETWEEN '$Partida' AND '$Chegada') OR (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$Partida' AND '$Chegada') ) )";

                        $rsConflitoMultiplo = pg_query(abreConexao(),$sqlConflitoMultiplo);

                        if(pg_num_rows($rsConflitoMultiplo) > 0)
                        {
                            $existeViagem = 1; 
                        }
                        else
                        {
                            $existeViagem = 0;
                        }
                    }
                    else
                    {
                        $existeViagem = 1;
                    }
                }                    
            }
        }
    }      
 
    if ($existe_viagem > 0) 
    {
        echo "<script>alert('Você não pode solicitar uma Diária para o periodo solicitado, já existe uma diária dentro do perfil informado.!!!');</script>";
        echo "<script>window.location = '".$PaginaLocal."Inicio.php';</script>";       
    }
    else
    {        
        if($qtdeRoteiros > 0)
        { 
            $controle = $_POST['controleRoteiro'];            
             
            while($controle >= 0)
            {                                         
                if($roteiroExcluido[$controle] == 1)
                {
                    $deletaDadosRoteiro = "UPDATE diaria.dados_roteiro_multiplo
                                                  SET dados_roteiro_status = 2  
                                                WHERE controle_roteiro = ".$controle."
                                                  AND diaria_id = ".$codigo;                    
                    pg_query(abreConexao(), $deletaDadosRoteiro);           
                    
                    $sqlDelete = "DELETE FROM diaria.roteiro
                                        WHERE controle_roteiro = $controle
                                          AND diaria_id = ".$codigo;       
                    pg_query(abreConexao(), $sqlDelete);                       
                }
                else
                {
                    $sqlDadosRoteiro   = "SELECT * FROM diaria.dados_roteiro_multiplo WHERE controle_roteiro =".$controle." AND diaria_id = ".$codigo;
                    $rsDadosRoteiro    = pg_query(abreConexao(), $sqlDadosRoteiro);
                    $linhaDadosRoteiro = pg_fetch_assoc($rsDadosRoteiro);
                     
                    if(($dataPartida[$controle] != $linhaDadosRoteiro['diaria_dt_saida'])||
                       ($dataChegada[$controle] != $linhaDadosRoteiro['diaria_dt_chegada'])||
                       ($horaPartida[$controle] != $linhaDadosRoteiro['diaria_hr_saida'])||
                       ($horaChegada[$controle] != $linhaDadosRoteiro['diaria_hr_chegada'])||
                       ($valor[$controle] != $linhaDadosRoteiro['diaria_valor'])||
                       ($linhaDadosRoteiro == ''))
                    {                       
                        if($linhaDadosRoteiro != '')
                        {
                            $deletaDadosRoteiro = "UPDATE diaria.dados_roteiro_multiplo
                                                    SET dados_roteiro_status = 2  
                                                  WHERE controle_roteiro = ".$controle."
                                                    AND diaria_id = ".$codigo;                             
                            pg_query(abreConexao(), $deletaDadosRoteiro);                            
                        }                        
                        
                        $sqlDadosRoteiro = 
                        "INSERT INTO diaria.dados_roteiro_multiplo
                         (  
                            diaria_id,                                                
                            diaria_dt_saida,
                            diaria_hr_saida,
                            diaria_dt_chegada,
                            diaria_hr_chegada,
                            diaria_qtde,
                            diaria_desconto,
                            diaria_valor,
                            diaria_roteiro_complemento,
                            controle_roteiro,
                            dados_roteiro_status)
                        VALUES 
                        (
                            $codigo,
                            '$dataPartida[$controle]',
                            '$horaPartida[$controle]',      
                            '$dataChegada[$controle]',   
                            '$horaChegada[$controle]',      
                            '$qtde[$controle]',  
                            '$desconto[$controle]',
                            '$valor[$controle]',            
                            '$roteiroComplemento[$controle]',
                            $controle,
                            0
                        )";                                   
                        pg_query(abreConexao(), $sqlDadosRoteiro);
                    }  

                    if(($alterarRoteiro[$controle] == 1)||($linhaDadosRoteiro == ''))
                    {   
                        For ($i = 1; $i <= $_SESSION['ContadorDestino'][$controle]; $i++) 
                        {                              
                            if($alterarRoteiro[$controle] == 1)
                            {
                                if($i == 1)
                                {                                                                    
                                    $sqlDeletaRoteiro = "DELETE FROM diaria.roteiro
                                                               WHERE controle_roteiro = $controle
                                                                 AND diaria_id = ".$codigo;       
                                    pg_query(abreConexao(), $sqlDeletaRoteiro);                                
                                }
                            }

                            $sqlInsere = "INSERT INTO diaria.roteiro
                                                      (diaria_id, roteiro_origem, roteiro_destino, controle_roteiro) 
                                               VALUES ($codigo, ".$_SESSION['ViagemOrigem'][$controle][$i].", ".$_SESSION['ViagemDestino'][$controle][$i].", $controle)";                        
                            pg_query(abreConexao(), $sqlInsere);                                                                                
                        }                                                 
                    }          
                } 
                $controle --;
            } 
            
            if($_POST['roteirosExcluidos'] > 0)
            {
                $novoCalculo   = 1;
                $controleLinha = 0;
                $sqlRoteirosExistentes = "SELECT * FROM diaria.dados_roteiro_multiplo 
                                           WHERE diaria_id = $codigo 
                                             AND dados_roteiro_status = 0 
                                        ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY')";
                $rsRoteirosExistentes = pg_query(abreConexao(), $sqlRoteirosExistentes);
                
                while($linha = pg_fetch_assoc($rsRoteirosExistentes)) 
                {                    
                    if($controleLinha != $linha['controle_roteiro'])
                    {
                        $sqlUpdateRoteiro = "UPDATE diaria.roteiro 
                                                SET controle_roteiro = $controleLinha
                                              WHERE diaria_id = ".$linha['diaria_id']."
                                                AND controle_roteiro = ".$linha['controle_roteiro'];
                        pg_query(abreConexao(), $sqlUpdateRoteiro);
                        
                        $sqlUpdateDadosRoteiro = "UPDATE diaria.dados_roteiro_multiplo 
                                                     SET controle_roteiro = $controleLinha
                                                   WHERE diaria_id = ".$linha['diaria_id']."
                                                     AND controle_roteiro = ".$linha['controle_roteiro']."
                                                     AND dados_roteiro_status = 0";
                        pg_query(abreConexao(), $sqlUpdateDadosRoteiro);                        
                    }
                    $controleLinha ++;
                }
            }            
        }
        else
        {                 
            if($_POST['roteirosExcluidos'] > 0)
            {                
                $controle = $_POST['controleRoteiro']; 
                while($controle > 0)
                {                                             
                    if($_POST['roteiroExcluido'.$controle] == 1)
                    {
                        $sqlDelete = "DELETE FROM diaria.roteiro
                                            WHERE controle_roteiro = $controle
                                              AND diaria_id = ".$codigo;
                        pg_query(abreConexao(), $sqlDelete);
                    }
                    else 
                    {
                        $sqlAltera = "UPDATE diaria.roteiro SET controle_roteiro = NULL WHERE controle_roteiro = $controle AND diaria_id = ".$codigo;
                        pg_query(abreConexao(), $sqlAltera);
                        
                        $sqlConsultaDadosRoteiro   = "SELECT drm.diaria_desconto, drm.diaria_qtde, drm.diaria_dt_saida, drm.diaria_hr_saida, drm.diaria_dt_chegada, drm.diaria_hr_chegada, d.diaria_valor_ref FROM diaria.diaria d
                                                        JOIN diaria.dados_roteiro_multiplo drm
                                                          ON d.diaria_id = drm.diaria_id
                                                       WHERE d.diaria_id = 56437 AND drm.controle_roteiro = 1 = ".$codigo." AND controle_roteiro = ".$controle;
                        $rsConsultaDadosRoteiro    = pg_query(abreConexao(), $sqlConsultaDadosRoteiro);
                        $linhaConsultaDadosRoteiro = pg_fetch_assoc($rsConsultaDadosRoteiro);
                        
                        $Desconto     = $linhaConsultaDadosRoteiro['diaria_desconto'];
                        $Qtde         = $linhaConsultaDadosRoteiro['diaria_qtde'];       
                        $Valor        = $_POST['NovoValorTotalDiarias'];
                        $DataPartida  = $linhaConsultaDadosRoteiro['diaria_dt_saida']; 
                        $HoraPartida  = $linhaConsultaDadosRoteiro['diaria_hr_saida'];
                        $DataChegada  = $linhaConsultaDadosRoteiro['diaria_dt_chegada'];
                        $HoraChegada  = $linhaConsultaDadosRoteiro['diaria_hr_chegada'];
                        $valorRef     = $linhaConsultaDadosRoteiro['diaria_valor_ref'];
                        $novoCalculo  = 1;
                    }
                    $controle --;
                }
                $deleteDadosRoteiroMultiplo = "UPDATE diaria.dados_roteiro_multiplo
                                                      SET dados_roteiro_status = 2  
                                                    WHERE diaria_id = ".$codigo;
                pg_query(abreConexao(), $deleteDadosRoteiroMultiplo); 
            }
            
            If($alterarRoteiro == 1)
            {
                $sqlDelete = "DELETE FROM diaria.roteiro
                                    WHERE diaria_id = ".$codigo;    
                
                pg_query(abreConexao(), $sqlDelete);

                For($e = 1; $e <= $_SESSION['ContadorDestino'][0]; $e++) 
                {
                    $sqlInsere = "INSERT INTO diaria.roteiro
                                              (diaria_id, roteiro_origem, roteiro_destino) 
                                       VALUES ($codigo, ".$_SESSION['ViagemOrigem'][0][$e].", ".$_SESSION['ViagemDestino'][0][$e].")";
                        pg_query(abreConexao(), $sqlInsere);
                }
            }            
        }
        //CASO O CALCULO SEJA ALTERADO INSERE O TRECHO DE CÓDIGO ABAIXO NA ATUALIZAÇÃO DA DIÁRIA 
        If ($novoCalculo == 1) 
        {
            $sqlAlteraCalculo = ", diaria_valor_ref = '$valorRef',
                                   diaria_desconto  = '$Desconto',
                                   diaria_qtde      = '$Qtde', 
                                   diaria_valor     = '$Valor' ";        
        }
        else
        {
            $sqlAlteraCalculo = "";
        }
        //PREPARA A QUERY DO UPDATE E Á EXECUTA EM SEGUIDA
        $sqlAltera = "UPDATE diaria.diaria 
                            SET diaria_dt_saida              = '$DataPartida', 
                                diaria_hr_saida              = '$HoraPartida',
                                diaria_dt_chegada            = '$DataChegada',
                                diaria_hr_chegada            = '$HoraChegada',
                                diaria_justificativa_feriado = '$justificativaFeriado',
                                diaria_justificativa_fds     = '$justificativaFimSemana',
                                meio_transporte_id           = '$meioTransporte', 
                                diaria_transporte_obs        = '$transporteObservacao',
                                diaria_descricao             = '$descricao', 
                                diaria_unidade_custo         = '$unidadeCusto', 
                                projeto_cd                   = '$projeto', 
                                acao_cd                      = '$acao', 
                                territorio_cd                = '$territorio', 
                                fonte_cd                     = '$fonte', 
                                " .$adicionaEtapa. "
                                diaria_roteiro_complemento   = '$RoteiroComplemento', 
                                diaria_devolvida             = 0, 
                                diaria_dt_alteracao          = '$dataAlteracao',
                                diaria_local_solicitacao     = '$diaria_local_solicitacao',
                                id_coordenadoria             = $id_coordenadoria,
                                diaria_beneficiario          = $id_beneficiario,
                                qtde_roteiros                = $qtdeRoteiros    
                                " .$sqlAlteraCalculo. "                            
                          WHERE diaria_id                    = ".$codigo;
  
        pg_query(abreConexao(), $sqlAltera);

        if($motivo != '')
        {
            $sqlAltera = "UPDATE diaria.diaria_motivo 
                             SET motivo_id     = '$motivo', 
                                 sub_motivo_id = '$subMotivo' 
                           WHERE diaria_id     = ".$codigo;
            pg_query(abreConexao(), $sqlAltera);
        }
                           
        //Verifica se Existe etapa para atuaizar os saldos.
        if(($etapaId == '')||($etapaId == 0))
        {
            if(($etapaIdAnt == '')&&($etapaIdAnt == 0))
            {
                //Caso não exista etapa os saldos atualizados serão dos projetos e fontes            
                if((($fonte != 'XX')&&($fonte != '0'))&&(($projeto != '')&&($projeto != '1000')))
                {            
                    if(($projetoAnte == $projeto)&&($fonteAnte == $fonte))
                    {
                        if(substr($diariaAnte,3,2) == substr($dataPartida,3,2))
                        {
                            $ano        = date("Y");
                            $sqlAltera  = "UPDATE diaria.saldo_projeto_fonte
                                            SET saldo_valor =".$saldoValorSub.",
                                                data_atualizacao = '".$dataAlteracao."'
                                          WHERE id_saldo_projeto =".$projeto."
                                            AND id_saldo_fonte ='".$fonte."'
                                            AND DATE_PART('YEAR', data_criacao) = '$ano'
                                            AND saldo_mes = '".substr($dataPartida,3,2)."'";                                             
                            pg_query(abreConexao(), $sqlAltera);
                        }
                        else
                        {
                            $ano            = date("Y");
                            $sqlAlteraVelho = "UPDATE diaria.saldo_projeto_fonte
                                              SET saldo_valor =".$saldoAnte.",
                                                  data_atualizacao = '".$dataAlteracao."'
                                            WHERE id_saldo_projeto =".$projetoAnte."
                                              AND id_saldo_fonte ='".$fonteAnte."'
                                              AND DATE_PART('YEAR', data_criacao) = '$ano'
                                              AND saldo_mes = '".substr($diariaAnte,3,2)."'";                                  
                            pg_query(abreConexao(), $sqlAlteraVelho);

                            $sqlAlteraNovo  = "UPDATE diaria.saldo_projeto_fonte
                                                  SET saldo_valor =".$saldoValorSub.",
                                                      data_atualizacao = '".$dataAlteracao."'
                                                WHERE id_saldo_projeto =".$projeto."
                                                  AND id_saldo_fonte ='".$fonte."'
                                                  AND DATE_PART('YEAR', data_criacao) = '$ano'
                                                  AND saldo_mes = '".substr($dataPartida,3,2)."'";
                            pg_query(abreConexao(), $sqlAlteraNovo);
                        }
                    }
                    elseif(($projetoAnte == '')||($projetoAnte == '1000')||($fonteAnte == 'XX')||($fonteAnte == '0'))
                    {
                        $ano        = date("Y");
                        $sqlAltera  = "UPDATE diaria.saldo_projeto_fonte
                                          SET saldo_valor =".$saldoValorSub.",
                                              data_atualizacao = '".$dataAlteracao."'
                                        WHERE id_saldo_projeto =".$projeto."
                                          AND id_saldo_fonte ='".$fonte."'
                                          AND DATE_PART('YEAR', data_criacao) = '$ano'
                                          AND saldo_mes = '".substr($dataPartida,3,2)."'";

                        pg_query(abreConexao(), $sqlAltera);
                    }
                    elseif(($projetoAnte != $projeto)||($fonteAnte != $fonte))
                    {
                        $ano            = date("Y");
                        $sqlAlteraVelho = "UPDATE diaria.saldo_projeto_fonte
                                              SET saldo_valor =".$saldoAnte.",
                                                  data_atualizacao = '".$dataAlteracao."'
                                            WHERE id_saldo_projeto =".$projetoAnte."
                                              AND id_saldo_fonte ='".$fonteAnte."'
                                              AND DATE_PART('YEAR', data_criacao) = '$ano'
                                              AND saldo_mes = '".substr($diariaAnte,3,2)."'";                                  
                        pg_query(abreConexao(), $sqlAlteraVelho);

                        $sqlAlteraNovo  = "UPDATE diaria.saldo_projeto_fonte
                                              SET saldo_valor =".$saldoValorSub.",
                                                  data_atualizacao = '".$dataAlteracao."'
                                            WHERE id_saldo_projeto =".$projeto."
                                              AND id_saldo_fonte ='".$fonte."'
                                              AND DATE_PART('YEAR', data_criacao) = '$ano'
                                              AND saldo_mes = '".substr($dataPartida,3,2)."'";
                        pg_query(abreConexao(), $sqlAlteraNovo);
                    }
                }
                else
                {                
                    if(($projetoAnte != '')&&($projetoAnte != '1000')&&($fonteAnte != 'XX')&&($fonteAnte != '0'))
                    {
                        $ano            = date("Y");
                        $sqlAlteraVelho = "UPDATE diaria.saldo_projeto_fonte
                                              SET saldo_valor =".$saldoAnte.",
                                                  data_atualizacao = '".$dataAlteracao."'
                                            WHERE id_saldo_projeto =".$projetoAnte."
                                              AND id_saldo_fonte ='".$fonteAnte."'
                                              AND DATE_PART('YEAR', data_criacao) = '$ano'
                                              AND saldo_mes = '".substr($diariaAnte,3,2)."'";                                  
                        pg_query(abreConexao(), $sqlAlteraVelho);
                    }
                }
            }
            else
            {
                $valorDiariaAnt    = $_POST['txtValor'];
                $diariaValorRefAnt = $_POST['txtValorRefAnt'];

                $sqlConsultaSaldo = "SELECT * FROM diaria.etapa WHERE etapa_id = $etapaIdAnt AND etapa_st = 0 ORDER BY etapa_meta, etapa_codigo";
                $rsConsultaSaldo  = pg_query(abreConexao(),$sqlConsultaSaldo);
                $linhaSaldo       = pg_fetch_assoc($rsConsultaSaldo);

                if($diariaValorRefAnt == '83')
                {
                    $saldoEtapa = (int)$linhaSaldo['saldo_medio'] + (int)$valorDiariaAnt;

                    $sqlUpdate = "UPDATE diaria.etapa
                                    SET saldo_medio = ".$saldoEtapa."
                                  WHERE etapa_id = ".$etapaIdAnt;

                    pg_query(abreConexao(), $sqlUpdate);
                }
                elseif($diariaValorRefAnt == '115')
                {
                    $saldoEtapa = (int)$linhaSaldo['saldo_superior'] + (int)$valorDiariaAnt;

                    $sqlUpdate = "UPDATE diaria.etapa
                                    SET saldo_superior = ".$saldoEtapa."
                                  WHERE etapa_id = ".$etapaIdAnt;

                    pg_query(abreConexao(), $sqlUpdate);
                }            
            }
        }
        else
        {
            $saldoEtapa        = $_POST['saldoEtapa'];
            $diariaNivelEsc    = $_POST['saldoNivel'];        
            $saldoEtapaAnt     = $_POST['saldoEtapaAnt'];
            $diariaNivelEscAnt = $_POST['saldoNivelAnt'];   

            if(($etapaIdAnt != '')&&($etapaIdAnt != 0))
            {            
                if($etapaId == $etapaIdAnt)
                {                
                    if($diariaNivelEscAnt == '')
                    {
                        if($diariaNivelEsc == 'superior')
                        {
                            $sqlUpdate = "UPDATE diaria.etapa
                                             SET saldo_superior = ".$saldoEtapa."
                                           WHERE etapa_id = ".$etapaId;

                            pg_query(abreConexao(), $sqlUpdate);
                        }
                        else
                        {
                            $sqlUpdate = "UPDATE diaria.etapa
                                             SET saldo_medio = ".$saldoEtapa."
                                           WHERE etapa_id = ".$etapaId;

                            pg_query(abreConexao(), $sqlUpdate);
                        }
                    }
                    elseif($diariaNivelEscAnt != $diariaNivelEsc)
                    {
                        if($diariaNivelEsc == 'superior')
                        {
                            $sqlUpdate = "UPDATE diaria.etapa
                                             SET saldo_superior = ".$saldoEtapa.",
                                                 saldo_medio = ".$saldoEtapaAnt."
                                           WHERE etapa_id = ".$etapaId;

                            pg_query(abreConexao(), $sqlUpdate);                                                
                        }
                        else
                        {
                            $sqlUpdate = "UPDATE diaria.etapa
                                             SET saldo_medio = ".$saldoEtapa.",
                                                 saldo_superior = ".$saldoEtapaAnt."
                                           WHERE etapa_id = ".$etapaId;

                            pg_query(abreConexao(), $sqlUpdate);                        
                        }
                    }
                }
                else
                {                
                    if($diariaNivelEscAnt == $diariaNivelEsc)
                    {
                        if($diariaNivelEsc == 'superior')
                        {
                            $sqlUpdate = "UPDATE diaria.etapa
                                             SET saldo_superior = ".$saldoEtapa."
                                           WHERE etapa_id = ".$etapaId;

                            pg_query(abreConexao(), $sqlUpdate);

                            $sqlUpdateAnt = "UPDATE diaria.etapa
                                                SET saldo_superior = ".$saldoEtapaAnt."
                                              WHERE etapa_id = ".$etapaIdAnt;

                            pg_query(abreConexao(), $sqlUpdateAnt);
                        }
                        else
                        {
                            $sqlUpdate = "UPDATE diaria.etapa
                                             SET saldo_medio = ".$saldoEtapa."
                                           WHERE etapa_id = ".$etapaId;

                            pg_query(abreConexao(), $sqlUpdate);

                            $sqlUpdateAnt = "UPDATE diaria.etapa
                                                SET saldo_medio = ".$saldoEtapaAnt."
                                              WHERE etapa_id = ".$etapaIdAnt;

                            pg_query(abreConexao(), $sqlUpdateAnt);
                        }
                    }
                    else
                    {
                        if($diariaNivelEsc == 'superior')
                        {
                            $sqlUpdate = "UPDATE diaria.etapa
                                             SET saldo_superior = ".$saldoEtapa."
                                           WHERE etapa_id = ".$etapaId;

                            pg_query(abreConexao(), $sqlUpdate);

                            $sqlUpdateAnt = "UPDATE diaria.etapa
                                                SET saldo_medio = ".$saldoEtapaAnt."
                                              WHERE etapa_id = ".$etapaIdAnt;

                            pg_query(abreConexao(), $sqlUpdateAnt);                
                        }
                        elseif($diariaNivelEsc == 'medio')
                        {
                            $sqlUpdate = "UPDATE diaria.etapa
                                             SET saldo_medio = ".$saldoEtapa."
                                           WHERE etapa_id = ".$etapaId;

                            pg_query(abreConexao(), $sqlUpdate);

                            $sqlUpdateAnt = "UPDATE diaria.etapa
                                                SET saldo_superior = ".$saldoEtapaAnt."
                                              WHERE etapa_id = ".$etapaIdAnt;

                            pg_query(abreConexao(), $sqlUpdateAnt);
                        }
                    }
                }
            }
            else
            {
                if($diariaNivelEsc == 'superior')
                {
                    $sqlUpdate = "UPDATE diaria.etapa
                                     SET saldo_superior = ".$saldoEtapa."
                                   WHERE etapa_id = ".$etapaId;

                    pg_query(abreConexao(), $sqlUpdate);
                }
                else
                {
                    $sqlUpdate = "UPDATE diaria.etapa
                                     SET saldo_medio = ".$saldoEtapa."
                                   WHERE etapa_id = ".$etapaId;

                    pg_query(abreConexao(), $sqlUpdate);
                }
            }
        }
        //f_InsereLogDiaria($_SESSION['UsuarioCodigo'], $codigo, "Alterou a diária."); 
        echo "<script>window.location = '".$PaginaLocal."Inicio.php';</script>";
    }        
}

function Excluir($PaginaLocal)
{ 
    $codigo        = trim($_POST['txtCodigo']);
    $projeto       = trim($_POST['txtProjeto']);
    $fonte         = trim($_POST['txtFonte']);
    $valorDiaria   = trim($_POST['txtValor']);    
    $dataDiaria    = trim($_POST['txtData']);    
    $dataDiaria    = substr($dataDiaria,3,2);
    $vazio         = 'null';
    $dataAlteracao = date("Y/m/d");
    $etapaId       = $_POST['txtEtapa'];
    $valorRef      = $_POST['txtValorRef'];
    
    $sqlDeleta = "UPDATE diaria.diaria 
                     SET diaria_excluida     = 1,  
                         data_viagem_saida   = $vazio, 
                         data_viagem_chegada = $vazio, 
                         diaria_dt_alteracao = '$dataAlteracao'
                   WHERE diaria_id           = ".$codigo;

    pg_query(abreConexao(), $sqlDeleta);
     
    if(($etapaId == '')&&($etapaId == 0))
    {
        if((($fonte != 'XX')&&($fonte != '0'))&&(($projeto != '')&&($projeto != '1000')))
        {
            $ano              = date("Y");
            $sqlConsultaSaldo = "SELECT * FROM diaria.saldo_projeto_fonte 
                                  WHERE id_saldo_projeto =".$projeto."
                                    AND id_saldo_fonte ='".$fonte."'
                                    AND DATE_PART('YEAR', data_criacao) = '$ano'
                                    AND saldo_mes = '".$dataDiaria."'";
            $rsConsultaSaldo  = pg_query(abreConexao(), $sqlConsultaSaldo);
            $linhaSaldo       = pg_fetch_assoc($rsConsultaSaldo);

            if($linhaSaldo)
            {
                $valorDiaria = (int)$linhaSaldo['saldo_valor'] + (int)$valorDiaria;
                $ano         = date("Y");
                $sqlAlteraVelho = "UPDATE diaria.saldo_projeto_fonte
                                      SET saldo_valor =".$valorDiaria."
                                          data_atualizacao = '".$dataAlteracao."'
                                    WHERE id_saldo_projeto =".$projeto."
                                      AND id_saldo_fonte ='".$fonte."'
                                      AND DATE_PART('YEAR', data_criacao) = '$ano'
                                      AND saldo_mes = '".$dataDiaria."'";                                                       
                pg_query(abreConexao(), $sqlAlteraVelho);
            }
        }    
    }
    else
    {
        $sqlConsultaSaldoEtapa = "SELECT * FROM diaria.etapa WHERE etapa_id = ".$etapaId;
        $rsConsultaSaldoEtapa  = pg_query(abreConexao(), $sqlConsultaSaldoEtapa);
        $linhaSaldoEtapa       = pg_fetch_assoc($rsConsultaSaldoEtapa);
        
        if($valorRef > '114')
        {
            $saldoAtual = (int)$linhaSaldoEtapa['saldo_superior'] - (int)$valorDiaria;
            
            $sqlDevolveSaldo = "UPDATE diaria.etapa
                                   SET saldo_superior = ".$saldoAtual."
                                 WHERE etapa_id = ".$etapaId;            
        }
        elseif($valorRef < '115')
        {
            $saldoAtual = (int)$linhaSaldoEtapa['saldo_medio'] - (int)$valorDiaria;
            
            $sqlDevolveSaldo = "UPDATE diaria.etapa
                                   SET saldo_medio = ".$saldoAtual."
                                 WHERE etapa_id = ".$etapaId;            
        }
        
        pg_query(abreConexao(), $sqlDevolveSaldo);
    }
    echo "<script>window.location = '".$PaginaLocal."Inicio.php';</script>";
}
?>