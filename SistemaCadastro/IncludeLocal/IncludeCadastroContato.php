<table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
    <tr>
        <td>
            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="30">DDD</td>
                    <td height="21" width="140">Telefone Residencial</td>
                    <td height="21" width="30">DDD</td>
                    <td height="21" width="140">Telefone Celular</td>
                    <td height="21" width="30">DDD</td>
                    <td height="21" width="140">Telefone Comercial</td>
                    <td height="21" width="30">DDD</td>
                    <td height="21" width="288">Telefone Fax</td>
	            </tr>
                <tr class="dataField">
                    <td height="21"><input name="txtFoneDDDResidencial" maxlength="2" type="text" value="<?=$TelefoneDDDResidencial?>" style=" width:20px;" onKeyPress="mascaraNumero(event, this);"/></td>
                    <td height="21"><input name="txtFoneResidencial" maxlength="9" type="text" value="<?=$TelefoneResidencial?>" style=" width:100px;" onKeyPress="mascaraTelefone(event, this);"/></td>
                    <td height="21"><input name="txtFoneDDDCelular" maxlength="2" type="text" value="<?=$TelefoneDDDCelular?>" style=" width:20px;" onKeyPress="mascaraNumero(event, this);"/></td>
                    <td height="21"><input name="txtFoneCelular" maxlength="9" type="text" value="<?=$TelefoneCelular?>" style=" width:100px;" onKeyPress="mascaraTelefone(event, this);"/></td>
                    <td height="21"><input name="txtFoneDDDComercial" maxlength="2" type="text" value="<?=$TelefoneDDDComercial?>" style=" width:20px;" onKeyPress="mascaraNumero(event, this);"/></td>
                    <td height="21"><input name="txtFoneComercial" maxlength="9" type="text" value="<?=$TelefoneComercial?>" style=" width:100px;" onKeyPress="mascaraTelefone(event, this);"/></td>
                    <td height="21"><input name="txtFoneDDDFax" maxlength="2" type="text" value="<?=$TelefoneDDDFax?>" style=" width:20px;" onKeyPress="mascaraNumero(event, this);"/></td>
                    <td height="21"><input name="txtFonefax" maxlength="9" type="text" value="<?=$TelefoneFax?>" style=" width:100px;" onKeyPress="mascaraTelefone(event, this);"/></td>
                </tr>
            </table>
            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21">E-Mail Pessoal</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><input name="txtEmail" maxlength="250" type="text" value="<?=$Email?>" style=" width:400px;"/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>