<script type="text/javascript" language="javascript">
    function alteraMes(frm)
    {
        frm.action = "CadastroSaldoRecursoInicio.php?filtroMes="+$('#cmbMes').val();
        frm.submit();
    }
</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td align="center" class="tabPesquisa" >
            <table cellpadding="0" border="0" cellspacing="0" width="100%">
                <tr>
                    <td><img src="../Imagens/vazio.gif" width="1" height="3" border="0"/></td>
                </tr>
                <tr>
                    <td valign="top" class="LinhaTexto">
                        <table cellpadding="0" border="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="270" class="dataField"><input name="txtFiltro" maxlength="100" type="text" value="<?=$RetornoFiltro?>" style=" width:265px;" onKeyPress="Javascript:if(event.keyCode == 13){FiltrarForm(document.Form);}"/></td>
                                <td width="75" valign="middle"><input type="button" style="width:70px; height: 18px;" onClick="Javascript:FiltrarForm(document.Form);" class="botao" value="Pesquisar"/></td>
                                <?php  
                                if($RetornoFiltro!="") 
                                { 
                                ?>
                                <td valign="middle"><input type="button" style="width:90px; height:18px;" onClick="Javascript:TodosForm(document.Form);" class="botao" value="Exibir Todos"/></td>
                                <?php                             
                                } 
                                else 
                                { 
                                ?>
                                    <td>&nbsp;</td>
                                <?php                                 
                                }
                                ?>
                                <td class="dataLinha" align="right">Mês
                                  <?php f_ComboMes('cmbMes','150','8','onchange="Javascript:alteraMes(document.Form);"',$_GET['filtroMes']);?>
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