<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaEstorno.php";
include "fpdf.php";

$pdf= new FPDF();
$pdf->Open();

$pdf->AddPage();
function Cabecalho(FPDF $pdf,$PAGINA)
{   /*Cabeçalho' *******************************************************************************************/
    $pdf->Cell (55,15,"",1,0,"C");
    $pdf->image ("../Imagens/logo.jpg",14,13,40);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (135,15, "",1,1);
    $pdf->Text (98,16, "  DIÁRIA AGUARDANDO ESTORNO",1,1,"C");
    $pdf->SetFont ("Times", "",7);
    $pdf->Text (110, 19 ,"EMITIDO: " .date("d/m/Y")." às ".date("H:i:s"),1,1,"C");
    $pdf->Text (108, 22 ,"Por: ".$_SESSION["UsuarioNome"],1,1,"C");
    $Contador=1;
    $pdf->SetFont ("Times", "B",8);
    $pdf->Text (180, 285 ,"PÁGINA : ");
    $pdf->Text (196, 285 , $PAGINA);
    $PAGINA 	  = 1;

        $yNome = 20;
	$yValores = 20;
}
Cabecalho($pdf,'1');
$pdf->Cell (16,5,"N.DIÁRIA",1,0);
$pdf->Cell (23,5,"CPF",1,0);
$pdf->Cell (70,5,"NOME BENEFICIÁRIO",1,0);
$pdf->Cell (20,5,"Nº.EMPENHO",1,0);
$pdf->Cell (19,5,"SD VALOR",1,0,"R");
$pdf->Cell (20,5,"CD VALOR",1,0,"R");
$pdf->Cell (22,5,"RESTITUIÇÃO",1,1);
While($linha=pg_fetch_assoc($rsConsulta))
{
    if ($Contador == 48)
    {
        $pdf->AddPage();
        $Contador = 1;
        $PAGINA ++;
        Cabecalho($pdf,$PAGINA);
    }
        $pdf->SetFont ("Times", "",8);
        $pdf->Cell (16,5,$linha['diaria_numero'],1,0);
        $pdf->Cell (23,5,$linha['pessoa_fisica_cpf'],1,0);
        $pdf->Cell (70,5,substr($linha['pessoa_nm'], 0, 85-strlen($linha['pessoa_nm'])),1,0);

        $ValorSolicitacao  = (ConverteStringMoeda($linha['diaria_valor']));

        $ValorComprovacao  = ConverteStringMoeda($linha['diaria_comprovacao_valor']);
        
        $Estorno      =(-1)*($ValorComprovacao-$ValorSolicitacao);
        $pdf->Cell (20,5,$linha['diaria_empenho'],1,0);
        $pdf->Cell (19,5,number_format($ValorSolicitacao,2, ',', '.'),1,0,"R");
        $pdf->Cell (20,5,number_format($ValorComprovacao,2, ',', '.'),1,0,"R");
        $pdf->Cell (22,5,number_format($Estorno,2, ',', '.'),1,1,"R");




    $Contador ++;
    
}
$pdf->Close();
ob_start();
$pdf->Output();

?>



