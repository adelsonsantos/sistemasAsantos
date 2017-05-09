<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Contrato"

		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = 1
		
		'variaveis de contrato
		Dim sqlConsulta, sqlAltera, sqlDeleta, sqlInsere
		Dim rsConsulta
		
		'variaveis da classe
		Dim Codigo, Numero, Empresa, Descricao, DataInicio, DataTermino, Valor, Qtde, Tipo, StatusCod, StatusNome, ContratoDataCriacao, ContratoDataAlteracao, DataAlteracao, DataCriacao
		Dim CodigoRegistro, ExcluirCheckbox		
		
		'filtro por status
		Dim strAtivo, strInativo, strTodos, numFiltro, strStringSQL			

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then
		
					numFiltro = Request.QueryString("filtro")
					
					If numFiltro <> "" Then
						strStringSQL = "contrato_st = " & numFiltro
					Else
						strStringSQL = "contrato_st <> 2"
					End If
					' fim do filtro 			
			
					If RetornoFiltro <> "" Then
						sqlConsulta = "SELECT * FROM dados_unico.contrato c, dados_unico.pessoa p WHERE (c.pessoa_id = p.pessoa_id) AND " & strStringSQL & " AND contrato_id <> 0 AND contrato_ds ILIKE '%" & RetornoFiltro & "%' ORDER BY UPPER(contrato_ds)"	
					Else
						sqlConsulta = "SELECT * FROM dados_unico.contrato c, dados_unico.pessoa p WHERE (c.pessoa_id = p.pessoa_id) AND " & strStringSQL & " AND contrato_id <> 0 ORDER BY UPPER(contrato_ds)"
					End If
					
					Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		
					DataCriacao = Date
					Numero		= Trim(Request("txtNumero"))	
					Descricao	= Replace(UCase(Trim(Request("txtDescricao"))),"'","''")	
					Tipo		= Request("cmbContratoTipo")
					Empresa		= Request("cmbPJ")						
					DataInicio	= Trim(Request("txtDataInicio"))	
					DataTermino	= Trim(Request("txtDataTermino"))						
					Valor		= Trim(Request("txtValor"))							
					Qtde		= Trim(Request("txtQtde"))	
					
					If Qtde = "" Then Qtde = 0 End If					
					
					sqlConsulta = "SELECT contrato_id FROM dados_unico.contrato WHERE contrato_num = '" & Numero & "' AND pessoa_id = " & Empresa
					Set rsConsulta = objConexao.execute(sqlConsulta)	
					
					If rsConsulta.eof Then
						
						sqlInsere = "INSERT INTO dados_unico.contrato (pessoa_id, contrato_num, contrato_ds, contrato_dt_inicio, contrato_dt_termino, contrato_valor, contrato_num_max, contrato_dt_criacao, contrato_tipo_id) VALUES " &_
									"(" & Empresa & ", '" & Numero & "', '" & Descricao & "', '" & DataInicio & "', '" & DataTermino & "', '" & Valor & "', " & Qtde & ", '" & DataCriacao & "', " & Tipo & " )"

 						objConexao.execute(sqlInsere)

						Response.Redirect PaginaLocal & "Inicio.asp"	
			
					Else	
						MensagemErroBD = "NÚMERO DE CONTRATO JÁ EXISTENTE PARA ESTA EMPRESA."	
					End If				
	
		ElseIf AcaoSistema = "consultar" Then	
		
					Codigo = Request.QueryString("cod")
					
					If Codigo = "" Then
					
						Codigo = Request("checkbox")
						
						sqlConsulta = "SELECT * FROM dados_unico.contrato WHERE contrato_id IN (" & Codigo & ")"
					
					Else
						sqlConsulta = "SELECT * FROM dados_unico.contrato WHERE contrato_id = " & Codigo
					End If					
			
					
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If Not rsConsulta.eof Then
			
						Numero	   	   = rsConsulta("contrato_num")
						Descricao	   = rsConsulta("contrato_ds")
						StatusCod	   = rsConsulta("contrato_st")	
						DataCriacao    = rsConsulta("contrato_dt_criacao")	
						DataAlteracao  = rsConsulta("contrato_dt_alteracao")
						Empresa		   = rsConsulta("pessoa_id")						
						DataInicio	   = rsConsulta("contrato_dt_inicio")	
						DataTermino	   = rsConsulta("contrato_dt_termino")		
						Tipo		   = rsConsulta("contrato_tipo_id")							
						Valor		   = rsConsulta("contrato_valor")						
						Qtde		   = rsConsulta("contrato_num_max")							

						If StatusCod = "0" Then StatusNome = "Ativo" Else StatusNome = "Inativo" End If													
			
					End If	
							
		ElseIf AcaoSistema = "alterar" Then	

					Codigo = Request("txtCodigo")
					DataAlteracao	= Date		
					Numero		= Trim(Request("txtNumero"))	
					Descricao	= Replace(UCase(Trim(Request("txtDescricao"))),"'","''")	
					Empresa		= Request("cmbPJ")
					Tipo		= Request("cmnContratoTipo")											
					DataInicio	= Trim(Request("txtDataInicio"))	
					DataTermino	= Trim(Request("txtDataTermino"))						
					Valor		= Trim(Request("txtValor"))						
					Qtde		= Trim(Request("txtQtde"))
					
					sqlConsulta = "SELECT contrato_id FROM dados_unico.contrato WHERE contrato_num = '" & Numero & "' AND pessoa_id = " & Empresa & " AND contrato_id <> " & Codigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If rsConsulta.eof Then							
			
							sqlAltera = "UPDATE dados_unico.contrato SET contrato_num = '" & Numero & "', contrato_ds = '" & Descricao & "', contrato_dt_inicio = '" & DataInicio & "', contrato_dt_termino = '" & DataTermino & "', contrato_valor = '" & Valor & "', contrato_num_max = '" & Qtde & "', contrato_dt_alteracao = '" & DataAlteracao & "' WHERE contrato_id = " & Codigo
							objConexao.execute(sqlAltera)
								
							Response.Redirect PaginaLocal & "Inicio.asp"	
			
					Else	
						MensagemErroBD = "NÚMERO DE CONTRATO JÁ EXISTENTE PARA ESTA EMPRESA."		
					End If	
				
		ElseIf AcaoSistema = "alterarStatus" Then
		
					DataAlteracao 	= Date
					Codigo 	= request.QueryString("cod")
					StatusCod 	= request.QueryString("status")
					
					If StatusCod = 0 Then StatusCod = 1 Else StatusCod = 0 End If
									
					sqlAltera = "UPDATE dados_unico.contrato SET contrato_st = " & StatusCod & ", contrato_dt_alteracao = '" & DataAlteracao & "' WHERE contrato_id = " & Codigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect PaginaLocal & "Inicio.asp"	
			
		ElseIf AcaoSistema = "excluir" Then			
				
					ExcluirCheckbox = Request.QueryString("excluirMultiplo")
					
					If ExcluirCheckbox = 1 Then
						Codigo	= Request("txtCodigo")	
						sqlDeleta = "UPDATE dados_unico.contrato SET contrato_st = 2 WHERE contrato_id IN (" & Codigo & ")"
					Else		
						Codigo	= Request.QueryString("cod")		
						sqlDeleta = "UPDATE dados_unico.contrato SET contrato_st = 2  WHERE contrato_id = " & Codigo
					End If
		
					objConexao.execute(sqlDeleta)				
			
					Response.Redirect PaginaLocal & "Inicio.asp"	
						
		End If
%>