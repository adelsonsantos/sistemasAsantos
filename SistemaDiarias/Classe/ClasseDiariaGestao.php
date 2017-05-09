<?php   
//define o nome da pagina local para facilitar nos links
$PaginaLocal = "SolicitacaoGestao";

//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 0;

$retornoFiltro = $_GET['txtFiltro'];

if($atributo == '')
{        
    $atributo = $_GET['atributo'];
    
    if($_GET['atributo'] == 'diaria_dt_saida')
    {
        $atributoFiltro = "TO_DATE(diaria_dt_saida,'DD/MM/YYYY') DESC";
    }
    elseif($_GET['atributo'] == 'diaria_id')
    {
        $atributoFiltro = "TO_DATE(diaria_dt_saida,'DD/MM/YYYY') ASC";
    }
    else
    {
        $atributoFiltro = $_GET['atributo'];
    }
}

/***************************************************
****************** A��o BUSCAR* *******************
***************************************************/

If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
{
      
//  Verifica se foi enviado um filtro
    if ($retornoFiltro != "")
    {
//  Verifica se foi enviado um atributo
        if ($atributo != '')
        {
//  Possui filtro e atributo
            $sqlConsulta = "SELECT diaria_id,
                                    diaria_numero,
                                    pessoa_nm,
                                    diaria_dt_saida,
                                    diaria_hr_saida,
                                    diaria_dt_chegada,
                                    diaria_dt_criacao,
                                    diaria_hr_criacao,
                                    diaria_hr_chegada,
                                    diaria_st,
                                    diaria_beneficiario,
                                    diaria_processo,
                                    diaria_empenho,
                                    fonte_cd,
                                    diaria_devolvida,
                                    diaria_cancelada,
                                    diaria_comprovada,
                                    diaria_excluida,
                                    diaria_local_solicitacao,
                                    pedido_empenho,
                                    indenizacao,
                                    convenio_id,
                                    diaria_extrato_empenho,
                                    diaria_agrupada,
                                    pessoa_fisica_cpf,
                                    est_organizacional_sigla,
                                    est_organizacional_ds
                               FROM diaria.diaria d 
                               JOIN dados_unico.pessoa p ON d.diaria_beneficiario = p.pessoa_id 
                               JOIN dados_unico.pessoa_fisica pf ON pf.pessoa_id = p.pessoa_id 
                               JOIN dados_unico.est_organizacional est ON est.est_organizacional_id = diaria_unidade_custo 
                              WHERE diaria_st = 2 AND (pessoa_nm ILIKE '%" .$retornoFiltro."%' OR diaria_numero ILIKE '%" .$retornoFiltro. "%') AND diaria_excluida = 0 
                           ORDER BY diaria_dt_empenho, ".$atributoFiltro;                
        }
        else
        {
//  Possui filtro, mas n�o possui atributo 
            $sqlConsulta = "SELECT diaria_id,
                                    diaria_numero,
                                    pessoa_nm,
                                    diaria_dt_saida,
                                    diaria_hr_saida,
                                    diaria_dt_chegada,
                                    diaria_dt_criacao,
                                    diaria_hr_criacao,
                                    diaria_hr_chegada,
                                    diaria_st,
                                    diaria_beneficiario,
                                    diaria_processo,
                                    diaria_empenho,
                                    fonte_cd,
                                    diaria_devolvida,
                                    diaria_cancelada,
                                    diaria_comprovada,
                                    diaria_excluida,
                                    diaria_local_solicitacao,
                                    indenizacao,
                                    convenio_id,
                                    pedido_empenho,
                                    diaria_extrato_empenho,
                                    diaria_agrupada,
                                    pessoa_fisica_cpf,
                                    est_organizacional_sigla,
                                    est_organizacional_ds
                               FROM diaria.diaria d 
                               JOIN dados_unico.pessoa p ON d.diaria_beneficiario = p.pessoa_id 
                               JOIN dados_unico.pessoa_fisica pf ON pf.pessoa_id = p.pessoa_id 
                               JOIN dados_unico.est_organizacional est ON est.est_organizacional_id = diaria_unidade_custo 
                              WHERE diaria_st = 2 AND (pessoa_nm ILIKE '%" .$retornoFiltro."%' OR diaria_numero ILIKE '%" .$retornoFiltro. "%') AND diaria_excluida = 0 
                           ORDER BY diaria_dt_empenho, TO_DATE(diaria_dt_saida,'DD/MM/YYYY')";
        }

    }
    else
    {
        if ($atributo != '')
        {
// n�o possui filtro, mas posssui Atributo.
            $sqlConsulta = "SELECT diaria_id,
                                    diaria_numero,
                                    pessoa_nm,
                                    diaria_dt_saida,
                                    diaria_hr_saida,
                                    diaria_dt_chegada,
                                    diaria_dt_criacao,
                                    diaria_hr_criacao,
                                    diaria_hr_chegada,
                                    diaria_st,
                                    diaria_beneficiario,
                                    diaria_processo,
                                    diaria_empenho,
                                    fonte_cd,
                                    diaria_devolvida,
                                    diaria_cancelada,
                                    diaria_comprovada,
                                    diaria_excluida,
                                    diaria_local_solicitacao,
                                    pedido_empenho,
                                    indenizacao,
                                    convenio_id,
                                    diaria_extrato_empenho,
                                    diaria_agrupada,
                                    pessoa_fisica_cpf,
                                    est_organizacional_sigla,
                                    est_organizacional_ds
                               FROM diaria.diaria d 
                               JOIN dados_unico.pessoa p ON d.diaria_beneficiario = p.pessoa_id 
                               JOIN dados_unico.pessoa_fisica pf ON pf.pessoa_id = p.pessoa_id 
                               JOIN dados_unico.est_organizacional est ON est.est_organizacional_id = diaria_unidade_custo 
                              WHERE diaria_st = 2 AND diaria_excluida = 0 
                           ORDER BY diaria_dt_empenho, ".$atributoFiltro;                
        }
        else
        {
// n�o possui atributo e n�o possui filtro
            $sqlConsulta = "SELECT diaria_id,
                                    diaria_numero,
                                    pessoa_nm,
                                    diaria_dt_saida,
                                    diaria_hr_saida,
                                    diaria_dt_chegada,
                                    diaria_dt_criacao,
                                    diaria_hr_criacao,
                                    diaria_hr_chegada,
                                    diaria_st,
                                    diaria_beneficiario,
                                    diaria_processo,
                                    diaria_empenho,
                                    fonte_cd,
                                    diaria_devolvida,
                                    diaria_cancelada,
                                    diaria_comprovada,
                                    diaria_excluida,
                                    diaria_local_solicitacao,
                                    pedido_empenho,
                                    indenizacao,
                                    convenio_id,
                                    diaria_extrato_empenho,
                                    diaria_agrupada,
                                    pessoa_fisica_cpf,
                                    est_organizacional_sigla,
                                    est_organizacional_ds
                               FROM diaria.diaria d 
                               JOIN dados_unico.pessoa p ON d.diaria_beneficiario = p.pessoa_id 
                               JOIN dados_unico.pessoa_fisica pf ON pf.pessoa_id = p.pessoa_id 
                               JOIN dados_unico.est_organizacional est ON est.est_organizacional_id = diaria_unidade_custo 
                              WHERE diaria_st = 2 AND diaria_excluida = 0 
                           ORDER BY diaria_dt_empenho, TO_DATE(diaria_dt_saida,'DD/MM/YYYY')";                
        }
    }        
   
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);    
}
/***************************************************
****************** A��o CONSULTAR *******************
***************************************************/
ElseIf ($AcaoSistema == "consultar")
{
    $Codigo = $_GET['cod'];

    $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = ".$Codigo;
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

	// Aqui eu fiz uma altera��o na SEMA, AS LINHAS COMENTADAS FUNCIONAM, MAS FALTA UMA TABELA NA BASE DE DADOS.
	
 /*   $sqlConsulta1 = "SELECT * FROM diaria.diaria_historico_doc WHERE diaria_id = ".$Codigo;
    $rsConsulta1 = pg_query(abreConexao(),$sqlConsulta1);
    $linhars1 = pg_fetch_assoc ($rsConsulta1);

    if ($linhars1['indenizacao'] == 1)
    {
            $sqlVerifica = "SELECT * FROM diaria.diaria_historico_doc WHERE diaria_id = '".$Codigo."' AND diaria_aprovacao_id = '".$linhars1['diaria_aprovacao_id']."' AND pessoa_id = '".$linhars1['pessoa_id']."' AND num_doc = '".$linhars1['num_doc']."' AND diaria_tipo_doc_id = '".$linhars1['diaria_tipo_doc_id']."'";
            $rsVerifica = pg_query(abreConexao(),$sqlVerifica);
            $linharsv   = pg_fetch_assoc ($rsVerifica);
    }
   */ 

}

/***************************************************
****************** A��o EMPENHAR *******************
***************************************************/

elseif ($AcaoSistema == "empenhar")
{
    $Codigo 	 	 = $_POST['txtCodigo'];
    $Empenho 	 	 = $_POST['txtEmpenho'];
    $DataEmpenho 	 = dataToDB($_POST['txtDataEmpenho']);    
    $Numero_diaria 	 = $_POST['txtNumeroDiaria'];    
	
    $sql = "Select diaria_processo, super_sd, diaria_agrupada from diaria.diaria where diaria_id = $Codigo";
    $rsConsulta = pg_query(abreConexao(),$sql);
    $tupla = pg_fetch_assoc($rsConsulta);
    $processo_diaria = $tupla['diaria_processo'];
    $Diaria_Agrupada = $tupla['diaria_agrupada'];
    $Super_SD = $tupla['super_sd']; /***Pegando a Super SD***/	

    if( $Diaria_Agrupada == 0)
    {	// Diarias N�o Agrupadas - N�o Tem SUPER SD
        if( $processo_diaria == "")
        {
            $Processo_diaria  = f_NumeroProcesso($Numero_diaria);
            $sqlAltera = "UPDATE diaria.diaria SET  diaria_devolvida = 0,
                                diaria_empenho = '".$Empenho."',
                                diaria_dt_empenho = '".$DataEmpenho."',
                                diaria_processo = '".$Processo_diaria."',
                                diaria_hr_empenho = '".date("H:i:s")."',                                            
                                diaria_empenho_pessoa_id = '".$_SESSION['UsuarioCodigo']."'
                                WHERE diaria_id = ".$Codigo;
        }
        else
        {
            $sqlAltera = "UPDATE diaria.diaria SET  diaria_devolvida = 0,
                                diaria_empenho = '".$Empenho."',
                                diaria_dt_empenho = '".$DataEmpenho."',                                           
                                diaria_hr_empenho = '".date("H:i:s")."',                                            
                                diaria_empenho_pessoa_id = '".$_SESSION['UsuarioCodigo']."'
                                WHERE diaria_id = ".$Codigo;

        }
    }
    else
    { // Diarias Agrupadas - Tem SUPER SD
        $DTAno        = date("Y");
        $DTAno        = substr($DTAno,1,3); //tira o 20 e ficar s� o 11 0710119000063
        $DTAno        = "0710".$DTAno."9";
        $Zeros 	      = "0";
        $TamanhoSD    = strlen ($Super_SD);
        $NumDiaria    = substr($Super_SD,6,$TamanhoSD);		

        $Processo_diaria  = $DTAno.$Zeros.$NumDiaria;

        $sqlAltera = "UPDATE diaria.diaria SET  diaria_devolvida = 0,
                                  diaria_empenho = '".$Empenho."',
                                  diaria_dt_empenho = '".$DataEmpenho."',
                                  diaria_processo = '".$Processo_diaria."',
                                  diaria_hr_empenho = '".date("H:i:s")."',                                            
                                  diaria_empenho_pessoa_id = '".$_SESSION['UsuarioCodigo']."'
                                  WHERE super_sd = '$Super_SD'";			
    }
    
    pg_query(abreConexao(),$sqlAltera);

    echo "<script>";
    echo "alert('Dados GRAVADOS com sucesso. Para finalizar LIBERE o empenho.')";
    echo "</script>";
    echo "<script>window.location = 'SolicitacaoGestaoInicio.php ';</script>";
}
/***************************************************
****************** A��o EMPENHAR *******************
***************************************************/

elseif ($AcaoSistema == "2empenhar")
{
    $Codigo                      = $_POST['txtCodigo'];
    $SegundoEmpenho 	 	 = $_POST['txt2Empenho'];
    $SegundoDataEmpenho 	 = $_POST['txtData2Empenho'];

    // VERIFICA SE EXISTE UM SEGUNDO EMPENHO PARA A DI�RIA INFORMADA. 
    
    $sqlConsulta = "SELECT diaria_segundo_empenho_id FROM diaria.diaria_segundo_empenho where diaria_segundo_empenho_st <> 2 and diaria_id =".$Codigo;
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    $linhars = pg_fetch_assoc($rsConsulta);
   
    if ($linhars == 0)
    {
        // INFORMA OS DADOS DO SEGUNDO EMPENHO.
        $sqlInsere= "INSERT INTO diaria.diaria_segundo_empenho
                    (
                        diaria_id,
                        diaria_segundo_empenho,
                        diaria_segundo_empenho_numero,
                        diaria_segundo_dt_empenho,
                        diaria_segundo_empenho_dt_acao,
                        diaria_segundo_empenho_hr_acao,
                        diaria_segundo_empenho_st)
                        VALUES (
                        ".$Codigo.",
                        ".$_SESSION['UsuarioCodigo'].",
                        ".$SegundoEmpenho.",
                        '".$SegundoDataEmpenho."',
                        '".$Date = date("Y-m-d")."',
                        '".date("H:i:s")."',
                        0
                    )";
        //echo $sqlInsere;
        pg_query(abreConexao(),$sqlInsere);
    }
    else
    {
        // ALTERAR OS DADOS DO SEGUNDO EMPENHO.
        $sqlAltera= "UPDATE diaria.diaria_segundo_empenho SET
                    diaria_segundo_empenho = ".$_SESSION['UsuarioCodigo']." ,
                    diaria_segundo_empenho_numero ='".$SegundoEmpenho."',
                    diaria_segundo_dt_empenho='".$SegundoDataEmpenho."',
                    diaria_segundo_empenho_dt_acao ='".$Date = date("Y-m-d")."',
                    diaria_segundo_empenho_hr_acao= '".date("H:i:s")."'
                    where diaria_id = ".$Codigo." and diaria_segundo_empenho_st = 0";
        //echo $sqlAltera;
        pg_query(abreConexao(),$sqlAltera);

    }
   
    echo "<script>";
    echo "alert('Dados GRAVADOS com sucesso. Para finalizar LIBERE o empenho.')";
    echo "</script>";
    echo "<script>window.location = 'SolicitacaoGestaoInicio.php ';</script>";
}
/***************************************************
****************** A��o IMPRIMIR *******************
***************************************************/
ElseIf ($AcaoSistema == "imprimir")
{

    $Codigo = $_GET['cod'];

    $sqlConsulta = "SELECT * FROM diaria.diaria d, 
                                  dados_unico.funcionario f, 
                                  dados_unico.pessoa p, 
                                  dados_unico.pessoa_fisica pf, 
                                  diaria.diaria_motivo dm, 
                                  dados_unico.est_organizacional_funcionario EF 
                            WHERE est_organizacional_funcionario_st = 0 AND (F.funcionario_id = EF.funcionario_id) 
                              AND (d.diaria_id = dm.diaria_id) AND (p.pessoa_id = pf.pessoa_id) AND (p.pessoa_id = f.pessoa_id) 
                              AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = ".$Codigo;
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

    $linhaConsulta=pg_fetch_assoc($rsConsulta);

    If($linhaConsulta)
    {
        $Numero 	   = $linhaConsulta['diaria_numero'];
        $PessoaCodigo      = $linhaConsulta['pessoa_id'];
        $Beneficiario      = $linhaConsulta['diaria_beneficiario'];
        $DataPartida       = $linhaConsulta['diaria_dt_saida'];
        $Nome              = $linhaConsulta['pessoa_nm'];
        $Matricula         = $linhaConsulta['funcionario_matricula'];
        $EstruturaAtuacao  = $linhaConsulta['est_organizacional_id'];
        $Escolaridade      = $linhaConsulta['nivel_escolar_id'];
        $CPF               = $linhaConsulta['pessoa_fisica_cpf'];
        $Convenio          = $linhaConsulta['ger_id'];
        $Indenizacao       = $linhaConsulta['indenizacao'];	
        $Processo          = $linhaConsulta['diaria_processo'];	
        $etapa_id          = $linhaConsulta['etapa_id'];
        /*
        '*****************************************************************************
        ' Alterado por Rodolfo em 12/09/2008
        ' Solicitaço da DA - Comprovação
        '*****************************************************************************
        ' Consulta Beneficiario
        '*****************************************************************************/
		
        $sql = "SELECT pessoa_nm FROM dados_unico.pessoa p, dados_unico.funcionario f WHERE (p.pessoa_id = f.pessoa_id) AND f.pessoa_id= ".$Beneficiario;

        $rs = pg_query(abreConexao(),$sql);

        $linhars=pg_fetch_assoc($rs);

        If ($linhars)
        {
            $BeneficiarioNome = $linhars['pessoa_nm'];
        }
        
        if(($etapa_id != '')&&($etapa_id != 0))
        {
            $sqlConsultaEtapa = "SELECT * FROM diaria.etapa WHERE etapa_id = ".$etapa_id;
            $rsEtapa          = pg_query(abreConexao(),$sqlConsultaEtapa);
            $linhaEtapa       = pg_fetch_assoc($rsEtapa);
        }
//'*****************************************************************************

        $HoraPartida		= $linhaConsulta['diaria_hr_saida'];
        $DataChegada	 	= $linhaConsulta['diaria_dt_chegada'];
        $HoraChegada	 	= $linhaConsulta['diaria_hr_chegada'];

        $DataDaSolicitacao 	= $linhaConsulta['diaria_dt_criacao'];
        $HoraDaSolicitacao 	= $linhaConsulta['diaria_hr_criacao'];
        $DiaSemanaPartida 	= diasemana($DataPartida);
        $DiaSemanaChegada 	= diasemana($DataChegada);

        $Desconto 		= $linhaConsulta['diaria_desconto'];
        $Qtde			= $linhaConsulta['diaria_qtde'];
        $ValorRef		= $linhaConsulta['diaria_valor_ref'];
        $Valor			= $linhaConsulta['diaria_valor'];
        $JustificativaFimSemana = $linhaConsulta['diaria_justificativa_fds'];
        $JustificativaFeriado  	= $linhaConsulta['diaria_justificativa_feriado'];
        $MeioTransporte		= $linhaConsulta['meio_transporte_id'];
        $TransporteObservacao	= $linhaConsulta['diaria_transporte_obs'];
        $Motivo			= $linhaConsulta['motivo_id'];
        $SubMotivo		= $linhaConsulta['sub_motivo_id'];
        $Descricao 		= $linhaConsulta['diaria_descricao'];
        $UnidadeCusto           = $linhaConsulta['diaria_unidade_custo'];
        $Projeto 		= $linhaConsulta['projeto_cd'];
        $Acao 			= $linhaConsulta['acao_cd'];
        $Territorio 		= $linhaConsulta['territorio_cd'];
        $Fonte 			= $linhaConsulta['fonte_cd'];        
        $Empenho 		= $linhaConsulta['diaria_empenho'];
        $DataEmpenho            = $linhaConsulta['diaria_dt_empenho'];
        $DiariaComprovada       = $linhaConsulta['diaria_comprovada'];
        
        If ($Desconto == "N")
        { 
            $Desconto = "N&atilde;o";
        }
        Else
        { 
            $Desconto = "Sim";
        }
        $sqlConsulta 	= "SELECT est_organizacional_centro_custo_num, est_organizacional_sigla, est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = ".$UnidadeCusto;
        $rsConsulta		= pg_query(abreConexao(),$sqlConsulta);

        $linhaConsulta	= pg_fetch_assoc($rsConsulta);

        $UnidadeCustoNumero = $linhaConsulta['est_organizacional_centro_custo_num'];
        $UnidadeCustoSigla  = $linhaConsulta['est_organizacional_sigla'];
        $UnidadeCustoNome   = $linhaConsulta['est_organizacional_ds'];

        $sqlConsulta 	= "SELECT nivel_escolar_ds FROM dados_unico.nivel_escolar WHERE nivel_escolar_id = ".$Escolaridade;
        $rsConsulta 	= pg_query(abreConexao(),$sqlConsulta);

        $linhaConsulta	= pg_fetch_assoc($rsConsulta);

        $EscolaridadeNome = $linhaConsulta['nivel_escolar_ds'];

        $TemporarioValor = False;
        $PermanenteValor = False;

        $sql4 = "SELECT cargo_temporario, cargo_permanente FROM dados_unico.funcionario WHERE pessoa_id = ".$Beneficiario;
        $rs4 = pg_query(abreConexao(),$sql4);

        $linhars4 = pg_fetch_assoc($rs4);

        If (($linhars4['cargo_temporario']!= 0) && ($linhars4['cargo_temporario']!= ""))
        {
            $CargoTemporario = $linhars4['cargo_temporario'];

            $sql1 = "SELECT classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl WHERE (ca.classe_id = cl.classe_id) AND cargo_id = ".$CargoTemporario;
            $rs1 = pg_query(abreConexao(),$sql1);

            $linhars1 = pg_fetch_assoc($rs1);

            $TemporarioValor = True;
        }

        If (($linhars4['cargo_permanente']!= 0) && ($linhars4['cargo_permanente']!=""))
        {
            $CargoPermanente = $linhars4['cargo_permanente'];
            $sql2 = "SELECT classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl WHERE (ca.classe_id = cl.classe_id) AND cargo_id = ".$CargoPermanente;
            $rs2 = pg_query(abreConexao(),$sql2);

            $linhars2 = pg_fetch_assoc($rs2);

            $PermanenteValor = True;
        }

        If (($TemporarioValor) &&($PermanenteValor))
        {
            If ((int)($linhars1['classe_valor']) > ((int)($linhars2['classe_valor'])))
            {
                $Cargo = $CargoTemporario;
            }
            Else
            {	$Cargo = $CargoPermanente;

            }
        }
        ElseIf ($TemporarioValor)
        {	$Cargo = $CargoTemporario;

        }
        ElseIf ($PermanenteValor)
        {
            $Cargo = $CargoPermanente;
        }
        $sql3 = "SELECT cargo_ds FROM dados_unico.cargo WHERE cargo_id = ".$Cargo;
        $rsConsulta = pg_query(abreConexao(),$sql3);

        $linhaConsulta = pg_fetch_assoc($rsConsulta);

        $CargoNome = $linhaConsulta['cargo_ds'];

        $sqlEndereco = "SELECT * FROM dados_unico.endereco e, dados_unico.municipio m WHERE (e.municipio_cd = m.municipio_cd) AND pessoa_id = ".$PessoaCodigo;
        $rsEndereco = pg_query(abreConexao(),$sqlEndereco);

        $linharsEndereco = pg_fetch_assoc($rsEndereco);

        If ($linharsEndereco)
        {
            $Endereco = $linharsEndereco['endereco_ds']. ", ".$linharsEndereco['endereco_num']." ".$linharsEndereco['endereco_complemento'].", ".$linharsEndereco['endereco_bairro'].", ".$linharsEndereco['municipio_ds']." - ".$linharsEndereco['estado_uf'];
        }
        Else
        {	
            $Endereco = "";
        }
        $sqlDadosBancarios = "SELECT * FROM dados_unico.dados_bancarios db, dados_unico.banco b WHERE (db.banco_id = b.banco_id) AND pessoa_id = ".$PessoaCodigo;
        $rsDadosBancarios = pg_query(abreConexao(),$sqlDadosBancarios);

        $linharsDadosBancarios = pg_fetch_assoc($rsDadosBancarios);

        If($linharsDadosBancarios)
        {
            $Banco	= $linharsDadosBancarios['banco_cd'];
            $Agencia    = $linharsDadosBancarios['dados_bancarios_agencia'];
            $Conta	= $linharsDadosBancarios['dados_bancarios_conta'];
        }
        Else
        {
            $Banco	= "";
            $Agencia = "";
            $Conta	= "";
        }
        $sqlTransporte = "SELECT meio_transporte_ds FROM diaria.meio_transporte WHERE meio_transporte_id = ".$MeioTransporte;
        $rsTransporte = pg_query(abreConexao(),$sqlTransporte);

        $linharsTransporte = pg_fetch_assoc($rsTransporte);

        $MeioTransporte = $linharsTransporte['meio_transporte_ds'];

        $sqlConsulta = "SELECT motivo_ds FROM diaria.motivo WHERE motivo_id = ".$Motivo;
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

        $linhaConsulta = pg_fetch_assoc($rsConsulta);

        $Motivo = $linhaConsulta['motivo_ds'];

        $sqlConsulta = "SELECT sub_motivo_ds FROM diaria.sub_motivo WHERE sub_motivo_id = ".$SubMotivo;
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

        $linhaConsulta = pg_fetch_assoc($rsConsulta);

        $SubMotivo = $linhaConsulta['sub_motivo_ds'];
    }
}
ElseIf ($AcaoSistema == "AdcionarDocumento")
{
    $Codigo 	 	 = $_POST['txtCodigo'];

    $sqlConsulta = "SELECT * FROM diaria.diaria where diaria_id = ".$Codigo;
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    $linhars = pg_fetch_assoc ($rsConsulta);

    if ($linhars['indenizacao'] == 1)
    {
            $TipoDocumento 	 = $_POST['cmbDocumento'];
            $NumeroDocumento = $_POST['txtNumDoc'];
            $UsuarioTipo = $_SESSION['UsuarioEstCodigo'];
            $Date = date("Y-m-d");
            $Time = date("H:i:s");

            $sqlConsulta1 = "SELECT * FROM diaria.diaria_aprovacao dda, diaria.diaria dd WHERE dda.diaria_id = dd.diaria_id AND dd.diaria_id =".$Codigo;
            $rsConsulta1 = pg_query(abreConexao(),$sqlConsulta1);
            $linhars1 = pg_fetch_assoc ($rsConsulta1);

            $sqlInsere = "INSERT INTO diaria.diaria_historico_doc(
                                            diaria_id, diaria_aprovacao_id, pessoa_id, num_doc, diaria_historico_doc_dt,
                                            diaria_historico_doc_hr, diaria_tipo_usuario, diaria_tipo_doc_id)
                                  VALUES ('".$Codigo."', ".$linhars1['diaria_aprovacao_id'].", ".$_SESSION['UsuarioCodigo'].",
                                                    '".$NumeroDocumento."', '".$Date."', '".$Time."', '".$UsuarioTipo."', ".$TipoDocumento.")";
            $sqlInsere = strtoupper ($sqlInsere);
            pg_query(abreConexao(),$sqlInsere);

            echo "<script>window.location = 'SolicitacaoEmpenhar.php?acao=consultar&cod=".$Codigo."&pagina=SolicitacaoGestao;'</script>";
    }
}
ElseIf ($AcaoSistema == "ExcluirDocumento")
{
    $Codigo          = $_POST['txtCodigo'];
    $CodigoDocumento = $_GET['CodigoDocumento'];

    $sqlAltera = "UPDATE diaria.diaria_historico_doc SET diaria_historico_doc_st=2 WHERE diaria_historico_doc_id = ".$CodigoDocumento;

    pg_query(abreConexao(),$sqlAltera);

    echo "<script>window.location = 'SolicitacaoEmpenhar.php?acao=consultar&cod=".$Codigo."&pagina=SolicitacaoGestao;'</script>";

}
ElseIf ($AcaoSistema == "empenharST") // LIBERAR EMPENHO
{
    $Codigo          = $_GET['Cod'];

    $sql = "Select super_sd, diaria_agrupada from diaria.diaria where diaria_id = $Codigo";
    $rsConsulta = pg_query(abreConexao(),$sql);
    $tupla = pg_fetch_assoc($rsConsulta);
    $Super_SD = $tupla['super_sd'];
    $Diaria_Agrupada = $tupla['diaria_agrupada'];
	
    // ALTERA O NUMERO DA DIARIA PARA AGUARDANDO PAGAMENTO.
    if($Diaria_Agrupada == 0 )
    { // N�o � Di�ria Agrupada		
        $sqlAltera = "UPDATE diaria.diaria SET  diaria_st = 3,
                     diaria_devolvida = 0
                     WHERE diaria_id = ".$Codigo;
    }
    else
    { // Di�rias Agrupadas
        $sqlAltera = "UPDATE diaria.diaria SET  diaria_st = 3,
                     diaria_devolvida = 0
                     WHERE super_sd = '$Super_SD'";
    }
	
    pg_query(abreConexao(),$sqlAltera);
    echo "<script>alert(\"Empenho Liberado com Sucesso.!!!\");</script>";	
    echo "<script>window.location = 'SolicitacaoGestaoInicio.php ';</script>";
}
ElseIf ($AcaoSistema == "SegundoEmpenharST") // LIBERAR SEGUNDO EMPENHO
{
    $Codigo          = $_GET['Cod'];
	
    $sql = "Select super_sd, diaria_agrupada from diaria.diaria where diaria_id = $Codigo";
    $rsConsulta = pg_query(abreConexao(),$sql);
    $tupla = pg_fetch_assoc($rsConsulta);
    $Super_SD = $tupla['super_sd'];
    $Diaria_Agrupada = $tupla['diaria_agrupada'];
	
    // ALTERA O NUMERO DA DIARIA PARA AGUARDANDO PAGAMENTO.
    if($Diaria_Agrupada == 0 )
    { // N�o � Di�ria Agrupada    
        $sqlAltera = "UPDATE diaria.diaria SET  diaria_st = 7,
                 diaria_devolvida = 0
                 WHERE diaria_id = ".$Codigo;
    }
    else
    {
        $sqlAltera = "UPDATE diaria.diaria SET  diaria_st = 7,
                 diaria_devolvida = 0
                 WHERE super_sd = '$Super_SD'";
    }
	
    pg_query(abreConexao(),$sqlAltera);
    echo "<script>window.location = 'SolicitacaoGestaoInicio.php ';</script>";
}
/*************************** Libera todos os Empenhos Selecionados ***************************************************/
ElseIf($AcaoSistema == "EmpenhoLiberarTodos")
{	
    $Codigos = $_GET['Codigos'];	    
    $sqlAltera = "UPDATE diaria.diaria SET  diaria_st = 3,
                         diaria_devolvida = 0
                         WHERE diaria_id in ($Codigos)";
	
    pg_query(abreConexao(),$sqlAltera);
    echo "<script>alert(\"Empenhos Liberados com Sucesso.!!!\");</script>";	
    echo "<script>window.location = 'SolicitacaoGestaoInicio.php ';</script>";
}

?>
