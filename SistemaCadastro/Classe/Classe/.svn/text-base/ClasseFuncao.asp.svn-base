<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Funcao"
		
		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = 0			
	
		'variaveis de funcao
		Dim sqlConsulta, sqlAltera, sqlDeleta, sqlInsere
		Dim rsConsulta
		
		'variaveis da classe
		Dim FuncaoCodigo, FuncaoDescricao, FuncaoStatusCod, FuncaoStatus, FuncaoDataCriacao, FuncaoDataAlteracao, DataAlteracao, DataCriacao
		Dim CodigoRegistro, ExcluirCheckbox		
		
		'filtro por status
		Dim strAtivo, strInativo, strTodos, numFiltro, strStringSQL				

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
		
					numFiltro = Request.QueryString("filtro")
					
					If numFiltro <> "" Then
						strStringSQL = "funcao_st = " & numFiltro
					Else
						strStringSQL = "funcao_st <> 2"
					End If
					' fim do filtro 		
			
					If RetornoFiltro <> "" Then
						sqlConsulta = "SELECT * FROM dados_unico.funcao WHERE " & strStringSQL & " AND funcao_id <> 0 AND funcao_ds ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(funcao_ds)"	
					Else
						sqlConsulta = "SELECT * FROM dados_unico.funcao WHERE " & strStringSQL & " AND funcao_id <> 0 ORDER BY UPPER(funcao_ds)"
					End If
					
					Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		
					DataCriacao 	= Date
					FuncaoDescricao	= replace(Trim(UCase(Request("txtFuncao"))),"'","''")	
					
					sqlConsulta = "SELECT funcao_id FROM dados_unico.funcao WHERE UPPER(funcao_ds) = '" & UCase(FuncaoDescricao) & "'"
					Set rsConsulta = objConexao.execute(sqlConsulta)	
					
					If rsConsulta.eof Then
						
						sqlInsere = "INSERT INTO dados_unico.funcao (funcao_ds, funcao_dt_criacao) VALUES ('" & FuncaoDescricao & "', '" & DataCriacao & "')"
						objConexao.execute(sqlInsere)
			
						Response.Redirect "FuncaoInicio.asp"	
			
					Else	
						MensagemErroBD = "FUN플O J� EXISTENTE."	
					End If				
	
		ElseIf AcaoSistema = "consultar" Then	
		
					FuncaoCodigo = Request.QueryString("cod")
					
					If FuncaoCodigo = "" Then
					
						FuncaoCodigo = Request("checkbox")
						
						sqlConsulta = "SELECT * FROM dados_unico.funcao WHERE funcao_id IN (" & FuncaoCodigo & ")"
					
					Else
						sqlConsulta = "SELECT * FROM dados_unico.funcao WHERE funcao_id = " & FuncaoCodigo
					End If							
			
					
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If Not rsConsulta.eof Then
			
						FuncaoDescricao	   = rsConsulta("funcao_ds")
						FuncaoStatusCod	   = rsConsulta("funcao_st")	
						FuncaoDataCriacao   = rsConsulta("funcao_dt_criacao")	
						FuncaoDataAlteracao = rsConsulta("funcao_dt_alteracao")
						
						If FuncaoStatusCod = "0" Then FuncaoStatus = "Ativo" Else FuncaoStatus = "Inativo" End If													
			
					End If	
							
		ElseIf AcaoSistema = "alterar" Then	

					DataAlteracao	= Date		
					FuncaoCodigo	= request("txtCodigo")
					FuncaoDescricao	= replace(Trim(UCase(Request("txtFuncao"))),"'","''")
					
					sqlConsulta = "SELECT funcao_id FROM dados_unico.funcao WHERE UPPER(funcao_ds) = '" & UCase(FuncaoDescricao) & "' AND funcao_id <> " & FuncaoCodigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
					
					If rsConsulta.eof Then							
			
							sqlAltera = "UPDATE dados_unico.funcao SET funcao_ds = '" & FuncaoDescricao & "', funcao_dt_alteracao = '" & DataAlteracao & "' WHERE funcao_id = " & FuncaoCodigo
							objConexao.execute(sqlAltera)
								
							Response.Redirect "FuncaoInicio.asp"	
			
					Else	
						MensagemErroBD = "FUN플O J� EXISTENTE."	
					End If	
				
		ElseIf AcaoSistema = "alterarStatus" Then
		
					DataAlteracao 	= Date
					FuncaoCodigo 	= request.QueryString("cod")
					FuncaoStatusCod = request.QueryString("status")
					
					If FuncaoStatusCod = 0 Then FuncaoStatusCod = 1 Else FuncaoStatusCod = 0 End If
									
					sqlAltera = "UPDATE dados_unico.funcao SET funcao_st = " & FuncaoStatusCod & ", funcao_dt_alteracao = '" & DataAlteracao & "' WHERE funcao_id = " & FuncaoCodigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect "FuncaoInicio.asp"	
			
		ElseIf AcaoSistema = "excluir" Then			
				
					ExcluirCheckbox = Request.QueryString("excluirMultiplo")
					
					If ExcluirCheckbox = 1 Then
						FuncaoCodigo	= Request("txtCodigo")	
						sqlDeleta = "UPDATE dados_unico.funcao SET funcao_st = 2 WHERE funcao_id IN (" & FuncaoCodigo & ")"
					Else		
						FuncaoCodigo	= Request.QueryString("cod")		
						sqlDeleta = "UPDATE dados_unico.funcao SET funcao_st = 2  WHERE funcao_id = " & FuncaoCodigo
					End If
		
					objConexao.execute(sqlDeleta)				
			
					Response.Redirect "FuncaoInicio.asp"	
						
		End If
%>