<?php
    //controla a visibilidade do botao consultar
	$_SESSION['BotaoConsultar'] = 1;


	If ($AcaoSistema == "consultar")
    {

        $Codigo = $CodigoValidacao;

        $sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E, dados_unico.funcionario F, dados_unico.est_organizacional_funcionario EF WHERE est_organizacional_funcionario_st = 0 AND (F.funcionario_id = EF.funcionario_id) AND (PF.pessoa_id = F.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND (P.pessoa_id = PF.pessoa_id) AND P.pessoa_id = ".$Codigo;
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

        $linharsConsulta=pg_fetch_assoc($rsConsulta);

        If ($linharsConsulta)
        {
		//atributos da entidade pessoa
			$Codigo                           = $linha['pessoa_id'];
			$StatusNumero                     = $linha['pessoa_st'];
			$PessoaDate                       = $linha['pessoa_dt_criacao'];
			$PessoaDataAlteracao              = $linha['pessoa_dt_alteracao'];
			$Nome                             = $linha['pessoa_nm'];
			$Email                            = $linha['pessoa_email'];
			$NivelEscolar                     = $linha['nivel_escolar_id'];
			$EstadoCivil                      = $linha['estado_civil_id'];
			$Sexo                             = $linha['pessoa_fisica_sexo'];
			$CPF                              = $linha['pessoa_fisica_cpf'];
			$DataNascimento                   = $linha['pessoa_fisica_dt_nasc'];
			$RG                               = $linha['pessoa_fisica_rg'];
			$RGOrgao                          = $linha['pessoa_fisica_rg_orgao'];
			$RGOrgaoUF                        = $linha['pessoa_fisica_rg_uf'];
			$RGData                           = $linha['pessoa_fisica_rg_dt'];
			$Passaporte                       = $linha['pessoa_fisica_passaporte'];
			$Sangue                           = $linha['pessoa_fisica_grupo_sanguineo'];
			$Filho                            = $linha['pessoa_fisica_filho'];
			$Filha                            = $linha['pessoa_fisica_filha'];
			$NomePai                          = $linha['pessoa_fisica_nm_pai'];
			$NomeMae                          = $linha['pessoa_fisica_nm_mae'];
			$Nacionalidade                    = $linha['pessoa_fisica_nacionalidade'];
			$NaturalidadeUF                   = $linha['pessoa_fisica_naturalidade_uf'];
			$Naturalidade                     = $linha['pessoa_fisica_naturalidade'];
			

            If ($Sexo == "M")
            {
                $SexoMasc = "checked";
                $SexoFem  = "";
            }
            ElseIf ($Sexo == "F")
            {
                $SexoMasc = "";
                $SexoFem  = "checked";
            }
            Else
            {	$SexoMasc = "";
                $SexoFem  = "";
            }

            //se pessoa possuir nivel tecnico como nivel escolar, entao consultar dados
            $sqlConsultaNivelTecnico = "SELECT nivel_tecnico_curso_ds, nivel_tecnico_instituicao_ds, nivel_tecnico_conselho, nivel_tecnico_semestre FROM dados_unico.nivel_tecnico WHERE pessoa_id = ".$Codigo;
            $rsConsultaNivelTecnico = pg_query(abreConexao(),$sqlConsultaNivelTecnico);
            $linharsConsultaNivelTecnico=pg_fetch_assoc($rsConsultaNivelTecnico);

 			if($linha2)
			{
		    $NivelTecnicoCurso 		          = $linha2['nivel_tecnico_curso_ds'];
			$NivelTecnicoInstituicao  	      = $linha2['nivel_tecnico_instituicao_ds'];
			$NivelTecnicoConselho   	      = $linha2['nivel_tecnico_conselho'];
			$NivelTecnicoSemestre             = $linha2['nivel_tecnico_semestre'];
			}

			$TituloEleitor                    = $linha['pessoa_fisica_titulo'];
			$TituloEleitorZona                = $linha['pessoa_fisica_titulo_zona'];
			$TituloEleitorSecao               = $linha['pessoa_fisica_titulo_secao'];
			$TituloEleitorUF                  = $linha['pessoa_fisica_titulo_uf'];
			$TituloEleitorCidade              = $linha['pessoa_fisica_titulo_cidade'];
			$Habilitacao		              = $linha['pessoa_fisica_cnh'];
			$HabilitacaoCategoria             = $linha['pessoa_fisica_cnh_categoria'];
			$HabilitacaoValidade              = $linha['pessoa_fisica_cnh_validade'];
			$HabilitacaoLenteCorretiva	      = $linha['pessoa_fisica_cnh_lente_corretiva'];
			$Reservista                       = $linha['pessoa_fisica_reservista'];
			$ReservistaUF                     = $linha['pessoa_fisica_reservista_uf'];
			$ReservistaMinisterio             = $linha['pessoa_fisica_reservista_ministerio'];
			$Endereco                         = $linha['endereco_ds'];
			$EnderecoNumero                   = $linha['endereco_num'];
			$EnderecoComplemento              = $linha['endereco_complemento'];
			$EnderecoReferencia               = $linha['endereco_referencia'];
			$EnderecoCEP                      = $linha['endereco_cep'];
			$EnderecoUF                       = $linha['estado_uf'];
			$EnderecoMunicipio                = $linha['municipio_cd'];
			$EnderecoBairro                   = $linha['endereco_bairro'];
			
            If ($StatusNumero == "0")
            {  $StatusNome = "Ativo";

            }
            Else
            {  $StatusNome = "Inativo";

            }

            //se pessoa possuir nivel tecnico como nivel escolar, entao consultar dados
            $sqlConsultaTelefone = "SELECT * FROM dados_unico.telefone WHERE pessoa_id = ".$Codigo;
            $rsConsultaTelefone = pg_query(abreConexao(),$sqlConsultaTelefone);

            while($linharsConsultaTelefone=pg_fetch_assoc($rsConsultaTelefone))
            {

                If($linharsConsultaTelefone['telefone_tipo']== "R")
                {
                    $TelefoneDDDResidencial =$linharsConsultaTelefone['telefone_ddd'];
                    $TelefoneResidencial 	=$linharsConsultaTelefone['telefone_num'];
                }
                ElseIf($linharsConsultaTelefone['telefone_tipo']== "M")
                {
                    $TelefoneDDDCelular 		=$linharsConsultaTelefone['telefone_ddd'];
                    $TelefoneCelular 		=$linharsConsultaTelefone['telefone_num'];
                }
                ElseIf($linharsConsultaTelefone['telefone_tipo']== "C")
                {
                    $TelefoneDDDComercial 	=$linharsConsultaTelefone['telefone_ddd'];
                    $TelefoneComercial 		=$linharsConsultaTelefone['telefone_num'];
                }
                ElseIf($linharsConsultaTelefone['telefone_tipo']== "F")
                {
                    $TelefoneDDDFax 		=$linharsConsultaTelefone['telefone_ddd'];
                   $TelefoneFax 			=$linharsConsultaTelefone['telefone_num'];
                }

           }

       	//atributos da entidade funcionario
			$TipoFuncionario                  = $linha['funcionario_tipo_id'];
			$Matricula                        = $linha['funcionario_matricula'];
			$CargoTemporario                  = $linha['cargo_temporario'];
			$CargoPermanente                  = $linha['cargo_permanente'];
			$Funcao                           = $linha['funcao_id'];
			$DataAdmissao                     = $linha['funcionario_dt_admissao'];
			$DataDemissao                     = $linha['funcionario_dt_demissao'];
			$CartTrabalho                     = $linha['pessoa_fisica_clt'];
			$CartTrabalhoSerie                = $linha['pessoa_fisica_clt_serie'];
			$CartTrabalhoUF                   = $linha['pessoa_fisica_clt_uf'];
			$PIS                              = $linha['pessoa_fisica_pis'];
			$FGTS                             = $linha['funcionario_conta_fgts'];
			$EstruturaAtuacao                 = $linha['est_organizacional_id'];
			$EstruturaLotacao                 = $linha['est_organizacional_lotacao_id'];
			$OrgaoOrigem                      = $linha['funcionario_orgao_origem'];
			$OrgaoDestino                     = $linha['funcionario_orgao_destino'];
			$FuncionarioRamal                 = $linha['funcionario_ramal'];
			$FuncionarioEmail                 = $linha['funcionario_email'];

            //se pessoa possuir dados bancarios
            $sqlConsultaBanco = "SELECT * FROM dados_unico.dados_bancarios db, dados_unico.banco b WHERE (db.banco_id = b.banco_id) AND pessoa_id = ".$Codigo;
            $rsConsultaBanco = pg_query(abreConexao(),$sqlConsultaBanco);

            $linharsConsultaBanco=pg_fetch_assoc($rsConsultaBanco);

             If($linharsConsultaBanco)
			{
			$Funcionario_id                   = $linha5['funcionario_id'];
			$Documento                        = $linha5['documento'];
			$Pasta                            = $linha5['pasta'];
			$Armario 		                  = $linha5['armario'];
			$Gaveta                           = $linha5['gaveta'];
			$Posicao                          = $linha5['posicao'];
			}
        }

    }

	ElseIf ($AcaoSistema == "alterar")
    {
  		$Codigo					              = $_POST['txtCodigo'];
		$EstruturaOriginal                    = $_POST['txtEstruturaOriginal'];
		$EstruturaLotacao	                  = $_POST['cmbEstruturaLotacao'];
		$Nome					              = strtoupper(trim($_POST['txtNome']));
		$Email					              = strtolower(trim($_POST['txtEmail']));
		$DataAlteracao 		                  = date("Y-m-d");
		$NivelEscolar			              = $_POST['cmbNivelEscolar'];
		$EstadoCivil			              = $_POST['cmbEstadoCivil'];
		$Sexo					              = $_POST['rdSexo'];
		$CPF					              = $_POST['txtCPF'];
		$DataNascimento		                  = $_POST['txtDtNasc'];
		$RG						              = $_POST['txtRG'];
		$RGOrgao				              = strtoupper($_POST['txtRGOrgao']);
		$RGOrgaoUF				              = $_POST['cmbRGUF'];
		$RGData					              = $_POST['txtRGDtExpedicao'];
		$Passaporte				              = $_POST['txtPassaporte'];
		$Sangue					              = $_POST['cmbGrupoSanguineo'];
		$Filho					              = $_POST['txtFilho'];
		$Filha					              = $_POST['txtFilha'];
		$NomePai				              = strtoupper(trim($_POST['txtPai']));
		$NomeMae 				              = strtoupper(trim($_POST['txtMae']));
		$Nacionalidade		                  = $_POST['cmbNacionalidade'];
		$NaturalidadeUF		                  = $_POST['cmbNaturalidadeUF'];
		$Naturalidade			              = $_POST['cmbNaturalidade'];
		$NivelTecnicoCurso                    = $_POST['txtNivelEscolarCurso'];
		$NivelTecnicoInstituicao              = $_POST['txtNivelEscolarInstituicao'];
		$NivelTecnicoConselho  	              = $_POST['txtNivelEscolarConselho'];
		$NivelTecnicoSemestre  	              = $_POST['txtNivelEscolarSemestre'];
		$Endereco				              = strtoupper(trim($_POST['txtEndereco']));
		$EnderecoNumero			              = $_POST['txtNumero'];
		$EnderecoComplemento	              = $_POST['txtComplemento'];
		$EnderecoReferencia 	              = $_POST['txtReferencia'];
		$EnderecoCEP			              = $_POST['txtCEP'];
		$EnderecoUF				              = $_POST['cmbEnderecoUF'];
		$EnderecoMunicipio		              = $_POST['cmbEnderecoMunicipio'];
		$EnderecoBairro			              = strtoupper(trim($_POST['txtEnderecoBairro']));
		$TipoFuncionario		              = $_POST['cmbFuncionarioTipo'];
		$Matricula				              = $_POST['txtMatricula'];
		$CargoTemporario		              = $_POST['cmbCargoTemporario'];
		$CargoPermanente		              = $_POST['cmbCargoPermanente'];
		$Funcao					              = $_POST['cmbFuncao'];
		$DataAdmissao			              = $_POST['txtDtAdmissao'];
		$DataDemissao			              = $_POST['txtDtDemissao'];
		$CartTrabalho			              = $_POST['txtCLTNumero'];
		$CartTrabalhoSerie		              = $_POST['txtCLTSerie'];
		$CartTrabalhoUF			              = $_POST['cmbCLTUF'];
		$TituloEleitor			              = $_POST['txtTitulo'];
		$TituloEleitorZona		              = $_POST['txtTituloZona'];
		$TituloEleitorSecao		              = $_POST['txtTituloSecao'];
		$TituloEleitorUF		              = $_POST['cmbTituloUF'];
		$TituloEleitorCidade	              = $_POST['cmbTituloCidade'];
		$Habilitacao			              = $_POST['txtHabilitacao'];
		$HabilitacaoCategoria                 = $_POST['txtHabilitacaoCategoriaCarro'];
		$HabilitacaoValidade	              = $_POST['txtHabilitacaoValidade'];
		$HabilitacaoLenteCorretiva            = $_POST['txtHabilitacaoLenteCorretiva'];
		$Reservista				              = $_POST['txtReservista'];
		$ReservistaUF			              = $_POST['cmbReservistaUF'];
		$ReservistaMinisterio	              = $_POST['cmbMinisterio'];
		$PIS					              = $_POST['txtPIS'];
		$FGTS					              = $_POST['txtFGTS'];
		$EstOrganizacional		              = $_POST['cmbEstruturaAtuacao'];
		$OrgaoOrigem			              = $_POST['cmbOrgaoOrigem'];
		$OrgaoDestino			              = $_POST['cmbOrgaoDestino'];
		$FuncionarioRamal 		              = $_POST['txtRamal'];
		$FuncionarioEmail 		              = strtolower(trim($_POST['txtFuncionarioEmail']));


 	    $Banco					              = $_POST['cmbBanco'];
		$Agencia				              = $_POST['txtAgencia'];
		$Conta					              = $_POST['txtConta'];
		$TipoConta			                  = $_POST['cmbTipoConta'];
		$Documento		                      = $_POST['txtDocumento'];
		$Pasta 			                      = $_POST['txtPasta'];
		$Armario 				              = $_POST['txtArmario'];
		$Gaveta					              = $_POST['txtGaveta'];
		$Posicao				              = $_POST['txtPosicao'];
		$TelefoneDDDResidencial               = $_POST['txtFoneDDDResidencial'];
		$TelefoneResidencial 	              = $_POST['txtFoneResidencial'];
		$TelefoneDDDComercial 	              = $_POST['txtFoneDDDComercial'];
		$TelefoneComercial	 	              = $_POST['txtFoneComercial'];
		$TelefoneDDDCelular 	              = $_POST['txtFoneDDDCelular'];
		$TelefoneCelular 		              = $_POST['txtFoneCelular'];
		$TelefoneDDDFax 		              = $_POST['txtFoneDDDFax'];
		$TelefoneFax 			              = $_POST['txtFonefax'];

        $sqlConsultaExistente = "SELECT PF.pessoa_id FROM dados_unico.pessoa_fisica PF, dados_unico.funcionario F WHERE (PF.pessoa_id = F.pessoa_id) AND (pessoa_fisica_cpf = '" .$CPF. "' OR funcionario_matricula = '" .$Matricula. "') AND PF.pessoa_id <> " .$Codigo;
        $rsConsultaExistente = pg_query(abreConexao(),$sqlConsultaExistente);

        If(pg_fetch_row($rsConsultaExistente)==0)
        {
            $BeginTrans= "BEGIN WORK";
            pg_query(abreConexao(),$BeginTrans);

            $sqlAltera = "UPDATE dados_unico.pessoa SET	pessoa_nm = '".$Nome."',pessoa_email = '".$Email."',pessoa_dt_alteracao = '".$DataAlteracao."' WHERE pessoa_id = ".$Codigo;

             pg_query(abreConexao(),$sqlAltera);

             $sqlAltera = "UPDATE dados_unico.pessoa_fisica SET pessoa_fisica_sexo = '" .$Sexo."',pessoa_fisica_cpf = '" .$CPF."',pessoa_fisica_dt_nasc = '" .$DataNascimento."',pessoa_fisica_rg = '" .$RG."',pessoa_fisica_rg_orgao = '" .$RGOrgao."',	pessoa_fisica_rg_uf = '" .$RGOrgaoUF."', pessoa_fisica_rg_dt = '" .$RGData."', pessoa_fisica_passaporte = '" .$Passaporte."', pessoa_fisica_nm_pai = '" .$NomePai."', pessoa_fisica_nm_mae = '" .$NomeMae. "', pessoa_fisica_grupo_sanguineo = '" .$Sangue."', pessoa_fisica_filho = '" .$Filho."',pessoa_fisica_filha = '" .$Filha."',pessoa_fisica_nacionalidade = '" .$Nacionalidade."', pessoa_fisica_naturalidade = '" .$Naturalidade."', pessoa_fisica_naturalidade_uf = '" .$NaturalidadeUF."', pessoa_fisica_clt = '" .$CartTrabalho."', pessoa_fisica_clt_serie = '" .$CartTrabalhoSerie."', pessoa_fisica_clt_uf = '" .$CartTrabalhoUF."', pessoa_fisica_titulo = '" .$TituloEleitor."', pessoa_fisica_titulo_zona = '" .$TituloEleitorZona."',  pessoa_fisica_titulo_secao = '" .$TituloEleitorSecao."', pessoa_fisica_titulo_cidade = '" .$TituloEleitorCidade."', pessoa_fisica_titulo_uf = '" .$TituloEleitorUF."', pessoa_fisica_cnh = '" .$Habilitacao."', pessoa_fisica_cnh_categoria = '".$HabilitacaoCategoria. "',  pessoa_fisica_cnh_validade = '" .$HabilitacaoValidade."', pessoa_fisica_cnh_lente_corretiva = '".$HabilitacaoLenteCorretiva. "', pessoa_fisica_reservista = '" .$Reservista."', pessoa_fisica_reservista_ministerio = '" .$ReservistaMinisterio."', pessoa_fisica_reservista_uf = '" .$ReservistaUF."',	pessoa_fisica_pis = '" .$PIS."', estado_civil_id = " .$EstadoCivil.", nivel_escolar_id = " .$NivelEscolar." WHERE pessoa_id = " .$Codigo;

            pg_query(abreConexao(),$sqlAltera);

            If ($NivelTecnico != "")
            {
           $sqlAltera = "UPDATE dados_unico.nivel_tecnico SET nivel_tecnico_curso_ds = '" .$NivelTecnicoCurso."', nivel_tecnico_instituicao_ds = '" .$NivelTecnicoInstituicao."', nivel_tecnico_conselho = '" .$NivelTecnicoConselho."', nivel_tecnico_semestre = '" .$NivelTecnicoSemestre."' WHERE pessoa_id = " .$Codigo;
            }

            $sqlAltera = "UPDATE dados_unico.endereco SET estado_uf = '".$EnderecoUF."',municipio_cd = '".$EnderecoMunicipio."',endereco_bairro = '".$EnderecoBairro."',endereco_ds = '".$Endereco."',endereco_num = '".$EnderecoNumero."',	endereco_cep = '".$EnderecoCEP."',endereco_complemento = '".$EnderecoComplemento."',endereco_referencia = '".$EnderecoReferencia."' WHERE pessoa_id = ".$Codigo;

            pg_query(abreConexao(),$sqlAltera);

            //residencial
            $sql = "select * from dados_unico.telefone where telefone_tipo = 'R' AND pessoa_id = ".$Codigo;
            $rs = pg_query(abreConexao(),$sql);

            $linha=pg_fetch_assoc($rs);

            If($linha)
            {
                $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '".$TelefoneResidencial."',telefone_ddd = '".$TelefoneDDDResidencial."'WHERE telefone_tipo = 'R' AND pessoa_id = ".$Codigo;

                pg_query(abreConexao(),$sqlAltera);
            }
            Else
            {
                $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (".$Codigo.",'".$TelefoneResidencial."', '".$TelefoneDDDResidencial."', 'R')";
                pg_query(abreConexao(),$sqlInsere);

            }

            //comercial
            $sql = "select * from dados_unico.telefone where telefone_tipo = 'C' AND pessoa_id = ".$Codigo;
            $linha=pg_fetch_assoc($rs);

            If($linha)
            {
                $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '".$TelefoneComercial."', telefone_ddd = '".$TelefoneDDDComercial."'WHERE telefone_tipo = 'C' AND pessoa_id = ".$Codigo;
                pg_query(abreConexao(),$sqlAltera);
            }
            Else
            {
                $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (".$Codigo.",'".$TelefoneComercial."', '".$TelefoneDDDComercial."', 'C')";
                pg_query(abreConexao(),$sqlInsere);

            }

            //celular
            $sql = "select * from dados_unico.telefone where telefone_tipo = 'M' AND pessoa_id = ".$Codigo;
            $rs = pg_query(abreConexao(),$sql);

            $linha=pg_fetch_assoc($rs);

            If ($linha)
            {
                $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '".$TelefoneCelular."',telefone_ddd = '".$TelefoneDDDCelular."' WHERE telefone_tipo = 'M' AND pessoa_id = ".$Codigo;
                pg_query(abreConexao(),$sqlAltera);
            }
            Else
            {
                $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (".$Codigo.",'".$TelefoneCelular."', '".$TelefoneDDDCelular."', 'M')";
                pg_query(abreConexao(),$sqlInsere);
            }

            //fax
            $sql = "select * from dados_unico.telefone where telefone_tipo = 'F' AND pessoa_id = ".$Codigo;
            $rs = pg_query(abreConexao(),$sql);
            $linha=pg_fetch_assoc($rs);

            If ($linha)
            {
                $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '".$TelefoneFAX."',telefone_ddd = '".$TelefoneDDDFAX."' WHERE telefone_tipo = 'F' AND pessoa_id = ".$Codigo;
                pg_query(abreConexao(),$sqlAltera);
            }
            Else
            {
                $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (".$Codigo.",'".$TelefoneFAX."', '".$TelefoneDDDFAX."', 'F')";
                pg_query(abreConexao(),$sqlInsere);

            }

            $sqlAltera = "UPDATE dados_unico.funcionario SET funcionario_matricula = '".$Matricula."',	funcionario_email = '".$FuncionarioEmail."',funcionario_dt_admissao = '".$DataAdmissao."',funcionario_dt_demissao = '".$DataDemissao."',funcionario_conta_fgts = '".$FGTS."',funcionario_validacao_propria = 1 	WHERE pessoa_id = ".$Codigo;;

            pg_query(abreConexao(),$sqlAltera);

            If ($Banco != "")
            {
                $sqlConsulta = "SELECT dados_bancarios_id FROM dados_unico.dados_bancarios WHERE pessoa_id = ".$Codigo;
                $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                $linha=pg_fetch_assoc($rsConsulta);

                If ($linha)
                {
                    $sqlInsere = "INSERT INTO dados_unico.dados_bancarios (pessoa_id, banco_id, dados_bancarios_agencia, dados_bancarios_conta, dados_bancarios_conta_tipo, dados_bancarios_dt_criacao) VALUES (".$Codigo.", ".$Banco.", '".$Agencia."', '".$Conta."', '".$TipoConta."', '".$DataAlteracao."')";
                    pg_query(abreConexao(),$sqlInsere);
                }
                Else
                {	$sqlAltera = "UPDATE dados_unico.dados_bancarios SET banco_id = ".$Banco.",	dados_bancarios_agencia = '".$Agencia."',dados_bancarios_conta = '".$Conta."',dados_bancarios_conta_tipo = '".$TipoConta."',dados_bancarios_dt_alteracao = '".$DataAlteracao."'WHERE pessoa_id = ".$Codigo;

                    pg_query(abreConexao(),$sqlAltera);
                }
            }
            If ($Err != 0)
            {
                $RollbackTrans = "ROLLBACK";
                pg_query(abreConexao(),$RollbackTrans);

                echo $Err;
            }
            Else
            {	$CommitTrans="COMMIT";
                pg_query(abreConexao(),$CommitTrans);

            }
            echo "<script>window.location = 'ValidacaoSucesso.php ';</script>";
        }
        Else
        {
                $MensagemErroBD = "CPF ou Matr&iacute;cula j&aacute;existente.";
        }
}

		

?>
