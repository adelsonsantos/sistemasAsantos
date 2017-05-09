<?php
include "../Include/Inc_Configuracao.php";
include_once 'IncludeLocal/Inc_FuncoesDiarias.php';
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
        <style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>
        <script type="text/javascript" language="javascript" src="funcoes.js"></script>
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptDiariaPendente.js"></script>
    </head>
    <body onload="WM_initializeToolbar();">
        <form name="Form" method="post" action="">
            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><?php include "../Include/Inc_Topo.php" ?></td>
                </tr>
                <tr>
                    <td><?php include "../Include/Inc_Aba.php" ?></td>
                </tr>
                <tr>
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php" ?></td>
                                <td valign="top" align="center" width="800">
                                    <?php include "../Include/Inc_Titulo.php" ?>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table cellpadding="1" cellspacing="1" width="800" border="0" class="GridPaginacao">                                                                   
                                        <tr class="dataLabel" align="left">
                                            <td width="220" height="21" colspan="2">Tipo de Pendência da Diária:</td>
                                            <td width="348" height="21">Beneficiário:</td>
                                            <td width="115" height="21" colspan="2">Data Início</td>
                                            <td width="115" height="21" colspan="2">Data Fim</td> 
                                        </tr>
                                        <tr align="left">
                                            <td width="110" >
                                                <input id="saldoNegativo" type="radio" class="radio" name="radio_tipo_relat" style="width:10px; height:10px;" value="-"/> À Pagar                                                                                                                       
                                            </td>
                                            <td width="110">
                                                <input id="saldoPositivo" type="radio" class="radio" name="radio_tipo_relat" style="width:10px; height:10px;" value="+"/> À Receber                                                         
                                            </td>
                                            <td class="dataField">                                                
                                                <?= ComboBeneficiario('', '') ?>
                                            </td>                                            
                                            <td height="21" width="78">
                                                <input id="dataInicio" type="text" name="txtDataInicio" maxlength="10" style=" width:75px;height:15px;" />
                                            </td>
                                            <td height="21" width="20">
                                                <a href="#" onClick="javascript:displayCalendar(document.getElementById('dataInicio'),'dd/mm/yyyy',this);" >
                                                    <img src="../Icones/ico_calendario.gif" border="0" title="Mostrar Calendário" style="width:18px; height:18px;"/>
                                                </a>
                                            </td>                                                        
                                            <td height="21" width="78">
                                                <input id="dataFim" type="text" name="txtDataFim" maxlength="10" style="width:75px;height:15px;" />
                                            </td>
                                            <td height="21" width="20">
                                                <a href="#" onClick="javascript:displayCalendar(document.getElementById('dataFim'),'dd/mm/yyyy',this);">
                                                    <img src="../Icones/ico_calendario.gif" border="0" title="Mostrar Calendário" style="width:18px; height:18px;"/>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>                                    
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td height="25" align="right">
                                                <input type="button" style="width:100px;" onclick="Javascript:GerarRelatorio();" name="btnGravar" class="botao" value="Gerar Relatório"></input>
                                            </td>
                                        </tr>
                                    </table>
                                    <span id="diariaPendente" ></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>