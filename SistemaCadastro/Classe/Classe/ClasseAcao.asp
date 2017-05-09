<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Acao"
		
		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = false			
	
		'variaveis de acao
		Dim sqlConsulta, rsConsulta, sqlAltera, sqlDeleta, sqlInsere
		
		'variaveis da classe
		Dim numCodigo, numSistema, strSistema, strSecao, strDescricao, numStatus, strStatus, numSecao, strDataCriacao, strDataAlteracao, strURL
		Dim CodigoRegistro, ExcluirCheckbox			

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
			
					If RetornoFiltro <> "" Then
						sqlConsulta = "SELECT * FROM seguranca.secao se, seguranca.acao ac, seguranca.sistema si WHERE (ac.secao_id = se.secao_id) AND (se.sistema_id = si.sistema_id) AND acao_st <> 2 AND acao_id <> 0 AND acao_ds ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(sistema_nm), UPPER(secao_ds), UPPER(acao_ds)"	
					Else
						sqlConsulta = "SELECT * FROM seguranca.secao se, seguranca.acao ac, seguranca.sistema si WHERE (ac.secao_id = se.secao_id) AND (se.sistema_id = si.sistema_id) AND acao_st <> 2 AND acao_id <> 0 ORDER BY UPPER(sistema_nm), UPPER(secao_ds), UPPER(acao_ds)"
					End If

					Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		
					strDataCriacao 	= Date
					numSistema		= request("cmbSistema")
					numSecao		= request("cmbSecao")					
					strDescricao	= replace(Trim(Request("txtDescricao")),"'","''")
					strURL			= replace(LCase(Trim(Request("txtURL"))),"'","''")
					
					sqlConsulta = "SELECT acao_id FROM seguranca.acao WHERE acao_st <> 2 AND UPPER(acao_ds) = '" & UCase(strDescricao) & "' AND secao_id = " & numSecao
					Set rsConsulta = objConexao.execute(sqlConsulta)	
					
					If rsConsulta.eof Then
						
						sqlInsere = "INSERT INTO seguranca.acao (acao_ds, secao_id, acao_url, acao_dt_criacao) VALUES ('" & strDescricao & "', " & numSecao & ", '" & strURL & "', '" & strDataCriacao & "')"
						objConexao.execute(sqlInsere)
			
						Response.Redirect "AcaoInicio.asp"	
			
					Else	
						MensagemErroBD = "A플O J� EXISTENTE."	
					End If				
	
		ElseIf AcaoSistema = "consultar" Then	
		
					numCodigo = Request.QueryString("cod")
			
					sqlConsulta = "SELECT * FROM seguranca.acao ac, seguranca.secao se, seguranca.sistema si WHERE (si.sistema_id = se.sistema_id) AND (se.secao_id = ac.secao_id) AND acao_id = " & numCodigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If Not rsConsulta.eof Then
			
						numSistema	   	 = rsConsulta("sistema_id")
						strSistema	   	 = rsConsulta("sistema_nm")	
						numSecao	   	 = rsConsulta("secao_id")
						strSecao	   	 = rsConsulta("secao_ds")												
						strDescricao	 = rsConsulta("acao_ds")
						numStatus	     = rsConsulta("acao_st")
						strURL			 = rsConsulta("acao_url")
						strDataCriacao   = rsConsulta("acao_dt_criacao")	
						strDataAlteracao = rsConsulta("acao_dt_alteracao")
						
						If numStatus = "0" Then strStatus = "Ativo" Else strStatus = "Inativo" End If													
			
					End If	
							
		ElseIf AcaoSistema = "alterar" Then	

					strDataAlteracao= Date		
					numCodigo		= request("txtCodigo")
					numSistema		= request("cmbSistema")		
					strDescricao	= replace(Trim(Request("txtDescricao")),"'","''")						
					
					sqlConsulta = "SELECT acao_id FROM seguranca.acao WHERE acao_st <> 2 AND acao_ds = '" & UCase(strDescricao) & "' AND sistema_id = " & numSistema & " AND acao_id <> " & numCodigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If rsConsulta.eof Then							
			
							sqlAltera = "UPDATE seguranca.acao SET sistema_id = '" & numSistema & "', acao_ds = '" & strDescricao & "', acao_dt_alteracao = '" & strDataAlteracao & "' WHERE acao_id = " & numCodigo
							objConexao.execute(sqlAltera)
								
							Response.Redirect "AcaoInicio.asp"	
			
					Else	
						MensagemErroBD = "SE플O J� EXISTENTE."	
					End If	
				
		ElseIf AcaoSistema = "alterarStatus" Then
		
					strDataAlteracao = Date
					numCodigo 		 = request.QueryString("cod")
					numStatus 		 = request.QueryString("status")
					
					If numStatus = 0 Then numStatus = 1 Else numStatus = 0 End If
									
					sqlAltera = "UPDATE seguranca.acao SET acao_st = " & numStatus & ", acao_dt_alteracao = '" & strDataAlteracao & "' WHERE acao_id = " & numCodigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect "AcaoInicio.asp"	
			
		ElseIf AcaoSistema = "excluir" Then			
				
					ExcluirCheckbox = Request.QueryString("excluirMultiplo")
					
					If ExcluirCheckbox = 1 Then
						numCodigo	= Request("txtCodigo")	
						sqlDeleta = "UPDATE seguranca.acao SET acao_st = 2 WHERE acao_id IN (" & numCodigo & ")"
					Else		
						numCodigo	= Request.QueryString("cod")		
						sqlDeleta = "UPDATE seguranca.acao SET acao_st = 2  WHERE acao_id = " & numCodigo
					End If
		
					objConexao.execute(sqlDeleta)				
			
					Response.Redirect "AcaoInicio.asp"	
						
		End If
%>