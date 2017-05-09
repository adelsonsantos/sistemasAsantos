<?php
include "../Include/Inc_Configuracao.php";
include "classe/ClasseRelatorioSaldoProjeto.php";
include "fpdf.php";

$DataComprovacao = $_POST['txtDataComprova'];

$pdf = new FPDF();
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
	$pdf->Cell (135,11,"RELATÓRIO SALDO POR PROJETO ",1,1,"C");
	$pdf->SetFont ("Times", "",8);
	$pdf->Text (114, 20 ,"EMITIDO : " .date("d/m/Y")." ".date("H:i:s"));
	$pdf->SetFont ("Times", "B",8);
	$pdf->SETX (65);
	$pdf->Cell (135,11,"Saldo até a data: ".$DataComprovacao,1,1,"C");
	$pdf->SetFont ("Times", "B",8);
	$pdf->image ("../SistemaDiarias/logo.jpg",14,16,40);
	$pdf->Cell (155,5,"NOME PROJETO",1,0);
	$pdf->Cell (35,5,"SALDO (R$)",1,0);
}

/*
End Function
'******************************************************************************************
 *
 */
Cabecalho($pdf,$DataComprovacao);
$contador = 1;
$pdf->Text (180, 285 ,"PÁGINA: ");
$pdf->Text (196, 285 , "1");
$PAGINA = 1;
$contatorReg = 0;

$pdf->Cell (0,5,"",1,1);

While ($linha=pg_fetch_assoc($rsConsulta))
{
	$sqlConsultaExtra = "SELECT p.pessoa_nm,
	                     d.diaria_numero,
											 d.diaria_hr_chegada,
											 diaria_processo,
											 d.diaria_dt_chegada,
											 diaria_st,
											 projeto_cd,
											 diaria_valor 
								  FROM diaria.diaria d,
									     dados_unico.pessoa p 
								 WHERE p.pessoa_id = d.diaria_beneficiario 
								   AND (d.diaria_st > 0 AND d.diaria_st <= 8 ) 
									 AND to_date(d.diaria_dt_chegada,'DD-MM-YYYY') <=  '". $DataComprovacao ."' 
									 AND projeto_cd =". $linha["projeto_cd"];
									 
	$rsConsultaExtra = pg_query(abreConexao(),$sqlConsultaExtra);
	
	//$imprime = false; LINHA ORIGINAL
	$imprime = true;
	$saldoProjeto = $linha["projeto_saldo"];
	/*While ($row=pg_fetch_assoc($rsConsultaExtra))
	{
		$imprime = true;
		$saldoProjeto -= $row["diaria_valor"];
	}
	*/
	if($imprime)
	{
		$pdf->SetFont ("Times", "",8);

		if(strlen($linha["projeto_ds"]) > 90)
			$projeto = $linha["projeto_cd"] . " " . substr($linha["projeto_ds"], 0, 90) . "...";
		else
			$projeto = $linha["projeto_cd"] . " " . $linha["projeto_ds"];
			
		$pdf->Cell (155,5,utf8_decode($projeto),1,0);
		$pdf->Cell (35,5,$saldoProjeto,1,1);
		
		$contador++;
		$contatorReg++;
	}
	
	if ($contador > 47)
	{   
		$contador = 1;
		$PAGINA++;
		Cabecalho($pdf,$DataComprovacao);
		$pdf->Text (180, 285 ,"PÁGINA: ");
		$pdf->Text (196, 285 , $PAGINA);
		$pdf->Cell (0,5,"",1,1);
	}
	
}

$contatorReg= "TOTAL DE REGISTRO(s) : ".$contatorReg;
$pdf->Cell (190,5,$contatorReg,0,1,"R");

$pdf->Close();
$pdf->Output();
?>

