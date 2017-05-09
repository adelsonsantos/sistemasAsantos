<script type="text/javascript" language="javascript">

    function Redirect(frm)
    {
        frm.action = "<?=$PaginaLocal?>Inicio.php?validado="+frm.cmbStatusValidados.value;
        frm.submit();
    }

</script>

<table cellpadding="0" cellspacing="0" border="0" width="100%"  class="tabPesquisa">
    <tr>
        <td align="center" >
            <table cellpadding="0" border="0" cellspacing="0" width="100%">
                <tr>
                    <td><img src="../Imagens/vazio.gif" width="1" height="3" border="0"/></td>
                </tr>
                <tr>
                    <td valign="top" >
                        <table cellpadding="0" border="0" cellspacing="0" width="100%">
                            <tr class="LinhaTexto">
                                <td align="right">Ver Funcion&aacute;rios
                                <?php
                                    if($numFiltroFuncionario == "")
                                    {	
                                        $strValidado = "selected";
                                        $strNaoValidado = "";
                                    }
                                    elseif ($numFiltroFuncionario == 0) 
                                    {
                                        $strValidado = "";
                                        $strNaoValidado = "selected";
                                    }	
                                    elseif ($numFiltroFuncionario == 1) 
                                    {
                                        $strValidado = "selected";
                                        $strNaoValidado = "";
                                    }

                                    echo "<select name='cmbStatusValidados' onchange='Redirect(document.Form);'>";
                                    echo "  <option value='1' ".$strValidado.">Validado pelo RH</option>";
                                    echo "  <option value='0' ".$strNaoValidado.">N&atilde;o Validado pelo RH</option>";
                                    echo "</select>"
                                ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><img src="../Imagens/vazio.gif" width="1" height="2" border="0"/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
