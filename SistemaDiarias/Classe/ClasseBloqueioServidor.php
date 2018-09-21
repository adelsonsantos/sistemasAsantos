<?php
//controla a visibilidade do botao consultar
$_SESSION['BotaoConsultar'] = 1;

//zera a variavel de msg de banco
$MensagemErroBD = "";

//define o link padrao para as paginas
$PaginaLocal = "BloqueioServidor";

//carrega grade de informacoes na pagina inicial
if (($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
{
    $numFiltro = $_GET['filtro'];

    if(isset($_GET['validado']))
    {
        $_SESSION["validado"] = $_GET['validado'];
    }

    $numFiltroFuncionario = $_SESSION["validado"];

    if ($numFiltroFuncionario != "")
    {
        $strStringSQL = "funcionario_validacao_rh = " . $numFiltroFuncionario;
    }
    else
    {
        $strStringSQL = "funcionario_validacao_rh = 1";
    }

    if($numFiltro != "")
    {
        $strStringSQL .= " AND pessoa_bloq_diaria = $numFiltro";
    }
    else
    {
        $strStringSQL .= " AND pessoa_st = 0 ";
    }

    //fim do filtro
    if ($RetornoFiltro != "")
    {
        $sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, funcionario_matricula, est_organizacional_sigla, funcionario_validacao_propria, pessoa_bloq_diaria FROM  dados_unico.pessoa p,dados_unico.pessoa_fisica pf,  dados_unico.funcionario f,  dados_unico.est_organizacional eo, dados_unico.est_organizacional_funcionario ef WHERE (p.pessoa_id = pf.pessoa_id) AND (eo.est_organizacional_id = ef.est_organizacional_id) AND est_organizacional_funcionario_st = 0 AND (ef.funcionario_id = f.funcionario_id) AND (p.pessoa_id = f.pessoa_id) AND ((pessoa_nm ILIKE '%" .$RetornoFiltro. "%') OR (funcionario_matricula ILIKE '%" .$RetornoFiltro. "%') OR (pessoa_fisica_cpf ILIKE '%" .$RetornoFiltro. "%') OR (pessoa_fisica_rg ILIKE '%" .$RetornoFiltro. "%') OR (funcionario_ramal ILIKE '%" .$RetornoFiltro. "%' )OR (est_organizacional_sigla ILIKE '%" .$RetornoFiltro. "%')  ) AND " .$strStringSQL." AND funcionario_tipo_id <> 3 AND pessoa_st = 0 ORDER BY UPPER(pessoa_nm)";
    }
    else
    {
        $sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, funcionario_matricula, est_organizacional_sigla, funcionario_validacao_propria, pessoa_bloq_diaria FROM  dados_unico.pessoa p,  dados_unico.funcionario f,  dados_unico.est_organizacional eo, dados_unico.est_organizacional_funcionario ef WHERE (eo.est_organizacional_id = ef.est_organizacional_id) AND est_organizacional_funcionario_st = 0 AND (ef.funcionario_id = f.funcionario_id) AND (p.pessoa_id = f.pessoa_id) AND " .$strStringSQL. " AND funcionario_tipo_id <> 3 AND pessoa_st = 0 ORDER BY UPPER(pessoa_nm)";
    }
    //echo $sqlConsulta;
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
}



ElseIf ($AcaoSistema == "consultar")
{
    $Codigo = $_GET['cod'];

    $_SESSION['CargoTemporario'] = "";
    $_SESSION['CargoPermanente'] = "";

    if ($Codigo == "")
    {
        $Codigo = $_POST['checkbox'];
        if ($Codigo == "")
        {
            $Codigo = $CodigoValidacao;
        }
        $sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E, dados_unico.funcionario F, dados_unico.est_organizacional_funcionario EF WHERE est_organizacional_funcionario_st = 0 AND (F.funcionario_id = EF.funcionario_id) AND (PF.pessoa_id = F.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND (P.pessoa_id = PF.pessoa_id) AND P.pessoa_id IN (" .$Codigo. ")";
    }
    else
    {
        $sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E, dados_unico.funcionario F, dados_unico.est_organizacional_funcionario EF WHERE est_organizacional_funcionario_st = 0 AND (F.funcionario_id = EF.funcionario_id) AND (PF.pessoa_id = F.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND (P.pessoa_id = PF.pessoa_id) AND P.pessoa_id = " .$Codigo;
    }

    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    //echo $sqlConsulta; exit;
    $linha=pg_fetch_assoc($rsConsulta);
    if ($linha)
    {
        //atributos da entidade pessoa
        $Codigo              = $linha['pessoa_id'];
        $StatusNumero        = $linha['pessoa_st'];
        $PessoaDate          = $linha['pessoa_dt_criacao'];
        $PessoaDataAlteracao = $linha['pessoa_dt_alteracao'];
        $Nome                = $linha['pessoa_nm'];
        $Email               = $linha['pessoa_email'];
        $NivelEscolar        = $linha['nivel_escolar_id'];
        $EstadoCivil         = $linha['estado_civil_id'];
        $Sexo                = $linha['pessoa_fisica_sexo'];
        $CPF                 = $linha['pessoa_fisica_cpf'];
        $DataNascimento      = $linha['pessoa_fisica_dt_nasc'];
        $RG                  = $linha['pessoa_fisica_rg'];
        $RGOrgao             = $linha['pessoa_fisica_rg_orgao'];
        $RGOrgaoUF           = $linha['pessoa_fisica_rg_uf'];
        $RGData              = $linha['pessoa_fisica_rg_dt'];
        $Passaporte          = $linha['pessoa_fisica_passaporte'];
        $Sangue              = $linha['pessoa_fisica_grupo_sanguineo'];
        $Filho               = $linha['pessoa_fisica_filho'];
        $Filha               = $linha['pessoa_fisica_filha'];
        $NomePai             = $linha['pessoa_fisica_nm_pai'];
        $NomeMae             = $linha['pessoa_fisica_nm_mae'];
        $Nacionalidade       = $linha['pessoa_fisica_nacionalidade'];
        $NaturalidadeUF      = $linha['pessoa_fisica_naturalidade_uf'];
        $Naturalidade        = $linha['pessoa_fisica_naturalidade'];
        $PessoaBloqueio      = $linha['pessoa_bloq_diaria'];

        if ($Sexo == "M")
        {
            $SexoMasc = "checked";
            $SexoFem  = "";
        }
        elseIf ($Sexo == "F")
        {
            $SexoMasc = "";
            $SexoFem  = "checked";
        }
        else
        {
            $SexoMasc = "";
            $SexoFem  = "";
        }

        //se pessoa possuir nivel tecnico como nivel escolar, entao consultar dados
        $sqlConsultaNivelTecnico = "SELECT nivel_tecnico_curso_ds, nivel_tecnico_instituicao_ds, nivel_tecnico_conselho, nivel_tecnico_semestre FROM dados_unico.nivel_tecnico WHERE pessoa_id = " .$Codigo;
        $rsConsultaNivelTecnico = pg_query(abreConexao(),$sqlConsultaNivelTecnico);
        $linha2=pg_fetch_assoc($rsConsultaNivelTecnico);

        if($linha2)
        {
            $NivelTecnicoCurso 	       = $linha2['nivel_tecnico_curso_ds'];
            $NivelTecnicoInstituicao   = $linha2['nivel_tecnico_instituicao_ds'];
            $NivelTecnicoConselho      = $linha2['nivel_tecnico_conselho'];
            $NivelTecnicoSemestre      = $linha2['nivel_tecnico_semestre'];
        }

        $TituloEleitor             = $linha['pessoa_fisica_titulo'];
        $TituloEleitorZona         = $linha['pessoa_fisica_titulo_zona'];
        $TituloEleitorSecao        = $linha['pessoa_fisica_titulo_secao'];
        $TituloEleitorUF           = $linha['pessoa_fisica_titulo_uf'];
        $TituloEleitorCidade       = $linha['pessoa_fisica_titulo_cidade'];
        $Habilitacao		   = $linha['pessoa_fisica_cnh'];
        $HabilitacaoCategoria      = $linha['pessoa_fisica_cnh_categoria'];
        $HabilitacaoValidade       = $linha['pessoa_fisica_cnh_validade'];
        $HabilitacaoLenteCorretiva = $linha['pessoa_fisica_cnh_lente_corretiva'];
        $Reservista                = $linha['pessoa_fisica_reservista'];
        $ReservistaUF              = $linha['pessoa_fisica_reservista_uf'];
        $ReservistaMinisterio      = $linha['pessoa_fisica_reservista_ministerio'];
        $Endereco                  = $linha['endereco_ds'];
        $EnderecoNumero            = $linha['endereco_num'];
        $EnderecoComplemento       = $linha['endereco_complemento'];
        $EnderecoReferencia        = $linha['endereco_referencia'];
        $EnderecoCEP               = $linha['endereco_cep'];
        $EnderecoUF                = $linha['estado_uf'];
        $EnderecoMunicipio         = $linha['municipio_cd'];
        $EnderecoBairro            = $linha['endereco_bairro'];

        if ($StatusNumero == "0")
        {
            $StatusNome = "Ativo";
        }
        else
        {
            $StatusNome = "Inativo";
        }

        //se pessoa TEL, entao consultar dados
        $sqlConsultaTelefone = "SELECT * FROM dados_unico.telefone WHERE pessoa_id = " .$Codigo;
        $rsConsultaTelefone  = pg_query(abreConexao(),$sqlConsultaTelefone);

        while($linha3=pg_fetch_assoc($rsConsultaTelefone))
        {
            if ($linha3['telefone_tipo']== "R")
            {
                $TelefoneDDDResidencial = $linha3['telefone_ddd'];
                $TelefoneResidencial 	= $linha3['telefone_num'];
            }
            elseif ($linha3['telefone_tipo']== "M")
            {
                $TelefoneDDDCelular = $linha3['telefone_ddd'];
                $TelefoneCelular    = $linha3['telefone_num'];
            }
            elseif ($linha3['telefone_tipo'] == "C")
            {
                $TelefoneDDDComercial 	= $linha3['telefone_ddd'];
                $TelefoneComercial 	= $linha3['telefone_num'];
            }
            elseif ($linha3['telefone_tipo']== "F")
            {
                $TelefoneDDDFax = $linha3['telefone_ddd'];
                $TelefoneFax 	= $linha3['telefone_num'];
            }
        }

        //atributos da entidade funcionario
        $TipoFuncionario             = $linha['funcionario_tipo_id'];
        $Matricula                   = $linha['funcionario_matricula'];
        $CargoTemporario             = $linha['cargo_temporario'];
        $CargoPermanente             = $linha['cargo_permanente'];
        $_SESSION['CargoTemporario'] = $CargoTemporario;
        $_SESSION['CargoPermanente'] = $CargoPermanente;
        $Funcao                      = $linha['funcao_id'];
        $DataAdmissao                = $linha['funcionario_dt_admissao'];
        $DataDemissao                = $linha['funcionario_dt_demissao'];
        $CartTrabalho                = $linha['pessoa_fisica_clt'];
        $CartTrabalhoSerie           = $linha['pessoa_fisica_clt_serie'];
        $CartTrabalhoUF              = $linha['pessoa_fisica_clt_uf'];
        $PIS                         = $linha['pessoa_fisica_pis'];
        $FGTS                        = $linha['funcionario_conta_fgts'];
        $EstruturaAtuacao            = $linha['est_organizacional_id'];
        $EstruturaLotacao            = $linha['est_organizacional_lotacao_id'];
        $OrgaoOrigem                 = $linha['funcionario_orgao_origem'];
        $OrgaoDestino                = $linha['funcionario_orgao_destino'];
        $FuncionarioOnus             = $linha['funcionario_onus'];
        $FuncionarioEmail            = $linha['funcionario_email'];

        //se possiu  dados  arquivamento

        $sqlConsultaArquivo = "SELECT * FROM dados_unico.funcionario_arquivo db  WHERE (db.funcionario_id = ".$Codigo.")";
        $rsConsultaArquivo  = pg_query(abreConexao(),$sqlConsultaArquivo);
        $linha5             = pg_fetch_assoc($rsConsultaArquivo);



        if($linha5)
        {
            $Funcionario_id = $linha5['funcionario_id'];
            $Documento      = $linha5['documento'];
            $Pasta          = $linha5['pasta'];
            $Armario 	    = $linha5['armario'];
            $Gaveta         = $linha5['gaveta'];
            $Posicao        = $linha5['posicao'];
        }
        //fim

        $sqlConsultaOrganizacional = "SELECT * FROM dados_unico.est_organizacional est  WHERE (est.est_organizacional_id = ".$EstruturaAtuacao.")";
        $rsConsultaOrganizacional  = pg_query(abreConexao(),$sqlConsultaOrganizacional);
        $linha6             = pg_fetch_assoc($rsConsultaOrganizacional);

        if($linha6){
            $EstruturaSigla = $linha6['est_organizacional_sigla'];
            $EstruturaDescricao = $linha6['est_organizacional_ds'];
        }

        $sqlConsultaUltimoBloqueio = "SELECT * FROM diaria.bloqueio_servidor blo  WHERE (blo.pessoa_id = ".$Codigo.") order by bloqueio_servidor_id desc limit 1";
        $rsConsultaUltimoBloqueio  = pg_query(abreConexao(),$sqlConsultaUltimoBloqueio);
        $linha7             = pg_fetch_assoc($rsConsultaUltimoBloqueio);

        $descricaoBloqueio = $linha7['bloqueio_descricao'];

        //se pessoa possuir dados bancarios
        $sqlConsultaBanco = "SELECT *
                               FROM dados_unico.dados_bancarios db
                               JOIN dados_unico.banco b  ON db.banco_id = b.banco_id
                              WHERE pessoa_id = ".$Codigo."
                           ORDER BY db.dados_bancarios_id DESC LIMIT 1";

        $rsConsultaBanco = pg_query(abreConexao(),$sqlConsultaBanco);
        $linha4 = pg_fetch_assoc($rsConsultaBanco);

        if ($linha4)
        {
            $Banco       = $linha4['banco_id'];
            $BancoNome   = $linha4['banco_ds'];
            $BancoNumero = $linha4['banco_cd'];
            $Agencia     = $linha4['dados_bancarios_agencia'];
            $Conta       = $linha4['dados_bancarios_conta'];
            $TipoConta   = $linha4['dados_bancarios_conta_tipo'];
        }
    }
}

ElseIf($AcaoSistema == "incluir"){
    $Codigo      = $_POST['txtCodigo'];
    $Bloqueio      = $_POST['txtBloqueio'];
    $StatusCod	   = $_POST['txtStatus'];
    $DataAlteracao = date("Y-m-d");
    $dataHora = new DateTime();

    if($StatusCod == 1){
        $sqlConsultaUltimoBloqueio = "SELECT * FROM diaria.bloqueio_servidor blo  WHERE (blo.pessoa_id = ".$Codigo.")order by bloqueio_servidor_id desc limit 1";
        $rsConsultaUltimoBloqueio  = pg_query(abreConexao(),$sqlConsultaUltimoBloqueio);
        $linhaBloqueado             = pg_fetch_assoc($rsConsultaUltimoBloqueio);


        if(!empty($linhaBloqueado)){
            $sqlAltera = "UPDATE diaria.bloqueio_servidor SET pessoa_id = ".$Codigo.",bloqueio_data_hora = '" .$dataHora->format('Y-m-d H:i:s')."', bloqueio_descricao = '".$Bloqueio."', usuario_bloqueio = ".$_SESSION['UsuarioCodigo']." WHERE bloqueio_servidor_id = ".$linhaBloqueado['bloqueio_servidor_id'];

            pg_query(abreConexao(),$sqlAltera);
        }
    }else{
        $sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_bloq_diaria = 1, pessoa_dt_alteracao = '" .$DataAlteracao."' WHERE pessoa_id = " .$Codigo;
        pg_query(abreConexao(),$sqlAltera);

        $sqlInsere = "INSERT INTO diaria.bloqueio_servidor (pessoa_id, bloqueio_descricao, usuario_bloqueio, bloqueio_data_hora ) VALUES (".$Codigo.", '".$Bloqueio."', ".$_SESSION['UsuarioCodigo'].", '".$dataHora->format('Y-m-d H:i:s')."')";
        pg_query(abreConexao(), $sqlInsere);

    }



    If ($Err != 0)
    { //error occurred
        $bSuccess = False;
    }
    Else
    {
        $bSuccess = True;
        echo "<script>window.location = 'BloqueioServidorInicio.php ';</script>";
    }
}

Elseif ($AcaoSistema == "alterarStatus")
{
    $DataAlteracao = date("Y-m-d");
    $Codigo 	   = $_GET['cod'];
    $StatusCod	   = $_GET['status'];
    $dataHora = new DateTime();

    if ($StatusCod == 0)
    {
        $StatusCod = 1;
    }
    else
    {
        $StatusCod = 0;
    }

    $sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_bloq_diaria = " .$StatusCod.", pessoa_dt_alteracao = '" .$DataAlteracao."' WHERE pessoa_id = " .$Codigo;
    pg_query(abreConexao(),$sqlAltera);

    $sqlConsultaUltimoBloqueio = "SELECT * FROM diaria.bloqueio_servidor blo  WHERE (blo.pessoa_id = ".$Codigo.")order by bloqueio_servidor_id desc limit 1";
    $rsConsultaUltimoBloqueio  = pg_query(abreConexao(),$sqlConsultaUltimoBloqueio);
    $linhaBloqueado             = pg_fetch_assoc($rsConsultaUltimoBloqueio);

    $sqlAlteraBloqueio = "UPDATE diaria.bloqueio_servidor SET desbloqueio_data_hora = '" .$dataHora->format('Y-m-d H:i:s')."', usuario_desbloqueio = ".$_SESSION['UsuarioCodigo']." WHERE bloqueio_servidor_id = ".$linhaBloqueado['bloqueio_servidor_id'];
    pg_query(abreConexao(),$sqlAlteraBloqueio);

    echo "<script>window.location = 'BloqueioServidorInicio.php ';</script>";
}

?>
