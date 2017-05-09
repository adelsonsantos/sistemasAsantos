<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseUsuario.php";
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
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script language="javascript">

            function Foco(frm)
            {
                frm.txtFiltro.focus();
            }

            function FiltrarForm(frm)
            {

                for(cont=0; cont < frm.elements.length; cont++)
                    frm.elements[cont].style.backgroundColor = '';

                if (frm.txtFiltro.value == "")
                {
                    alert("Digite filtro para busca.");
                    frm.txtFiltro.focus();
                    frm.txtFiltro.style.backgroundColor='#B9DCFF';
                    return false;
                }

                frm.action = "UsuarioInicio.php?acao=buscar";
                frm.submit();
            }

            function TodosForm(frm)
            {
                frm.txtFiltro.value = "";
                frm.action = "UsuarioInicio.php";
                frm.submit();
            }

            function Redirect(frm)
            {
                frm.action = "UsuarioInicio.php?filtro="+frm.cmbStatus.value;
                frm.submit();
            }

        </script>
    </head>

    <body onLoad="WM_initializeToolbar();">
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
                                    
                                    <table cellpadding="0" border="0" cellspacing="0" width="100%"  class="GridPaginacao">
                                        <tr>
                                            <td><img src="../Imagens/vazio.gif" width="1" height="3" border="0"/></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="LinhaTexto">
                                                <table cellpadding="1" border="0" cellspacing="1" width="100%">
                                                    <tr class="dataField">
                                                        <td width="270">
                                                            <input name="txtFiltro" maxlength="100" type="text" value="<?=$RetornoFiltro?>" style=" width:265px; height:15px;"/>
                                                        </td>
                                                        <td width="75" valign="middle">
                                                            <input type="button" style="width:70px; height: 18px;" onClick="Javascript:FiltrarForm(document.Form);" class="botao" value="Pesquisar"/>
                                                        </td>
                                                        <?php
                                                        If ($RetornoFiltro != "")
                                                        {
                                                           echo "<td valign=middle><input type='button' style=width:90px; height:18px; onClick=Javascript:TodosForm(document.Form); class=botao value='Exibir Todos'/></td>";
                                                        }
                                                        Else
                                                        {
                                                           echo "<td>&nbsp;</td>";
                                                        }

                                                           echo "<td align=right>Ver status ";

                                                            If ($numFiltro == "")
                                                            {
                                                                $strCLogin   = "";
                                                                $strSLogin = "";
                                                                $strTodos   = "Selected";
                                                            }
                                                            ElseIf ($numFiltro == 1)
                                                            {
                                                                $strCLogin   = "Selected";
                                                                $strSLogin   = "";
                                                                $strTodos    = "";
                                                            }
                                                            Elseif ($numFiltro == 0)
                                                            {
                                                                $strCLogin = "";
                                                                $strSLogin = "Selected";
                                                                $strTodos  = "";
                                                            }

                                                            echo "<select name='cmbStatus' onchange='Redirect(document.Form);'>";
                                                                 echo "<option value='' " .$strTodos.">Todos</option>";
                                                                 echo "<option value='1' " .$strCLogin.">Com Login</option>";
                                                                 echo "<option value='0' ".$strSLogin. ">Sem Login</option>";
                                                            echo "</select>
                                                               </td>";
                                                        ?>                                                                    
                                                   </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="../Imagens/vazio.gif" width="1" height="2" border="0"/></td>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table border="0" cellpadding="1" cellspacing="1" class="GridPaginacao">
                                        <tr class="GridPaginacaoRegistroCabecalho">
                                            <td height="20" width="75" colspan="3">&nbsp;</td>
                                            <td height="20" width="345" align="left">Nome</td>
                                            <td height="20" width="198" align="left">Estrutura</td>
                                            <td height="20" width="120" align="left">Login</td>
                                            <td height="20" width="60" align="center">Status</td>
                                        </tr>
                                        <?php
                                        $paginaAtual        =(int) $_GET['PaginaMostrada'];
                                        $qtdRegistroPagina  = $iPageSize;
                                        $qtdRegistroTotal   = pg_num_rows($rsConsulta);
                                        $qtdIndice          = $paginaAtual * $qtdRegistroPagina;
                                        $qtdIndiceFinal     = (($qtdIndice + $qtdRegistroPagina)-1);
                                        $qtdPagina          = ($qtdRegistroTotal/$qtdRegistroPagina);
                                        $qtdPagina          = ceil($qtdPagina);

                                        While((($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal)))
                                        {
                                            $linha = pg_fetch_assoc($rsConsulta,$qtdIndice);

                                            $Codigo	      = $linha['pessoa_id'];
                                            $Nome	      = $linha['pessoa_nm'];
                                            $Login        = $linha['usuario_login'];
                                            $StatusNumero = $linha['usuario_st'];
                                            $Estrutura    = $linha['est_organizacional_sigla'];

                                            echo "<tr bgcolor='#f2f2f2' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                echo "<td height='20' width='20' align='center'>";

                                            If ($_SESSION['BotaoConsultar'] == false)
                                            {
                                                echo "<img src='../icones/ico_consultar_off.png' alt='Consultar' border='0'/>";
                                            }
                                            Else
                                            {	
                                                If ($_SESSION['BotaoConsultar'] != 0)
                                                {
                                                    echo "<a href=".$PaginaLocal."Consultar.php?cod=" .$Codigo. "&acao=consultar><img src='../icones/ico_consultar.png' alt='Consultar' border='0'/></a>";
                                                }
                                            }
                                                echo "</td>";
                                                echo "<td height='20' width='20' align='center'><a href='" .$PaginaLocal."Cadastrar.php?cod=".$Codigo."&acao=consultar&acaoTitulo=Editar'><img src='../icones/ico_alterar.png' alt='Editar' border='0'></a></td>";
                                                echo "<td height='20' width='20' align='center'><a href='" .$PaginaLocal."Excluir.php?cod=".$Codigo."&acao=consultar&acaoTitulo=Excluir'><img src='../icones/ico_excluir.png'  alt='Excluir' border='0'></a></td>";
                                                echo "<td height='20'>".$Nome."</td>";
                                                echo "<td height='20'>".$Estrutura."</td>";
                                                echo "<td height='20'>".$Login."</td>";

                                            If ($Login != "")
                                            {
                                                echo "<td align='center'><font color='#ff0000'>Com Login</font></td>";
                                            }
                                            Else
                                            {	
                                                echo "<td height='20' align='center'><font color='#ff0000'>Sem Login</font></td>";
                                            }

                                            echo "</tr>";
                                            $qtdIndice++;
                                        }
                                        $paginaAtual++;
                                        ?>
                                        <tr>
                                            <td colspan="7"><?php include "../Include/Inc_Paginacao.php"?></td>
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
