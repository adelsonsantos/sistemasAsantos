<?php
include "../Include/Inc_Configuracao.php";
include "IncludeLocal/Inc_FuncoesDiarias.php";
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
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>  
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>
        <script type="text/javascript" language="javascript" src="funcoes.js"></script>
        <script type="text/javascript" language="javascript">    
            function GerarRelatorio(frm)
            {                
                if($('#cmbBeneficiario').val() == '0')
                {
                    if($('#cmbMes').val() == '0')
                    {
                        window.open("RelatorioTicketRefeicaoPDF.php?cmbAno="+$('#comboAno').val());
                        frm.submit();
                    }
                    else
                    {
                        window.open("RelatorioTicketRefeicaoPDF.php?cmbMes="+$('#cmbMes').val()+"&cmbAno="+$('#comboAno').val()+"&descricaoMes="+$('#cmbMes :selected').text());
                        frm.submit();
                    }
                }
                else
                {
                    if($('#cmbMes').val() == '0')
                    {
                        window.open("RelatorioFuncionarioTicketRefeicaoPDF.php?cmbBeneficiario="+$('#cmbBeneficiario').val()+"&cmbAno="+$('#comboAno').val());
                        frm.submit();
                    }
                    else
                    {
                        window.open("RelatorioFuncionarioTicketRefeicaoPDF.php?cmbBeneficiario="+$('#cmbBeneficiario').val()+"&cmbAno="+$('#comboAno').val()+"&cmbMes="+$('#cmbMes').val()+"&descricaoMes="+$('#cmbMes :selected').text());
                        frm.submit();
                    }                    
                }
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
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">
                                    <?php include "../Include/Inc_Titulo.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>  
                                    <table cellpadding="1" cellspacing="1" width="800" border="0" class="GridPaginacao">
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                    <tr class="dataLabel">
                                                        <td height="20" width="150">Selecione o Servidor:</td>
                                                        <td height="20" width="400">
                                                            <?php ComboBeneficiario('todos', '');?>
                                                        </td>    
                                                        <td width="248"></td>
                                                    </tr>
                                                    <tr class="dataLabel">
                                                        <td height="20" width="150">Escolha o Ano:</td>
                                                        <td height="20" width="400">
                                                            <?php f_ComboAno('comboAno','80',date('Y'),'size="1"','2');?>
                                                        </td>
                                                        <td width="248"></td>
                                                    </tr>
                                                    <tr class="dataLabel">
                                                        <td height="20" width="150">Informe o Mês:</td>
                                                        <td height="20" width="400">                                                                                                                                                    
                                                            <?php f_ComboMes('cmbMes','150','8','','');?>
                                                        </td>
                                                        <td width="248"></td>
                                                    </tr>
                                                </table>                                            
                                            </td>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td align="right">
                                                <input type="button" style="width:100px; height:20px;" onClick="Javascript:GerarRelatorio(document.Form);" name="btnGravar" class="botao" value="Gerar Relatório"></input>
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