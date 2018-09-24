<?php
include "../Include/Inc_Configuracao.php";
//include "fpdf.php";

$Codigo = $_GET['cod'];
if($CodigoThiago != '')
{
    $Codigo = $CodigoThiago;
}

$sqlConsulta = "SELECT * 
                  FROM diaria.diaria d,
                       dados_unico.funcionario f,
                       dados_unico.pessoa p,
                       dados_unico.pessoa_fisica pf,
                       diaria.diaria_motivo dm,
                       dados_unico.est_organizacional_funcionario EF 
                 WHERE est_organizacional_funcionario_st = 0 
                   AND (F.funcionario_id = EF.funcionario_id) 
                   AND (d.diaria_id = dm.diaria_id)
                   AND (p.pessoa_id = pf.pessoa_id)
                   AND (p.pessoa_id = f.pessoa_id)
                   AND (d.diaria_beneficiario = f.pessoa_id)
                   AND d.diaria_id = ".$Codigo;

$rsConsulta     = pg_query(abreConexao(),$sqlConsulta);
$linhaConsulta  = pg_fetch_assoc($rsConsulta);

if($linhaConsulta)
{
    $DataCriacao            = $linhaConsulta['diaria_dt_criacao'];
    $HoraCriacao            = $linhaConsulta['diaria_hr_criacao'];
    $Numero                 = $linhaConsulta['diaria_numero'];
    $PessoaCodigo           = $linhaConsulta['pessoa_id'];
    $Beneficiario           = $linhaConsulta['diaria_beneficiario'];
    $DataPartida            = $linhaConsulta['diaria_dt_saida'];
    $Nome                   = $linhaConsulta['pessoa_nm'];
    $Matricula              = $linhaConsulta['funcionario_matricula'];
    $Escolaridade           = $linhaConsulta['nivel_escolar_id'];
    $CPF                    = $linhaConsulta['pessoa_fisica_cpf'];
    $EstruturaAtuacao       = $linhaConsulta['est_organizacional_id'];
    $HoraPartida            = $linhaConsulta['diaria_hr_saida'];
    $DataChegada            = $linhaConsulta['diaria_dt_chegada'];
    $HoraChegada            = $linhaConsulta['diaria_hr_chegada'];
    $DiaSemanaPartida       = diasemana($DataPartida);
    $DiaSemanaChegada       = diasemana($DataChegada);
    $Desconto               = $linhaConsulta['diaria_desconto'];
    $Qtde                   = $linhaConsulta['diaria_qtde'];
    $ValorRef               = $linhaConsulta['diaria_valor_ref'];
    $Valor                  = $linhaConsulta['diaria_valor'];
    $MeioTransporte         = $linhaConsulta['meio_transporte_id'];
    $TransporteObservacao   = $linhaConsulta['diaria_transporte_obs'];
    $Motivo                 = $linhaConsulta['motivo_id'];
    $SubMotivo              = $linhaConsulta['sub_motivo_id'];
    $Descricao              = $linhaConsulta['diaria_descricao'];
    $UnidadeCusto           = $linhaConsulta['diaria_unidade_custo'];
    $Projeto                = $linhaConsulta['projeto_cd'];
    $Acao                   = $linhaConsulta['acao_cd'];
    $Territorio             = $linhaConsulta['territorio_cd'];
    $Fonte                  = $linhaConsulta['fonte_cd'];
    $Processo               = $linhaConsulta['diaria_processo'];
    $Empenho                = $linhaConsulta['diaria_empenho'];
    $DataEmpenho            = $linhaConsulta['diaria_dt_empenho'];
    $qtdeRoteiros           = $linhaConsulta['qtde_roteiros'];
	
    /*
    '*****************************************************************************
    ' Alterado por Rodolfo em 12/09/2008
    ' Solicita��o da DA - Comprova��o
    '*****************************************************************************
    ' Consulta Beneficiario
    '*****************************************************************************
     *
     */
    $ValorRef   = 'R$ '.number_format($ValorRef, 2, ',', '.');
    $Valor      = 'R$ '.number_format($Valor, 2, ',', '.'); 
    
    $sql     = "SELECT pessoa_nm FROM dados_unico.pessoa p, dados_unico.funcionario f WHERE (p.pessoa_id = f.pessoa_id) AND f.pessoa_id= ".$Beneficiario;
    $rs      = pg_query(abreConexao(),$sql);
    $linhars = pg_fetch_assoc($rs);

    If($linhars)
    {  
        $BeneficiarioNome = $linhars['pessoa_nm'];
    }
    /*
    '*****************************************************************************
    ' Consulta Unidade de Custo
    '*****************************************************************************
     *
     */
    $sql     = "SELECT est_organizacional_sigla, est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = ".$UnidadeCusto;
    $rs      = pg_query(abreConexao(),$sql);
    $linhars = pg_fetch_assoc($rs);

    If($linhars)
    {  
        $UnidadeCustoNome =  $linhars['est_organizacional_sigla']." - ".$linhars['est_organizacional_ds'];
    }
    //*****************************************************************************
    /*
    Consulta Unidade de Custo
    '*****************************************************************************
     *
     */
    $sql     = "SELECT est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = ".$EstruturaAtuacao;
    $rs      = pg_query(abreConexao(),$sql);
    $linhars = pg_fetch_assoc($rs);

    $EstruturaAtuacaoNome = $linhars['est_organizacional_ds'];

    //*****************************************************************************

    $sqlComprovacao     = "SELECT * FROM diaria.diaria_comprovacao WHERE diaria_id = ".$Codigo;
    $rsComprovacao      = pg_query(abreConexao(),$sqlComprovacao);
    $linharsComprovacao = pg_fetch_assoc($rsComprovacao);

    If($linharsComprovacao['diaria_comprovacao_saldo_tipo']== "D")
    {
	$SaldoPagar   = $linharsComprovacao['diaria_comprovacao_saldo'];
        $SaldoReceber = "0";
    }
    ElseIf ($linharsComprovacao['diaria_comprovacao_saldo_tipo']== "C")
    {
        $SaldoReceber = $linharsComprovacao['diaria_comprovacao_saldo'];
        $SaldoPagar   = "0";
    }
    Else
    {    
        $SaldoPagar   = "0";
        $SaldoReceber = "0";
    }
    $JustificativaFimSemana             = $linharsComprovacao['diaria_comprovacao_justificativa_fds'];
    $JustificativaFeriado               = $linharsComprovacao['diaria_comprovacao_justificativa_feriado'];
    $QtdeComprovacao                    = $linharsComprovacao['diaria_comprovacao_qtde'];    
    $Resumo                             = $linharsComprovacao['diaria_comprovacao_resumo'];
    $Complemento 			= $linharsComprovacao['diaria_comprovacao_complemento'];
    $DataDaComprovacao 			= $linharsComprovacao['diaria_comprovacao_dt'];
    $HoraDaComprovacao 			= $linharsComprovacao['diaria_comprovacao_hr'];
    $diaria_comprovacao_dt_saida	= $linharsComprovacao['diaria_comprovacao_dt_saida'];
    $diaria_comprovacao_dt_saida	= $linharsComprovacao['diaria_comprovacao_dt_saida'];
    $diaria_comprovacao_dt_chegada 	= $linharsComprovacao['diaria_comprovacao_dt_chegada'];
    $ValorComprovacao                   = $linharsComprovacao['diaria_comprovacao_valor'];
    $valorComprovacaoRef                = $linharsComprovacao['diaria_comprovacao_valor_ref'];
    
    $ValorComprovacao    = 'R$ '.number_format($ValorComprovacao, 2, ',', '.');    
    $valorComprovacaoRef = 'R$ '.number_format($valorComprovacaoRef, 2, ',', '.');
    
    If ($Complemento == "1")
    {
        $ComplementoJustificativa = $linharsComprovacao['diaria_comprovacao_complemento_justificativa'];
    }

    If ($Desconto == "N")
    {  
        $Desconto = "N&atilde;o";
    }
    Else
    {  
        $Desconto = "Sim";
    }

    $sqlConsulta        = "SELECT est_organizacional_centro_custo_num, est_organizacional_sigla, est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = ".$UnidadeCusto;
    $rsConsulta         = pg_query(abreConexao(),$sqlConsulta);
    $linhaConsulta      = pg_fetch_assoc($rsConsulta);
    $UnidadeCustoNumero = $linhaConsulta['est_organizacional_centro_custo_num'];
    $UnidadeCustoSigla 	= $linhaConsulta['est_organizacional_sigla'];
    $UnidadeCustoNome 	= $linhaConsulta['est_organizacional_ds'];
    
    $sqlConsulta 	= "SELECT nivel_escolar_ds FROM dados_unico.nivel_escolar WHERE nivel_escolar_id = ".$Escolaridade;
    $rsConsulta 	= pg_query(abreConexao(),$sqlConsulta);
    $linhaConsulta	= pg_fetch_assoc($rsConsulta);
    $EscolaridadeNome 	= $linhaConsulta['nivel_escolar_ds'];
    $TemporarioValor 	= False;
    $PermanenteValor 	= False;

    $sql4               = "SELECT cargo_temporario, cargo_permanente FROM dados_unico.funcionario WHERE pessoa_id = ".$Beneficiario;
    $rs4                = pg_query(abreConexao(),$sql4);
    $linhars4           = pg_fetch_assoc($rs4);

    If (($linhars4['cargo_temporario']!= 0) && ($linhars4['cargo_temporario']!= ""))
    {
        $CargoTemporario = $linhars4['cargo_temporario'];

        $sql1 = "SELECT classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl WHERE (ca.classe_id = cl.classe_id) AND cargo_id = ".$CargoTemporario;
        $rs1  = pg_query(abreConexao(),$sql1);
        $linhars1 = pg_fetch_assoc($rs1);
        $TemporarioValor = True;
    }

    If (($linhars4['cargo_permanente']!=0) && ($linhars4['cargo_permanente']!= ""))
    {

        $CargoPermanente = $linhars4['cargo_permanente'];

        $sql2 = "SELECT classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl WHERE (ca.classe_id = cl.classe_id) AND cargo_id = ".$CargoPermanente;
        $rs2  = pg_query(abreConexao(),$sql2);

        $linhars2 =pg_fetch_assoc($rs2);
        $PermanenteValor = True	;
    }


    If (($TemporarioValor)&&($PermanenteValor))
    {
        If (((int)($linhars1['classe_valor'])) > ((int)($linhars2['classe_valor'])))
        {
            $Cargo = $CargoTemporario;
        }
        Else
        {   $Cargo = $CargoPermanente;

        }
    }
    ElseIf ($TemporarioValor)
    {
        $Cargo = $CargoTemporario;
    }
    ElseIf($PermanenteValor)
    {
        $Cargo = $CargoPermanente;
    }
    $sql3 = "SELECT cargo_ds FROM dados_unico.cargo WHERE cargo_id = ".$Cargo;

    $rsConsulta = pg_query(abreConexao(),$sql3);

    $linhaConsulta=pg_fetch_assoc($rsConsulta);
    $CargoNome = $linhaConsulta['cargo_ds'];

    $sqlEndereco = "SELECT * FROM dados_unico.endereco e, dados_unico.municipio m WHERE (e.municipio_cd = m.municipio_cd) AND pessoa_id = ".$PessoaCodigo;
    $rsEndereco = pg_query(abreConexao(),$sqlEndereco);

    $linharsEndereco=pg_fetch_assoc($rsEndereco);

    $Endereco = $linharsEndereco['endereco_ds'].", ".$linharsEndereco['endereco_num']." ".$linharsEndereco['endereco_complemento']. ", ".$linharsEndereco['endereco_bairro'].", ".$linharsEndereco['municipio_ds']. " - ".$linharsEndereco['estado_uf'];

    $sqlDadosBancarios = "SELECT * FROM dados_unico.dados_bancarios db, dados_unico.banco b WHERE (db.banco_id = b.banco_id) AND pessoa_id = ".$PessoaCodigo;
    $rsDadosBancarios  = pg_query(abreConexao(),$sqlDadosBancarios) ;

    $linharsDadosBancarios=pg_fetch_assoc($rsDadosBancarios);

    $Banco	 = $linharsDadosBancarios['banco_cd'];

    $Agencia = $linharsDadosBancarios['dados_bancarios_agencia'];
    $Conta	 = $linharsDadosBancarios['dados_bancarios_conta'];
    $ContaTipo	 = $linharsDadosBancarios['dados_bancarios_conta_tipo'];

    $sqlTransporte = "SELECT meio_transporte_ds FROM diaria.meio_transporte WHERE meio_transporte_id = ".$MeioTransporte;
    $rsTransporte = pg_query(abreConexao(),$sqlTransporte);

    $linharsTransporte=pg_fetch_assoc($rsTransporte);
    $MeioTransporte = $linharsTransporte['meio_transporte_ds'];

    $sqlConsulta = "SELECT motivo_ds FROM diaria.motivo WHERE motivo_id = ".$Motivo;
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    $linhaConsulta=pg_fetch_assoc($rsConsulta);
    $Motivo = $linhaConsulta['motivo_ds'];

    $sqlConsulta = "SELECT sub_motivo_ds FROM diaria.sub_motivo WHERE sub_motivo_id = ".$SubMotivo;
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    $linhaConsulta=pg_fetch_assoc($rsConsulta);
    $SubMotivo = $linhaConsulta['sub_motivo_ds'];

}

?>
