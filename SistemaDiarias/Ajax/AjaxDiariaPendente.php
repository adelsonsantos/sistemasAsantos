<?php 
include "../../Include/Inc_Configuracao.php";

$beneficiario  = $_POST['beneficiario'];
$saldoPositivo = $_POST['tipoPositivo'];
$saldoNegativo = $_POST['tipoNegativo'];
$dataInicio    = $_POST['dataInicio'];
$dataFim       = $_POST['dataFim'];

if($beneficiario != '0')
{    
    if($saldoPositivo == 'true')
    {        
        $sqlConsulta = " SELECT funcionario_matricula, pessoa_nm, diaria_numero, diaria_comprovacao_valor, diaria_dt_saida, diaria_dt_chegada, diaria_valor, diaria_comprovacao_dt_saida, diaria_comprovacao_dt_chegada, diaria_comprovacao_saldo 
                           FROM diaria.diaria d 
                           JOIN diaria.diaria_comprovacao c ON d.diaria_id = c.diaria_id 
                           JOIN dados_unico.pessoa p ON diaria_solicitante = p.pessoa_id
                           JOIN dados_unico.funcionario f ON f.pessoa_id = p.pessoa_id
                          WHERE diaria_comprovada = 1 
                            AND diaria_excluida = 0
                            AND diaria_comprovacao_saldo_tipo = 'C' 
                            AND ( 
                                    (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) OVERLAPS (DATE '$dataInicio', DATE '$dataFim')
                                 OR 
                                    (
                                        (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim') 
                                     OR 
                                        (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim')
                                    )
                                )                          
                           AND diaria_solicitante = ".$beneficiario."
                           ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY')";
        
         $html = '<table cellpadding="1" cellspacing="1" width="800" border="0" class="GridPaginacao">
                    <tr class="dataLabel">
                        <td width="70" height="21" >Matricula</td>            
                        <td width="218" height="21" >Nome</td>            
                        <td width="70" height="21" >SD</td> 
                        <td width="90" height="21" >Valor da Diária</td>
                        <td width="90" height="21" >Valor à Receber</td>            
                        <td width="130" height="21" >Período Programado</td>                                    
                        <td width="130" height="21" >Período Comprovado</td>                                    
                    </tr>';
    }
    elseif($saldoNegativo == 'true')
    {
        $sqlConsulta = " SELECT funcionario_matricula, pessoa_nm, diaria_numero, diaria_comprovacao_valor, diaria_dt_saida, diaria_dt_chegada, diaria_valor, diaria_comprovacao_dt_saida, diaria_comprovacao_dt_chegada, diaria_comprovacao_saldo 
                           FROM diaria.diaria d 
                           JOIN diaria.diaria_comprovacao c ON d.diaria_id = c.diaria_id 
                           JOIN dados_unico.pessoa p ON diaria_solicitante = p.pessoa_id
                           JOIN dados_unico.funcionario f ON f.pessoa_id = p.pessoa_id
                          WHERE diaria_comprovada = 1 
                            AND diaria_excluida = 0
                            AND diaria_comprovacao_saldo_tipo = 'D' 
                            AND ( 
                                    (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) OVERLAPS (DATE '$dataInicio', DATE '$dataFim')
                                 OR 
                                    (
                                        (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim') 
                                     OR 
                                        (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim')
                                    )
                                )                          
                           AND diaria_solicitante = ".$beneficiario."
                           ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY')";
        
         $html = '<table cellpadding="1" cellspacing="1" width="800" border="0" class="GridPaginacao">
                    <tr class="dataLabel">
                        <td width="70" height="21" >Matricula</td>            
                        <td width="218" height="21" >Nome</td>            
                        <td width="70" height="21" >SD</td> 
                        <td width="90" height="21" >Valor da Diária</td>
                        <td width="90" height="21" >Valor à Pagar</td>            
                        <td width="130" height="21" >Período Programado</td>                                    
                        <td width="130" height="21" >Período Comprovado</td>                                  
                    </tr>';
    }
    
    $rsConsulta   = pg_query(abreConexao(),$sqlConsulta);      
    
             while($linhaConsulta = pg_fetch_assoc($rsConsulta))
             {
                 $nome = $linhaConsulta['pessoa_nm'];
                 if(strlen($nome)> 27){$nome = substr($nome, 0, 25).'...';}
                 
                 $html.='<tr class="dataField">
                            <td height="21" >'.$linhaConsulta['funcionario_matricula'].'</td>            
                            <td height="21" >'.$nome.'</td>            
                            <td height="21" >'.$linhaConsulta['diaria_numero'].'</td>            
                            <td height="21" >R$ '.number_format($linhaConsulta['diaria_comprovacao_valor'],2,',','.').'</td>            
                            <td height="21" >R$ '.number_format($linhaConsulta['diaria_comprovacao_saldo'],2,',','.').'</td>            
                            <td height="21" >'.$linhaConsulta['diaria_dt_saida'].' - '.$linhaConsulta['diaria_dt_chegada'].'</td>
                            <td height="21" >'.$linhaConsulta['diaria_comprovacao_dt_saida'].' - '.$linhaConsulta['diaria_comprovacao_dt_chegada'].'</td>
                        </tr height="21" >';           
             }
                
    $html .= '</table>';

}
else
{    
    $controle   = 0;
    $codigo     = '';
    $saldoTotal = 0;
    $pessoaNm   = '';
    $matricula  = '';
    
    if($_POST['tipoPositivo'] == 'true')
    {        
        $sqlConsulta = " SELECT p.pessoa_id, funcionario_matricula, pessoa_nm, diaria_numero, diaria_comprovacao_valor, diaria_dt_saida, diaria_dt_chegada, diaria_valor,diaria_comprovacao_saldo FROM diaria.diaria d 
                           JOIN diaria.diaria_comprovacao c ON d.diaria_id = c.diaria_id 
                           JOIN dados_unico.pessoa p ON diaria_solicitante = p.pessoa_id
                           JOIN dados_unico.funcionario f ON f.pessoa_id = p.pessoa_id
                          WHERE diaria_comprovada = 1 
                            AND diaria_excluida = 0
                            AND diaria_comprovacao_saldo_tipo = 'C'
                            AND ( 
                                    (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) OVERLAPS (DATE '$dataInicio', DATE '$dataFim')
                                 OR 
                                    (
                                        (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim') 
                                     OR 
                                        (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim')
                                    )
                                )
                           ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY')";
        
         $html = '<table cellpadding="1" cellspacing="1" width="800" border="0" class="GridPaginacao">
                    <tr class="dataLabel">
                        <td width="150" height="21" >Ações</td>
                        <td width="80" height="21" >Matrícula</td>            
                        <td width="388" height="21" >Nome</td>                                    
                        <td width="100" height="21" >Valor à Receber</td>
                        <td width="80" height="21" >Situação</td>
                    </tr>';
    }
    elseif($_POST['tipoNegativo'] == 'true')
    {
        $sqlConsulta = " SELECT p.pessoa_id,funcionario_matricula, pessoa_nm, diaria_numero, diaria_comprovacao_valor, diaria_dt_saida, diaria_dt_chegada, diaria_valor,diaria_comprovacao_saldo FROM diaria.diaria d 
                           JOIN diaria.diaria_comprovacao c ON d.diaria_id = c.diaria_id 
                           JOIN dados_unico.pessoa p ON diaria_solicitante = p.pessoa_id
                           JOIN dados_unico.funcionario f ON f.pessoa_id = p.pessoa_id
                          WHERE diaria_comprovada = 1 
                            AND diaria_excluida = 0
                            AND diaria_comprovacao_saldo_tipo = 'D'
                            AND ( 
                                    (TO_DATE(diaria_dt_saida,'DD/MM/YYYY'),TO_DATE(diaria_dt_chegada,'DD/MM/YYYY')) OVERLAPS (DATE '$dataInicio', DATE '$dataFim')
                                 OR 
                                    (
                                        (TO_DATE(diaria_dt_saida,'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim') 
                                     OR 
                                        (TO_DATE(diaria_dt_chegada,'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim')
                                    )
                                )                                                     
                           ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYYY')";
        
         $html = '<table cellpadding="1" cellspacing="1" width="800" border="0" class="GridPaginacao">
                    <tr class="dataLabel">
                        <td width="150" height="21" >Ações</td>
                        <td width="80" height="21" >Matrícula</td>            
                        <td width="388" height="21" >Nome</td>                                    
                        <td width="100" height="21" >Valor à Pagar</td>
                        <td width="80" height="21" >Situação</td>                                   
                    </tr>';
    }
        $rsConsulta   = pg_query(abreConexao(),$sqlConsulta); 
        $qtd          = pg_num_rows($rsConsulta);
    
        while($linhaConsulta = pg_fetch_assoc($rsConsulta))
        {
            $controle = $controle + 1;
            
            $sqlConsultaBloqueio = "SELECT * FROM diaria.diaria_bloqueio
                                    WHERE pessoa_id = ".$linhaConsulta['pessoa_id'];
            $rsConsultaBloqueio  = pg_query(abreConexao(),$sqlConsultaBloqueio);                   
            $linhaConsultaBloqueio = pg_fetch_assoc($rsConsultaBloqueio);
            
            if($linhaConsultaBloqueio != '')
            {
                $bloqueio = "<font color='#ff0000' id='".$linhaConsulta['pessoa_id']."'>Bloqueado</font>";
            }
            else
            {
                $bloqueio = "<font color='#065387' id='".$linhaConsulta['pessoa_id']."'>Liberado</font>";
            }
            
            if($codigo == '')
            {
                $codigo     = trim($linhaConsulta['pessoa_id']);
                $saldoTotal = (float)trim($linhaConsulta['diaria_comprovacao_saldo']);
                $pessoaNm   = trim($linhaConsulta['pessoa_nm']);
                $matricula  = trim($linhaConsulta['funcionario_matricula']);
                
                if($controle == $qtd)
                {                    
                    $html .='<tr class="dataField">
                            <td width="150" height="21" >À Definir</td>
                            <td height="21" >'.$matricula.'</td>            
                            <td height="21" >'.$pessoaNm.'</td>                                          
                            <td height="21" >R$ '.number_format($saldoTotal,2,',','.').'</td>                             
                            <td height="21" onclick="Javascript:BloqueiaPessoa('.$codigo.')">'.$bloqueio.'</td>
                           </tr height="21" >'; 
                }
            }
            elseif($codigo == trim($linhaConsulta['pessoa_id']))
            {
                $saldoTotal = $saldoTotal + (float)trim($linhaConsulta['diaria_comprovacao_saldo']);
                
                if($controle == $qtd)
                {
                    $html .='<tr class="dataField">
                            <td width="150" height="21" >À Definir</td>
                            <td height="21" >'.$matricula.'</td>            
                            <td height="21" >'.$pessoaNm.'</td>                                          
                            <td height="21" >R$ '.number_format($saldoTotal,2,',','.').'</td>                                                                       
                            <td height="21" onclick="Javascript:BloqueiaPessoa('.$codigo.')">'.$bloqueio.'</td>
                           </tr height="21" >'; 
                }
            }
            elseif($codigo != trim($linhaConsulta['pessoa_id']))
            {                                
                $html .='<tr class="dataField">
                        <td width="150" height="21" >À Definir</td>
                        <td height="21" >'.$matricula.'</td>            
                        <td height="21" >'.$pessoaNm.'</td>                                          
                        <td height="21" >R$ '.number_format($saldoTotal,2,',','.').'</td>                                           
                        <td height="21" onclick="Javascript:BloqueiaPessoa('.$codigo.')">'.$bloqueio.'</td>
                       </tr height="21" >'; 
                
                $codigo     = trim($linhaConsulta['pessoa_id']);
                $saldoTotal = (float)trim($linhaConsulta['diaria_comprovacao_saldo']);
                $pessoaNm   = trim($linhaConsulta['pessoa_nm']);
                $matricula  = trim($linhaConsulta['funcionario_matricula']);
                
                if($controle == $qtd)
                {
                    $html .='<tr class="dataField">
                            <td width="150" height="21" >À Definir</td>
                            <td height="21" >'.$matricula.'</td>            
                            <td height="21" >'.$pessoaNm.'</td>                                          
                            <td height="21" >R$ '.number_format($saldoTotal,2,',','.').'</td>                                                                       
                            <td height="21" onclick="Javascript:BloqueiaPessoa('.$codigo.')">'.$bloqueio.'</td>                            
                           </tr height="21" >'; 
                }
            }                      
        }
                
    $html .= '</table>';
}

echo $html;
?>
