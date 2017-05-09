<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Banco"
		
		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = 0			
	
		'variaveis de banco
		Dim sqlConsulta, sqlAltera, sqlDeleta, sqlInsere
		Dim rsConsulta
		
		'variaveis da classe
		Dim BancoCodigo, BancoNumero, BancoDescricao, BancoStatusCod, BancoStatus, strDataCriacao, strDataAlteracao, DataAlteracao, DataCriacao
		Dim CodigoRegistro, ExcluirCheckbox	
		
		'filtro por status
		Dim strAtivo, strInativo, strTodos, numFiltro, strStringSQL						

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
		
					numFiltro = Request.QueryString("filtro")
					
					If numFiltro <> "" Then
						strStringSQL = "banco_st = " & numFiltro
					Else
						strStringSQL = "banco_st <> 2"
					End If		
			
					If RetornoFiltro <> "" Then
						sqlConsulta = "SELECT * FROM dados_unico.banco WHERE " & strStringSQL & " AND banco_id <> 0 AND banco_ds ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(banco_ds)"	
					Else
						sqlConsulta = "SELECT * FROM dados_unico.banco WHERE " & strStringSQL & " AND banco_id <> 0 ORDER BY UPPER(banco_ds)"
					End If
					
					Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		
					DataCriacao 	= Date
					BancoNumero		= Trim(Request("txtBancoNumero"))	
					BancoDescricao	= replace(UCase(Trim(Request("txtBanco"))),"'","''")	
					
					sqlConsulta = "SELECT banco_id FROM dados_unico.banco WHERE banco_st <> 2 AND UPPER(banco_ds) = '" & UCase(BancoDescricao) & "' OR banco_cd = '" & BancoNumero & "'"
					Set rsConsulta = objConexao.execute(sqlConsulta)	
					
					If rsConsulta.eof Then
						
						sqlInsere = "INSERT INTO dados_unico.banco (banco_cd, banco_ds, banco_dt_criacao) VALUES ('" & BancoNumero & "', '" & BancoDescricao & "', '" & DataCriacao & "')"
						objConexao.execute(sqlInsere)
			
						Response.Redirect PaginaLocal & "Inicio.asp"	
			
					Else	
						MensagemErroBD = "NÚMERO OU BANCO JÁ EXISTENTES."	
					End If				
	
		ElseIf AcaoSistema = "consultar" Then	
		
					BancoCodigo = Request.QueryString("cod")
					
					If BancoCodigo = "" Then
					
						BancoCodigo = Request("checkbox")
						
						sqlConsulta = "SELECT * FROM dados_unico.banco WHERE banco_id IN (" & BancoCodigo & ")"
						
					Else
						sqlConsulta = "SELECT * FROM dados_unico.banco WHERE banco_id = " & BancoCodigo
					End If					
			
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If Not rsConsulta.eof Then
			
						BancoNumero	   	   = rsConsulta("banco_cd")
						BancoDescricao	   = rsConsulta("banco_ds")
						BancoStatusCod	   = rsConsulta("banco_st")	
						strDataCriacao   = rsConsulta("banco_dt_criacao")	
						strDataAlteracao = rsConsulta("banco_dt_alteracao")
						
						If BancoStatusCod = "0" Then BancoStatus = "Ativo" Else BancoStatus = "Inativo" End If													
			
					End If	
							
		ElseIf AcaoSistema = "alterar" Then	

					DataAlteracao	= Date		
					BancoCodigo		= request("txtCodigo")
					BancoNumero	   	= Trim(Request("txtBancoNumero"))
					BancoDescricao	= replace(UCase(Trim(Request("txtBanco"))),"'","''")	
					
					sqlConsulta = "SELECT banco_id FROM dados_unico.banco WHERE banco_st <> 2 AND (UPPER(banco_ds) = '" & UCase(BancoDescricao) & "' OR banco_cd = '" & BancoNumero & "') AND banco_id <> " & BancoCodigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If rsConsulta.eof Then							
			
							sqlAltera = "UPDATE dados_unico.banco SET banco_cd = '" & BancoNumero & "', banco_ds = '" & BancoDescricao & "', banco_dt_alteracao = '" & DataAlteracao & "' WHERE banco_id = " & BancoCodigo
							objConexao.execute(sqlAltera)
								
							Response.Redirect PaginaLocal & "Inicio.asp"	
			
					Else	
						MensagemErroBD = "NÚMERO OU BANCO JÁ EXISTENTES."	
					End If	
				
		ElseIf AcaoSistema = "alterarStatus" Then
		
					DataAlteracao 	= Date
					BancoCodigo 	= request.QueryString("cod")
					BancoStatusCod 	= request.QueryString("status")
					
					If BancoStatusCod = 0 Then BancoStatusCod = 1 Else BancoStatusCod = 0 End If
									
					sqlAltera = "UPDATE dados_unico.banco SET banco_st = " & BancoStatusCod & ", banco_dt_alteracao = '" & DataAlteracao & "' WHERE banco_id = " & BancoCodigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect PaginaLocal & "Inicio.asp"	
			
		ElseIf AcaoSistema = "excluir" Then			
				
					ExcluirCheckbox = Request.QueryString("excluirMultiplo")
					
					If ExcluirCheckbox = 1 Then
						BancoCodigo	= Request("txtCodigo")	
						sqlDeleta = "UPDATE dados_unico.banco SET banco_st = 2 WHERE banco_id IN (" & BancoCodigo & ")"
					Else		
						BancoCodigo	= Request.QueryString("cod")		
						sqlDeleta = "UPDATE dados_unico.banco SET banco_st = 2  WHERE banco_id = " & BancoCodigo
					End If
		
					objConexao.execute(sqlDeleta)				
			
					Response.Redirect PaginaLocal & "Inicio.asp"	
						
		End If
%>