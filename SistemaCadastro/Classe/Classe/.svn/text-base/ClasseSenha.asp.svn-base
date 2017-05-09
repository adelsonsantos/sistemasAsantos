<%
		Dim SenhaAntiga, NovaSenha, Codigo
		Dim sqlConsulta, rsConsulta, sqlAltera
		
		If AcaoSistema = "alterar" Then	

			SenhaAntiga = LCase(request("txtSenhaAtual"))
			NovaSenha = LCase(request("txtNovaSenha"))
			Codigo = request("txtCodigo")						

			sqlConsulta = "SELECT pessoa_id FROM seguranca.usuario WHERE usuario_senha = '" & SenhaAntiga & "' AND pessoa_id = " & Codigo
			Set rsConsulta = objConexao.execute(sqlConsulta)
			
			If Not rsConsulta.eof Then				
			
				sqlAltera = "UPDATE seguranca.usuario SET usuario_senha = '" & NovaSenha & "', usuario_primeiro_logon = 0 WHERE pessoa_id = " & Codigo
				objConexao.execute(sqlAltera)
					
				Response.Redirect "Home.asp"	
			
			Else	
				MensagemErroBD = "SENHA ATUAL FORNECIDA É INVÁLIDA."	
			End If	
						
		End If
%>