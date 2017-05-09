<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Sistema"
		
		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = false			
	
		'variaveis de sistema
		Dim sqlConsulta, rsConsulta, sqlAltera, sqlDeleta, sqlInsere
		
		'variaveis da classe
		Dim numCodigo, numSimbolo, strIcone, strDescricao, numStatus, strStatus, strDataCriacao, strDataAlteracao, strURL
		Dim CodigoRegistro, ExcluirCheckbox			

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
			
					If RetornoFiltro <> "" Then
						sqlConsulta = "SELECT * FROM seguranca.sistema WHERE sistema_st <> 2 AND sistema_ds ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(sistema_ds)"	
					Else
						sqlConsulta = "SELECT * FROM seguranca.sistema WHERE sistema_st <> 2 ORDER BY UPPER(sistema_ds)"
					End If
					
					Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		

				
					strDataCriacao 	= Date
		
					strDescricao	= replace(UCase(Trim(strDescricao)),"'","''")
					
					sqlConsulta = "SELECT sistema_id FROM seguranca.sistema WHERE sistema_st <> 2 AND UPPER(sistema_ds) = '" & UCase(strDescricao) & "'"
					Set rsConsulta = objConexao.execute(sqlConsulta)	
					
					If rsConsulta.eof Then
						
						sqlInsere = "INSERT INTO seguranca.sistema (sistema_ds, simbolo_id, sistema_dt_criacao) VALUES ('" & strDescricao & "', '" & numSimbolo & "', '" & strDataCriacao & "')"
						objConexao.execute(sqlInsere)
			
						Response.Redirect "SistemaInicio.asp"	
			
					Else	
						MensagemErroBD = "CARGO JÁ EXISTENTE."	
					End If				
	
		ElseIf AcaoSistema = "consultar" Then	
		

							
		ElseIf AcaoSistema = "alterar" Then	

				
		ElseIf AcaoSistema = "alterarStatus" Then
		

			
		ElseIf AcaoSistema = "excluir" Then			
				

						
		End If
%>