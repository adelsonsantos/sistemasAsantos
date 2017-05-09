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
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptRelatorioDiariaCoordenadoria.js"></script>
    </head>
    <body onload="WM_initializeToolbar();">
        <form name="Form" method="post">
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
                                            <td width="290" height="21">Tipo de Relat&oacute;rio:</td>
                                            <td width="150" height="21">Diretoria:</td>
                                            <td width="165" height="21">Status</td>
                                            <td width="100" height="21" colspan="2">Data Início</td>
                                            <td width="100" height="21" colspan="2">Data Fim</td> 
                                        </tr>
                                        <tr align="left">
                                            <td width="290" class="dataField">
                                                <table border="0" cellpadding="1" cellspacing="1" width="290">
                                                    <tr class="dataField">
                                                        <td width="100" >
                                                            <input id="coordenadoria" type="radio" class="radio" name="radio_tipo_relat" style="width:10px; height:10px;" value="coord" onclick="HabComboCoordenadoria();habilitaGrafico();"/> Coordenadoria                                                                                                                       
                                                        </td>
                                                        <td width="70">
                                                            <?php
                                                            if($_SESSION['TipoUsuario'] != '31')
                                                            {
                                                                echo'<input id="todos" type="radio" class="radio" name="radio_tipo_relat" style="width:10px; height:10px;" value="todos" onclick="HabComboCoordenadoria();habilitaGrafico();"/> Todas';
                                                            }
                                                            else
                                                            {
                                                                echo'<input id="todos" type="radio" class="radio" disabled name="radio_tipo_relat" style="width:10px; height:10px;" value="todos" onclick="HabComboCoordenadoria();habilitaGrafico();"/> Todas';
                                                            }
                                                            ?>                                                            
                                                        </td>  
                                                        <td width="100">
                                                            <label id="campo_coordenadoria" style="display:none">
                                                                <select name="combo_coordenadoria" id="combo_coordenadoria" style="width:110px; height:18px;">                                                                    
                                                                    <?php
                                                                    $sql      = "SELECT id_coordenadoria, nome FROM diaria.coordenadoria ORDER BY nome ASC";
                                                                    $consulta = pg_query(abreConexao(),$sql);                                                                        
                                                                    if($_SESSION['TipoUsuario'] != '31')
                                                                    {
                                                                        if (pg_num_rows($consulta)>0)
                                                                        {
                                                                            echo "<option value='0'>Sede";
                                                                            while ($tupla = pg_fetch_assoc($consulta)) 
                                                                            {
                                                                                $idCoordenadoria   = $tupla["id_coordenadoria"];
                                                                                $nomeCoordenadoria = $tupla["nome"];
                                                                                echo "<option value=\"$idCoordenadoria\">$nomeCoordenadoria</option>";
                                                                            }
                                                                            echo '</option>';
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        $sql      = "SELECT id_coordenadoria, nome 
                                                                                       FROM diaria.coordenadoria 
                                                                                      WHERE id_coordenadoria = ".$_SESSION['UsuarioCoordenadoria']."  
                                                                                   ORDER BY nome ASC";
                                                                        $consulta = pg_query(abreConexao(),$sql);
                                                                        $tupla    = pg_fetch_assoc($consulta);
                                                                        if (pg_num_rows($consulta)>0)
                                                                        {
                                                                            echo "<option selected value=".$tupla['id_coordenadoria'].">".$tupla['nome']."</option>";
                                                                        }
                                                                        else
                                                                        {
                                                                            echo "<option value='0'>Sede</option>";
                                                                        }
                                                                    }                                                                        
                                                                    ?>
                                                                </select>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="150" class="dataField">                                                
                                                &nbsp;<select name="comboDiretoria" id="comboDiretoria" style="width:130px; height:18px;">
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
                                            <td width="165">
                                                 <select name="comboStatus" id="comboStatus" style="width:130px; height:18px;">
                                                    <option selected value="0">[---------- Selecione ----------]</option>
                                                    <option value='1'>Empenhadas</option>
                                                    <option value='2'>Solicitadas</option>
                                                    <option value='3'>Autorizadas</option>                                                    
                                                </select>
                                            </td>
                                            <td width="80" height="21">
                                                <input id="dataInicio" type="text" name="txtDataInicio" onchange="javascript:habilitaGrafico();" maxlength="10" style=" width:75px;height:15px;" />
                                            </td>
                                            <td width="20" height="21">
                                                <a href="#" onClick="javascript:displayCalendar(document.getElementById('dataInicio'),'dd/mm/yyyy',this);" >
                                                    <img src="../Icones/ico_calendario.gif" border="0" title="Mostrar Calendário" style="width:18px; height:18px;"/>
                                                </a>
                                            </td>                                                        
                                            <td width="80" height="21">
                                                <input id="dataFim" type="text" name="txtDataFim" onchange="javascript:habilitaGrafico();" maxlength="10" style="width:75px;height:15px;" />
                                            </td>
                                            <td width="20" height="21">
                                                <a href="#" onClick="javascript:displayCalendar(document.getElementById('dataFim'),'dd/mm/yyyy',this);">
                                                    <img src="../Icones/ico_calendario.gif" border="0" title="Mostrar Calendário" style="width:18px; height:18px;"/>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="21" width="798" colspan="7">Projeto</td>                                                        
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21" colspan="7"><?=f_ComboProjetos('cmbProjeto','780','','onchange="VerificaEtapa()"','114')?></td>                                                        
                                        </tr>
                                        <tr class="dataLabel">                                                        
                                            <td height="21" width="798" colspan="7">Fonte</td>
                                        </tr>
                                        <tr class="dataField">                                                        
                                            <td height="21" colspan="7"><?=f_ComboFontes('cmbFonte','780','','onchange="VerificaEtapa()"','114')?></td>
                                        </tr>
                                         <tr class="dataLabel">
                                            <td height="21" colspan="7">
                                                <span id="desEtapa" style="display:none">Etapa</span>
                                            </td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21" colspan="7">  
                                                <span id="spEtapa" style="display:none"></span>
                                            </td>
                                        </tr>   
                                    </table>                                    
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr height="25">
                                            <td align="right">
                                                <span id="spanGrafico" style="display: none;">
                                                    <input type="button" style="width:100px;" onclick="Javascript:GerarGrafico(document.Form);" name="btnGravar" class="botao" value="Gerar Gráfico"></input>
                                                </span>
                                            </td>
                                            <td align="right">
                                                <input type="button" style="width:100px;" onClick="Javascript:GerarRelatorio(document.Form);" name="btnGravar" class="botao" value="Gerar Relatório"></input>
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
