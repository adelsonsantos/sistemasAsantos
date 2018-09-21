<?php
include "../Include/Inc_Configuracao.php";
include "../SistemaDiarias/Classe/ClasseBloqueioServidor.php";
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
    <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
    <script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
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

            frm.action = "BloqueioServidorInicio.php?acao=buscar";
            frm.submit();
        }

        function TodosForm(frm)
        {
            frm.txtFiltro.value = "";
            frm.action = "BloqueioServidorInicio.php";
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

            frm.action="FuncionarioExcluir.php?excluirMultiplo=1";
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

            frm.action="FuncionarioCadastrar.php?acao=consultar";
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
                        <td valign="top" align="left" width="800">
                            <?php include "../Include/Inc_Titulo.php"?>
                            <?php include "../Include/Inc_Linha.php"?>
                            <?php include "../Include/Inc_PesquisaBloqueado.php"?>
                            <?php include "../Include/Inc_Linha.php"?>
                            <?php include "../Include/Inc_Linha.php"?>

                            <table width="800" border="0" cellpadding="1" cellspacing="1" class="GridPaginacao">
                                <tr class="dataLabel">
                                    <td height="20" width="85" align="left">Matr&iacute;cula</td>
                                    <td height="20" width="443" align="left">Nome</td>
                                    <td height="20" width="130" align="center">Estrutura / Atua&ccedil;&atilde;o</td>
                                    <td height="20" width="140" align="center">Status</td>
                                    <td height="20" width="40" colspan="2">&nbsp;Ações</td>
                                </tr>
                                <?php
                                $paginaAtual = (int) $_GET['PaginaMostrada'];
                                $qtdRegistroPagina = $iPageSize;
                                $qtdRegistroTotal  = pg_num_rows($rsConsulta);
                                $qtdIndice         = $paginaAtual * $qtdRegistroPagina;
                                $qtdIndiceFinal    = (($qtdIndice + $qtdRegistroPagina)-1);
                                $qtdPagina         = ($qtdRegistroTotal/$qtdRegistroPagina);
                                $qtdPagina         = ceil($qtdPagina);



                                While((($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal)))
                                {
                                    $linha = pg_fetch_assoc($rsConsulta,$qtdIndice);

                                    $Codigo           = $linha['pessoa_id'];
                                    $Matricula        = $linha['funcionario_matricula'];
                                    $EstruturaAtuacao = $linha['est_organizacional_sigla'];
                                    $Nome             = $linha['pessoa_nm'];
                                    $StatusNumero     = $linha['pessoa_bloq_diaria'];
                                    $Confirmado       = $linha['funcionario_validacao_propria'];

                                    If ($StatusNumero == "0")
                                    {
                                        $StatusNome = "Desbloqueado";
                                    }
                                    Else
                                    {
                                        $StatusNome = "Bloqueado";
                                    }

                                    $CodigoRegistro = $Codigo;

                                    echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";

                                    echo "<td height='40'>" .$Matricula. "</td>";
                                    echo "<td height='40'>" .$Nome. "</font></td>";

                                    echo "<td height='40' align='center'>".$EstruturaAtuacao. "</td>";
                                    if($_SESSION['TipoUsuario'] != '32')
                                    {
                                        echo "<td height='20' align='center'><a href=BloqueioServidorInicio.php?acao=alterarStatus&cod=".$Codigo. "&status=" .$StatusNumero. "><font color='#065387'>".$StatusNome. "</font></a></td>";
                                    }
                                    else
                                    {
                                        echo "<td height='20' align='center'>$StatusNome</td>";
                                    }

                                    echo $StatusNumero == "0" ?
                                        "<td width='20' align='center'><img src='../Icones/ico_alterar_off.png' alt='Editar' border='0'/></td>" :
                                        "<td width='20' align='center'><a href='BloqueioServidorCadastrar.php?cod=".$CodigoRegistro."&acao=consultar&acaoTitulo=Consultar'><img src='../Icones/ico_alterar.png' alt='Editar' border='0'/></td>" ;

                                    echo $StatusNumero == "0" ?
                                         "<td width='20' align='center'><a href='BloqueioServidorCadastrar.php?cod=".$CodigoRegistro."&acao=consultar&acaoTitulo=Consultar'><img src='../Icones/ico_bloquear.png' alt='Editar' border='0'/></td>" :
                                         "<td width='20' align='center'><a href=BloqueioServidorInicio.php?acao=alterarStatus&cod=".$Codigo. "&status=" .$StatusNumero. "><img src='../Icones/ico_desbloquear.png' alt='Editar' border='0'/></td>";





                                    echo "</tr>";

                                    $qtdIndice++;
                                }
                                $paginaAtual++;
                                ?>
                                <tr>
                                    <td colspan="8"><?php include "../Include/Inc_Paginacao.php"?></td>
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

