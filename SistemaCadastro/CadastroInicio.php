<?php
include "../Include/Inc_Configuracao.php";
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
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
    </head>

    <body onLoad="WM_initializeToolbar();">
        <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
               <td>
                    <?php include "../Include/Inc_Topo.php"?>
                    <?php include "../Include/Inc_Aba.php"?>
               </td>
            </tr>
            <tr>
                <td>
                    <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                            <td width="5"><img src="../Imagens/vazio.gif" width="7" height="1" border="0"/></td>
                            <td valign="top" align="center" width="100%">
                                <div id="titulopagina">
                                    <table cellpadding="2" cellspacing="2" border="0" width="800" class="TabModulo">
                                        <tr>
                                            <td width="1"><img src="../Imagens/vazio.gif" width="1" height="1" border="0"/></td>
                                            <td align="left" class="titulo_pagina">Resumo do Sistema</td>
                                        </tr>
                                        <tr>
                                            <table width="800" cellspacing="0" cellpadding="0" border="0">
                                                <tr>
                                                    <br>
                                                </tr>
                                                <tr>
                                                    <td width="500" class="dataLinha" valign="top">
                                                        <p align="justify">
                                                            <font size="2">O Sistema de Cadastro &Uacute;nico tem como funcionalidade b&aacute;sica subdisiar outros sistemas da ADAB, centralizando as informa&ccedil;&otilde;es das pessoas f&iacute;sicas, jur&iacute;dicas e unidades organizacionais vinculadas a este &oacute;rg&atilde;o em uma &uacute;nica base de dados e diferenciando a sua rela&ccedil;&atilde;o conforme o sistema em quest&atilde;o. </font>
                                                        </p>
                                                    </td>
                                                    <td width="20">&nbsp;</td>
                                                    <td valign="top">
                                                        <table align="center" width="300" cellspacing="0" cellpadding="0" border="0">
                                                            <tr class="dataLinha">
                                                                <td height="21">
                                                                    <font size="2">
                                                                        <img src="../Imagens/calendar.png" />
                                                                            <u>Data de implanta&ccedil;&atilde;o 22/11/2010</u>
                                                                    </font>
                                                                </td>
                                                            </tr>
                                                            <tr class="dataLinha">
                                                                <td height="21">
                                                                    <font size="2"> 
                                                                        <img src="../Imagens/pdf_button.png" />
                                                                        <u>Vers&atilde;o 01.09</u>
                                                                    </font>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </tr>
                                    </table>
                                </div>
                                <?php
                                If ($_Session['UsuarioEstDescricao'] == "DAF_CSG")
                                {
                                    include "../Include/Inc_Resumo_Contrato.php";
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>

