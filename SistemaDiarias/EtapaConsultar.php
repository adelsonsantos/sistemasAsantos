<?php
include "Classe/ClasseEtapa.php";
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
        <link type="text/css" href="../css/estilo.css" rel="stylesheet"/>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.4.2.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery.maskedinput-1.2.2.js"></script>   
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptEtapaCadastrar.js"></script>
    </head>
    
    <body>
        <form name="Form" method="post" action="">
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
                                    <?php 
                                        $linhaConsulta  = pg_fetch_assoc($rsConsulta);
                                        $meta           = $linhaConsulta['etapa_meta'];
                                        $etapaCodigo    = $linhaConsulta['etapa_codigo'];
                                        $etapaDescricao = $linhaConsulta['etapa_ds'];
                                        $idProjeto      = $linhaConsulta['projeto_id'];
                                        $idFonte        = $linhaConsulta['fonte_id'];
                                        $SaldoSuperior  = $linhaConsulta['saldo_superior_inicio'] - $linhaConsulta['saldo_superior'];
                                        $SaldoMedio     = $linhaConsulta['saldo_medio_inicio'] - $linhaConsulta['saldo_medio'];
                                        
                                        if($SaldoSuperior < 0)
                                        {
                                            $SaldoSuperior = $SaldoSuperior * (-1);
                                        }
                                        
                                        if($SaldoMedio < 0)
                                        {
                                            $SaldoMedio = $SaldoMedio * (-1);
                                        }
                                        
                                        $SaldoSuperior  = number_format($SaldoSuperior,2);
                                        $SaldoMedio     = number_format($SaldoMedio,2);                                    
                                    ?>                                    
                                    <table width="800" border="0" cellpadding="1" cellspacing="1" class="TabelaFormulario">
                                        <tr class="dataLabel">
                                            <td height="21" width="100">Meta</td>
                                            <td height="21" width="100">Código da Etapa</td>
                                            <td height="21" width="598">Descrição da Etapa</td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="21" width="100">
                                                <input type="text" id="txtMeta" name="txtMeta" style="width:90px; height:17px;" disabled value="<?=$meta?>" />
                                            </td> 
                                            <td height="21" width="100">
                                                <input type="text" id="txtCodigoEtapa" name="txtCodigoEtapa" style="width:90px; height:17px;" disabled value="<?=$etapaCodigo?>" />
                                            </td> 
                                            <td height="21" width="598">
                                                <input type="text" id="txtEtapa" name="txtEtapa" style="width:590px; height:17px;" disabled value="<?=$etapaDescricao?>" />
                                            </td>                                                
                                        </tr>
                                        <tr class="dataLabel">
                                            <td width="798" height="21" colspan="3">Projeto Vinculado à Etapa</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td width="798" height="21" colspan="3"><?=f_ComboProjeto($idProjeto, 'disabled')?></td>
                                        </tr>
                                        <tr class="dataLabel">
                                            <td width="798" height="21" colspan="3">Fonte Vinculada à Etapa</td>
                                        </tr>
                                        <tr class="dataField">
                                            <td width="798" height="21" colspan="3"><?=f_ComboFontes('cmbFonte','785',$idFonte,'disabled','114')?></td>
                                        </tr>
                                        <tr class="dataLabel">                                            
                                            <td width="200" height="21" colspan="2">Saldo Nível Superior</td>
                                            <td width="598" height="21">Saldo Nível Médio</td>                                            
                                        </tr>
                                        <tr class="dataField">  
                                            <td width="200" height="21" colspan="2">
                                                <input type="text" id="txtSaldoSuperior" name="txtSaldoSuperior" disabled style="width:120px; height:18px;" value="<?=$SaldoSuperior?>"/>
                                            </td>       
                                            <td width="598" height="21">
                                                <input type="text" id="txtSaldoMedio" name="txtSaldoMedio" disabled style="width:120px; height:18px;" value="<?=$SaldoMedio?>"/>
                                            </td>                                            
                                        </tr>
                                    </table>                                    
                                    <?php include "../Include/Inc_Linha.php";?>
                                    <table border="0" cellpadding="1" cellspacing="1" width="800">
                                        <tr>
                                            <td height="25" align="right">       
                                                 <?php
                                                if($_GET['acaoTitulo'] == 'Excluir')
                                                {
                                                    echo '<input type="button" style="width:70px" onclick="Javascript:GravarForm(document.Form);" name="btnExcluir" id="btnGravar" class="botao" value="Excluir"/>';
                                                }
                                                ?>
                                                <input type="button" style="width:70px" onclick="Javascript:window.location.href='EtapaInicio.php';" name="btnConsultar" class="botao" value="Voltar"/>
                                                <input type="hidden" id="etapa_id" name="etapa_id" value="<?=$_GET['etapa_id']?>"/>
                                           </td>
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