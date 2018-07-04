<?php
include "../../Include/Inc_Configuracao.php";

$controle      = $_POST['controle'];
$totalRoteiros = $_POST['totalRoterios'];

if($controle == '')
{
    $cont = 0;
}
else 
{
    $cont = $controle;
}

$_SESSION['DataPartida'][$cont]     = "";
$_SESSION['HoraPartida'][$cont]     = "";
$_SESSION['DataChegada'][$cont]     = "";
$_SESSION['HoraChegada'][$cont]     = "";
$_SESSION['PossuiFimSemana'][$cont] = "";
$_SESSION['PossuiFeriado'][$cont]   = "";

$HoraPartida        = $_POST['horasaida'];
$HoraChegada        = $_POST['horachegada'];
$DataPartida        = $_POST['datasaida'];
$DataChegada        = $_POST['datachegada'];
$ValorReferencia    = str_replace(",",".",$_POST['valor']);
$Desconto           = $_POST['desconto'];
$PercentualRecebido = str_replace(",",".",$_POST['perc']);
$diariaValorOld     = str_replace(",",".",$_POST['valorOld']);
$dataSolicitada     = $_POST['dataSolicitacao'];

$_SESSION['DataPartida'][$cont] = $DataPartida;
$_SESSION['HoraPartida'][$cont] = $HoraPartida;
$_SESSION['DataChegada'][$cont] = $DataChegada;
$_SESSION['HoraChegada'][$cont] = $HoraChegada;

If (($_SESSION['PercentualRecebido'][$cont] == $PercentualRecebido) || ($_SESSION['PercentualRecebido'][$cont] == ""))
{    
    //calcula a diferenca entre as horas
    // Divide a hora
    $HoraP = explode(":",$HoraPartida); //hora de partida 
    $HoraC = explode(":",$HoraChegada);// hora de chegada

    // Divide a data
    $DataP = explode("/", $DataPartida);
    $DataC = explode("/", $DataChegada);

    // Transforma em segundo
    $MinutoPartida = mktime($HoraP[0], $HoraP[1], "00", $DataP[1], $DataP[0], $DataP[2]);
    $MinutoChegada = mktime($HoraC[0], $HoraC[1], "00", $DataC[1], $DataC[0], $DataC[2]);

//                var_dump($MinutoPartida);
//                var_dump($MinutoChegada);
//                exit;
    // Transforma os segundos em minutos
    $difMinutos = ($MinutoChegada - $MinutoPartida)/60;

    // Diferen�a em dias
    //qntidade de dias.
    $difDias = $difMinutos/1440;		 

    // Trunca o numero de dias .. 
    $NumeroDia = intval($difDias);

    $DiariaResto = $difMinutos - (1440*$NumeroDia);
    
    //Data da solicitação da Diária.
    $dataS = explode("/", $dataSolicitada);  
    $minutoSolicitada = mktime("00", "00", "00", $dataS[1], $dataS[0], $dataS[2]);
    //Data da alteração do decreto.
    $dataR = explode("/", "24/07/2015");
    $minutoReferencia = mktime("00", "00", "00", $dataR[1], $dataR[0], $dataR[2]);
    
    if($minutoSolicitada > $minutoReferencia)
    {        
        //Alteração 24 de julho 2015 decreto Nº 16.220
        if($DiariaResto > 600) //Se o período for maior do que 10:00 horas
        {
            $Percentual = ".5";
        }
        Else	//se horas menor que 10:00 ou igual a 24:00
        {
            $Percentual = "";
        }
    }
    else
    {
        If (($DiariaResto > 360) && ($DiariaResto <= 720)) //se horas entre 6:00 e 12:00
        {	
            $Percentual = ".4";
        }
        ElseIf (($DiariaResto > 720) && ($DiariaResto < 1440)) //se horas entre 12:01 e 23:59
        {	
            $Percentual = ".6";
        }
        Else	//se horas menor que 5:59 ou igual a 24:00
        {
            $Percentual = "";
        }
    }
    
    $NumeroDiarias 	= $NumeroDia.$Percentual;
    //calculo de acordo com o roteiro
    If (($PercentualRecebido != 0) ||($PercentualRecebido != "")|| ($PercentualRecebido != 1))
    {
        $ValorReferencia = ((double)($ValorReferencia)) + ((double)($ValorReferencia)) * ((double)($PercentualRecebido));
    }
    ElseIf ($PercentualRecebido == 1)
    {
        $ValorReferencia = (double)($ValorReferencia) + (double)($ValorReferencia);
    }
    
    if($totalRoteiros > 0)
    {
        $ValorReferencia = $ValorReferencia;    
        $ValorTotal	= ($ValorReferencia)*((double)($NumeroDiarias));

        If ($Desconto == "on") //se checkbox desconto 50% marcado
        {	
            $ValorTotal = $ValorTotal/2;
        }

        $ValorTotal = $ValorTotal;
        $saldo      = $ValorTotal - $diariaValorOld;
    }
    else
    {
        $ValorTotal	= ($ValorReferencia)*((double)($NumeroDiarias));

        If ($Desconto == "on") //se checkbox desconto 50% marcado
        {	
            $ValorTotal = $ValorTotal/2;
        }

        $saldo      = ($ValorTotal - $diariaValorOld);
    }
    //CALCULAR SALDO
    if ($saldo == 0)
    {
        $saldoTipo = "";
    }
    elseif (substr($saldo,0,1) == "-")
    {
        $saldo     = ((-1)*$saldo);
        $saldoTipo = "D";            
    }
    else
    {
        $saldo     = $saldo;
        $saldoTipo = "C";
    }
    
    //chama funcao que percorre o periodo da viagem para busca de feriados
    $PossuiFeriado   = f_PossuiFeriado($DataPartida,$DataChegada);

    //chama funcao que percorre o periodo da viagem para busca de fim de semana      
    $PossuiFimSemana = f_PossuiFimSemana($DataPartida,$DataChegada);
    
    $_SESSION['PercentualRecebido'][$cont] = $PercentualRecebido;
    $_SESSION['NumeroDiarias'][$cont]	   = $NumeroDiarias;
    $_SESSION['PossuiFeriado'][$cont]	   = $PossuiFeriado;
    $_SESSION['PossuiFimSemana'][$cont]    = $PossuiFimSemana;
    $_SESSION['ValorTotal'][$cont]	   = $ValorTotal;                    				   
}
Else
{
    $_SESSION['ErroRoteiro']= 1;
}

If ($NumeroDiarias <= 15)
{
   $result ="<table width='318' border='0' cellpadding='1' cellspacing='1'>
                <tr class='calculoSusesso'>
                    <td height='21' width='118'> ".(($PercentualRecebido*100)."% R$ ".(number_format($ValorReferencia, 2, ',', '.')))." </td>
                    <td height='21' width='100'> $NumeroDiarias <input type='hidden' id='hdQtdeDiaria$controle' value='$NumeroDiarias'/></td>
                    <td height='21' width='100'>R$ ".(number_format($ValorTotal, 2, ',', '.'))." <input type='hidden' id='hdValorDiaria$controle' value='$ValorTotal'/></td>
                </tr>
            </table>            
            <input type='hidden' name='txtConfDataPartida$controle' id='txtConfDataPartida$controle' value = '$DataPartida' />
            <input type='hidden' name='txtConfHoraPartida$controle' id='txtConfHoraPartida$controle' value = '$HoraPartida' />
            <input type='hidden' name='txtConfDataChegada$controle' id='txtConfDataChegada$controle' value = '$DataChegada' />
            <input type='hidden' name='txtConfHoraChegada$controle' id='txtConfHoraChegada$controle' value = '$HoraChegada' />                        
            <input type='hidden' name='txtNovoValorRef$controle' id='txtNovoValorRef$controle' value = '$ValorReferencia' />
            <input type='hidden' name='txtNovoValorTotal$controle' id='txtNovoValorTotal$controle' value = '$ValorTotal' />
            <input type='hidden' name='txtQtdDiarias$controle' id='txtQtdDiarias$controle' value = '$NumeroDiarias' />
            <input type='hidden' name='txtNovoCalculo$controle' id='txtNovoCalculo$controle' value = '1' />
            <input type='hidden' name='PossuiFeriado$controle' id='PossuiFeriado$controle' value = '$PossuiFeriado' />
            <input type='hidden' name='PossuiFimSemana$controle' id='PossuiFimSemana$controle' value = '$PossuiFimSemana' />  __";
   
   if($saldoTipo == 'D')
   {
       $result.="<table width='198' border='0' cellpadding='0' cellspacing='1'>
                    <tr class='dataField'>
                        <td class='calculoDevolver' height='21' width='99'>R$ ".number_format($saldo, 2, ',', '.')." </td>
                        <td height='21' width='99'>R$ 0,00 </td>                                                
                    </tr>
                </table>                 
                 <input type='hidden' name='txtSaldo$controle' id='txtSaldo$controle' value = '$saldo' />
                 <input type='hidden' name='txtSaldoTipo$controle' id='txtSaldoTipo$controle' value = '$saldoTipo' />";
   }
   elseif($saldoTipo == 'C')
   {
       $result.="<table width='198' border='0' cellpadding='0' cellspacing='1'>
                    <tr class='dataField'>                        
                        <td height='21' width='99'>R$ 0,00 </td>
                        <td class='calculoReceber height='21' width='99'>R$ ".number_format($saldo, 2, ',', '.')." </td>
                    </tr>
                </table>                 
                 <input type='hidden' name='txtSaldo$controle' id='txtSaldo$controle' value = '$saldo' />
                 <input type='hidden' name='txtSaldoTipo$controle' id='txtSaldoTipo$controle' value = '$saldoTipo' />";
   }
   else
   {
       $result.="<table width='198' border='0' cellpadding='0' cellspacing='1'>
                    <tr class='dataField'>                        
                        <td height='21' width='99'>R$ 0,00 </td>
                        <td height='21' width='99'>R$ 0,00 </td>
                    </tr>
                </table>                 
                 <input type='hidden' name='txtSaldo$controle' id='txtSaldo$controle' value = '$saldo' />
                 <input type='hidden' name='txtSaldoTipo$controle' id='txtSaldoTipo$controle' value = '$saldoTipo' />";
   }
}
Else
{
    $result = "<script type='text/javascript' language='javascript'>
                   alert('Período de viagem não pode ultrapassar 15 dias corridos!');
               </script>";
}
print $result;
?>
