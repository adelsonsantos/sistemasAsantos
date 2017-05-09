<?php
include "../Include/Inc_Configuracao.php";

$inicio = explode("/", $_POST["dataPartida"]);
$fim    = explode("/", $_POST["dataChegada"]);

$mkDataInicio = mktime(0, 0, 0, $inicio[1], $inicio[0], $inicio[2]);
$mkDataFim    = mktime(0, 0, 0, $fim[1], $fim[0], $fim[2]);

$diaFeriado = 0;

$sqlFeriado = "SELECT * FROM dados_unico.feriado WHERE (feriado_tipo = 0 OR feriado_tipo = 1) ORDER BY feriado_mes, feriado_dia";         

$dataInicio = date('d/m/Y',$mkDataInicio);
$dataFim    = date('d/m/Y',$mkDataFim);

while($mkDataInicio <= $mkDataFim)
{
    $rsFeriado  = pg_query(abreConexao(),$sqlFeriado); 
     
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
    $mkDataInicio = mktime(0, 0, 0, $inicio[1], $inicio[0]+1, $inicio[2]);  
    $dataInicio   = date('d/m/Y',$mkDataInicio);        
    $inicio       = explode("/", $dataInicio);  
    $linhaFeriado = '';    
} 

if($diaFeriado > 0)
{	
    echo "true";	
}
else
{
    echo "false";
}
?>