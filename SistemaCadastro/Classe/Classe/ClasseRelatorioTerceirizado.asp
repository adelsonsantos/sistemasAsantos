<%	
	Dim sqlConsulta,Contrato
	
	
	sqlConsulta = "SELECT * FROM dados_unico.pessoa p, dados_unico.funcionario f, dados_unico.contrato c, dados_unico.funcao func,dados_unico.funcionario_lotacao lotFuc,dados_unico.lotacao lot WHERE (lot.lotacao_id = lotFuc.lotacao_id) and  (lotFuc.funcionario_id = f.funcionario_id) and (f.funcao_id = func.funcao_id ) AND (c.contrato_id = f.contrato_id) AND (p.pessoa_id = f.pessoa_id)"
	
	
	if Request("cmbContrato") <> 0 then 
		Contrato= Request("cmbContrato")
		sqlConsulta = sqlConsulta  & " AND c.contrato_id = "&Contrato
	End If

 
	if Request("cmbLotacao") <> 0  then 
		Lotacao= Request("cmbLotacao")
		sqlConsulta = sqlConsulta  & " AND lotFuc.lotacao_id = "&Lotacao
	End If


 	if Request("cmbFuncao") <> 0 then 
		Funcao= Request("cmbFuncao")
		sqlConsulta = sqlConsulta  & " AND f.funcao_id = "&Funcao
	End If

	'**************************************************
	' Trata a Situação do Funcionário Terceirizado. 
	'**************************************************
		if Request("cmbSituacao") = 0  then 
		End If
		if Request("cmbSituacao") = 1  then 
		sqlConsulta = sqlConsulta  &	" and funcionario_dt_demissao = '' "	
		End If
		if Request("cmbSituacao") = 2  then 
		sqlConsulta = sqlConsulta  &	" and funcionario_dt_demissao <> '' "
		End If
	'**************************************************	
	
	sqlConsulta = sqlConsulta  & "ORDER BY UPPER(pessoa_nm)"	
	
	set rsConsulta = objConexao.execute(sqlConsulta) 	
	
			
%>