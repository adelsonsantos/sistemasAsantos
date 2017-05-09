<table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
    <tr>
        <td>
            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="150">Tipo de Funcion&aacute;rio</td>
                    <td height="21" width="135">Matr&iacute;cula</td>
                    <td height="21" width="135">Data de Admiss&atilde;o</td>
                    <td height="21" width="135">Data de Demiss&atilde;o</td>
                    <td height="21" width="243">E-Mail Institucional</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><?=f_ComboTipoFuncionario($TipoFuncionario)?></td>
                    <td height="21"><input name="txtMatricula" id="matricula" maxlength="20" type="text" value="<?=$Matricula?>" style=" width:120px;"/></td>
                    <td height="21"><input name="txtDtAdmissao" maxlength="10" type="text" value="<?=$DataAdmissao?>" style=" width:120px;" OnKeyUp="mascaraData(this.value, document.Form.txtDtAdmissao);"/></td>
                    <td height="21"><input name="txtDtDemissao" maxlength="10" type="text" value="<?=$DataDemissao?>" style=" width:120px;" OnKeyUp="mascaraData(this.value, document.Form.txtDtDemissao);"/></td>
                    <td height="21"><input name="txtFuncionarioEmail" maxlength="200" type="text" value="<?=$FuncionarioEmail?>" style=" width:200px;"/></td>
                </tr>
            </table>

            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="210">Unidade de Lota&ccedil;&atilde;o/ACP</td>
                    <td height="21" width="210">Local de Trabalho</td>
                    <td height="21" width="189">&Oacute;rg&atilde;o de Origem</td>
                    <td height="21" width="189">&Oacute;rg&atilde;o a Disposi&ccedil;&atilde;o</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><?=f_ComboEstruturaOrganizacional("cmbEstruturaAtuacao",$EstruturaAtuacao)?></td>
                    <td height="21"><?=f_ComboEstruturaOrganizacionalLotacao("cmbEstruturaLotacao",$EstruturaLotacao)?></td>
                    <td height="21"><?=f_ComboOrgao($OrgaoOrigem,"cmbOrgaoOrigem")?></td>
                    <td height="21"><?=f_ComboOrgao($OrgaoDestino,"cmbOrgaoDestino")?></td>
                </tr>
            </table>

            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="315">Cargo Tempor&aacute;rio</td>
                    <td height="21" width="315">Cargo Permanente</td>
                    <td height="21" width="168">&Ocirc;nus</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><?=f_ComboCargo("cmbCargoTemporario",$CargoTemporario,2)?></td>
                    <td height="21"><?=f_ComboCargo("cmbCargoPermanente",$CargoPermanente,1)?></td>
                    <td height="21">
                        <?php 
                        if($FuncionarioOnus == 1) 
                        { 
                        ?>
                            <input name="txtOnus" class="radio" type="radio" value="1" checked/>Sim                                    
                            <input name="txtOnus" class="radio" type="radio" value="0"/>Não
                        <?php                             
                        } 
                        else
                        {
                        ?>
                            <input name="txtOnus" class="radio" type="radio" value="1"/>Sim                                    
                            <input name="txtOnus" class="radio" type="radio" value="0" checked/>Não
                        <?php                             
                        } 
                        ?>
                    </td>
                </tr>
            </table>

            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="199">Num. Carteira de Trabalho</td>
                    <td height="21" width="200" colspan="2">Carteira de Trabalho S&eacute;rie / UF</td>
                    <td height="21" width="199">PIS/PASEP</td>
                    <td height="21" width="200">Conta FGTS</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><input name="txtCLTNumero" maxlength="20" type="text" value="<?=$CartTrabalho?>" style=" width:150px;"></td>
                    <td height="21" width="140"><input name="txtCLTSerie" maxlength="10" type="text" value="<?=$CartTrabalhoSerie?>" style=" width:150px;"></td>
                    <td height="21" width="55"><?=f_ComboEstado("cmbCLTUF","",$CartTrabalhoUF)?></td>
                    <td height="21"><input name="txtPIS" maxlength="50" type="text" value="<?=$PIS?>" style=" width:150px;"></td>
                    <td height="21"><input name="txtFGTS" maxlength="50" type="text" value="<?=$FGTS?>" style=" width:150px;"></td>
                </tr>
            </table>

            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="200">Banco</td>
                    <td height="21" width="199">Ag&ecirc;ncia</td>
                    <td height="21" width="200">Conta</td>
                    <td height="21" width="199">Tipo da Conta</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><?=f_ComboBanco($Banco);?></td>
                    <td height="21"><input name="txtAgencia" maxlength="10" type="text" value="<?=$Agencia?>" style=" width:100px;"></td>
                    <td height="21"><input name="txtConta" maxlength="10" type="text" value="<?=$Conta?>" style=" width:150px;"></td>
                    <td height="21"><?=f_ComboTipoConta($TipoConta)?></td>
                </tr>
            </table>

            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="798">Arquivo Fisico</td>
                </tr>
            </table>

            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="198">Tipo: CI / Oficio / Processo</td>
                    <td height="21" width="150">Armario Num ou Nome</td>
                    <td height="21" width="150">Gaveta</td>
                    <td height="21" width="150">Pasta</td>
                    <td height="21" width="150">Posicao</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><input name="txtDocumento" type="text" value="<?=$Documento?>" style=" width:190px;"/></td>
                    <td height="21"><input name="txtArmario" maxlength="80" type="text" value="<?=$Armario?>" style=" width:150px;"/></td>
                    <td height="21"><input name="txtGaveta" maxlength="10" type="text" value="<?=$Gaveta?>" style=" width:120px;"/></td>
                    <td height="21"><input name="txtPasta" maxlength="10" type="text" value="<?=$Pasta?>" style=" width:120px;"/></td>
                    <td height="21"><input name="txtPosicao" maxlength="10" type="text" value="<?=$Posicao?>" style=" width:120px;"/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>