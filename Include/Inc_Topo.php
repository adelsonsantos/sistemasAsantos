<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="250" align="left"><img src="../Imagens/logo_menor.gif"/></td>
        <td align="right" valign="top">
        <?php
          If (($_SESSION['UsuarioCodigo']!= "")&& ($_SESSION['ValidacaoPropria']== "1") && ($_SESSION['ValidacaoRH']== "1"))
          {
        ?>
            &nbsp;<a href="../Home/Senha.php"><font color="#666666">Alterar Senha</font></a>&nbsp;
            &nbsp;<a href="../Home/Login.php"><font color="#FF0000">Efetuar logoff</font></a>&nbsp;
        <?php
          }
?>		            
        </td>
    </tr>
</table>