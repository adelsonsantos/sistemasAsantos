<?php
include "Classe/ClasseDiaria.php";
$iPageCurrent = 1;
$dataDia = date("d,m,Y");
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
        <script type="text/javascript" language="javascript" src="../JavaScript/jquery-1.7.1.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptFuncao.js"></script>
        <script type="text/javascript" language="javascript" src="../JavaScript/ScriptMenu.js"></script>          
        <script type="text/javascript" language="javascript" src="JavaScript/ScriptDiariaSaldoRecurso.js"></script>          
    </head>
<?php
//abre a janela da diaria recem comprovada para impressa
if(empty($_GET['imprimir'])== true)
{   
    echo '<body onLoad="Javascript:WM_initializeToolbar();repassaSaldo('.$dataDia.');">';
}
else
{   
    If ($_GET['imprimir'] == 1)
    {  
        $diariaRecebida = $_GET['cod'];    
        echo'<body onLoad="Javascript:WM_initializeToolbar();ImprimirDiaria('.$diariaRecebida.');repassaSaldo('.$dataDia.');">';    
    }
}
?>
        <form name="Form" method="post" action="">
            <table align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr><td><?php include "../Include/Inc_Topo.php"?></td></tr>
                <tr><td><?php include "../Include/Inc_Aba.php"?></td></tr>
                <tr>
                    <td align="left">
                        <table width="990" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td valign="top" align="left" width="190">                                    
                                    <?php include "../Include/Inc_Menu.php"?>
                                </td>
                                <td valign="top" align="left">
                                    <?php include "../Include/Inc_Titulo.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>
                                    <?php include "../Include/Inc_Pesquisa_Sem_Filtro.php"?>
                                    <?php include "../Include/Inc_Linha.php"?>         
                                    <table border="0" cellpadding="0" cellspacing="1" width="798" class="GridPaginacao">
                                        <tr class="GridPaginacaoCabecalho">                                            
                                        <?php                                                        
                                            if($linhaConsultaPermissao != '')
                                            {
                                                echo"<td height='20' colspan='12'><a href=\"SolicitacaoCadastrar.php?pagina=Solicitacao\"><font color=\"#000099\">Nova Solicita&ccedil;&atilde;o</font></a></td>";
                                            }
                                        ?>   
                                        </tr>
                                        <tr class="dataLabel">
                                            <td height="20" width="110" align="center" colspan="7">A&ccedil;&otilde;es</td>
                                            <td height="20" width="76" align="center">SD</td>
                                            <td height="20" width="218" align="left">Funcion&aacute;rio</td>
                                            <td height="20" width="99" align="center">Partida</td>
                                            <td height="20" width="99" align="center">Chegada</td>
                                            <td height="20" width="100" align="center">Processo</td>
                                            <td height="20" width="100" align="center">Status</td>
                                        </tr>
                                        <?php	
                                            //DADOS PARA A PAGINAÇÃO
                                            $paginaAtual        = (int)$_GET['PaginaMostrada'];                                                        
                                            $qtdRegistroPagina  = $iPageSize;
                                            $qtdRegistroTotal   = pg_num_rows($rsConsulta);
                                            $qtdIndice          = $paginaAtual * $qtdRegistroPagina;
                                            $qtdIndiceFinal     = (($qtdIndice + $qtdRegistroPagina)-1);
                                            $qtdPagina          = ($qtdRegistroTotal/$qtdRegistroPagina);
                                            $qtdPagina          = ceil($qtdPagina);

                                            while(($qtdIndice <= $qtdIndiceFinal) && ($qtdIndice < $qtdRegistroTotal))
                                            {                                                            
                                                $linhaDiaria      = pg_fetch_assoc($rsConsulta, $qtdIndice);
                                                //DADOS DA CONSULTA
                                                $codigoRegistro   = $linhaDiaria['diaria_id'];
                                                $numero           = $linhaDiaria['diaria_numero'];
                                                $dataPartida      = $linhaDiaria['diaria_dt_saida'];
                                                $horaPartida      = $linhaDiaria['diaria_hr_saida'];
                                                $dataChegada      = $linhaDiaria['diaria_dt_chegada'];
                                                $horaChegada      = $linhaDiaria['diaria_hr_chegada'];
                                                $processo         = $linhaDiaria['diaria_processo'];
                                                $status           = $linhaDiaria['diaria_st'];
                                                $nome             = $linhaDiaria['pessoa_nm'];
                                                $beneficiario     = $linhaDiaria['diaria_beneficiario'];                                                            
                                                $diariaAgrupada   = $linhaDiaria['diaria_agrupada'];
                                                $diariaDevolvida  = $linhaDiaria['diaria_devolvida'];
                                                $diariaCancelada  = $linhaDiaria['diaria_cancelada'];
                                                $diariaComprovada = $linhaDiaria['diaria_comprovada'];
                                                $diaria_Excluida  = $linhaDiaria['diaria_excluida'];
                                                $superSD          = $linhaDiaria['super_sd'];
                                                $diariaLocal      = $linhaDiaria['diaria_local_solicitacao'];

                                                if(strlen($nome)> 27){$nome = substr($nome, 0, 25).'...';}

                                                include "IncludeLocal/Inc_StatusDiaria.php";
                                                //var_dump($diariaDevolvida);
                                                if ($diariaAgrupada == 1) 
                                                {
                                                    $Numero = $superSD;
                                                }                                                          

                                                if($diariaDevolvida == "1")
                                                {
                                                    $sqlConsultaMotivoDevolucao = "SELECT diaria_devolucao_ds, 
                                                                                          m.motivo_ds,
                                                                                          tu.tipo_usuario_ds,
                                                                                          diaria_devolucao_dt
                                                                                     FROM diaria.diaria_devolucao d 
                                                                                     JOIN diaria.motivo m 
                                                                                       ON d.motivo_id = m.motivo_id
                                                                                     JOIN dados_unico.funcionario F 
                                                                                       ON F.funcionario_id = d.diaria_devolucao_func
                                                                                     JOIN seguranca.usuario U 
                                                                                       ON U.pessoa_id = F.pessoa_id
                                                                                     JOIN seguranca.usuario_tipo_usuario tp 
                                                                                       ON tp.pessoa_id = U.pessoa_id
                                                                                     JOIN seguranca.tipo_usuario tu 
                                                                                       ON tu.tipo_usuario_id = tp.tipo_usuario_id
                                                                                    WHERE diaria_id = ".$codigoRegistro."
                                                                                      AND tu.sistema_id = 2
                                                                                 ORDER BY diaria_devolucao_dt DESC LIMIT 1";                                                            
                                                    
                                                    $rsConsultaMotivoDevolucao = pg_query(abreConexao(), $sqlConsultaMotivoDevolucao);
                                                    $linhaMotivo = pg_fetch_assoc($rsConsultaMotivoDevolucao);

                                                    if ($linhaMotivo) 
                                                    {
                                                        if ($linhaMotivo['diaria_devolucao_ds'] != "") 
                                                        {
                                                            $labelDevolucao = $linhaMotivo['diaria_devolucao_ds'];
                                                        }
                                                        $motivoDevolucao  = $linhaMotivo['motivo_ds'];
                                                        $labelResponsavel = $linhaMotivo['tipo_usuario_ds'];
                                                        $dataDevolucao    = date("d-m-Y", strtotime($linhaMotivo['diaria_devolucao_dt']));
                                                    }
                                                }                                                                                                                                                                       
                                            echo "<tr class='dataField' onMouseOver=javascript:this.style.backgroundColor='#cccccc' onMouseOut=javascript:this.style.backgroundColor='#f2f2f2'>";
                                                include "IncludeLocal/Inc_RegistroDiarias.php";
                                                echo "<td height='20' align='center'>" . $numero . "</td>";
                                                echo "<td height='20' title='".$linhaDiaria['pessoa_nm']."' align='left'>".$nome."</td>";
                                                echo "<td height='20' align='center'>" . $dataPartida . " " . $horaPartida . "</td>";
                                                echo "<td height='20' align='center'>" . $dataChegada . " " . $horaChegada . "</td>";
                                                echo "<td height='20' align='center'>" . $processo . "</td>";                                                                                                             
                                                echo "<td height='20' align='center'><font color='#000099'>" . $StatusNome . "</font></td>";                                                        
                                            echo "</tr>";
                                            If ($diariaDevolvida == 1) 
                                            {  
                                                echo "<tr bgcolor='#f2f2f2'>";
                                                    echo "<td height='20' ><img src='../icones/ico_aviso.gif' alt='Alerta' border='0' title='Diária Devolvida'/></td>";
                                                    echo "<td height='20' colspan='6' align='left'><font color='##000099'>Devolvido Por:&nbsp;</font><font face='verdana' color='red'>" . $labelResponsavel . "</font></td>";
                                                    echo "<td height='20' colspan='5'><font color='#000099'>DATA: ".$dataDevolucao."&nbsp;&nbsp;&nbsp; MOTIVO: ".$motivoDevolucao. ": " . $labelDevolucao . "</font></td>";                                                    
                                                echo "</tr>";
                                            }
                                            $qtdIndice++;
                                        }
                                        $paginaAtual++;
                                        ?>
                                        <tr>
                                            <td colspan="12"><?php include "IncludeLocal/Inc_Paginacao.php"?></td>
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