<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaAgrupar.php";
?>
<html>
    <style type="text/css">@import url("../css/estilo.css"); </style>
    <script language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
    <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
    <script language="javascript"charset="utf-8">
        <!--
        function AgruparDiarias (checkbox)
        {
            var sel = 0;
            var selecionadas = "";			
			
            for (i=0; i < checkbox.length; i++) {
                if (checkbox[i].checked) {				
                    sel++;
                    selecionadas = checkbox[i].value+','+selecionadas;
                }
            }
		
            if (sel == 1){
                alert("Não é possivel realizar a operação com apenas 1 Diária!");
                return;
            }
			
            if (selecionadas == ""){
                alert("Todas as diárias já foram IMPRESSAS.\n\Para REIMPRIMIR alguma diária DESMARQUE a mesma!");
                return;
            }
			
			
            if (selecionadas.length > 4){
                selecionadas = selecionadas.substr(0,selecionadas.length-1);//retira a virgula do final			    
            }	
		 
            // document.Form.action="SolicitacaoImprimirDiariasAgrupadasPDF.php?Multiplos="+selecionadas;
            window.open ("SolicitacaoImprimirDiariasAgrupadasPDF.php?Multiplos="+selecionadas);
            //window.location = "SolicitacaoImprimirDiariasAgrupadasPDF.php";
            document.Form.submit();
        }
		
		
        function Foco(frm)
        {
            frm.txtFiltro.focus();
        }
		
        function ImprimirDiariasAgrupadas(codigo){
            window.open ("ImprimirDiariasAgrupadasEmpenhoPDF.php?cod="+codigo);
        }
		
        function ImprimirProcessoDiariasAgrupadas(codigo)
        {
            window.open ("CapaProcessoDiariasAgrupadasPDF.php?cod="+codigo);
        }
		
        function ImprimirDiaria(codigo)
        {
            window.open ("SolicitacaoImprimirPDFAgrupadas.php?acao=imprimir&cod="+codigo);
        }

        function ImprimirProcesso(codigo)
        {
            window.open ("SolicitacaoProcessoPDF.php?acao=imprimir&cod="+codigo);
        }
        
        function CarregarGride(projeto,fonte,frm){
            
            frm.action = "SolicitacaoAgruparDiariaInicio.php?p="+projeto+"&f="+fonte;
            frm.submit();
        }
        
        function ExibirFonte(){
            document.getElementById("FonteLabel").style.display="block";
            document.getElementById("Fonte").style.display="block";
            
        }
              
        -->
    </script>

    <body onLoad="WM_initializeToolbar();">

        <form name="Form" method="post">

            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><? include "../Include/Inc_Topo.php" ?></td>
                </tr>
                <tr>
                    <td><? include "../Include/Inc_Aba.php" ?></td>
                </tr>
                <tr>
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><? include "../Include/Inc_Menu.php" ?></td>
                                <td valign="top" align="left">

                                    <? include "../Include/Inc_Titulo.php" ?>

                                    <?include "../Include/Inc_Linha.php"?>

                                    <?include "../Include/Inc_Linha.php"?>

                                    <table cellpadding="0" cellspacing="0" width="800" border="0" class="TabelaFormulario">
                                        <tr height="21" class="dataLabel">
                                            <td colspan="4">
                                                Projeto:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 5px;" id="Projeto" >&nbsp;
                                                <?php echo f_ComboProjeto($codigoEscolhido,"onChange=ExibirFonte();" );
                                                ?>
                                                <br/>
                                            </td>
                                        </tr>
                                        <tr height="21" class="dataLabel" id="FonteLabel" style="display: <?php echo $display; ?>;">
                                            <td colspan="4">
                                                Fonte:
                                            </td>
                                        </tr>
                                        <tr id="Fonte" style="display: <?php echo $display; ?>;">
                                            <td style="padding-bottom: 5px;" >&nbsp;
                                                <?php echo f_ComboFonte($fonteEscolhida,"782","onChange=CarregarGride(document.getElementsByName('cmbProjeto')[0].value,this.value,document.Form)");
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                        <table cellpadding="0" cellspacing="0" width="800" border="0">
                                            <tr>
                                                <td align="right" height='20'><button style="width:100px; height: 20px;" onClick="Javascript:AgruparDiarias(document.Form.checkbox);" class="botao">Agrupar Diárias</button> <img src="../Icones/diaria_reuniao.gif" border="0" alt="Agrupar Diárias"></td>
                                            </tr>

                                        </table>

                                        <? include "../Include/Inc_Linha.php" ?>

                                        <table cellpadding="0" cellspacing="0" width="800" border="0" class="GridPaginacao">
                                            <tr>
                                                <td>
                                                    <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                        <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                                            <td width="150" colspan="4"></td>
                                                            <td width="90" align="center">SD</td>
                                                            <td width="308" align="left">&nbsp;<a href='<?= $PaginaLocal ?>Inicio.php?acao=buscar&atributo=pessoa_nm'><u>Nome</u></a></td>
                                                            <td width="150" align="center"><a href='<?= $PaginaLocal ?>Inicio.php?acao=buscar&atributo=diaria_dt_criacao'><u>Data Solicitação</u></a></td>
                                                            <td width="130" align="center">Partida Prevista</td>  
                                                            <td width="10" >Agrupada</td>														
                                                            <td width="10" >Impressa</td>														
                                                        </tr>
                                                    <?
                                                    if ($rsConsulta != '') {
                                                        while ($linharsConsulta = pg_fetch_assoc($rsConsulta)) {
                                                            $Codigo = $linharsConsulta['diaria_id'];
                                                            $ACP = $linharsConsulta['diaria_unidade_custo'];
                                                            $Numero = $linharsConsulta['diaria_numero'];
                                                            $Nome = $linharsConsulta['pessoa_nm'];
                                                            $DataPartida = $linharsConsulta['diaria_dt_saida'];
                                                            $HoraPartida = $linharsConsulta['diaria_hr_saida'];
                                                            $DataChegada = $linharsConsulta['diaria_dt_chegada'];
                                                            $DataDaSolicitacao = $linharsConsulta['diaria_dt_criacao'];
                                                            $HoraDaSolicitacao = $linharsConsulta['diaria_hr_criacao'];
                                                            $HoraChegada = $linharsConsulta['diaria_hr_chegada'];
                                                            $Status = $linharsConsulta['diaria_st'];
                                                            $Beneficiario = $linharsConsulta['diaria_beneficiario'];
                                                            $Processo = $linharsConsulta['diaria_processo'];
                                                            $diaria_agrupada = $linharsConsulta['diaria_agrupada'];
                                                            $Diaria_Super_SD = $linharsConsulta['super_sd'];
                                                            $diaria_indvidual = $linharsConsulta['diaria_indvidual'];

                                                            $sqlACP = "SELECT * FROM diaria.autorizador_acp WHERE pessoa_id = " . $_SESSION['UsuarioCodigo'] . " AND est_organizacional_id = " . $ACP;
                                                            $rsACP = pg_query(abreConexao(), $sqlACP);
                                                            $linhaACP = pg_fetch_assoc($rsACP);

                                                            if ($linhaACP) {
                                                                if ($diaria_agrupada == 1 || $diaria_indvidual == 1) {
                                                                    if ($diaria_agrupada == 1) {
                                                                        echo "<tr height='20' bgcolor='#F5DEB3' class='GridPaginacaoLink'>";

                                                                        echo "<td width='10' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= " . $Codigo . " DISABLED></td>";
                                                                        echo "<td align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" . $Codigo . "&pagina=SolicitacaoAgruparDiaria'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";
                                                                        echo "<td align='center'><a href='javascript:ImprimirDiariasAgrupadas(" . $Diaria_Super_SD . ");'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>";
                                                                        echo "<td align='center'><a href='javascript:ImprimirProcessoDiariasAgrupadas(" . $Diaria_Super_SD . ");'><img src='../Icones/ico_imprimir_processo.png' border='0' alt='Imprimir Processo'></a></td>";

                                                                        echo "<td align='center'>" . $Numero . "</td>";
                                                                        echo "<td>&nbsp;" . $Nome . "</a></td>";
                                                                        echo "<td align='center'>" . f_FormataData($DataDaSolicitacao) . " &agrave;s " . $HoraDaSolicitacao . "</td>";
                                                                        echo "<td align='center'>" . $DataPartida . " &agrave;s " . $HoraPartida . "</td>";
                                                                    } else {
                                                                        echo "<tr height='20' bgcolor='#A52A2A' class='GridPaginacaoLink'>";
                                                                        echo "<td width='10' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= " . $Codigo . " DISABLED></td>";
                                                                        echo "<td align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" . $Codigo . "&pagina=SolicitacaoAgruparDiaria'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";
                                                                        echo "<td align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>";
                                                                        echo "<td align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'></a></td>";

                                                                        echo "<td align='center'>" . $Numero . "</td>";
                                                                        echo "<td>&nbsp;" . $Nome . "</a></td>";
                                                                        echo "<td align='center'>" . f_FormataData($DataDaSolicitacao) . " &agrave;s " . $HoraDaSolicitacao . "</td>";
                                                                        echo "<td align='center'>" . $DataPartida . " &agrave;s " . $HoraPartida . "</td>";
                                                                    }
                                                                } else {
                                                                    echo "<tr height='20' bgcolor='#f2f2f2' class='GridPaginacaoLink'>";
                                                                    echo "<td width='10' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= " . $Codigo . "></td>";
                                                                    echo "<td align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" . $Codigo . "&pagina=SolicitacaoAgruparDiaria'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";
                                                                    echo "<td align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>";
                                                                    echo "<td align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'></a></td>";

                                                                    echo "<td align='center'>" . $Numero . "</td>";
                                                                    echo "<td>&nbsp;" . $Nome . "</a></td>";
                                                                    echo "<td align='center'>" . f_FormataData($DataDaSolicitacao) . " &agrave;s " . $HoraDaSolicitacao . "</td>";
                                                                    echo "<td align='center'>" . $DataPartida . " &agrave;s " . $HoraPartida . "</td>";
                                                                }
                                                                if ($diaria_agrupada == 1) {
                                                                    echo "<td align='center'>SIM</td>";
                                                                } else {
                                                                    echo "<td align='center'>NÃO</td>";
                                                                }

                                                                $sqlConsulta = "SELECT imp_processo_st FROM diaria.diaria_aprovacao WHERE diaria_id  = $Codigo";
                                                                $rs = pg_query(abreConexao(), $sqlConsulta);
                                                                $linha = pg_fetch_assoc($rs);
                                                                $diaria_agrupa_imp = $linha['imp_processo_st'];

                                                                if ($diaria_agrupa_imp == 1 && $diaria_agrupada == 1) {
                                                                    //echo "<td align='center'>SIM</td>";
                                                                    echo "<td width='10' align='center'><INPUT TYPE=\"checkbox\" name=\"opcao\" DISABLED checked ></td>";
                                                                } else {
                                                                    //echo "<td align='center'>NÃO</td>";														
                                                                    echo "<td  width='10' align='center'><INPUT TYPE=\"checkbox\" name=\"opcao\" DISABLED  ></td>";
                                                                }
                                                                echo "</tr>";
                                                            } //if linhaACP
                                                        } // while
                                                    } //if rsConsulta
                                                    else{
                                                        echo"<tr height='20'class='GridPaginacaoLink' bgcolor='#f2f2f2'><td colspan='10' align='center'>Selecione o Projeto e a Fonte para listar as Di&aacute;rias.</td></tr>";
                                                    }
                                                    ?>
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