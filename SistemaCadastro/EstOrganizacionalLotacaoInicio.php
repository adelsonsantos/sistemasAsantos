<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseEstruturaLotacao.php";
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

                frm.action = "EstOrganizacionalLotacaoInicio.php?acao=buscar";
                frm.submit();
            }

            function TodosForm(frm)
            {
                frm.txtFiltro.value = "";
                frm.action = "EstOrganizacionalLotacaoInicio.php";
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

                frm.action="EstOrganizacionalLotacaoExcluir.php?excluirMultiplo=1";
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

                frm.action="EstOrganizacionalLotacaoCadastrar.php?acao=consultar";
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
                                            <td height="20" colspan="8"><?php include "../Include/Inc_RegistroOpcoes.php"?></td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="20" width="80" colspan="4">&nbsp;</td>
                                            <td height="20" width="170" align="center">Sigla</td>
                                            <td height="20" width="199" align="center">Unidade Superior</td>
                                            <td height="20" width="289" align="left">Unidade</td>
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
                                            $EstOrganizacionalCodigo    = $linha['est_organizacional_lotacao_id'];
                                            $EstOrganizacionalDescricao = $linha['est_organizacional_lotacao_ds'];
                                            $EstOrganizacionalSigla	= $linha['est_organizacional_lotacao_sigla'];
                                            $EstOrganizacionalStatusCod = $linha['est_organizacional_lotacao_st'];

                                            If ($EstOrganizacionalStatusCod == "0")
                                            {
                                                $EstOrganizacionalStatus = "Ativo";
                                            }
                                            Else
                                            {	
                                                $EstOrganizacionalStatus = "Inativo";
                                            }
                                            
                                            If (strlen($EstOrganizacionalSigla) > 28)
                                            {
                                                $EstOrganizacionalSigla = substr($EstOrganizacionalSigla,0,26)."...";
                                            }
                                            
                                            If (strlen($EstOrganizacionalSuperior) > 32)
                                            {
                                                $EstOrganizacionalSuperior = substr($EstOrganizacionalSuperior,0,30)."...";
                                            }

                                            If (strlen($EstOrganizacionalDescricao) > 50)
                                            {
                                                $EstOrganizacionalDescricao = substr($EstOrganizacionalDescricao,0,48)."...";
                                            }


                                            $CodigoRegistro = $EstOrganizacionalCodigo;

                                            echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                    include "../Include/Inc_Registro.php";
                                                echo "<td height='20' align='left' title='".$linha['est_organizacional_lotacao_sigla']."'>" .$EstOrganizacionalSigla."</td>";
                                                echo "<td height='20' align='left' title='".$linha['estsuperior']."'>" .$EstOrganizacionalSuperior. "</td>";
                                                echo "<td height='20' title='".$linha['est_organizacional_lotacao_ds']."'>" .$EstOrganizacionalDescricao."</td>";
                                                echo "<td height='20' align='center'><a href=EstOrganizacionalLotacaoInicio.php?acao=alterarStatus&cod=".$EstOrganizacionalCodigo. "&status=" .$EstOrganizacionalStatusCod. "><font color='#065387'>" .$EstOrganizacionalStatus. "</font></a></td>";
                                            echo "</tr>";

                                            $qtdIndice++;
                                         }

                                        $paginaAtual++;
                                        ?>
                                        <tr>
                                            <td height="20" colspan="8"><?php include "../Include/Inc_Paginacao.php"?></td>
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
