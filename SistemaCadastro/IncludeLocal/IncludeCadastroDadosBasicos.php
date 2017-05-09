<script language="javascript" type="text/javascript" src="../JavaScript/jquery-1.4.2.js"></script>
<script language="javascript" type="text/javascript">
    var erros = new Array("CPF Inválido!", "CPF já cadastrado!", "Matrícula já cadastrada!");
    var bErros = new Array(0, 0, 0);

    function showErros()
    {
        var str="";
        for(i=0; i < erros.length; i++)
        {
            if(bErros[i] == 1)
                str += erros[i]+"<br>";
        }
        $("#erro").html(str);
    }

    function addErro(erro)
    {
        bErros[erro]=1;
        showErros();
    }

    function removeErro(erro)
    {
        bErros[erro]=0;
        showErros();
    }

    $(document).ready(function()
    {
        $("#cpf").keyup(function(){
            if($(this).val().length == 14)
            {
                if(Verifica_CPF(document.Form) != false)
                {
                    removeErro(0);
                    $.ajax
                    ({
                        type: 'POST',
                        url: "../Include/funcoes.php",
                        data: "acao=buscaCPF&cpf="+$(this).val(),
                        success: function(result)
                        {
                            <?php 
                                if(!isset($_GET["cod"])) 
                                { 
                            ?> 
                                    if(result == "existe")
                                        addErro(1);
                                    else
                                        removeErro(1);
                            <?php                             
                                }
                                else
                                { 
                            ?>
                                    removeErro(0);
                            <?php                             
                                }
                            ?>
                        },
                        error: function()
                        {
                            alert("Erro");
                        }
                    });
                } 
                else
                {
                    addErro(0); 
                    removeErro(1); 
                }
            }
            else
            { 
                addErro(0); 
                removeErro(1); 
            }
        });

        $("#matricula").blur(function()
        {
            $.ajax
            ({
                type: 'POST',
                url: "../Include/funcoes.php",
                data: "acao=buscaMatricula&matricula="+$(this).val(),
                success: function(result)
                {
                    <?php 
                        if(!isset($_GET["cod"])) 
                        {
                    ?> 
                            if(result == "existe")
                                addErro(2);
                            else
                                removeErro(2);
                    <?php
                        }
                        else 
                        {
                    ?>
                            removeErro(2);
                    <?php
                        }
                    ?>
                },
                error: function()
                {
                    alert("Erro");
                }
            });
        });
    });
</script>

<table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
    <tr>
        <td>
            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="150">CPF</td>
                    <td height="21" width="150">Data de Nascimento</td>
                    <td height="21" width="338">Nome</td>
                    <td height="21" width="160">Sexo</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><input name="txtCPF" id="cpf" maxlength="14" type="text" value="<?=$CPF?>" style=" width:120px;" onKeyPress="mascaraCPF(event, this);" />*</td>
                    <td height="21"><input name="txtDtNasc" maxlength="10" type="text" value="<?=$DataNascimento?>" style=" width:120px;" OnKeyUp="mascaraData(this.value, document.Form.txtDtNasc);" onKeyPress="mascaraNumero(event, this);"/>*</td>
                    <td height="21"><input name="txtNome" maxlength="200" type="text" value="<?=$Nome?>" style=" width:300px;"/>*</td>
                    <td height="21">
                        <input name="rdSexo" type="radio" value="M" class="radio" <?=$SexoMasc?>/>Masculino
                        <input name="rdSexo" type="radio" value="F" class="radio" <?=$SexoFem?>/>Feminino
                    </td>
                </tr>
            </table>
            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="152">RG</td>
                    <td height="21" width="154">&Oacute;rg&atilde;o Emissor</td>
                    <td height="21" width="56">UF do RG</td>
                    <td height="21" width="150">Data de Expedi&ccedil;&atilde;o</td>
                    <td height="21" width="150">Grupo Sangu&iacute;neo</td>
                    <td height="21" width="68">Qtde Filho</td>
                    <td height="21" width="68">Qtde Filha</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><input name="txtRG" maxlength="20" type="text" value="<?=$RG?>" style=" width:120px;" onKeyPress="mascaraNumero(event, this);"/>*</td>
                    <td height="21"><input name="txtRGOrgao" maxlength="20" type="text" value="<?=$RGOrgao?>" style=" width:121px;"/></td>
                    <td height="21"><?=f_ComboEstado("cmbRGUF","",$RGOrgaoUF)?></td>
                    <td height="21"><input name="txtRGDtExpedicao" maxlength="10" type="text" value="<?=$RGData?>" style=" width:120px;" OnKeyUp="mascaraData(this.value, document.Form.txtRGDtExpedicao);"/></td>
                    <td height="21"><?=f_ComboGrupoSanguineo($Sangue)?></td>
                    <td height="21"><input name="txtFilho" maxlength="2" type="text" value="<?=$Filho?>" style=" width:25px;"/></td>
                    <td height="21"><input name="txtFilha" maxlength="2" type="text" value="<?=$Filha?>" style=" width:25px;"/></td>
                </tr>
            </table>
            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="139">Estado Civil</td>
                    <td height="21" width="139">Escolaridade</td>
                    <td height="21" width="70">Semestre</td>                    
                    <td height="21" width="150">Nome do Curso</td>
                    <td height="21" width="150">Nome da Institui&ccedil;&atilde;o</td>
                    <td height="21" width="150">Conselho / Numero</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><?=f_ComboEstadoCivil($EstadoCivil)?></td>
                    <td height="21"><?=f_ComboNivelEscolar($NivelEscolar)?></td>
                    <td height="21"><input name="txtNivelEscolarSemestre" maxlength="02" type="text" value="<?=$NivelTecnicoSemestre?>" style=" width:45px;" /></td>
                    <td height="21"><input name="txtNivelEscolarCurso" maxlength="850" type="text" value="<?=$NivelTecnicoCurso?>" style=" width:150px;" /></td>
                    <td height="21"><input name="txtNivelEscolarInstituicao" maxlength="850" type="text" value="<?=$NivelTecnicoInstituicao?>" style=" width:150px;" /></td>
                    <td height="21"><input name="txtNivelEscolarConselho" maxlength="850" type="text" value="<?=$NivelTecnicoConselho?>" style=" width:150px;" /></td>
                </tr>
            </table>
            <table width="798" border="0" cellpadding="1" cellspacing="1">
                <tr class="dataLabel">
                    <td height="21" width="200">Nome do Pai</td>
                    <td height="21" width="200">Nome da M&atilde;e</td>
                    <td height="21" width="120">Nacionalidade</td>
                    <td height="21" width="278" colspan="2">Naturalidade</td>
                </tr>
                <tr class="dataField">
                    <td height="21"><input name="txtPai" maxlength="200" type="text" value="<?=$NomePai?>" style=" width:190px;"/></td>
                    <td height="21"><input name="txtMae" maxlength="200" type="text" value="<?=$NomeMae?>" style=" width:190px;"/></td>
                    <td height="21"><?=f_ComboPais("cmbNacionalidade",$Nacionalidade)?></td>
                    <td height="21" width="50"><?=f_ComboEstado("cmbNaturalidadeUF", "onChange=\"Javascript:MandaID(this.value,'AjaxNaturalidade','estado_id')\"",$NaturalidadeUF)?></td>
                    <td height="21">
                        <div id="NaturalidadeCidade"><?=f_ComboMunicipio("cmbNaturalidade", $NaturalidadeUF, $Naturalidade)?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>