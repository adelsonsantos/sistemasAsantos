<?php
include "../Include/Inc_Configuracao.php";
include "classe/ClasseRelatorioExtratoProjeto.php";
include "fpdf.php";

$dataInicial   = $_POST['txtDataInicial'];
$dataFinal     = $_POST['txtDataFinal'];
$tipoRelatorio = $_GET['tiporelatorio'];

$pdf = new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();
$RelatorioTipo="";

/*CabeÃ§alho
'******************************************************************************************
 *
 */

function Cabecalho($pdf,$dataInicial,$dataFinal)
{
	$pdf->Cell (55,22,"",1,0,"C");
	$pdf->SETX (65);
	$pdf->SetFont ("Times", "B",10);
	$pdf->Cell (135,11,"RELATÓRIO SALDO POR PROJETO ",1,1,"C");
	$pdf->SetFont ("Times", "",8);
	$pdf->Text (114, 20 ,"EMITIDO : " .date("d/m/Y")." ".date("H:i:s"));
	$pdf->SetFont ("Times", "B",8);
	$pdf->SETX (65);

	$pdf->Cell (135,11,"Período de ".$dataInicial." à ".$dataFinal,1,1,"C");

	$pdf->SetFont ("Times", "B",8);
	$pdf->image ("../SistemaDiarias/logo.jpg",14,16,40);
	$pdf->Cell (119,5,"NOME PROJETO",1,0);
	$pdf->Cell (21,5,"ORÇAMENTO",1,0);
	$pdf->Cell (24,5,"TOTAL DIÁRIAS",1,0);
	$pdf->Cell (26,5,"SALDO PROJETO",1,0);
}

/*
End Function
'******************************************************************************************
 *
 */
Cabecalho($pdf,$dataInicial,$dataFinal);
$contador = 1;
$pdf->Text (180, 285 ,"PÁGINA: ");
$pdf->Text (196, 285 , "1");
$PAGINA = 1;
$contatorReg = 0;

$pdf->Cell (0,5,"",1,1);

While ($linha=pg_fetch_assoc($rsConsulta))
{
	switch($tipoRelatorio)
	{
	 case '1':
		$bordar = 1;
		$sqlConsultaExtra = "SELECT est_organizacional_sigla,
																projeto_cd,diaria_valor,
																diaria_numero,
																pessoa_nm
													 FROM diaria.diaria	d,
																dados_unico.pessoa p,
																dados_unico.est_organizacional e
													WHERE d.diaria_beneficiario = p.pessoa_id
														AND e.est_organizacional_id = d.diaria_unidade_custo
														AND diaria_excluida = 0
														AND (d.diaria_st > 2)
														AND projeto_cd =". $linha["projeto_cd"] ."
														AND diaria_dt_empenho >= '". $dataInicial ."'
														AND diaria_dt_empenho <= '". $dataFinal ."'
											 ORDER BY projeto_cd,
											          est_organizacional_sigla,
																pessoa_nm";
		break;

		case '2':
		case '3':
		$bordar = 0;
		$sqlConsultaExtra = "SELECT *
		                       FROM diaria.diaria d,
													      dados_unico.pessoa p,
																dados_unico.funcionario f,
																dados_unico.est_organizacional_funcionario eof,
																dados_unico.est_organizacional e
													WHERE d.diaria_beneficiario = p.pessoa_id
													  AND p.pessoa_id = f.pessoa_id
														AND f.funcionario_id = eof.funcionario_id
														AND e.est_organizacional_id = eof.est_organizacional_id
														AND est_organizacional_funcionario_st = 0
														AND diaria_excluida = 0
														AND (d.diaria_st > 2 )
														AND d.projeto_cd =". $linha["projeto_cd"] ."
														AND diaria_dt_empenho >= '". $dataInicial ."'
														AND diaria_dt_empenho <= '". $dataFinal ."'
											 ORDER BY projeto_cd,
											          est_organizacional_sigla,
											          pessoa_nm";
		break;
	}

	//echo "Tipo: $tipoRelatorio<br>Query: ".$sqlConsultaExtra; exit;

	$rsConsultaExtra = pg_query(abreConexao(),$sqlConsultaExtra);

	$saldoDiarias = 0;
	$imprimir = false;

	while ($row = pg_fetch_assoc($rsConsultaExtra))
	{
		$imprimir = true;
		$saldoDiarias += $row["diaria_valor"];
	}

	if($imprimir)
	{
		if(strlen($linha["projeto_ds"]) > 70)
			$projeto = $linha["projeto_cd"] . " " . substr($linha["projeto_ds"], 0, 70) . "...";
		else
			$projeto = $linha["projeto_cd"] . " " . $linha["projeto_ds"];

		$saldoProjeto = $linha["projeto_saldo"] - $saldoDiarias;

		$pdf->SetFont ("Times", "",8);
		$pdf->Cell (119,5,$projeto,$bordar,0);
		$pdf->SetFont ("Times", "",8);
		$pdf->Cell (21,5,$linha["projeto_saldo"],$bordar,0);
		$pdf->SetFont ("Times", "",8);
		$pdf->Cell (24,5,$saldoDiarias,$bordar,0);
		$pdf->SetFont ("Times", "",8);
		$pdf->Cell (26,5,$saldoProjeto,$bordar,1);
		$contador++;
		$contatorReg++;

		if($tipoRelatorio == '2' || $tipoRelatorio == '3')
		{
			$array = array("SFC", "SPS", "CPA", "DG", "GASEC", "CG");
			foreach($array as $sigla)
			{
				$sqlConsultaunidadeTotal = "SELECT *
																			FROM diaria.diaria d,
																					 dados_unico.pessoa p,
																					 dados_unico.funcionario f,
																					 dados_unico.est_organizacional_funcionario eof,
																					 dados_unico.est_organizacional e
																		 WHERE d.diaria_beneficiario = p.pessoa_id
																			 AND p.pessoa_id = f.pessoa_id
																			 AND f.funcionario_id = eof.funcionario_id
																			 AND e.est_organizacional_id = eof.est_organizacional_id
																			 AND est_organizacional_funcionario_st = 0
																			 AND diaria_excluida = 0
																			 AND (d.diaria_st > 2 )
																			 AND d.projeto_cd = ". $linha["projeto_cd"] ."
																			 AND diaria_dt_empenho >= '". $dataInicial ."'
																			 AND diaria_dt_empenho <= '". $dataFinal ."'
																			 AND est_organizacional_sigla like '". $sigla ."%'
																	ORDER BY projeto_cd,
																					 est_organizacional_sigla,
																					 pessoa_nm";

				$rsConsultaTotal = pg_query(abreConexao(),$sqlConsultaunidadeTotal);

				$saldoUnidadeDiarias = 0;
				$imprimir = false;

				while ($row = pg_fetch_assoc($rsConsultaTotal))
				{
					$imprimir = true;
					$saldoUnidadeDiarias += $row["diaria_valor"];
				}

				if($imprimir)
				{
					$pdf->SetFont ("Times", "",6);
					$pdf->Cell (130,5,"    UNIDADE - ".$sigla,0,0);
					$pdf->SetFont ("Times", "",6);
					$pdf->Cell (24,5,$saldoUnidadeDiarias,0,1);
					$contador++;
				}
			}
		}
	}

	if ($contador > 46)
	{
		$contador = 1;
		$PAGINA++;
		Cabecalho($pdf,$dataInicial,$dataFinal);
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