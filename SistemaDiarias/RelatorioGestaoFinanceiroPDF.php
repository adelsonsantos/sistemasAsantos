<?php
include "Fpdf.php";
include "Classe/ClasseRelatorioGestaoFinanceiroPDF.php";

$pdf = new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();
/*Cabeçalho
****************************************************************************************** 
 */
function Cabecalho(FPDF $pdf,$dataInicio,$dataFim,$filtro,$status)
{
    if($status == '2')
    {
        $status = 'Aguardando Empenho';
    }
    else
    {
        $status = 'Empenhadas';
    }
    $pdf->Cell (55,22,"",1,0,"C");
    $pdf->SETX (65);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (135,11,  utf8_decode("RELATÓRIO DIÁRIA ".$filtro),1,1,"C");
    $pdf->SetFont ("Times", "",8);
    $pdf->Text (114, 20 ,"EMITIDO : " .date("d/m/Y")." ".date("H:i:s"));
    $pdf->SetFont ("Times", "B",8);
    $pdf->SETX (65);    
    $pdf->Cell(135, 6,utf8_decode("Diárias de  ".$dataInicio."  à  ".$dataFim),1,1,"C");
    $pdf->SETX (65);
    $pdf->Cell(135, 5,$status,1,1,"C");    
    $pdf->SetFont ("Times", "B",8);
    $pdf->image ("../Imagens/logo.jpg",14,16,40);
    $pdf->Cell (0,5,"",0,1);	
}

Cabecalho($pdf,$dataInicio,$dataFim,$filtro,$status);
$contador = 1;
$pagina = 1;
$pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
$pdf->Text (196, 285 , $pagina);
$contatorReg = 45;

if($status == '2')
{
    // Colunas do relatório
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (17,5,"SD",1,0,"C");
    $pdf->Cell (75,5,utf8_decode("BENEFICIÁRIO"),1,0);
    $pdf->Cell (17,5,utf8_decode("SAÍDA"),1,0,"C");
    $pdf->Cell (17,5,"CHEGADA",1,0,"C");        
    $pdf->Cell (20,5,"VALOR",1,0);
    $pdf->Cell (44,5,"PEDIDO DE EMPENHO",1,1);
    $pdf->SetFont ("Times", "",8);

    while($linha = pg_fetch_assoc($rsConsulta))
    {
        // Linhas do relatório    
        $pdf->Cell (17,5,$linha['diaria_numero'],1,0,"C");
        $pdf->Cell (75,5,utf8_decode($linha['pessoa_nm']),1,0);
        $pdf->Cell (17,5,$linha['diaria_dt_saida'],1,0,"C");
        $pdf->Cell (17,5,$linha['diaria_dt_chegada'],1,0,"C");        
        $pdf->Cell (20,5,'R$ '.number_format($linha['diaria_valor'],2,',','.'),1,0);
        $pdf->Cell (44,5,"",1,1);
        $pdf->SetFont ("Times", "",8);
        
        $novaPagina = $pdf -> page;
        if($novaPagina > $pagina)
        {                                          
            $pdf->SetFont ("Times", "B",8);
            $pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
            $pdf->Text (196, 285 , $novaPagina);   
            $pagina = $novaPagina;
            $pdf->SetFont ("Times", "",8);
        }
    }
}
else if($status == '3')
{
    // Colunas do relatório
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (17,5,"SD",1,0,"C");
    $pdf->Cell (95,5,utf8_decode("BENEFICIÁRIO"),1,0);
    $pdf->Cell (17,5,utf8_decode("SAÍDA"),1,0,"C");
    $pdf->Cell (17,5,"CHEGADA",1,0,"C");        
    $pdf->Cell (20,5,"VALOR",1,0);
    $pdf->Cell (24,5,utf8_decode("N° EMPENHO"),1,1);
    $pdf->SetFont ("Times", "",8);

    while($linha = pg_fetch_assoc($rsConsulta))
    {
        // Linhas do relatório    
        $pdf->Cell (17,5,$linha['diaria_numero'],1,0,"C");
        $pdf->Cell (95,5,utf8_decode($linha['pessoa_nm']),1,0);
        $pdf->Cell (17,5,$linha['diaria_dt_saida'],1,0,"C");
        $pdf->Cell (17,5,$linha['diaria_dt_chegada'],1,0,"C");        
        $pdf->Cell (20,5,'R$ '.number_format($linha['diaria_valor'],2,',','.'),1,0);
        $pdf->Cell (24,5,$linha['diaria_empenho'],1,1);
        $pdf->SetFont ("Times", "",8);
        
        $novaPagina = $pdf -> page;
        if($novaPagina > $pagina)
        {                                          
            $pdf->SetFont ("Times", "B",8);
            $pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
            $pdf->Text (196, 285 , $novaPagina);   
            $pagina = $novaPagina;
            $pdf->SetFont ("Times", "",8);
        }
    }
}

$pdf->Close();
$pdf->Output();
?>
