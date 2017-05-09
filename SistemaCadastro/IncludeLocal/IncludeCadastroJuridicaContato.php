<table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
    <tr>
        <td>
            <table width="798" border="0" cellpadding="0" cellspacing="1">
                <tr height="21" class="dataLabel">
                    <td width="40">&nbsp;DDD</td>
                    <td width="130">&nbsp;Telefone Comercial 1</td>
                    <td width="40">&nbsp;DDD</td>
                    <td width="130">&nbsp;Telefone Comercial 2</td>
                    <td width="40">&nbsp;DDD</td>
                    <td width="130">&nbsp;Telefone Fax</td>
                    <td>&nbsp;E-Mail da Empresa</td>
	            </tr>
                <tr height="21" class="dataField">
                    <td>&nbsp;<input name="txtFoneDDDComercial1" maxlength="2"   type="text" value="<?=$TelefoneDDDComercial1?>" style=" width:20px;"  onKeyPress="mascaraNumero(event, this);">&nbsp;*</td>
                    <td>&nbsp;<input name="txtFoneComercial1"    maxlength="9"   type="text" value="<?=$TelefoneComercial1?>"    style=" width:100px;" onKeyPress="mascaraTelefone(event, this);">&nbsp;*</td>
                    <td>&nbsp;<input name="txtFoneDDDComercial2" maxlength="2"   type="text" value="<?=$TelefoneDDDComercial2?>" style=" width:20px;"  onKeyPress="mascaraNumero(event, this);"></td>
                    <td>&nbsp;<input name="txtFoneComercial2"    maxlength="9"   type="text" value="<?=$TelefoneComercial2?>"    style=" width:100px;" onKeyPress="mascaraTelefone(event, this);"></td>
                    <td>&nbsp;<input name="txtFoneDDDFax"        maxlength="2"   type="text" value="<?=$TelefoneDDDFax?>"        style=" width:20px;"  onKeyPress="mascaraNumero(event, this);"></td>
                    <td>&nbsp;<input name="txtFoneFax"           maxlength="9"   type="text" value="<?=$TelefoneFax?>"           style=" width:100px;" onKeyPress="mascaraTelefone(event, this);"></td>
                    <td>&nbsp;<input name="txtEmail"             maxlength="250" type="text" value="<?=$Email?>"                 style=" width:200px;"></td>
                </tr>
            </table>

            <table width="798" border="0" cellpadding="0" cellspacing="1">
                <tr height="21" class="dataLabel">
                    <td width="260">&nbsp;Pessoa de Contato</td>
                    <td colspan="2">&nbsp;Celular do Contato</td>
	            </tr>
                <tr height="21" class="dataField">

                    <td width="260">&nbsp;<input name="txtContato" maxlength="250" type="text" value="<?=$Contato?>" style=" width:220px;"></td>
                    <td width="30">&nbsp;<input name="txtFoneDDDCelular" maxlength="2" type="text" value="<?=$TelefoneDDDCelular?>" style=" width:20px;" onKeyPress="mascaraNumero(event, this);"></td>
                    <td>&nbsp;<input name="txtFoneCelular" maxlength="9" type="text" value="<?=$TelefoneCelular?>" style=" width:100px;" onKeyPress="mascaraTelefone(event, this);"></td>
                </tr>
            </table>

        </td>
    </tr>
</table>