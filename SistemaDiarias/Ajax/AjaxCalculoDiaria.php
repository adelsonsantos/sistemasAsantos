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

$HoraPartida 	    = $_POST['horasaida'];
$HoraChegada 	    = $_POST['horachegada'];
$DataPartida 	    = $_POST['datasaida'];
$DataChegada 	    = $_POST['datachegada'];
$ValorReferencia    = str_replace(",",".",$_POST['valor']);
$Desconto	    = $_POST['desconto'];
$PercentualRecebido = str_replace(",",".",$_POST['perc']);
$dataSolicitada     = $_POST['dataSolocitada'];

$_SESSION['DataPartida'][$cont] = $DataPartida;
$_SESSION['HoraPartida'][$cont] = $HoraPartida;
$_SESSION['DataChegada'][$cont] = $DataChegada;
$_SESSION['HoraChegada'][$cont] = $HoraChegada;

//If (($_SESSION['PercentualRecebido'] == $PercentualRecebido) || ($_SESSION['PercentualRecebido'] == ""))
//{
    //calcula a diferenca entre as horas
    // Divide a hora
    $HoraP=explode(":",$HoraPartida); //hora de partida 
    $HoraC=explode(":",$HoraChegada);// hora de chegada

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
echo $ValorReferencia;
switch ($ValorReferencia) {
    case '571,9' :
        $ValorReferencia = '571';
        break;
    case '571.9' :
        $ValorReferencia = '571';
        break;
    case '541,8' :
        $ValorReferencia = '542';
        break;
    case '541.8' :
        $ValorReferencia = '542';
        break;
    case '481,6' :
        $ValorReferencia = '481';
        break;
    case '481.6' :
        $ValorReferencia = '481';
        break;
    case '427,5' :
        $ValorReferencia = '427';
        break;
    case '427.5' :
        $ValorReferencia = '427';
        break;
    case '340,1' :
        $ValorReferencia = '339';
        break;
    case '340.1' :
        $ValorReferencia = '339';
        break;
    case '322,2' :
        $ValorReferencia = '321';
        break;
    case '322.2' :
        $ValorReferencia = '321';
        break;
    case '286,4' :
        $ValorReferencia = '286';
        break;
    case '286.4' :
        $ValorReferencia = '286';
        break;
    case '324,9' :
        $ValorReferencia = '326';
        break;
    case '324.9' :
        $ValorReferencia = '326';
        break;
    case '307,8' :
        $ValorReferencia = '308';
        break;
    case '307.8' :
        $ValorReferencia = '308';
        break;
    case '273,6' :
        $ValorReferencia = '274';
        break;
    case '273.6' :
        $ValorReferencia = '274';
        break;
    case '277,4' :
        $ValorReferencia = '277';
        break;
    case '277.4' :
        $ValorReferencia = '277';
        break;
    case '262,8' :
        $ValorReferencia = '262';
        break;
    case '262.8' :
        $ValorReferencia = '262';
        break;
    case '233,6' :
        $ValorReferencia = '234';
        break;
    case '233.6' :
        $ValorReferencia = '234';
        break;
    case '235,6' :
        $ValorReferencia = '235';
        break;
    case '235.6' :
        $ValorReferencia = '235';
        break;
    case '223,2' :
        $ValorReferencia = '222';
        break;
    case '223.2' :
        $ValorReferencia = '222';
        break;
    case '198,4' :
        $ValorReferencia = '198';
        break;
    case '198.4' :
        $ValorReferencia = '198';
        break;
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
    }
    else
    {
        $ValorReferencia = round($ValorReferencia);    
        $ValorTotal	= ($ValorReferencia)*((double)($NumeroDiarias));

        If ($Desconto == "on") //se checkbox desconto 50% marcado
        {	
            $ValorTotal = $ValorTotal/2;
        }

        //$ValorTotal = round($ValorTotal);
    }
    
    //chama funcao que percorre o periodo da viagem para busca de feriados
    $PossuiFeriado = f_PossuiFeriado($DataPartida,$DataChegada);

    //chama funcao que percorre o periodo da viagem para busca de fim de semana

    $PossuiFimSemana = f_PossuiFimSemana($DataPartida,$DataChegada);

    $_SESSION['PercentualRecebido'][$cont] = $PercentualRecebido;
    $_SESSION['NumeroDiarias'][$cont]      = $NumeroDiarias;
    $_SESSION['PossuiFeriado'][$cont]      = $PossuiFeriado;
    $_SESSION['PossuiFimSemana'][$cont]    = $PossuiFimSemana;
    $_SESSION['ValorTotal'][$cont]         = $ValorTotal;


If ($NumeroDiarias <= 15)
{

    echo "<table width='318' border='0' cellpadding='1' cellspacing='1'>
                <tr class='calculoSusesso'>
                    <td height='21' width='118'> ".(($PercentualRecebido*100)."% R$ ".(number_format($ValorReferencia, 2, ',', '.')))." </td>
                    <td height='21' width='100'> ".$_SESSION['NumeroDiarias'][$cont]." <input type='hidden' id='hdQtdeDiaria$controle' value='$NumeroDiarias'/></td>
                    <td height='21' width='100'>R$ ".(number_format($_SESSION['ValorTotal'][$cont], 2, ',', '.'))." <input type='hidden' id='hdValorDiaria$controle' value='$ValorTotal'/></td>
                </tr>
            </table>            
            <input type='hidden' name='txtConfDataPartida$controle' id='txtConfDataPartida$controle' value = '$DataPartida' />
            <input type='hidden' name='txtConfHoraPartida$controle' id='txtConfHoraPartida$controle' value = '$HoraPartida' />
            <input type='hidden' name='txtConfDataChegada$controle' id='txtConfDataChegada$controle' value = '$DataChegada' />
            <input type='hidden' name='txtConfHoraChegada$controle' id='txtConfHoraChegada$controle' value = '$HoraChegada' />                        
            <input type='hidden' name='txtNovoValorRef$controle' id='txtNovoValorRef$controle' value = '$ValorReferencia' class='Oculto' />
            <input type='hidden' name='txtNovoValor$controle' id='txtNovoValor$controle' value = '$ValorTotal' />
            <input type='hidden' name='txtQtdDiarias$controle' id='txtQtdDiarias$controle' value = '$NumeroDiarias' />
            <input type='hidden' name='txtNovoCalculo$controle' id='txtNovoCalculo$controle' value = '1' />
            <input type='hidden' name='PossuiFeriado$controle' id='PossuiFeriado$controle' value = '$PossuiFeriado' />
            <input type='hidden' name='PossuiFimSemana$controle' id='PossuiFimSemana$controle' value = '$PossuiFimSemana' /> ";    
}
Else
{
    echo "<font class='MensagemErro'>Período de viagem não pode ultrapassar 15 dias corridos!</font>";
}
?>
