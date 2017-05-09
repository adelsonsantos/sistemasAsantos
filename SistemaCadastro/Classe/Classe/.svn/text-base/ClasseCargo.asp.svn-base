<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Cargo"
		
		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = false			
	
		'variaveis de cargo
		Dim sqlConsulta, rsConsulta, sqlAltera, sqlDeleta, sqlInsere
		
		'variaveis da classe
		Dim numTipo, strTipo
		Dim numCodigo, numClasse, strClasse, strDescricao, numStatus, strStatus, strDataCriacao, strDataAlteracao
		Dim CodigoRegistro, ExcluirCheckbox		
		
		'filtro por status
		Dim strAtivo, strInativo, strTodos, numFiltro, strStringSQL				

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
		
			numFiltro = Request.QueryString("filtro")
			
					If numFiltro <> "" Then
						strStringSQL = "cargo_st = " & numFiltro
					Else
						strStringSQL = "cargo_st <> 2"
					End If		
			
					If RetornoFiltro <> "" Then
						sqlConsulta = "SELECT * FROM dados_unico.cargo c, diaria.classe cl, dados_unico.funcionario_tipo ft WHERE (c.funcionario_tipo_id = ft.funcionario_tipo_id) AND (c.classe_id = cl.classe_id) AND " & strStringSQL & " AND cargo_id <> 0 AND cargo_ds ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(cargo_ds)"	
					Else
						sqlConsulta = "SELECT * FROM dados_unico.cargo c, diaria.classe cl, dados_unico.funcionario_tipo ft WHERE (c.funcionario_tipo_id = ft.funcionario_tipo_id) AND (c.classe_id = cl.classe_id) AND " & strStringSQL & " AND cargo_id <> 0 ORDER BY UPPER(cargo_ds)"
					End If

					Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		
					numTipo			= request("cmbFuncionarioTipo")
					numClasse		= request("cmbClasse")
					strDescricao	= replace(UCase(Trim(Request("txtDescricao"))),"'","''")
					
					sqlConsulta 	= "SELECT cargo_id FROM dados_unico.cargo WHERE cargo_st <> 2 AND UPPER(cargo_ds) = '" & UCase(strDescricao) & "' AND classe_id = " & numClasse
					Set rsConsulta  = objConexao.execute(sqlConsulta)	
					
					If rsConsulta.eof Then
						
						sqlInsere = "INSERT INTO dados_unico.cargo (cargo_ds, classe_id, cargo_dt_criacao, funcionario_tipo_id) VALUES ('" & strDescricao & "', '" & numClasse & "', '" & Date & "', " & numTipo & ")"
						objConexao.execute(sqlInsere)
			
						Response.Redirect "CargoInicio.asp"	
			
					Else	
						MensagemErroBD = "CARGO JÁ EXISTENTE."	
					End If				
	
		ElseIf AcaoSistema = "consultar" Then	
		
					numCodigo = Request.QueryString("cod")
					
					If numCodigo = "" Then
					
						numCodigo = Request("checkbox")
						
						sqlConsulta = "SELECT * FROM dados_unico.cargo c, diaria.classe cl, dados_unico.funcionario_tipo ft WHERE (c.funcionario_tipo_id = ft.funcionario_tipo_id) AND c.classe_id = cl.classe_id) AND cargo_id IN (" & numCodigo & ")"
					
					Else
						sqlConsulta = "SELECT * FROM dados_unico.cargo c, diaria.classe cl, dados_unico.funcionario_tipo ft WHERE (c.funcionario_tipo_id = ft.funcionario_tipo_id) AND (c.classe_id = cl.classe_id) AND cargo_id = " & numCodigo
					End If						
			
					
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If Not rsConsulta.eof Then
			
						numClasse	   	 = rsConsulta("classe_id")
						strClasse	   	 = "Classe " & rsConsulta("classe_nm")	
						numTipo			 = rsConsulta("funcionario_tipo_id")	
						strTipo			 = rsConsulta("funcionario_tipo_ds")													
						strDescricao	 = rsConsulta("cargo_ds")
						numStatus	     = rsConsulta("cargo_st")	
						strDataCriacao   = rsConsulta("cargo_dt_criacao")	
						strDataAlteracao = rsConsulta("cargo_dt_alteracao")
						
						If numStatus = "0" Then strStatus = "Ativo" Else strStatus = "Inativo" End If													
			
					End If	
							
		ElseIf AcaoSistema = "alterar" Then	

					numCodigo		= request("txtCodigo")
					numTipo			= request("cmbFuncionarioTipo")
					numClasse		= request("cmbClasse")		
					strDescricao	= replace(UCase(Trim(Request("txtDescricao"))),"'","''")						
					
					sqlConsulta 	= "SELECT cargo_id FROM dados_unico.cargo WHERE cargo_st <> 2 AND UPPER(cargo_ds) = '" & UCase(strDescricao) & "' AND classe_id = " & numClasse & " AND cargo_id <> " & numCodigo
					Set rsConsulta  = objConexao.execute(sqlConsulta)
			
					If rsConsulta.eof Then							
			
							sqlAltera = "UPDATE dados_unico.cargo SET funcionario_tipo_id = " & numTipo & ", classe_id = '" & numClasse & "', cargo_ds = '" & strDescricao & "', cargo_dt_alteracao = '" & Date & "' WHERE cargo_id = " & numCodigo
							objConexao.execute(sqlAltera)
								
							Response.Redirect "CargoInicio.asp"	
			
					Else	
						MensagemErroBD = "CARGO JÁ EXISTENTE."	
					End If	
				
		ElseIf AcaoSistema = "alterarStatus" Then
		
					numCodigo 		 = request.QueryString("cod")
					numStatus 		 = request.QueryString("status")
					
					If numStatus = 0 Then numStatus = 1 Else numStatus = 0 End If
									
					sqlAltera = "UPDATE dados_unico.cargo SET cargo_st = " & numStatus & ", cargo_dt_alteracao = '" & Date & "' WHERE cargo_id = " & numCodigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect "CargoInicio.asp"	
			
		ElseIf AcaoSistema = "excluir" Then			
				
					ExcluirCheckbox = Request.QueryString("excluirMultiplo")
					
					If ExcluirCheckbox = 1 Then
						numCodigo	= Request("txtCodigo")	
						sqlDeleta = "UPDATE dados_unico.cargo SET cargo_st = 2 WHERE cargo_id IN (" & numCodigo & ")"
					Else		
						numCodigo	= Request.QueryString("cod")		
						sqlDeleta = "UPDATE dados_unico.cargo SET cargo_st = 2  WHERE cargo_id = " & numCodigo
					End If
		
					objConexao.execute(sqlDeleta)				
			
					Response.Redirect "CargoInicio.asp"	
						
		End If
%>