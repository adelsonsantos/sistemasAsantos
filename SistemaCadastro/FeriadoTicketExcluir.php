<?php
include "Classe/ClasseFeriadoTicket.php";
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
        <title>ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia</title>          
        <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE8' ></meta>
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptAjax.js"></script>
        <script type="text/javascript" language="javascript">
            function ExcluirForm(frm)
            {                          
                frm.action = "FeriadoTicketInicio.php?acao=excluir";
                frm.submit();
            }
        </script>
    </head>    
    <body onload="WM_initializeToolbar();">
        <form id="Form" name="Form" method="post" action="">
            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><?php include "../Include/Inc_Topo.php" ?></td>
                </tr>
                <tr>
                    <td><?php include "../Include/Inc_Aba.php" ?></td>
                </tr>
                <tr>
                    <td>
                        <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td height="21" valign="top" align="left" width="190">
                                    <?php include "../Include/Inc_Menu.php" ?>
                                </td>
                                <td height="21" valign="top" align="left">
                                    <?php include "../Include/Inc_Titulo.php" ?>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <div id="Lista">
                                        <table width="800" border="0" cellpadding="1" cellspacing="1" class="GridPaginacao">                                                                                       
                                            <tr class="dataLabel">                                                
                                                <td height="20" width="90">Dia do Fériado</td>
                                                <td height="20" width="160">Mês</td>
                                                <td height="20" width="400">Descri&ccedil;&atilde;o</td>                                                
                                                <td height="20" width="148">Tipo</td>                                                                                              
                                            </tr>
                                            <?php                                             
                                                $linha       = pg_fetch_assoc($rsConsulta);                                                
                                                $feriadoMes  = $linha['feriado_mes'];
                                                $feriadoDia  = $linha['feriado_dia'];
                                                $feriadoDs   = $linha['feriado_ds'];
                                                $feriadoTipo = $linha['feriado_tipo'];                                            
                                            ?>
                                            <tr class="dataField">                                                                                                    
                                                <td height='20'><input type="text" id="diaFeriado" name="diaFeriado" style="width:75px; height:16px;" disabled="disabled" value="<?=$feriadoDia?>"/></td>
                                                <td><?php f_ComboMes('cmbMes','150','8','disabled',$feriadoMes);?></td>
                                                <td height='20'><input type="text" id="desFeriado" name="desFeriado" style="width:400px; height:16px;" disabled="disabled" value="<?=$feriadoDs?>"/></td>
                                                <td height='20'>
                                                    <?php                                                    
                                                    if($feriadoTipo == 0)
                                                    {
                                                        echo "  <select id='tipoFeriado' name='tipoFeriado' disabled style='width:120px; height:20px;'>
                                                                    <option value='0' selected>Nascional</option>                                                                  
                                                                    <option value='1'>Estadual</option>
                                                                    <option value='2'>Municipal</option>                                                        
                                                                </select>";
                                                    }
                                                    elseif($feriadoTipo == 1)
                                                    {
                                                        echo "  <select id='tipoFeriado' name='tipoFeriado' disabled style='width:120px; height:20px;'>
                                                                    <option value='0'>Nascional</option>                                                                  
                                                                    <option value='1' selected>Estadual</option>
                                                                    <option value='2'>Municipal</option>                                                        
                                                                </select>";
                                                    }
                                                    else
                                                    {
                                                        echo "  <select id='tipoFeriado' name='tipoFeriado' disabled style='width:120px; height:20px;'>
                                                                    <option value='0'>Nascional</option>                                                                  
                                                                    <option value='1'>Estadual</option>
                                                                    <option value='2' selected>Municipal</option>                                                        
                                                                </select>";
                                                    }                                                                                                            
                                                    ?>
                                                </td>                                                                                                                                                      
                                            </tr>
                                        </table>
                                    </div>
                                    <div>
                                        <table border="0" cellpadding="1" cellspacing="1" width="800">
                                            <tr>
                                                <td height="25" align="right">                                                    
                                                    <input type='button' style='width:70px' onclick="Javascript:ExcluirForm(document.Form);" name='btnExcluir' id='btnExcluir' class='botao' value='Excluir'/>                                                                                                                                                                                                                                                           
                                                    <input type="button" style="width:70px" onclick="Javascript:window.location.href='FeriadoTicketInicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
                                               </td>
                                           </tr>
                                        </table>
                                    </div>
                                    <input type="hidden" id="feriado_id" name="feriado_id" value="<?=$_GET['feriado_id']?>"/>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>