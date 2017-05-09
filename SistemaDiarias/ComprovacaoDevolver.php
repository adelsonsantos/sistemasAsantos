<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaComprovacaoDevolucao.php";
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
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script language="javascript" charset="utf-8">        

            function Foco(frm)
            {
                frm.cmbMotivoDiaria.focus();
            }

            function GravarForm(frm)
             {

                for(cont=0; cont < frm.elements.length; cont++)
                    frm.elements[cont].style.backgroundColor = '';

                if (frm.cmbMotivoDiaria.value == "0")
                {
                    alert("Escolha um MOTIVO DE DEVOLU��O.");
                    frm.cmbMotivoDiaria.focus();
                    frm.cmbMotivoDiaria.style.backgroundColor='#B9DCFF';
                    return false;
                }

                frm.action = "ComprovacaoDevolver.php?acao=devolver&pagina="+frm.txtPaginaLocal.value;
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
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">
                                    <table cellpadding="0" cellspacing="0" border="0" width="800">
                                        <tr>
                                            <td align="center" class="tabPesquisa" >
                                                <table cellpadding="0" border="0" cellspacing="0" width="798">
                                                    <tr>
                                                        <td><img src="../Imagens/vazio.gif" width="1" height="2" border="0"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" class="LinhaTexto"><b>Confirma devolu&ccedil;&atilde;o da comprova&ccedil;&atilde;o abaixo?</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="../Imagens/vazio.gif" width="1" height="2" border="0"/></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                <?php include "../Include/Inc_Linha.php"?>
                                    <table cellpadding="0" cellspacing="0" width="798" border="0" class="GridPaginacao">
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                    <tr class="GridPaginacaoRegistroCabecalho">
                                                        <td height="21" width="100" align="center">SD</td>
                                                        <td height="21" width="250" align="left">Nome</td>
                                                        <td height="21" width="110" align="center">Partida Efetiva</td>
                                                        <td height="21" width="110" align="center">Chegada Efetiva</td>
                                                        <td height="21" width="228" align="left">Motivo da Viagem</td>
                                                    </tr>
                                                  <?php
                                                    $linharsConsulta = pg_fetch_assoc($rsConsulta);

                                                    If ($linharsConsulta)
                                                    { 	
                                                        echo "<tr bgcolor='#f2f2f2' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                            echo "<td height='21' class='GridPaginacaoLink' align='center'>" .$linharsConsulta['diaria_numero']. "</td>";
                                                            echo "<td height='21' class='GridPaginacaoLink' align='left'>" .$linharsConsulta['pessoa_nm']. "</td>";
                                                            echo "<td height='21' class='GridPaginacaoLink' align='center'>" .$linharsConsulta['diaria_comprovacao_dt_saida']. " " .$linharsConsulta['diaria_comprovacao_hr_saida']. "</td>";
                                                            echo "<td height='21' class='GridPaginacaoLink' align='center'>" .$linharsConsulta['diaria_comprovacao_dt_chegada']. " " .$linharsConsulta['diaria_comprovacao_hr_chegada']. "</td>";
                                                            echo "<td height='21' class='GridPaginacaoLink' align='left'>" .$linharsConsulta['motivo_ds']. "</td>";
                                                        echo "</tr>";
                                                    }
                                                 ?>
                                                 </table>
                                            </td>
                                        </tr>
                                    </table>                                                            
                                <?php include "../Include/Inc_Linha.php" ?>
                                    <table width="798" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr>
                                                        <td height="21" class="dataLabel" width="150">Motivo da Devolu&ccedil;&atilde;o</td>
                                                        <td height="21" class="dataField" width="648"><?=ComboMotivoDiaria(0,2,"")?>&nbsp;*</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="21" class="dataLabel">Descri&ccedil;&atilde;o</td>
                                                        <td height="21" class="dataField"><textarea name="txtDescricaoDevolucao" style=" width:309px; height:60px" maxlenght="255"></textarea></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                     </table>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr>
                                            <td height="21" class="dataLinha">(*) Campo obrigat&oacute;rio</td>
                                        </tr>
                                    </table>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td height="21" align="right">
                                                <input type="button" style="width:70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao" value="Gravar"/>&nbsp;&nbsp;&nbsp;
                                                <input type="button" style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>inicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
                                           </td>
                                       </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    <input type="hidden" name="txtCodigo" value="<?=$Codigo?>"/>
                    <input type="hidden" name="txtStatus" value="<?=$linharsConsulta['diaria_st']?>"/>
                    <input type="hidden" name="txtPaginaLocal" value="<?=$PaginaLocal?>"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>