<% 	
	'variaveis de banco
	Dim sqlConsultaTelefone, rsConsultaTelefone, sqlConsulta, rsConsulta, sqlAltera, sqlCodigo, rsCodigo, sqlInsere, sqlConsultaExistente, rsConsultaExistente, CodigoRegistro, ExcluirCheckbox, sqlConsultaExclusao, rsConsultaExclusao

	'controla a visibilidade do botao consultar
	Session("BotaoConsultar") = 1
	
	'variaveis da entidade pessoa
	Dim Codigo, RazaoSocial, Fornecedor, Email, DataCriacao, StatusNumero, StatusNome, StatusCod, DataAlteracao, PessoaDataCriacao, PessoaDataAlteracao
	
	'variaveis da entidade pessoa juridica
	Dim CNPJ, DataAbertura, NomeFantasia, IM, IE, Contato, Tipo, FornecedorMarcado
	
	'variaveis da entidade endereco
	Dim Endereco, EnderecoNumero, EnderecoComplemento, EnderecoCEP, EnderecoUF, EnderecoMunicipio, EnderecoBairro
	
	'variaveis da entidade telefone
	Dim TelefoneDDDComercial1, TelefoneComercial1, TelefoneDDDComercial2, TelefoneComercial2, TelefoneDDDFax, TelefoneFax
	Dim TelefoneDDDCelular, TelefoneCelular
	
	'filtro por status
	Dim strAtivo, strInativo, strTodos, numFiltro, strStringSQL
	
	'zera a variavel de msg de banco
	MensagemErroBD = ""
	
	'define o link padrao para as paginas
	PaginaLocal = "Juridica"
	
	'carrega grade de informacoes na pagina inicial
	If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
	
			numFiltro = Request.QueryString("filtro")
			
			If numFiltro <> "" Then
				strStringSQL = "pessoa_st = " & numFiltro
			Else
				strStringSQL = "pessoa_st <> 2"
			End If
			' fim do filtro 
				
			If RetornoFiltro <> "" Then
				sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, pessoa_juridica_cnpj, pessoa_juridica_nm_fantasia FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj WHERE (p.pessoa_id = pj.pessoa_id) AND pessoa_tipo = 'J' AND " & strStringSQL & " AND pessoa_nm ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(pessoa_nm)"	
			Else
				sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, pessoa_juridica_cnpj, pessoa_juridica_nm_fantasia FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj WHERE (p.pessoa_id = pj.pessoa_id) AND pessoa_tipo = 'J' AND " & strStringSQL & " ORDER BY UPPER(pessoa_nm)"	
			End If

			set rsConsulta = objConexao.execute(sqlConsulta) 					
		
	ElseIf AcaoSistema = "incluir" Then	

			'atributos da entidade pessoa
			NomeFantasia			= UCase(replace(Trim(Request("txtNomeFantasia")),"'","''"))
			RazaoSocial				= UCase(replace(Trim(Request("txtRazao")),"'","''"))
			Tipo					= "J" 
			Email					= LCase(replace(Trim(Request("txtEmail")),"'","''"))
			DataCriacao 			= Date
			Fornecedor				= Request("chkFornecedor")	
			CNPJ					= Request("txtCNPJ")				
			DataAbertura			= Request("txtData")
			IE						= Request("txtIE")				
			IM						= Request("txtIM")							
	
			Endereco				= UCase(replace(Trim(Request("txtEndereco")),"'","''"))			
			EnderecoNumero			= Request("txtNumero")
			EnderecoComplemento		= Request("txtComplemento")	
			EnderecoCEP				= Request("txtCEP")				
			EnderecoUF				= Request("cmbEnderecoUF")													
			EnderecoMunicipio		= Request("cmbEnderecoMunicipio")													
			EnderecoBairro			= UCase(replace(Trim(Request("txtEnderecoBairro")),"'","''"))		
			
			TelefoneDDDComercial1 	= Request("txtFoneDDDComercial1")
			TelefoneComercial1 		= Request("txtFoneComercial1")		
			TelefoneDDDComercial2 	= Request("txtFoneDDDComercial2")
			TelefoneComercial2	 	= Request("txtFoneComercial2")				
			TelefoneDDDFax 			= Request("txtFoneDDDFax")
			TelefoneFax 			= Request("txtFoneFax")	
			TelefoneDDDCelular 		= Request("txtFoneDDDCelular")
			TelefoneCelular 		= Request("txtFoneCelular")		
			Contato					= UCase(replace(Trim(Request("txtContato")),"'","''"))
			
			If Fornecedor = "on" Then Fornecedor = 1 Else Fornecedor = 0 End If
	
			'verifica se já existe cpf
			sqlConsultaExistente = "SELECT pessoa_id FROM dados_unico.pessoa_juridica WHERE pessoa_juridica_cnpj = '" & CNPJ & "'"
			Set rsConsultaExistente = objConexao.execute(sqlConsultaExistente)	
	
			If rsConsultaExistente.eof Then
			
					objConexao.BeginTrans
				
					DataCriacao = Date
					
					'insere dados na tabela pessoa
					sqlInsere = "INSERT INTO dados_unico.pessoa (pessoa_nm, pessoa_tipo, pessoa_email, pessoa_dt_criacao) VALUES ('" & RazaoSocial & "', '" & Tipo & "', '" & Email & "', '" & DataCriacao & "')"
					objConexao.execute(sqlInsere)
					'fim
		
					'pega o ultimo codigo inserido
					sqlCodigo = "SELECT @@identity AS UltimoInserido FROM dados_unico.pessoa" 
					Set rsCodigo = objConexao.execute(sqlCodigo)	
					'fim					
					
					'insere dados da tabela pessoa_fisica
					sqlInsere = "INSERT INTO dados_unico.pessoa_juridica (pessoa_id, pessoa_juridica_cnpj, pessoa_juridica_nm_fantasia, pessoa_juridica_insc_mun, pessoa_juridica_insc_est, pessoa_juridica_dt_abertura, pessoa_juridica_contato, pessoa_juridica_fornecedor) " &_
								"VALUES (" & rsCodigo("UltimoInserido") & ", '" & CNPJ & "', '" & NomeFantasia & "', '" & IM & "', '" & IE & "', '" & DataAbertura & "', '" & Contato & "', '" & Fornecedor & "')"
					objConexao.execute(sqlInsere)

					'fim

					'insere dados da tabela endereco	
					sqlInsere = "INSERT INTO dados_unico.endereco (pessoa_id, estado_uf, municipio_cd, endereco_bairro, endereco_ds, endereco_num, endereco_complemento, endereco_cep) " &_
								"VALUES (" & rsCodigo("UltimoInserido") & ", '" & EnderecoUF & "', '" & EnderecoMunicipio & "', '" & EnderecoBairro & "', '" & Endereco & "', '" & EnderecoNumero & "', '" & EnderecoComplemento & "', '" & EnderecoCEP & "')"
					objConexao.execute(sqlInsere)	
					'fim
					
					If TelefoneCelular <> "" Then				
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & rsCodigo("UltimoInserido") & ",'" & TelefoneCelular & "', '" & TelefoneDDDCelular & "', 'M')"
						objConexao.execute(sqlInsere)				
					End If
					
					If TelefoneComercial1 <> "" Then				
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & rsCodigo("UltimoInserido") & ",'" & TelefoneComercial1 & "', '" & TelefoneDDDComercial1 & "', 'C')"
						objConexao.execute(sqlInsere)				
					End If	
					If TelefoneComercial2 <> "" Then				
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & rsCodigo("UltimoInserido") & ",'" & TelefoneComercial2 & "', '" & TelefoneDDDComercial2 & "', 'C')"
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
						
					Response.Redirect "JuridicaInicio.asp"

			Else
	
					MensagemErroBD = "CNPJ já existente."
	
			End If				

	ElseIf AcaoSistema = "consultar" Then	
	
			Codigo = Request.QueryString("cod")
			
			If Codigo = "" Then
			
				Codigo = Request("checkbox")
				
				sqlConsulta = "SELECT * FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj, dados_unico.endereco e WHERE (p.pessoa_id = pj.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND p.pessoa_id IN (" & Codigo & ")"
				
			Else
				sqlConsulta = "SELECT * FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj, dados_unico.endereco e WHERE (p.pessoa_id = pj.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND p.pessoa_id = " & Codigo
			End If				
	
			Set rsConsulta = objConexao.execute(sqlConsulta)
			
			If Not rsConsulta.eof Then			
			
					'atributos da entidade pessoa
					NomeFantasia			= rsConsulta("pessoa_juridica_nm_fantasia")
					RazaoSocial				= rsConsulta("pessoa_nm")
					Email					= rsConsulta("pessoa_email")
					Fornecedor				= rsConsulta("pessoa_juridica_fornecedor")	
					CNPJ					= rsConsulta("pessoa_juridica_cnpj")			
					DataAbertura			= rsConsulta("pessoa_juridica_dt_abertura")
					IE						= rsConsulta("pessoa_juridica_insc_est")				
					IM						= rsConsulta("pessoa_juridica_insc_mun")
					Contato					= rsConsulta("pessoa_juridica_contato")	
					PessoaDataCriacao		= rsConsulta("pessoa_dt_criacao")
					PessoaDataAlteracao		= rsConsulta("pessoa_dt_alteracao")	
					StatusNumero			= rsConsulta("pessoa_st")																					
			
					Endereco				= rsConsulta("endereco_ds")
					EnderecoNumero			= rsConsulta("endereco_num")
					EnderecoComplemento		= rsConsulta("endereco_complemento")
					EnderecoCEP				= rsConsulta("endereco_cep")				
					EnderecoUF				= rsConsulta("estado_uf")													
					EnderecoMunicipio		= rsConsulta("municipio_cd")													
					EnderecoBairro			= rsConsulta("endereco_bairro")		
					
					If Fornecedor = "1" Then FornecedorMarcado = "checked" Else FornecedorMarcado = "" End If

					If StatusNumero = "0" Then StatusNome = "Ativo" Else StatusNome = "Inativo" End If																	

					sqlConsultaTelefone = "SELECT * FROM dados_unico.telefone WHERE pessoa_id = " & Codigo
					Set rsConsultaTelefone = objConexao.execute(sqlConsultaTelefone)
					
					If Not rsConsultaTelefone.eof Then
					
						While Not rsConsultaTelefone.eof 
						
							If rsConsultaTelefone("telefone_tipo") = "C" Then
								If TelefoneComercial1 = "" Then
									TelefoneDDDComercial1 	= rsConsultaTelefone("telefone_ddd")
									TelefoneComercial1 		= rsConsultaTelefone("telefone_num")
								Else
									TelefoneDDDComercial2 	= rsConsultaTelefone("telefone_ddd")
									TelefoneComercial2 		= rsConsultaTelefone("telefone_num")								
								End If									
							ElseIf rsConsultaTelefone("telefone_tipo") = "M" Then	
								TelefoneDDDCelular 		= rsConsultaTelefone("telefone_ddd")
								TelefoneCelular 		= rsConsultaTelefone("telefone_num")
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
			NomeFantasia			= UCase(replace(Trim(Request("txtNomeFantasia")),"'","''"))
			RazaoSocial				= UCase(replace(Trim(Request("txtRazao")),"'","''"))
			Tipo					= "J" 
			Email					= LCase(replace(Trim(Request("txtEmail")),"'","''"))
			DataAlteracao 			= Date
			Fornecedor				= Request("chkFornecedor")	
			CNPJ					= Request("txtCNPJ")				
			DataAbertura			= Request("txtData")
			IE						= Request("txtIE")				
			IM						= Request("txtIM")							
	
			Endereco				= UCase(replace(Trim(Request("txtEndereco")),"'","''"))			
			EnderecoNumero			= Request("txtNumero")
			EnderecoComplemento		= Request("txtComplemento")	
			EnderecoCEP				= Request("txtCEP")				
			EnderecoUF				= Request("cmbEnderecoUF")													
			EnderecoMunicipio		= Request("cmbEnderecoMunicipio")													
			EnderecoBairro			= UCase(replace(Trim(Request("txtEnderecoBairro")),"'","''"))		
			
			TelefoneDDDComercial1 	= Request("txtFoneDDDComercial1")
			TelefoneComercial1 		= Request("txtFoneComercial1")		
			TelefoneDDDComercial2 	= Request("txtFoneDDDComercial2")
			TelefoneComercial2	 	= Request("txtFoneComercial2")				
			TelefoneDDDFax 			= Request("txtFoneDDDFax")
			TelefoneFax 			= Request("txtFoneFax")	
			TelefoneDDDCelular 		= Request("txtFoneDDDCelular")
			TelefoneCelular 		= Request("txtFoneCelular")		
			Contato					= UCase(replace(Trim(Request("txtContato")),"'","''"))
			
			If Fornecedor = "on" Then Fornecedor = 1 Else Fornecedor = 0 End If											
		
			sqlConsultaExistente = "SELECT pessoa_id FROM dados_unico.pessoa_juridica WHERE pessoa_juridica_cnpj = '" & CNPJ & "' AND pessoa_id <> " & Codigo
			Set rsConsultaExistente = objConexao.execute(sqlConsultaExistente)	

			If rsConsultaExistente.eof Then
			
					objConexao.BeginTrans
	
					sqlAltera = "UPDATE dados_unico.pessoa SET " &_
										"pessoa_nm = '" & RazaoSocial & "', " &_
										"pessoa_email = '" & Email & "', " &_										
										"pessoa_dt_alteracao = '" & DataAlteracao & "' " &_										
										"WHERE pessoa_id = " & Codigo
										
					objConexao.execute(sqlAltera)
	
					sqlAltera = "UPDATE dados_unico.pessoa_juridica SET " &_
										"pessoa_juridica_cnpj = '" & CNPJ & "', " &_					
										"pessoa_juridica_nm_fantasia = '" & NomeFantasia & "', " &_					
										"pessoa_juridica_insc_mun = '" & IM & "', " &_					
										"pessoa_juridica_insc_est = '" & IE & "', " &_					
										"pessoa_juridica_dt_abertura = '" & DataAbertura & "', " &_																																													
										"pessoa_juridica_contato = '" & Contato & "', " &_																																													
										"pessoa_juridica_fornecedor = '" & Fornecedor & "' " &_																																																																																											
										"WHERE pessoa_id = " & Codigo
										
					objConexao.execute(sqlAltera)	
					
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
										"telefone_num = '" & TelefoneComercial1 & "', " &_ 					
										"telefone_ddd = '" & TelefoneDDDComercial1 & "' " &_ 
										"WHERE telefone_tipo = 'C' AND pessoa_id = " & Codigo
										
 					objConexao.execute(sqlAltera)
					
					sqlConsulta = "SELECT telefone_id FROM dados_unico.telefone WHERE telefone_num = '" & TelefoneComercial1 & "' AND pessoa_id = " & Codigo
 					Set rsConsulta = objConexao.execute(sqlConsulta)					

					sqlAltera = "UPDATE dados_unico.telefone SET " &_
										"telefone_num = '" & TelefoneComercial2 & "', " &_ 					
										"telefone_ddd = '" & TelefoneDDDComercial2 & "' " &_ 
										"WHERE telefone_tipo = 'C' AND telefone_id = " & rsConsulta("telefone_id")
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
							
					Response.Redirect "JuridicaInicio.asp"
	
			Else
	
					MensagemErroBD = "CNPJ já existente."
	
			End If	
		
		ElseIf AcaoSistema = "alterarStatus" Then
		
					DataAlteracao 	= Date
					Codigo 			= request.QueryString("cod")
					StatusCod		= request.QueryString("status")
					
					If StatusCod = 0 Then StatusCod = 1 Else StatusCod = 0 End If
									
					sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_st = " & StatusCod & ", pessoa_dt_alteracao = '" & DataAlteracao & "' WHERE pessoa_id = " & Codigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect "JuridicaInicio.asp"			
		
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
				
	
				Response.Redirect "JuridicaInicio.asp"
					
		End If
	


%>