<?php
include "../Include/Inc_Configuracao.php";
include "fpdf.php";

$Ano        = $_GET['cmbAno'];
$dataInicio = $_GET['dataInicio'];
$dataFim    = $_GET['dataFim'];
$idServidor = $_GET['cmbBeneficiario'];

$TotalPorFuncionario = 0;

if($dataInicio != '')
{
    $Ano = $dataInicio." ".$dataFim;
}

$pdf = new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();

/*Cabeçalho
'***************************************************************************************
 */
function status($stBd)
{
    switch ($stBd) {
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
function Cabecalho(FPDF $pdf,$Ano,$dataInicio,$dataFim)
{
	$pdf->Cell (55,22,"",1,0,"C");
	$pdf->SETX (65);
	$pdf->SetFont ("Times", "B",10);
	$pdf->Cell (135,11,  utf8_decode("RELATÓRIO DIÁRIA POR SERVIDOR "),1,1,"C");
	$pdf->SetFont ("Times", "",8);
	$pdf->Text (114, 20 ,"EMITIDO : " .date("d/m/Y")." ".date("H:i:s"));
	$pdf->SetFont ("Times", "B",8);
	$pdf->SETX (65);
	$pdf->Cell (135,11,utf8_decode("Diárias Referente a ").$Ano,1,1,"C");
	$pdf->SetFont ("Times", "B",8);
	$pdf->image ("../Imagens/logo.jpg",14,16,40);
        $pdf->Cell (15,5,"SD",1,0,'C');
	$pdf->Cell (80,5,"SERVIDOR",1,0,C);
        $pdf->Cell (19,5,"PARTIDA",1,0,'C');
        $pdf->Cell (19,5,"CHEGADA",1,0,'C');
        $pdf->Cell (10,5,utf8_decode("QTD"),1,0,'C');
	$pdf->Cell (15,5,"VALOR",1,0,'C');
        $pdf->Cell (32,5,"STATUS",1,0,'C');
}


Cabecalho($pdf,$Ano,$dataInicio,$dataFim);
$contador = 1;
$pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
$pdf->Text (196, 285 , "1");
$PAGINA = 1;
$contatorReg = 0;
$pdf->Cell (0,5,"",1,1);

if($dataFim != '')
{
    $where = " AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim') ";
}
else
{
    $where = " AND SUBSTRING(diaria_dt_saida,7) = '$Ano' ";
}

$sqlConsulta = "SELECT diaria_numero,diaria_beneficiario, diaria_dt_saida,
                       diaria_qtde, diaria_valor,diaria_dt_criacao,diaria_dt_chegada,
                       du.pessoa_nm,diaria_st
                  FROM diaria.diaria 
                  JOIN dados_unico.pessoa du 
                    ON du.pessoa_id = diaria_beneficiario
                 WHERE diaria_beneficiario = ".$idServidor." 
                   AND diaria_excluida = 0  
                   ".$where."
              ORDER BY TO_DATE(diaria_dt_saida,'DD/MM/YYY')";

$rsConsulta = pg_query(abreConexao(),$sqlConsulta);							 

//Calculo por valor da Diaria
$pdf->SetFont ("Times", "",8);	
$qntLinha = pg_affected_rows($rsConsulta);
$qtdSoma  = 0;
$Valores  = 0;

while($linha = pg_fetch_assoc($rsConsulta))
{        
    $qtdSoma = $qtdSoma + $linha['diaria_qtde'];        
    $Valores = $Valores + $linha['diaria_valor'];
    
    $pdf->Cell (15,5,$linha['diaria_numero'],1,0);
    $pdf->Cell (80,5,$linha['pessoa_nm'],1,0);
    $pdf->Cell (19,5,$linha['diaria_dt_saida'],1,0,C);
    $pdf->Cell (19,5,$linha['diaria_dt_chegada'],1,0,C);
    $pdf->Cell (10,5,$linha['diaria_qtde'],1,0,C);
    $pdf->Cell (15,5,number_format($linha['diaria_valor'],2,',','.'),1,0,C);
    $pdf->Cell (32,5,utf8_decode(status($linha['diaria_st'])),1,1,C);                 
}

$pdf->Cell (190,5,'',0,1);
$pdf->SetFont ("Times", "B",8);
$pdf->Cell (190,5,'TOTAL',0,1,"C");
$pdf->Cell (95,5,'QUANTIDADE',0,0,"R" );
$pdf->Cell (95,5,'VALOR',0,1,"L");
$pdf->SetFont ("Times", "",8);
$pdf->Cell (75,5,'',0,0,"R" );
$pdf->Cell (20,5,$qtdSoma,0,0,"C" );
$pdf->Cell (95,5,"R$ ".number_format($Valores,2,',','.'),0,1,"L");
$pdf->Close();
$pdf->Output();
//=============================================================================================================================
?>