<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseFonte.php";
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
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script language="javascript" charset="utf-8">
            function Foco(frm)
            {
                frm.txtNumero.focus();
            }

            function GravarForm(frm)
            {
                for(cont=0; cont < frm.elements.length; cont++)
                    frm.elements[cont].style.backgroundColor = '';

                if (frm.txtNumero.value == "")
                {
                    alert("Campo NÚMERO em Branco.");
                    frm.txtNumero.focus();
                    frm.txtNumero.style.backgroundColor='#B9DCFF';
                    return false;
                }

                if (frm.txtDescricao.value == "")
                {
                    alert("Campo DESCRIÇÃO em Branco.");
                    frm.txtDescricao.focus();
                    frm.txtDescricao.style.backgroundColor='#B9DCFF';
                    return false;
                }


                if (frm.txtCodigo.value == "")
                    frm.action = "FonteCadastrar.php?acao=incluir";
                else
                    frm.action = "FonteCadastrar.php?acao=alterar";

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
                                <?php include "../Include/Inc_Titulo.php"?>
                                <?php include "../Include/Inc_Linha.php"?>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr height="21">
                                                        <td class="dataLabel" width="120">&nbsp;N&uacute;mero&nbsp;*</td>
                                                        <td class="dataLabel" width="678" colspan="3">&nbsp;Descri&ccedil;&atilde;o da Fonte&nbsp;*</td>
                                                    </tr>
                                                    <tr height="21">
                                                        <?php
                                                        If ($Numero != "")
                                                        {
                                                        ?>
                                                            <td class="dataField">&nbsp;<input name="txtNumero" maxlength="4" type="text" value="<?=$Numero?>" style=" width:50px;" readonly class="Oculto"/>&nbsp;*</td>
                                                        <?php
                                                        }
                                                        Else
                                                        {
                                                        ?>
                                                            <td class="dataField">&nbsp;<input name="txtNumero" maxlength="4" type="text" value="<?=$Numero?>" style=" width:50px;"/>&nbsp;*</td>
                                                        <?php
                                                        }
                                                        ?>
                                                        <td class="dataField" colspan="3">&nbsp;<input name="txtDescricao" maxlength="350" type="text" value="<?=$Descricao?>" style=" width:400px;"/></td>
                                                    </tr>
                                                 </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLinha">(*) Campo obrigat&oacute;rio</td>
                                        </tr>
                                    </table>
                                    <input name="txtCodigo" type="hidden" value="<?=$Codigo?>"/>

                                    <?php
                                    include "../Include/Inc_Linha.php";
                                    
                                    If ($MensagemErroBD != "")
                                    {   
                                        echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
                                            echo "<tr>";
                                                echo "<td class='MensagemErro'>".$MensagemErroBD."</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                                echo "<td><img src='../imagens/vazio.gif' width='1' height='10' border='0'/></td>";
                                            echo "</tr>";
                                        echo "</table>";
                                    }
                                    ?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr height="25">
                                            <td align="right">
                                                <input type="button" style="width:70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao" value="Gravar"/>&nbsp;&nbsp;&nbsp;
                                                <input type="button" style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
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