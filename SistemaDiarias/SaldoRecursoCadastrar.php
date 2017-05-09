<?php
include "Classe/ClasseSaldoRecurso.php";
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
        <link type="text/css" href="../css/estilo.css" rel="stylesheet"/>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery.maskedinput-1.2.2.js"></script>
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptDiariaSaldoRecurso.js"></script>
    </head>
    
    <body onload="Javascript:WM_initializeToolbar();HabilitarDados();">
        <form name="Form" method="post" action="">
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
                                    <table width="800" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21" colspan="5">Projeto</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21" colspan="5"><?=f_ComboProjeto($_GET['codProjeto'], 'onChange="Javascript:HabilitarDados();LimpaDados();"')?></td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="21" colspan="5">Descrição da Fonte</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21" colspan="5"><?=f_ComboFontes('cmbFonte','785',$_GET['codFonte'],'onchange="Javascript:LimpaDados();" disabled','114')?></td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td width="200" height="21">Mês</td>
                                            <td width="200" height="21">Saldo</td>
                                            <td width="400" height="21" colspan="3">Ações</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21">
                                                <?php f_ComboMes('cmbMes','150','8','disabled','');?>
                                            </td>
                                            <td height="21">
                                                <input type="text" id="txtSaldo" name="txtSaldo" onKeyPress="Javascript:return(MascaraMoeda(this,'.',',',event));" style="width:150px; height:18px;" disabled value="0,00"/>
                                            </td>       
                                            <td width="100" height="21">
                                                <input type="button" class="botao" id="btnAdicionar" name="btnAdicionar" onclick="Javascript:AdicionaSaldoMes();" style="width:80px; height:18px;" value="Adicionar" disabled/>                                                
                                            </td>
                                            <td width="100" height="21">
                                                <input type="button" class="botao" id="btnLimparSaldo" name="btnLimparSaldo" onclick="Javascript:LimpaDados();" style="width:80px; height:18px;" value="Limpar" disabled/>
                                            </td>
                                            <td width="200" height="21"></td>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php";?>
                                    <div id="listaSaldoMesEditar">
                                    <?php                                    
                                        if($acaoSistema == 'consultar')
                                        {
                                            print '<table width="800" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">';
                                            $linhas = 0;
                                            while($linhaConsulta = pg_fetch_assoc($rsConsulta))
                                            {
                                                $mesId    = $linhaConsulta['saldo_mes'];
                                                $saldoMes = $linhaConsulta['saldo_valor'];

                                                print '<tr class="dataLabel">
                                                           <td width="200" height="21">Mês</td>
                                                           <td width="200" height="21">Saldo</td>
                                                           <td width="400" height="21">&nbsp;</td>
                                                       </tr>
                                                       <tr class="dataField">
                                                           <td height="21"><input type="text" value="'.retornaMes($mesId).'" id="mesSelecionado'.$mesId.'" name="mesSelecionado'.$mesId.'" style="width:150px; height:18px;" readonly="readonly" /></td>
                                                           <td height="21"><input type="text" value="'.number_format($saldoMes,2,',','.').'" id="saldoMes'.$mesId.'" name="saldoMes'.$mesId.'" onKeyPress="Javascript:return(MascaraMoeda(this,\'.\',\',\',event));" style="width:150px; height:18px;"  /></td>
                                                           <td height="21">&nbsp;</td>
                                                       </tr>';
                                                $linhas ++;
                                            }
                                            print '</table>
                                                   <input type="hidden" value="'.$linhas.'" id="numRegistros" name="numRegistros"/>';
                                        }
                                        ?>
                                    </div>
                                    <div id="listaSaldoMes"></div>
                                    <table width="800" border="0" cellpadding="1" cellspacing="1">
                                        <tr class="dataLinha">
                                            <td height="21">(*) Campo obrigatório</td>
                                        </tr>
                                    </table>
                                    
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
                                        <tr>
                                            <td height="25" align="right">
                                                <?php
                                                if($acaoSistema == 'consultar')
                                                {
                                                    echo '<input type="button" style="width:70px" onclick="Javascript:GravarForm(document.Form);" name="btnEditar" id="btnGravar" class="botao" value="Editar"/>';
                                                }
                                                else
                                                {
                                                    echo '<input type="button" style="width:70px" onclick="Javascript:GravarForm(document.Form);" name="btnGravar" id="btnGravar"  class="botao" value="Gravar"/>';
                                                }
                                                ?>                                                
                                                <input type="button" style="width:70px" onclick="Javascript:window.location.href='CadastroSaldoRecursoInicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
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