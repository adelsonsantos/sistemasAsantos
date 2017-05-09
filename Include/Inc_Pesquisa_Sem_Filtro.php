<script type="text/javascript" language="javascript">
    function PesquisarForm(frm)
    {
        if(frm.txtFiltro.value != '')
        {
            frm.action = "<?=$PaginaLocal?>Inicio.php?filtro="+frm.txtFiltro.value;            
            frm.submit();
        }          
    }
    function LimparForm(frm)
    {       
        frm.action = "<?=$PaginaLocal?>Inicio.php";
        frm.submit();
    }
</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td align="center" class="tabPesquisa" >
            <table cellpadding="0" border="0" cellspacing="0" width="798">
                <tr>
                    <td><img src="../Imagens/vazio.gif" width="1" height="3" border="0"/></td>
                </tr>
                <tr>
                    <td valign="top" class="LinhaTexto">
                        <table cellpadding="0" border="0" cellspacing="0" width="798">
                            <tr>
                                <td width="270" class="dataField">
                                    <input name="txtFiltro" id="txtFiltro" maxlength="100" value="<?=$RetornoFiltro?>" onKeyPress="Javascript: if((window.event ? event.keyCode : event.which) == 13) {PesquisarForm(document.Form);}" style="width:265px; height:15px;"/>
                                </td>
                                <td width="75">
                                    <input type="button" style="width:70px; height:18px;" onClick="Javascript:PesquisarForm(document.Form);" class="botao" value="Pesquisar"/>
                                </td>
                      <?php if($RetornoFiltro != "")
                            {?>
                                <td valign="middle" width="75">                                    
                                    <input type="button" name="limparFiltro" id="limparFiltro" style="width:90px; height:18px;" onClick="Javascript:LimparForm(document.Form);" class="botao" value="Exibir Todos"/>                                    
                                </td>
                      <?php }else
                            {?>
                                <td>&nbsp;</td>
                      <?php }?>                                   
                                <td width="380"></td>
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

