<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaConsultaGlobal.php";
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

                frm.action = "SolicitacaoConsultaGlobalInicio.php?acao=buscar";
                frm.submit();
            }

            function ImprimirDiaria(codigo)
            {
                window.open ("SolicitacaoImprimirPDF.php?acao=imprimir&cod="+codigo);
            }

            function TodosForm(frm)
            {
                frm.txtFiltro.value = "";
                frm.action = "SolicitacaoConsultaGlobalInicio.php";
                frm.submit();
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
                                    <?php include "../Include/Inc_Pesquisa_Sem_Filtro.php"?>
                                    <?php include "../Include/Inc_Pesquisa_Status.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="100%" class="GridPaginacao">
                                        <tr class="dataLabel">
                                            <td width="30" align="center" >A&ccedil;&otilde;es</td>
                                            <?php 
                                                if (($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Gestor Diarias") or ($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Administador" ))
                                                {
                                                    echo "<td height='20' width='25' align='center'>SD</td>";
                                                    echo "<td height='20' width='25' align='center'>PR</td>";
                                                    echo "<td height='20' width='25' align='center'></td>";
                                                }
                                            ?>
                                            <td height="20" width="80" align="center">SD</td>
                                            <td height="20" width="303" align="left">Funcion&aacute;rio</td>
                                            <td height="20" width="95" align="center">Partida</td>
                                            <td height="20" width="95" align="center">Chegada</td>
                                            <td height="20" width="100" align="center">Processo</td>
                                            <td height="20" width="100" align="center">Status</td>
                                        </tr>
                                        <?php
                                            while($linhaConsulta = pg_fetch_assoc($rsConsulta))
                                            {
                                                $Codigo             = $linhaConsulta['diaria_id'];
                                                $Numero             = $linhaConsulta['diaria_numero'];
                                                $DataPartida        = $linhaConsulta['diaria_dt_saida'];
                                                $HoraPartida        = $linhaConsulta['diaria_hr_saida'];
                                                $DataChegada        = $linhaConsulta['diaria_dt_chegada'];
                                                $HoraChegada        = $linhaConsulta['diaria_hr_chegada'];
                                                $Processo           = $linhaConsulta['diaria_processo'];
                                                $Status             = $linhaConsulta['diaria_st'];
                                                $Nome               = $linhaConsulta['pessoa_nm'];
                                                $Beneficiario       = $linhaConsulta['diaria_beneficiario'];
                                                $diaria_comprovada  = $linhaConsulta['diaria_comprovada'];
                                                $diaria_devolvida   = $linhaConsulta['diaria_devolvida'];
                                                $diaria_excluida    = $linhaConsulta['diaria_excluida'];

                                                include "IncludeLocal/Inc_Status_Diaria_ConsultaGlobal.php";

                                                echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                /*
                                                '*****************************************************************************
                                                ' Alterado por Rodolfo em 15/09/2008
                                                ' Solicitação da DA - Comprovação
                                                '*****************************************************************************
                                                 */
                                                    if($linhaConsulta['diaria_st'] <= 2)
                                                    { 	
                                                        echo "
                                                            <td width='10px;' align='center'>
                                                                    <a href=SolicitacaoConsultar.php?cod=" .$Codigo."&acao=consultar&pagina=SolicitacaoConsultaGlobal>
                                                                        <img src='../icones/ico_consultar.png' alt='Consultar' border='0'/>
                                                                    </a>
                                                              </td>";
                                                            //echo "<td align='left'><a href='javascript:ImprimirDiaria(" .$Codigo.");'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Comprova&ccedil;&atilde;o'></a></td>";
                                                    }
                                                    else 
                                                    {
                                                        if($linhaConsulta['diaria_comprovada'] == "1")
                                                        {
                                                            echo "<td width='20' align='center'><a href=ComprovacaoConsultar.php?cod=" .$Codigo. "&acao=consultar><img src='../icones/ico_consultar.png' alt='Consultar' border='0'/></a></td>";
                                                            //echo "<td width='20' align='center'><a href='javascript:ImprimirDiaria(" .$Codigo.");'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Comprova&ccedil;&atilde;o'></a></td>";
                                                            //echo "<td width='2' align='left'><a href='javascript:ImprimirDiaria(" .$Codigo.");'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Comprova&ccedil;&atilde;o'></a></td>";
                                                            //echo "<td width='10' align='center'><a href=SolicitacaoConsultar.php?cod=" .$Codigo."&acao=consultar&pagina=SolicitacaoConsultaGlobal><img src='../icones/ico_consultar.png' alt='Consultar' border='0'></a></td>";
                                                        }
                                                        else
                                                        {
                                                            echo "<td width='20' align='center'><a href=SolicitacaoConsultar.php?cod=" .$Codigo."&acao=consultar&pagina=SolicitacaoConsultaGlobal><img src='../icones/ico_consultar.png' alt='Consultar' border='0'/></a></td>";
                                                        }
                                                    }
                                                    /*
                                                    '*****************************************************************************
                                                    ' Alterado por Rodolfo em 16/09/2008
                                                    ' Solicitação da DA - Paulo - Imprimir a Solicitação.
                                                    '*****************************************************************************
                                                     */
                                                    if (($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Gestor Diarias") or ($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Administador" ))
                                                    {
                                                        if (($linhaConsulta['diaria_st'] >= 2) && ($linhaConsulta['diaria_st'] <= 3))
                                                        {
                                                            echo "<td align='center'><a href='javascript:ImprimirDiaria(".$Codigo. ");'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'/></a></td>";
                                                            echo "<td align='center'><a href='javascript:ImprimirProcesso(" .$Codigo.");'><img src='../Icones/ico_imprimir_processo.png' border='0' alt='Imprimir Processo'/></a></td>";
                                                        }
                                                        else
                                                        {
                                                            echo "<td align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'/></a></td>";
                                                            echo "<td align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'/></a></td>";
                                                        }
                                                    }	

                                                    if (($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Gestor Diarias") or ($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Administador" ))	
                                                    {
                                                        if (($linhaConsulta['diaria_comprovada'] == "1") && (($linhaConsulta['diaria_st'] >= 3) && ($linhaConsulta['diaria_st'] <= 6)))
                                                        {
                                                            echo "<td align='center'><a href='ComprovacaoDevolver.php?cod=".$Codigo."&pagina=SolicitacaoConsultaGlobal'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver Comprova&ccedil;&atilde;o'/></a></td>";
                                                        }
                                                        else
                                                        {
                                                            echo "<td align='center'><img src='../Icones/ico_devolver_offG.png' border='0' alt='Devolver Comprova&ccedil;&atilde;o'/></a></td>";
                                                        }
                                                    }

                                                    if($linhaConsulta['diaria_st'] == "10"){
                                                        if($linhaConsulta['diaria_excluida'] == "0"){
                                                            $StatusNome = "Comprovação Aprovação SEI";
                                                        }else{
                                                            $StatusNome = "Excluída";
                                                        }
                                                    }
                                                    if($linhaConsulta['diaria_st'] == "100"){
                                                        if($linhaConsulta['diaria_excluida'] == "0"){
                                                            $StatusNome = "Pré Autorização";
                                                        }else{
                                                            $StatusNome = "Excluída";
                                                        }
                                                    }

                                                    echo "<td align='center'>".$Numero."</td>";
                                                    echo "<td align='left'>".substr($Nome,0,30)."</td>";
                                                    echo "<td align='center'>".$DataPartida." ".$HoraPartida."</td>";
                                                    echo "<td align='center'>".$DataChegada." " .$HoraChegada. "</td>";
                                                    echo "<td align='center'>".$Processo."</td>";
                                                    echo "<td align='center'><font color='#000099'>".$StatusNome."</font></td>";
                                                echo "</tr>";

                                                if(($linhaConsulta['diaria_devolvida']== 1)||($linhaConsulta['diaria_devolvida']== 2))
                                                {
                                                    $sqlConsultaMotivoDevolucao     = "SELECT diaria_devolucao_dt, diaria_devolucao_ds, m.motivo_ds, tu.tipo_usuario_ds FROM diaria.diaria_devolucao d JOIN diaria.motivo m ON d.motivo_id = m.motivo_id JOIN dados_unico.funcionario F ON F.funcionario_id = d.diaria_devolucao_func JOIN seguranca.usuario U ON U.pessoa_id = F.pessoa_id JOIN seguranca.usuario_tipo_usuario tp ON tp.pessoa_id = U.pessoa_id JOIN seguranca.tipo_usuario tu ON tu.tipo_usuario_id = tp.tipo_usuario_id WHERE diaria_id = " . $Codigo . "  AND tu.sistema_id = 2 ORDER BY diaria_devolucao_dt DESC LIMIT 1";
                                                    $rsConsultaMotivoDevolucao      = pg_query(abreConexao(),$sqlConsultaMotivoDevolucao);
                                                    $linharsConsultaMotivoDevolucao = pg_fetch_assoc($rsConsultaMotivoDevolucao);
                                                    $labelDevolucao                 = "";
                                                    $MotivoDevolucao                = "";

                                                    if ($linharsConsultaMotivoDevolucao)
                                                    {
                                                        if ($linharsConsultaMotivoDevolucao['diaria_devolucao_ds'] != "")
                                                        {
                                                            $labelDevolucao = $linharsConsultaMotivoDevolucao['diaria_devolucao_ds'];
                                                        }
                                                        $MotivoDevolucao = $linharsConsultaMotivoDevolucao['motivo_ds'];
                                                    }
                                                    
                                                    $labelResponsavel = $linharsConsultaMotivoDevolucao['tipo_usuario_ds'];
                                                    $dataDevolucao    = date("d-m-Y", strtotime($linharsConsultaMotivoDevolucao['diaria_devolucao_dt']));                                                   

                                                    if(($MotivoDevolucao != "") or ($labelDevolucao != ""))
                                                    {
                                                        echo "<tr class='dataField' >";
                                                            echo "<td height='20'><img src='../icones/ico_aviso.gif' alt='Alerta' border='0' title='Diária Devolvida'/></td>";                                                            
                                                            echo "<td height='20' colspan='6'><font color='##000099'>Devolvido Por:&nbsp;</font><font face='verdana' color='red'>" . $labelResponsavel . "</font>&nbsp;&nbsp;&nbsp;&nbsp;<font color='#000099'>DATA:&nbsp;".$dataDevolucao."&nbsp;&nbsp;&nbsp;  MOTIVO: ". $MotivoDevolucao .": " . $labelDevolucao . "</font></td>";                                                    
                                                        echo "</tr>";
                                                    }
                                                }
                                            }
                                        ?>
                                       <!-- <tr>
                                            <td>&nbsp;<?php //include "../Include/Inc_Paginacao.php"?></td>
                                        </tr> -->
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
