<?php
include "Classe/ClasseFeriadoTicket.php";
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
        <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE8' ></meta>
        <style type="text/css">@import url("../css/estilo.css"); </style>
        <style type="text/css">@import url("../css/dhtmlgoodies_calendar.css"); </style>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptAjax.js"></script>
        <script type="text/javascript" language="javascript">
            function AtualizaTicket(frm)
            {                
                if($('#valTicket').val() == $('#hdnValTicket').val())
                {
                    alert('O valor do Ticket não pode ser igual ao atual!');
                    return false;
                }
                else if($('#valTicket').val() == '') 
                {
                    alert('Informe um valor para o Ticket!');
                    return false;
                }
                else
                {
                    frm.action = "FeriadoTicketInicio.php?acao=alterarTicket";                    
                    frm.submit();
                }
            }
        </script>
    </head>    
    <body onload="WM_initializeToolbar();">
        <form id="Form" name="Form" method="post" action="">
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
                                <td height="21" valign="top" align="left" width="190">
                                    <?php include "../Include/Inc_Menu.php" ?>
                                </td>
                                <td height="21" valign="top" align="left">
                                    <?php include "../Include/Inc_Titulo.php" ?>
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <div id="Lista">
                                        <table width="800" border="0" cellpadding="1" cellspacing="1" class="GridPaginacao">                                           
                                            <tr class="GridPaginacaoCabecalhoBorda">
                                                <td height="20" width="498" align="left" colspan="3">
                                                    <a href="FeriadoTicketCadastrar.php?acaoTitulo=Cadastrar" class="GridPaginacaoRegistroNumRegistro">Novo</a>
                                                </td>
                                                <td height="20" width="150" align="right">Valor Ticket</td>
                                                <td height="20" width="100" align="center"><input type="text" id="valTicket" name="valTicket" style="width:90px; height: 16px;" value="<?=$valTicket?>"/></td>
                                                <td height="20" width="100" align="center" ><input type="button" id="btnValTicket" name="btnValTicket" onclick="Javascript:AtualizaTicket(document.Form);" value="Atualizar" style="width:70px"/></td>
                                            </tr>
                                            <tr class="dataLabel">
                                                <td height="20" width="60" colspan="2">&nbsp;</td>
                                                <td height="20" width="110" align='center'>Fériado</td> 
                                                <td height="20" width="420" >Descri&ccedil;&atilde;o</td>                                                
                                                <td height="20" width="200" align='center' colspan="2">Tipo</td>                                                                                              
                                            </tr>
                                            <?php
                                            $paginaAtual        = (int) $_GET['PaginaMostrada'];
                                            $qtdRegistroPagina  = 25;
                                            $qtdRegistroTotal   = pg_num_rows($rsConsulta);
                                            $qtdIndice          = $paginaAtual * $qtdRegistroPagina;
                                            $qtdIndiceFinal     = (($qtdIndice + $qtdRegistroPagina)-1);
                                            $qtdPagina          = ($qtdRegistroTotal/$qtdRegistroPagina);
                                            $qtdPagina          = ceil($qtdPagina);

                                            While(($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal))
                                            {       
                                                $linha       = pg_fetch_assoc($rsConsulta,$qtdIndice);   
                                                $diaFeriado  = $linha['feriado_dia'];
                                                $mesFeriado  = $linha['feriado_mes'];
                                                $feriadoId   = $linha['feriado_id'];
                                                $feriadoDt   = $linha['feriado_dt'];
                                                $feriadoDs   = $linha['feriado_ds'];
                                                $feriadoTipo = $linha['feriado_tipo'];
                                                
                                                if($feriadoTipo == 0)
                                                {
                                                    $feriadoDsTipo = 'NACIONAL';
                                                }
                                                elseif($feriadoTipo == 1)
                                                {
                                                    $feriadoDsTipo = 'ESTADUAL';
                                                }
                                                elseif($feriadoTipo == 2)
                                                {
                                                    $feriadoDsTipo = 'MUNICIPAL';
                                                }
                                                
                                                if($SaldoSuperiorAtual < 0)
                                                {
                                                    $SaldoSuperiorAtual = $SaldoSuperiorAtual * (-1);
                                                }

                                                if($saldoMedioAtual < 0)
                                                {
                                                    $SaldoMedioAtual = $SaldoMedioAtual * (-1);
                                                }                                                                                                                                          

                                                echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";                                                    
                                                    echo "<td width='20' align='center'><a href='FeriadoTicketCadastrar.php?feriado_id=".$feriadoId."&acao=consultar&acaoTitulo=Editar'><img src='../Icones/ico_alterar.png' alt='Editar' border='0'/></a></td>";
                                                    echo "<td width='20' align='center'><a href='FeriadoTicketExcluir.php?feriado_id=".$feriadoId."&acao=consultar&acaoTitulo=Excluir'><img src='../Icones/ico_excluir.png'  alt='Excluir' border='0'/></a></td>";
                                                    echo "<td height='20' align='center' >".$diaFeriado." de ".retornaMes($mesFeriado)."</td>";
                                                    echo "<td height='20' title='".$linha['feriado_ds']."'>".$feriadoDs."</td>";
                                                    echo "<td height='20' align='center' colspan='2'>".$feriadoDsTipo."</td>";                                                                                                                                                         
                                                echo "</tr>";

                                                $qtdIndice++;
                                            }
                                            $paginaAtual++;
                                            ?>
                                            <tr>
                                                <td colspan="6"><?php include "../Include/Inc_Paginacao.php"?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <input type="hidden" id="hdnValTicket" name="hdnValTicket" value="<?=$valTicket?>"/>                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>