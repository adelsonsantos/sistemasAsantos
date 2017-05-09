<?php
include"../Include/Inc_Configuracao.php";
include "classe/ClasseRelatorioBeneficiario.php";
include "fpdf.php";

$vetData = explode("/", $_POST['txtDataComprovaIni']);
$Dia = $vetData[0];
$Mes = $vetData[1];
$Ano = $vetData[2];
if(strlen($Dia)==1)
{ $Dia = "0". $Dia;
}
if (strlen($Mes)==1)
{	$Mes = "0" . $Mes;
}
$DataComprovacaoIni=implode("/", array($Dia,$Mes,$Ano));

$vetData = explode("/", $_POST['txtDataComprovaFim']);
$Dia = $vetData[0];
$Mes = $vetData[1];
$Ano = $vetData[2];
if(strlen($Dia)==1)
{ $Dia = "0". $Dia;
}
if (strlen($Mes)==1)
{	$Mes = "0" . $Mes;
}
$DataComprovacaoFim=implode("/",array($Dia,$Mes,$Ano));


$pdf=new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();
$RelatorioTipo="";


/*
'CabeÃ§alho
'******************************************************************************************
 *
 */
function Cabecalho(FPDF $pdf,$Beneficiario,$DataComprovacaoIni,$DataComprovacaoFim,$ProjetoDescricao)
{
    $pdf->Cell (55,22,"",1,0,"C");
    $pdf->SETX (65);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (135,11,"RELATÓRIO DIÁRIA ",1,1,"C");
    $pdf->SetFont ("Times", "",8);
    $pdf->Text (114, 20 ,"EMITIDO : " .date("d/m/Y")." ".date("H:i:s"));
    $pdf->SetFont ("Times", "B",8);
    $pdf->SETX (65);
    $pdf->Cell (90,11,"BENEFICIÁRIO : ".$Beneficiario  ,1,0,"L");
    $pdf->Cell (45,11,"",1,1,"L");
    $pdf->Text (158, 26 , "Período : ".$DataComprovacaoIni." à " .$DataComprovacaoFim);
     If ($FiltrarProjeto == "on")
     {
        $pdf->Text (158, 29 , "Projeto : " .$ProjetoDescricao);
     }
    $pdf->SetFont ("Times", "B",8);
    $pdf->image ("../SistemaDiarias/logo.jpg",14,16,40);
    $pdf->Cell (20,5,"N.DIÁRIA",1,0);
    $pdf->Cell (20,5,"PROCESSO",1,0);
    $pdf->Cell (22,5,"EMPENHO",1,0);
    $pdf->Cell (20,5,"DT.INÍCIO",1,0);
    $pdf->Cell (21,5,"DT.CHEGADA",1,0);
    $pdf->Cell (21,5,"QTDE",1,0);
    $pdf->Cell (21,5,"VL.UNIT",1,0);
    $pdf->Cell (22,5,"VL TOTAL",1,0);
    $pdf->Cell (23,5,"Status",1,1);
}

/*
End Function
'******************************************************************************************
 *
 */
Cabecalho($pdf,$Beneficiario,$DataComprovacaoIni,$DataComprovacaoFim,$ProjetoDescricao);
$Contador=1;
$pdf->Text (180, 285 ,"PÁGINA : ");
$pdf->Text (196, 285 , "1");
$PAGINA 		  = 1;
$contatorReg	  = 0 ;
$valortemp		  = 0;
$contatorQtDiaria = 0;

While($linha=pg_fetch_assoc($rsConsulta))
{

    $valortemp 		 = $valortemp+$linha['diaria_comprovacao_valor'];
    $DataDiariainicio    = $linha['diaria_dt_saida'];
    $DataDiariafim       = $linha['diaria_dt_chegada'];
    $contatorQtDiaria    = $contatorQtDiaria+$linha['diaria_comprovacao_qtde'];

    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (20,5,$linha['diaria_numero'],1,0);
    $pdf->Cell (20,5,$linha['diaria_processo'],1,0);
    $pdf->Cell (22,5,$linha['diaria_empenho'],1,0);
    $pdf->Cell (20,5,$DataDiariainicio,1,0);
    $pdf->Cell (21,5,$DataDiariafim,1,0);
    $pdf->Cell (21,5,$linha['diaria_comprovacao_qtde'],1,0,"R");
    $pdf->Cell (21,5,$linha['diaria_comprovacao_valor_ref'],1,0);
    $pdf->Cell (22,5,$linha['diaria_comprovacao_valor'],1,0);
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
            $statusString = "EXECU&Ccedil;&Atilde;O";
            break;
        Case "6":
            $statusString = "COMPROVA&Ccedil;&Atilde;O";
            break;
        Case "8":
            $statusString = "APROV.COMP.";
            break;
        Case "9":
            $statusString = "AGUARD.ARQ.";
            break;
        Case "10":
            $statusString = "ARQUIVADA";
            break;
    }

    $pdf->Cell (23,5,$statusString,1,1);


    $Contador =$Contador+1;
    if ($Contador > 47)
    {
        $Contador=1;
        $PAGINA = $PAGINA +1;
        Cabecalho($pdf,$Beneficiario,$DataComprovacaoIni,$DataComprovacaoFim,$ProjetoDescricao);
        $pdf->Text (180, 285 ,"PÁGINA : ");
        $pdf->Text (196, 285 , $PAGINA);
    }
    $contatorReg=$contatorReg+1;
}

$contatorReg 	= "TOTAL DE REGISTRO(s) : ".$contatorReg ;
$contatorQtDiaria= "TOTAL DE DIÁRIAS :".$contatorQtDiaria;
$contatorReg1 	= "VALOR TOTAL         : "." ".number_format($valortemp,2, ',', '.');
$pdf->Cell (152,5, $contatorQtDiaria,0,1,"R");
$pdf->Cell (162,5, $contatorReg1,0,1,"R");
$pdf->Cell (190,5,$contatorReg,0,1,"R");
$pdf->Close();
$pdf->Output();
?>

