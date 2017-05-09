<table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
    <tr>
        <td>
            <table width="798" border="0" cellpadding="0" cellspacing="1">
                <tr height="21" class="dataLabel">
                    <td width="150">&nbsp;Tipo de Funcion&aacute;rio</td>
                    <td width="135">&nbsp;Matr&iacute;cula</td>
                    <td width="135">&nbsp;Data de Admiss&atilde;o</td>
                    <td width="135">&nbsp;Data de Demiss&atilde;o</td>
                    <td width="233">&nbsp;E-Mail Institucional</td>
                </tr>
                <tr height="21" class="dataField">
                    <td>&nbsp;Definido pelo RH</td>
                    <td>&nbsp;<input name="txtMatricula" maxlength="20" type="text" value="<?=$Matricula?>" style=" width:120px;"></td>
                    <td>&nbsp;<input name="txtDtAdmissao" maxlength="10" type="text" value="<?=$DataAdmissao?>" style=" width:120px;" OnKeyUp="mascaraData(this.value, document.Form.txtDtAdmissao);"></td>
                    <td>&nbsp;<input name="txtDtDemissao" maxlength="10" type="text" value="<?=$DataDemissao?>" style=" width:120px;" OnKeyUp="mascaraData(this.value, document.Form.txtDtDemissao);"></td>
                    <td>&nbsp;<input name="txtFuncionarioEmail" maxlength="200" type="text" value="<?=$FuncionarioEmail?>" style=" width:200px;"></td>
                </tr>
             </table>


            <table width="798" border="0" cellpadding="0" cellspacing="1">
                <tr height="21" class="dataLabel">
                    <td width="150">&nbsp;Num. Carteira de Trabalho</td>
                    <td width="195" colspan="2">&nbsp;Carteira de Trabalho S&eacute;rie / UF</td>
                    <td width="140">&nbsp;PIS/PASEP</td>
                    <td>&nbsp;Conta FGTS</td>

                </tr>
                <tr height="21" class="dataField">
                    <td>&nbsp;<input name="txtCLTNumero" maxlength="20" type="text" value="<?=$CartTrabalho?>" style=" width:120px;"></td>
                    <td width="140">&nbsp;<input name="txtCLTSerie" maxlength="10" type="text" value="<?=$CartTrabalhoSerie?>" style=" width:120px;"></td>
                    <td width="55">&nbsp;<?=f_ComboEstado("cmbCLTUF","",$CartTrabalhoUF)?></td>
                    <td>&nbsp;<input name="txtPIS" maxlength="50" type="text" value="<?=$PIS?>" style=" width:120px;"></td>
                    <td>&nbsp;<input name="txtFGTS" maxlength="50" type="text" value="<?=$FGTS?>" style=" width:120px;"></td>

                </tr>
             </table>

            <table width="798" border="0" cellpadding="0" cellspacing="1">
                <tr height="21" class="dataLabel">
                    <td width="201">&nbsp;Banco</td>
                    <td width="110">&nbsp;Ag&ecirc;ncia</td>
                    <td width="150">&nbsp;Conta</td>
                    <td width="337">&nbsp;Tipo da Conta</td>
                </tr>
                <tr height="21" class="dataField">
                    <td>&nbsp;<?=f_ComboBanco($Banco)?></td>
                    <td>&nbsp;<input name="txtAgencia" maxlength="10" type="text" value="<?=$Agencia?>" style=" width:80px;"></td>
                    <td>&nbsp;<input name="txtConta" maxlength="10" type="text" value="<?=$Conta?>" style=" width:120px;"></td>
                    <td>&nbsp;<?=f_ComboTipoConta($TipoConta)?></td>
                </tr>
             </table>
                                 <table width="798" border="0" cellpadding="0" cellspacing="1">
                <tr height="21" class="dataLabel">
                    <td width="201">&nbsp;Doc: CI / OFICIO / Processo</td>
                    <td width="150">&nbsp;Armario Num ou Nome</td>
                    <td width="150">&nbsp;Gaveta</td>
                    <td width="150">&nbsp;Pasta</td>
                    <td width="150">&nbsp;Posicao</td>
                </tr>
                <tr height="21" class="dataField">
                    <td>&nbsp;<input name="txtDocumento" maxlength="80" type="text" value="<?=$Documento?>" style=" width:190px;"></td>
                    <td>&nbsp;<input name="txtArmario" maxlength="80" type="text" value="<?=$Armario?>" style=" width:120px;"></td>
                    <td>&nbsp;<input name="txtGaveta" maxlength="10" type="text" value="<?=$Gaveta?>" style=" width:120px;"></td>
                    <td>&nbsp;<input name="txtPasta" maxlength="10" type="text" value="<?=$Pasta?>" style=" width:120px;"></td>
                    <td>&nbsp;<input name="txtPosicao" maxlength="10" type="text" value="<?=$Posicao?>" style=" width:120px;"></td>
              </tr>
              </table>
       </td>
    </tr>
 </table>