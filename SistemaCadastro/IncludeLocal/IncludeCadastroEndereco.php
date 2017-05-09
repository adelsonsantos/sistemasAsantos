<table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
    <tr>
        <td>
            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="55">Estado</td>
                    <td height="21" width="375">Munic&iacute;pio</td>
                    <td height="21" width="230">Bairro</td>
                    <td height="21" width="138">CEP</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><?=f_ComboEstado("cmbEnderecoUF", "onChange=MandaID(this.value,'AjaxEndereco','estado_id')",$EnderecoUF)?></td>
                    <td height="21"><div id="Endereco"><?=f_ComboMunicipio("cmbEnderecoMunicipio", $EnderecoUF, $EnderecoMunicipio)?></div></td>
                    <td height="21"><input name="txtEnderecoBairro" maxlength="150" type="text"  style=" width:180px;" value="<?=$EnderecoBairro?>"/></td>
                    <td height="21"><input name="txtCEP" maxlength="9" type="text" value="<?=$EnderecoCEP?>" style=" width:115px;" onKeyPress="mascaraCEP(event, this);" /></td>
                </tr>
            </table>

            <table width="798" border="0" cellpadding="1" cellspacing="1">
                    <tr class="dataLabel">
                        <td height="21" width="422">Logradouro</td>
                        <td height="21" width="76">N&uacute;mero</td>
                        <td height="21" width="300">Complemento</td>
                    </tr>
                    <tr class="dataField">
                        <td height="21"><input name="txtEndereco" maxlength="200" type="text" style=" width:390px;" value="<?=$Endereco?>"/></td>
                        <td height="21"><input name="txtNumero" maxlength="10" type="text" style=" width:40px;" value="<?=$EnderecoNumero?>"/></td>
                        <td height="21"><input name="txtComplemento" maxlength="50" type="text" style=" width:270px;" value="<?=$EnderecoComplemento?>"/></td>
                    </tr>
            </table>
            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="798">Descrimine um Ponto de Referencia do Endereco</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><input name="txtReferencia" maxlength="256" type="text" style=" width:780px;" value="<?=$EnderecoReferencia?>"/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>