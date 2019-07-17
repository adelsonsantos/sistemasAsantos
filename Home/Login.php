<?php
//Valida o browser do cliente.
$u_agent = $_SERVER['HTTP_USER_AGENT'];
$ub      = '';

$_SESSION['UsuarioCodigo'] = "";
include_once '../Include/Inc_Conexao.php';


if ($_GET['acao']== "verificarLogin") 
{
    $Login = strtolower($_POST['txtLogin']);
    $Senha = sha1($_POST['txtSenha']);

    $sqlConsulta = "SELECT * 
                      FROM seguranca.usuario u,
                           dados_unico.pessoa p, 
                           dados_unico.funcionario f,
                           dados_unico.est_organizacional_funcionario eof,
                           dados_unico.est_organizacional eo
                     WHERE (eof.est_organizacional_id = eo.est_organizacional_id)
                       AND (f.funcionario_id = eof.funcionario_id) 
                       AND (est_organizacional_funcionario_st = 0) 
                       AND (p.pessoa_id = f.pessoa_id) 
                       AND (u.pessoa_id = p.pessoa_id) 
                       AND pessoa_st <> 2 
                       AND usuario_login = '".addslashes($Login)."'
                       AND usuario_senha = '".addslashes($Senha)."'";

    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    
    $linha      = pg_fetch_assoc($rsConsulta);

    if($linha) 
    {
        $_SESSION['UsuarioCoordenadoria'] = $linha['id_coordenadoria'];
        $_SESSION['UsuarioCodigo']        = $linha['pessoa_id'];
        $_SESSION['UsuarioNome']          = $linha['pessoa_nm'];
        $_SESSION['UsuarioEstCodigo']     = $linha['est_organizacional_id'];
        $_SESSION['UsuarioEst']           = $linha['est_organizacional_sigla'];

        $sql = "SELECT utu.tipo_usuario_id, tipo_usuario_ds 
                  FROM seguranca.usuario_tipo_usuario utu, seguranca.tipo_usuario tu 
                 WHERE (utu.tipo_usuario_id = tu.tipo_usuario_id) 
                   AND pessoa_id = ".$_SESSION["UsuarioCodigo"];

        $rs     = pg_query(abreConexao(),$sql);
        $linha2 = pg_fetch_assoc($rs);

        $sqlConsultaEstOrganizacional = "SELECT est_organizacional_sigla 
                                           FROM dados_unico.est_organizacional 
                                          WHERE est_organizacional_id = ".$_SESSION['UsuarioEstCodigo'];
        $rsConsultaEstOrganizacional  = pg_query(abreConexao(),$sqlConsultaEstOrganizacional);
        $linha3                       = pg_fetch_assoc($rsConsultaEstOrganizacional);

        $_SESSION['UsuarioEstDescricao'] = $linha3['est_organizacional_sigla'];
        $_SESSION['PrimeiroLogon']       = $linha['usuario_primeiro_logon'];

        if ($_SESSION['PrimeiroLogon'] == "1") 
        {
            header("Location: Senha.php?primeiro=1");
        }
        else 
        {		
            exit(header("Location: Home.php"));
        }
    }
    else
    {   
        header("Location: Login.php?erro=1");
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
        //window.onload = location.href="Login_Manutencao.php";
            function Foco(frm)
            {
                frm.txtLogin.focus();
            }

            function GravarForm(frm)
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
                if (frm.txtSenha.value == "")
                {
                    alert("Campo SENHA em Branco.");
                    frm.txtSenha.focus();
                    frm.txtSenha.style.backgroundColor='#B9DCFF';
                    return false;
                }
                frm.action = "Login.php?acao=verificarLogin";
                frm.submit();
            }            
        </script>
    </head>
    <body style=" margin-right:5px;" onLoad="Foco(document.Form);">
        <form name="Form" method="post" action="">
            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><?php include "../Include/Inc_Topo.php" ?></td>
                </tr>
                <tr>
                    <td align="right">
                        <table border="0" cellpadding="0" cellspacing="1">
                            <tr height="21" class="dataLinha">
                                <td width="60">&nbsp;<b>Login</b></td>
                                <td width="110">&nbsp;<input name="txtLogin" maxlength="35" type="text" style=" width:100px;"/></td>
                                <td width="60">&nbsp;<b>Senha</b></td>
                                <td width="110">&nbsp;<input name="txtSenha" maxlength="10" type="password" style=" width:100px;"/></td>
                                <td><input type="submit" value="Entrar" style=" width:80px;" class="botao" onClick="javascript:GravarForm(document.Form)"/>&nbsp;&nbsp;&nbsp;</td>
                                <td><a href="EsqueceuSenha.php"><font class="dataLinha">Esqueceu sua senha?</font></a></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="MensagemErro"><?php $Erro?></td>
                            </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="3"><img src="../Imagens/vazio.gif" height="1"/></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bgcolor"><img src="../Imagens/vazio.gif" height="16"/></td>
                            </tr>
                            <tr>
                                <td colspan="3"><img src="../Imagens/vazio.gif" height="5"/></td>
                            </tr>
                        </table>
<?php
$Erro = $_GET['erro'];

if($Erro == 1) 
{?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="MensagemErro" align="right"><b>Login ou senha inv&aacute;lidos</td>
                            </tr>
                        </table>
<?php } ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <br><br>
                    <table align="center" width="800" cellspacing="0" cellpadding="0" border="0">
                        <tr>              
                            <td width="500" class="dataLinha" valign="top"><p align="justify"><font size="2">O portal de Sistemas &eacute; um canal &uacute;nico de acesso aos sistemas de informa&ccedil;&atilde;o  no da Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia - ADAB, que visa centralizar e facilitar o acesso &agrave;s aplica&ccedil;&otilde;es, a partir de uma base de dados &uacute;nica.</p></td>
                            <td width="20"></td>
                            <td valign="top">
                                <table align="center" width="300" cellspacing="0" cellpadding="0" border="0">     
                                    <tr height="21">
                                        <td class="dataLinha"><font size="2"> <img src="../Imagens/calendar.png" />&nbsp;<u>Data de implantação 22/11/2010</u></td>
                                    </tr>
                                   <!-- <tr height="21">
                                        <td class="dataLinha"><font size="2"> <img src="../Imagens/pdf_button.png" />&nbsp;<u>Vers&atilde;o 01.09</u></font></td>
                                    </tr>-->
                                    <tr height="21">
                                        <td class="dataLinha"><font size="2"> <img src="../Imagens/pdf_button.png" />   <a href="http://www2.uesb.br/proreitorias/asplan/wp-content/uploads/Decreto_13169_12Ago2011.pdf"><u>Decreto N&ordm; 13.169 de 12 de Agosto de 2011</u></a></td>
                                    </tr>
                                   <!-- <tr height="21">
                                        <td class="dataLinha"><font size="2"> <img src="../Imagens/pdf_button.png" /> <a href="../SistemaDiarias/Pdf/DECRETO80942002.pdf"><u>Decreto N&ordm; 8.094 de 07 de Janeiro de 2002</u></a></td>
                                    </tr>
                                    <tr height="21">
                                        <td class="dataLinha"><font size="2"> <img src="../Imagens/pdf_button.png" /> <a href="../SistemaDiarias/Pdf/DECRETO99602006.pdf"><u>Decreto N&ordm; 9.960 de 30 de Mar&ccedil;o de 2006</u></a></td>
                                    </tr>
                                    <tr height="21">
                                        <td class="dataLinha"><font size="2">  <img src="../Imagens/pdf_button.png" /> <a href="../SistemaDiarias/Pdf/Manual.pdf"><u>Manual</u></a></td>-->
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </td>
                </tr>
            </table>
            <br>
        </form>
    </body>
</html>