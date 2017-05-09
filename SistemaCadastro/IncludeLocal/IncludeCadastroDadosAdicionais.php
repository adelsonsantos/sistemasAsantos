<table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
    <tr>
        <td>
            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="148">Num. T&iacute;tulo de Eleitor</td>
                    <td height="21" width="150">Zona</td>
                    <td height="21" width="148">Se&ccedil;&atilde;o</td>
                    <td height="21" colspan="2" width="352">Cidade</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><input name="txtTitulo" maxlength="20" type="text" value="<?=$TituloEleitor?>" style=" width:120px;" onKeyPress="mascaraNumero(event, this);"/></td>
                    <td height="21"><input name="txtTituloZona" maxlength="20" type="text" value="<?=$TituloEleitorZona?>" style=" width:120px;" onKeyPress="mascaraNumero(event, this);"/></td>
                    <td height="21"><input name="txtTituloSecao" maxlength="20" type="text" value="<?=$TituloEleitorSecao?>" style=" width:120px;" onKeyPress="mascaraNumero(event, this);"/></td>
                    <td height="21" width="50"><?=f_ComboEstado("cmbTituloUF", "onChange=MandaID(this.value,'AjaxTituloEleitor','estado_id')",$TituloEleitorUF)?></td>
                    <td height="21"><div id="Titulo"><?=f_ComboMunicipio("cmbTituloCidade",$TituloEleitorUF,$TituloEleitorCidade)?></div></td>
                </tr>
            </table>

            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="150">Num. Habilita&ccedil;&atilde;o</td>
                    <td height="21" width="156">Categoria</td>
                    <td height="21" width="150">Validade</td>
                    <td height="21" width="152">Lente Corretiva</td>
                    <td height="21" width="190">Passaporte</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><input name="txtHabilitacao" maxlength="20" type="text" value="<?=$Habilitacao?>" style=" width:120px;" onKeyPress="mascaraNumero(event, this);"/></td>
                    <td height="21"><input name="txtHabilitacaoCategoria" maxlength="2" type="text" value="<?=$HabilitacaoCategoria?>" style=" width:30px;" onKeyPress="mascaraLetra(event, this);"/></td>
                    <td height="21"><input name="txtHabilitacaoValidade" maxlength="10" type="text" value="<?=$HabilitacaoValidade?>" style=" width:120px;" OnKeyUp="mascaraData(this.value, document.Form.txtHabilitacaoValidade);"/></td>
                    <td height="21">
                    <?php if($HabilitacaoLenteCorretiva == 1) 
                          { ?>
                            <input name="txtHabilitacaoLenteCorretiva" type="radio" class="radio" value="1" checked/>Sim                                    
                            <input name="txtHabilitacaoLenteCorretiva" type="radio" class="radio" value="0"/>Não
                    <?php } 
                          else 
                          { ?>
                            <input name="txtHabilitacaoLenteCorretiva" type="radio" class="radio" value="1"/>Sim                                    
                            <input name="txtHabilitacaoLenteCorretiva" type="radio" class="radio" value="0" checked/>Não
                    <?php } ?>
                    </td>
                    <td height="21"><input name="txtPassaporte" maxlength="50" type="text" value="<?=$Passaporte?>" style=" width:120px;"/></td>  
                </tr>
            </table>

            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="302" colspan="2">Reservista / UF</td>
                    <td height="21" width="496">Reservista Minist&eacute;rio</td>
                </tr>
                <tr class="dataField">
                    <td height="21" width="148"><input name="txtReservista" maxlength="20" type="text" value="<?=$Reservista?>" style=" width:120px;"/></td>
                    <td height="21" width="154"><?=f_ComboEstado("cmbReservistaUF", "",$ReservistaUF)?></td>
                    <td height="21"><?=f_ComboMinisterio($ReservistaMinisterio)?></td>
                </tr>
             </table>
        </td>
    </tr>
</table>