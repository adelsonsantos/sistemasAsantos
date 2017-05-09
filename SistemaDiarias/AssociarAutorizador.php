<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseAssociarAutorizador.php";
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
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>  
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript">            
            function GravarForm(frm,j)
            {
                //alert($('#txtUnidade'+j).val()); return false;
                for (cont=0; cont < frm.elements.length; cont++)
                {
                    frm.elements[cont].style.backgroundColor = '';
                }                
                frm.action = "AssociarAutorizador.php?acao=alterar&i="+j;
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
                    <td><?php include"../Include/Inc_Aba.php"?></td>
                </tr>
                <tr>
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">
                                <?php 
                                    include "../Include/Inc_Titulo.php";
                                    include "../Include/Inc_Linha.php";                                 

                                    $i = 0;
                                    echo "<table border='0' cellpadding='1' cellspacing='1' width='100%' class='GridPaginacao'>";
                                        echo "<tr class=dataLabel>";
                                            echo "<td height=21 width=300>Unidade</td>";
                                            echo "<td height=21 width=498>Autorizador</td>";
                                        echo "</tr>";

                                    While ($linharsACP = pg_fetch_assoc($rsACP))
                                    {
                                        $i++;
                                        $sql     = "SELECT pessoa_id FROM diaria.autorizador_acp WHERE est_organizacional_id = ".$linharsACP['est_organizacional_id'];
                                        $rs      = pg_query(abreConexao(),$sql);
                                        $linhars = pg_fetch_assoc($rs);

                                        If($linhars)
                                        {
                                            $CodigoPessoa  = $linhars['pessoa_id'];
                                        }
                                        Else
                                        {    
                                            $CodigoPessoa = 0;
                                        }

                                        echo "<tr class='dataField'>";
                                            echo "<td height='21'>";
                                                echo $linharsACP['est_organizacional_centro_custo_num']." ".$linharsACP['est_organizacional_sigla'];
                                                echo "<input type='hidden' id='txtUnidade".$i."' name='txtUnidade".$i."' value='".$linharsACP['est_organizacional_id']."'/>";
                                            echo "</td>";
                                            echo "<td height='21'>";                                            
                                                echo f_ComboAutorizador($CodigoPessoa,$i);
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</table>";
                                    
                                    If ($_GET['sucesso'] == 1)
                                    {
                                        echo "<table width='800'>
                                                <tr class='MensagemErro'>
                                                    <td align='right'>Associção realizada com sucesso</td>
                                                </tr>
                                             </table>";
                                    }
                                    ?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="100%">
                                        <tr>
                                            <td height="25" align="right"><input type="button" style="width:70px" onClick="Javascript:GravarForm(document.Form,'<?=$i?>');" name="btnGravar" class="botao" value="Gravar"/></td>
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

