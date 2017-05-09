<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseFonte.php";
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
        <script language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script language="javascript">

            function ExcluirForm(frm, checkbox)
            {
                frm.action="FonteExcluir.php?excluirMultiplo=1&acao=excluir";
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
                    <td>
                        <table align="left" width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">
                                    <?php include "../Include/Inc_Titulo.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <?php include "../Include/Inc_TituloExcluir.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    
                                    <table width="798" border="0" cellpadding="0" cellspacing="1" class="TabelaFormulario">
                                        <tr height="21" class="dataLabel">
                                            <td width="90">&nbsp;N&uacute;mero</td>
                                            <td width="648">&nbsp;Descri&ccedil;&atilde;o</td>
                                            <td width="60" align="center">Status</td>
                                        </tr>
                                        <?php
                                        $ExcluirCheckbox = $_GET['excluirMultiplo'];
                                        $codCheckbox     = $_POST['checkbox'];

                                        If ($ExcluirCheckbox == 1)
                                        {                               
                                            $sqlConsulta = "SELECT * FROM diaria.fonte WHERE fonte_cd IN ('" .$codCheckbox. "') ORDER BY UPPER(fonte_ds)";
                                            $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);
                                            $Codigo      = $codCheckbox;

                                            while($linha = pg_fetch_assoc($rsConsulta))
                                            {
                                                $Numero	  = $linha['fonte_cd'];
                                                $Descricao	  = $linha['fonte_ds'];
                                                $StatusNumero = $linha['fonte_st'];

                                                If ($StatusNumero == "0")
                                                { 
                                                    $StatusNome = "Ativo";
                                                }
                                                Else
                                                {  
                                                    $StatusNome = "Inativo";
                                                }
                                                ?>
                                                    <tr height="21" class="dataField">
                                                        <td>&nbsp;<?=$Numero?></td>
                                                        <td>&nbsp;<?=$Descricao?></td>
                                                        <td align="center"><?=$StatusNome?></td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                        Else
                                        {
                                        ?>
                                            <tr height="21" class="dataField">
                                                <td>&nbsp;<?=$Numero?></td>
                                                <td>&nbsp;<?=$Descricao?></td>
                                                <td align="center"><?=$StatusNome?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr height="25">
                                            <td align="right">
                                                <?php
                                                If ($ExcluirCheckbox == 1)
                                                {
                                                ?>
                                                    <input type="button" style="width:70px" onClick="Javascript:ExcluirForm(document.Form);" class="botao" value="Sim"/>&nbsp;&nbsp;
                                                <?php
                                                }
                                                Else
                                                {
                                                ?>
                                                    <input type="button" style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php?acao=excluir&cod=<?=$Codigo?>';" class="botao" value="Sim"/>&nbsp;&nbsp;
                                                <?php
                                                }
                                                ?>
                                                    <input type="button" style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" class="botao" value="Não"/>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <input name="txtCodigo" type="hidden" value="<?=$Codigo?>"/>
        </form>
    </body>
</html>
