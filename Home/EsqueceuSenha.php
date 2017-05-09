<?php
include_once"../Include/Inc_Conexao.php";
include_once"../Include/Inc_Funcao.php";

$acao  = $_GET['acao'];
$login = strtolower($_POST['txtLogin']);

If($acao == "enviarSenha")
{
    $sql = "SELECT funcionario_email, usuario_senha, usuario_login FROM dados_unico.pessoa p, seguranca.usuario u, dados_unico.funcionario f WHERE (p.pessoa_id = f.pessoa_id) AND (p.pessoa_id = u.pessoa_id) AND usuario_login = '".$login."'";
    $rs = pg_query(abreConexao(),$sql);
    $linhars=pg_fetch_assoc($rs);
    
    If ($linhars)
    {
                        // DESTINATÁRIO
        $toEmail = $linhars['funcionario_email'];
        // SENHA
        $Senha = f_GeraSenha();               
        
        // REMETENTE
        $FromEmail = "sistemas.adab@adab.ba.gov.br";
        $FromName = "Sistema Corporativo (ADAB - Agencia de Defesa Agropecuaria da Bahia)";
        // ASSUNTO
        $subj = "Informativo - Senha para acesso ao Sistema Corporativo de Di&aacute;rias";
        // MESSAGEM
        $msg .= "Caro(a) Servidor(a),<br><br>";
        $msg.= "Conforme solicitação , encaminhamos abaixo sua senha:<br><br>";
        $msg.= "Login: ".$linhars['usuario_login']."<br>";   
        $msg.= "Senha: ".$Senha."<br><br>";
        $msg.= "<font color=#ff0000><strong>ACESSE O <a href='http://sdadab.ba.gov.br/gestor/Home/Login.php' target='_blank'> Sistema de Diárias</a> DIGITE SEU LOGIN E SENHA<strong></font><br><br>";
        $msg.= "<font><strong>A T E N Ç Ã O! Sua senha é pessoal e intransferível<strong></font><br><br>";		                	
        $msg.= "Assessoria de Planejamento Estratégico (APE)<br>";
        $msg.= "GT Sistemas<br>";
        $msg.= "Telefones: (71) 3116-7824 / 7861<br><br>";
        $msg.= "E-mail: sistemas.adab@adab.ba.gov.br<br><br><br>";
        // CABECALHO
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers.= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers.= 'To: <'.$toEmail.'>' . "\r\n";
        $headers.= 'From: '.$FromName.' <'.$FromEmail.'>' . "\r\n";

        if(mail( $toEmail,$subj,$msg,$headers))
        {  // enviando o email
            $Erro = "Sua senha foi enviada para o e-mail ".$toEmail;
        }
        else
        {
            $Erro = "Ocorreu um erro ao tentar enviar o email";
        }
    }
    Else
    {
            $Erro = "Login inv&aacute;lido!";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="pt-BR" lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="Description" content="ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia" />
        <meta name="Keywords" content="ADAB, Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia, Defesa Agropecu&aacute;ria, Agropecu&aacute;ria Bahia" />
        <meta name="language" content="pt-br" />
        <meta name="distribution" content="Global" />
        <meta name="rating" content="General" />
        <meta name="DC.title" content="ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia" />
        <title>ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia</title>    
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <script language="javascript">        
            function Foco(frm)
            {
                    frm.txtLogin.focus();
            }
            function Enviar(frm)
            {
                for(cont=0; cont < frm.elements.length; cont++)
                        frm.elements[cont].style.backgroundColor = '';

                if (frm.txtLogin.value == "")
                {
                        alert("Campo LOGIN em Branco.");
                        frm.txtLogin.focus();
                        frm.txtLogin.style.backgroundColor='#B9DCFF';
                        return false;
                }
                frm.action = "EsqueceuSenha.php?acao=enviarSenha";
                frm.submit();
            }
            function Voltar(frm)
            {
                frm.action = "Login.php";
                frm.submit();
            }    
        </script>
    </head>
    <body onLoad="Foco(document.Form);" style=" margin-right:5px;">
        <form name="Form" method="post" action="">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                <td><?include "../Include/Inc_Topo.php"?></td>
                </tr>
                <tr>
                    <td align="right">
                        <table border="0" cellpadding="0" cellspacing="1">
                            <tr height="21" class="dataLinha">
                                <td width="120">&nbsp;<b>Informe seu Login</b></td>
                                <td width="140">&nbsp;<input name="txtLogin" maxlength="35" type="text" style=" width:130px;"></td>
                                <td><input type="button" value="Enviar senha por e-mail" style=" width:140px;" class="botao" onClick="javascript:Enviar(document.Form)">&nbsp;&nbsp;&nbsp;<input type="button" value="Voltar" style=" width:70px;" class="botao" onClick="javascript:Voltar(document.Form)"></td>
                            </tr>
                        </table>
                            </td>
                    </tr>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="3"><img src="../Imagens/vazio.gif" height="1"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bgcolor"><img src="../Imagens/vazio.gif" height="16"></td>
                            </tr>
                            <tr>
                                <td colspan="3"><img src="../Imagens/vazio.gif" height="5"></td>
                            </tr>
                        </table>
                            </td>
                    </tr>
                <tr>
                    <td valign="top" align="right">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="MensagemErro" align="right"><b><?=$Erro?></b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>