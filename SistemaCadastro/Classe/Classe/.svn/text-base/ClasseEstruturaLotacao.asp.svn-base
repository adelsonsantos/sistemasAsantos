<%

	'define o nome da pagina local para facilitar nos links
	PaginaLocal = "EstOrganizacionalLotacao"
	
	'controla a visibilidade do botao consultar
	Session("BotaoConsultar") = 0

	'variaveis de banco
	Dim sqlConsulta, sqlAltera, sqlDeleta, sqlInsere
	Dim rsConsulta, erroBD
	
	'variaveis da classe
	Dim EstOrganizacionalCodigo, EstOrganizacionalSuperior, EstOrganizacionalSuperiorCod, EstOrganizacionalDescricao, EstOrganizacionalSigla, EstOrganizacionalStatusCod, EstOrganizacionalStatus, EstOrganizacionalDataCriacao, EstOrganizacionalDataAlteracao, DataCriacao, DataAlteracao
	Dim CodigoRegistro, ExcluirCheckbox, Reticencias
	
	Dim strAtivo, strInativo, strTodos, numFiltro, strStringSQL			
		
	ErroBD = 0

	If (AcaoSistema = "buscar" or AcaoSistema = "")  Then
	
			numFiltro = Request.QueryString("filtro")
			
			If numFiltro <> "" Then
				strStringSQL = "tFilha.est_organizacional_lotacao_st = " & numFiltro
			Else
				strStringSQL = "tFilha.est_organizacional_lotacao_st <> 2"
			End If	
	
			If RetornoFiltro <> "" Then
				sqlConsulta = "SELECT tFilha.est_organizacional_lotacao_id, tFilha.est_organizacional_lotacao_ds, tFilha.est_organizacional_lotacao_sigla, tPai.est_organizacional_lotacao_sigla AS EstSuperior, tFilha.est_organizacional_lotacao_st FROM dados_unico.est_organizacional_lotacao tFilha LEFT JOIN dados_unico.est_organizacional_lotacao tPai ON (tPai.est_organizacional_lotacao_id = tFilha.est_organizacional_lotacao_sup_cd) WHERE " & strStringSQL & " AND tFilha.est_organizacional_lotacao_id <> 0 AND (tFilha.est_organizacional_lotacao_ds ILIKE '%" & RetornoFiltro & "%') OR (tFilha.est_organizacional_lotacao_sigla ILIKE '%" & RetornoFiltro & "%') ORDER BY UPPER(tFilha.est_organizacional_lotacao_sigla)"				
			Else
				sqlConsulta = "SELECT tFilha.est_organizacional_lotacao_id, tFilha.est_organizacional_lotacao_ds, tFilha.est_organizacional_lotacao_sigla, tPai.est_organizacional_lotacao_sigla AS EstSuperior, tFilha.est_organizacional_lotacao_st FROM dados_unico.est_organizacional_lotacao tFilha LEFT JOIN dados_unico.est_organizacional_lotacao tPai ON (tPai.est_organizacional_lotacao_id = tFilha.est_organizacional_lotacao_sup_cd) WHERE " & strStringSQL & " AND tFilha.est_organizacional_lotacao_id <> 0 ORDER BY UPPER(tFilha.est_organizacional_lotacao_sigla)"				
			End If

			set rsConsulta = objConexao.execute(sqlConsulta) 
	
	ElseIf AcaoSistema = "incluir" Then
	
			EstOrganizacionalDescricao	 = replace(UCase(Trim(Request("txtEstOrganizacional"))),"'","''")	
			EstOrganizacionalSigla		 = replace(UCase(Trim(Request("txtEstOrganizacionalSigla"))),"'","''")				
			EstOrganizacionalSuperiorCod = request("cmbEstruturaSuperior")
			
			sqlConsulta = "SELECT est_organizacional_lotacao_id FROM dados_unico.est_organizacional_lotacao WHERE UPPER(est_organizacional_lotacao_ds) = '" & UCase(EstOrganizacionalDescricao) & "' OR UPPER(est_organizacional_lotacao_sigla) = '" & UCase(EstOrganizacionalSigla) & "'"
			Set rsConsulta = objConexao.execute(sqlConsulta)	
			
			If rsConsulta.eof Then					
				
				sqlInsere = "INSERT INTO dados_unico.est_organizacional_lotacao (est_organizacional_lotacao_sup_cd, est_organizacional_lotacao_ds, est_organizacional_lotacao_sigla, est_organizacional_lotacao_dt_criacao) VALUES ("& EstOrganizacionalSuperiorCod & ", '" & EstOrganizacionalDescricao & "','" & EstOrganizacionalSigla & "', '" & Date & "')"
				objConexao.execute(sqlInsere)
	
				Response.Redirect "EstOrganizacionalLotacaoInicio.asp"
	
			Else
				MensagemErroBD = "ESTRUTURA ORGANIZACIONAL JÁ CADASTRADA."				
			End If	
			
	ElseIf AcaoSistema = "consultar" Then	
	
			EstOrganizacionalCodigo = Request.QueryString("cod")
			
			If EstOrganizacionalCodigo = "" Then
			
				EstOrganizacionalCodigo = Request("checkbox")
				
				sqlConsulta = "SELECT tFilha.est_organizacional_lotacao_id, tFilha.est_organizacional_lotacao_ds, tFilha.est_organizacional_lotacao_sigla, tPai.est_organizacional_lotacao_ds AS EstSuperior, tFilha.est_organizacional_lotacao_sup_cd, tFilha.est_organizacional_lotacao_st FROM dados_unico.est_organizacional_lotacao tFilha LEFT JOIN dados_unico.est_organizacional_lotacao tPai ON (tPai.est_organizacional_lotacao_id = tFilha.est_organizacional_lotacao_sup_cd) WHERE tFilha.est_organizacional_lotacao_id IN (" & EstOrganizacionalCodigo & ")"
			
			Else
				sqlConsulta = "SELECT tFilha.est_organizacional_lotacao_id, tFilha.est_organizacional_lotacao_ds, tFilha.est_organizacional_lotacao_sigla, tPai.est_organizacional_lotacao_ds AS EstSuperior, tFilha.est_organizacional_lotacao_sup_cd, tFilha.est_organizacional_lotacao_st FROM dados_unico.est_organizacional_lotacao tFilha LEFT JOIN dados_unico.est_organizacional_lotacao tPai ON (tPai.est_organizacional_lotacao_id = tFilha.est_organizacional_lotacao_sup_cd) WHERE tFilha.est_organizacional_lotacao_id = " & EstOrganizacionalCodigo							
			End If				
			

			Set rsConsulta = objConexao.execute(sqlConsulta)

			If Not rsConsulta.eof Then
	
				EstOrganizacionalSuperiorCod   	= rsConsulta("est_organizacional_lotacao_sup_cd")
				EstOrganizacionalSuperior    	= rsConsulta("EstSuperior")
				EstOrganizacionalCodigo		    = rsConsulta("est_organizacional_lotacao_id")
				EstOrganizacionalDescricao	    = rsConsulta("est_organizacional_lotacao_ds")
				EstOrganizacionalSigla	    	= rsConsulta("est_organizacional_lotacao_sigla")														
				EstOrganizacionalStatusCod	    = rsConsulta("est_organizacional_lotacao_st")	

				If EstOrganizacionalStatusCod = "0" Then EstOrganizacionalStatus = "Ativo" Else EstOrganizacionalStatus = "Inativo" End If													

			End If	
						
	ElseIf AcaoSistema = "alterar" Then	
	
			EstOrganizacionalCodigo		= request("txtCodigo")
			EstOrganizacionalDescricao	= replace(UCase(Trim(Request("txtEstOrganizacional"))),"'","''")	
			EstOrganizacionalSigla		= replace(UCase(Trim(Request("txtEstOrganizacionalSigla"))),"'","''")							
			EstOrganizacionalSuperior	= request("cmbEstruturaSuperior")	

			sqlConsulta = "SELECT est_organizacional_lotacao_id FROM dados_unico.est_organizacional_lotacao WHERE UPPER(est_organizacional_lotacao_ds) = '" & UCase(EstOrganizacionalDescricao) & "' AND est_organizacional_lotacao_sup_cd = " & EstOrganizacionalSuperior & " AND UPPER(est_organizacional_lotacao_sigla) = '" & UCase(EstOrganizacionalSigla) & "' AND est_organizacional_lotacao_id <> " & EstOrganizacionalCodigo
			Set rsConsulta = objConexao.execute(sqlConsulta)
	
			If rsConsulta.eof Then
			
					sqlAltera = "UPDATE dados_unico.est_organizacional_lotacao SET " &_
								"est_organizacional_lotacao_sup_cd = " & EstOrganizacionalSuperior & ", " &_
								"est_organizacional_lotacao_ds = '" & EstOrganizacionalDescricao & "', " &_
								"est_organizacional_lotacao_sigla = '" & EstOrganizacionalSigla & "', " &_
								"est_organizacional_lotacao_dt_alteracao = '" & Date & "' " &_										
								"WHERE est_organizacional_lotacao_id = " & EstOrganizacionalCodigo

					objConexao.execute(sqlAltera)
						
				Response.Redirect "EstOrganizacionalLotacaoInicio.asp"
	
			Else	
				MensagemErroBD = "ESTRUTURA ORGANIZACIONAL OU SIGLA JÁ EXISTENTES."	
			End If	
			
	ElseIf AcaoSistema = "alterarStatus" Then
	
		EstOrganizacionalCodigo 	= request.QueryString("cod")
		EstOrganizacionalStatusCod 	= request.QueryString("status")
		
		If EstOrganizacionalStatusCod = 0 Then EstOrganizacionalStatusCod = 1 Else EstOrganizacionalStatusCod = 0 End If
							
		sqlAltera = "UPDATE dados_unico.est_organizacional_lotacao SET est_organizacional_lotacao_st = " & EstOrganizacionalStatusCod & ", est_organizacional_lotacao_dt_alteracao = '" & Date & "' WHERE est_organizacional_lotacao_id = " & EstOrganizacionalCodigo
		objConexao.execute(sqlALtera)
		
		Response.Redirect "EstOrganizacionalLotacaoInicio.asp"		
		
	ElseIf AcaoSistema = "excluir" Then			
			
			ExcluirCheckbox = Request.QueryString("excluirMultiplo")
			
			If ExcluirCheckbox = 1 Then
				EstOrganizacionalCodigo	= Request("txtCodigo")	
				sqlDeleta = "UPDATE dados_unico.est_organizacional_lotacao SET est_organizacional_lotacao_st = 2 WHERE est_organizacional_lotacao_id IN (" & EstOrganizacionalCodigo & ")"
			Else		
				EstOrganizacionalCodigo	= Request.QueryString("cod")		
				sqlDeleta = "UPDATE dados_unico.est_organizacional_lotacao SET est_organizacional_lotacao_st = 2  WHERE est_organizacional_lotacao_id = " & EstOrganizacionalCodigo
			End If

			objConexao.execute(sqlDeleta)				
	
			Response.Redirect "EstOrganizacionalLotacaoInicio.asp"
					
	End If
	


%>