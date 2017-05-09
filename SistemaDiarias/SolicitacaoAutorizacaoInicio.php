<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaAutorizacao.php";
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
        <script type="text/javascript" language="javascript" charset="utf-8">

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

                frm.action = "SolicitacaoAutorizacaoInicio.php?acao=buscar";
                frm.submit();
            }

            function TodosForm(frm)
            {
                frm.txtFiltro.value = "";
                frm.action = "SolicitacaoAutorizacaoInicio.php";
                frm.submit();
            }

            function Autorizar(codigo)
            {
                var resposta = confirm('Tem certeza que deseja autorizar a diária?');
                if (resposta == true)
                {
                    document.Form.action="SolicitacaoAutorizacaoInicio.php?cod="+codigo+"&acao=autorizar";
                    document.Form.submit();
                }
            }
            // Novas funções acresentadas por conta da Mudança de Perfil de Autorizador para Imprimir o processo e a diária.

            function ImprimirDiaria(codigo)
            {
                window.open ("SolicitacaoImprimirPDF.php?acao=imprimir&cod="+codigo);
            }

            function ImprimirProcesso(codigo)
            {
                window.open ("SolicitacaoProcessoPDF.php?acao=imprimir&cod="+codigo);
            }            	 

        </script>
    </head>

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
                                    <?php include "../Include/Inc_Pesquisa_Sem_Filtro.php" ?>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table cellpadding="0" cellspacing="0" width="800" border="0">
                                        <tr class="dataLinha">
                                            <?php 
                                            if ($Roteiro == 0) 
                                            { ?>
                                                <td align="right"><a href="SolicitacaoAutorizacaoInicio.php?roteiro=1"><font color="#000099">Visualizar com roteiro</font></a></td>
                                            <?php                                             
                                            } 
                                            else
                                            { ?>
                                                <td align="right"><a href="SolicitacaoAutorizacaoInicio.php?roteiro=0"><font color="#000099">Visualizar sem roteiro</font></a></td>
                                            <?php                                             
                                            } ?>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table border="0" cellpadding="0" cellspacing="1" width="798" class="GridPaginacao">
                                        <tr class="dataLabel">
                                            <td height="20" width="120" colspan="6"></td>
                                            <td height="20" width="100" align="center">SD</td>
                                            <td height="20" width="318" align="left">Nome</td>
                                            <td height="20" width="150" align="center"><a href='<?= $PaginaLocal ?>Inicio.php?acao=buscar&atributo=diaria_dt_criacao'><u>Data Solicita&ccedil;&atilde;o</u></a></td>
                                            <td height="20" width="130" align="center">Partida Prevista</td>
                                            <td height="20" width="130" align="center">Chegada Prevista</td>
                                        </tr>
                                        <?php
                                        //DADOS PARA A PAGINAÇÃO
                                        $paginaAtual        = (int)$_GET['PaginaMostrada'];                                                        
                                        $qtdRegistroPagina  = $iPageSize;
                                        $qtdRegistroTotal   = pg_num_rows($rsConsulta);
                                        $qtdIndice          = $paginaAtual * $qtdRegistroPagina;
                                        $qtdIndiceFinal     = (($qtdIndice + $qtdRegistroPagina)-1);
                                        $qtdPagina          = ($qtdRegistroTotal/$qtdRegistroPagina);
                                        $qtdPagina          = ceil($qtdPagina);

                                        while(($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal)) 
                                        {
                                            $linhaDiaria       = pg_fetch_assoc($rsConsulta, $qtdIndice);

                                            $Codigo            = $linhaDiaria['diaria_id'];
                                            $Numero            = $linhaDiaria['diaria_numero'];
                                            $DataPartida       = $linhaDiaria['diaria_dt_saida'];
                                            $HoraPartida       = $linhaDiaria['diaria_hr_saida'];
                                            $DataChegada       = $linhaDiaria['diaria_dt_chegada'];
                                            $HoraChegada       = $linhaDiaria['diaria_hr_chegada'];
                                            $Processo          = $linhaDiaria['diaria_processo'];
                                            $Status            = $linhaDiaria['diaria_st'];
                                            $Nome              = $linhaDiaria['pessoa_nm'];
                                            $ACP               = $linhaDiaria['diaria_unidade_custo'];
                                            $DataDaSolicitacao = $linhaDiaria['diaria_dt_criacao'];
                                            $HoraDaSolicitacao = $linhaDiaria['diaria_hr_criacao'];

                                            echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                echo "<td height='20' align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" . $Codigo . "&pagina=SolicitacaoAutorizacao'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'/></a></td>";
                                            /* Aleteração Feita no perfil por Erinaldo em 26-03-2011 para atender solicitação de Dr. Adolfo
                                             * ***Impressão da Diária e do processo antes de fazer o empenho****
                                             */
                                            $sql = "SELECT diaria_imprimir_processo FROM diaria.diaria_aprovacao WHERE diaria_id = $Codigo";
                                            $resultado = pg_query(abreConexao(), $sql);
                                            $tupla = pg_fetch_assoc($resultado);
                                            $diaria_imprimir_processo = $tupla['diaria_imprimir_processo'];

                                            if ($diaria_imprimir_processo == 1) 
                                            {
                                                echo "<td height='20' align='center'><a href='javascript:ImprimirDiaria(" . $Codigo . ");'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'/></a></td>";
                                            } 
                                            else 
                                            {
                                                echo "<td height='20' align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'/></a></td>";
                                            }
                                            if ($diaria_imprimir_processo == 1) 
                                            {
                                                echo "<td height='20' align='center'><a href='javascript:ImprimirProcesso(" . $Codigo . ");'><img src='../Icones/ico_imprimir_processo.png' border='0' alt='Imprimir Processo'/></a></td>";
                                            }
                                            else
                                            {
                                                echo "<td height='20' align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'/></a></td>";
                                            }
                                                echo "<td height='20' align='center'><a href='SolicitacaoCadastrar.php?cod=" . $Codigo . "&acao=consultar&pagina=SolicitacaoAutorizacao'><img src='../icones/ico_alterar.png' alt='Editar' border='0'/></a></td>";

                                            if ($linha['diaria_devolvida'] == 1) 
                                            {
                                                echo "<td height='20' align='center'><img src='../Icones/ico_devolver_off.png' border='0' alt='Devolver'/></a></td>";
                                                echo "<td height='20' align='center'><img src='../Icones/ico_aceitar_off.png' border='0'alt='Autorizar'/></a></td>";
                                            } 
                                            else
                                            {
                                                echo "<td height='20' align='center'><a href='SolicitacaoDevolver.php?cod=" . $Codigo . "&pagina=SolicitacaoAutorizacao'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'/></a></td>";
                                                echo "<td height='20' align='center'><a href='SolicitacaoConsultar.php?acao=consultar&funcao=autorizar&cod=" . $Codigo . "&pagina=SolicitacaoAutorizacao'><img src='../Icones/ico_aceitar.png' border='0'alt='Autorizar'/></a></td>";
                                            }

                                                echo "<td height='20' align='center'>" . $Numero . "</td>";
                                                echo "<td height='20'>" . $Nome . "</td>";
                                                echo "<td height='20' align='center'>" . f_FormataData($DataDaSolicitacao) . " &agrave;s " . $HoraDaSolicitacao . "</td>";
                                                echo "<td height='20' align='center'>" . $DataPartida . " &Agrave;s " . $HoraPartida . "</td>";
                                                echo "<td height='20' align='center'>" . $DataChegada . " &Agrave;s " . $HoraChegada . "</td>";
                                            echo "</tr>";
                                            if ($linhaDiaria['diaria_devolvida'] == 2) 
                                            {
                                                $sqlConsultaMotivoDevolucao = "SELECT diaria_devolucao_dt, diaria_devolucao_ds, m.motivo_ds, tu.tipo_usuario_ds FROM diaria.diaria_devolucao d JOIN diaria.motivo m ON d.motivo_id = m.motivo_id JOIN dados_unico.funcionario F ON F.funcionario_id = d.diaria_devolucao_func JOIN seguranca.usuario U ON U.pessoa_id = F.pessoa_id JOIN seguranca.usuario_tipo_usuario tp ON tp.pessoa_id = U.pessoa_id JOIN seguranca.tipo_usuario tu ON tu.tipo_usuario_id = tp.tipo_usuario_id WHERE diaria_id = " . $Codigo . "  AND tu.sistema_id = 2 ORDER BY diaria_devolucao_dt DESC LIMIT 1";
                                                $rsConsultaMotivoDevolucao = pg_query(abreConexao(), $sqlConsultaMotivoDevolucao);
                                                $linhaMotivo = pg_fetch_assoc($rsConsultaMotivoDevolucao);

                                                if ($linhaMotivo['diaria_devolucao_ds'] != "") 
                                                {
                                                    $labelDevolucao = $linhaMotivo['diaria_devolucao_ds'];
                                                }

                                                $MotivoDevolucao = $linhaMotivo['motivo_ds'];
                                                $labelResponsavel = $linhaMotivo['tipo_usuario_ds'];
                                                $dataDevolucao    = date("d-m-Y", strtotime($linhaMotivo['diaria_devolucao_dt']));
                                                
                                                echo "<tr class='dataField' >";
                                                    echo "<td height='20'><img src='../icones/ico_aviso.gif' alt='Alerta' border='0' title='Diária Devolvida'/></td>";
                                                    echo "<td height='20' colspan='6' align='left'><font color='##000099'>Devolvido Por:&nbsp;</font><font face='verdana' color='red'>" . $labelResponsavel . "</font></td>";
                                                    echo "<td height='20' colspan='4'><font color='#000099'>DATA:&nbsp;".$dataDevolucao."&nbsp;&nbsp;&nbsp;  MOTIVO: ". $MotivoDevolucao .": " . $labelDevolucao . "</font></td>";                                                    
                                                echo "</tr>";
                                            }

                                            if ($Roteiro == 1) 
                                            {
                                                echo "<tr class=dataLabel>";
                                                     echo "<td colspan='11' align=center><b>Roteiro</b></td>";
                                                echo "</tr>";
                                                echo "<tr class='dataLabel'>";
                                                    echo "<td colspan='8' width='50%'>Origem</td>";
                                                    echo "<td colspan='3' width='50%'>Destino</td>";
                                                echo "</tr>";
                                                $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = " . $Codigo;
                                                $rsRoteiro = pg_query(abreConexao(), $sqlRoteiro);

                                                while ($linhaRoteiro = pg_fetch_assoc($rsRoteiro)) 
                                                {
                                                    $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linhaRoteiro['roteiro_origem'];
                                                    $rsRoteiroOrigem = pg_query(abreConexao(), $sqlRoteiroOrigem);
                                                    $linhaOrigem = pg_fetch_assoc($rsRoteiroOrigem);

                                                    $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linhaRoteiro['roteiro_destino'];
                                                    $rsRoteiroDestino = pg_query(abreConexao(), $sqlRoteiroDestino);
                                                    $linhaDestino = pg_fetch_assoc($rsRoteiroDestino);

                                                    echo "<tr class='dataField'>";
                                                        echo "<td colspan='8' height='20'>" . $linhaOrigem['estado_uf'] . " - " . $linhaOrigem['municipio_ds'] . "</td>";
                                                        echo "<td colspan='3' height='20'>" . $linhaDestino['estado_uf'] . " - " . $linhaDestino['municipio_ds'] . "</td>";
                                                    echo "</tr>";
                                                }
                                            }                                                        
                                            $qtdIndice++;
                                        }
                                        $paginaAtual++;
                                        ?>
                                        <tr>
                                            <td colspan="11"><?php include "IncludeLocal/Inc_Paginacao.php"?></td>
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

