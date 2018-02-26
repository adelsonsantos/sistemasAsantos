<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseImprimirProcesso.php";
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
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" charset="utf-8">
            // Novas funções acresentadas por conta da Mudança de Perfil de Autorizador para Imprimir o processo e a diária.
            function FiltrarForm(frm)
            {     
                frm.action = "SolicitacaoImprimirProcesso.php?filtro="+frm.txtFiltro.value;
                frm.submit();                
            }
            function TodosForm(frm)
            {
                frm.action = "SolicitacaoImprimirProcesso.php";
                frm.submit();  
            }
            function ImprimirDiaria(codigo,frm)
            {                
                frm.action = "SolicitacaoImprimirProcesso.php";
                frm.submit(); 
                window.open ("SolicitacaoImprimirPDF.php?acao=imprimir&cod="+codigo);
            }

            function ImprimirProcesso(codigo)
            {
				location.reload();
                window.open ("SolicitacaoImprimirJPG.php?acao=imprimir&cod="+codigo);
            }
            // Fim das Novas funções acresentadas por conta da Mudança de Perfil de Autorizador para Imprimir o processo e a diária.  
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
                                    <table cellpadding="1" border="0" cellspacing="1" width="100%" class="tabPesquisa" >
                                        <tr class="dataField">
                                            <td width="270"><input name="txtFiltro" id="txtFiltro" maxlength="100" type="text" value="<?=$RetornoFiltro?>" style=" width:265px;" onKeyPress="Javascript:if(event.keyCode == 13){FiltrarForm(document.Form);}" /></td>
                                            <td width="75" valign="middle"><input type="button" style="width:70px; height:18px;" onClick="Javascript:FiltrarForm(document.Form);" class="botao" value="Pesquisar"/></td>
                                            <?php
                                            if ($RetornoFiltro != "") 
                                            {
                                            ?>
                                                <td valign="middle"><input type="button" style="width:90px; height:18px;" onClick="Javascript:TodosForm(document.Form);" class="botao" value="Exibir Todos"/></td>
                                            <?php
                                            } 
                                            else 
                                            {
                                            ?>
                                                <td>&nbsp;</td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    </table>                                                                                       
                                    <?php include "../Include/Inc_Linha.php" ?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="100%" class="GridPaginacao">
                                        <tr class="dataLabel">
                                            <td height="20" width="100" colspan="4"></td>
                                            <td height="20" width="90" align="center"><a href='<?= $PaginaLocal ?>.php?acao=buscar&atributo=diaria_numero&orderby=<?=$_GET['orderby']?>'><u>SD</u></a></td>
                                            <td height="20" width="318" align="left"><a href='<?= $PaginaLocal ?>.php?acao=buscar&atributo=pessoa_nm&orderby=<?=$_GET['orderby']?>'><u>Nome</u></a></td>
                                            <td height="20" width="130" align="center"><a href='<?= $PaginaLocal ?>.php?acao=buscar&atributo=diaria_dt_criacao&orderby=<?=$_GET['orderby']?>'><u>Data Solicita&ccedil;&atilde;o</u></a></td>
                                            <td height="20" width="130" align="center"><a href='<?= $PaginaLocal ?>.php?acao=buscar&atributo=diaria_dt_saida&orderby=<?=$_GET['orderby']?>'><u>Partida Prevista</u></a></td>                                                        
                                        </tr>
                                        <?php
                                        while($linhaDiaria  = pg_fetch_assoc($rsConsulta)) 
                                        {                                            
                                            $Codigo             = $linhaDiaria['diaria_id'];
                                            $Numero             = $linhaDiaria['diaria_numero'];
                                            $DataPartida        = $linhaDiaria['diaria_dt_saida'];
                                            $HoraPartida        = $linhaDiaria['diaria_hr_saida'];
                                            $DataChegada        = $linhaDiaria['diaria_dt_chegada'];
                                            $HoraChegada        = $linhaDiaria['diaria_hr_chegada'];
                                            $Processo           = $linhaDiaria['diaria_processo'];
                                            $Status             = $linhaDiaria['diaria_st'];
                                            $Nome               = $linhaDiaria['pessoa_nm'];
                                            $ACP                = $linhaDiaria['diaria_unidade_custo'];
                                            $imp_processo_st    = $linhaDiaria['imp_processo_st'];
                                            $DataDaSolicitacao  = $linhaDiaria['diaria_dt_criacao'];
                                            $HoraDaSolicitacao  = $linhaDiaria['diaria_hr_criacao'];

                                            echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";

                                            if ($imp_processo_st == 1) 
                                            { // esse é o atributo que vai controlar a Marcação do Box pode usar  READONLY OU DISABLED - melhor esse
                                                echo "<td height='20' width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= " . $Codigo . " checked disabled /></td>";
                                            }
                                            else 
                                            {
                                                echo "<td height='20' width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= " . $Codigo . " disabled /></td>";
                                            }
                                                echo "<td height='20' align='center'>
                                                        <a href='SolicitacaoConsultar.php?acao=consultar&cod=" . $Codigo . "&pagina=$PaginaLocal'>
                                                            <img src='../Icones/ico_consultar.png' border='0' alt='Consultar'/>
                                                        </a>
                                                      </td>";
                                                echo "<td height='20' align='center'>
                                                        <a href='javascript:ImprimirDiaria(" . $Codigo . ", document.Form);'>
                                                            <img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'/>
                                                        </a>
                                                      </td>";
                                                echo "<td height='20' align='center'>
                                                        <a href='javascript:ImprimirProcesso(" . $Codigo . ");'>
                                                            <img src='../Icones/blue-download.png' border='0' alt='Imprimir Processo'/>
                                                        </a>
                                                      </td>";
                                                echo "<td height='20' align='center'>" . $Numero . "</td>";
                                                echo "<td height='20'>" . $Nome . "</td>";
                                                echo "<td height='20' align='center'>" . f_FormataData($DataDaSolicitacao) . " &agrave;s " . $HoraDaSolicitacao . "</td>";
                                                echo "<td height='20' align='center'>" . $DataPartida . " &agrave;s " . $HoraPartida . "</td>";
                                            echo "</tr>";
                                            $qtdIndice++;
                                        }
                                        $paginaAtual++;
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