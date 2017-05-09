<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseFuncionario.php";
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
        <link rel="stylesheet" type="text/css" href="../css/estilo.css" />  
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
    </head>

    <body onload="Javascript:WM_initializeToolbar();">
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
                                    <div id="titulopagina">
                                        <?php include "../Include/Inc_Titulo.php"?>
                                    </div>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <?php include "../Include/Inc_TituloExcluir.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table width="800" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21" width="100" align="left">Matr&iacute;cula</td>
                                            <td height="21" width="468" align="left">Nome</td>
                                            <td height="21" width="170" align="center">Estrutura</td>
                                            <td height="21" width="60" align="center">Status</td>
                                        </tr>
                                        <?php
                                        $ExcluirCheckbox = $_GET['excluirMultiplo'];
                                        $codCheckbox = $_POST['checkbox'];

                                        If ($ExcluirCheckbox == 1)
                                        {
                                            $sqlConsultaExclusao = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, funcionario_matricula, ef.est_organizacional_id 
                                                                      FROM dados_unico.pessoa p,  dados_unico.funcionario f,  dados_unico.est_organizacional eo, dados_unico.est_organizacional_funcionario ef 
                                                                     WHERE (f.funcionario_id = ef.funcionario_id) 
                                                                       AND (eo.est_organizacional_id = ef.est_organizacional_id) 
                                                                       AND est_organizacional_funcionario_st = 0 
                                                                       AND (p.pessoa_id = f.pessoa_id) 
                                                                       AND f.pessoa_id IN (" .$codCheckbox. ") 
                                                                  ORDER BY UPPER(pessoa_nm)";
                                            $rsConsultaExclusao  = pg_query(abreConexao(),$sqlConsultaExclusao);
                                            $Codigo = $codCheckbox;

                                            while($linha = pg_fetch_assoc($rsConsultaExclusao))
                                            {
                                                $Matricula         = $linha['funcionario_matricula'];
                                                $EstOrganizacional = $linha['est_organizacional_id'];
                                                $Nome	       = $linha['pessoa_nm'];
                                                $StatusNumero      = $linha['pessoa_st'];

                                                If ($StatusNumero == "0")
                                                {  
                                                    $StatusNome = "Ativo";
                                                }
                                                Else
                                                {
                                                    $StatusNome = "Inativo";
                                                }
                                        ?>
                                                <tr class="dataField">
                                                    <td height="21"><?=$Matricula?></td>
                                                    <td height="21"><?=$Nome?></td>
                                                    <td height="21"><?=f_ConsultaEstruturaOrganizacionalSigla($EstOrganizacional)?></td>
                                                    <td height="21" align="center"><?=$StatusNome?></td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        Else
                                        {
                                        ?>
                                            <tr class="dataField">
                                                <td height="21"><?=$Matricula?></td>
                                                <td height="21"><?=$Nome?></td>
                                                <td height="21" align="center"><?=f_ConsultaEstruturaOrganizacionalSigla($EstOrganizacional)?></td>
                                                <td height="21" align="center"><?=$StatusNome?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td height="25" align="right">
                                                <input type="button" style="width:70px;" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php?acao=excluir&cod=<?=$Codigo?>';" class="botao" value="Sim"/>                                            
                                                <input type="button" style="width:70px;" onClick="Javascript:window.location.href='<?=$PaginaLocal?>Inicio.php';" class="botao" value="Não"/>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <input name="txtCodigo" type="hidden" value="<?=$Codigo?>">
        </form>
    </body>
</html>
