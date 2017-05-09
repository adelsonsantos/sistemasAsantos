<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaFinanceiro.php";
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
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptAjax.js"></script>
        <script type="text/javascript" language="javascript">

            function CancelarDiaria(frm)
            {
                frm.action = "SolicitacaoCancelar.php";
                frm.submit();
            }

            function ImprimirDiaria(frm)
            {
                window.open ("SolicitacaoImprimir.php?acao=imprimir&cod=<?=$codigo?>");
            }
             
        </script>
    </head>

    <body onLoad="WM_initializeToolbar();">
        <form name="Form" method="post" action="">
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
                                    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21" width="126" align="center">N&uacute;mero SD</td>
                                            <td height="21" width="128" align="center">Solicitada em</td>
                                            <td height="21" width="128" align="center">Nº Empenho</td>
                                            <td height="21" width="128" align="center">Data Empenho</td>
                                            <td height="21" width="160" align="center">Processo</td>
                                            <td height="21" width="128" align="center">Status</td>
                                        </tr>
                                        <tr class="dataField">
                                            <?php
                                            if($Diaria_agrupada == 0)
                                            {
                                                echo "<td height='21' align=\"center\">$Numero</td>";
                                            }
                                            else
                                            {
                                                echo "<td height='21' align=\"center\">$Diaria_Super_SD</td>";
                                            }											
                                            ?>                                                        
                                            <td height="21"><?=DBToData($DataCriacao)." " .$HoraCriacao?></td>
                                            <td height="21" align="center"><?=$Empenho?></td>
                                            <td height="21" align="center"><?=$DataEmpenho?></td>
                                            <td height="21" align="center"><?=$Processo?></td>
                                            <?php include "IncludeLocal/Inc_StatusDiaria.php";?>
                                            <td height="21" align="center"><font color="#ff0000"><?=$StatusNome?></font></td>
                                        </tr>
                                    </table>
                                    <?php
                                    If ($Status == 4)
                                    {                                        
                                    ?>
                                        <br />
                                        <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                            <tr class="dataLabel">
                                                <td height="21"  width="100" align="center">Data Obriga&ccedil;&atilde;o</td>
                                                <td height="21"  width="100" align="center">Hora Obriga&ccedil;&atilde;o</td>
                                                <td height="21"  width="338" align="left">Pr&eacute;-Liquidante</td>
                                                <td height="21"  width="130" align="center">Data Pr&eacute;-Liquida&ccedil;&atilde;o</td>
                                                <td height="21"  width="130" align="center">Hora Pr&eacute;-Liquida&ccedil;&atilde;o</td>
                                            </tr>
                                            <tr class="dataField">
                                                <?php $linharsFinanceiro=pg_fetch_assoc($rsFinanceiro);?>
                                                <td height="21" align="center"><?=$linharsFinanceiro['diaria_financeiro_dt_obrigacao']?></td>
                                                <td height="21" align="center"><?=$linharsFinanceiro['diaria_financeiro_hr_obrigacao']?></td>
                                                <?php $linharsPessoa=pg_fetch_assoc($rsPessoa);?>
                                                <td height="21"><?=$linharsPessoa['pessoa_nm']?></td>
                                                <td height="21" align="center"><?=$linharsFinanceiro['diaria_preliquidacao_dt']?></td>
                                                <td height="21" align="center"><?=$linharsFinanceiro['diaria_preliquidacao_hr']?></td>
                                            </tr>
                                        </table>
                                    <?php
                                    }
                                    ?>
                                        <br/>
                                    <?php
                                    If ((($Status == 9) ||($Status == 3)) &&  ($Status == 5))
                                    {
                                        $sqlConsultaComplemento = "SELECT diaria_comprovacao_complemento, diaria_comprovacao_complemento_justificativa FROM diaria.diaria_comprovacao WHERE diaria_id = " .$codigo;
                                        $rsConsultaComplemento  = pg_query(abreConexao(),$sqlConsultaComplemento);

                                        /*Alterado por Rodolfo Para correção do Sistema . erro
                                         *************************************************** */

                                        $linharsConsultaComplemento = pg_fetch_assoc($rsConsultaComplemento);

                                        If ($linharsConsultaComplemento)
                                        {
                                            $Complemento = $linharsConsultaComplemento['diaria_comprovacao_complemento'];
                                        }
                                        else
                                        {
                                            $Complemento = 0;
                                        }
                                        //***********************************************************

                                    }
                                    If ($Complemento == "1")
                                    {
                                        $ComplementoJustificativa = $linharsConsultaComplemento['diaria_comprovacao_complemento_justificativa'];
                                    }
                                    If ($Complemento == "1")
                                    {
                                    ?>
                                        <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                            <tr class="dataLabel">
                                                <td height="21">Justificativa do Complemento (Conforme Art. 4º par&aacute;grafo 2º do DECRETO Nº 5.910 de Outubro de 1996.)</td>
                                            </tr>
                                            <tr class="dataField">
                                                <td height="21"><?=$ComplementoJustificativa?></td>
                                            </tr>
                                        </table>                                        
                                    <?php                                         
                                    }
                                    ?>
                                    <br />
                                    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21" width="400">Benefici&aacute;rio</td>
                                            <td height="21" width="200">Matr&iacute;cula</td>
                                            <td height="21" width="198">CPF</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21" ><?=f_ConsultaNomeFuncionario($Beneficiario)?></td>
                                            <td height="21" ><?=$Matricula?> </td>
                                            <td height="21" ><?=$CPF?> </td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="21" width="400">Banco</td>
                                            <td height="21" width="200">Ag&ecirc;ncia</td>
                                            <td height="21" width="198">Conta</td>
                                        </tr>
                                        <tr class="dataField">
                                            <?php $linharsBanco=pg_fetch_assoc($rsBanco);?>
                                            <td height="21" ><?=$linharsBanco['banco_cd']?> - <?=$linharsBanco['banco_ds']?></td>
                                            <td height="21" ><?=$linharsBanco['dados_bancarios_agencia']?> </td>
                                            <td height="21" ><?=$linharsBanco['dados_bancarios_conta']?></td>
                                        </tr>
                                    </table>                                                                            
                                    <br />
                                    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21" width="312">Valor Refer&ecirc;ncia</td>
                                            <td height="21" width="85">Redu&ccedil;&atilde;o 50%</td>
                                            <td height="21" width="102">Qtde Di&aacute;rais</td>
                                            <td height="21" width="98">Valor Total</td>
                                            <td height="21">&nbsp;</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21" width="312"><?= 'R$ '.number_format($linhaDiaria['diaria_valor_ref'], 2, ',', '.');?></td>
                                            <td height="21" width="85"><?= $Desconto?></td>
                                            <td height="21"><?=$Qtde?></td>
                                            <td height="21"><?= 'R$ '.number_format($linhaDiaria['diaria_valor'], 2, ',', '.');?></td>
                                            <td height="21">&nbsp;</td>
                                        </tr>
                                    </table>
                                    <br />
                                    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21">Unidade de Custo</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td height="21"><?=f_ExibeUnidadeCusto($UnidadeCusto)?></td>
                                        </tr>
                                    </table>
                                    <br />
                                    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataTitulo">
                                            <td height="21" colspan="2">Roteiro</td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="21">Origem</td>
                                            <td height="21">Destino</td>
                                        </tr>
                                        <?php
                                        $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$codigo;
                                        $rsRoteiro  = pg_query(abreConexao(),$sqlRoteiro);

                                        while($linharsRoteiro=pg_fetch_assoc($rsRoteiro))
                                        {
                                            $sqlRoteiroOrigem     = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " .$linharsRoteiro['roteiro_origem'];
                                            $rsRoteiroOrigem      = pg_query(abreConexao(),$sqlRoteiroOrigem);
                                            $linharsRoteiroOrigem = pg_fetch_assoc($rsRoteiroOrigem);

                                            $sqlRoteiroDestino     = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " .$linharsRoteiro['roteiro_destino'];
                                            $rsRoteiroDestino      = pg_query(abreConexao(),$sqlRoteiroDestino);
                                            $linharsRoteiroDestino = pg_fetch_assoc($rsRoteiroDestino);

                                            echo "<tr class='dataField'>";
                                                echo "<td height='21'>" .$linharsRoteiroOrigem['estado_uf']." - " .$linharsRoteiroOrigem['municipio_ds']."</td>";
                                                echo "<td height='21'>" .$linharsRoteiroDestino['estado_uf']. " - " .$linharsRoteiroDestino['municipio_ds']. "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </table>
                                    <br />
                                    <?php include "IncludeLocal/Inc_HistoricoDiaria.php"; ?>
                                    <input name="txtCodigo" type="hidden" value="<?=$codigo?>"/>
                                    <?php 
                                    include "../Include/Inc_Linha.php";
                                    If ($MensagemErroBD != "")
                                    {
                                        echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
                                            echo "<tr>";
                                                echo "<td class='MensagemErro'>".$MensagemErroBD."</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                                echo "<td><img src='../images/vazio.gif' width='1' height='10' border='0'/></td>";
                                            echo "</tr>";
                                        echo "</table>";
                                    }
                                    ?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="100%">
                                        <tr>
                                            <td height="25" align="right">
                                                <input type="button" style="width:70px" onClick="Javascript:window.location.href='SolicitacaoFinanceiroExecucaoInicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
                                            </td>
                                       </tr>
                                    </table>
                                    <br />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>