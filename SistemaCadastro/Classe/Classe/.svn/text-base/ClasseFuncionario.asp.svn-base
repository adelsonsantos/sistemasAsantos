<% 	
	'controla a visibilidade do botao consultar
	Session("BotaoConsultar") = 1	
	
	'zera a variavel de msg de banco
	MensagemErroBD = ""
	
	'define o link padrao para as paginas
	PaginaLocal = "Funcionario"
	
	'carrega grade de informacoes na pagina inicial
	If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
			
			numFiltro = Request.QueryString("filtro")
			
			numFiltroFuncionario = Request.QueryString("validado")	
			If numFiltroFuncionario = "" Then
				numFiltroFuncionario = Request.QueryString("filtro")	
			End If

'			If numFiltro <> "" Then
'				strStringSQL = "pessoa_st = " & numFiltro				
'			Else
'				strStringSQL = "pessoa_st <> 2"			
'			End If

			If numFiltroFuncionario <> "" Then
				strStringSQL = "funcionario_validacao_rh = " & numFiltroFuncionario
			Else
				strStringSQL = "funcionario_validacao_rh = 0"		
			End If			
			' fim do filtro 		
	
			If RetornoFiltro <> "" Then
				sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, funcionario_matricula, est_organizacional_sigla, funcionario_validacao_propria FROM  dados_unico.pessoa p,  dados_unico.funcionario f,  dados_unico.est_organizacional eo, dados_unico.est_organizacional_funcionario ef WHERE (eo.est_organizacional_id = ef.est_organizacional_id) AND est_organizacional_funcionario_st = 0 AND (ef.funcionario_id = f.funcionario_id) AND (p.pessoa_id = f.pessoa_id) AND pessoa_nm ILIKE '%" & RetornoFiltro & "%' AND " & strStringSQL & " AND funcionario_tipo_id <> 3 ORDER BY UPPER(pessoa_nm)"	
			Else
				sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, funcionario_matricula, est_organizacional_sigla, funcionario_validacao_propria FROM  dados_unico.pessoa p,  dados_unico.funcionario f,  dados_unico.est_organizacional eo, dados_unico.est_organizacional_funcionario ef WHERE (eo.est_organizacional_id = ef.est_organizacional_id) AND est_organizacional_funcionario_st = 0 AND (ef.funcionario_id = f.funcionario_id) AND (p.pessoa_id = f.pessoa_id) AND " & strStringSQL & " AND funcionario_tipo_id <> 3 ORDER BY UPPER(pessoa_nm)"	
			End If

			set rsConsulta = objConexao.execute(sqlConsulta) 	
				
		
	ElseIf AcaoSistema = "incluir" Then	

			'atributos da entidade pessoa
			Tipo					= "F" 
			Nome					= UCase(replace(Trim(Request("txtNome")),"'","''"))
			Email					= LCase(replace(Trim(Request("txtEmail")),"'","''"))
			NivelEscolar			= Request("cmbNivelEscolar")
			EstadoCivil				= Request("cmbEstadoCivil")
			Sexo					= Request("rdSexo")	
			CPF						= Request("txtCPF")				
			DataNascimento			= Request("txtDtNasc")	
			RG						= Request("txtRG")	
			RGOrgao					= UCase(Request("txtRGOrgao"))
			RGOrgaoUF				= Request("cmbRGUF")									
			RGData					= Request("txtRGDtExpedicao")
			Passaporte				= Request("txtPassaporte")		
			Sangue					= Request("cmbGrupoSanguineo")
			NomePai					= UCase(replace(Trim(Request("txtPai")),"'","''"))
			NomeMae 				= UCase(replace(Trim(Request("txtMae")),"'","''"))
			Nacionalidade			= Request("cmbNacionalidade")
			NaturalidadeUF			= Request("cmbNaturalidadeUF")
			Naturalidade			= Request("cmbNaturalidade")
			NivelTecnico 			= Request("txtNivelEscolarDescricao")
			NivelTecnicoClasse 		= Request("txtNivelEscolarClasse")
			NivelTecnicoRegistro 	= Request("txtNivelEscolarRegistro")		
			'atributos da entidade endereco
			Endereco				= UCase(replace(Trim(Request("txtEndereco")),"'","''"))			
			EnderecoNumero			= Request("txtNumero")
			EnderecoComplemento		= Request("txtComplemento")	
			EnderecoCEP				= Request("txtCEP")				
			EnderecoUF				= Request("cmbEnderecoUF")													
			EnderecoMunicipio		= Request("cmbEnderecoMunicipio")													
			EnderecoBairro			= UCase(replace(Trim(Request("txtEnderecoBairro")),"'","''"))		
			'atributos da entidade funcionario
			TipoFuncionario			= Request("cmbFuncionarioTipo")
			Matricula				= Request("txtMatricula")
			CargoTemporario			= Request("cmbCargoTemporario")
			CargoPermanente			= Request("cmbCargoPermanente")			
			Funcao					= Request("cmbFuncao")	
			DataAdmissao			= Request("txtDtAdmissao")
			DataDemissao			= Request("txtDtDemissao")					
			CartTrabalho			= Request("txtCLTNumero")
			CartTrabalhoSerie		= Request("txtCLTSerie")				
			CartTrabalhoUF			= Request("cmbCLTUF")		
			TituloEleitor			= Request("txtTitulo")
			TituloEleitorZona		= Request("txtTituloZona")				
			TituloEleitorSecao		= Request("txtTituloSecao")		
			TituloEleitorUF			= Request("cmbTituloUF")
			TituloEleitorCidade		= Request("cmbTituloCidade")				
			Habilitacao				= Request("txtHabilitacao")		
			HabilitacaoCategoria	= Request("txtHabilitacaoCategoria")
			HabilitacaoValidade		= Request("txtHabilitacaoValidade")		
			Reservista				= Request("txtReservista")
			ReservistaUF			= Request("cmbReservistaUF")	
			ReservistaMinisterio	= Request("cmbMinisterio")	
			PIS						= Request("txtPIS")
			FGTS					= Request("txtFGTS")
			EstruturaAtuacao		= Request("cmbEstruturaAtuacao")
			EstruturaLotacao		= Request("cmbEstruturaLotacao")			
			OrgaoOrigem				= Request("cmbOrgaoOrigem")
			OrgaoDestino			= Request("cmbOrgaoDestino")			
			FuncionarioRamal 		= Request("txtRamal")
			FuncionarioEmail 		= LCase(replace(Trim(Request("txtFuncionarioEmail")),"'","''"))	
			
			'atributos da entidade dados bancarios
			Banco					= Request("cmbBanco")
			Agencia					= Request("txtAgencia")
			Conta					= Request("txtConta")
			TipoConta				= Request("cmbTipoConta")		
			'atributos da entidade telefone
			TelefoneDDDResidencial 	= Request("txtFoneDDDResidencial")
			TelefoneResidencial 	= Request("txtFoneResidencial")		
			TelefoneDDDComercial 	= Request("txtFoneDDDComercial")
			TelefoneComercial	 	= Request("txtFoneComercial")				
			TelefoneDDDCelular 		= Request("txtFoneDDDCelular")
			TelefoneCelular 		= Request("txtFoneCelular")		
			TelefoneDDDFax 			= Request("txtFoneDDDFax")
			TelefoneFax 			= Request("txtFoneFax")	
			
			If Funcao 			= "" Then Funcao 		  = 0 End If	
			If CargoTemporario  = "" Then CargoTemporario = 0 End If
			If CargoPermanente  = "" Then CargoPermanente = 0 End If	
			If OrgaoOrigem 		= "" Then OrgaoOrigem 	  = 0 End If						
			If OrgaoDestino 	= "" Then OrgaoDestino 	  = 0 End If		
			If EstruturaAtuacao = "" Then EstruturaAtuacao= 0 End If
			If EstruturaLotacao = "" Then EstruturaLotacao= 0 End If									
		
			'verifica se já existe cpf
			sqlConsultaExistente = "SELECT pf.pessoa_id FROM dados_unico.pessoa_fisica pf, dados_unico.funcionario f WHERE (pf.pessoa_id = f.pessoa_id) AND pessoa_fisica_cpf = '" & CPF & "' OR funcionario_matricula = '" & Matricula & "'"
			Set rsConsultaExistente = objConexao.execute(sqlConsultaExistente)	
	
			If rsConsultaExistente.eof Then
			
					objConexao.BeginTrans
					
					'insere dados na tabela pessoa
					sqlInsere = "INSERT INTO dados_unico.pessoa (pessoa_nm, pessoa_tipo, pessoa_email, pessoa_dt_criacao) VALUES ('" & Nome & "', '" & Tipo & "', '" & Email & "', '" & Date & "')"
					objConexao.execute(sqlInsere)

					'pega o ultimo codigo inserido
					sqlCodigo = "SELECT @@identity AS UltimoInserido FROM dados_unico.pessoa" 
					Set rsCodigo = objConexao.execute(sqlCodigo)	
					
					'insere dados da tabela pessoa_fisica
					sqlInsere = "INSERT INTO dados_unico.pessoa_fisica (pessoa_id, nivel_escolar_id, pessoa_fisica_sexo, pessoa_fisica_cpf, pessoa_fisica_dt_nasc, pessoa_fisica_rg, pessoa_fisica_rg_orgao, pessoa_fisica_rg_uf, pessoa_fisica_rg_dt, pessoa_fisica_passaporte, estado_civil_id, pessoa_fisica_nm_pai, pessoa_fisica_nm_mae, pessoa_fisica_grupo_sanguineo, pessoa_fisica_nacionalidade, pessoa_fisica_naturalidade, pessoa_fisica_naturalidade_uf, pessoa_fisica_clt, pessoa_fisica_clt_serie, pessoa_fisica_clt_uf, pessoa_fisica_titulo, pessoa_fisica_titulo_zona, pessoa_fisica_titulo_secao, pessoa_fisica_titulo_cidade, pessoa_fisica_titulo_uf, pessoa_fisica_cnh, pessoa_fisica_cnh_categoria, pessoa_fisica_cnh_validade, pessoa_fisica_reservista, pessoa_fisica_reservista_ministerio, pessoa_fisica_reservista_uf, pessoa_fisica_pis, pessoa_fisica_funcionario) " &_
								"VALUES (" & rsCodigo("UltimoInserido") & ", '" & NivelEscolar & "', '" & Sexo & "', '" & CPF & "', '" & DataNascimento & "', '" & RG & "', '" & RGOrgao & "', '" & RGOrgaoUF & "', '" & RGData & "', '" & Passaporte & "', '" & EstadoCivil & "', '" & NomePai & "', '" & NomeMae & "', '" & Sangue & "', '" & Nacionalidade & "', '" & Naturalidade & "', '" & NaturalidadeUF & "', '" & CartTrabalho & "', '" & CartTrabalhoSerie & "', '" & CartTrabalhoUF & "', '" & TituloEleitor & "', '" & TituloEleitorZona & "', '" & TituloEleitorSecao & "', '" & TituloEleitorCidade & "', '" & TituloEleitorUF & "', '" & Habilitacao & "', '" & HabilitacaoCategoria & "', '" & HabilitacaoValidade & "', '" & Reservista & "', '" & ReservistaMinisterio & "', '" & ReservistaUF & "', '" & PIS & "',1)"
					objConexao.execute(sqlInsere)

					'insere dados da tabela endereco	
					sqlInsere = "INSERT INTO dados_unico.endereco (pessoa_id, estado_uf, municipio_cd, endereco_bairro, endereco_ds, endereco_num, endereco_complemento, endereco_cep) " &_
								"VALUES (" & rsCodigo("UltimoInserido") & ", '" & EnderecoUF & "', '" & EnderecoMunicipio & "', '" & EnderecoBairro & "', '" & Endereco & "', '" & EnderecoNumero & "', '" & EnderecoComplemento & "', '" & EnderecoCEP & "')"
					objConexao.execute(sqlInsere)	
					
					'insere dados bancarios	
					If Banco <> "" Then
						sqlInsere = "INSERT INTO dados_unico.dados_bancarios (pessoa_id, banco_id, dados_bancarios_agencia, dados_bancarios_conta, dados_bancarios_conta_tipo, dados_bancarios_dt_criacao) " &_
									"VALUES (" & rsCodigo("UltimoInserido") & ", " & Banco & ", '" & Agencia & "', '" & Conta & "', '" & TipoConta & "', '" & Date & "')"
						objConexao.execute(sqlInsere)	
					End If
	
					'insere funcionario
					sqlInsere = "INSERT INTO dados_unico.funcionario (pessoa_id, funcionario_matricula, funcionario_tipo_id, funcao_id, cargo_permanente, cargo_temporario, funcionario_dt_admissao, funcionario_dt_demissao, funcionario_orgao_origem, funcionario_orgao_destino, funcionario_conta_fgts, funcionario_ramal, funcionario_email,est_organizacional_lotacao_id)" &_
								"VALUES (" & rsCodigo("UltimoInserido") & ",'" & Matricula & "'," & TipoFuncionario & "," & Funcao & "," & CargoPermanente & "," & CargoTemporario & ",'" & DataAdmissao & "', '" & DataDemissao & "'," & OrgaoOrigem & "," & OrgaoDestino & ", '" & FGTS & "', '" & FuncionarioRamal & "', '" & FuncionarioEmail & "'," & EstruturaLotacao & ")"
					objConexao.execute(sqlInsere)

					'pega codigo do funcionario inserido
					sqlCodigoFuncionario = "SELECT @@identity AS UltimoInserido FROM dados_unico.funcionario" 
					Set rsCodigoFuncionario = objConexao.execute(sqlCodigoFuncionario)	
					
					'insere dados da estrutura organizacional
					sqlInsere = "INSERT INTO dados_unico.est_organizacional_funcionario (est_organizacional_id, funcionario_id, est_organizacional_funcionario_dt_entrada) " &_
								"VALUES (" & EstruturaAtuacao & " ," & rsCodigoFuncionario("UltimoInserido") & ", '" & Date & "')"
					objConexao.execute(sqlInsere)
					
					'insere dados sobre nivel tecnico
					If NivelTecnico <> "" Then
						sqlInsere = "INSERT INTO dados_unico.nivel_tecnico (pessoa_id, nivel_tecnico_ds, nivel_tecnico_classe, nivel_tecnico_registro) " &_
									"VALUES (" & rsCodigo("UltimoInserido") & ", '" & NivelTecnico & "', '" & NivelTecnicoClasse & "', '" & NivelTecnicoRegistro & "')"
						objConexao.execute(sqlInsere)
					End If	
					
					'insere telefones
					If TelefoneResidencial <> "" Then				
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & rsCodigo("UltimoInserido") & ",'" & TelefoneResidencial & "', '" & TelefoneDDDResidencial & "', 'R')"
						objConexao.execute(sqlInsere)
					End If
					
					If TelefoneCelular <> "" Then				
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & rsCodigo("UltimoInserido") & ",'" & TelefoneCelular & "', '" & TelefoneDDDCelular & "', 'M')"
						objConexao.execute(sqlInsere)				
					End If
					
					If TelefoneComercial <> "" Then				
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & rsCodigo("UltimoInserido") & ",'" & TelefoneComercial & "', '" & TelefoneDDDComercial & "', 'C')"
						objConexao.execute(sqlInsere)				
					End If	
					
					If TelefoneFAX <> "" Then				
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & rsCodigo("UltimoInserido") & ",'" & TelefoneFAX & "', '" & TelefoneDDDFax& "', 'F')"
						objConexao.execute(sqlInsere)				
					End If	
					
					If Session("UsuarioEst") = "DG_DA_CRH" Then
						sqlAltera = "UPDATE dados_unico.funcionario SET " &_
											"funcionario_validacao_propria = 1, " &_	
											"funcionario_validacao_rh = 1 " &_																																																
											"WHERE pessoa_id = " & rsCodigo("UltimoInserido")
											
						objConexao.execute(sqlAltera)
					End If						
					
					If Err <> 0 Then
						objConexao.RollbackTrans
						Response.Write Err.Description
					Else
						objConexao.CommitTrans
					End If								
						
					Response.Redirect "FuncionarioInicio.asp"

			Else
	
					MensagemErroBD = "CPF ou Matrícula já existente."
	
			End If				

	ElseIf AcaoSistema = "consultar" Then	
	
			Codigo = Request.QueryString("cod")	
			
			Session("CargoTemporario") = ""
			Session("CargoPermanente") = ""					
			
			If Codigo = "" Then
			
				Codigo = Request("checkbox")
				
				If Codigo = "" Then
					Codigo = CodigoValidacao
				End If
				
				sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E, dados_unico.funcionario F, dados_unico.est_organizacional_funcionario EF WHERE est_organizacional_funcionario_st = 0 AND (F.funcionario_id = EF.funcionario_id) AND (PF.pessoa_id = F.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND (P.pessoa_id = PF.pessoa_id) AND P.pessoa_id IN (" & Codigo & ")"		
				
			Else
				sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E, dados_unico.funcionario F, dados_unico.est_organizacional_funcionario EF WHERE est_organizacional_funcionario_st = 0 AND (F.funcionario_id = EF.funcionario_id) AND (PF.pessoa_id = F.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND (P.pessoa_id = PF.pessoa_id) AND P.pessoa_id = " & Codigo
			End If

			Set rsConsulta = objConexao.execute(sqlConsulta)

			If Not rsConsulta.eof Then			
			
					'atributos da entidade pessoa
					Codigo					= rsConsulta("pessoa_id")
					StatusNumero			= rsConsulta("pessoa_st")
					PessoaDate				= rsConsulta("pessoa_dt_criacao")
					PessoaDataAlteracao		= rsConsulta("pessoa_dt_alteracao")					
					Nome					= rsConsulta("pessoa_nm")
					Email					= rsConsulta("pessoa_email")
					NivelEscolar			= rsConsulta("nivel_escolar_id")
					EstadoCivil				= rsConsulta("estado_civil_id")
					Sexo					= rsConsulta("pessoa_fisica_sexo")	
					CPF						= rsConsulta("pessoa_fisica_cpf")				
					DataNascimento			= rsConsulta("pessoa_fisica_dt_nasc")	
					RG						= rsConsulta("pessoa_fisica_rg")	
					RGOrgao					= rsConsulta("pessoa_fisica_rg_orgao")
					RGOrgaoUF				= rsConsulta("pessoa_fisica_rg_uf")									
					RGData					= rsConsulta("pessoa_fisica_rg_dt")
					Passaporte				= rsConsulta("pessoa_fisica_passaporte")	
					Sangue					= rsConsulta("pessoa_fisica_grupo_sanguineo")
					NomePai					= rsConsulta("pessoa_fisica_nm_pai")
					NomeMae 				= rsConsulta("pessoa_fisica_nm_mae")
					Sangue					= rsConsulta("pessoa_fisica_grupo_sanguineo")
					Nacionalidade			= rsConsulta("pessoa_fisica_nacionalidade")
					NaturalidadeUF			= rsConsulta("pessoa_fisica_naturalidade_uf")
					Naturalidade			= rsConsulta("pessoa_fisica_naturalidade")	

					If Sexo = "M" Then
						SexoMasc = "checked"
						SexoFem  = ""										
					ElseIf Sexo = "F" Then
						SexoMasc = ""
						SexoFem  = "checked"																					
					Else
						SexoMasc = ""
						SexoFem  = ""																					
					End If											

					'se pessoa possuir nivel tecnico como nivel escolar, entao consultar dados					
					sqlConsultaNivelTecnico = "SELECT nivel_tecnico_ds, nivel_tecnico_classe, nivel_tecnico_registro FROM dados_unico.nivel_tecnico WHERE pessoa_id = " & Codigo
					Set rsConsultaNivelTecnico = objConexao.execute(sqlConsultaNivelTecnico)
					
					If Not rsConsultaNivelTecnico.eof Then

						NivelTecnico 			= rsConsultaNivelTecnico("nivel_tecnico_ds")
						NivelTecnicoClasse 		= rsConsultaNivelTecnico("nivel_tecnico_classe")
						NivelTecnicoRegistro 	= rsConsultaNivelTecnico("nivel_tecnico_registro")
										
					End If
					
					TituloEleitor			= rsConsulta("pessoa_fisica_titulo")
					TituloEleitorZona		= rsConsulta("pessoa_fisica_titulo_zona")				
					TituloEleitorSecao		= rsConsulta("pessoa_fisica_titulo_secao")	
					TituloEleitorUF			= rsConsulta("pessoa_fisica_titulo_uf")
					TituloEleitorCidade		= rsConsulta("pessoa_fisica_titulo_cidade")	
					Habilitacao				= rsConsulta("pessoa_fisica_cnh")		
					HabilitacaoCategoria	= rsConsulta("pessoa_fisica_cnh_categoria")	
					HabilitacaoValidade		= rsConsulta("pessoa_fisica_cnh_validade")	
					Reservista				= rsConsulta("pessoa_fisica_reservista")	
					ReservistaUF			= rsConsulta("pessoa_fisica_reservista_uf")	
					ReservistaMinisterio	= rsConsulta("pessoa_fisica_reservista_ministerio")	
					Endereco				= rsConsulta("endereco_ds")
					EnderecoNumero			= rsConsulta("endereco_num")
					EnderecoComplemento		= rsConsulta("endereco_complemento")
					EnderecoCEP				= rsConsulta("endereco_cep")				
					EnderecoUF				= rsConsulta("estado_uf")													
					EnderecoMunicipio		= rsConsulta("municipio_cd")													
					EnderecoBairro			= rsConsulta("endereco_bairro")	
					
					If StatusNumero = "0" Then StatusNome = "Ativo" Else StatusNome = "Inativo" End If																	
					
					'se pessoa possuir nivel tecnico como nivel escolar, entao consultar dados					
					sqlConsultaTelefone = "SELECT * FROM dados_unico.telefone WHERE pessoa_id = " & Codigo
					Set rsConsultaTelefone = objConexao.execute(sqlConsultaTelefone)
					
					If Not rsConsultaTelefone.eof Then
					
						While Not rsConsultaTelefone.eof 
						
							If rsConsultaTelefone("telefone_tipo") = "R" Then
								TelefoneDDDResidencial 	= rsConsultaTelefone("telefone_ddd")
								TelefoneResidencial 	= rsConsultaTelefone("telefone_num")
							ElseIf rsConsultaTelefone("telefone_tipo") = "M" Then	
								TelefoneDDDCelular 		= rsConsultaTelefone("telefone_ddd")
								TelefoneCelular 		= rsConsultaTelefone("telefone_num")
							ElseIf rsConsultaTelefone("telefone_tipo") = "C" Then	
								TelefoneDDDComercial 	= rsConsultaTelefone("telefone_ddd")
								TelefoneComercial 		= rsConsultaTelefone("telefone_num")
							ElseIf rsConsultaTelefone("telefone_tipo") = "F" Then	
								TelefoneDDDFax 			= rsConsultaTelefone("telefone_ddd")
								TelefoneFax 			= rsConsultaTelefone("telefone_num")																																
							End If
							
						
							rsConsultaTelefone.MoveNext
						Wend
										
					End If	
					
					'atributos da entidade funcionario
					TipoFuncionario			= rsConsulta("funcionario_tipo_id")
					Matricula				= rsConsulta("funcionario_matricula")
					CargoTemporario			= rsConsulta("cargo_temporario")
					CargoPermanente			= rsConsulta("cargo_permanente")
					
					Session("CargoTemporario") = CargoTemporario
					Session("CargoPermanente") = CargoPermanente		
														
					Funcao					= rsConsulta("funcao_id")
					DataAdmissao			= rsConsulta("funcionario_dt_admissao")
					DataDemissao			= rsConsulta("funcionario_dt_demissao")				
					CartTrabalho			= rsConsulta("pessoa_fisica_clt")
					CartTrabalhoSerie		= rsConsulta("pessoa_fisica_clt_serie")				
					CartTrabalhoUF			= rsConsulta("pessoa_fisica_clt_uf")		
					PIS						= rsConsulta("pessoa_fisica_pis")
					FGTS					= rsConsulta("funcionario_conta_fgts")
					EstruturaAtuacao		= rsConsulta("est_organizacional_id")
					EstruturaLotacao		= rsConsulta("est_organizacional_lotacao_id")		
					OrgaoOrigem				= rsConsulta("funcionario_orgao_origem")
					OrgaoDestino			= rsConsulta("funcionario_orgao_destino")	
					FuncionarioRamal 		= rsConsulta("funcionario_ramal")
					FuncionarioEmail 		= rsConsulta("funcionario_email")										
					
					'se pessoa possuir dados bancarios				
					sqlConsultaBanco = "SELECT * FROM dados_unico.dados_bancarios db, dados_unico.banco b WHERE (db.banco_id = b.banco_id) AND pessoa_id = " & Codigo
					Set rsConsultaBanco = objConexao.execute(sqlConsultaBanco)	
					
					If Not rsConsultaBanco.eof Then
					
						Banco					= rsConsultaBanco("banco_id")
						BancoNome				= rsConsultaBanco("banco_ds")	
						BancoNumero				= rsConsultaBanco("banco_cd")						
						Agencia					= rsConsultaBanco("dados_bancarios_agencia")
						Conta					= rsConsultaBanco("dados_bancarios_conta")
						TipoConta				= rsConsultaBanco("dados_bancarios_conta_tipo")						
					
					End If														
					
			End If	

	ElseIf AcaoSistema = "alterar" Then
				
			Codigo					= request("txtCodigo")
			EstruturaOriginal		= request("txtEstruturaOriginal")
			EstruturaLotacao		= Request("cmbEstruturaLotacao")			
			Nome					= UCase(replace(Trim(Request("txtNome")),"'","''"))
			Email					= LCase(replace(Trim(Request("txtEmail")),"'","''"))
			DataAlteracao 			= Date
			NivelEscolar			= Request("cmbNivelEscolar")
			EstadoCivil				= Request("cmbEstadoCivil")
			Sexo					= Request("rdSexo")	
			CPF						= Request("txtCPF")				
			DataNascimento			= Request("txtDtNasc")	
			RG						= Request("txtRG")	
			RGOrgao					= UCase(Request("txtRGOrgao"))
			RGOrgaoUF				= Request("cmbRGUF")									
			RGData					= Request("txtRGDtExpedicao")
			Passaporte				= Request("txtPassaporte")		
			Sangue					= Request("cmbGrupoSanguineo")
			NomePai					= UCase(replace(Trim(Request("txtPai")),"'","''"))
			NomeMae 				= UCase(replace(Trim(Request("txtMae")),"'","''"))
			Nacionalidade			= Request("cmbNacionalidade")
			NaturalidadeUF			= Request("cmbNaturalidadeUF")
			Naturalidade			= Request("cmbNaturalidade")
			NivelTecnico 			= Request("txtNivelEscolarDescricao")
			NivelTecnicoClasse 		= Request("txtNivelEscolarClasse")
			NivelTecnicoRegistro 	= Request("txtNivelEscolarRegistro")		
			Endereco				= UCase(replace(Trim(Request("txtEndereco")),"'","''"))			
			EnderecoNumero			= Request("txtNumero")
			EnderecoComplemento		= Request("txtComplemento")	
			EnderecoCEP				= Request("txtCEP")				
			EnderecoUF				= Request("cmbEnderecoUF")													
			EnderecoMunicipio		= Request("cmbEnderecoMunicipio")													
			EnderecoBairro			= UCase(replace(Trim(Request("txtEnderecoBairro")),"'","''"))		
			TipoFuncionario			= Request("cmbFuncionarioTipo")
			Matricula				= Request("txtMatricula")
			CargoTemporario			= Request("cmbCargoTemporario")
			CargoPermanente			= Request("cmbCargoPermanente")	
			Funcao					= Request("cmbFuncao")	
			DataAdmissao			= Request("txtDtAdmissao")
			DataDemissao			= Request("txtDtDemissao")					
			CartTrabalho			= Request("txtCLTNumero")
			CartTrabalhoSerie		= Request("txtCLTSerie")				
			CartTrabalhoUF			= Request("cmbCLTUF")		
			TituloEleitor			= Request("txtTitulo")
			TituloEleitorZona		= Request("txtTituloZona")				
			TituloEleitorSecao		= Request("txtTituloSecao")		
			TituloEleitorUF			= Request("cmbTituloUF")
			TituloEleitorCidade		= Request("cmbTituloCidade")				
			Habilitacao				= Request("txtHabilitacao")		
			HabilitacaoCategoria	= Request("txtHabilitacaoCategoria")
			HabilitacaoValidade		= Request("txtHabilitacaoValidade")		
			Reservista				= Request("txtReservista")
			ReservistaUF			= Request("cmbReservistaUF")	
			ReservistaMinisterio	= Request("cmbMinisterio")	
			PIS						= Request("txtPIS")
			FGTS					= Request("txtFGTS")
			EstOrganizacional		= Request("cmbEstruturaAtuacao")
			OrgaoOrigem				= Request("cmbOrgaoOrigem")
			OrgaoDestino			= Request("cmbOrgaoDestino")
			FuncionarioRamal 		= Request("txtRamal")
			FuncionarioEmail 		= LCase(replace(Trim(Request("txtFuncionarioEmail")),"'","''"))	
			
			If Funcao 			= "" Then Funcao 		  = 0 End If	
			If CargoTemporario  = "" Then CargoTemporario = 0 End If
			If CargoPermanente  = "" Then CargoPermanente = 0 End If	
			If OrgaoOrigem 		= "" Then OrgaoOrigem 	  = 0 End If						
			If OrgaoDestino 	= "" Then OrgaoDestino 	  = 0 End If		
			If EstruturaLotacao = "" Then EstruturaLotacao= 0 End If												
			
			Banco					= Request("cmbBanco")
			Agencia					= Request("txtAgencia")
			Conta					= Request("txtConta")
			TipoConta				= Request("cmbTipoConta")		
			TelefoneDDDResidencial 	= Request("txtFoneDDDResidencial")
			TelefoneResidencial 	= Request("txtFoneResidencial")		
			TelefoneDDDComercial 	= Request("txtFoneDDDComercial")
			TelefoneComercial	 	= Request("txtFoneComercial")				
			TelefoneDDDCelular 		= Request("txtFoneDDDCelular")
			TelefoneCelular 		= Request("txtFoneCelular")		
			TelefoneDDDFax 			= Request("txtFoneDDDFax")
			TelefoneFax 			= Request("txtFoneFax")	
			
			sqlConsultaExistente = "SELECT PF.pessoa_id FROM dados_unico.pessoa_fisica PF, dados_unico.funcionario F WHERE (PF.pessoa_id = F.pessoa_id) AND (pessoa_fisica_cpf = '" & CPF & "' OR funcionario_matricula = '" & Matricula & "') AND PF.pessoa_id <> " & Codigo
			Set rsConsultaExistente = objConexao.execute(sqlConsultaExistente)	
			

			If rsConsultaExistente.eof Then
			
					objConexao.BeginTrans
	
					sqlAltera = "UPDATE dados_unico.pessoa SET " &_
										"pessoa_nm = '" & Nome & "', " &_
										"pessoa_email = '" & Email & "', " &_										
										"pessoa_dt_alteracao = '" & DataAlteracao & "' " &_										
										"WHERE pessoa_id = " & Codigo
										
					objConexao.execute(sqlAltera)
	
					sqlAltera = "UPDATE dados_unico.pessoa_fisica SET " &_
										"pessoa_fisica_sexo = '" & Sexo & "', " &_					
										"pessoa_fisica_cpf = '" & CPF & "', " &_
										"pessoa_fisica_dt_nasc = '" & DataNascimento & "', " &_
										"pessoa_fisica_rg = '" & RG & "', " &_
										"pessoa_fisica_rg_orgao = '" & RGOrgao & "', " &_
										"pessoa_fisica_rg_uf = '" & RGOrgaoUF & "', " &_
										"pessoa_fisica_rg_dt = '" & RGData & "', " &_
										"pessoa_fisica_passaporte = '" & Passaporte & "', " &_										
										"pessoa_fisica_nm_pai = '" & NomePai & "', " &_										
										"pessoa_fisica_nm_mae = '" & NomeMae & "', " &_																				
										"pessoa_fisica_grupo_sanguineo = '" & Sangue & "', " &_																														
										"pessoa_fisica_nacionalidade = '" & Nacionalidade & "', " &_																																								
										"pessoa_fisica_naturalidade = '" & Naturalidade & "', " &_																																								
										"pessoa_fisica_naturalidade_uf = '" & NaturalidadeUF & "', " &_	
										"pessoa_fisica_clt = '" & CartTrabalho & "', " &_											
										"pessoa_fisica_clt_serie = '" & CartTrabalhoSerie & "', " &_											
										"pessoa_fisica_clt_uf = '" & CartTrabalhoUF & "', " &_	
										"pessoa_fisica_titulo = '" & TituloEleitor & "', " &_																																									
										"pessoa_fisica_titulo_zona = '" & TituloEleitorZona & "', " &_																																									
										"pessoa_fisica_titulo_secao = '" & TituloEleitorSecao & "', " &_																																									
										"pessoa_fisica_titulo_cidade = '" & TituloEleitorCidade & "', " &_																																									
										"pessoa_fisica_titulo_uf = '" & TituloEleitorUF & "', " &_	
										"pessoa_fisica_cnh = '" & Habilitacao & "', " &_	
										"pessoa_fisica_cnh_categoria = '" & HabilitacaoCategoria & "', " &_	
										"pessoa_fisica_cnh_validade = '" & HabilitacaoValidade & "', " &_	
										"pessoa_fisica_reservista = '" & Reservista & "', " &_	
										"pessoa_fisica_reservista_ministerio = '" & ReservistaMinisterio & "', " &_	
										"pessoa_fisica_reservista_uf = '" & ReservistaUF & "', " &_	
										"pessoa_fisica_pis = '" & PIS & "', " &_	
										"estado_civil_id = " & EstadoCivil & ", " &_																					
										"nivel_escolar_id = " & NivelEscolar & " " &_																															
										"WHERE pessoa_id = " & Codigo
										
					objConexao.execute(sqlAltera)	

					If NivelTecnico <> "" Then
					
							sqlAltera = "UPDATE dados_unico.nivel_tecnico SET " &_
												"nivel_tecnico_ds = '" & NivelTecnico & "', " &_ 
												"nivel_tecnico_classe = '" & NivelTecnicoClasse & "', " &_ 
												"nivel_tecnico_registro = '" & NivelTecnicoRegistro & "' " &_ 
												"WHERE pessoa_id = " & Codigo					
 							objConexao.execute(sqlAltera)
					End If				
					
					sqlAltera = "UPDATE dados_unico.endereco SET " &_
										"estado_uf = '" & EnderecoUF & "', " &_ 					
										"municipio_cd = '" & EnderecoMunicipio & "', " &_ 
										"endereco_bairro = '" & EnderecoBairro & "', " &_ 
										"endereco_ds = '" & Endereco & "', " &_ 										
										"endereco_num = '" & EnderecoNumero & "', " &_ 
										"endereco_cep = '" & EnderecoCEP & "', " &_ 							
										"endereco_complemento = '" & EnderecoComplemento & "' " &_ 																	
										"WHERE pessoa_id = " & Codigo
					
					'Response.Write(sqlAltera)
					'Response.end()
												
 					objConexao.execute(sqlAltera)
				
					sqlAltera = "UPDATE dados_unico.telefone SET " &_
										"telefone_num = '" & TelefoneResidencial & "', " &_ 					
										"telefone_ddd = '" & TelefoneDDDResidencial & "' " &_ 
										"WHERE telefone_tipo = 'R' AND pessoa_id = " & Codigo
										
 					objConexao.execute(sqlAltera)

					sqlAltera = "UPDATE dados_unico.telefone SET " &_
										"telefone_num = '" & TelefoneComercial & "', " &_ 					
										"telefone_ddd = '" & TelefoneDDDComercial & "' " &_ 
										"WHERE telefone_tipo = 'C' AND pessoa_id = " & Codigo
										
 					objConexao.execute(sqlAltera)

					sqlAltera = "UPDATE dados_unico.telefone SET " &_
										"telefone_num = '" & TelefoneCelular & "', " &_ 					
										"telefone_ddd = '" & TelefoneDDDCelular & "' " &_ 
										"WHERE telefone_tipo = 'M' AND pessoa_id = " & Codigo
										
 					objConexao.execute(sqlAltera)

					sqlAltera = "UPDATE dados_unico.telefone SET " &_
										"telefone_num = '" & TelefoneFax & "', " &_ 					
										"telefone_ddd = '" & TelefoneDDDFax & "' " &_ 
										"WHERE telefone_tipo = 'F' AND pessoa_id = " & Codigo
										
 					objConexao.execute(sqlAltera)											
										
					sqlAltera = "UPDATE dados_unico.funcionario SET " &_
										"funcionario_tipo_id = " & TipoFuncionario & ", " &_ 					
										"funcao_id = " & Funcao & ", " &_ 
										"cargo_permanente = " & CargoPermanente & ", " &_ 
										"cargo_temporario = " & CargoTemporario & ", " &_ 										
										"funcionario_matricula = '" & Matricula & "', " &_ 										
										"funcionario_ramal = '" & FuncionarioRamal & "', " &_ 
										"funcionario_email = '" & FuncionarioEmail & "', " &_ 							
										"funcionario_dt_admissao = '" & DataAdmissao & "', " &_ 							
										"funcionario_dt_demissao = '" & DataDemissao & "', " &_ 							
										"funcionario_orgao_origem = '" & OrgaoOrigem & "', " &_
										"funcionario_orgao_destino = '" & OrgaoDestino & "', " &_										
										"est_organizacional_lotacao_id = " & EstruturaLotacao & ", " &_
										"funcionario_conta_fgts = '" & FGTS & "' " &_ 																	
										"WHERE pessoa_id = " & Codigo
										
 					objConexao.execute(sqlAltera)
					
					'se o cargo foi alterado, guardo no log
					If Session("CargoTemporario") <> CargoTemporario Then
						Call f_InsereLog("Alterou da pessoa_id (" & Codigo & ") o cargo temporario de (" & Session("CargoTemporario") & ") para (" & CargoTemporario & ")")
					End If
					
					If Session("CargoPermanente") <> CargoPermanente Then
						Call f_InsereLog("Alterou da pessoa_id (" & Codigo & ") o cargo permanente de (" & Session("CargoPermanente") & ") para (" & CargoPermanente & ")")					
					End If					
															
					
					If Session("UsuarioEst") = "DG_DA_CRH" Then
						sqlAltera = "UPDATE dados_unico.funcionario SET " &_
											"funcionario_validacao_rh = 1 " &_																																					
											"WHERE pessoa_id = " & Codigo
											
						objConexao.execute(sqlAltera)
					End If							

					If EstruturaOriginal <> EstOrganizacional Then
					
							sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " & Codigo
 		 					Set rsConsulta = objConexao.execute(sqlConsulta)
					
							sqlAltera = "UPDATE dados_unico.est_organizacional_funcionario SET " &_
												"est_organizacional_funcionario_dt_saida = '" & DataAlteracao & "', " &_ 					
												"est_organizacional_funcionario_st = 1 " &_ 
												"WHERE funcionario_id = " & rsConsulta("funcionario_id")
												
 		 					objConexao.execute(sqlAltera)		

							sqlInsere = "INSERT INTO dados_unico.est_organizacional_funcionario (est_organizacional_id, funcionario_id, est_organizacional_funcionario_dt_entrada) " &_
										"VALUES (" & EstOrganizacional & " ," & rsConsulta("funcionario_id") & ", '" & DataAlteracao & "')"
							objConexao.execute(sqlInsere)					
					
					End If
					
					If Banco <> "" Then
					
						sqlConsulta = "SELECT dados_bancarios_id FROM dados_unico.dados_bancarios WHERE pessoa_id = " & Codigo
						Set rsConsulta = objConexao.execute(sqlConsulta)
						
						If rsConsulta.eof Then
							sqlInsere = "INSERT INTO dados_unico.dados_bancarios (pessoa_id, banco_id, dados_bancarios_agencia, dados_bancarios_conta, dados_bancarios_conta_tipo, dados_bancarios_dt_criacao) " &_
										"VALUES (" & Codigo & ", " & Banco & ", '" & Agencia & "', '" & Conta & "', '" & TipoConta & "', '" & DataAlteracao & "')"
							objConexao.execute(sqlInsere)							
						Else
							sqlAltera = "UPDATE dados_unico.dados_bancarios SET " &_
												"banco_id = " & Banco & ", " &_ 					
												"dados_bancarios_agencia = '" & Agencia & "', " &_ 					
												"dados_bancarios_conta = '" & Conta & "', " &_ 					
												"dados_bancarios_conta_tipo = '" & TipoConta & "', " &_ 																																									
												"dados_bancarios_dt_alteracao = '" & DataAlteracao & "' " &_ 
												"WHERE pessoa_id = " & Codigo
												
		 					objConexao.execute(sqlAltera)							
						End If
					
					End If
					
					If Err <> 0 Then
						objConexao.RollbackTrans
						Response.Write Err.Description
					Else
						objConexao.CommitTrans
					End If	
							
					Response.Redirect "FuncionarioInicio.asp"
	
			Else
	
					MensagemErroBD = "CPF ou Matrícula já existente."
	
			End If	
		
		ElseIf AcaoSistema = "alterarStatus" Then
		
					DataAlteracao 	= Date
					Codigo 			= request.QueryString("cod")
					StatusCod		= request.QueryString("status")
					
					If StatusCod = 0 Then StatusCod = 1 Else StatusCod = 0 End If
									
					sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_st = " & StatusCod & ", pessoa_dt_alteracao = '" & DataAlteracao & "' WHERE pessoa_id = " & Codigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect "FuncionarioInicio.asp"			
		
		ElseIf AcaoSistema = "excluir" Then			
		
				Dim sqlDeleta
				
				ExcluirCheckbox = Request.QueryString("excluirMultiplo")
				
				If ExcluirCheckbox = 1 Then
				
					Codigo	= Request("txtCodigo")
					sqlDeleta = "UPDATE dados_unico.pessoa SET pessoa_st = 2 WHERE pessoa_id IN (" & Codigo & ")"
							
				Else		
				
					Codigo	= Request.QueryString("cod")		
					sqlDeleta = "UPDATE dados_unico.pessoa SET pessoa_st = 2 WHERE pessoa_id = " & Codigo
					
				End If
		
				objConexao.execute(sqlDeleta)
				
	
				Response.Redirect "FuncionarioInicio.asp"
					
		End If
	


%>
