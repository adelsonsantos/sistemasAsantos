<?php
include "../Include/Inc_Configuracao.php";
include "fpdf.php";

function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}


function diasUteis($dataSaida,$dataChegada,$horaSaida,$horaChegada)
{
    $diasUteis = 0;
    //Remove as barras das datas e separa dia, mês e ano em um array.
    $inicio = explode("/", $dataSaida);
    $fim    = explode("/", $dataChegada);
    
    //Converte as datas para um formato calculavel 
    //Verifica se as horas de saida e chegada são suficientes para realizar um desconto de Ticket Refeição       
    if($horaSaida < '11:59')
    {        
        $mkDataInicio = mktime(0, 0, 0, $inicio[1], $inicio[0], $inicio[2]);
    }
    else
    {        
        $mkDataInicio = mktime(0, 0, 0, $inicio[1], $inicio[0]+1, $inicio[2]);        
    }
    
    if($horaChegada > '12:00')
    {
        $mkDataFim = mktime(0, 0, 0, $fim[1], $fim[0], $fim[2]);
    }
    else
    {        
        $mkDataFim = mktime(0, 0, 0, $fim[1], $fim[0]-1, $fim[2]);           
    }    
     
    $diaFeriado = 0;
    $sqlFeriado = "SELECT * FROM dados_unico.feriado WHERE (feriado_tipo = 0 OR feriado_tipo = 1) ORDER BY feriado_mes, feriado_dia";         
    
    $dataInicio = date('d/m/Y',$mkDataInicio);
    $inicio     = explode("/", $dataInicio);
    $dataFim    = date('d/m/Y',$mkDataFim);
    $fim        = explode("/", $dataFim);    
    
    if($mkDataInicio < $mkDataFim)
    {
        //Cria um laço de repetição até que a dataInicio seja maior que a dataFim.
        while($mkDataInicio <= $mkDataFim)
        {           
            $rsFeriado  = pg_query(abreConexao(),$sqlFeriado);   
            $dia_semana = date("w", $mkDataInicio);
            //Verifica se existe feriado
            while($linhaFeriado = pg_fetch_assoc($rsFeriado))
            {       
                if($linhaFeriado['feriado_dia'] < 10){$feriadoDia = '0'.$linhaFeriado['feriado_dia'];}else{$feriadoDia = $linhaFeriado['feriado_dia'];}
                if($linhaFeriado['feriado_mes'] < 10){$feriadoMes = '0'.$linhaFeriado['feriado_mes'];}else{$feriadoMes = $linhaFeriado['feriado_mes'];}

                $feriado = $feriadoDia.'/'.$feriadoMes;

                if($feriado == substr($dataInicio,0,5))
                {
                    $diaFeriado = 1;
                }
            }
            //Verifica se o dia em questão é um domingo ou um sábado
            if(($dia_semana != 0)&&($dia_semana != 6))
            {            
                //calcula total de dias uteis
                $diasUteis = $diasUteis +1;
            } 
            
            //Soma um dia a data em questão        
            $mkDataInicio = mktime(0, 0, 0, $inicio[1], $inicio[0]+1, $inicio[2]);  
            $dataInicio   = date('d/m/Y',$mkDataInicio);        
            $inicio       = explode("/", $dataInicio);  
            $linhaFeriado = '';
        }
    }
    else
    {
        //Verifica se existe feriado
        $rsFeriado  = pg_query(abreConexao(),$sqlFeriado);   
        while($linhaFeriado = pg_fetch_assoc($rsFeriado))
        {
            if($linhaFeriado['feriado_dia'] < 10){$feriadoDia = '0'.$linhaFeriado['feriado_dia'];}
            if($linhaFeriado['feriado_mes'] < 10){$feriadoMes = '0'.$linhaFeriado['feriado_mes'];}
            
            $feriado = $feriadoDia.'/'.$feriadoMes;
            
            if(($feriado == substr($dataInicio,0,5))OR($feriado == substr($dataFim,0,5)))
            {
                $diaFeriado = 1;
            }
        }
        
        $hSaida   = explode(":", $horaSaida);
        $hChegada = explode(":", $horaChegada); 
        $dInicio  = explode("/", $dataSaida);
        $dFim     = explode("/", $dataChegada);
                
        $data1   = ($dInicio[2].'-'.$dInicio[1].'-'.$dInicio[0].' '.$hSaida[0].':'.$hSaida[1].':00');
        $data2   = ($dFim[2].'-'.$dFim[1].'-'.$dFim[0].' '.$hChegada[0].':'.$hChegada[1].':00');
        
        $unix_data1 = strtotime($data1);
        $unix_data2 = strtotime($data2);        
        $nHoras     = ($unix_data2 - $unix_data1) / 3600;
        $nMinutos   = (($unix_data2 - $unix_data1) % 3600) / 60;
        $nHoras     = (int)$nHoras;
        
        $resultado  = $nHoras.':'.$nMinutos;
                
        if($resultado > '12:00')
        {
            $diasUteis = 1;
        }      
    }
    $diasUteis = $diasUteis - $diaFeriado;
    return $diasUteis;
}

function status($stBd)
{
    switch ($stBd) 
    {    
    case 0:
       return  'Autorização';
        break;
    case 1:
        return 'Aprovação';
        break;
    case 2:
        return 'Execução';
        break;
    case 3:
        return 'Empenho';
        break;
    case 4:
        return 'Comprovação';
        break;
    case 5:
        return 'Aprovação Comprovação';
        break;
    case 6:
        return 'Aguardando Arquivamento';
        break;
    case 7:
        return 'Arquivada';
        break;
    default:
       return "";
    }
}
?>
