<?php
$numCodigoAcao = $_GET['id'];	
if($numCodigoAcao != "" )
{ 
    $sqlTitulo = "SELECT  acao_ds, 
                          secao_ds 
                    FROM  seguranca.acao a, 
                          seguranca.secao s 
                   WHERE (s.secao_id = a.secao_id) 
                     AND  acao_id = ".$numCodigoAcao;
    $rsTitulo  = pg_query(abreConexao(),$sqlTitulo);
    $linha 	   = pg_fetch_assoc($rsTitulo);
    $_SESSION["Titulo"]    = $linha['secao_ds'];
    $_SESSION["SubTitulo"] = $linha['acao_ds'];
    $_SESSION['acaoCodigo'] = $_GET['id'];
}
?>
<table cellpadding="2" cellspacing="2" border="0" width="800" class="TabModulo">
<tr>
<?php if(isset($_GET["acaoTitulo"])){ ?>
    <td align="left" class="titulo_pagina">&nbsp;<?=$_SESSION["Titulo"]?> \ <?=$_SESSION["SubTitulo"]?> \ <?=$_GET["acaoTitulo"]?></td> 
<?php }else{ ?>
    <td align="left" class="titulo_pagina">&nbsp;<?=$_SESSION["Titulo"]?> \ <?=$_SESSION["SubTitulo"]?></td>
<?php } 

if ($_SESSION['Sistema']==3)	
{	if ((($_SESSION["Titulo"] == "Permiss&otilde;es") && ($_SESSION["SubTitulo"] == "Associar Autorizador por ACP")) || (($_SESSION["Titulo"] == "Permiss&otilde;es") && ($_SESSION["SubTitulo"] == "Motorista Tempor&aacute;rio")))
        {?>
                    <td width="20" align="right">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="right"><a href='Javascript:window.location.href="../SistemaTransporte/Index.php?sistema=3";'><img src='../Imagens/voltar.gif' border='0'/></a></td>
                                <td width="21" align="left"><a href='Javascript:window.location.href="../SistemaTransporte/Index.php?sistema=3";' class="Voltarlink">Voltar</a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
        </table>
  <?php }// segundo if dentro do primeiro if     
        else 
        {	if (($_SESSION['acaoCodigo'] ==51)||($_SESSION['acaoCodigo'] ==46)||($_SESSION['acaoCodigo'] ==58)||($_SESSION['acaoCodigo'] ==57))
                { ?>				
                            <td width="20" align="right">
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="right"><a href="Javascript:history.back(0)"><img src="../Imagens/refresh.gif" border="0"/></a></td>
                                        <td width="21" align="left"><a href="Javascript:history.go(0)" class="Voltarlink">Refresh</a></td>
                                        <td align="right"><a href='Javascript:window.location.href="<?=$PaginaLocal?>Inicio.php";'><img src='../Imagens/voltar.gif' border="0"/></a></td>
                                        <td width="21" align="left"><a href='Javascript:window.location.href="<?=$PaginaLocal?>Inicio.php";' class='Voltarlink'>Voltar</a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
        <?php	}//terceiro if
                else 
                { ?>
                            <td width="20" align="right">
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="right"><a href="Javascript:history.back(0)"><img src="../Imagens/refresh.gif" border="0"/></a></td>
                                        <td width="21" align="left"><a href="Javascript:history.go(0)" class="Voltarlink">Refresh&nbsp;</a></td>
                                        <td align="right"><a href='Javascript:history.back(-1)'><img src='../Imagens/voltar.gif' border="0"/></a></td>
                                        <td width="21" align="left"><a href='Javascript:history.back(-1)' class='Voltarlink'>Voltar</a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
    <?php	}//segundo else
        } //else do segundo if
}//primeiro if
else 
{?>	
            <td width="20" align="right">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="right"><a href="Javascript:history.back(0)"><img src="../Imagens/refresh.gif" border="0"/></a></td>
                        <td width="21" align="left"><a href="Javascript:history.go(0)" class="Voltarlink">Refresh</a></td>
                        <td align="right"><a href='Javascript:history.back(-1)'><img src='../Imagens/voltar.gif' border="0"/></a></td>
                        <td width="21" align="left"><a href='Javascript:history.back(-1)' class='Voltarlink'>Voltar</a></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php }?>