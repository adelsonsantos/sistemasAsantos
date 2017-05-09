<%

		'define o nome da pagina local para facilitar nos links
		PaginaLocal = "Usuario"
		
		'controla a visibilidade do botao consultar
		Session("BotaoConsultar") = 0
		
		ErroTipoUsuario = 1

		If (AcaoSistema = "buscar" or AcaoSistema = "")  Then	
		
					numFiltro = Request.QueryString("filtro")

					If RetornoFiltro <> "" Then
						sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, usuario_login, usuario_st, est_organizacional_sigla FROM dados_unico.funcionario f, dados_unico.est_organizacional est, dados_unico.est_organizacional_funcionario eof, seguranca.usuario u RIGHT JOIN dados_unico.pessoa p ON (p.pessoa_id = u.pessoa_id) WHERE (f.pessoa_id = p.pessoa_id) AND (f.funcionario_id = eof.funcionario_id) AND (est.est_organizacional_id = eof.est_organizacional_id) AND est_organizacional_funcionario_st = 0 AND (pessoa_nm ILIKE '%" & RetornoFiltro & "%' OR usuario_login ILIKE '%" & RetornoFiltro & "%') ORDER BY UPPER(pessoa_nm) "
					Else
						If numFiltro = "1" Then
							sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, usuario_login, usuario_st, est_organizacional_sigla FROM dados_unico.funcionario f, dados_unico.est_organizacional est, dados_unico.est_organizacional_funcionario eof, seguranca.usuario u, dados_unico.pessoa p WHERE (p.pessoa_id = u.pessoa_id) AND (f.pessoa_id = p.pessoa_id) AND (f.funcionario_id = eof.funcionario_id) AND (est.est_organizacional_id = eof.est_organizacional_id) AND est_organizacional_funcionario_st = 0 ORDER BY UPPER(pessoa_nm) "						
						ElseIf numFiltro = "0" Then
							sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, usuario_login, usuario_st, est_organizacional_sigla FROM dados_unico.funcionario f, dados_unico.est_organizacional est, dados_unico.est_organizacional_funcionario eof, seguranca.usuario u RIGHT JOIN dados_unico.pessoa p ON (p.pessoa_id = u.pessoa_id) WHERE (usuario_login is null) AND (f.pessoa_id = p.pessoa_id) AND (f.funcionario_id = eof.funcionario_id) AND (est.est_organizacional_id = eof.est_organizacional_id) AND est_organizacional_funcionario_st = 0 ORDER BY UPPER(pessoa_nm) "												
						Else
							sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, usuario_login, usuario_st, est_organizacional_sigla FROM dados_unico.funcionario f, dados_unico.est_organizacional est, dados_unico.est_organizacional_funcionario eof, seguranca.usuario u RIGHT JOIN dados_unico.pessoa p ON (p.pessoa_id = u.pessoa_id) WHERE (f.pessoa_id = p.pessoa_id) AND (f.funcionario_id = eof.funcionario_id) AND (est.est_organizacional_id = eof.est_organizacional_id) AND est_organizacional_funcionario_st = 0 ORDER BY UPPER(pessoa_nm) "						
						End If
					End If

					Set rsConsulta = objConexao.execute(sqlConsulta) 	
			
		ElseIf AcaoSistema = "incluir" Then
		
					DataCriacao = Date
					Codigo 		= Request.Form("txtCodigo")	
					Login		= Trim(LCase(Request.Form("txtLogin")))
					Email		= Trim(LCase(Request.Form("txtEmail")))	
					
					sqlConsulta = "SELECT pessoa_id FROM seguranca.usuario WHERE usuario_login = '" & Login & "'"									
					Set rsConsulta = ObjConexao.execute(sqlConsulta)
					
					If rsConsulta.eof Then
					
													
							Randomize()
							PassLen = 0
							CurrPass = ""
							'gera senha randomica
							do while PassLen < 7
								CurrLtr = Int((42 * Rnd()) + 48)
								
								if CurrLtr < 57 or CurrLtr > 65 then
									CurrPass = CurrPass & Chr(CurrLtr)
									PassLen = PassLen + 1
								end if
							loop					
					
							sqlInsere = "INSERT INTO seguranca.usuario (pessoa_id, usuario_login, usuario_senha, usuario_dt_criacao) VALUES (" & Codigo & ", '" & Login & "', '" & LCase(CurrPass) & "', '" & DataCriacao & "')"
							objConexao.execute(sqlInsere)					
							
							sqlSistema = "SELECT * FROM seguranca.sistema WHERE sistema_st = 0 ORDER BY UPPER(sistema_ds)"
							Set rsSistema = objConexao.execute(sqlSistema)	
							
							If Session("UsuarioEmail") = 0 Then
								sqlAltera = "UPDATE dados_unico.funcionario SET funcionario_email = '" & Email & "' WHERE pessoa_id = " & Codigo
								ObjConexao.execute(sqlAltera)
							End If
					
							If Not rsSistema.eof Then
							
								Set SistemaAcessoCodigo = rsSistema("sistema_id")
							
								While Not rsSistema.eof
																						
									TipoUsuario = Request.Form("radio" & SistemaAcessoCodigo & "")
									
									If TipoUsuario <> "" Then
										
										ErroTipoUsuario = 0
										
										sqlInsere = "INSERT INTO seguranca.usuario_tipo_usuario (pessoa_id, tipo_usuario_id) VALUES (" & Codigo & ", " & TipoUsuario & ")"
										objConexao.execute(sqlInsere)							
								
									End If
									
									rsSistema.MoveNext
								Wend					
							End If
							
							If ErroTipoUsuario = 1 Then
								sqlDeleta = "DELETE FROM seguranca.usuario WHERE pessoa_id = " & Codigo
								ObjConexao.execute(sqlDeleta)
							End If
							
							smtp_server_address = "200.187.60.36"
							Set Mail = Server.CreateObject("JMail.Message")
							Mail.From = "sistemas.sema@sema.ba.gov.br"	  
							Mail.FromName = "SEMA - Secretaria do Meio Ambiente"
							Mail.logging = False	  
							Mail.MailServerUserName = ""
							Mail.MailServerPassWord = ""	
						
							Mail.AddRecipient Email
			
							Mail.Subject = "Informativo - Senha para acesso ao Sistema Corporativo"			
			
							texto = "<br>Caro(a) Servidor(a),<br><br>"
							texto = texto & "Segue seu login e senha para acesso ao Sistema Corporativo:<br><br>"
							texto = texto & "Login: " & Login & "<br>"
							texto = texto & "Senha: " & LCase(CurrPass) & "<br><br>"	
							texto = texto & "<font><strong>A T E N Ç Ã O! Sua senha é pessoal e intransferivel<strong></font><br><br>"						
							texto = texto & "Contando com sua colaboração e nos colocamos a disposição nos contatos abaixo:<br><br>"						
							texto = texto & "Coordenação de Mordernização - CMO<br>"	
							texto = texto & "GT Sistemas<br>"	
							texto = texto & "Telefones: (71) 3115-9826 / 3812<br>"	
							texto = texto & "E-mail: sistemas.sema@sema.ba.gov.br<br><br>"
							
							texto = texto & "<font color=#ff0000><strong>A T E N Ç Ã O! Sua senha é pessoal e intransferivel<strong></font><br><br>"	
							texto = texto & "<font color=#ff0000><strong>ACESSE: intranet.meioambiente.ba.gov.br 'SISTEMAS' Digite seu login e senha"
							
							Mail.HTMLBody = texto		   
							Mail.Priority = 3		 
							
							Mail.Send(smtp_server_address) 

							If Err <> 0 Then ' error occurred
								bSuccess = False	  
							Else
								bSuccess = True
								Response.Redirect PaginaLocal & "Inicio.asp"								
							End If
						 							
					Else
							MensagemErroBD = "LOGIN EXISTENTE."	
					End If
			
		ElseIf AcaoSistema = "consultar" Then	
		
					Codigo = Request.QueryString("cod")
										
					Session("UsuarioEmail") = 0
					
					sqlConsulta = "SELECT pessoa_nm, eof.est_organizacional_id, funcionario_email, funcionario_ramal, p.pessoa_id FROM dados_unico.pessoa p, dados_unico.pessoa_fisica pf, dados_unico.est_organizacional_funcionario eof, dados_unico.funcionario f WHERE (pf.pessoa_id = f.pessoa_id) AND (eof.funcionario_id = f.funcionario_id) AND eof.est_organizacional_funcionario_st = 0 AND pessoa_fisica_funcionario = 1 AND (p.pessoa_id = pf.pessoa_id) AND p.pessoa_id = " & Codigo						
					Set rsConsulta = objConexao.execute(sqlConsulta)

					If Not rsConsulta.eof Then
			
						Codigo				= rsConsulta("pessoa_id")
						Nome	  	  	   	= rsConsulta("pessoa_nm")
						EstOrganizacional  	= rsConsulta("est_organizacional_id")
						Email  				= rsConsulta("funcionario_email")	
						Ramal  				= rsConsulta("funcionario_ramal")
						
						sqlConsultaUsuario = "SELECT * FROM seguranca.usuario WHERE pessoa_id = " & Codigo
						Set rsConsultaUsuario = objConexao.execute(sqlConsultaUsuario)
						
						' traz o login caso o funcionario já possua login
						If Not rsConsultaUsuario.eof Then
							Login = rsConsultaUsuario("usuario_login")
						End If
						
						If Email <> "" Then
							Session("UsuarioEmail") = 1
						End If												
						
						If StatusNumero = "0" Then StatusNome = "Ativo" Else StatusNome = "Inativo" End If		
						
						sqlConsultaUsuario = "SELECT usuario_login FROM seguranca.usuario WHERE pessoa_id = " & Codigo
						Set rsConsultaUsuario = objConexao.execute(sqlConsultaUsuario)
						
						If Not rsConsultaUsuario.eof Then
							PossuiLogin = 1
						Else
							PossuiLogin = 0
						End If
						
					Else											
						MensagemErroBD = "REGISTRO NÃO EXISTENTE."							
					End If	
							
		ElseIf AcaoSistema = "alterar" Then	

					Codigo 		= Request.Form("txtCodigo")	
					Login		= Trim(LCase(Request.Form("txtLogin")))
					Email		= Trim(LCase(Request.Form("txtEmail")))		
					
					sqlConsulta = "SELECT pessoa_id FROM seguranca.usuario WHERE (UPPER(usuario_login) = '" & UCase(Descricao) & "') AND pessoa_id <> " & Codigo
					Set rsConsulta = objConexao.execute(sqlConsulta)
			
					If rsConsulta.eof Then							
			
							sqlAltera = "UPDATE seguranca.usuario SET usuario_login = '" & Login & "', usuario_dt_alteracao = '" & Date & "' WHERE pessoa_id = " & Codigo
							objConexao.execute(sqlAltera)
							
							sqlAltera = "UPDATE dados_unico.funcionario SET funcionario_email = '" & Email & "' WHERE pessoa_id = " & Codigo
							ObjConexao.execute(sqlAltera)

							sqlSistema = "SELECT * FROM seguranca.sistema WHERE sistema_st = 0 ORDER BY UPPER(sistema_ds)"
							Set rsSistema = objConexao.execute(sqlSistema)						
							
							If Not rsSistema.eof Then
							
								Set SistemaAcessoCodigo = rsSistema("sistema_id")
								
								sqlDeleta = "DELETE FROM seguranca.usuario_tipo_usuario WHERE pessoa_id = " & Codigo
								ObjConexao.execute(sqlDeleta)									

								While Not rsSistema.eof
																						
									TipoUsuario = Request.Form("radio" & SistemaAcessoCodigo & "")
									
									If TipoUsuario <> "" Then

										sqlInsere = "INSERT INTO seguranca.usuario_tipo_usuario (pessoa_id, tipo_usuario_id) VALUES (" & Codigo & ", " & TipoUsuario & ")"
										objConexao.execute(sqlInsere)							

									End If
									
									rsSistema.MoveNext
								Wend					
							End If	
								
							Response.Redirect PaginaLocal & "Inicio.asp"	
			
					Else	
						MensagemErroBD = "REGISTRO JÁ EXISTENTE."	
					End If	
				
		ElseIf AcaoSistema = "alterarStatus" Then
		
					DataAlteracao 	= Date
					Codigo 			= request.QueryString("cod")
					StatusNumero 	= request.QueryString("status")
					
					If StatusNumero = 0 Then StatusNumero = 1 Else StatusNumero = 0 End If
									
					sqlAltera = "UPDATE seguranca.usuario SET usuario_st = " & StatusNumero & ", usuario_dt_alteracao = '" & DataAlteracao & "' WHERE usuario_id = " & Codigo
					objConexao.execute(sqlALtera)
					
					Response.Redirect PaginaLocal & "Inicio.asp"	
			
		ElseIf AcaoSistema = "excluir" Then			
				
					Codigo	= Request.QueryString("cod")		
					sqlDeleta = "UPDATE seguranca.usuario SET usuario_st = 2  WHERE pessoa_id = " & Codigo
		
					objConexao.execute(sqlDeleta)				
			
					Response.Redirect PaginaLocal & "Inicio.asp"	
						
		End If
%>