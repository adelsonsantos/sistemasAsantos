<?php
include "Classe/ClasseRelatorioTicketRefeicao.php";

$pessoa       = $_GET['cmbBeneficiario'];
$mes          = $_GET['cmbMes'];
$Ano          = $_GET['cmbAno'];
$dataAtual    = date('d/m/Y');
$descricaoMes = $_GET['descricaoMes'];
$diasUteis    = 0;

if($mes < '10')
{
    $mes = '0'.$mes;
}
//Verifica Ticket
$sqlTicket   = "SELECT * FROM dados_unico.ticket_refeicao ORDER BY ticket_data_inclusao DESC";
$rsTicket    = pg_query(abreConexao(),$sqlTicket);
$linhaTicket = pg_fetch_assoc($rsTicket);

$valorTicket = $linhaTicket['ticket_valor'];

//RELATORIO ANUAL
if(($mes == NULL)||($mes == '0'))
{
    $where = " AND SUBSTRING(diaria_dt_saida,7) = '$Ano' ";
}
else
{
    $where = " AND SUBSTRING(diaria_dt_saida,4) = '$mes/$Ano' ";
}

if($pessoa != NULL)
{
    $where .= " AND diaria_beneficiario = ".$pessoa." ";
}

$pdf = new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();

/*Cabeçalho
'***************************************************************************************
 */
function Cabecalho(FPDF $pdf,$Ano,$dataAtual,$descricaoMes)
{
	$pdf->Cell (55,22,"",1,0,"C");
	$pdf->SETX (65);
	$pdf->SetFont ("Times", "B",10);
	$pdf->Cell (135,11,  utf8_decode("RELATÓRIO DIÁRIA POR SERVIDOR "),1,1,"C");
	$pdf->SetFont ("Times", "",8);
	$pdf->Text (114, 20 ,"EMITIDO : " .$dataAtual." ".date("H:i:s"));
	$pdf->SetFont ("Times", "B",8);
	$pdf->SETX (65);
        if($descricaoMes == '')
        {
            $pdf->Cell (135,11,utf8_decode("Diárias Referente a ").$Ano,1,1,"C");
        }
        else
        {
            $pdf->Cell (135,11,utf8_decode("Diárias Referente a ").utf8_decode($descricaoMes).' / '.$Ano,1,1,"C");
        }
	$pdf->SetFont ("Times", "B",8);
	$pdf->image ("../Imagens/logo.jpg",14,16,40);
        $pdf->Cell (15,5,"SD",1,0,'C');
	$pdf->Cell (71,5,"SERVIDOR",1,0,C);
        $pdf->Cell (19,5,"PARTIDA",1,0,'C');
        $pdf->Cell (19,5,"CHEGADA",1,0,'C');
        $pdf->Cell (19,5,"TICKET",1,0,'C');
	$pdf->Cell (15,5,"VALOR",1,0,'C');
        $pdf->Cell (32,5,"STATUS",1,0,'C');
}

Cabecalho($pdf,$Ano,$dataAtual,$descricaoMes);
$contador = 1;
$pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
$pdf->Text (196, 285 , "1");
$PAGINA = 1;
$contatorReg = 0;
$pdf->Cell (0,5,"",1,1);


$sqlConsulta = "SELECT diaria_numero,diaria_beneficiario, diaria_dt_saida,
                       diaria_qtde, diaria_valor,diaria_dt_criacao,diaria_dt_chegada,
                       du.pessoa_nm,diaria_st,diaria_hr_saida,diaria_hr_chegada
                  FROM diaria.diaria 
                  JOIN dados_unico.pessoa du 
                    ON du.pessoa_id = diaria_beneficiario
                 WHERE diaria_beneficiario = ".$pessoa." 
                   AND diaria_excluida = 0  
                   AND diaria_st > 2
                   AND diaria_st < 100
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
    $diasUteis  = $diasUteis + diasUteis($linha['diaria_dt_saida'],$linha['diaria_dt_chegada'],$linha['diaria_hr_saida'],$linha['diaria_hr_chegada']);        
    $Valores    = $diasUteis * $valorTicket;
    $diaUtil    = diasUteis($linha['diaria_dt_saida'],$linha['diaria_dt_chegada'],$linha['diaria_hr_saida'],$linha['diaria_hr_chegada']);
    $valor      = $diaUtil * $valorTicket;
    
    $pdf->Cell (15,5,$linha['diaria_numero'],1,0);
    $pdf->Cell (71,5,$linha['pessoa_nm'],1,0);
    $pdf->Cell (19,5,$linha['diaria_dt_saida'],1,0,C);
    $pdf->Cell (19,5,$linha['diaria_dt_chegada'],1,0,C);
    $pdf->Cell (19,5,$diaUtil,1,0,C);
    $pdf->Cell (15,5,number_format($valor,2,',','.'),1,0,C);
    $pdf->Cell (32,5,utf8_decode(status($linha['diaria_st'])),1,1,C);                 
}

$pdf->Cell (190,5,'',0,1);
$pdf->SetFont ("Times", "B",8);
$pdf->Cell (190,5,'TOTAL',0,1,"C");
$pdf->Cell (95,5,'QUANTIDADE DE TICKETS',0,0,"R" );
$pdf->Cell (95,5,'VALOR DESCONTADO',0,1,"L");
$pdf->SetFont ("Times", "",8);
$pdf->Cell (75,5,'',0,0,"R" );
$pdf->Cell (20,5,$diasUteis,0,0,"C" );
$pdf->Cell (95,5,"R$ ".number_format($Valores,2,',','.'),0,1,"L");

$pdf->Close();
$pdf->Output();
?>