<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Secao"
		
		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = false			
	
		'variaveis de secao
		Dim sqlConsulta, rsConsulta, sqlAltera, sqlDeleta, sqlInsere
		
		'variaveis da classe
		Dim numCodigo, numSistema, strSistema, strDescricao, numStatus, strStatus, strDataCriacao, strDataAlteracao
		Dim CodigoRegistro, ExcluirCheckbox			

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
			
					If RetornoFiltro <> "" Then
						sqlConsulta = "SELECT * FROM seguranca.secao se, seguranca.sistema si WHERE (se.sistema_id = si.sistema_id) AND secao_st <> 2 AND secao_id <> 0 AND secao_ds ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(sistema_nm), UPPER(secao_ds)"	
					Else
						sqlConsulta = "SELECT * FROM seguranca.secao se, seguranca.sistema si WHERE (se.sistema_id = si.sistema_id) AND secao_st <> 2 AND secao_id <> 0 ORDER BY UPPER(sistema_nm), UPPER(secao_ds)"
					End If

					Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		
					strDataCriacao 	= Date
					numSistema		= request("cmbSistema")
					strDescricao	= replace(Trim(Request("txtDescricao")),"'","''")
					
					sqlConsulta = "SELECT secao_id FROM seguranca.secao WHERE secao_st <> 2 AND UPPER(secao_ds) = '" & UCase(strDescricao) & "' AND sistema_id = " & numSistema
					Set rsConsulta = objConexao.execute(sqlConsulta)	
					
					If rsConsulta.eof Then
						
						sqlInsere = "INSERT INTO seguranca.secao (secao_ds, sistema_id, secao_dt_criacao) VALUES ('" & strDescricao & "', '" & numSistema & "', '" & strDataCriacao & "')"
						objConexao.execute(sqlInsere)
			
						Response.Redirect "SecaoInicio.asp"	
			
					Else	
						MensagemErroBD = "SE플O J� EXISTENTE."	
					End If				
	
		ElseIf AcaoSistema = "consultar" Then	
		
					numCodigo = Request.QueryString("cod")
			
					sqlConsulta = "SELECT * FROM seguranca.secao se, seguranca.sistema si WHERE (se.sistema_id = si.sistema_id) AND secao_id = " & numCodigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If Not rsConsulta.eof Then
			
						numSistema	   	 = rsConsulta("sistema_id")
						strSistema	   	 = rsConsulta("sistema_nm")						
						strDescricao	 = rsConsulta("secao_ds")
						numStatus	     = rsConsulta("secao_st")	
						strDataCriacao   = rsConsulta("secao_dt_criacao")	
						strDataAlteracao = rsConsulta("secao_dt_alteracao")
						
						If numStatus = "0" Then strStatus = "Ativo" Else strStatus = "Inativo" End If													
			
					End If	
							
		ElseIf AcaoSistema = "alterar" Then	

					strDataAlteracao= Date		
					numCodigo		= request("txtCodigo")
					numSistema		= request("cmbSistema")		
					strDescricao	= replace(Trim(Request("txtDescricao")),"'","''")						
					
					sqlConsulta = "SELECT secao_id FROM seguranca.secao WHERE secao_st <> 2 AND secao_ds = '" & UCase(strDescricao) & "' AND sistema_id = " & numSistema & " AND secao_id <> " & numCodigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If rsConsulta.eof Then							
			
							sqlAltera = "UPDATE seguranca.secao SET sistema_id = '" & numSistema & "', secao_ds = '" & strDescricao & "', secao_dt_alteracao = '" & strDataAlteracao & "' WHERE secao_id = " & numCodigo
							objConexao.execute(sqlAltera)
								
							Response.Redirect "SecaoInicio.asp"	
			
					Else	
						MensagemErroBD = "SE플O J� EXISTENTE."	
					End If	
				
		ElseIf AcaoSistema = "alterarStatus" Then
		
					strDataAlteracao = Date
					numCodigo 		 = request.QueryString("cod")
					numStatus 		 = request.QueryString("status")
					
					If numStatus = 0 Then numStatus = 1 Else numStatus = 0 End If
									
					sqlAltera = "UPDATE seguranca.secao SET secao_st = " & numStatus & ", secao_dt_alteracao = '" & strDataAlteracao & "' WHERE secao_id = " & numCodigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect "SecaoInicio.asp"	
			
		ElseIf AcaoSistema = "excluir" Then			
				
					ExcluirCheckbox = Request.QueryString("excluirMultiplo")
					
					If ExcluirCheckbox = 1 Then
						numCodigo	= Request("txtCodigo")	
						sqlDeleta = "UPDATE seguranca.secao SET secao_st = 2 WHERE secao_id IN (" & numCodigo & ")"
					Else		
						numCodigo	= Request.QueryString("cod")		
						sqlDeleta = "UPDATE seguranca.secao SET secao_st = 2  WHERE secao_id = " & numCodigo
					End If
		
					objConexao.execute(sqlDeleta)				
			
					Response.Redirect "SecaoInicio.asp"	
						
		End If
%>