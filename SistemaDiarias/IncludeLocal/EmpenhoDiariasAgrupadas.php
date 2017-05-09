<?php														
$sql_SuperSD = "SELECT super_sd 
                  FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p
                 WHERE (p.pessoa_id = f.pessoa_id) 
                   AND (d.diaria_beneficiario = f.pessoa_id) 
                   AND diaria_st IN (2,6) 
                   AND diaria_cancelada = 0 
                   AND super_sd = super_sd 
                   AND diaria_agrupada = 1 
              GROUP BY super_sd";

$Consulta_SuperSD = pg_query(abreConexao(),$sql_SuperSD);

while($tupla=pg_fetch_assoc($Consulta_SuperSD)) 
{		
    $Super_SD = $tupla['super_sd']; 

    $sql = "SELECT * 
              FROM diaria.diaria d, 
                   dados_unico.funcionario f, 
                   dados_unico.pessoa p
             WHERE (p.pessoa_id = f.pessoa_id) 
               AND (d.diaria_beneficiario = f.pessoa_id) 
               AND diaria_st IN (2,6) 
               AND diaria_cancelada = 0 
               AND super_sd = '$Super_SD' 
               AND diaria_agrupada = 1 
             LIMIT 1";			

    $Consulta = pg_query(abreConexao(),$sql);

    while($tupla=pg_fetch_assoc($Consulta))
    {					

        $Diaria_ID                  = $tupla['diaria_id'];
        $Diaria_Super_SD            = $tupla['super_sd'];
        $Numero_Diaria              = $tupla['diaria_numero'];
        $NomeBeneficiario           = $tupla['pessoa_nm'];
        $Diaria_DataPartida         = $tupla['diaria_dt_saida'];
        $Diaria_HoraPartida         = $tupla['diaria_hr_saida'];
        $DataChegada                = $tupla['diaria_dt_chegada'];
        $Diaria_DataDaSolicitacao   = $tupla['diaria_dt_criacao'];
        $Diaria_HoraDaSolicitacao   = $tupla['diaria_hr_criacao'];
        $HoraChegada                = $tupla['diaria_hr_chegada'];
        $Status_Diaria              = $tupla['diaria_st'];
        $Beneficiario               = $tupla['diaria_beneficiario'];
        $Processo		    = $tupla['diaria_processo'];
        $Empenho		    = $tupla['diaria_empenho'];
        $Devolvida		    = $tupla['diaria_devolvida'];
        $Indenizacao                = $tupla['indenizacao'];
        $Convenio		    = $tupla['convenio_id'];
        $ExtratoEmpenho             = $tupla['diaria_extrato_empenho'];	
        $diaria_agrupada            = $tupla['diaria_agrupada'];	

        if ($Status_Diaria == 2)
        {
            echo "<tr height='20' bgcolor='#228B22' class='GridPaginacaoLink'>";
                /* if ($ExtratoEmpenho == 1){echo "<td width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Diaria_ID." checked></td>";}
                 * else{echo "<td width='15' align='center'><input type='checkbox' class='checkbox' name='checkbox' value= ".$Diaria_ID." DISABLED></td>";}*/
            echo "<td width='15' align='center'><input type='checkbox' class='checkbox' name='checkboxAgrupada' value= ".$Diaria_ID." DISABLED></td>";					
            echo "<td align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" .$Diaria_ID."&pagina=SolicitacaoGestao'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";
            echo "<td align='center'><a href='SolicitacaoEmpenhar.php?cod=" .$Diaria_ID. "&acao=consultar&pagina=SolicitacaoGestao'><img src='../Icones/ico_comprovar.png' border='0' alt='Empenhar'></a></td>";

            if(($Processo != "") && ($Empenho!=""))
            {
                echo "<td align='center'><a href='javascript:ImprimirDiariasAgrupadas(" .$Diaria_Super_SD. ");'><img src='../Icones/ico_imprimir.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>";
            }
            else
            {
                echo "<td align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>";
            }

            if(($Processo != "") && ($Empenho!="")) 
            {
                echo "<td align='center'><a href='javascript:ImprimirProcessoDiariasAgrupadas(" .$Diaria_Super_SD. ");'><img src='../Icones/ico_imprimir_processo.png' border='0' alt='Imprimir Processo'></a></td>";
            }
            else
            {
                echo "<td align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'></a></td>";
            }
            if (($StatusNome == "Devolvida (Comprovada) " )  &&  ($Status_Diaria == 2))
            {
                echo "<td align='center'><img src='../icones/ico_devolver_offG.png' alt='Devolver' border='0'></td>";
            }
            else
            {
                echo "<td align='center'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'></td>";
            }
            if($Empenho=="")
            {
                echo "<td align='center'><img src='../icones/ico_aceitar_off.png' alt='Liberar Empenho' border='0'></td>";
            }
            else
            {
                echo "<td align='center'><a href='javascript:LiberarEmpenho(" .$Diaria_ID. ");'><img src='../Icones/ico_aceitar.png' border='0' alt='Liberar Empenho'></a></td>";
            }
            echo "<td align='center'>".$Diaria_Super_SD."</td>";
            echo "<td>&nbsp;" .$NomeBeneficiario."</a></td>";
            echo "<td align='center'>".f_FormataData($Diaria_DataDaSolicitacao)." &agrave;s ".$Diaria_HoraDaSolicitacao."</td>";
            echo "<td align='center'>".$Diaria_DataPartida." &agrave;s ".$Diaria_HoraPartida."</td>";
            echo "<td align='center'>";
        }
        else
        { // DIARIO NO SEGUNDO EMPENHO.
            echo "<tr height='20' bgcolor='#228B22' class='GridPaginacaoLink'>";
            if ($ExtratoEmpenho == 1)
            {
                echo "<td width='15' align='center'><input type='checkbox' class='checkbox' name='checkboxAgrupada' value= ".$Diaria_ID." checked></td>";
            }
            else
            {
                echo "<td width='15' align='center'><input type='checkbox' class='checkbox' name='checkboxAgrupada' value= ".$Diaria_ID."></td>";
            }
            echo "<td align='center'><a href='SolicitacaoConsultar.php?acao=consultar&cod=" .$Diaria_ID."&pagina=SolicitacaoGestao'><img src='../Icones/ico_consultar.png' border='0' alt='Consultar'></a></td>";
            echo "<td align='center'><a href='SolicitacaoEmpenhar.php?cod=" .$Diaria_ID. "&acao=consultar&pagina=SolicitacaoGestao'><img src='../Icones/ico_comprovar.png' border='0' alt='Empenhar'></a></td>";
            echo "<td align='center'><img src='../Icones/ico_imprimir_off.png' border='0' alt='Imprimir Solicita&ccedil;&atilde;o'></a></td>";
            echo "<td align='center'><img src='../Icones/ico_imprimir_processo_off.png' border='0' alt='Imprimir Processo'></a></td>";
            if (($StatusNome == "Devolvida (Comprovada) " )  &&  ($Status_Diaria == 6))
            {
                echo "<td align='center'><img src='../icones/ico_devolver_offG.png' alt='Devolver' border='0'></td>";
            }
            else
            {
                echo "<td align='center'><img src='../Icones/ico_devolver.png' border='0' alt='Devolver'></td>";
            }
            if($Empenho=="")
            {
                echo "<td align='center'><img src='../icones/ico_aceitar_off.png' alt='Liberar Empenho' border='0'></td>";
            }
            else
            {
                echo "<td align='center'><a href='javascript:LiberarSegundoEmpenho(" .$Diaria_ID. ");'><img src='../Icones/ico_aceitar.png' border='0' alt='Liberar Empenho'></a></td>";
            }
            echo "<td align='center'><font color='#CC9933'>".$Diaria_Super_SD."</font></td>";
            echo "<td>&nbsp;<font color='#CC9933'>" .$NomeBeneficiario."</font></a></td>";
            echo "<td align='center'><font color='#CC9933'>".f_FormataData($Diaria_DataDaSolicitacao)." &agrave;s ".$Diaria_HoraDaSolicitacao."</font></td>";
            echo "<td align='center'><font color='#CC9933'>".$Diaria_DataPartida." &agrave;s ".$Diaria_HoraPartida."</font></td>";
            echo "<td align='center'>";
        }

        if ($Indenizacao == 0)
        {
            if ($Convenio == 0)
            {
                if ($Status_Diaria == 2)
                {
                    echo "N-1";
                }
                else
                {
                    echo "<font color='#CC9933'>N-2</font>";
                }
            }
            else
            {
                if ($Status_Diaria == 2)
                {
                    echo "C-1";
                }
                else
                {
                    echo "<font color='#CC9933'>C-2</font>";
                }
            }
        }
        else
        {
            if ($Status_Diaria ==2)
            {
                echo "I";
            }
            else
            {
                echo "<font color='#CC9933'>I-2</font>";
            }
        }
        if($diaria_agrupada == 1)
        {
            echo "<td align='center'>SIM</td>";
        }
        else
        {
            echo "<td align='center'>NÃO</td>";														
        }
        if($Empenho =="")
        { // Liberar todos os empenhos de uma vez
            echo "<td width='100' align='center'><input type='checkbox' class='check' name='checkboxAgrupada' DISABLED></td>";
        }
        else
        {
            echo "<td width='100' align='center'><input type='checkbox' class='check' name='checkboxAgrupada'  DISABLED></td>";
        }

        echo "</td>";
        echo "</tr>";
        if (($StatusNome == "Devolvida") || ($StatusNome == "Devolvida (Comprovada) " )  &&  ($Status_Diaria == 2)) 
        {
            echo "<tr height='20' bgcolor='#f2f2f2'>";
                echo "<td class='GridPaginacaoLink'><img src='../icones/ico_aviso.gif' alt='Alerta' border='0'></td>";
                echo "<td class='GridPaginacaoLink' colspan='7'><font color='#ff0000'>&nbsp;".$MotivoDevolucao.": ".$labelDevolucao."</font></td>";
                echo "<td></td>";
                echo "<td></td>";
            echo "</tr>";
        }
        If($ContadorVirtual > 1)
        {
            echo "<tr height='21'><td colspan='14' class='dataField'>Beneficiario com Diaria comprovada e pendente de documenta&ccedil;&atilde;o - ".$NumeroDiariaVirtual."</td></tr>";
        }
        If($ContadorAtraso > 0)
        {
            echo "<tr height='21'><td colspan='14' class='dataField'>Beneficiario que n&atilde;o fez comprova&ccedil;&atilde;o - ".$NumeroDiariaAtrasada."</td></tr>";
        }        
    } 
}
?>														
