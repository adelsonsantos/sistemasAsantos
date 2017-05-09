<?php
include "Classe/ClasseDiariaFinanceiroExecucao.php";
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

                frm.action = "SolicitacaoFinanceiroExecucaoInicio.php?acao=buscar";
                frm.submit();
            }

            function TodosForm(frm)
            {
                frm.txtFiltro.value = "";
                frm.action = "SolicitacaoFinanceiroExecucaoInicio.php";
                frm.submit();
            }

            /* Função que Executa todas as Diárias*/
            function ExecutarTodasDiarias(checkboxExecutarDiaria)
            {
                CodigoDiarias ='';

                for (i=0; i < checkboxExecutarDiaria.length; i++) 
                {
                    if (checkboxExecutarDiaria[i].checked) 
                    {
                        CodigoDiarias = (checkboxExecutarDiaria[i].value)+','+CodigoDiarias ;
                    }
                }

                if (CodigoDiarias == "")
                {
                    alert("Todas as Diárias já foram Executadas. \nPara Executar alguma Empenho é Diária é Nécessário Selecionar Alguma Diária.!!!");
                    return;
                }		

                if (CodigoDiarias.length > 4)
                {
                    CodigoDiarias = CodigoDiarias.substr(0,CodigoDiarias.length-1);//retira a virgula do final							
                    //	document.write(CodigoDiarias);
                }

                var resposta = confirm('Tem certeza que deseja Executar Todas as Diárias Selecionadas ?');
                if (resposta == true)
                {
                    Form.action = "SolicitacaoFinanceiroExecucaoInicio.php?acao=ExecutarTodasDiarias&Codigos="+CodigoDiarias;		  
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

                                    <table cellpadding="1" cellspacing="1" width="800" border="0" class="GridPaginacao">
                                        <tr class="GridPaginacaoRegistroNumRegistro">
                                            <td align="left" height='20'>
                                                <input type="button" style="width:100px; height: 18px;" onClick="javascript:ExecutarTodasDiarias(document.Form.checkboxExecutarDiaria);" class="botao" value="Executar Diárias"/> 
                                                <img src='../Icones/ico_arquivar.gif' border="0" alt="Executar Diárias"/>
                                            </td> 
                                            <td align="right" height='20'>
                                                <a href="#" onClick="javascript:MarcaCheckbox(document.Form.checkboxExecutarDiaria);">Marcar Todos</a> |
                                                <a href="#" onClick="javascript:DesmarcaCheckbox(document.Form.checkboxExecutarDiaria);">Desmarcar Todos</a>
                                            </td>
                                        </tr>					
                                    </table>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="100%" class="GridPaginacao">
                                        <tr class="dataLabel">
                                            <td height="20" width="80" colspan="4"></td>
                                            <td height="20" width="70" align="center">SD</td>
                                            <td height="20" width="290" align="left">Nome</td>
                                            <td height="20" width="98" align="center">Data Solicitação</td>
                                            <td height="20" width="130" align="center">Partida Prevista</td>
                                            <td height="20" width="130" align="center">Chegada Prevista</td>
                                        </tr>
                                        <?php
                                        //include "IncludeLocal/ExecucaoFinanceiroDiariasAgrupadas.php";

                                        while($linharsConsulta = pg_fetch_assoc($rsConsulta)) 
                                        {
                                            $Codigo          = $linharsConsulta['diaria_id'];
                                            $Numero          = $linharsConsulta['diaria_numero'];
                                            $Diaria_agrupada = $linharsConsulta['diaria_agrupada'];
                                            $Diaria_Super_SD = $linharsConsulta['super_sd'];
                                            $Nome            = $linharsConsulta['pessoa_nm'];
                                            $DataPartida     = $linharsConsulta['diaria_dt_saida'];
                                            $HoraPartida     = $linharsConsulta['diaria_hr_saida'];
                                            $DataChegada     = $linharsConsulta['diaria_dt_chegada'];
                                            $HoraChegada     = $linharsConsulta['diaria_hr_chegada'];
                                            $DataCriacao     = $linharsConsulta['diaria_dt_criacao'];
                                            $Status          = $linharsConsulta['diaria_st'];

                                            $DataCriacao     = f_FormataData($DataCriacao);

                                            echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                            /* **** Executar todas as diárias de uma vez **** */
                                                echo "<td height='20' width='50' align='center' bgcolor='#8FBC8F' ><input type='checkbox' class='checkbox'name='checkboxExecutarDiaria' value= " . $Codigo . "></td>";

                                                /* ****  Fim do Executar todas as diárias de uma vez **** */
                                                echo "<td height='20' width='10' align='center'><a href='SolicitacaoConsultarFinanceiro.php?acao=consultar&cod=" . $Codigo . "'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'/></a></td>";
                                                echo "<td height='20' width='10' align='center'><a href='SolicitacaoExecutar.php?acao=consultar&cod=" . $Codigo . "'><img src='../Icones/ico_comprovar.png' border='0' alt='Executar'/></a></td>";
                                                echo "<td height='20' width='10' align='center'><a href='SolicitacaoDevolver.php?cod=" . $Codigo . "&pagina=SolicitacaoFinanceiroExecucao'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'/></a></td>";
                                                if ($Diaria_agrupada == 0)
                                                {
                                                    echo "<td height='20' align='center'>" . $Numero . "</td>";
                                                } 
                                                else
                                                {
                                                    echo "<td height='20' align='center'>" . $Diaria_Super_SD . "</td>";
                                                }
                                                echo "<td height='20'>" . $Nome . "</a></td>";
                                                echo "<td height='20' align='center'>" . $DataCriacao . "</a></td>";
                                                echo "<td height='20' align='center'>" . $DataPartida . " &agrave;s " . $HoraPartida . "</td>";
                                                echo "<td height='20' align='center'>" . $DataChegada . " &agrave;s " . $HoraChegada . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
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