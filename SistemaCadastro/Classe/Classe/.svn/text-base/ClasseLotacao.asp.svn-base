<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Lotacao"

		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = 0	
			
		'variaveis de lotacao
		Dim sqlConsulta, sqlAltera, sqlDeleta, sqlInsere
		Dim rsConsulta
		
		'variaveis da classe
		Dim LotacaoCodigo, LotacaoOrgao, OrgaoNome, LotacaoDescricao, LotacaoStatusCod, LotacaoStatus, LotacaoDataCriacao, LotacaoDataAlteracao, DataAlteracao, DataCriacao
		Dim CodigoRegistro, ExcluirCheckbox		
		
		'filtro por status
		Dim strAtivo, strInativo, strTodos, numFiltro, strStringSQL			

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
		
					numFiltro = Request.QueryString("filtro")
					
					If numFiltro <> "" Then
						strStringSQL = "lotacao_st = " & numFiltro
					Else
						strStringSQL = "lotacao_st <> 2"
					End If
					' fim do filtro 		
			
					If RetornoFiltro <> "" Then
						sqlConsulta = "SELECT * FROM dados_unico.lotacao l, dados_unico.orgao o WHERE (o.orgao_id = l.orgao_id) AND " & strStringSQL & " AND lotacao_id <> 0 AND lotacao_ds ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(lotacao_ds)"	
					Else
						sqlConsulta = "SELECT * FROM dados_unico.lotacao l, dados_unico.orgao o WHERE (o.orgao_id = l.orgao_id) AND " & strStringSQL & " AND lotacao_id <> 0 ORDER BY UPPER(lotacao_ds)"
					End If
					
					Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		
					DataCriacao 		= Date
					LotacaoOrgao		= Request("cmbOrgao")	
					LotacaoDescricao	= replace(UCase(Trim(Request("txtLotacao"))),"'","''")
					
					sqlConsulta = "SELECT lotacao_id FROM dados_unico.lotacao WHERE UPPER(lotacao_ds) = '" & UCase(LotacaoDescricao) & "' AND orgao_id = " & LotacaoOrgao
					Set rsConsulta = objConexao.execute(sqlConsulta)	
					
					If rsConsulta.eof Then
						
						sqlInsere = "INSERT INTO dados_unico.lotacao (lotacao_ds, orgao_id, lotacao_dt_criacao) VALUES ('" & LotacaoDescricao & "', " & LotacaoOrgao & ", '" & DataCriacao & "')"
						objConexao.execute(sqlInsere)
			
						Response.Redirect "LotacaoInicio.asp"	
			
					Else	
						MensagemErroBD = "LOTA플O J� EXISTENTE."	
					End If				
	
		ElseIf AcaoSistema = "consultar" Then	
		
					LotacaoCodigo = Request.QueryString("cod")
					
					If LotacaoCodigo = "" Then
					
						LotacaoCodigo = Request("checkbox")
						
						sqlConsulta = "SELECT * FROM dados_unico.lotacao l, dados_unico.orgao o WHERE (o.orgao_id = l.orgao_id) AND lotacao_id IN (" & LotacaoCodigo & ")"
					
					Else
						sqlConsulta = "SELECT * FROM dados_unico.lotacao l, dados_unico.orgao o WHERE (o.orgao_id = l.orgao_id) AND lotacao_id = " & LotacaoCodigo
					End If						
			
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If Not rsConsulta.eof Then
			
						LotacaoOrgao	   		= rsConsulta("orgao_id")
						OrgaoNome				= rsConsulta("orgao_ds")
						LotacaoDescricao	   	= rsConsulta("lotacao_ds")
						LotacaoStatusCod	   	= rsConsulta("lotacao_st")	
						LotacaoDataCriacao   	= rsConsulta("lotacao_dt_criacao")	
						LotacaoDataAlteracao 	= rsConsulta("lotacao_dt_alteracao")
						
						If LotacaoStatusCod = "0" Then LotacaoStatus = "Ativo" Else LotacaoStatus = "Inativo" End If													
			
					End If	
							
		ElseIf AcaoSistema = "alterar" Then	

					DataAlteracao		= Date		
					LotacaoCodigo		= request("txtCodigo")
					LotacaoOrgao		= request("cmbOrgao")					
					LotacaoDescricao	= replace(UCase(Trim(Request("txtLotacao"))),"'","''")
					
					sqlConsulta = "SELECT lotacao_id FROM dados_unico.lotacao WHERE UPPER(lotacao_ds) = '" & UCase(LotacaoDescricao) & "' AND lotacao_id <> " & LotacaoCodigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If rsConsulta.eof Then							
			
							sqlAltera = "UPDATE dados_unico.lotacao SET orgao_id = " & LotacaoOrgao & ", lotacao_ds = '" & LotacaoDescricao & "', lotacao_dt_alteracao = '" & DataAlteracao & "' WHERE lotacao_id = " & LotacaoCodigo
							objConexao.execute(sqlAltera)
								
							Response.Redirect "LotacaoInicio.asp"	
			
					Else	
						MensagemErroBD = "LOTA플O J� EXISTENTE."	
					End If	
				
		ElseIf AcaoSistema = "alterarStatus" Then
		
					DataAlteracao 		= Date
					LotacaoCodigo 		= request.QueryString("cod")
					LotacaoStatusCod 	= request.QueryString("status")
					
					If LotacaoStatusCod = 0 Then LotacaoStatusCod = 1 Else LotacaoStatusCod = 0 End If
									
					sqlAltera = "UPDATE dados_unico.lotacao SET lotacao_st = " & LotacaoStatusCod & ", lotacao_dt_alteracao = '" & DataAlteracao & "' WHERE lotacao_id = " & LotacaoCodigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect "LotacaoInicio.asp"	
			
		ElseIf AcaoSistema = "excluir" Then			
				
					ExcluirCheckbox = Request.QueryString("excluirMultiplo")
					
					If ExcluirCheckbox = 1 Then
						LotacaoCodigo	= Request("txtCodigo")	
						sqlDeleta = "UPDATE dados_unico.lotacao SET lotacao_st = 2 WHERE lotacao_id IN (" & LotacaoCodigo & ")"
					Else		
						LotacaoCodigo	= Request.QueryString("cod")		
						sqlDeleta = "UPDATE dados_unico.lotacao SET lotacao_st = 2  WHERE lotacao_id = " & LotacaoCodigo
					End If
		
					objConexao.execute(sqlDeleta)				
			
					Response.Redirect "LotacaoInicio.asp"	
						
		End If
%>