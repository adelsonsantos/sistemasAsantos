<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseEstruturaLotacao.php";
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
        <script type="text/javascript" language="javascript">

            function ExcluirForm(frm, checkbox)
            {
                frm.action="EstOrganizacionalExcluir.php?excluirMultiplo=1&acao=excluir";
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

                                    <table width="798" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21" width="170" align="center">Sigla</td>
                                            <td height="21" width="210" align="center">Unidade Superior</td>
                                            <td height="21" width="369" align="left">Unidade</td>
                                            <td height="21" width="60" align="center">Status</td>
                                        </tr>
                                        <?php
                                        $ExcluirCheckbox = $_GET['excluirMultiplo'];
                                        $codCheckbox     = $_POST['checkbox'];

                                        If ($ExcluirCheckbox == 1)
                                        {
                                            $sqlConsulta = "SELECT tFilha.est_organizacional_lotacao_id, tFilha.est_organizacional_lotacao_ds, tFilha.est_organizacional_lotacao_sigla, tPai.est_organizacional_lotacao_ds AS EstSuperior, tFilha.est_organizacional_lotacao_sup_cd, tFilha.est_organizacional_lotacao_st FROM dados_unico.est_organizacional_lotacao tFilha LEFT JOIN dados_unico.est_organizacional_lotacao tPai ON (tPai.est_organizacional_lotacao_id = tFilha.est_organizacional_lotacao_sup_cd) WHERE tFilha.est_organizacional_lotacao_id IN (" .$codCheckbox. ") ORDER BY UPPER(tFilha.est_organizacional_lotacao_ds)";
                                            $rsConsulta  = pg_query(abreConexao(),$sqlConsulta);
                                            $EstOrganizacionalCodigo = $codCheckbox;

                                            while($linha=pg_fetch_assoc($rsConsulta))
                                            {
                                                $EstOrganizacionalSuperior    	= $linha['estsuperior'];
                                                $EstOrganizacionalDescricao	= $linha['est_organizacional_lotacao_ds'];
                                                $EstOrganizacionalSigla	    	= $linha['est_organizacional_lotacao_sigla'];
                                                $EstOrganizacionalStatusCod	= $linha['est_organizacional_lotacao_st'];

                                                If ($EstOrganizacionalStatusCod == "0")
                                                {  
                                                    $EstOrganizacionalStatus = "Ativo";
                                                }
                                                Else
                                                {  
                                                    $EstOrganizacionalStatus = "Inativo";
                                                }
                                        ?>
                                                <tr class="dataField">
                                                    <td height="21"><?=$EstOrganizacionalSigla?></td>
                                                    <td height="21"><?=$EstOrganizacionalSuperior?></td>
                                                    <td height="21"><?=$EstOrganizacionalDescricao?></td>
                                                    <td height="21" align="center"><?=$EstOrganizacionalStatus?></td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        Else
                                        {
                                        ?>
                                            <tr class="dataField">
                                                <td height="21" title="<?=$linha['est_organizacional_lotacao_sigla']?>"><?=$EstOrganizacionalSigla?></td>
                                                <td height="21"><?=$EstOrganizacionalSuperior?></td>
                                                <td height="21"><?=$EstOrganizacionalDescricao?></td>
                                                <td height="21" align="center"><?=$EstOrganizacionalStatus?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>

                                    <?php include "../Include/Inc_Linha.php"?>

                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td height="25" align="right">
                                                <?php
                                                If ($ExcluirCheckbox == 1)
                                                {
                                                ?>
                                                    <input type="button" style="width:70px" onClick="Javascript:ExcluirForm(document.Form);" class="botao" value="Sim"/>
                                                <?php
                                                }
                                                Else
                                                {
                                                ?>									
                                                    <input type="button" style="width:70px" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php?acao=excluir&cod=<?=$EstOrganizacionalCodigo?>';" class="botao" value="Sim"/>
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
            <input name="txtCodigo" type="hidden" value="<?=$EstOrganizacionalCodigo?>"/>
        </form>
    </body>
</html>

