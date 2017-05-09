<?php
include "../Include/Inc_Configuracao.php";
include "classe/ClasseRelatorioTerceirizado.php";
include "../SistemaDiarias/fpdf.php";

$pdf=new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();
$RelatorioTipo="";
/*
Tipo de Relatorio
****************************************************************************************
 *
 */

	if($_POST['cmbLotacao']== 0)
    {
    }
	else
	{	$Lotacao =$_POST['cmbLotacao'];
		$sqlconsultaextra = "SELECT  lotacao_ds FROM dados_unico.lotacao where lotacao_id = ".$Lotacao;
        $rsConsultaExtra = pg_query(abreConexao(),$sqlconsultaextra);
        $linha=pg_fetch_assoc($rsConsultaExtra);
        $RelatorioTipo = "LOTACAO : " .$linha['lotacao_ds']. "  ";
    }
	if($_POST['cmbContrato']== 0)
    {
    }
	else
	{	$Contrato =$_POST['cmbContrato'];
		$sqlconsultaextra = "SELECT  pessoa_id, contrato_num, contrato_ds FROM dados_unico.contrato where contrato_id = ".$Contrato;
        $rsConsultaExtra = pg_query(abreConexao(),$sqlconsultaextra);
	    $linha=pg_fetch_assoc($rsConsultaExtra);
        $RelatorioTipo = $RelatorioTipo."CONTRATO : " .$linha['contrato_num']." ".$linha['contrato_ds']."  ";
    }
	if($_POST['cmbFuncao']== 0)
    {$DsFuncao = "";
    }
	else
	{	$Funcao =$_POST['cmbFuncao'];
		$sqlconsultaextra = "SELECT  funcao_ds  FROM dados_unico.funcao where funcao_id = ".$Funcao;
        $rsConsultaExtra = pg_query(abreConexao(),$sqlconsultaextra);
	    $linha=pg_fetch_assoc($rsConsultaExtra);
		$DsFuncao = "FUNCAO : " .$linha['funcao_ds']. "  ";
    }
	if ($_POST['cmbSituacao']== 0)
    {$DsFuncao =$DsFuncao."SITUAÇÃO : TODOS";
    }
	if ($_POST['cmbSituacao'] == 1)
    {$DsFuncao =$DsFuncao."SITUAÇÃO  : CONTRATADO";
    }
	if($_POST['cmbSituacao'] == 2)
    {$DsFuncao =$DsFuncao. "SITUAÇÃO : DESLIGADO";
    }

/*

'CabeÃ§alho
'******************************************************************************************
 *
 */
 
function Cabecalho(FPDF $pdf)
 {
    $pdf->Cell(55,22,"",1,0,"C");
    $pdf->SETX (65);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (135,11,"Relatório Funcionário Terceirizado",1,1,"C");
    $pdf->SetFont ("Times", "",8);
    $pdf->Text (117, 20 ,"EMITIDO : ".date("d/m/Y")." ".date("H:i:s"));
    $pdf->SetFont ("Times", "B",6);
    $pdf->Text (117, 24 ,"CRITÉRIO DE BUSCA");
    $pdf->SETX (65);
    $pdf->Cell (135,11,$RelatorioTipo,1,1,"L");
    $pdf->Text (66, 30 ,$DsFuncao);
    $pdf->SetFont ("Times", "B",8);
    $pdf->image ("../SistemaDiarias/logo.jpg",14,16,40);
    $pdf->Cell (80,5,"NOME FUNCIONÁRIO",1,0);
    $pdf->Cell (22,5,"LOTAÇÃO",1,0);
    $pdf->Cell (50,5,"FUNÇÃO",1,0);
    $pdf->Cell (16,5,"DT.ADM.",1,0);
    $pdf->Cell (22,5,"SITUAÇÃO",1,1);
 }

/*
'******************************************************************************************
 *
 */
 Cabecalho($pdf);
$Contador=1;
$pdf->text(180,285,"PÁGINA : ");
$pdf->text(196,285,"1");

$PAGINA 	= 1;
$contatorReg= 0;

while($linha=pg_fetch_assoc($rsConsulta))
{    $pdf->SetFont('Times','',8);
     $pdf->Cell(80, 5, $linha['pessoa_nm'], 1, 0,'');
     $pdf->Cell(22, 5, $linha['lotacao_ds'], 1, 0,'');
     $pdf->Cell(50, 5, $linha['funcao_ds'], 1, 0,'');
     $pdf->Cell(16, 5, $linha['funcionario_dt_admissao'], 1, 0,'');

	  If ($linha['funcionario_dt_demissao'] != "")
      {    $pdf->Cell(22, 5, "DESLIGADO", 1, 1,'');
      }
	  Else
	  {	$pdf->Cell(22, 5, "CONTRATADO", 1, 1,'');
      }
	  $Contador = $Contador+1;
	  if ($Contador > 47)
      { $Contador=1;
        $PAGINA = $PAGINA +1;
    
         Cabecalho($pdf);
        
        $pdf->text(180,285,"PAGINA : ");
        $pdf->text(196,285,$PAGINA);
      }
	  $contatorReg=$contatorReg+1;
}
$contatorReg = "TOTAL DE REGISTRO(s) : " .$contatorReg;
$pdf->Cell(190, 5, $contatorReg, 0, 1,'R');
$pdf->Close();
$pdf->Output();
?>


