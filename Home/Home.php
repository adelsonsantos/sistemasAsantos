<?php 
    include '../Include/Inc_Configuracao.php';
    
    $sql = "SELECT funcionario_validacao_propria, funcionario_validacao_rh FROM dados_unico.funcionario WHERE pessoa_id = " .$_SESSION['UsuarioCodigo'];

    $rs    = pg_query(abreConexao(),$sql);
    $linha = pg_fetch_assoc($rs);
    $_SESSION['ValidacaoPropria'] = $linha['funcionario_validacao_propria'];
    $_SESSION['ValidacaoRH']      = $linha['funcionario_validacao_rh'];

    /*if ((int)($_SESSION['ValidacaoPropria'])== 0){
        header("Location: ../SistemaCadastro/validacaofuncionario.php");
    }*/
    if (((int)($_SESSION['ValidacaoPropria'])==1)&&((int)($_SESSION['ValidacaoRH'])==0)){
        header("Location: ../SistemaCadastro/validacaoaguardando.php");
    }
    $sqlSistema = "SELECT s.sistema_id, sistema_url FROM seguranca.sistema s, seguranca.usuario u, seguranca.usuario_tipo_usuario utu, seguranca.tipo_usuario tp WHERE
                   (utu.pessoa_id = u.pessoa_id) AND (s.sistema_id = tp.sistema_id) AND (tp.tipo_usuario_id = utu.tipo_usuario_id) AND sistema_st = 0 AND
                    u.pessoa_id = ".$_SESSION['UsuarioCodigo']. " ORDER BY UPPER(sistema_nm)";
    $rsSistema = pg_query(abreConexao(),$sqlSistema);
    $linha2=pg_fetch_assoc($rsSistema);
    if($linha2==1){
        header("Location:'" .$linha2['sistema_url']."?sistema=".$linha['sistema_id']."'");
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
    </head>
    <body>
        <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td><?php include "../Include/Inc_Topo.php" ?></td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="2"><img src="../Imagens/vazio.gif" height="5" /></td>
                        </tr>
                        <tr>
                            <td align="left" width="115">
                                <table width="115" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="9" background="../Imagens/bg_tab.gif"><img src="../Imagens/tab_esq.gif" width="9" height="20" /></td>
                                        <td width="198" background="../Imagens/bg_tab.gif"><div align="center"><a class="linktab" href="Home.php">In&iacute;cio</a></div></td>
                                        <td width="8" background="../Imagens/bg_tab.gif"><img src="../Imagens/tab_dir.gif" width="8" height="20" /></td>
                                    </tr>
                                </table>
                            </td>
                            <td align="right">
                                <table width="530" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="dataLinha" align="right">&nbsp;<b>Usu&aacute;rio</b>: <?= $_SESSION['UsuarioNome'] ?>&nbsp;&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><img src="../Imagens/vazio.gif" height="1" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bgcolor"><img src="../Imagens/vazio.gif" height="16" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><img src="../Imagens/vazio.gif" height="5" /></td>
                        </tr>
                    </table>

                </td>
            </tr>
            <tr>
                <td><?php include "../Include/Inc_Sistema.php" ?></td>
            </tr>
            <tr>
            </tr>
        </table>
    </body>
</html>

