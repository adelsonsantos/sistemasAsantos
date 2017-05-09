<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaAgrupadaExecucao.php";
?>
<html>
    <style type="text/css">@import url("../css/estilo.css"); </style>
    <script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
    <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
    <script language="javascript"charset="utf-8">

    </script>

    <body onLoad="WM_initializeToolbar();">

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
                                <td valign="top" align="left">

                                    <?php include "../Include/Inc_Titulo.php" ?>

                                    <?php include "../Include/Inc_Linha.php" ?>


                                    <table cellpadding="0" cellspacing="0" width="800" border="0">
                                        <tr>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td class="GridPaginacaoRegistroCabecalho">Solicita&ccedil;&atilde;o:</td>
                                                        <td class="GridPaginacaoLink"><?php echo $diariasAgrupadas[0]->super_sd; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="GridPaginacaoRegistroCabecalho">Processo:</td>
                                                        <td class="GridPaginacaoLink"><?php echo $diariasAgrupadas[0]->diaria_processo; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="GridPaginacaoRegistroCabecalho">Projeto:</td>
                                                        <td class="GridPaginacaoLink"><?php echo $diariasAgrupadas[0]->projeto_cd; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="GridPaginacaoRegistroCabecalho">Fonte:</td>
                                                        <td class="GridPaginacaoLink"><?php echo $diariasAgrupadas[0]->fonte_cd; ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                    </table>

                                    <?php include "../Include/Inc_Linha.php" ?>

                                    <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                    <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                                        <td width="30" align="center">A&ccedil;&otilde;es</td>
                                                        <td width="80" align="center">SD</td>
                                                        <td width="290" align="left">&nbsp;Nome</td>
                                                        <td width="120" align="center">Data Solicitação</td>
                                                        <td width="120" align="center">Partida Prevista</td>
                                                        <td width="120" align="center">Chegada Prevista</td>
                                                        <td width="100" align="center">Valor</td>
                                                    </tr>
                                                    <?php 
                                                    for ($index = 0; $index < count($diariasAgrupadas); $index++) { 
                                                        $diaria = $diariasAgrupadas[$index]; ?>
                                                        <tr height='20' class='linhaGrid'>
                                                            <td align='center' width="30"><a href='SolicitacaoConsultarFinanceiro.php?acao=consultar&cod=<?php echo $diaria->diaria_id; ?>&pagina=<?php echo $PaginaLocal; ?>'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'/></a></td>
                                                            <!--<td align='center'width="30"><a href='SolicitacaoExecutar.php?acao=consultar&cod=<?php echo $diaria->diaria_id; ?>&pagina=<?php echo $PaginaLocal; ?>'><img src='../Icones/ico_comprovar.png' border='0' alt='Executar'/></a></td>-->
                                                            <td align='center'><?php echo $diaria->diaria_numero; ?></td>
                                                            <td>&nbsp;<?php echo $diaria->pessoa_nm; ?></a></td>
                                                            <td align='center'><?php echo $diaria->diaria_dt_criacao; ?> &agrave;s <?php echo $diaria->diaria_hr_criacao; ?></td>
                                                            <td align='center'><?php echo $diaria->diaria_dt_saida; ?>&agrave;s <?php echo $diaria->diaria_hr_saida; ?></td>
                                                            <td align='center'><?php echo $diaria->diaria_dt_chegada; ?>&agrave;s <?php echo $diaria->diaria_hr_chegada; ?></td>
                                                            <td align='center'><?php echo $diaria->diaria_valor; ?></td> 
                                                        </tr>
                                                    <?
                                                    } // for ?>
                                                </table>
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