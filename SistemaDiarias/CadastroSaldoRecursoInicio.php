<?php
include "Classe/ClasseSaldoRecurso.php";
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
                                    <?php include "IncludeLocal/Inc_PesquisaSaldoRecurso.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <div id="Lista">
                                        <table width="800" border="0" cellpadding="1" cellspacing="1" class="GridPaginacao">                                           
                                            <tr class="GridPaginacaoCabecalho">
                                                <td colspan="8" align="left">
                                                    <a href="SaldoRecursoCadastrar.php?acaoTitulo=Cadastrar" class="GridPaginacaoRegistroNumRegistro">Novo</a>
                                                </td>
                                            </tr>
                                            <tr class="dataLabel">
                                                <td height="20" width="80" colspan="3">&nbsp;</td>
                                                <td height="20" width="280">Projeto</td>                                                
                                                <td height="20" width="270">Fonte</td>
                                                <td height="20" width="85" align="center">Saldo Atual</td>
                                                <td height="20" width="85" align="center">Saldo Inicial</td>
                                                <td height="20" width="70" align="center">Mês</td>                                                                                                
                                            </tr>
                                            <?php 
                                            $paginaAtual        = (int) $_GET['PaginaMostrada'];
                                            $qtdRegistroPagina  = $iPageSize;
                                            $qtdRegistroTotal   = pg_num_rows($rsConsulta);
                                            $qtdIndice          = $paginaAtual * $qtdRegistroPagina;
                                            $qtdIndiceFinal     = (($qtdIndice + $qtdRegistroPagina)-1);
                                            $qtdPagina          = ($qtdRegistroTotal/$qtdRegistroPagina);
                                            $qtdPagina          = ceil($qtdPagina);

                                            While(($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal))
                                            {       
                                                $linha  = pg_fetch_assoc($rsConsulta,$qtdIndice);
                                                
                                                $codigo            = $linha['id_saldo'];
                                                $codigoProjeto     = $linha['id_saldo_projeto'];
                                                $projetoDs         = $linha['projeto_ds'];
                                                $codigoFonte       = trim($linha['id_saldo_fonte']);
                                                $fonteDs           = $linha['fonte_ds'];
                                                $saldo    	   = $linha['saldo_valor'];
                                                $saldoInicial	   = $linha['saldo_valor_inicial'];
                                                $mes    	   = $linha['saldo_mes'];                                               

                                                if(strlen($projetoDs)> 32){$projetoDs = substr($projetoDs, 0, 28).'...';}
                                                if(strlen($fonteDs)> 34){$fonteDs = substr($fonteDs, 0, 30).'...';}                                                

                                                echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                    echo "<td width='20' align='center'><a href='SaldoRecursoConsultar.php?codProjeto=".$codigoProjeto."&codFonte=".$codigoFonte."&acao=consultar&acaoTitulo=Consultar'><img src='../Icones/ico_consultar.png' alt='Consultar' border='0'></a></td>";
                                                    echo "<td width='20' align='center'><a href='SaldoRecursoCadastrar.php?codProjeto=".$codigoProjeto."&codFonte=".$codigoFonte."&acao=consultar&acaoTitulo=Editar'><img src='../Icones/ico_alterar.png' alt='Editar' border='0'/></a></td>";
                                                    echo "<td width='20' align='center'><a href='SaldoRecursoConsultar.php?codProjeto=".$codigoProjeto."&codFonte=".$codigoFonte."&acao=consultar&acaoTitulo=Excluir'><img src='../Icones/ico_excluir.png'  alt='Excluir' border='0'/></a></td>";
                                                    echo "<td height='20' title='".$linha['projeto_ds']."'>".$codigoProjeto." - ".$projetoDs."</td>";
                                                    echo "<td height='20' title='".$linha['fonte_ds']."'>".$codigoFonte." - ".$fonteDs."</td>";
                                                    echo "<td height='20' align='center'>R$ ".number_format($saldo,2)."</td>";
                                                    echo "<td height='20' align='center'>R$ ".number_format($saldoInicial,2)."</td>";
                                                    echo "<td height='20' align='center'>" .retornaMes($mes)."</td>";
                                                echo "</tr>";

                                                $qtdIndice++;
                                            }
                                            $paginaAtual++;
                                            ?>
                                            <tr>
                                                <td colspan="8"><?php include "../Include/Inc_Paginacao.php"?></td>
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
