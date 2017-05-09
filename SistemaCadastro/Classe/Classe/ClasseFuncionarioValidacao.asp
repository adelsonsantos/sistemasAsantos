<% 	
	'controla a visibilidade do botao consultar
	Session("BotaoConsultar") = 1	


	If AcaoSistema = "consultar" Then	
	
			Codigo = CodigoValidacao
			
			sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E, dados_unico.funcionario F, dados_unico.est_organizacional_funcionario EF WHERE est_organizacional_funcionario_st = 0 AND (F.funcionario_id = EF.funcionario_id) AND (PF.pessoa_id = F.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND (P.pessoa_id = PF.pessoa_id) AND P.pessoa_id = " & Codigo
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
										
 					objConexao.execute(sqlAltera)
					
					'residencial
					sql = "select * from dados_unico.telefone where telefone_tipo = 'R' AND pessoa_id = " & Codigo
					Set rs = objConexao.execute(sql)
					
					If Not rs.eof Then
				
						sqlAltera = "UPDATE dados_unico.telefone SET " &_
											"telefone_num = '" & TelefoneResidencial & "', " &_ 					
											"telefone_ddd = '" & TelefoneDDDResidencial & "' " &_ 
											"WHERE telefone_tipo = 'R' AND pessoa_id = " & Codigo
											
						objConexao.execute(sqlAltera)
						
					Else
					
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & Codigo & ",'" & TelefoneResidencial & "', '" & TelefoneDDDResidencial & "', 'R')"
						objConexao.execute(sqlInsere)					
					
					End If
					
					'comercial
					sql = "select * from dados_unico.telefone where telefone_tipo = 'C' AND pessoa_id = " & Codigo
					Set rs = objConexao.execute(sql)
					
					If Not rs.eof Then
				
						sqlAltera = "UPDATE dados_unico.telefone SET " &_
											"telefone_num = '" & TelefoneComercial & "', " &_ 					
											"telefone_ddd = '" & TelefoneDDDComercial & "' " &_ 
											"WHERE telefone_tipo = 'C' AND pessoa_id = " & Codigo
											
						objConexao.execute(sqlAltera)
						
					Else
					
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & Codigo & ",'" & TelefoneComercial & "', '" & TelefoneDDDComercial & "', 'C')"
						objConexao.execute(sqlInsere)					
					
					End If					

					'celular
					sql = "select * from dados_unico.telefone where telefone_tipo = 'M' AND pessoa_id = " & Codigo
					Set rs = objConexao.execute(sql)
					
					If Not rs.eof Then
				
						sqlAltera = "UPDATE dados_unico.telefone SET " &_
											"telefone_num = '" & TelefoneCelular & "', " &_ 					
											"telefone_ddd = '" & TelefoneDDDCelular & "' " &_ 
											"WHERE telefone_tipo = 'M' AND pessoa_id = " & Codigo
											
						objConexao.execute(sqlAltera)
						
					Else
					
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & Codigo & ",'" & TelefoneCelular & "', '" & TelefoneDDDCelular & "', 'M')"
						objConexao.execute(sqlInsere)					
					
					End If		
					
					'fax
					sql = "select * from dados_unico.telefone where telefone_tipo = 'F' AND pessoa_id = " & Codigo
					Set rs = objConexao.execute(sql)
					
					If Not rs.eof Then
				
						sqlAltera = "UPDATE dados_unico.telefone SET " &_
											"telefone_num = '" & TelefoneFAX & "', " &_ 					
											"telefone_ddd = '" & TelefoneDDDFAX & "' " &_ 
											"WHERE telefone_tipo = 'F' AND pessoa_id = " & Codigo
											
						objConexao.execute(sqlAltera)
						
					Else
					
						sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" & Codigo & ",'" & TelefoneFAX & "', '" & TelefoneDDDFAX & "', 'F')"
						objConexao.execute(sqlInsere)					
					
					End If															
										
					sqlAltera = "UPDATE dados_unico.funcionario SET " &_
										"funcionario_matricula = '" & Matricula & "', " &_ 										
										"funcionario_email = '" & FuncionarioEmail & "', " &_ 							
										"funcionario_dt_admissao = '" & DataAdmissao & "', " &_ 							
										"funcionario_dt_demissao = '" & DataDemissao & "', " &_ 																																	
										"funcionario_conta_fgts = '" & FGTS & "', " &_ 																	
										"funcionario_validacao_propria = 1" &_
										"WHERE pessoa_id = " & Codigo
										
 					objConexao.execute(sqlAltera)

					
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
	
					response.redirect "ValidacaoSucesso.asp"
						
			Else
	
					MensagemErroBD = "CPF ou Matrícula já existente."
	
			End If	
		
					
		End If
	


%>