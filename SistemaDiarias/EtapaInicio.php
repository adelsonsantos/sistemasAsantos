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
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
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
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190"><?php include "../Include/Inc_Menu.php"?></td>
                                <td valign="top" align="left">
                                    <?php include "../Include/Inc_Titulo.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <?php// include "IncludeLocal/Inc_PesquisaSaldoRecurso.php"?>
                                    <?php// include "../Include/Inc_Linha.php"?>
                                    <div id="Lista">
                                        <table width="800" border="0" cellpadding="1" cellspacing="1" class="GridPaginacao">                                           
                                            <tr class="GridPaginacaoCabecalhoBorda">
                                                <td colspan="6" align="left">
                                                    <a href="EtapaCadastrar.php?acaoTitulo=Cadastrar" class="GridPaginacaoRegistroNumRegistro">Novo</a>
                                                </td>    
                                                <td colspan="3" align="center" bgcolor="#D4D4D4">Nível Superior</td>
                                                <td colspan="3" align="center" bgcolor="#DFDFDF">Nível Médio</td>
                                            </tr>
                                            <tr class="dataLabel">
                                                <td height="20" width="80" colspan="3">&nbsp;</td>
                                                <td height="20" width="50" align='center'>Etapa</td> 
                                                <td height="20" width="50" align='center'>Projeto</td>                                                
                                                <td height="20" width="50" align='center'>Fonte</td>
                                                <td height="20" width="105" align="center" bgcolor="#D4D4D4">Disponibilizado</td>
                                                <td height="20" width="90" align="center" bgcolor="#D4D4D4">Utilizado</td>
                                                <td height="20" width="90" align="center" bgcolor="#D4D4D4">Saldo</td>
                                                <td height="20" width="105" align="center" bgcolor="#DFDFDF">Disponibilizado</td> 
                                                <td height="20" width="90" align="center" bgcolor="#DFDFDF">Utilizado</td>
                                                <td height="20" width="90" align="center" bgcolor="#DFDFDF">Saldo</td>                                                                                                
                                            </tr>
                                            <?php
                                            $paginaAtual        = (int) $_GET['PaginaMostrada'];
                                            $qtdRegistroPagina  = 20;
                                            $qtdRegistroTotal   = pg_num_rows($rsConsulta);
                                            $qtdIndice          = $paginaAtual * $qtdRegistroPagina;
                                            $qtdIndiceFinal     = (($qtdIndice + $qtdRegistroPagina)-1);
                                            $qtdPagina          = ($qtdRegistroTotal/$qtdRegistroPagina);
                                            $qtdPagina          = ceil($qtdPagina);

                                            While(($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal))
                                            {       
                                                $linha  = pg_fetch_assoc($rsConsulta,$qtdIndice);
                                                
                                                $etapaId                = $linha['etapa_id'];
                                                $etapaCodigo            = $linha['etapa_codigo'];
                                                $etapaDescricao         = $linha['etapa_ds'];
                                                $idProjeto              = $linha['projeto_id'];
                                                $projetoDs              = $linha['projeto_ds'];
                                                $idFonte                = $linha['fonte_id'];
                                                $fonteDs                = $linha['fonte_ds'];
                                                $saldoNivelSuperior     = $linha['saldo_superior_inicio'];
                                                $saldoNivelmedio        = $linha['saldo_medio_inicio'];  
                                                $saldoSuperiorUtilizado = $linha['saldo_superior'];
                                                $saldoMedioUtilizado    = $linha['saldo_medio'];
                                                $SaldoSuperiorAtual     = $linha['saldo_superior_inicio'] - $linha['saldo_superior'];
                                                $SaldoMedioAtual        = $linha['saldo_medio_inicio'] - $linha['saldo_medio'];

                                                if($SaldoSuperiorAtual < 0)
                                                {
                                                    $SaldoSuperiorAtual = $SaldoSuperiorAtual * (-1);
                                                }

                                                if($saldoMedioAtual < 0)
                                                {
                                                    $SaldoMedioAtual = $SaldoMedioAtual * (-1);
                                                }                                                                                                                                          

                                                echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                    echo "<td width='20' align='center'><a href='EtapaConsultar.php?etapa_id=".$etapaId."&acao=consultar&acaoTitulo=Consultar'><img src='../Icones/ico_consultar.png' alt='Consultar' border='0'></a></td>";
                                                    echo "<td width='20' align='center'><a href='EtapaCadastrar.php?etapa_id=".$etapaId."&acao=consultar&acaoTitulo=Editar'><img src='../Icones/ico_alterar.png' alt='Editar' border='0'/></a></td>";
                                                    echo "<td width='20' align='center'><a href='EtapaConsultar.php?etapa_id=".$etapaId."&acao=consultar&acaoTitulo=Excluir'><img src='../Icones/ico_excluir.png'  alt='Excluir' border='0'/></a></td>";
                                                    echo "<td height='20' align='center' title='".trim($linha['etapa_ds'])."'>".$etapaCodigo."</td>";
                                                    echo "<td height='20' align='center' title='".$linha['projeto_ds']."'>".$idProjeto."</td>";
                                                    echo "<td height='20' align='center' title='".$linha['fonte_ds']."'>".$idFonte."</td>";
                                                    echo "<td height='20' align='center'>R$ ".number_format($saldoNivelSuperior,2)."</td>";
                                                    echo "<td height='20' align='center'>R$ ".number_format($saldoSuperiorUtilizado,2)."</td>";
                                                    echo "<td height='20' align='center'>R$ ".number_format($SaldoSuperiorAtual,2)."</td>";
                                                    echo "<td height='20' align='center'>R$ ".number_format($saldoNivelmedio,2)."</td>";
                                                    echo "<td height='20' align='center'>R$ ".number_format($saldoMedioUtilizado,2)."</td>";
                                                    echo "<td height='20' align='center'>R$ ".number_format($SaldoMedioAtual,2)."</td>";                                                                                                                                                              
                                                echo "</tr>";

                                                $qtdIndice++;
                                            }
                                            $paginaAtual++;
                                            ?>
                                            <tr>
                                                <td colspan="12"><?php include "../Include/Inc_Paginacao.php"?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
