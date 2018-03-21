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
    <script type="text/javascript" language="javascript" src="JavaScript/ScriptRelatorioDiariaServidor.js"></script>
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


                                                <td>
                                                    <table border="0" cellpadding="1" cellspacing="0" width="308">
                                                        <tr class="dataLabel">
                                                            <td height="20" width="208" colspan="3" class="dataLabel" align="left">Selecione o Servidor:</td>
                                                        </tr>
                                                        <tr class="dataLabel">
                                                            <td height="21" width="58">
                                                                <?php ComboBeneficiario('todos', '');?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>

                                                <td width="308">
                                                    <span id="spPeriodo" style="display:block">
                                                                <table border="0" cellpadding="1" cellspacing="0" width="308">
                                                                    <tr class="dataLabel">
                                                                        <td height="20" width="208" colspan="3" class="dataLabel" align="right">Data de Início do Período</td>
                                                                        <td height="20" width="100" colspan="3" class="dataLabel" align="right">Data Final do Período</td>
                                                                    </tr>
                                                                    <tr class="dataLabel">
                                                                        <td height="21" width="58"></td>
                                                                        <td height="21" width="80"><input id="dataInicio" type="text" name="dataInicio" maxlength="10" style=" width:75px;height:15px;"/></td>
                                                                        <td height="21" width="20"><a href="#" onClick="javascript:displayCalendar(document.getElementById('dataInicio'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18" /></a></td>
                                                                        <td height="21" width="50"></td>
                                                                        <td height="21" width="80"><input id="dataFim" type="text" name="dataFim" maxlength="10" style="width:75px;height:15px;"/></td>
                                                                        <td height="21" width="20"><a href="#" onClick="javascript:displayCalendar(document.getElementById('dataFim'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calend�rio" width="18"/></a></td>
                                                                    </tr>
                                                                </table>
                                                            </span>
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr class="dataLabel">
                                                <td width="150" height="20">Tipo de Relat&oacute;rio:</td>
                                                <td width="340">
                                                    <table border="0" cellpadding="1" cellspacing="1" width="290">
                                                        <tr class="dataLabel">
                                                            <td width="130" >
                                                                <input id="coordenadoria" type="radio" class="radio" name="radio_tipo_relat" style="width:10px; height:10px;" value="coord" onClick="HabComboCoordenadoria()"/> Coordenadoria
                                                            </td>
                                                            <td width="80">
                                                                <?php
                                                                if($_SESSION['TipoUsuario'] != '31')
                                                                {
                                                                    echo'<input id="todos" type="radio" class="radio" name="radio_tipo_relat" style="width:10px; height:10px;" value="todos" onClick="HabComboCoordenadoria()"/> Todas';
                                                                }
                                                                else
                                                                {
                                                                    echo'<input id="todos" type="radio" class="radio" disabled name="radio_tipo_relat" style="width:10px; height:10px;" value="todos" onClick="HabComboCoordenadoria()"/> Todas';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td width="130">
                                                                <label id="campo_coordenadoria" style="display:none">
                                                                    <select name="combo_coordenadoria" id="combo_coordenadoria" style="width:120px; height:18px;">
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
                                                <td width="308">
                                                            <span id="spAno" style="display:none">
                                                                <table border="0" cellpadding="1" cellspacing="0" width="358">
                                                                    <tr class="dataLabel">
                                                                        <td width="58"></td>
                                                                        <td height="20" width="100">Escolha o Ano:</td>
                                                                        <td height="20" width="150">
                                                                            <?php f_ComboAno('comboAno','80',date('Y'),'size="1"','2');?>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </span>
                                                    <span id="spPeriodo" style="display:none">
                                                                <table border="0" cellpadding="1" cellspacing="0" width="308">
                                                                    <tr class="dataLabel">
                                                                        <td height="20" width="208" colspan="3" class="dataLabel" align="right">Data de Início do Período</td>
                                                                        <td height="20" width="100" colspan="3" class="dataLabel" align="right">Data Final do Período</td>
                                                                    </tr>
                                                                    <tr class="dataLabel">
                                                                        <td height="21" width="58"></td>
                                                                        <td height="21" width="80"><input id="dataInicio" type="text" name="dataInicio" maxlength="10" style=" width:75px;height:15px;"/></td>
                                                                        <td height="21" width="20"><a href="#" onClick="javascript:displayCalendar(document.getElementById('dataInicio'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18" /></a></td>
                                                                        <td height="21" width="50"></td>
                                                                        <td height="21" width="80"><input id="dataFim" type="text" name="dataFim" maxlength="10" style="width:75px;height:15px;"/></td>
                                                                        <td height="21" width="20"><a href="#" onClick="javascript:displayCalendar(document.getElementById('dataFim'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calend�rio" width="18"/></a></td>
                                                                    </tr>
                                                                </table>
                                                            </span>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="1" cellspacing="1" width="798">
                                            <tr class="dataLabel">
                                                <td width="340">
                                                    <table border="0" cellpadding="1" cellspacing="1" width="290">
                                                        <tr class="dataLabel">
                                                            <td width="130">
                                                                <label id="campo_coordenadoria" style="display:none">
                                                                    <select name="combo_coordenadoria" id="combo_coordenadoria" style="width:120px; height:18px;">
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
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <?php include "../Include/Inc_Linha.php"?>
                            <table border="0" cellpadding="1" cellspacing="1" width="800">
                                <tr>
                                    <td align="right">
                                        <input type="button" style="width:100px; height:20px;" onClick="Javascript:GerarRelatorioDesconto(document.Form);" name="btnGravar" class="botao" value="Gerar Relatório"></input>
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