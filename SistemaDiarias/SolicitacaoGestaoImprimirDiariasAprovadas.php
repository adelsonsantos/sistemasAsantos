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
        <style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>        
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>  
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptRelatorioGestaoFinanceiro.js"></script>
    </head>
    <body onLoad="JavaScript:WM_initializeToolbar();">
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
                                        <tr class="dataLabel">                                            
                                            <td width="150" height="21">Diretoria:</td>
                                            <td width="165" height="21">Situação</td>
                                            <td width="120" height="21" colspan="2">Data Início</td>
                                            <td width="330" height="21" colspan="2">Data Fim</td> 
                                        </tr>
                                        <tr class="dataField">                                           
                                            <td width="150" height="21">
                                                <select name="comboDiretoria" id="comboDiretoria" style="width:130px; height:18px;">
                                                    <option selected value="0">[---------- Selecione ----------]</option>
                                                    <?php
                                                    $sql      = "SELECT est.est_organizacional_id, est_organizacional_sigla 
                                                                    FROM dados_unico.est_organizacional est
                                                                    WHERE est_organizacional_st = 0
                                                                    AND est_organizacional_id 
                                                                                IN(
                                                                                    SELECT diaria_unidade_custo 
                                                                                    FROM diaria.diaria
                                                                                    WHERE diaria_st = 0 
                                                                                    ) 
                                                                ORDER BY est_organizacional_sigla ASC";
                                                    $consulta = pg_query(abreConexao(),$sql);                                                                        
                                                    if($_SESSION['TipoUsuario'] != '5')
                                                    {
                                                        if (pg_num_rows($consulta)>0)
                                                        {
                                                            while ($tupla = pg_fetch_assoc($consulta)) 
                                                            {
                                                                $idDiretoria    = $tupla["est_organizacional_id"];
                                                                $siglaDiretoria = $tupla["est_organizacional_sigla"];
                                                                echo "<option value='$idDiretoria'>$siglaDiretoria</option>";
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $sql      = "SELECT est.est_organizacional_id, est_organizacional_sigla 
                                                                        FROM dados_unico.est_organizacional est
                                                                        WHERE est_organizacional_id = ".$_SESSION['UsuarioEstCodigo'];
                                                        $consulta = pg_query(abreConexao(),$sql);
                                                        $tupla    = pg_fetch_assoc($consulta);
                                                        echo "<option value=".$tupla['est_organizacional_id'].">".$tupla['est_organizacional_sigla']."</option>";
                                                    }
                                                    ?>                                                    
                                                </select>
                                            </td>
                                            <td width="165" height="21">
                                                <select name="comboStatus" id="comboStatus" style="width:130px; height:18px;">
                                                    <option selected value="0">[---------- Selecione ----------]</option>
                                                    <option value='2'>Empenho</option>
                                                    <option value='3'>Execução</option>                                                    
                                                </select>
                                            </td>
                                            <td width="80" height="21">
                                                <input id="dataInicio" type="text" name="txtDataInicio" maxlength="10" style=" width:75px;height:15px;" />
                                            </td>
                                            <td width="40" height="21">
                                                <a href="#" onClick="javascript:displayCalendar(document.getElementById('dataInicio'),'dd/mm/yyyy',this);" >
                                                    <img src="../Icones/ico_calendario.gif" border="0" title="Mostrar Calendário" style="width:18px; height:18px;"/>
                                                </a>
                                            </td>                                                        
                                            <td width="80" height="21">
                                                <input id="dataFim" type="text" name="txtDataFim" maxlength="10" style="width:75px;height:15px;" />
                                            </td>
                                            <td width="250" height="21">
                                                <a href="#" onClick="javascript:displayCalendar(document.getElementById('dataFim'),'dd/mm/yyyy',this);">
                                                    <img src="../Icones/ico_calendario.gif" border="0" title="Mostrar Calendário" style="width:18px; height:18px;"/>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr height="25">
                                            <td align="right">
                                                <input type="button" style="width:100px;" onClick="Javascript:GerarRelatorio(document.Form);" name="btnGravar" class="botao" value="Gerar Relatório"></input>
                                                &nbsp;&nbsp;
                                                <input type="button" style="width:70px" onClick="Javascript:window.location.href='SolicitacaoGestaoInicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
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