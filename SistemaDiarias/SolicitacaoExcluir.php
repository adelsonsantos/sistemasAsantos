<?php
include "Classe/ClasseDiaria.php";
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
        <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE8'></meta>
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script language="javascript">
            function ExcluirForm(frm)
            {
                frm.action="SolicitacaoInicio.php?acao=excluir";
                frm.submit();
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
                    <td>
                        <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php" ?></td>
                                <td valign="top" align="left">
                                    <?php // inicio titulo da pagina ?>
                                    <div id="titulopagina">
                                        <?php include "../Include/Inc_Titulo.php" ?>
                                    </div>
                                    <?php // fim do titulo da pagina ?>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <?php include "../Include/Inc_TituloExcluir.php" ?>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
                                        <tr>
                                            <td>
                                                <table width="798" border="0" cellpadding="0" cellspacing="1">
                                                    <tr height="20" class="GridPaginacaoRegistroCabecalho">
                                                        <td width="100" align="center">SD</td>
                                                        <td width="328" align="left">Benefici&aacute;rio</td>
                                                        <td width="100" align="center">Partida</td>
                                                        <td width="100" align="center">Chegada</td>
                                                        <td width="170 "align="center">Processo</td>
                                                    </tr>
                                                    <?php 
                                                    $codigo = $_GET['cod'];
                                                    
                                                    $sqlConsulta = "SELECT diaria_id,
                                                                           diaria_numero,
                                                                           diaria_dt_saida,
                                                                           diaria_hr_saida,
                                                                           diaria_dt_chegada,
                                                                           diaria_hr_chegada,
                                                                           diaria_processo,
                                                                           diaria_st,
                                                                           pessoa_nm,
                                                                           projeto_cd,
                                                                           fonte_cd
                                                                      FROM diaria.diaria d
                                                                      JOIN dados_unico.pessoa p  
                                                                        ON d.diaria_beneficiario = p.pessoa_id
                                                                      JOIN dados_unico.funcionario f
                                                                        ON p.pessoa_id = f.pessoa_id 
                                                                       AND d.diaria_id = $codigo";
                                                        
                                                    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);

                                                    $linharsConsulta = pg_fetch_assoc($rsConsulta);
                                                    
                                                    $codigo      = $linharsConsulta['diaria_id'];
                                                    $numero      = $linharsConsulta['diaria_numero'];
                                                    $dataPartida = $linharsConsulta['diaria_dt_saida'];
                                                    $horaPartida = $linharsConsulta['diaria_hr_saida'];
                                                    $dataChegada = $linharsConsulta['diaria_dt_chegada'];
                                                    $horaChegada = $linharsConsulta['diaria_hr_chegada'];
                                                    $processo    = $linharsConsulta['diaria_processo'];
                                                    $status      = $linharsConsulta['diaria_st'];
                                                    $nome        = $linharsConsulta['pessoa_nm'];

                                                    echo "<tr height='20' bgcolor='#f2f2f2'>";
                                                    echo "<td class='GridPaginacaoLink' align='center'>" . $numero . "</td>";
                                                    echo "<td class='GridPaginacaoLink' align='left'>" . $nome . "</td>";
                                                    echo "<td class='GridPaginacaoLink' align='center'>" . $dataPartida . " " . $horaPartida . "</td>";
                                                    echo "<td class='GridPaginacaoLink' align='center'>" . $dataChegada . " " . $horaChegada . "</td>";
                                                    echo "<td class='GridPaginacaoLink' align='center'>&nbsp;" . $processo . "</td>";
                                                    echo "</tr>";
                                                    ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr height="25">
                                            <td align="right">                                          
                                                <input type="button" style="width:70px" onClick="Javascript:ExcluirForm(document.Form);" class="botao" value="Sim"/>&nbsp;&nbsp;                                          
                                                <input type="button" style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" class="botao" value="N&atilde;o"/></td>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <input name="txtCodigo" type="hidden" value="<?=$codigo?>"/>
            <input name="txtData" id="txtData" type="hidden" value="<?=$linhaDiaria['diaria_dt_saida']?>"/>
            <input name="txtProjeto" id="txtProjeto" type="hidden" value="<?=$linhaDiaria['projeto_cd']?>"/>
            <input name="txtFonte" id="txtFonte" type="hidden" value="<?=$linhaDiaria['fonte_cd']?>"/>
            <input name="txtValor" id="txtValor" type="hidden" value="<?=$linhaDiaria['diaria_valor']?>"/>
            <input name="txtEtapa" id="txtEtapa" type="hidden" value="<?=$linhaDiaria['etapa_id']?>"/>
            <input name="txtValorRef" id="txtValorRef" type="hidden" value="<?=$linhaDiaria['diaria_valor_ref']?>"/>
        </form>
    </body>
</html>