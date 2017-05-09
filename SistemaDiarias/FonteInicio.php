<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseFonte.php";
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
        <script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
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

                    frm.action = "FonteInicio.php?acao=buscar";
                    frm.submit();
                }

                function TodosForm(frm)
                {
                    frm.txtFiltro.value = "";
                    frm.action = "FonteInicio.php";
                    frm.submit();
                }

                function ExcluirForm(frm, checkbox)
                {
                    cont = 0;
                    for (i = 0 ; i < checkbox.length ; i++)
                        if (checkbox[i].checked == true)
                        {
                            cont = cont + 1;
                        }

                    if (cont == 0)
                    {
                        alert("Escolha pelo menos um registro.");
                        return false;
                    }

                    frm.action="FonteExcluir.php?excluirMultiplo=1";
                    frm.submit();
                }

                function AlterarForm(frm, checkbox)
                {
                    cont = 0;
                    for (i = 0 ; i < checkbox.length ; i++)
                        if (checkbox[i].checked == true)
                        {
                            cont = cont + 1;
                        }

                    if (cont == 0)
                    {
                        alert("Escolha um registro.");
                        return false;
                    }

                    if (cont > 1)
                    {
                        alert("Escolha apenas registro.");
                        return false;
                    }

                    frm.action="ProjetoCadastrar.php?acao=consultar";
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
                                    <?php include "../Include/Inc_Titulo.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <?php include "../Include/Inc_Pesquisa.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <div id="Lista">
                                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                                            <tr>
                                                <td><?php include "../Include/Inc_RegistroOpcoes.php"?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table border="0" cellpadding="1" cellspacing="1">
                                                        <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                                            <td width="80" colspan="4">&nbsp;</td>
                                                            <td width="80" align="center">N&uacute;mero</td>
                                                            <td width="578" align="left">&nbsp;Descri&ccedil;&atilde;o</td>
                                                            <td width="60" align="center">Status</td>
                                                        </tr>
                                                        <?php 
                                                        $paginaAtual        = (int) $_GET['PaginaMostrada'];
                                                        $qtdRegistroPagina  = $iPageSize;
                                                        $qtdRegistroTotal   = pg_num_rows($rsConsulta);
                                                        $qtdIndice          = $paginaAtual * $qtdRegistroPagina;
                                                        $qtdIndiceFinal     = (($qtdIndice + $qtdRegistroPagina)-1);
                                                        $qtdPagina          = ($qtdRegistroTotal/$qtdRegistroPagina);
                                                        $qtdPagina          = ceil($qtdPagina);
                                                        
                                                        While(($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal))
                                                        {       
                                                            $linha  = pg_fetch_assoc($rsConsulta,$qtdIndice);

                                                            $Codigo             = $linha['fonte_cd'];
                                                            $Descricao	   	= $linha['fonte_ds'];
                                                            $StatusNumero	= $linha['fonte_st'];

                                                            If ($StatusNumero == "0")
                                                            {  
                                                                $StatusNome = "Ativo";
                                                            }
                                                            Else
                                                            {  
                                                                $StatusNome = "Inativo";
                                                            }

                                                            $CodigoRegistro = $Codigo;

                                                            echo "<tr height='20' bgcolor='#f2f2f2' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";            
                                                                include "../Include/Inc_Registro.php";
                                                                echo "<td class='GridPaginacaoLink' align='center'>".$Codigo."</td>";
                                                                echo "<td class='GridPaginacaoLink'>&nbsp;" .substr($Descricao,0,90)."</td>";
                                                                echo "<td class='GridPaginacaoLink' align='center'><a href=FonteInicio.php?acao=alterarStatus&cod=".$Codigo."&status=" .$StatusNumero."><font color='#065387'>" .$StatusNome."</font></a></td>";
                                                            echo "</tr>";

                                                         $qtdIndice++;
                                                      }
                                                      $paginaAtual++;
                                                      ?>
                                                     </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><?php include "../Include/Inc_Paginacao.php"?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
