<?php
	//print($AcaoSistema);
	//controla a visibilidade do botao consultar
	$_SESSION['BotaoConsultar'] = 1;

	//zera a variavel de msg de banco
	$MensagemErroBD = "";

	//define o link padrao para as paginas
	$PaginaLocal = "Terceirizado";

	//carrega grade de informacoes na pagina inicial
	if (($AcaoSistema == "buscar")||($AcaoSistema == ""))
  {

			$numFiltro = $_GET['filtro'];

			If ($numFiltro !="")
            {
				$strStringSQL = "pessoa_st = ".$numFiltro;
            }
			Else
			{	$strStringSQL = "pessoa_st <> 2";

            }
			// fim do filtro

			If ($RetornoFiltro != "")
            {
				$sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, funcionario_matricula, contrato_num FROM dados_unico.pessoa p, dados_unico.pessoa_fisica pf, dados_unico.funcionario f, dados_unico.contrato c WHERE (p.pessoa_id = pf.pessoa_id) AND (c.contrato_id = f.contrato_id) AND (p.pessoa_id = f.pessoa_id) AND ((pessoa_nm ILIKE '%".$RetornoFiltro."%') OR (pessoa_fisica_cpf ILIKE '%" .$RetornoFiltro. "%') OR (pessoa_fisica_rg ILIKE '%" .$RetornoFiltro. "%') OR (funcionario_ramal ILIKE '%" .$RetornoFiltro. "%' )OR (contrato_num ILIKE '%" .$RetornoFiltro. "%')) AND ".$strStringSQL." ORDER BY UPPER(pessoa_nm)";
            }
            Else
			{	$sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, funcionario_matricula, contrato_num FROM dados_unico.pessoa p, dados_unico.funcionario f, dados_unico.contrato c WHERE (c.contrato_id = f.contrato_id) AND (p.pessoa_id = f.pessoa_id) AND ".$strStringSQL." ORDER BY UPPER(pessoa_nm)";
            }
		//print($sqlConsulta);
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

    }
	elseif ($AcaoSistema == "incluir")
	{
		$sqlConsultaTipo = "SELECT funcionario_tipo_id FROM dados_unico.funcionario_tipo WHERE funcionario_tipo_terceirizado = 1";
		$rsConsultaTipo  = pg_query(abreConexao(),$sqlConsultaTipo);
	
		$linha = pg_fetch_assoc($rsConsultaTipo);
		//atributos da entidade pessoa
	    $DataCriacao 		               = date("Y-m-d");
		$Tipo					           = "F";
		$Nome					           = strtoupper(trim($_POST['txtNome']));
		$Email				               = strtolower(trim($_POST['txtEmail']));
		$NivelEscolar		               = $_POST['cmbNivelEscolar'];
		$EstadoCivil		               = $_POST['cmbEstadoCivil'];
		$Sexo					           = $_POST['rdSexo'];
		$CPF					           = $_POST['txtCPF'];
		$DataNascimento	                   = $_POST['txtDtNasc'];
		$RG						           = $_POST['txtRG'];
		$RGOrgao				           = strtoupper($_POST['txtRGOrgao']);
		$RGOrgaoUF			               = $_POST['cmbRGUF'];
		$RGData					           = $_POST['txtRGDtExpedicao'];
		$Passaporte			               = $_POST['txtPassaporte'];
		$Sangue					           = $_POST['cmbGrupoSanguineo'];
		$Filho   				           = $_POST['txtFilho'];
		$Filha   				           = $_POST['txtFilha'];
		$NomePai				           = strtoupper(trim($_POST['txtPai']));
		$NomeMae 				           = strtoupper(trim($_POST['txtMae']));
		$Nacionalidade			           = $_POST['cmbNacionalidade'];
		$NaturalidadeUF			           = $_POST['cmbNaturalidadeUF'];
		$Naturalidade		    	       = $_POST['cmbNaturalidade'];
		$NivelTecnicoCurso 		           = $_POST['txtNivelEscolarCurso'];
		$NivelTecnicoInstituicao           = $_POST['txtNivelEscolarInstituicao'];
		$NivelTecnicoConselho  	           = $_POST['txtNivelEscolarConselho'];
		$NivelTecnicoSemestre  	           = $_POST['txtNivelEscolarSemestre'];


		//atributos da entidade endereco
		$Endereco				          = strtoupper(trim($_POST['txtEndereco']));
		$EnderecoNumero			          = $_POST['txtNumero'];
		$EnderecoComplemento              = $_POST['txtComplemento'];
		$EnderecoReferencia	              = $_POST['txtReferencia'];
		$EnderecoCEP			          = $_POST['txtCEP'];
		$EnderecoUF				          = $_POST['cmbEnderecoUF'];
		$EnderecoMunicipio	              = $_POST['cmbEnderecoMunicipio'];
		$EnderecoBairro			          = strtoupper(trim($_POST['txtEnderecoBairro']));

		//atributos da entidade funcionario
		$TipoFuncionario              	  = $linha['funcionario_tipo_id'];
		$Matricula			              = $_POST['txtMatricula'];
		$CargoTemporario		          = $_POST['cmbCargoTemporario'];
		$CargoPermanente		          = $_POST['cmbCargoPermanente'];
		$Funcao				  	          = $_POST['cmbFuncao'];
		$DataAdmissao			          = $_POST['txtDtAdmissao'];
		$DataDemissao			          = $_POST['txtDtDemissao'];
		$CartTrabalho			          = $_POST['txtCLTNumero'];
		$CartTrabalhoSerie		          = $_POST['txtCLTSerie'];
		$CartTrabalhoUF			          = $_POST['cmbCLTUF'];
		$TituloEleitor			          = $_POST['txtTitulo'];
		$TituloEleitorZona		          = $_POST['txtTituloZona'];
		$TituloEleitorSecao		          = $_POST['txtTituloSecao'];
		$TituloEleitorUF		          = $_POST['cmbTituloUF'];
		$TituloEleitorCidade              = $_POST['cmbTituloCidade'];
		$Habilitacao			          = $_POST['txtHabilitacao'];
		$HabilitacaoCategoria             = $_POST['txtHabilitacaoCategoria'];
		$HabilitacaoValidade	          = $_POST['txtHabilitacaoValidade'];
		$HabilitacaoLenteCorretiva        = $_POST['txtHabilitacaoLenteCorretiva'];
		$Reservista				          = $_POST['txtReservista'];
		$ReservistaUF			          = $_POST['cmbReservistaUF'];
		$ReservistaMinisterio	          = $_POST['cmbMinisterio'];
		$PIS					          = $_POST['txtPIS'];
		$FGTS					          = $_POST['txtFGTS'];
		$EstruturaAtuacao		          = $_POST['cmbEstruturaAtuacao'];
		$Lotacao		          		  = $_POST['cmbLotacao'];
		$UnidadeFuncional				  = $_POST['cmbUnidadeFuncional'];
		$OrgaoOrigem			          = $_POST['cmbOrgaoOrigem'];
		$OrgaoDestino			          = $_POST['cmbOrgaoDestino'];
		$FuncionarioOnus 		          = $_POST['txtOnus'];
		$FuncionarioEmail 		          = strtolower(trim($_POST['txtFuncionarioEmail']));
		$Contrato 				 		  = $_POST['cmbContrato'];
	
		if ($Cargo == "")
		{
			$Cargo = 0;
		}
		if ($CargoPermanente == "")
		{
			$CargoPermanente = 0;
		}
		if ($Funcao == "")
		{
			$Funcao = 0;
		}
		if ($OrgaoOrigem == "")
		{
			$OrgaoOrigem = 0;
		}
		if ($OrgaoDestino == "")
		{
			$OrgaoDestino = 0;
		}
		if ($Lotacao == "")
		{
			$Lotacao = 0;
		}

		//atributos da entidade dados bancarios

		$Banco		                      = $_POST['cmbBanco'];
		$Agencia	                      = $_POST['txtAgencia'];
		$Conta		                      = $_POST['txtConta'];
		$TipoConta                        = $_POST['cmbTipoConta'];
		
		//atributos da entidade dados arquivamento pasta com informações funcional dados.unico_funcionario_arquivo

		$Documento                        = $_POST['txtDocumento'];
		$Pasta 		                      = $_POST['txtPasta'];
		$Armario 	                      = $_POST['txtArmario'];
		$Gaveta		                      = $_POST['txtGaveta'];
		$Posicao                          = $_POST['txtPosicao'];


		 //atributos da entidade telefone

		$TelefoneDDDResidencial 		  = $_POST['txtFoneDDDResidencial'];
		$TelefoneResidencial 	  		  = $_POST['txtFoneResidencial'];
		$TelefoneDDDComercial   		  = $_POST['txtFoneDDDComercial'];
		$TelefoneComercial	 	  		  = $_POST['txtFoneComercial'];
		$TelefoneDDDCelular 	  		  = $_POST['txtFoneDDDCelular'];
		$TelefoneCelular 		    	  = $_POST['txtFoneCelular'];
		$TelefoneDDDFax 		          = $_POST['txtFoneDDDFax'];
		$TelefoneFax 			          = $_POST['txtFonefax'];

        //verifica se já existe cpf

		$sqlConsultaExistente = "SELECT pf.pessoa_id FROM dados_unico.pessoa_fisica pf, dados_unico.funcionario f WHERE (pf.pessoa_id = f.pessoa_id) AND pessoa_fisica_cpf = '" .$CPF. "' OR funcionario_matricula = '" .$Matricula. "'";
		$rsConsultaExistente = pg_query(abreConexao(),$sqlConsultaExistente);

		if (pg_fetch_row($rsConsultaExistente)==0)
		{
			$Date = date("Y-m-d");
			$BeginTrans = "BEGIN WORK";
			pg_query(abreConexao(),$BeginTrans);

			//insere dados na tabela pessoa
			$sqlInsere = "INSERT INTO dados_unico.pessoa (pessoa_nm, pessoa_tipo, pessoa_email, pessoa_dt_criacao) VALUES ('" .$Nome. "', '" .$Tipo. "', '" .$Email. "', '" .$Date. "')";
			pg_query(abreConexao(),$sqlInsere);
			
			//pega o ultimo codigo inserido
			$sqlCodigo = "SELECT last_value FROM dados_unico.seq_pessoa";
			$rsCodigo = pg_query(abreConexao(),$sqlCodigo);
			$ultimoValorSeq = pg_fetch_assoc($rsCodigo);
 
			//insere dados da tabela pessoa_fisica
			$sqlInsere = "INSERT INTO dados_unico.pessoa_fisica ( pessoa_id, 
			                                                      nivel_escolar_id, 
																														pessoa_fisica_sexo, 
																														pessoa_fisica_cpf, 
																														pessoa_fisica_dt_nasc, 
																														pessoa_fisica_rg, 
																														pessoa_fisica_rg_orgao, 
																														pessoa_fisica_rg_uf, 
																														pessoa_fisica_rg_dt, 
																														pessoa_fisica_passaporte, 
																														estado_civil_id, 
																														pessoa_fisica_nm_pai, 
																														pessoa_fisica_nm_mae, 
																														pessoa_fisica_grupo_sanguineo, 
																														pessoa_fisica_filho, 
																														pessoa_fisica_filha, 
																														pessoa_fisica_nacionalidade, 
																														pessoa_fisica_naturalidade, 
																														pessoa_fisica_naturalidade_uf, 
																														pessoa_fisica_clt, 
																														pessoa_fisica_clt_serie, 
																														pessoa_fisica_clt_uf, 
																														pessoa_fisica_titulo, 
																														pessoa_fisica_titulo_zona, 
																														pessoa_fisica_titulo_secao, 
																														pessoa_fisica_titulo_cidade, 
																														pessoa_fisica_titulo_uf, 
																														pessoa_fisica_cnh, 
																														pessoa_fisica_cnh_categoria, 
																														pessoa_fisica_cnh_validade, 
																														pessoa_fisica_cnh_lente_corretiva, 
																														pessoa_fisica_reservista, 
																														pessoa_fisica_reservista_ministerio, 
																														pessoa_fisica_reservista_uf, 
																														pessoa_fisica_pis, 
																														pessoa_fisica_funcionario
																													)VALUES(
																													  " .$ultimoValorSeq['last_value']. ", 
																														'" .$NivelEscolar. "', 
																														'" .$Sexo. "', 
																														'" .$CPF. "', 
																														'" .$DataNascimento. "', 
																														'" .$RG. "', 
																														'" .$RGOrgao."', 
																														'" .$RGOrgaoUF. "', 
																														'" .$RGData. "', 
																														'" .$Passaporte. "', 
																														'" .$EstadoCivil. "', 
																														'" .$NomePai. "', 
																														'" .$NomeMae. "', 
																														'" .$Sangue. "', 
																														'" .$Filho. "', 
																														'" .$Filha. "', 
																														'" .$Nacionalidade. "', 
																														'" .$Naturalidade. "', 
																														'" .$NaturalidadeUF. "', 
																														'" .$CartTrabalho. "', 
																														'" .$CartTrabalhoSerie. "', 
																														'" .$CartTrabalhoUF. "', 
																														'" .$TituloEleitor. "', 
																														'" .$TituloEleitorZona. "', 
																														'" .$TituloEleitorSecao. "', 
																														'" .$TituloEleitorCidade. "', 
																														'" .$TituloEleitorUF. "', 
																														'" .$Habilitacao. "', 
																														'" .$HabilitacaoCategoria. "', 
																														'" .$HabilitacaoValidade. "',  
																														'" .$HabilitacaoLenteCorretiva."', 
																														'" .$Reservista. "', 
																														'" .$ReservistaMinisterio. "', 
																														'" .$ReservistaUF. "', 
																														'" .$PIS. "',
																													  1
																													)";

			pg_query(abreConexao(),$sqlInsere);

			//fim

			//insere dados da tabela endereco
			$EnderecoCEP = str_replace("-","",$EnderecoCEP);
			$sqlInsere = "INSERT INTO dados_unico.endereco ( pessoa_id, 
																											 estado_uf, 
																											 municipio_cd, 
																											 endereco_bairro, 
																											 endereco_ds, 
																											 endereco_num, 
																											 endereco_complemento, 
																											 endereco_referencia, 
																											 endereco_cep
																											) VALUES (
																											 " .$ultimoValorSeq['last_value']. ", 
																											 '" .$EnderecoUF. "', 
																											 '" .$EnderecoMunicipio. "', 
																											 '" .$EnderecoBairro. "', 
																											 '" .$Endereco. "', 
																											 '" .$EnderecoNumero. "', 
																											 '" .$EnderecoComplemento. "', 
																											 '" .$EnderecoReferencia. "', 
																											 '" .$EnderecoCEP. "'
																											)";
			pg_query(abreConexao(),$sqlInsere);
			//fim
			
			//Insere dados bancarios
			if ($Banco != "")
			{
				$sqlInsere = "INSERT INTO dados_unico.dados_bancarios (pessoa_id, banco_id, dados_bancarios_agencia, dados_bancarios_conta, dados_bancarios_conta_tipo, dados_bancarios_dt_criacao) VALUES (" .$ultimoValorSeq['last_value']. ", " .$Banco. ", '" .$Agencia."', '" .$Conta."', '" .$TipoConta."', '" .$DataCriacao."')";
				pg_query(abreConexao(),$sqlInsere);
			}
			//fim

			//insere funcionario
			$sqlInsere = "INSERT INTO dados_unico.funcionario ( pessoa_id, 
																													funcionario_matricula,
																													funcionario_tipo_id, 
																													funcao_id,
																													cargo_permanente,
																													funcionario_dt_admissao,
																													funcionario_dt_demissao,
																													contrato_id,
																													funcionario_conta_fgts,
																													funcionario_ramal,
																													funcionario_email,
																													funcionario_orgao_origem,
																													funcionario_orgao_destino
																												) VALUES (
																													'" .$ultimoValorSeq['last_value']. "',
																													'" .$Matricula. "',
																													'" .$TipoFuncionario. "',
																													'" .$Funcao. "',
																													'" .$CargoPermanente. "',
																													'" .$DataAdmissao. "',
																													'" .$DataDemissao. "',
																													'" .$Contrato. "',
																													'" .$FGTS. "',
																													'" .$FuncionarioRamal. "',
																													'" .$FuncionarioEmail. "',
																													'" .$OrgaoOrigem. "',
																													'" .$OrgaoDestino. "'
																												)";
					pg_query(abreConexao(),$sqlInsere);

					//fim

					//pega codigo do funcionario inserido
					$sqlCodigoFuncionario = "SELECT last_value FROM dados_unico.seq_funcionario";
					$rsCodigoFuncionario = pg_query(abreConexao(),$sqlCodigoFuncionario);
					$ultimoValorSeqFuncionario = pg_fetch_assoc($rsCodigoFuncionario);
					//fim

					//insere dados pasta arquivamento
					$sqlInsere = "INSERT INTO dados_unico.funcionario_arquivo (funcionario_id, documento, pasta, armario, gaveta, posicao) VALUES(".$ultimoValorSeqFuncionario['last_value'].", '" .$Documento. "', '" .$Pasta. "', '" .$Armario. "', '" .$Gaveta. "', '" .$Posicao. "')";
				
					pg_query(abreConexao(),$sqlInsere);
					//fim

					//insere dados da estrutura organizacional
					$sqlInsere = "INSERT INTO dados_unico.funcionario_lotacao (funcionario_id, lotacao_id) VALUES (".$ultimoValorSeqFuncionario['last_value']. ", " .$Lotacao. ")";
					pg_query(abreConexao(),$sqlInsere);
					//fim

					//insere dados da estrutura organizacional
					$sqlInsere = "INSERT INTO dados_unico.est_organizacional_funcionario ( est_organizacional_id,funcionario_id, 																				est_organizacional_funcionario_dt_entrada ) VALUES ('" .$UnidadeFuncional. "','" .$ultimoValorSeqFuncionario['last_value']. "','" .$DataCriacao. "')";
					
					pg_query(abreConexao(),$sqlInsere);
					//fim

					//insere dados sobre nivel tecnico
					if ($NivelTecnicoCurso != "")
					{
					$sqlInsere = "INSERT INTO dados_unico.nivel_tecnico (pessoa_id, nivel_tecnico_curso_ds, nivel_tecnico_instituicao_ds, nivel_tecnico_conselho, nivel_tecnico_semestre) VALUES (" .$ultimoValorSeq['last_value']. ", '" .$NivelTecnicoCurso. "', '" .$NivelTecnicoInstituicao. "', '" .$NivelTecnicoConselho. "', '" .$NivelTecnicoSemestre. "')";
						pg_query(abreConexao(),$sqlInsere);
					}
					

                //insere telefones
                If ($TelefoneResidencial != "")
                {
                    $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneResidencial. "', '" .$TelefoneDDDResidencial. "', 'R')";
                    
					$sqlInsere = strtoupper($sqlInsere);
					
					pg_query(abreConexao(),$sqlInsere);
                }

                If ($TelefoneCelular != "")
                {
                    $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneCelular. "', '" .$TelefoneDDDCelular. "', 'M')";
                    
					$sqlInsere = strtoupper($sqlInsere);
					
					pg_query(abreConexao(),$sqlInsere);
                }

                If ($TelefoneComercial != "")
                {
                    $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneComercial. "', '" .$TelefoneDDDComercial. "', 'C')";
                    
					$sqlInsere = strtoupper($sqlInsere);
					
					pg_query(abreConexao(),$sqlInsere);
                }

                If ($TelefoneFax != "")
                {
                    $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneFax. "', '" .$TelefoneDDDFax. "', 'F')";
                    
					$sqlInsere = strtoupper($sqlInsere);
					
					pg_query(abreConexao(),$sqlInsere);
                }
                //fim
					if ($Err != 0)
					{
						$RollbackTrans = "ROLLBACK";
						pg_query(abreConexao(),$RollbackTrans);

						echo $Err;
					}
					Else
					{
						$CommitTrans="COMMIT";
						pg_query(abreConexao(),$CommitTrans);

					}
					echo "<script>window.location = 'TerceirizadoInicio.php ';</script>";
		}
		else
		{
			$MensagemErroBD = "CPF ou Matr&iacute;cula j&aacute; existente.";
		}
  }


	ElseIf ($AcaoSistema == "consultar")
    {

			$Codigo = $_GET['cod'];

			If($Codigo == "")
            {

				$Codigo = $_POST['checkbox'];

				$sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E, dados_unico.funcionario F, dados_unico.funcionario_lotacao l, dados_unico.est_organizacional_funcionario EF WHERE est_organizacional_funcionario_st = 0 AND (F.funcionario_id = EF.funcionario_id) AND (F.funcionario_id = L.funcionario_id) AND (PF.pessoa_id = F.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND (P.pessoa_id = PF.pessoa_id) AND P.pessoa_id IN (" .$Codigo. ")";
            }
			Else
			{	$sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E, dados_unico.funcionario F, dados_unico.funcionario_lotacao l, dados_unico.est_organizacional_funcionario EF WHERE est_organizacional_funcionario_st = 0 AND (F.funcionario_id = EF.funcionario_id) AND (F.funcionario_id = L.funcionario_id) AND (PF.pessoa_id = F.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND (P.pessoa_id = PF.pessoa_id) AND P.pessoa_id = ".$Codigo;
            }

            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
						//echo $sqlConsulta; exit;
            $linha=pg_fetch_assoc($rsConsulta);
			If($linha)
            {

					//atributos da entidade pessoa
					$Codigo					= $linha['pessoa_id'];
					$StatusNumero			= $linha['pessoa_st'];
					$PessoaDataCriacao		= $linha['pessoa_dt_criacao'];
					$PessoaDataAlteracao	= $linha['pessoa_dt_alteracao'];
					$Nome					= $linha['pessoa_nm'];
					$Email					= $linha['pessoa_email'];
					$NivelEscolar			= $linha['nivel_escolar_id'];
					$EstadoCivil			= $linha['estado_civil_id'];
					$Sexo					= $linha['pessoa_fisica_sexo'];
					$CPF					= $linha['pessoa_fisica_cpf'];
					$DataNascimento			= $linha['pessoa_fisica_dt_nasc'];
					$RG						= $linha['pessoa_fisica_rg'];
					$RGOrgao				= $linha['pessoa_fisica_rg_orgao'];
					$RGOrgaoUF				= $linha['pessoa_fisica_rg_uf'];
					$RGData					= $linha['pessoa_fisica_rg_dt'];
					$Passaporte				= $linha['pessoa_fisica_passaporte'];
					$Sangue					= $linha['pessoa_fisica_grupo_sanguineo'];
					$Filho					= $linha['pessoa_fisica_filho'];
					$Filha					= $linha['pessoa_fisica_filha'];
					$NomePai				= $linha['pessoa_fisica_nm_pai'];
					$NomeMae 				= $linha['pessoa_fisica_nm_mae'];
					$Nacionalidade			= $linha['pessoa_fisica_nacionalidade'];
					$NaturalidadeUF			= $linha['pessoa_fisica_naturalidade_uf'];
					$Naturalidade			= $linha['pessoa_fisica_naturalidade'];

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

					$TituloEleitor			= $linha['pessoa_fisica_titulo'];
					$TituloEleitorZona		= $linha['pessoa_fisica_titulo_zona'];
					$TituloEleitorSecao		= $linha['pessoa_fisica_titulo_secao'];
					$TituloEleitorUF		= $linha['pessoa_fisica_titulo_uf'];
					$TituloEleitorCidade	= $linha['pessoa_fisica_titulo_cidade'];
					$Habilitacao			= $linha['pessoa_fisica_cnh'];
					$HabilitacaoCategoria	= $linha['pessoa_fisica_cnh_categoria'];
					$HabilitacaoValidade	= $linha['pessoa_fisica_cnh_validade'];
					$HabilitacaoLenteCorretiva	= $linha['pessoa_fisica_cnh_lente_corretiva'];
					$Reservista				= $linha['pessoa_fisica_reservista'];
					$ReservistaUF			= $linha['pessoa_fisica_reservista_uf'];
					$ReservistaMinisterio	= $linha['pessoa_fisica_reservista_ministerio'];
					$Endereco				= $linha['endereco_ds'];
					$EnderecoNumero			= $linha['endereco_num'];
					$EnderecoComplemento	= $linha['endereco_complemento'];
					$EnderecoReferencia 	= $linha['endereco_referencia'];
					$EnderecoCEP			= $linha['endereco_cep'];
					$EnderecoUF				= $linha['estado_uf'];
					$EnderecoMunicipio		= $linha['municipio_cd'];
					$EnderecoBairro			= $linha['endereco_bairro'];

					If ($StatusNumero == "0")
                    {  $StatusNome = "Ativo";

                    }
                    Else
                    {  $StatusNome = "Inativo";

                    }
					
					//se pessoa possuir nivel tecnico como nivel escolar, entao consultar dados
					$sqlConsultaNivelTecnico = "SELECT nivel_tecnico_curso_ds, nivel_tecnico_instituicao_ds, nivel_tecnico_conselho, nivel_tecnico_semestre FROM dados_unico.nivel_tecnico WHERE pessoa_id = " .$Codigo;
					$rsConsultaNivelTecnico = pg_query(abreConexao(),$sqlConsultaNivelTecnico);
					
					If($linha2=pg_fetch_assoc($rsConsultaNivelTecnico))
                    {
					
						$NivelTecnicoCurso 	     = $linha2['nivel_tecnico_curso_ds'];
						$NivelTecnicoInstituicao = $linha2['nivel_tecnico_instituicao_ds'];
						$NivelTecnicoConselho    = $linha2['nivel_tecnico_conselho'];
						$NivelTecnicoSemestre  	 = $linha2['nivel_tecnico_semestre'];

					}

					

					//se pessoa possuir nivel tecnico como nivel escolar, entao consultar dados
					$sqlConsultaTelefone = "SELECT * FROM dados_unico.telefone WHERE pessoa_id = " .$Codigo;
                    $rsConsultaTelefone = pg_query(abreConexao(),$sqlConsultaTelefone);
                    while($linha3=pg_fetch_assoc($rsConsultaTelefone))
                    {
							If ($linha3['telefone_tipo'] == "R")
                            {
								$TelefoneDDDResidencial = $linha3['telefone_ddd'];
								$TelefoneResidencial 	= $linha3['telefone_num'];
                            }
							ElseIf ($linha3['telefone_tipo']== "M")
                            {
								$TelefoneDDDCelular 	= $linha3['telefone_ddd'];
								$TelefoneCelular 		= $linha3['telefone_num'];
                            }
							ElseIf ($linha3['telefone_tipo']== "C")
                            {
								$TelefoneDDDComercial 	= $linha3['telefone_ddd'];
								$TelefoneComercial 		= $linha3['telefone_num'];
                            }
							ElseIf ($linha3['telefone_tipo']== "F")
                            {
								$TelefoneDDDFax 		= $linha3['telefone_ddd'];
								$TelefoneFax 			= $linha3['telefone_num'];
                            }
                    }

					//atributos da entidade funcionario

					$Matricula				= $linha['funcionario_matricula'];
//					Cargo					= $linha['cargo_id'];
					$Funcao					= $linha['funcao_id'];
					$UnidadeFuncional		= $linha['est_organizacional_id'];
					$DataAdmissao			= $linha['funcionario_dt_admissao'];
					$DataDemissao			= $linha['funcionario_dt_demissao'];
					$CartTrabalho			= $linha['pessoa_fisica_clt'];
					$CartTrabalhoSerie		= $linha['pessoa_fisica_clt_serie'];
					$CartTrabalhoUF			= $linha['pessoa_fisica_clt_uf'];
					$OrgaoOrigem			= $linha['funcionario_orgao_origem'];
					$OrgaoDestino			= $linha['funcionario_orgao_destino'];
					$PIS					= $linha['pessoa_fisica_pis'];
					$FGTS					= $linha['funcionario_conta_fgts'];
					$Lotacao				= $linha['lotacao_id'];
					$Contrato				= $linha['contrato_id'];
					$FuncionarioRamal 		= $linha['funcionario_ramal'];
					$FuncionarioEmail 		= $linha['funcionario_email'];
					$Salario				= $linha['funcionario_salario'];


					//se pessoa possuir dados bancarios
					//se pessoa possuir dados bancarios
			$sqlConsultaBanco = "SELECT * FROM dados_unico.dados_bancarios db 													 JOIN dados_unico.banco b  ON db.banco_id = b.banco_id WHERE pessoa_id = ".$Codigo." ORDER BY db.dados_bancarios_id DESC LIMIT 1";

                    $rsConsultaBanco = pg_query(abreConexao(),$sqlConsultaBanco);
                    $linha4=pg_fetch_assoc($rsConsultaBanco);

					If ($linha4)
                    {

						$Banco                            = $linha4['banco_id'];
						$BancoNome                        = $linha4['banco_ds'];
						$BancoNumero                      = $linha4['banco_cd'];
						$Agencia                          = $linha4['dados_bancarios_agencia'];
						$Conta                            = $linha4['dados_bancarios_conta'];
						$TipoConta                        = $linha4['dados_bancarios_conta_tipo'];
                    }
            }
    }


	ElseIf ($AcaoSistema == "alterar")
    {

			$Codigo					= $_POST['txtCodigo'];
			$EstruturaOriginal		= $_POST['txtEstruturaOriginal'];
			$Nome					= strtoupper(trim($_POST['txtNome']));
			$Email					= strtolower(trim($_POST['txtEmail']));
			$DataAlteracao 			= date("Y-m-d");
			$NivelEscolar			= $_POST['cmbNivelEscolar'];
			$EstadoCivil			= $_POST['cmbEstadoCivil'];
			$Sexo					= $_POST['rdSexo'];
			$CPF					= $_POST['txtCPF'];
			$DataNascimento			= $_POST['txtDtNasc'];
			$RG						= $_POST['txtRG'];
			$RGOrgao				= strtoupper($_POST['txtRGOrgao']);
			$RGOrgaoUF				= $_POST['cmbRGUF'];
			$RGData					= $_POST['txtRGDtExpedicao'];
			$Passaporte				= $_POST['txtPassaporte'];
			$Sangue					= $_POST['cmbGrupoSanguineo'];
			$Filho					= $_POST['txtFilho'];
			$Filha					= $_POST['txtFilha'];
			$NomePai				= strtoupper(trim($_POST['txtPai']));
			$NomeMae 				= strtoupper(trim($_POST['txtMae']));
			$Nacionalidade			= $_POST['cmbNacionalidade'];
			$NaturalidadeUF			= $_POST['cmbNaturalidadeUF'];
			$Naturalidade			= $_POST['cmbNaturalidade'];
			$NivelTecnicoCurso 		= $_POST['txtNivelEscolarCurso'];
			$NivelTecnicoInstituicao = $_POST['txtNivelEscolarInstituicao'];
			$NivelTecnicoConselho  	= $_POST['txtNivelEscolarConselho'];
			$NivelTecnicoSemestre  	= $_POST['txtNivelEscolarSemestre'];
			$Endereco				= strtoupper(trim($_POST['txtEndereco']));
			$EnderecoNumero			= $_POST['txtNumero'];
			$EnderecoComplemento	= $_POST['txtComplemento'];
			$EnderecoReferencia 	= $_POST['txtReferencia'];
			$EnderecoCEP			= $_POST['txtCEP'];
			$EnderecoUF				= $_POST['cmbEnderecoUF'];
			$EnderecoMunicipio		= $_POST['cmbEnderecoMunicipio'];
			$EnderecoBairro			= strtoupper(trim($_POST['txtEnderecoBairro']));
			$TipoFuncionario		= $_POST['cmbFuncionarioTipo'];
			$Matricula				= $_POST['txtMatricula'];
			$Cargo					= $_POST['cmbCargo'];
			$Funcao					= $_POST['cmbFuncao'];
			$DataAdmissao			= $_POST['txtDtAdmissao'];
			$DataDemissao			= $_POST['txtDtDemissao'];
			$CartTrabalho			= $_POST['txtCLTNumero'];
			$CartTrabalhoSerie		= $_POST['txtCLTSerie'];
			$CartTrabalhoUF			= $_POST['cmbCLTUF'];
			$TituloEleitor			= $_POST['txtTitulo'];
			$TituloEleitorZona		= $_POST['txtTituloZona'];
			$TituloEleitorSecao		= $_POST['txtTituloSecao'];
			$TituloEleitorUF		= $_POST['cmbTituloUF'];
			$TituloEleitorCidade	= $_POST['cmbTituloCidade'];
			$Habilitacao			= $_POST['txtHabilitacao'];
			$HabilitacaoCategoria	= $_POST['txtHabilitacaoCategoria'];
			$HabilitacaoValidade	= $_POST['txtHabilitacaoValidade'];
			$HabilitacaoLenteCorretiva	= $_POST['txtHabilitacaoLenteCorretiva'];
			$Reservista				= $_POST['txtReservista'];
			$ReservistaUF			= $_POST['cmbReservistaUF'];
			$ReservistaMinisterio	= $_POST['cmbMinisterio'];
			$PIS					= $_POST['txtPIS'];
			$FGTS					= $_POST['txtFGTS'];
			$UnidadeFuncional		= $_POST['cmbUnidadeFuncional'];
			$OrgaoOrigem			= $_POST['cmbOrgao'];
			$Lotacao				= $_POST['cmbLotacao'];
			$Contrato				= $_POST['cmbContrato'];
			$FuncionarioRamal 		= $_POST['txtRamal'];
			$FuncionarioEmail 		= strtolower(trim($_POST['txtFuncionarioEmail']));
			$OrgaoOrigem			= $_POST['cmbOrgaoOrigem'];
			$OrgaoDestino			= $_POST['cmbOrgaoDestino'];
			If ($Cargo == "")
            {  $Cargo = 0;

            }

			IF ($OrgaoOrigem == "")
            {  $OrgaoOrigem = 0;

            }

			$Banco					= $_POST['cmbBanco'];
			$Agencia				= $_POST['txtAgencia'];
			$Conta					= $_POST['txtConta'];
			$TipoConta				= $_POST['cmbTipoConta'];
			$TelefoneDDDResidencial = $_POST['txtFoneDDDResidencial'];
			$TelefoneResidencial 	= $_POST['txtFoneResidencial'];
			$TelefoneDDDComercial 	= $_POST['txtFoneDDDComercial'];
			$TelefoneComercial	 	= $_POST['txtFoneComercial'];
			$TelefoneDDDCelular 	= $_POST['txtFoneDDDCelular'];
			$TelefoneCelular 		= $_POST['txtFoneCelular'];
			$TelefoneDDDFax 		= $_POST['txtFoneDDDFax'];
			$TelefoneFax 			= $_POST['txtFonefax'];

			$sqlConsultaExistente = "SELECT PF.pessoa_id FROM dados_unico.pessoa_fisica PF, dados_unico.funcionario F WHERE (PF.pessoa_id = F.pessoa_id) AND (pessoa_fisica_cpf = '" .$CPF. "' OR funcionario_matricula = '" .$Matricula. "') AND PF.pessoa_id <> " .$Codigo;
            $rsConsultaExistente = pg_query(abreConexao(),$sqlConsultaExistente);


           If(pg_fetch_row($rsConsultaExistente)==0)
           {

					$BeginTrans= "BEGIN WORK";
                    pg_query(abreConexao(),$BeginTrans);

					$sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_nm = '".$Nome. "', pessoa_email = '".$Email. "', pessoa_dt_alteracao = '".$DataAlteracao. "' WHERE pessoa_id = ".$Codigo;

					pg_query(abreConexao(),$sqlAltera);


					$sqlAltera = "UPDATE dados_unico.pessoa_fisica SET pessoa_fisica_sexo = '".$Sexo. "', pessoa_fisica_cpf = '".$CPF. "', pessoa_fisica_dt_nasc = '".$DataNascimento. "', pessoa_fisica_rg = '".$RG. "', pessoa_fisica_rg_orgao = '".$RGOrgao. "', pessoa_fisica_rg_uf = '".$RGOrgaoUF. "', pessoa_fisica_rg_dt = '".$RGData. "', pessoa_fisica_passaporte = '".$Passaporte. "', pessoa_fisica_nm_pai = '".$NomePai. "', pessoa_fisica_nm_mae = '".$NomeMae. "', pessoa_fisica_grupo_sanguineo = '".$Sangue. "', pessoa_fisica_filho = '".$Filho. "',pessoa_fisica_filha = '".$Filha. "',pessoa_fisica_nacionalidade = '".$Nacionalidade. "', pessoa_fisica_naturalidade = '".$Naturalidade. "', pessoa_fisica_naturalidade_uf = '".$NaturalidadeUF. "', pessoa_fisica_clt = '".$CartTrabalho. "', pessoa_fisica_clt_serie = '".$CartTrabalhoSerie. "', pessoa_fisica_clt_uf = '".$CartTrabalhoUF. "', pessoa_fisica_titulo = '".$TituloEleitor. "', pessoa_fisica_titulo_zona = '".$TituloEleitorZona. "', pessoa_fisica_titulo_secao = '".$TituloEleitorSecao. "', pessoa_fisica_titulo_cidade = '".$TituloEleitorCidade. "', pessoa_fisica_titulo_uf = '".$TituloEleitorUF. "', pessoa_fisica_cnh = '".$Habilitacao. "', pessoa_fisica_cnh_categoria = '".$HabilitacaoCategoria. "', pessoa_fisica_cnh_validade = '".$HabilitacaoValidade. "', pessoa_fisica_cnh_lente_corretiva = '".$HabilitacaoLenteCorretiva. "', pessoa_fisica_reservista = '".$Reservista. "', pessoa_fisica_reservista_ministerio = '".$ReservistaMinisterio. "', pessoa_fisica_reservista_uf = '".$ReservistaUF. "', pessoa_fisica_pis = '".$PIS. "', estado_civil_id = ".$EstadoCivil. ",	nivel_escolar_id = ".$NivelEscolar. " WHERE pessoa_id = ".$Codigo;

					pg_query(abreConexao(),$sqlAltera);

					// Altera o nivel técnico ..
					//*******************************************************************	
					$sqlTeste="SELECT * FROM dados_unico.nivel_tecnico where pessoa_id=".$Codigo;
					$rsTeste=pg_query(abreConexao(),$sqlTeste);
					if(pg_fetch_row($rsTeste)==0)
						{
							$sqlInsere = "INSERT INTO dados_unico.nivel_tecnico (pessoa_id, nivel_tecnico_curso_ds, nivel_tecnico_instituicao_ds, nivel_tecnico_conselho,  nivel_tecnico_semestre) VALUES (" .$Codigo. ", '" .$NivelTecnicoCurso. "', '" .$NivelTecnicoInstituicao. "', '" .$NivelTecnicoConselho."', '" .$NivelTecnicoSemestre."')";
							pg_query(abreConexao(),$sqlInsere);
						}
					else
						{
							$sqlAltera = "UPDATE dados_unico.nivel_tecnico SET nivel_tecnico_curso_ds = '" .$NivelTecnicoCurso."', nivel_tecnico_instituicao_ds = '" .$NivelTecnicoInstituicao."', nivel_tecnico_conselho = '" .$NivelTecnicoConselho."', nivel_tecnico_semestre = '" .$NivelTecnicoSemestre."' WHERE pessoa_id = " .$Codigo;
						pg_query(abreConexao(),$sqlAltera);
						}
					//*******************************************************************					
					// Fim 		
					
					//  Altera o endereço ..
					//*******************************************************************
					$sqlAltera = "UPDATE dados_unico.endereco SET estado_uf = '" .$EnderecoUF."', municipio_cd = '" .$EnderecoMunicipio."', endereco_bairro = '" .$EnderecoBairro."', endereco_ds = '" .$Endereco."', endereco_num = '" .$EnderecoNumero."', endereco_cep = '" .$EnderecoCEP."', endereco_complemento = '" .$EnderecoComplemento."' , endereco_referencia = '" .$EnderecoReferencia."'WHERE pessoa_id = " .$Codigo;

 					pg_query(abreConexao(),$sqlAltera);
					//*******************************************************************
					//Fim 
					
					// Dados do Telefone residencial .. 
					// ********************************************************************

					$sqlTeste="SELECT * FROM dados_unico.telefone where telefone_tipo = 'R' and  telefone_num='" .$TelefoneResidencial."'AND pessoa_id=".$Codigo;
					$rsTeste=pg_query(abreConexao(),$sqlTeste);
					If(pg_fetch_row($rsTeste)==0)
					{   $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneResidencial. "', '" .$TelefoneDDDResidencial. "', 'R')";
						
						$sqlInsere = strtoupper($sqlInsere);
						
						pg_query(abreConexao(),$sqlInsere);
					}
					else
					{  $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneResidencial."',telefone_ddd = '" .$TelefoneDDDResidencial."'WHERE telefone_tipo = 'R' AND pessoa_id = " .$Codigo;
					   
					   $sqlInsere = strtoupper($sqlInsere);
					   
					   pg_query(abreConexao(),$sqlAltera);
					}
				   	
					// Dados do Telefone Celular .. 
					// ********************************************************************
					$sqlTeste="SELECT * FROM dados_unico.telefone where telefone_tipo = 'M' and telefone_num='" .$TelefoneCelular."'AND pessoa_id=".$Codigo;
					$rsTeste=pg_query(abreConexao(),$sqlTeste);
					
					If(pg_fetch_row($rsTeste)==0)
					{  $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneCelular. "', '" .$TelefoneDDDCelular. "', 'M')";
						$sqlInsere = strtoupper($sqlInsere);
						
						pg_query(abreConexao(),$sqlInsere);
					}
					else
					{
					 $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneCelular."',telefone_ddd = '" .$TelefoneDDDCelular."'WHERE telefone_tipo = 'M' AND pessoa_id = " .$Codigo;
						pg_query(abreConexao(),$sqlAltera);
					}
					// Fim 
					// ********************************************************************
				  

					// Dados do Telefone Comercial .. 
					// ********************************************************************
					$sqlTeste="SELECT * FROM dados_unico.telefone where telefone_tipo = 'C' and  telefone_num='" .$TelefoneComercial."'AND pessoa_id=".$Codigo;
					$rsTeste=pg_query(abreConexao(),$sqlTeste);
					If(pg_fetch_row($rsTeste)==0)
					{  $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneComercial. "', '" .$TelefoneDDDComercial. "', 'C')";
						
						$sqlInsere = strtoupper($sqlInsere);
						
						pg_query(abreConexao(),$sqlInsere);
					}
					else
					{
					   $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneComercial."',telefone_ddd = '" .$TelefoneDDDComercial."'WHERE telefone_tipo = 'C' AND pessoa_id = " .$Codigo;
					   pg_query(abreConexao(),$sqlAltera);
		
					}
					// Fim 
					// ********************************************************************
		
					// Dados do Telefone Fax .. 
					// ********************************************************************
					$sqlTeste="SELECT * FROM dados_unico.telefone where telefone_tipo = 'F' and telefone_num='" .$TelefoneFax."'AND pessoa_id=".$Codigo;
					$rsTeste=pg_query(abreConexao(),$sqlTeste);
					If(pg_fetch_row($rsTeste)==0)
					{  $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneFax. "', '" .$TelefoneDDDFax. "', 'F')";
						$sqlInsere = strtoupper($sqlInsere);
						
						pg_query(abreConexao(),$sqlInsere);
					}
					else
					{
					 $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneFax."',telefone_ddd = '" .$TelefoneDDDFax."'WHERE telefone_tipo = 'F' AND pessoa_id = " .$Codigo;
					pg_query(abreConexao(),$sqlAltera);
		
					}
					// Fim 
					// ********************************************************************
					
					// Altera os dados do funcionario 		
					//*******************************************************************
					$sqlAltera = "UPDATE dados_unico.funcionario SET funcao_id = ".$Funcao. ", funcionario_matricula = '".$Matricula. "', funcionario_ramal = '".$FuncionarioRamal. "', funcionario_email = '".$FuncionarioEmail. "', funcionario_dt_admissao = '".$DataAdmissao. "', funcionario_dt_demissao = '".$DataDemissao. "', funcionario_orgao_origem = ".$OrgaoOrigem. ",funcionario_orgao_destino =".$OrgaoDestino.", funcionario_conta_fgts = '".$FGTS. "', funcionario_salario = '".$Salario. "', contrato_id = ".$Contrato. " WHERE pessoa_id = ".$Codigo;
		
 					pg_query(abreConexao(),$sqlAltera);

					If ($EstruturaOriginal != $UnidadeFuncional)
                    {

							$sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = ".$Codigo;

                            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                            $linha=pg_fetch_assoc($rsConsulta);

							$sqlAltera = "UPDATE dados_unico.est_organizacional_funcionario SET est_organizacional_funcionario_dt_saida = '".$DataAlteracao. "', est_organizacional_funcionario_st = 1 WHERE funcionario_id = ".$linha['funcionario_id'];

 		 					 pg_query(abreConexao(),$sqlAltera);


							$sqlInsere = "INSERT INTO dados_unico.est_organizacional_funcionario (est_organizacional_id, funcionario_id, est_organizacional_funcionario_dt_entrada) VALUES (".$UnidadeFuncional. " ," .$linha['funcionario_id']. ", '" .$DataAlteracao. "')";

                            pg_query(abreConexao(),$sqlInsere);


                    }
					$sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " .$Codigo;

                    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

                    $linha=pg_fetch_assoc($rsConsulta);
					$sqlAltera = "UPDATE dados_unico.funcionario_lotacao SET lotacao_id =  " .$Lotacao." WHERE funcionario_id = ".$linha['funcionario_id'];
					pg_query(abreConexao(),$sqlAltera);
					
					If ($Banco != "")
                    {

						$sqlConsulta = "SELECT dados_bancarios_id FROM dados_unico.dados_bancarios WHERE pessoa_id = " .$Codigo;
                        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                        $linha=pg_fetch_assoc($rsConsulta);
						If(!$linha)
                        {
							$sqlInsere = "INSERT INTO dados_unico.dados_bancarios (pessoa_id, banco_id, dados_bancarios_agencia, dados_bancarios_conta, dados_bancarios_conta_tipo, dados_bancarios_dt_criacao) VALUES (" .$Codigo. ", " .$Banco. ", '" .$Agencia. "', '" .$Conta. "', '" .$TipoConta. "', '" .$DataAlteracao. "')";
							pg_query(abreConexao(),$sqlInsere);
                        }
						Else
						{	$sqlAltera = "UPDATE dados_unico.dados_bancarios SET banco_id = ".$Banco. ", dados_bancarios_agencia = '" .$Agencia. "', dados_bancarios_conta = '" .$Conta. "', dados_bancarios_conta_tipo = '" .$TipoConta. "', dados_bancarios_dt_alteracao = '" .$DataAlteracao. "' WHERE pessoa_id = " .$Codigo;
							//echo $sqlAltera;
							//exit;
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
                    echo "<script>window.location = 'TerceirizadoInicio.php ';</script>";
            }
			Else
            {
					$MensagemErroBD = "CPF ou Matr&iacute;cula j&aacute; existente.";

            }

    }


		ElseIf ($AcaoSistema == "alterarStatus")
        {

					$DataAlteracao 	= date("Y-m-d");
					$Codigo 		= $_GET['cod'];
					$StatusCod		= $_GET['status'];

					If ($StatusCod == 0)
                    {  $StatusCod = 1;

                    }
                    Else
                    {  $StatusCod = 0;

                    }

					$sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_st = " .$StatusCod. ", pessoa_dt_alteracao = '".$DataAlteracao. "' WHERE pessoa_id = " .$Codigo;
					pg_query(abreConexao(),$sqlAltera);

					 echo "<script>window.location = 'TerceirizadoInicio.php ';</script>";
        }
		ElseIf ($AcaoSistema == "excluir")
        {


    			$ExcluirCheckbox = $_GET['excluirMultiplo'];

				If ($ExcluirCheckbox == 1)
                {

					$Codigo	= $_POST['txtCodigo'];
					$sqlDeleta = "UPDATE dados_unico.pessoa SET pessoa_st = 2 WHERE pessoa_id IN (" .$Codigo. ")";
                }

				Else
                {

					$Codigo	= $_GET['cod'];
					$sqlDeleta = "UPDATE dados_unico.pessoa SET pessoa_st = 2 WHERE pessoa_id = " .$Codigo;
                }



				pg_query(abreConexao(),$sqlDeleta);

			    echo "<script>window.location = 'TerceirizadoInicio.php ';</script>";
        }



?>
