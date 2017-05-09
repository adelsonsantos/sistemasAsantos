<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Orgao"
		
		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = 0			
	
		'variaveis de orgao
		Dim sqlConsulta, sqlAltera, sqlDeleta, sqlInsere
		Dim rsConsulta
		
		'variaveis da classe
		Dim OrgaoCodigo, OrgaoDescricao, OrgaoStatusCod, OrgaoStatus, OrgaoDataCriacao, OrgaoDataAlteracao, DataAlteracao, DataCriacao
		Dim CodigoRegistro, ExcluirCheckbox		
		
		'filtro por status
		Dim strAtivo, strInativo, strTodos, numFiltro, strStringSQL				

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then
		
			numFiltro = Request.QueryString("filtro")
			
			If numFiltro <> "" Then
				strStringSQL = "orgao_st = " & numFiltro
			Else
				strStringSQL = "orgao_st <> 2"
			End If
			' fim do filtro 		
			
			If RetornoFiltro <> "" Then
				sqlConsulta = "SELECT * FROM dados_unico.orgao WHERE " & strStringSQL & " AND orgao_id <> 0 AND orgao_ds ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(orgao_ds)"	
			Else
				sqlConsulta = "SELECT * FROM dados_unico.orgao WHERE " & strStringSQL & " AND orgao_id <> 0 ORDER BY UPPER(orgao_ds)"
			End If
			
			Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		
					DataCriacao 	= Date
					OrgaoDescricao	= replace(UCase(Trim(Request("txtOrgao"))),"'","''")	
					
					sqlConsulta = "SELECT orgao_id FROM dados_unico.orgao WHERE UPPER(orgao_ds) = '" & UCase(OrgaoDescricao) & "'"
					Set rsConsulta = objConexao.execute(sqlConsulta)	
					
					If rsConsulta.eof Then
						
						sqlInsere = "INSERT INTO dados_unico.orgao (orgao_ds, orgao_dt_criacao) VALUES ('" & OrgaoDescricao & "', '" & DataCriacao & "')"
						objConexao.execute(sqlInsere)
			
						Response.Redirect "OrgaoInicio.asp"	
			
					Else	
						MensagemErroBD = "ÓRGÃO JÁ EXISTENTE."	
					End If				
	
		ElseIf AcaoSistema = "consultar" Then	
		
					OrgaoCodigo = Request.QueryString("cod")
					
					If OrgaoCodigo = "" Then
					
						OrgaoCodigo = Request("checkbox")
						
						sqlConsulta = "SELECT * FROM dados_unico.orgao WHERE orgao_id IN (" & OrgaoCodigo & ")"
					
					Else
						sqlConsulta = "SELECT * FROM dados_unico.orgao WHERE orgao_id = " & OrgaoCodigo
					End If						
			
					
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If Not rsConsulta.eof Then
			
						OrgaoDescricao	   = rsConsulta("orgao_ds")
						OrgaoStatusCod	   = rsConsulta("orgao_st")	
						OrgaoDataCriacao   = rsConsulta("orgao_dt_criacao")	
						OrgaoDataAlteracao = rsConsulta("orgao_dt_alteracao")
						
						If OrgaoStatusCod = "0" Then OrgaoStatus = "Ativo" Else OrgaoStatus = "Inativo" End If													
			
					End If	
							
		ElseIf AcaoSistema = "alterar" Then	

					DataAlteracao	= Date		
					OrgaoCodigo		= request("txtCodigo")
					OrgaoDescricao	= replace(UCase(Trim(Request("txtOrgao"))),"'","''")	
					
					sqlConsulta = "SELECT orgao_id FROM dados_unico.orgao WHERE UPPER(orgao_ds) = '" & UCase(OrgaoDescricao) & "' AND orgao_id <> " & OrgaoCodigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If rsConsulta.eof Then							
			
							sqlAltera = "UPDATE dados_unico.orgao SET orgao_ds = '" & OrgaoDescricao & "', orgao_dt_alteracao = '" & DataAlteracao & "' WHERE orgao_id = " & OrgaoCodigo
							objConexao.execute(sqlAltera)
								
							Response.Redirect "OrgaoInicio.asp"	
			
					Else	
						MensagemErroBD = "ÓRGÃO JÁ EXISTENTE."	
					End If	
				
		ElseIf AcaoSistema = "alterarStatus" Then
		
					DataAlteracao 	= Date
					OrgaoCodigo 	= request.QueryString("cod")
					OrgaoStatusCod 	= request.QueryString("status")
					
					If OrgaoStatusCod = 0 Then OrgaoStatusCod = 1 Else OrgaoStatusCod = 0 End If
									
					sqlAltera = "UPDATE dados_unico.orgao SET orgao_st = " & OrgaoStatusCod & ", orgao_dt_alteracao = '" & DataAlteracao & "' WHERE orgao_id = " & OrgaoCodigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect "OrgaoInicio.asp"	
			
		ElseIf AcaoSistema = "excluir" Then			
				
					ExcluirCheckbox = Request.QueryString("excluirMultiplo")
					
					If ExcluirCheckbox = 1 Then
						OrgaoCodigo	= Request("txtCodigo")	
						sqlDeleta = "UPDATE dados_unico.orgao SET orgao_st = 2 WHERE orgao_id IN (" & OrgaoCodigo & ")"
					Else		
						OrgaoCodigo	= Request.QueryString("cod")		
						sqlDeleta = "UPDATE dados_unico.orgao SET orgao_st = 2  WHERE orgao_id = " & OrgaoCodigo
					End If
		
					objConexao.execute(sqlDeleta)				
			
					Response.Redirect "OrgaoInicio.asp"	
						
		End If
%>