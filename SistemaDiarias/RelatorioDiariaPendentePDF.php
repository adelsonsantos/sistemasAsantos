<?php
include "../Include/Inc_Configuracao.php";
include "classe/ClasseRelatorioDiariaPendente.php";
include "fpdf.php";

$pdf=new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();
$RelatorioTipo="";

/*CabeÃ§alho
'******************************************************************************************
 *
 */
function Cabecalho(FPDF $pdf,$DataComprovacao)
{
    $pdf->Cell (55,22,"",1,0,"C");
    $pdf->SETX (65);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (135,11,"RELATÓRIO DIÁRIA PENDENTE ",1,1,"C");
    $pdf->SetFont ("Times", "",8);
    $pdf->Text (114, 20 ,"EMITIDO : " .date("d/m/Y")." ".date("H:i:s"));
    $pdf->SetFont ("Times", "B",8);
    $pdf->SETX (65);
    if ($TipoRelatorio == 0)
    {  $pdf->Cell (135,11,"Aguardando Comprovação Limite : ".$DataComprovacao,1,1,"C");
    }
    if ($TipoRelatorio == 1)
    {  $pdf->Cell (135,11,"Aguardando Entrega da Documentação Limite : ".$DataComprovacao ,1,1,"C");

    }
 
    $pdf->SetFont ("Times", "B",8);
    $pdf->image ("../SistemaDiarias/logo.jpg",14,16,40);
    $pdf->Cell (80,5,"NOME BENEFICIÁRIO",1,0);
    $pdf->Cell (22,5,"N.DIÁRIA",1,0);
    $pdf->Cell (22,5,"DT.CHEGADA",1,0);
    $pdf->Cell (10,5,"HS",1,0);
    $pdf->Cell (26,5,"PROCESSO",1,0);
    $pdf->Cell (30,5,"SITUAÇÃO",1,1);
}

/*
End Function
'******************************************************************************************
 *
 */
Cabecalho($pdf,$DataComprovacao);
$Contador=1;
$pdf->Text (180, 285 ,"PÁGINA : ");
$pdf->Text (196, 285 , "1");
$PAGINA 		  = 1;
$contatorReg	  = 0;
While ($linha=pg_fetch_assoc($rsConsulta))
{

    $DataDiaria = f_FormataData($linha['to_date']);

    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (80,5,$linha['pessoa_nm'],1,0);
    $pdf->Cell (22,5,$linha['diaria_numero'],1,0);
    $pdf->Cell (22,5,$DataDiaria,1,0);
    $pdf->Cell (10,5,$linha['diaria_hr_chegada'],1,0);

    switch (strval($linha['diaria_st']))
    {
			Case "2":
				$statusString = "EMPENHO";
				break;
			Case "3":
				$statusString = "PRÉ-LIQUIDAR";
				break;
			Case "4":
				$statusString = "LIQUIDAR";
				break;
			Case "5":
				$statusString = "EXECUÇÃO";
				break;
			Case "6":
				$statusString = "COMPROVAÇÃO";
				break;
			Case "8":
				$statusString = "APROV.COMP.";
				break;
    }


    $pdf->Cell (26,5,$linha['diaria_processo'],1,0);
    $pdf->Cell (30,5,$statusString,1,1);
    $Contador = $Contador+1;
    if ($Contador > 47)
    {   $Contador=1;
        $PAGINA = $PAGINA +1;
        Cabecalho($pdf,$DataComprovacao);
        $pdf->Text (180, 285 ,"PÁGINA : ");
        $pdf->Text (196, 285 , $PAGINA);
    }
    $contatorReg=$contatorReg+1;
  }

$contatorReg= "TOTAL DE REGISTRO(s) : ".$contatorReg;
$pdf->Cell (190,5,$contatorReg,0,1,"R");

$pdf->Close();
$pdf->Output();
?>

