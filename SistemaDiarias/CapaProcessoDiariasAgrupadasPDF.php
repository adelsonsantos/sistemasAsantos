<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseCapaProcessoDiariasAgrupadas.php";
include "fpdf.php";

$pdf=new FPDF();
$pdf->SetFont('Times','',12);
$pdf->Open();
$pdf->AddPage();

$pdf->image ("../Imagens/Bahia_brasao.JPG",20,5,80);

$pdf->Rect (20,40, 170,17,"C");
$pdf->SETXY (20,40);
$pdf->SetFont ("Times", "",7);
$pdf->Cell (19,4,"Abertura",0,0);

$pdf->SETXY (20,45);
$pdf->SetFont ("Times", "",7);
$pdf->Cell (19,4,"Data/Hora ",0,0);
$pdf->SETXY (41,45);
$pdf->Cell (25,4,date("d/m/Y - H:i:s"),0,0);

$pdf->SETXY (20,50);
$pdf->SetFont ("Times", "",7);
$pdf->Cell (19,4,"Responsavel - Matr.:",0,0);
$pdf->SETXY (41,50);
$pdf->Cell (25,4,f_MatriculaPessoa($_SESSION['UsuarioCodigo']),0,0);

		$pdf->SETXY (149,45);
		$pdf->SetFont ("Times","",10);
		$pdf->Text (149,44,"Numero do Processo");
		$pdf->SetFont ("Times","B",12);
		$pdf->Cell (40,6,$Processo,1,1);
		
                $pdf->SETXY(50,60);
                $pdf->SetFont("Times","","12");
                $pdf->Text(33,67,"Pre-Liquidacao");
                $pdf->SETXY(28,64);
                $pdf->Cell(4,4,"",1,0);
                
                $pdf->SETXY(50,87);
                $pdf->SetFont("Times","",12);
                $pdf->Text(33,73,"Liquidado");
                $pdf->SETXY(28,70);
                $pdf->Cell(4,4,"",1,0);
                $pdf->SETXY(50,85);
                $pdf->SetFont("Times","","12");
                $pdf->Text(33,79,"Pago");
                $pdf->SETXY(28,76);
                $pdf->Cell(4,4,"",1,0);
                $pdf->SetFont("Times","","12");
                $pdf->Text(31,87,"Visto : _____________________");
                
                $pdf->SETXY(133,60);
                $pdf->Cell(45,18,"",1,1);
                $pdf->SETXY(135,60);
                $pdf->SetFont("Times","","12");
                $pdf->Text(135,67,"N ______________");
                $pdf->SETXY(135,70);
                $pdf->SetFont("Times","","12");
                $pdf->Text(135,75,"Mes _____/______");
                
                
		$pdf->SetFont ("Times", "",12);
		$pdf->SETXY (20,108);
		$pdf->Cell (170,10,"ADAB - AGENCIA DE DEFESA AGROPECUARIA DA BAHIA",1,1);
		
		$pdf->SETXY (20,130);
		$pdf->MultiCell (170,6,$UnidadeCustoSigla." - ".$UnidadeCustoNome,1,1);
		
     	$pdf->SETXY (20,150);
		$pdf->MultiCell (170,7,$BeneficiarioNome,1,1);
		
		$pdf->SETXY (20,208);
		$pdf->SetFont ("Times","",10);
		$pdf->MultiCell (170,7,"SOLICITACAO DE DIARIA - SD / ".$Numero ,1,1);
		
		$pdf->image ("../Imagens/orgao.jpg",20,100,170);
		$pdf->image ("../Imagens/unidade.jpg",20,120,170);
		$pdf->image ("../Imagens/autor.jpg",20,140,170);
	    $pdf->image ("../Imagens/assunto.jpg",20,200,170);
	    $pdf->image ("../Imagens/tramitacao.jpg",20,215,170);

$pdf->Close();
ob_start();
$pdf->Output();
?>