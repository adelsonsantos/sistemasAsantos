<script language="javascript">

    function Redirect(frm)
    {
        frm.action = "SolicitacaoConsultaGlobalInicio.php?Status="+frm.cmbStatusSolicitacao.value+"&ano="+frm.cmbanoSolicitacao.value;
        frm.submit();
    }
    
</script>

<table cellpadding="0" cellspacing="0" border="0" width="800">
    <tr>
        <td align="center" class="tabPesquisa" >
            <table cellpadding="0" border="0" cellspacing="0" width="100%">
                <tr>
                    <td><img src="../SistemaCadastro/Imagens/vazio.gif" width="1" height="3" border="0"/></td>
                </tr>
                <tr>
                    <td valign="top" class="LinhaTexto">
                        <table cellpadding="0" border="0" cellspacing="0" width="100%">
                            <tr>
                                <td class="dataLinha" align="right">Status SD
                                        <?php
                                        $StatusSolicitacao0  = "";
                                        $StatusSolicitacao1  = "";
                                        $StatusSolicitacao2  = "";
                                        $StatusSolicitacao3  = "";
                                        $StatusSolicitacao4  = "";
                                        $StatusSolicitacao5  = "";
                                        $StatusSolicitacao6  = "";
                                        $StatusSolicitacao7  = "";
                                        $StatusSolicitacao8  = "";
                                        $StatusSolicitacao9  = "";

                                        if($StatusSolicitacao == "")
                                        {
                                            $StatusSolicitacao0 = "Selected";
                                        }
                                        elseif ($StatusSolicitacao == 0)
                                        {
                                            $StatusSolicitacao0 = "Selected";
                                        }
                                        elseif ($StatusSolicitacao == 1)
                                        {
                                            $StatusSolicitacao1="Selected";
                                        }
                                        elseif ($StatusSolicitacao == 2)
                                        {
                                            $StatusSolicitacao2="Selected";
                                        }
                                        elseif ($StatusSolicitacao == 3)
                                        {
                                            $StatusSolicitacao3 = "Selected";
                                        }
                                        elseif ($StatusSolicitacao == 4)
                                        {
                                            $StatusSolicitacao4 = "Selected";
                                        }
                                        elseif ($StatusSolicitacao == 5)
                                        {
                                            $StatusSolicitacao5 = "Selected";
                                        }
                                        elseif ($StatusSolicitacao == 6)
                                        {
                                            $StatusSolicitacao6 = "Selected";
                                        }
                                        elseif ($StatusSolicitacao == 7)
                                        {
                                            $StatusSolicitacao7 = "Selected";
                                        }
                                        elseif ($StatusSolicitacao == 8)
                                        {
                                            $StatusSolicitacao8 = "Selected";
                                        }
                                        elseif ($StatusSolicitacao == 9)
                                        {
                                            $StatusSolicitacao9 = "Selected";
                                        }                                        
                                        elseif ($StatusSolicitacao == 10)
                                        {
                                            $StatusSolicitacao10 = "Selected";
                                        }

                                        echo "<select name='cmbStatusSolicitacao' onchange='Redirect(document.Form);'>";
                                            echo "<option value='0' ".$StatusSolicitacao0.">Autoriza&ccedil;&atilde;o </option>";
                                            echo "<option value='1' ".$StatusSolicitacao1.">Aprova&ccedil;&atilde;o</option>";
                                            echo "<option value='2' ".$StatusSolicitacao2.">Empenho</option>";
                                            echo "<option value='3' ".$StatusSolicitacao3.">Execu&ccedil;&atilde;o</option>";
                                            echo "<option value='4' ".$StatusSolicitacao4.">Comprova&ccedil;&atilde;o</option>";
                                            echo "<option value='5' ".$StatusSolicitacao5.">Aprova&ccedil;&atilde;o de Comprova&ccedil;&atilde;o</option>";
                                            echo "<option value='6' ".$StatusSolicitacao6.">Aguardando Arquivamento</option>";
                                            echo "<option value='7' ".$StatusSolicitacao7.">Arquivada </option>";
                                            echo "<option value='8' ".$StatusSolicitacao8.">Devolvida</option>";
                                            echo "<option value='9' ".$StatusSolicitacao9.">Excluida</option>";
                                            echo "<option value='10' ".$StatusSolicitacao9.">Comprovação Aprovação SEI</option>";
                                        echo "</select>";
                                        ?>
                                        Ano                                        
                                        <?php                                        
                                            $sqlAno = "SELECT DISTINCT EXTRACT(YEAR FROM diaria_dt_criacao) AS ano
                                                         FROM diaria.diaria
                                                        WHERE diaria_excluida = 0
                                                       ORDER BY ano DESC";
                                        
                                            $rsConsultaAno = pg_query(abreConexao(),$sqlAno);
                                            echo "<select name='cmbanoSolicitacao' onchange='Redirect(document.Form);'>";
                                            
                                            while ($linhaAno = pg_fetch_assoc($rsConsultaAno))
                                            {        
                                                if($linhaAno['ano'] == date('Y'))
                                                {
                                                    echo "<option value=".$linhaAno['ano']." selected>".$linhaAno['ano']."</option>";                                                                  
                                                }
                                                elseif($linhaAno['ano'] == $_GET['ano'])
                                                {
                                                    echo "<option value=".$linhaAno['ano']." selected>".$linhaAno['ano']."</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value=".$linhaAno['ano']." >".$linhaAno['ano']."</option>"; 
                                                }                                                                                                                                              
                                            }   
                                            echo "</select>"; 
                                        ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><img src="../SistemaCadastro/Imagens/vazio.gif" width="1" height="2" border="0"/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
