<%

	'define o nome da pagina local para facilitar nos links
	PaginaLocal = "EstOrganizacional"
	
	'controla a visibilidade do botao consultar
	Session("BotaoConsultar") = 0

	'variaveis de banco
	Dim sqlConsulta, sqlAltera, sqlDeleta, sqlInsere
	Dim rsConsulta, erroBD
	
	'variaveis da classe
	Dim EstOrganizacionalCodigo, EstOrganizacionalSuperior, EstOrganizacionalSuperiorCod, EstOrganizacionalDescricao, EstOrganizacionalSigla, EstOrganizacionalStatusCod, EstOrganizacionalStatus, EstOrganizacionalDataCriacao, EstOrganizacionalDataAlteracao, DataCriacao, DataAlteracao
	Dim CentroCusto, CentroCustoNumero, strParametroConsulta
	Dim sqlCodigo, rsCodigo
	Dim CodigoRegistro, ExcluirCheckbox, Reticencias
	
	'filtro por status
	Dim strAtivo, strInativo, strTodos, numFiltro, strStringSQL			
		
	ErroBD = 0

	If (AcaoSistema = "buscar" or AcaoSistema = "")  Then
	
			numFiltro = Request.QueryString("filtro")
			
			If numFiltro <> "" Then
				strStringSQL = "tFilha.est_organizacional_st = " & numFiltro
			Else
				strStringSQL = "tFilha.est_organizacional_st <> 2"
			End If	
	
			If RetornoFiltro <> "" Then
				sqlConsulta = "SELECT tFilha.est_organizacional_id, tFilha.est_organizacional_ds, tFilha.est_organizacional_sigla, tPai.est_organizacional_sigla AS EstSuperior, tFilha.est_organizacional_st, tFilha.est_organizacional_dt_criacao,tFilha.est_organizacional_dt_alteracao, tFilha.est_organizacional_centro_custo,tFilha.est_organizacional_centro_custo_transporte,tFilha.est_organizacional_centro_custo_acompanhamento, tFilha.est_organizacional_centro_custo_num FROM dados_unico.est_organizacional tFilha LEFT JOIN dados_unico.est_organizacional tPai ON (tPai.est_organizacional_id = tFilha.est_organizacional_sup_cd) WHERE " & strStringSQL & " AND (tFilha.est_organizacional_ds ILIKE '%" & RetornoFiltro & "%') OR (tFilha.est_organizacional_sigla ILIKE '%" & RetornoFiltro & "%') ORDER BY UPPER(tFilha.est_organizacional_sigla)"				
			Else
				sqlConsulta = "SELECT tFilha.est_organizacional_id, tFilha.est_organizacional_ds, tFilha.est_organizacional_sigla, tPai.est_organizacional_sigla AS EstSuperior, tFilha.est_organizacional_st, tFilha.est_organizacional_dt_criacao,tFilha.est_organizacional_dt_alteracao, tFilha.est_organizacional_centro_custo,tFilha.est_organizacional_centro_custo_transporte,tFilha.est_organizacional_centro_custo_acompanhamento,tFilha.est_organizacional_centro_custo_num FROM dados_unico.est_organizacional tFilha LEFT JOIN dados_unico.est_organizacional tPai ON (tPai.est_organizacional_id = tFilha.est_organizacional_sup_cd) WHERE " & strStringSQL & " ORDER BY UPPER(tFilha.est_organizacional_sigla)"				
			End If
	
			set rsConsulta = objConexao.execute(sqlConsulta) 
	
	ElseIf AcaoSistema = "incluir" Then
	
			DataCriacao 				 				= Date
			EstOrganizacionalDescricao	 				= replace(UCase(Trim(Request("txtEstOrganizacional"))),"'","''")	
			EstOrganizacionalSigla		 				= replace(UCase(Trim(Request("txtEstOrganizacionalSigla"))),"'","''")				
			EstOrganizacionalSuperiorCod 				= request("cmbEstruturaSuperior")
			CentroCusto 				 				= Request.Form("rdCentro")
			CentroCustoTransporte						= Request.Form("rdCentroTransporte")
			CentroCustoAcompanhamento					= Request.Form("rdCentroAcompanhamento")
			CentroCustoNumero			 				= Trim(Request("txtCentroCusto"))		
			
			If CentroCustoNumero <> "" Then
				strParametroConsulta = "(est_organizacional_centro_custo_num = '" & CentroCustoNumero & "') OR"	
			Else
				strParametroConsulta = ""
			End If
			
			'verifica se já existe a estrutura
			sqlConsulta = "SELECT est_organizacional_id FROM dados_unico.est_organizacional WHERE " &strParametroConsulta&" UPPER(est_organizacional_ds) = '" & UCase(EstOrganizacionalDescricao) & "' OR UPPER(est_organizacional_sigla) = '" & UCase(EstOrganizacionalSigla) & "'"
			Set rsConsulta = objConexao.execute(sqlConsulta)	
			
			If rsConsulta.eof Then					
				
				sqlInsere = "INSERT INTO dados_unico.est_organizacional (est_organizacional_sup_cd, est_organizacional_ds, est_organizacional_sigla, est_organizacional_dt_criacao, est_organizacional_centro_custo, est_organizacional_centro_custo_num,est_organizacional_centro_custo_transporte,est_organizacional_centro_custo_acompanhamento) VALUES ("& EstOrganizacionalSuperiorCod & ", '" & EstOrganizacionalDescricao & "','" & EstOrganizacionalSigla & "', '" & DataCriacao & "', " & CentroCusto & ", '" & CentroCustoNumero & ","& CentroCustoTransporte & ","&CentroCustoAcompanhamento&"')"
				objConexao.execute(sqlInsere)
				
				sqlCodigo = "SELECT @@identity AS UltimoInserido FROM dados_unico.est_organizacional" 
				Set rsCodigo = objConexao.execute(sqlCodigo)				
				
				sqlInsere = "INSERT INTO diaria.autorizador_acp (est_organizacional_id) VALUES (" & rsCodigo("UltimoInserido") & ")"
				objConexao.execute(sqlInsere)				
	
				Response.Redirect "EstOrganizacionalInicio.asp"
	
			Else
				MensagemErroBD = "ESTRUTURA ORGANIZACIONAL JÁ CADASTRADA."				
			End If	
			
	ElseIf AcaoSistema = "consultar" Then	
	
			EstOrganizacionalCodigo = Request.QueryString("cod")
			
			If EstOrganizacionalCodigo = "" Then
			
				EstOrganizacionalCodigo = Request("checkbox")
				
				sqlConsulta = "SELECT tFilha.est_organizacional_id, tFilha.est_organizacional_ds, tFilha.est_organizacional_sigla, tPai.est_organizacional_ds AS EstSuperior, tFilha.est_organizacional_sup_cd, tFilha.est_organizacional_st, tFilha.est_organizacional_dt_criacao,tFilha.est_organizacional_dt_alteracao, tFilha.est_organizacional_centro_custo,tFilha.est_organizacional_centro_custo_transporte,tFilha.est_organizacional_centro_custo_acompanhamento, tFilha.est_organizacional_centro_custo_num FROM dados_unico.est_organizacional tFilha LEFT JOIN dados_unico.est_organizacional tPai ON (tPai.est_organizacional_id = tFilha.est_organizacional_sup_cd) WHERE tFilha.est_organizacional_id IN (" & EstOrganizacionalCodigo & ")"
			
			Else
				sqlConsulta = "SELECT tFilha.est_organizacional_id, tFilha.est_organizacional_ds, tFilha.est_organizacional_sigla, tPai.est_organizacional_ds AS EstSuperior, tFilha.est_organizacional_sup_cd, tFilha.est_organizacional_st, tFilha.est_organizacional_dt_criacao,tFilha.est_organizacional_dt_alteracao, tFilha.est_organizacional_centro_custo,tFilha.est_organizacional_centro_custo_transporte,tFilha.est_organizacional_centro_custo_acompanhamento, tFilha.est_organizacional_centro_custo_num FROM dados_unico.est_organizacional tFilha LEFT JOIN dados_unico.est_organizacional tPai ON (tPai.est_organizacional_id = tFilha.est_organizacional_sup_cd) WHERE tFilha.est_organizacional_id = " & EstOrganizacionalCodigo							
			End If				
			

			Set rsConsulta = objConexao.execute(sqlConsulta)

			If Not rsConsulta.eof Then
	
				EstOrganizacionalSuperiorCod   				= rsConsulta("est_organizacional_sup_cd")
				EstOrganizacionalSuperior    				= rsConsulta("EstSuperior")
				EstOrganizacionalCodigo		    			= rsConsulta("est_organizacional_id")
				EstOrganizacionalDescricao	    			= rsConsulta("est_organizacional_ds")
				EstOrganizacionalSigla	    				= rsConsulta("est_organizacional_sigla")														
				EstOrganizacionalStatusCod	    			= rsConsulta("est_organizacional_st")	
				EstOrganizacionalDataCriacao    			= rsConsulta("est_organizacional_dt_criacao")	
				EstOrganizacionalDataAlteracao  			= rsConsulta("est_organizacional_dt_alteracao")	
				CentroCusto									= rsConsulta("est_organizacional_centro_custo")	
				CentroCustoTransporte						= rsConsulta("est_organizacional_centro_custo_transporte")
				CentroCustoAcompanhamento					= rsConsulta("est_organizacional_centro_custo_acompanhamento")
				CentroCustoNumero							= rsConsulta("est_organizacional_centro_custo_num")					

				If EstOrganizacionalStatusCod = "0" Then EstOrganizacionalStatus = "Ativo" Else EstOrganizacionalStatus = "Inativo" End If													

			End If	
						
	ElseIf AcaoSistema = "alterar" Then	
	
			DataAlteracao				 = Date
			EstOrganizacionalCodigo		 = request("txtCodigo")
			EstOrganizacionalDescricao	 = replace(UCase(Trim(Request("txtEstOrganizacional"))),"'","''")	
			EstOrganizacionalSigla		 = replace(UCase(Trim(Request("txtEstOrganizacionalSigla"))),"'","''")							
			EstOrganizacionalSuperior	 = request("cmbEstruturaSuperior")	
			CentroCusto 				 = Request.Form("rdCentro")
			CentroCustoTransporte		 = Request.Form("rdCentroTransporte")
			CentroCustoAcompanhamento	 = Request.Form("rdCentroAcompanhamento")
			CentroCustoNumero			 = Trim(Request("txtCentroCusto"))				

			sqlConsulta = "SELECT est_organizacional_id FROM dados_unico.est_organizacional WHERE UPPER(est_organizacional_ds) = '" & UCase(EstOrganizacionalDescricao) & "' AND est_organizacional_sup_cd = " & EstOrganizacionalSuperior & " AND UPPER(est_organizacional_sigla) = '" & UCase(EstOrganizacionalSigla) & "' AND est_organizacional_id <> " & EstOrganizacionalCodigo
			Set rsConsulta = objConexao.execute(sqlConsulta)
	
			If rsConsulta.eof Then
			
					sqlAltera = "UPDATE dados_unico.est_organizacional SET " &_
								"est_organizacional_sup_cd = " & EstOrganizacionalSuperior & ", " &_
								"est_organizacional_ds = '" & EstOrganizacionalDescricao & "', " &_
								"est_organizacional_sigla = '" & EstOrganizacionalSigla & "', " &_
								"est_organizacional_dt_alteracao = '" & DataAlteracao & "', " &_										
								"est_organizacional_centro_custo = " & CentroCusto & ", " &_
								"est_organizacional_centro_custo_transporte = " & CentroCustoTransporte & ", " &_
								"est_organizacional_centro_custo_acompanhamento = " & CentroCustoAcompanhamento & ", " &_																		
								"est_organizacional_centro_custo_num = '" & CentroCustoNumero & "' " &_																		
								"WHERE est_organizacional_id = " & EstOrganizacionalCodigo

					objConexao.execute(sqlAltera)
						
				Response.Redirect "EstOrganizacionalInicio.asp"
	
			Else	
				MensagemErroBD = "ESTRUTURA ORGANIZACIONAL OU SIGLA JÁ EXISTENTES."	
			End If	
			
	ElseIf AcaoSistema = "alterarStatus" Then
	
		DataCriacao 				= Date
		EstOrganizacionalCodigo 	= request.QueryString("cod")
		EstOrganizacionalStatusCod 	= request.QueryString("status")
		
		If EstOrganizacionalStatusCod = 0 Then EstOrganizacionalStatusCod = 1 Else EstOrganizacionalStatusCod = 0 End If
							
		sqlAltera = "UPDATE dados_unico.est_organizacional SET est_organizacional_st = " & EstOrganizacionalStatusCod & ", est_organizacional_dt_alteracao = '" & DataCriacao & "' WHERE est_organizacional_id = " & EstOrganizacionalCodigo
		objConexao.execute(sqlALtera)
		
		Response.Redirect "EstOrganizacionalInicio.asp"		
		
	ElseIf AcaoSistema = "excluir" Then			
			
			ExcluirCheckbox = Request.QueryString("excluirMultiplo")
			
			If ExcluirCheckbox = 1 Then
				EstOrganizacionalCodigo	= Request("txtCodigo")	
				sqlDeleta = "UPDATE dados_unico.est_organizacional SET est_organizacional_st = 2 WHERE est_organizacional_id IN (" & EstOrganizacionalCodigo & ")"
			Else		
				EstOrganizacionalCodigo	= Request.QueryString("cod")		
				sqlDeleta = "UPDATE dados_unico.est_organizacional SET est_organizacional_st = 2  WHERE est_organizacional_id = " & EstOrganizacionalCodigo
			End If

			objConexao.execute(sqlDeleta)				
	
			Response.Redirect "EstOrganizacionalInicio.asp"
					
	End If
	


%>