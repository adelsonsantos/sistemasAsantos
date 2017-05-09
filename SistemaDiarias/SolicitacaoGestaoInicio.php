<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaGestao.php";
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
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>  
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptDiariaGestao.js"></script>
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
                                    <table cellpadding="1" cellspacing="1" border="0" width="100%" class="GridPaginacao">
                                        <tr class="tabPesquisa">
                                            <td width="300"> 
                                                <input name="txtFiltro" id="txtFiltro" maxlength="100" type="text" value="<?=$retornoFiltro?>" style=" width:265px; height:18px;" onKeyPress="Javascript:if(event.keyCode == 13){ FiltrarForm(document.Form);}" />
                                            </td>
                                            <td width="90">
                                                <input type="button" style="width:70px; height:18px;" onClick="Javascript:FiltrarForm(document.Form);" class="botao" value="Pesquisar"/>                                                                        
                                            </td>
                                            <?php
                                                if($retornoFiltro!="") 
                                                {
                                            ?>
                                                    <td width="155">                                                                                
                                                        <input type="button" style="width:90px; height:18px;" onClick="Javascript:TodosForm(document.Form);" class="botao" value="Exibir Todos" />
                                                    </td>
                                            <?php
                                                }
                                                else 
                                                {
                                            ?>
                                                    <td width="155">&nbsp;</td>
                                            <?php
                                                }
                                            ?>
                                            <td width="253" align="right"> 
                                                <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:MarcaCheckbox(document.Form.checkbox);">Marcar Todos </a>
                                                <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:DesmarcaCheckbox(document.Form.checkbox);"> Desmarcar Todos</a>
                                            </td> 
                                        </tr>
                                    </table>                                    
                                    <?php include "../Include/Inc_Linha.php"?>								
                                        <table cellpadding="1" cellspacing="1" width="100%" border="0" class="GridPaginacao">
                                            <tr class="dataField">
                                                <td width="399" align="left" height='20'>
                                                    <input type="button" style="width:100px; height:20px;" onClick="javascript:LiberarTodosEmpenho(document.Form.checkboxLiberarEmpenho);" class="botao" value="Liberar Empenho"/>
                                                    <img src='../Icones/ico_aceitar.png' border="0" alt="Liberar Empenho"/>
                                                </td>
                                                <td width="399" align="right" height='20'>
                                                    <a href="<?=$PaginaLocal?>ImprimirDiariasAprovadas.php" >Imprimir Diárias Aprovadas</a> 
                                                    <a href="<?=$PaginaLocal?>ImprimirDiariasAprovadas.php" ><img src="../Icones/ico_imprimir.png" border="0" alt="Extrato Empenho"/></a>
                                                </td>
                                            </tr>
                                        </table>									
                                    <?php include "../Include/Inc_Linha.php"?>
                                        <table border="0" cellpadding="1" cellspacing="1" width="798"  class="GridPaginacao">
                                            <tr class="dataLabel">
                                                <td>                                                    
                                                    <table border="0" cellpadding="1" cellspacing="1" width="798">
                                                        <tr class="dataLabel">
                                                            <td height="20" width="120" colspan="7"></td>                                                            
                                                            <td height="20" width="20" title="Pedido de Empenho"><u>P.E</u></td>
                                                            <td height="20" width="60" align="center"><a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=diaria_id'><u>SD</u></a></td>
                                                            <td height="20" width="195" align="left"><a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=pessoa_nm'><u>Nome</u></a></td>                                                        
                                                            <td height="20" width="130" align="center"><a href='<?=$PaginaLocal?>Inicio.php?acao=buscar&atributo=diaria_dt_saida'><u>Partida Prevista</u></a></td>                                                        
                                                            <td height="20" width="138" align="center"><u>Fonte</u></a></td>
                                                            <td height="20" width="20"><u>Diretoria</u></td>
                                                            <td height="20" width="115"><u>Liberar Empenho</u></td>
                                                        </tr>
                                                        <?php													
                                                        include "IncludeLocal/EmpenhoDiariasAgrupadas.php";
                                                        //DADOS PARA A PAGINAÇÃO
                                                        $paginaAtual        = (int)$_GET['PaginaMostrada'];                                                        
                                                        $qtdRegistroPagina  = 50;
                                                        $qtdRegistroTotal   = pg_num_rows($rsConsulta);
                                                        $qtdIndice          = $paginaAtual * $qtdRegistroPagina;
                                                        $qtdIndiceFinal     = (($qtdIndice + $qtdRegistroPagina)-1);
                                                        $qtdPagina          = ($qtdRegistroTotal/$qtdRegistroPagina);
                                                        $qtdPagina          = ceil($qtdPagina);

                                                        while(($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal)) 
                                                        {
                                                            $linhaDiaria        = pg_fetch_assoc($rsConsulta, $qtdIndice);

                                                            $Codigo             = $linhaDiaria['diaria_id'];
                                                            $Numero             = $linhaDiaria['diaria_numero'];
                                                            $Nome               = $linhaDiaria['pessoa_nm'];
                                                            $DataPartida        = $linhaDiaria['diaria_dt_saida'];
                                                            $HoraPartida        = $linhaDiaria['diaria_hr_saida'];
                                                            $DataChegada        = $linhaDiaria['diaria_dt_chegada'];
                                                            $DataDaSolicitacao  = $linhaDiaria['diaria_dt_criacao'];
                                                            $HoraDaSolicitacao  = $linhaDiaria['diaria_hr_criacao'];
                                                            $HoraChegada        = $linhaDiaria['diaria_hr_chegada'];
                                                            $Status             = $linhaDiaria['diaria_st'];
                                                            $Beneficiario       = $linhaDiaria['diaria_beneficiario'];
                                                            $Processo           = $linhaDiaria['diaria_processo'];
                                                            $Empenho            = $linhaDiaria['diaria_empenho'];
                                                            $diariaDevolvida    = $linhaDiaria['diaria_devolvida'];
                                                            $diariaCancelada    = $linhaDiaria['diaria_cancelada'];
                                                            $diariaComprovada   = $linhaDiaria['diaria_comprovada'];
                                                            $diaria_Excluida    = $linhaDiaria['diaria_excluida'];
                                                            $diariaLocal        = $linhaDiaria['diaria_local_solicitacao'];
                                                            $Indenizacao        = $linhaDiaria['indenizacao'];
                                                            $Convenio           = $linhaDiaria['convenio_id'];
                                                            $ExtratoEmpenho     = $linhaDiaria['diaria_extrato_empenho'];
                                                            $Diaria_Agrupa      = $linhaDiaria['diaria_agrupada'];
                                                            $fonteCodigo        = $linhaDiaria['fonte_cd'];
                                                            $pedidoEmpenho      = $linhaDiaria['pedido_empenho'];

                                                            if (strlen($Nome) > 21) 
                                                            {
                                                                $Nome = substr($Nome, 0, 20) . '...';
                                                            }
                                                            include "IncludeLocal/Inc_Regra_Bloqueio.php";

                                                            include "IncludeLocal/Inc_StatusDiaria.php";

                                                            // DIARIA NO PRIMEIRO EMPENHO.
                                                            if ($Status == 2)
                                                            {  
                                                                echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";

                                                                if($ExtratoEmpenho == 1)
                                                                {
                                                                    echo "<td height='20' width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Codigo." checked/></td>"; //checked																
                                                                }
                                                                else
                                                                {                                                               
                                                                    echo "<td height='20' width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Codigo." /></td>"; 
                                                                }															
                                                                echo "<td height='20' align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" .$Codigo."&pagina=SolicitacaoGestao'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'/></a></td>";
                                                                echo "<td height='20' align='center'><a href='SolicitacaoEmpenhar.php?cod=" .$Codigo. "&acao=consultar&pagina=SolicitacaoGestao'><img src='../Icones/ico_comprovar.png' border='0' alt='Empenhar'/></a></td>";                                                    
                                                                if(($Processo != "") && ($Empenho!=""))
                                                                {    
                                                                    echo "<td height='20' align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'/></a></td>";
                                                                    //REMOVIDO POR SOLICITAÇÃO DO SETOR
                                                                    //echo "<td height='20' align='center'><a href='javascript:ImprimirDiaria(" .$Codigo. ");'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'/></a></td>";
                                                                }
                                                                else 
                                                                {
                                                                    echo "<td height='20' align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'/></a></td>";
                                                                }

                                                                if(($Processo != "") && ($Empenho!="")) 
                                                                {
                                                                    echo "<td height='20' align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'/></a></td>";
                                                                    //REMOVIDO POR SOLICITAÇÃO DO SETOR
                                                                    //echo "<td height='20' align='center'><a href='javascript:ImprimirProcesso(" .$Codigo. ");'><img src='../Icones/ico_imprimir_processo.png' border='0' alt='Imprimir Processo'/></a></td>";
                                                                }
                                                                else
                                                                {
                                                                    echo "<td height='20' align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'/></a></td>";
                                                                }
                                                                /*

                                                                '*****************************************************************************
                                                                ' Alterado por Rodolfo em 16/09/2008
                                                                ' Solicitação da DA - Paulo Bispo - Diaria Comprovada não pode ser devolvida
                                                                '*****************************************************************************
                                                                 *
                                                                 */
                                                                if (($StatusNome == "Devolvida (Comprovada) " )  &&  ($Status == 2)) 
                                                                {
                                                                    echo "<td height='20' align='center'><img src='../icones/ico_devolver_offG.png' alt='Devolver' border='0'/></td>";
                                                                }
                                                                else 
                                                                {    
                                                                    echo "<td height='20' align='center'><a href='SolicitacaoDevolver.php?cod=".$Codigo."&pagina=SolicitacaoGestao'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'/></a></td>";
                                                                }

                                                                if ($Empenho=="") 
                                                                {
                                                                    echo "<td height='20' align='center'><img src='../icones/ico_aceitar_off.png' alt='Liberar Empenho' border='0'/></td>";
                                                                }
                                                                else 
                                                                {
                                                                    echo "<td height='20' align='center'><a href='javascript:LiberarEmpenho(" .$Codigo. ");'><img src='../Icones/ico_aceitar.png' border='0' alt='Liberar Empenho'/></a></td>";
                                                                }
                                                                if($Empenho == "")
                                                                {
                                                                    if(($pedidoEmpenho == '')||($pedidoEmpenho == 2))
                                                                    {
                                                                    ?>
                                                                        <td height='20' align='center'>
                                                                          <span id="ped">
                                                                              <input type="checkbox" id="pedEmp<?=$Codigo?>" name="pedEmp" class="checkbox" onclick="Javascript:PedidoDeEmpenho(<?=$Codigo?>);"/>
                                                                          </span>
                                                                        </td>
                                                                    <?php
                                                                    }
                                                                    else 
                                                                    {
                                                                    ?>
                                                                        <td height='20' align='center'>
                                                                          <span id="ped">
                                                                              <input type="checkbox" id="pedEmp<?=$Codigo?>" name="pedEmp" checked class="checkbox" onclick="Javascript:PedidoDeEmpenho(<?=$Codigo?>);"/>
                                                                          </span>
                                                                        </td>
                                                                    <?php
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                     echo"<td height='20' align='center'>
                                                                            <span id='ped'>
                                                                                <input type='checkbox' id='pedEmp".Codigo."' name='pedEmp' checked class='checkbox' onclick='Javascript:PedidoDeEmpenho(".$Codigo.");' disabled/>
                                                                            </span>
                                                                          </td>";
                                                                }
                                                                echo "<td height='20' align='center'>".$Numero."</td>";
                                                                echo "<td height='20' title='".$linhaDiaria['pessoa_nm']."'>".$Nome."</a></td>";                                                            
                                                                echo "<td height='20' align='center'>".$DataPartida." &agrave;s ".$HoraPartida."</td>";                                                            
                                                            }
                                                            else
                                                            {
                                                            // DIARIO NO SEGUNDO EMPENHO.
                                                                echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                                if ($ExtratoEmpenho == 1)
                                                                {
                                                                    echo "<td height='20' width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Codigo." checked/></td>";
                                                                }
                                                                else
                                                                {
                                                                    echo "<td height='20' width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Codigo."/></td>";
                                                                }
                                                                echo "<td height='20' align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" .$Codigo."&pagina=SolicitacaoGestao'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'/></a></td>";
                                                                echo "<td height='20' align='center'><a href='SolicitacaoEmpenhar.php?cod=" .$Codigo. "&acao=consultar&pagina=SolicitacaoGestao'><img src='../Icones/ico_comprovar.png' border='0' alt='Empenhar'/></a></td>";
                                                                echo "<td height='20' align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'/></a></td>";
                                                                echo "<td height='20' align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'/></a></td>";

                                                                if (($StatusNome == "Devolvida (Comprovada) " )  &&  ($Status == 6)) 
                                                                {
                                                                    echo "<td height='20' align='center'><img src='../icones/ico_devolver_offG.png' alt='Devolver' border='0'/></td>";
                                                                }
                                                                else 
                                                                {    
                                                                    echo "<td height='20' align='center'>
                                                                            <a href='SolicitacaoDevolver.php?cod=".$Codigo."&pagina=SolicitacaoGestao'>
                                                                                <img src='../Icones/ico_devolver.png' border='0' alt='Devolver'/>
                                                                            </a>
                                                                        </td>";
                                                                }

                                                                if ($Empenho=="") 
                                                                {
                                                                    echo "<td height='20' align='center'><img src='../icones/ico_aceitar_off.png' alt='Liberar Empenho' border='0'/></td>";
                                                                }
                                                                else 
                                                                {
                                                                    echo "<td height='20' align='center'>
                                                                            <a href='javascript:LiberarSegundoEmpenho(" .$Codigo. ");'>
                                                                                <img src='../Icones/ico_aceitar.png' border='0' alt='Liberar Empenho'/>
                                                                            </a>
                                                                        </td>";
                                                                }
                                                                if($Empenho == "")
                                                                {
                                                                    if(($pedidoEmpenho == '')||($pedidoEmpenho == 2))
                                                                    {
                                                                    ?>
                                                                        <td height='20' align='center'>
                                                                          <span id="ped">
                                                                              <input type="checkbox" id="pedEmp<?=$Codigo?>" name="pedEmp" class="checkbox" onclick="Javascript:PedidoDeEmpenho(<?=$Codigo?>);"/>
                                                                          </span>
                                                                        </td>
                                                                    <?php
                                                                    }
                                                                    else 
                                                                    {
                                                                    ?>
                                                                        <td height='20' align='center'>
                                                                          <span id="ped">
                                                                              <input type="checkbox" id="pedEmp<?=$Codigo?>" name="pedEmp" checked class="checkbox" onclick="Javascript:PedidoDeEmpenho(<?=$Codigo?>);"/>
                                                                          </span>
                                                                        </td>
                                                                    <?php
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                     echo"<td height='20' align='center'>
                                                                            <span id='ped'>
                                                                                <input type='checkbox' id='pedEmp".Codigo."' name='pedEmp' checked class='checkbox' onclick='Javascript:PedidoDeEmpenho(".$Codigo.");' disabled/>
                                                                            </span>
                                                                          </td>";
                                                                }
                                                                echo "<td height='20' align='center'><font color='#CC9933'>".$Numero."</font></td>";
                                                                echo "<td height='20'><font color='#CC9933'>" .$Nome."</font></a></td>";                                                            
                                                                echo "<td height='20' align='center'><font color='#CC9933'>".$DataPartida." &agrave;s ".$HoraPartida."</font></td>";                                                            
                                                            }
                                                           // VERIFICA O TIPO DE DIÁRIA SE É INDENIZAÇÃO, CONVENIO OU NORMAL 
    //                                                        if ($Indenizacao == 0)
    //                                                        {
    //                                                            if ($Convenio == 0)
    //                                                            {
    //                                                                if ($Status == 2)
    //                                                                {
    //                                                                    echo "N-1";                                                                
    //                                                                }
    //                                                                else
    //                                                                {
    //                                                                    echo "<font color='#CC9933'>N-2</font>";                                                                
    //                                                                }
    //                                                            }
    //                                                            else
    //                                                            {
    //                                                                if ($Status == 2)
    //                                                                {
    //                                                                    echo "C-1";                                                                    
    //                                                                }
    //                                                                else
    //                                                                {
    //                                                                    echo "<font color='#CC9933'>C-2</font>";                                                                
    //                                                                }
    //                                                            }
    //                                                        }
    //                                                        else
    //                                                        {
    //                                                            if ($Status == 2)
    //                                                            {
    //                                                                echo "I";                                                                
    //                                                            }
    //                                                            else
    //                                                            {
    //                                                                echo "<font color='#CC9933'>I-2</font>";                                                                
    //                                                            }
    //                                                        }
                                                            echo "<td height='20' align='center'>$fonteCodigo</td>";
                                                            /// Diretoria da Diaria  
                                                            $diretoria      = $linhaDiaria['est_organizacional_ds'];                                                        
                                                            $diretoriaSigla = $linhaDiaria['est_organizacional_sigla'];

                                                            echo "<td height='20' color='#FFFF00' title ='$diretoria'>$diretoriaSigla</td>";

                                                            if($Empenho == "")
                                                            { // Liberar todos os empenhos de uma vez
                                                                if($pedidoEmpenho == '')
                                                                {
                                                                    echo "<td height='20' width='100' align='center' id='liberarEmpenho".$Codigo."'><input type='checkbox' class='checkbox' name='checkboxLiberarEmpenho' value= ".$Codigo." disabled/></td>";
                                                                }
                                                                elseif($pedidoEmpenho == 1)
                                                                {
                                                                    echo "<td height='20' width='100' align='center' bgcolor='#ffff00' id='liberarEmpenho".$Codigo."'><input type='checkbox' class='checkbox' name='checkboxLiberarEmpenho' value= ".$Codigo." disabled/></td>";
                                                                }
                                                                else 
                                                                {
                                                                    echo "<td height='20' width='100' align='center' bgcolor='#b22222' id='liberarEmpenho".$Codigo."'><input type='checkbox' class='checkbox' name='checkboxLiberarEmpenho' value= ".$Codigo." disabled/></td>";
                                                                }                                                                
                                                            }
                                                            else
                                                            {
                                                                echo "<td width='100' align='center' bgcolor='#8FBC8F' ><input type='checkbox' class='checkbox' name='checkboxLiberarEmpenho' value= ".$Codigo." checked/></td>";
                                                            }
                                                                echo "</td>";
                                                            echo "</tr>";

                                                            If (($StatusNome == "Devolvida") || ($StatusNome == "Devolvida (Comprovada) " )  &&  ($Status == 2)) 
                                                            {
                                                                echo "<tr bgcolor='#f2f2f2'>";
                                                                    echo "<td height='20' class='GridPaginacaoLink'><img src='../icones/ico_aviso.gif' alt='Alerta' border='0'/></td>";
                                                                    echo "<td height='20' class='GridPaginacaoLink' colspan='7'><font color='#ff0000'>".$MotivoDevolucao.": ".$labelDevolucao."</font></td>";
                                                                    echo "<td height='20'></td>";
                                                                    echo "<td height='20'></td>";
                                                                echo "</tr>";
                                                            }

                                                            If ($ContadorVirtual > 1) 
                                                            { 
                                                                echo "<tr class='dataField'><td height='21' colspan='14'>Beneficiário com Diária comprovada e pendente de documentação - ".$NumeroDiariaVirtual."</td></tr>";
                                                            }
                                                            If ($ContadorAtraso > 0) 
                                                            {
                                                                echo "<tr class='dataField'><td height='21' colspan='14'>Beneficiário que não fez comprovação - ".$NumeroDiariaAtrasada."</td></tr>";
                                                            }
                                                            $qtdIndice++;
                                                        }
                                                        $paginaAtual++;
                                                      ?>                                        
                                                    </table>                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="798"><?php include "IncludeLocal/Inc_Paginacao_Empenho.php"?></td>                                                                                                        
                                            </tr>
                                        </table>                                    
                                    <input type="hidden" id="filtro" name="filtro"/>                                   
                                    <input type="hidden" id="pedidoEmpenho" name="pedidoEmpenho" value="<?=$pedidoEmpenho?>"/>                                   
                                </td>
                            </tr>                            
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>