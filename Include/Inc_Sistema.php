<?php
$sqlConsulta = "SELECT s.sistema_id, 
                       sistema_nm, 
                       sistema_url, 
                       sistema_icone, 
                       tipo_usuario_ds 
                  FROM seguranca.sistema s, 
                       seguranca.usuario u, 
                       seguranca.usuario_tipo_usuario utu,
                       seguranca.tipo_usuario tp 
                 WHERE (utu.pessoa_id = u.pessoa_id) 
                   AND (s.sistema_id = tp.sistema_id) 
                   AND (tp.tipo_usuario_id = utu.tipo_usuario_id) 
                   AND sistema_st = 0 
                   AND u.pessoa_id = " . $_SESSION['UsuarioCodigo'] . " 
              ORDER BY UPPER(sistema_nm)";
$rsConsulta = pg_query(abreConexao(), $sqlConsulta);
?>
<table border="0" cellspacing="0" cellpadding="0">
    <tr>
<?php
        While ($linha = pg_fetch_assoc($rsConsulta)) 
        {
            $Codigo = $linha['sistema_id'];
            $Nome   = $linha['sistema_nm'];
            $URL    = $linha['sistema_url'];
            $Icone  = $linha['sistema_icone'];
            $ds     = $linha['tipo_usuario_ds'];
            $sistemas[$Codigo] = $ds;
?>
            <td width="100" valign="top">
                <table width="100" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100" align="center"><a href="<?=$URL?>?sistema=<?=$Codigo?>"><img src="../Icones/<?=$Icone?>" alt="<?=$Nome?>" border="0" /></a></td>
                    </tr>
                    <tr>
                        <td width="100" align="center"><a href="<?=$URL?>?sistema=<?=$Codigo?>"><font size="2"></font></a></td>
                    </tr>
                </table>
            </td>
            <td width="20"><img src="../Imagens/vazio.gif" width="20" /></td>
<?php
        }
        if (isset($_SESSION["Sistemas"]))
        {
            unset($_SESSION["Sistemas"]);
        }
        $_SESSION["Sistemas"] = $sistemas;
?>
    </tr>
</table>