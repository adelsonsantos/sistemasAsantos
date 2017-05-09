<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Simbolo"
		
		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = false			
	
		'variaveis de Simbolo
		Dim sqlConsulta, rsConsulta, sqlAltera, sqlDeleta, sqlInsere
		
		'variaveis da classe
		Dim numCodigo, strDescricao, numStatus, strStatus, strDataCriacao, strDataAlteracao, strValorDiaria, strSalario
		Dim CodigoRegistro, ExcluirCheckbox			

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
			
					If RetornoFiltro <> "" Then
						sqlConsulta = "SELECT * FROM dados_unico.simbolo WHERE simbolo_st <> 2 AND simbolo_id <> 0 AND simbolo_ds ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(simbolo_ds)"	
					Else
						sqlConsulta = "SELECT * FROM dados_unico.simbolo WHERE simbolo_st <> 2 AND simbolo_id <> 0 ORDER BY UPPER(simbolo_ds)"
					End If
					
					Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		
					strDataCriacao  = Date
					strDescricao	= UCase(Trim(request("txtSimbolo")))
					strValorDiaria	= Trim(Request("txtValor"))	
					strSalario		= Trim(Request("txtSalario"))						
					
					sqlConsulta = "SELECT simbolo_id FROM dados_unico.simbolo WHERE simbolo_st <> 2 AND UPPER(simbolo_ds) = '" & UCase(strDescricao) & "'"
					Set rsConsulta = objConexao.execute(sqlConsulta)	
					
					If rsConsulta.eof Then
						
						sqlInsere = "INSERT INTO dados_unico.simbolo (simbolo_ds, simbolo_valor_diaria, simbolo_dt_criacao, simbolo_salario) VALUES ('" & strDescricao & "', '" & strValorDiaria & "', '" & strDataCriacao & "','" & strSalario & "')"
						objConexao.execute(sqlInsere)
			
						Response.Redirect "SimboloInicio.asp"	
			
					Else	
						MensagemErroBD = "SÍMBOLO JÁ EXISTENTE."	
					End If				
	
		ElseIf AcaoSistema = "consultar" Then	
		
					numCodigo = Request.QueryString("cod")
					
					If numCodigo = "" Then
					
						numCodigo = Request("checkbox")
						
						sqlConsulta = "SELECT * FROM dados_unico.simbolo WHERE simbolo_id IN (" & numCodigo & ")"
					
					Else
						sqlConsulta = "SELECT * FROM dados_unico.simbolo WHERE simbolo_id = " & numCodigo
					End If					
			
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If Not rsConsulta.eof Then
			
						strDescricao	 = rsConsulta("simbolo_ds")
						strValorDiaria	 = rsConsulta("simbolo_valor_diaria")
						strSalario		 = rsConsulta("simbolo_salario")												
						numStatus	   	 = rsConsulta("simbolo_st")	
						strDataCriacao   = rsConsulta("simbolo_dt_criacao")	
						strDataAlteracao = rsConsulta("simbolo_dt_alteracao")
						
						If numStatus = "0" Then strStatus = "Ativo" Else strStatus = "Inativo" End If													
			
					End If	
							
		ElseIf AcaoSistema = "alterar" Then	

					strDataAlteracao= Date		
					numCodigo		= request("txtCodigo")
					strDescricao	= replace(UCase(Trim(Request("txtSimbolo"))),"'","''")	
					strValorDiaria	= Trim(Request("txtValor"))	
					strSalario		= Trim(Request("txtSalario"))											
					
					sqlConsulta = "SELECT simbolo_id FROM dados_unico.simbolo WHERE simbolo_st <> 2 AND UPPER(simbolo_ds) = '" & UCase(strDescricao) & "' AND simbolo_id <> " & numCodigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If rsConsulta.eof Then							
			
							sqlAltera = "UPDATE dados_unico.simbolo SET simbolo_salario = '" & strSalario & "', simbolo_valor_diaria = '" & strValorDiaria & "', simbolo_ds = '" & strDescricao & "', simbolo_dt_alteracao = '" & strDataAlteracao & "' WHERE simbolo_id = " & numCodigo
							objConexao.execute(sqlAltera)
								
							Response.Redirect "SimboloInicio.asp"	
			
					Else	
						MensagemErroBD = "SÍMBOLO JÁ EXISTENTE."	
					End If	
				
		ElseIf AcaoSistema = "alterarStatus" Then
		
					strDataAlteracao= Date
					numCodigo 		= request.QueryString("cod")
					numStatus 		= request.QueryString("status")
					
					If numStatus = 0 Then numStatus = 1 Else numStatus = 0 End If
									
					sqlAltera = "UPDATE dados_unico.simbolo SET simbolo_st = " & numStatus & ", simbolo_dt_alteracao = '" & strDataAlteracao & "' WHERE simbolo_id = " & numCodigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect "SimboloInicio.asp"	
			
		ElseIf AcaoSistema = "excluir" Then			
				
					ExcluirCheckbox = Request.QueryString("excluirMultiplo")
					
					If ExcluirCheckbox = 1 Then
						numCodigo = Request("txtCodigo")	
						sqlDeleta = "UPDATE dados_unico.simbolo SET simbolo_st = 2 WHERE simbolo_id IN (" & numCodigo & ")"
					Else		
						numCodigo = Request.QueryString("cod")		
						sqlDeleta = "UPDATE dados_unico.simbolo SET simbolo_st = 2  WHERE simbolo_id = " & numCodigo
					End If
		
					objConexao.execute(sqlDeleta)				
			
					Response.Redirect "SimboloInicio.asp"	
						
		End If
%>