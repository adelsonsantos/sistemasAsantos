<?php
include 'Inc_Linha.php';

if($_SESSION['Sistema']== "" )
{  
    echo "<script>window.location = '../Home/Login.php';</script>";
}
else
{
    $sql    = "SELECT sistema_nm, sistema_url FROM seguranca.sistema WHERE sistema_id = '" .$_SESSION['Sistema']."'";
    $rs     = pg_query(abreConexao(),$sql);
    $linha  =pg_fetch_assoc($rs);

    if($linha)
    {
        $SistemaNome = $linha['sistema_nm'];
        $SistemaURL  = $linha['sistema_url'];
    }
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="left" width="115">
            <table width="115" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="9" background="../Imagens/bg_tab.gif"><img src="../Imagens/tab_esq.gif" width="9" height="20"/></td>
                    <td width="198" background="../Imagens/bg_tab.gif"><div align="center"><a class="linktab" href="../Home/Home.php">In&iacute;cio</a></div></td>
                    <td width="8" background="../Imagens/bg_tab.gif"><img src="../Imagens/tab_dir.gif" width="8" height="20"/></td>
                </tr>
            </table>
        </td>
        <td width="215" align="left">
            <table width="215" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="9" background="../Imagens/bg_tab_on.gif"><img src="../Imagens/tab_esq_on.gif" width="9" height="20"/></td>
                    <td width="198" background="../Imagens/bg_tab_on.gif"><div align="center"><font class="linktab"><?=$SistemaNome?></font></div></td>
                    <td width="8" background="../Imagens/bg_tab_on.gif"><img src="../Imagens/tab_dir_on.gif" width="8" height="20"/></td>
                </tr>
            </table>
        </td>
        <td align="right">
            <table width="530" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="dataLinha" align="right"><b>Acesso: </b><?=$_SESSION["Sistemas"][$_SESSION["Sistema"]]?>&nbsp;&nbsp;&nbsp;&nbsp;<b>Usu&aacute;rio</b>: <?=$_SESSION['UsuarioNome']?></td>
                </tr>
            </table>
        </td>           
    </tr>
    <tr>
    	<td colspan="3"><img src="../Imagens/vazio.gif" height="1"/></td>
    </tr>
    <tr>
    	<td colspan="3" class="bgcolor"><img src="../Imagens/vazio.gif" height="6"/></td>
    </tr>
    <tr>
    	<td colspan="3"><img src="../Imagens/vazio.gif" height="5"/></td>
    </tr>
</table>

