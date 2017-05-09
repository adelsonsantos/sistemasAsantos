<% 	
	'variaveis de banco
	Dim sqlConsultaBanco, rsConsultaBanco, sqlConsultaTelefone, rsConsultaTelefone, sqlConsultaNivelTecnico, rsConsultaNivelTecnico, sqlConsulta, rsConsulta, sqlAltera, sqlCodigo, rsCodigo, sqlInsere, sqlConsultaExistente, rsConsultaExistente, sqlCodigoFuncionario, rsCodigoFuncionario, CodigoRegistro, ExcluirCheckbox, sqlConsultaExclusao, rsConsultaExclusao

	'controla a visibilidade do botao consultar
	Session("BotaoConsultar") = 1
		
	'variaveis da entidade pessoa
	Dim Codigo, Nome, Tipo, Email, DataCriacao, StatusNumero, StatusNome, StatusCod, DataAlteracao, PessoaDataCriacao, PessoaDataAlteracao
	
	'variaveis da entidade pessoa fisica
	Dim NivelEscolar, EstadoCivil, Sexo, SexoMasc, SexoFem, CPF, DataNascimento, RG, RGOrgao, RGOrgaoUF, RGData, Passaporte, Sangue, NomePai, NomeMae
	Dim NivelTecnico, NivelTecnicoClasse, NivelTecnicoRegistro, Nacionalidade, NaturalidadeUF, Naturalidade, EstruturaOriginal
	Dim TituloEleitor, TituloEleitorZona, TituloEleitorSecao, TituloEleitorUF, TituloEleitorCidade, Habilitacao, HabilitacaoCategoria	
	Dim CartTrabalho, CartTrabalhoSerie, CartTrabalhoUF, HabilitacaoValidade, Reservista, ReservistaUF, ReservistaMinisterio, PIS
	
	'variaveis da entidade endereco
	Dim Endereco, EnderecoNumero, EnderecoComplemento, EnderecoCEP, EnderecoUF, EnderecoMunicipio, EnderecoBairro
		
	'variaveis da entidade funcionario
	Dim TipoFuncionario, Matricula, Cargo, Funcao, DataAdmissao, DataDemissao, FGTS, EstOrganizacional, OrgaoOrigem, FuncionarioRamal, FuncionarioEmail	
	
	'variaveis da entidade banco	
	Dim Banco, Agencia, Conta, TipoConta
	
	'variaveis da entidade telefone
	Dim TelefoneDDDComercial, TelefoneComercial, TelefoneDDDResidencial, TelefoneResidencial, TelefoneDDDCelular, TelefoneCelular, TelefoneDDDFax, TelefoneFax
	
	'zera a variavel de msg de banco
	MensagemErroBD = ""
	
	'define o link padrao para as paginas
	PaginaLocal = "Fisica"
	
	'filtro por status
	Dim strAtivo, strInativo, strTodos, numFiltro, strStringSQL	
	
	'carrega grade de informacoes na pagina inicial
	If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	

			numFiltro = Request.QueryString("filtro")
			
			If numFiltro <> "" Then
				strStringSQL = "pessoa_st = " & numFiltro
			Else
				strStringSQL = "pessoa_st <> 2"
			End If	
	
			If RetornoFiltro <> "" Then
				sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, pessoa_fisica_cpf FROM dados_unico.pessoa p, dados_unico.pessoa_fisica pf WHERE pessoa_fisica_funcionario = 0 AND (p.pessoa_id = pf.pessoa_id) AND pessoa_nm ILIKE '%" & RetornoFiltro & "%' AND " & strStringSQL & " ORDER BY UPPER(pessoa_nm)"	
			Else
				sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, pessoa_fisica_cpf FROM dados_unico.pessoa p, dados_unico.pessoa_fisica pf WHERE pessoa_fisica_funcionario = 0 AND (p.pessoa_id = pf.pessoa_id) AND " & strStringSQL & " ORDER BY UPPER(pessoa_nm)"	
			End If

			set rsConsulta = objConexao.execute(sqlConsulta) 	
				
		
	ElseIf AcaoSistema = "incluir" Then	

			'atributos da entidade pessoa
			Nome					= UCase(replace(Trim(Request("txtNome")),"'","''"))
			Tipo					= "F" 
			Email					= LCase(replace(Trim(Request("txtEmail")),"'","''"))
			DataCriacao 			= Date
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
			TelefoneDDDResidencial 	= Request("txtFoneDDDResidencial")
			TelefoneResidencial 	= Request("txtFoneResidencial")		
			TelefoneDDDComercial 	= Request("txtFoneDDDComercial")
			TelefoneComercial	 	= Request("txtFoneComercial")				
			TelefoneDDDCelular 		= Request("txtFoneDDDCelular")
			TelefoneCelular 		= Request("txtFoneCelular")		
			TelefoneDDDFax 			= Request("txtFoneDDDFax")
			TelefoneFax 			= Request("txtFoneFax")	
		
			'verifica se já existe cpf
			sqlConsultaExistente = "SELECT pf.pessoa_id FROM dados_unico.pessoa_fisica pf, dados_unico.funcionario f WHERE (pf.pessoa_id = f.pessoa_id) AND pessoa_fisica_cpf = '" & CPF & "' OR funcionario_matricula = '" & Matricula & "'"
			Set rsConsultaExistente = objConexao.execute(sqlConsultaExistente)	
	
			If rsConsultaExistente.eof Then
			
					objConexao.BeginTrans
				
					DataCriacao = Date
					
					'insere dados na tabela pessoa
					sqlInsere = "INSERT INTO dados_unico.pessoa (pessoa_nm, pessoa_tipo, pessoa_email, pessoa_dt_criacao) VALUES ('" & Nome & "', '" & Tipo & "', '" & Email & "', '" & DataCriacao & "')"
					objConexao.execute(sqlInsere)
					'fim
		
					'pega o ultimo codigo inserido
					sqlCodigo = "SELECT @@identity AS UltimoInserido FROM dados_unico.pessoa" 
					Set rsCodigo = objConexao.execute(sqlCodigo)	
					'fim					
					
					'insere dados da tabela pessoa_fisica
					sqlInsere = "INSERT INTO dados_unico.pessoa_fisica (pessoa_id, nivel_escolar_id, pessoa_fisica_sexo, pessoa_fisica_cpf, pessoa_fisica_dt_nasc, pessoa_fisica_rg, pessoa_fisica_rg_orgao, pessoa_fisica_rg_uf, pessoa_fisica_rg_dt, pessoa_fisica_passaporte, estado_civil_id, pessoa_fisica_nm_pai, pessoa_fisica_nm_mae, pessoa_fisica_grupo_sanguineo, pessoa_fisica_nacionalidade, pessoa_fisica_naturalidade, pessoa_fisica_naturalidade_uf, pessoa_fisica_clt, pessoa_fisica_clt_serie, pessoa_fisica_clt_uf, pessoa_fisica_titulo, pessoa_fisica_titulo_zona, pessoa_fisica_titulo_secao, pessoa_fisica_titulo_cidade, pessoa_fisica_titulo_uf, pessoa_fisica_cnh, pessoa_fisica_cnh_categoria, pessoa_fisica_cnh_validade, pessoa_fisica_reservista, pessoa_fisica_reservista_ministerio, pessoa_fisica_reservista_uf, pessoa_fisica_pis) " &_
								"VALUES (" & rsCodigo("UltimoInserido") & ", '" & NivelEscolar & "', '" & Sexo & "', '" & CPF & "', '" & DataNascimento & "', '" & RG & "', '" & RGOrgao & "', '" & RGOrgaoUF & "', '" & RGData & "', '" & Passaporte & "', '" & EstadoCivil & "', '" & NomePai & "', '" & NomeMae & "', '" & Sangue & "', '" & Nacionalidade & "', '" & Naturalidade & "', '" & NaturalidadeUF & "', '" & CartTrabalho & "', '" & CartTrabalhoSerie & "', '" & CartTrabalhoUF & "', '" & TituloEleitor & "', '" & TituloEleitorZona & "', '" & TituloEleitorSecao & "', '" & TituloEleitorCidade & "', '" & TituloEleitorUF & "', '" & Habilitacao & "', '" & HabilitacaoCategoria & "', '" & HabilitacaoValidade & "', '" & Reservista & "', '" & ReservistaMinisterio & "', '" & ReservistaUF & "', '" & PIS & "')"
					objConexao.execute(sqlInsere)
					'fim

					'insere dados da tabela endereco	
					sqlInsere = "INSERT INTO dados_unico.endereco (pessoa_id, estado_uf, municipio_cd, endereco_bairro, endereco_ds, endereco_num, endereco_complemento, endereco_cep) " &_
								"VALUES (" & rsCodigo("UltimoInserido") & ", '" & EnderecoUF & "', '" & EnderecoMunicipio & "', '" & EnderecoBairro & "', '" & Endereco & "', '" & EnderecoNumero & "', '" & EnderecoComplemento & "', '" & EnderecoCEP & "')"
					objConexao.execute(sqlInsere)	
					'fim					
					
					'insere dados sobre nivel tecnico
					If NivelTecnico <> "" Then
						sqlInsere = "INSERT INTO dados_unico.nivel_tecnico (pessoa_id, nivel_tecnico_ds, nivel_tecnico_classe, nivel_tecnico_registro) " &_
									"VALUES (" & rsCodigo("UltimoInserido") & ", '" & NivelTecnico & "', '" & NivelTecnicoClasse & "', '" & NivelTecnicoRegistro & "')"
						objConexao.execute(sqlInsere)
					End If	
					'fim										
					
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
					'fim					
					
					If Err <> 0 Then
						objConexao.RollbackTrans
						Response.Write Err.Description
					Else
						objConexao.CommitTrans
					End If								
						
					Response.Redirect "FisicaInicio.asp"

			Else
	
					MensagemErroBD = "CPF já existente."
	
			End If				

	ElseIf AcaoSistema = "consultar" Then	
	
			Codigo = Request.QueryString("cod")
			
			If Codigo = "" Then
			
				Codigo = Request("checkbox")
				
				sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E WHERE (e.pessoa_id = p.pessoa_id) AND(P.pessoa_id = PF.pessoa_id) AND P.pessoa_id IN (" & Codigo & ")"
			
			Else
				sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E WHERE (e.pessoa_id = p.pessoa_id) AND(P.pessoa_id = PF.pessoa_id) AND P.pessoa_id = " & Codigo
			End If				
	
			Set rsConsulta = objConexao.execute(sqlConsulta)

			If Not rsConsulta.eof Then			
			
					'atributos da entidade pessoa
					Codigo					= rsConsulta("pessoa_id")
					StatusNumero			= rsConsulta("pessoa_st")
					PessoaDataCriacao		= rsConsulta("pessoa_dt_criacao")
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
					
			End If	

	ElseIf AcaoSistema = "alterar" Then
				
			Codigo					= request("txtCodigo")
			EstruturaOriginal		= request("txtEstruturaOriginal")
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
			TelefoneDDDResidencial 	= Request("txtFoneDDDResidencial")
			TelefoneResidencial 	= Request("txtFoneResidencial")		
			TelefoneDDDComercial 	= Request("txtFoneDDDComercial")
			TelefoneComercial	 	= Request("txtFoneComercial")				
			TelefoneDDDCelular 		= Request("txtFoneDDDCelular")
			TelefoneCelular 		= Request("txtFoneCelular")		
			TelefoneDDDFax 			= Request("txtFoneDDDFax")
			TelefoneFax 			= Request("txtFoneFax")												
		
			sqlConsultaExistente = "SELECT PF.pessoa_id FROM dados_unico.pessoa_fisica PF WHERE (pessoa_fisica_cpf = '" & CPF & "') AND PF.pessoa_id <> " & Codigo
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
					
					If Err <> 0 Then
						objConexao.RollbackTrans
						Response.Write Err.Description
					Else
						objConexao.CommitTrans
					End If	
							
					Response.Redirect "FisicaInicio.asp"
	
			Else
	
					MensagemErroBD = "CPF já existente."
	
			End If	
		
		ElseIf AcaoSistema = "alterarStatus" Then
		
					DataAlteracao 	= Date
					Codigo 			= request.QueryString("cod")
					StatusCod		= request.QueryString("status")
					
					If StatusCod = 0 Then StatusCod = 1 Else StatusCod = 0 End If
									
					sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_st = " & StatusCod & ", pessoa_dt_alteracao = '" & DataAlteracao & "' WHERE pessoa_id = " & Codigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect "FisicaInicio.asp"			
		
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
				
	
				Response.Redirect "FisicaInicio.asp"
					
		End If
	


%>