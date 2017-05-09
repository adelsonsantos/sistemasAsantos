<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseEstrutura.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="pt-BR" lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="Description" content="ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia" />
        <meta name="Keywords" content="ADAB, Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia, Defesa Agropecu&aacute;ria, Agropecu&aacute;ria Bahia" />
        <meta name="language" content="pt-br" />
        <meta name="distribution" content="Global" />
        <meta name="rating" content="General" />
        <meta name="DC.title" content="ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia" />
        <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE8'></meta>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia</title>
        <style type="text/css">@import url("../css/estilo.css");</style>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript">
            
            function Foco(frm)
            {
                frm.txtEstOrganizacional.focus();
            }

            function GravarForm(frm)
            {
                for(cont=0; cont < frm.elements.length; cont++)
                    frm.elements[cont].style.backgroundColor = '';

                if (frm.txtEstOrganizacional.value == "")
                {
                    alert("Campo em Branco.");
                    frm.txtEstOrganizacional.focus();
                    frm.txtEstOrganizacional.style.backgroundColor='#B9DCFF';
                    return false;
                }

                if (frm.txtEstOrganizacionalSigla.value == "")
                {
                    alert("Campo em Branco.");
                    frm.txtEstOrganizacionalSigla.focus();
                    frm.txtEstOrganizacionalSigla.style.backgroundColor='#B9DCFF';
                    return false;
                }

                if (frm.txtCodigo.value == "")
                    frm.action = "EstOrganizacionalCadastrar.php?acao=incluir";
                else
                    frm.action = "EstOrganizacionalCadastrar.php?acao=alterar";

                frm.submit();
            }

        </script>
    </head>

    <body onLoad="WM_initializeToolbar();">
        <form name="Form" method="post">
            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><?php include "../Include/Inc_Topo.php"?></td>
                </tr>
                <tr>
                    <td><?php include "../Include/Inc_Aba.php"?></td>
                </tr>
                <tr>
                    <td>
                        <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">                                                   
                                    <div id="titulopagina"><?php include "../Include/Inc_Titulo.php"?></div>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table width="800" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="GridPaginacaoRegistroCabecalho">
                                            <td>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="dataLabel">
                                                        <td height="21" width="280">Unidade</td>
                                                        <td height="21" width="200">Sigla</td>
                                                        <td height="21" width="218">Unidade Superior</td>
                                                        <td height="21" width="100">N&uacute;mero</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21"><input name="txtEstOrganizacional" maxlength="100" type="text" value="<?=$EstOrganizacionalDescricao?>" style="width: 260px;"/> *</td>
                                                        <td height="21"><input name="txtEstOrganizacionalSigla" maxlength="50" type="text" value="<?=$EstOrganizacionalSigla?>" style="width: 180px;"/> *</td>
                                                        <td height="21"><?=f_ComboEstruturaOrganizacional("cmbEstruturaSuperior",$EstOrganizacionalSuperiorCod)?></td>
                                                        <td height="21"><input name="txtCentroCusto" maxlength="10" type="text" value="<?=$CentroCustoNumero?>"style="width: 100px;"/></td>
                                                    </tr>
                                                </table>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr class="GridPaginacaoRegistroCabecalho">
                                                        <td height="21" colspan="3" width="100%" align="center">Centro de Custo</td>
                                                    </tr>
                                                    <tr class="dataLabel">
                                                        <td height="21" width="266">Diárias</td>
                                                        <td height="21" width="266">Transporte</td>
                                                        <td height="21" width="266">Unidade Notificadora</td>
                                                    </tr>
                                                    <tr class="dataField">
                                                        <td height="21">
                                                            <input name="rdCentro" type="radio" class="radio" value="1" <?php if ($CentroCusto == "1"){?> checked <?php } ?>/> Sim
                                                            <input name="rdCentro" type="radio" class="radio" value="0" <?php if (($CentroCusto == "0")||($CentroCusto == "")){?> checked <?php } ?> />N&atilde;o
                                                        </td>
                                                        <td height="21">
                                                            <input name="rdCentroTransporte" type="radio" class="radio" value="1" <?php if ($CentroCustoTransporte == "1"){ ?> checked <?php } ?> />Sim
                                                            <input name="rdCentroTransporte" type="radio" class="radio" value="0" <?php if ($CentroCustoTransporte == "0" || $CentroCustoTransporte == "") { ?> checked <?php } ?> />Não
                                                        </td>
                                                        <td height="21">
                                                            <input name="rdCentroAcompanhamento" type="radio" class="radio" value="1" <?php if ($CentroCustoAcompanhamento == "1") { ?> checked <?php } ?> />Sim
                                                            <input name="rdCentroAcompanhamento" type="radio" class="radio" value="0" <?php if ($CentroCustoAcompanhamento == "0" || $CentroCustoAcompanhamento == "") { ?> checked <?php } ?> />Não
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr class="dataLinha">
                                            <td height="21">(*) Campo obrigat&oacute;rio</td>
                                        </tr>
                                    </table>
                                    <input name="txtCodigo" type="hidden" value="<?=$EstOrganizacionalCodigo?>" /> 
                                    <?php 
                                    include "../Include/Inc_Linha.php";
                                    if ($MensagemErroBD != "")
                                    {
                                        echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
                                            echo "<tr class='MensagemErro'>";
                                                echo "<td>".$MensagemErroBD."</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                                echo "<td><img src='../images/vazio.gif' width='1' height='10' border='0'/></td>";
                                            echo "</tr>";
                                        echo "</table>";
                                    }
                                    ?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td height="25" align="right">
                                                <input type="button" style="width: 70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao" value="Gravar"/>
                                                <input type="button" style="width: 70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
