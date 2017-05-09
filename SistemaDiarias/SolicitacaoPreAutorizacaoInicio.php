<?php
include "Classe/ClassePreAutorizacao.php";
?>
<html>
    <head>
        <meta name="Description" content="ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia" />
        <meta name="Keywords" content="ADAB, Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia, Defesa Agropecu&aacute;ria, Agropecu&aacute;ria Bahia" />
        <meta name="language" content="pt-br" />
        <meta name="distribution" content="Global" />
        <meta name="rating" content="General" />
        <meta name="DC.title" content="ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia" />
        <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE8'/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>ADAB - Ag&ecirc;ncia de Defesa Agropecu&aacute;ria da Bahia</title> 
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" charset="utf-8" src="SolicitacaoPreAutorizacaoInicio.php">            
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

                frm.action = "SolicitacaoPreAutorizacaoInicio.php?acao=buscar";
                frm.submit();
            }

            function TodosForm(frm)
            {
                frm.txtFiltro.value = "";
                frm.action = "SolicitacaoPreAutorizacaoInicio.php";
                frm.submit();
            }

            function Autorizar(codigo)
            {
                var resposta = confirm('Tem certeza que deseja pré autorizar a diária?');

                if (resposta == true)
                {
                    document.Form.action="SolicitacaoPreAutorizacaoInicio.php?cod="+codigo+"&acao=autorizar";
                    document.Form.submit();
                }
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
                                        <?php if ($Roteiro == 0) 
                                              { ?>
                                                <td align="right"><a href="SolicitacaoPreAutorizacaoInicio.php?roteiro=1"><font color="#000099">Visualizar com roteiro</font></a></td>
                                        <?php } 
                                              else 
                                              { ?>
                                                <td align="right"><a href="SolicitacaoPreAutorizacaoInicio.php?roteiro=0"><font color="#000099">Visualizar sem roteiro</font></a></td>
                                        <?php } ?>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table border="0" cellpadding="0" cellspacing="1" width="798" class="GridPaginacao">
                                        <tr class="dataLabel">
                                            <td height="20" width="120" colspan="4">&nbsp;</td>
                                            <td height="20" width="100" align="center">SD</td>
                                            <td height="20" width="318" align="left">&nbsp;Nome</td>
                                            <td height="20" width="130" align="center">Partida Prevista</td>
                                            <td height="20" width="130" align="center">Chegada Prevista</td>
                                        </tr>
                                        <?php   
                                        //DADOS PARA A PAGINAÇÃO
                                        $paginaAtual        = (int)$_GET['PaginaMostrada'];                                                        
                                        $qtdRegistroPagina  = $iPageSize;
                                        $qtdRegistroTotal   = pg_num_rows($consultaPreAutorizacao);
                                        $qtdIndice          = $paginaAtual * $qtdRegistroPagina;
                                        $qtdIndiceFinal     = (($qtdIndice + $qtdRegistroPagina)-1);
                                        $qtdPagina          = ($qtdRegistroTotal/$qtdRegistroPagina);
                                        $qtdPagina          = ceil($qtdPagina);
                                        
                                        while(($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal))
                                        {
                                            $linhaPreAutorizacao = pg_fetch_assoc($consultaPreAutorizacao,$qtdIndice);
                                            
                                            $Codigo         = $linhaPreAutorizacao['diaria_id'];
                                            $Numero         = $linhaPreAutorizacao['diaria_numero'];
                                            $DataPartida    = $linhaPreAutorizacao['diaria_dt_saida'];
                                            $HoraPartida    = $linhaPreAutorizacao['diaria_hr_saida'];
                                            $DataChegada    = $linhaPreAutorizacao['diaria_dt_chegada'];
                                            $HoraChegada    = $linhaPreAutorizacao['diaria_hr_chegada'];
                                            $Processo       = $linhaPreAutorizacao['diaria_processo'];
                                            $Status         = $linhaPreAutorizacao['diaria_st'];
                                            $Nome           = $linhaPreAutorizacao['pessoa_nm'];
                                            $ACP            = $linhaPreAutorizacao['diaria_unidade_custo'];
                                            
                                            echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                echo "<td height='20' align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" . $Codigo . "&pagina=SolicitacaoPreAutorizacao'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'/></a></td>";                                                        
                                                echo "<td height='20' align='center'><a href='SolicitacaoCadastrar.php?cod=" . $Codigo . "&acao=consultar&pagina=SolicitacaoPreAutorizacao'><img src='../icones/ico_alterar.png' alt='Editar' border='0'/></a></td>";
                                            if ($linhaPreAutorizacao['diaria_devolvida'] == 1) 
                                            {
                                                echo "<td height='20' align='center'><img src='../Icones/ico_devolver_off.png' border='0' alt='Devolver'/></a></td>";
                                                echo "<td height='20' align='center'><img src='../Icones/ico_aceitar_off.png' border='0'alt='Autorizar'/></a></td>";
                                            }
                                            else
                                            { // Alteração de código feita por Erinaldo em 21/02/2011
                                                echo "<td height='20' align='center'><a href='SolicitacaoDevolver.php?cod=" . $Codigo . "&pagina=SolicitacaoPreAutorizacao'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'/></a></td>";
                                                //	echo "<td align='center'><a href='SolicitacaoConsultar.php?acao=consultar&funcao=autorizar&cod=".$Codigo."&pagina=SolicitacaoPreAutorizacao'><img src='../Icones/ico_aceitar.png' border='0'alt='Autorizar'></a></td>";
                                                echo "<td height='20' align='center'><a href='SolicitacaoConsultar.php?acao=consultar&funcao=preautorizar&cod=" . $Codigo . "&pagina=SolicitacaoPreAutorizacao'><img src='../Icones/ico_aceitar.png' border='0'alt='Pré-Autorizar'/></a></td>";
                                            } // Fim da Alteração Feita por Erinaldo

                                                echo "<td height='20' align='center'>" . $Numero . "</td>";
                                                echo "<td height='20'>&nbsp;" . $Nome . "</td>";
                                                echo "<td height='20' align='center'>" . $DataPartida . " &Agrave;s " . $HoraPartida . "</td>";
                                                echo "<td height='20' align='center'>" . $DataChegada . " &Agrave;s " . $HoraChegada . "</td>";
                                            echo "</tr>";
                                            
                                            if ($linhaPreAutorizacao['diaria_devolvida'] == 2) 
                                            {                                                    
                                                $sqlConsultaMotivoDevolucao = "SELECT diaria_devolucao_dt, diaria_devolucao_ds, m.motivo_ds, tu.tipo_usuario_ds FROM diaria.diaria_devolucao d JOIN diaria.motivo m ON d.motivo_id = m.motivo_id JOIN dados_unico.funcionario F ON F.funcionario_id = d.diaria_devolucao_func JOIN seguranca.usuario U ON U.pessoa_id = F.pessoa_id JOIN seguranca.usuario_tipo_usuario tp ON tp.pessoa_id = U.pessoa_id JOIN seguranca.tipo_usuario tu ON tu.tipo_usuario_id = tp.tipo_usuario_id WHERE diaria_id = " . $Codigo . "  AND tu.sistema_id = 2 ORDER BY diaria_devolucao_dt DESC LIMIT 1";
                                                $rsConsultaMotivoDevolucao = pg_query(abreConexao(), $sqlConsultaMotivoDevolucao);
                                                $linhaMotivo = pg_fetch_assoc($rsConsultaMotivoDevolucao);

                                                if ($linhaMotivo['diaria_devolucao_ds'] != "") 
                                                {
                                                    $labelDevolucao = $linhaMotivo['diaria_devolucao_ds'];
                                                }

                                                $MotivoDevolucao  = $linhaMotivo['motivo_ds'];
                                                $labelResponsavel = $linhaMotivo['tipo_usuario_ds'];
                                                $dataDevolucao    = date("d-m-Y", strtotime($linhaMotivo['diaria_devolucao_dt']));

                                                echo "<tr class='dataField' >";
                                                    echo "<td height='20'><img src='../icones/ico_aviso.gif' alt='Alerta' border='0' title='Diária Devolvida'/></td>";
                                                    echo "<td height='20' colspan='4' align='left'><font color='##000099'>Devolvido Por:&nbsp;</font><font face='verdana' color='red'>" . $labelResponsavel . "</font></td>";
                                                    echo "<td height='20' colspan='3'><font color='#000099'>DATA:&nbsp;".$dataDevolucao."&nbsp;&nbsp;&nbsp;  MOTIVO: ". $MotivoDevolucao .": " . $labelDevolucao . "</font></td>";                                                    
                                                echo "</tr>";
                                            }

                                            if ($Roteiro == 1) 
                                            {
                                                echo "<tr class='dataLabel'>";
                                                    echo "<td height='20' colspan=8 align=center><b>Roteiro</b></td>";
                                                echo "</tr>";
                                                echo "<tr class='dataField'>";
                                                    echo "<td colspan=8>";
                                                        echo "<table width='100%' border=0 cellpadding=0>";
                                                            echo "<tr class=dataLabel>";
                                                                echo "<td height='20' width='50%'>&nbsp;Origem</td>";
                                                                echo "<td height='20' width='50%'>&nbsp;Destino</td>";
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
                                                                echo "<td height='20'>&nbsp;" . $linhaOrigem['estado_uf'] . " - " . $linhaOrigem['municipio_ds'] . "</td>";
                                                                echo "<td height='20'>&nbsp;" . $linhaDestino['estado_uf'] . " - " . $linhaDestino['municipio_ds'] . "</td>";
                                                            echo "</tr>";
                                                        }
                                                        echo "</table>
                                                        </td>
                                                    </tr>";
                                            } 
                                            $qtdIndice++;
                                        }
                                        $paginaAtual++;
                                        ?>
                                        <td colspan=8><?php include "IncludeLocal/Inc_Paginacao.php"?></td>
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

