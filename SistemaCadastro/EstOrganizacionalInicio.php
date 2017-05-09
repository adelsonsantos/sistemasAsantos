<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseEstrutura.php";
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
        <script type="text/javascript" language="javascript">

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

                frm.action = "EstOrganizacionalInicio.php?acao=buscar";
                frm.submit();
            }

            function TodosForm(frm)
            {
                frm.txtFiltro.value = "";
                frm.action = "EstOrganizacionalInicio.php";
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

                frm.action="EstOrganizacionalExcluir.php?excluirMultiplo=1";
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

                frm.action="EstOrganizacionalCadastrar.php?acao=consultar";
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
                    <td>
                        <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">
                                    <?php include "../Include/Inc_Titulo.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <?php include "../Include/Inc_Pesquisa.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table border="0" cellpadding="1" cellspacing="1" class="GridPaginacao">
                                        <tr>
                                            <td height="20" colspan="9"><?php include "../Include/Inc_RegistroOpcoes.php"?></td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="20" width="80" colspan="4">&nbsp;</td>
                                            <td height="20" width="180">Sigla</td>
                                            <td height="20" width="180">Unidade Superior</td>
                                            <td height="20" width="78" align="center">CC</td>
                                            <td height="20" width="220" align="left">Unidade</td>
                                            <td height="20" width="60" align="center">Status</td>
                                        </tr>
                                    <?php 
                                        
                                        $paginaAtual       =(int) $_GET['PaginaMostrada'];
                                        $qtdRegistroPagina = $iPageSize;
                                        $qtdRegistroTotal  = pg_num_rows($rsConsulta);
                                        $qtdIndice         = $paginaAtual * $qtdRegistroPagina;
                                        $qtdIndiceFinal    = (($qtdIndice + $qtdRegistroPagina)-1);
                                        $qtdPagina         = ($qtdRegistroTotal/$qtdRegistroPagina);
                                        $qtdPagina         = ceil($qtdPagina);

                                        While((($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal)))
                                        {       
                                            $linha = pg_fetch_assoc($rsConsulta,$qtdIndice);

                                            $EstOrganizacionalSuperior  = $linha['estsuperior'];
                                            $EstOrganizacionalCodigo    = $linha['est_organizacional_id'];
                                            $CentroCustoNumero          = $linha['est_organizacional_centro_custo_num'];
                                            $EstOrganizacionalDescricao = $linha['est_organizacional_ds'];
                                            $EstOrganizacionalSigla	= $linha['est_organizacional_sigla'];
                                            $EstOrganizacionalStatusCod = $linha['est_organizacional_st'];

                                            If ($EstOrganizacionalStatusCod == "0")
                                            {
                                                $EstOrganizacionalStatus = "Ativo";
                                            }
                                            Else
                                            {
                                                $EstOrganizacionalStatus = "Inativo";
                                            }

                                            If (strlen($EstOrganizacionalDescricao) > 27)
                                            {
                                                $Reticencias = "...";
                                            }
                                            Else
                                            {
                                                $Reticencias = "";
                                            }

                                            $CodigoRegistro = $EstOrganizacionalCodigo;

                                            echo "<tr class = 'dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                            include "../Include/Inc_Registro.php";
                                                echo "<td height='20' align='left'>".$EstOrganizacionalSigla. "</td>";
                                                echo "<td height='20' align='left'>" .$EstOrganizacionalSuperior. "</td>";
                                                echo "<td height='20' align='center'>" .$CentroCustoNumero. "</td>";
                                                echo "<td height='20'>" .substr($EstOrganizacionalDescricao,0,27).$Reticencias. "</td>";
                                                echo "<td height='20' align='center'><a href=EstOrganizacionalInicio.php?acao=alterarStatus&cod=".$EstOrganizacionalCodigo. "&status=" .$EstOrganizacionalStatusCod. "><font color='#065387'>" .$EstOrganizacionalStatus. "</font></a></td>";
                                            echo "</tr>";
                                            $qtdIndice++;
                                        }
                                        $paginaAtual++;
                                        ?>
                                        <tr>
                                            <td height="20" colspan="9"><?php include "../Include/Inc_Paginacao.php"?></td>
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
