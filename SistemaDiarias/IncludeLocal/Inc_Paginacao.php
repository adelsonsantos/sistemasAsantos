<table border="0" cellpadding="0" cellspacing="0" width="798">
<?php 
if ($qtdPagina > 0)
{
    ?>
    <tr class="GridPaginacaoCabecalhoClaro">
        <td width="98" align="left">P&aacute;gina <?= $paginaAtual ?> de <?= $qtdPagina ?></td>
        <td width="500" align="center">&nbsp;
        <?php
	if ($qtdPagina < 5)
        {
            if ($paginaAtual > 1)
            {
                $paginaAnterior = ($paginaAtual-2);
                echo "<a href='".$PaginaLocal."Inicio.php?acao=$AcaoSistema&PaginaMostrada=$paginaAnterior&cmbStatus=$cmbStatus&cmbAno=$cmbAno&filtro=$retornoFiltro&order=$order&typeOrder=$typeOrder'><font color='#065387'>[Anterior]</font></a>&nbsp;&nbsp;";
            }
            if ($qtdPagina > 1)
            {
                for ( $contadorPaginacao = 1; $contadorPaginacao <= $qtdPagina; $contadorPaginacao++)
                {
                    if ($contadorPaginacao == $paginaAtual)
                    {
                        echo "<font color='#000000' size='1'>&nbsp;<B>$contadorPaginacao</B>&nbsp;</strong>";
                    }
                    else
                    {
                        $paginaMostrar = ($contadorPaginacao -1);
                        echo "&nbsp;<a href='".$PaginaLocal."Inicio.php?acao=$AcaoSistema&acao=$AcaoSistema&PaginaMostrada=$paginaMostrar&cmbStatus=$cmbStatus&cmbAno=$cmbAno&filtro=$retornoFiltro&order=$order&typeOrder=$typeOrder'><font color='#065387' size='1'>$contadorPaginacao</font></a>&nbsp;";
                    }
		}
            }

            if ( $paginaAtual < $qtdPagina)
            {
                echo "&nbsp;&nbsp;<a href='".$PaginaLocal."Inicio.php?acao=$AcaoSistema&PaginaMostrada=$paginaAtual&cmbStatus=$cmbStatus&cmbAno=$cmbAno&filtro=$retornoFiltro&order=$order&typeOrder=$typeOrder'><font color='#065387'>[Pr&oacute;xima]</font></a>";
            }
        }
        else // >25
	{
            if ($paginaAtual > 1)
            {
                $paginaAnterior = ($paginaAtual-2);
		echo "<a href='".$PaginaLocal."Inicio.php?acao=$AcaoSistema&PaginaMostrada=$paginaAnterior&cmbStatus=$cmbStatus&cmbAno=$cmbAno&filtro=$retornoFiltro&order=$order&typeOrder=$typeOrder'><font color='#065387'>[Anterior]</font></a>&nbsp;&nbsp;";
					
		print "<a href='".$PaginaLocal."Inicio.php?acao=$AcaoSistema&PaginaMostrada=0&cmbStatus=$cmbStatus&cmbAno=$cmbAno&filtro=$retornoFiltro&order=$order&typeOrder=$typeOrder'><font color='#065387'>1</font></a>";
		print "<font color='#065387'>...</font>";
            }
            for ( $contadorPaginacao = 1; $contadorPaginacao <= $qtdPagina; $contadorPaginacao++)
            {
                if ($contadorPaginacao == $paginaAtual)
		{
                    print "<font color='#000000' size='1'><B>$contadorPaginacao</B></strong>";
		}
            }
            if ( $paginaAtual < $qtdPagina)
            {
                $ultimaPag=$qtdPagina-1;
		print "<font color='#065387'>...</font>";
		print "<a href='".$PaginaLocal."Inicio.php?acao=$AcaoSistema&PaginaMostrada=$ultimaPag&cmbStatus=$cmbStatus&cmbAno=$cmbAno&filtro=$retornoFiltro&order=$order&typeOrder=$typeOrder'><font color='#065387'>$qtdPagina</font></a>&nbsp;&nbsp;";
		echo "&nbsp;&nbsp;<a href='".$PaginaLocal."Inicio.php?acao=$AcaoSistema&PaginaMostrada=$paginaAtual&cmbStatus=$cmbStatus&cmbAno=$cmbAno&filtro=$retornoFiltro&order=$order&typeOrder=$typeOrder'><font color='#065387'>[Pr&oacute;xima]</font></a>";
            }
	}
	?>
        &nbsp;
        </td>
        <td width="200" align="right">Registros Encontrados [ <?= $qtdRegistroTotal?> ]</td>
    </tr>
<?php 
}
else
{
    ?>
    <tr class="GridPaginacaoCabecalhoClaro">
        <td width="798" align="center">N&atilde;o Existe Registro</td>
    </tr>
    <?php 
}
?>
</table>