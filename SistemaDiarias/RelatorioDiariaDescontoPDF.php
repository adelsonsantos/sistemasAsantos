<?php
include "Classe/ClasseRelatorioAnual.php";

$ano        = $_GET['cmbAno'];
$idServidor = $_GET['cmbBeneficiario'];

$dtInicio = explode("/", $_GET['dataInicio']);
$dtFim    = explode("/", $_GET['dataFim']);

$dataInicio = $dtInicio[2].'/'.$dtInicio[1].'/'.$dtInicio[0];
$dataFim = $dtFim[2].'/'.$dtFim[1].'/'.$dtFim[0];

$tipoRelatorio      = $_GET['tipoRelatorio'];
$local              = $_GET['local'];
$comboCoordenadoria = $_GET['comboCoordenadoria'];

if($dataInicio != '')
{
    $Ano = $_GET['dataInicio']." ".$_GET['dataFim'];
}
else
{
    $Ano = $ano;
}

$TotalPorFuncionario = 0;

$pdf = new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();

/*Cabeçalho
'***************************************************************************************
 */
function Cabecalho(FPDF $pdf,$Ano,$local)
{
    $pdf->Cell (71,27,"",1,0,"C");
    $pdf->SETX (81);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (119,11,  utf8_decode("RELATÓRIO TICKET REFEIÇÃO ".utf8_decode($local)),1,1,"C");
    $pdf->SetFont ("Times", "",8);
    $pdf->Text (121, 20 ,"EMITIDO : ".date("d/m/Y")." ".date("H:i:s"));
    $pdf->SetFont ("Times", "B",8);
    $pdf->SETX (81);
    $pdf->Cell (119,11,utf8_decode("Diárias Referente a ").$Ano,1,1,"C");
    $pdf->SetFont ("Times", "B",8);
    $pdf->image ("../Imagens/adabb.jpg",33,11,20);
    $pdf->Cell (71,5,"NOME",1,0,'L');
    $pdf->Cell (40,5,utf8_decode("MATRÍCULA"),1,0,'C');
    $pdf->Cell (39,5,"QTD DIARIAS",1,0,'C');
    $pdf->Cell (40,5,"VALOR TOTAL",1,0,'C');
}

Cabecalho($pdf,$Ano,$local);

$contador = 1;
$pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
$pdf->Text (196, 285 , "1");
$PAGINA = 1;
$contatorReg = 0;
$pdf->Cell (0,5,"",1,1);

if($idServidor != '')
{
    $wheree .= " AND diaria_beneficiario = ".$idServidor." ";
}


if(!empty($dataInicio) && !empty($dataFim)){
    $where = " AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim') ";
    if($tipoRelatorio != 'todas'){
        if($idServidor != ''){
            $where2 =  " AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim') AND C.id_coordenadoria = ".$comboCoordenadoria." AND diaria_beneficiario = ".$idServidor;
        }else{
            $where2 = " AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim') AND C.id_coordenadoria = ".$comboCoordenadoria;
        }
    }else{
        if($idServidor != ''){
            $where2 =  " AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim') AND diaria_beneficiario = ".$idServidor;
        }else{
            $where2 = " AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim')";
        }
    }
}



$sqlConsulta = "SELECT DISTINCT
pessoa_nm, 
p.pessoa_id, 
pessoa_fisica_cpf,
funcionario_matricula,
nome,
(	SELECT COALESCE(sum(CAST(DD.DIARIA_QTDE as float)), NULL, 0)
	FROM DADOS_UNICO.PESSOA PP JOIN DIARIA.DIARIA DD ON DD.DIARIA_BENEFICIARIO = PP.PESSOA_ID WHERE PP.PESSOA_ID = P.PESSOA_ID
	and DD.DIARIA_ST IN (4, 5, 6, 7) ".$where."  
)as quantidade_diarias,

(
		(	
			SELECT COALESCE(sum(CAST(DD.DIARIA_QTDE as float)), NULL, 1)
			FROM DADOS_UNICO.PESSOA PP JOIN DIARIA.DIARIA DD ON DD.DIARIA_BENEFICIARIO = PP.PESSOA_ID WHERE PP.PESSOA_ID = P.PESSOA_ID
			and DD.DIARIA_ST IN (4, 5, 6, 7) ".$where."  
		) 
		*
		(
			9
		)	 
) as valor_total
FROM DADOS_UNICO.PESSOA P 
JOIN DIARIA.DIARIA D ON D.DIARIA_BENEFICIARIO = P.PESSOA_ID
JOIN DADOS_UNICO.FUNCIONARIO F ON P.PESSOA_ID = F.PESSOA_ID
JOIN DADOS_UNICO.PESSOA_FISICA PF ON PF.PESSOA_ID = P.PESSOA_ID
JOIN SEGURANCA.USUARIO U ON U.PESSOA_ID = P.PESSOA_ID
JOIN DIARIA.COORDENADORIA C ON C.ID_COORDENADORIA = U.ID_COORDENADORIA
WHERE D.DIARIA_ST IN (4, 5, 6, 7, 300)
".$where2."  
ORDER BY PESSOA_NM";
ini_set('max_execution_time', 5000);
$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

//Calculo por valor da Diaria
$pdf->SetFont ("Times", "",8);
$pessoaId   = '';
$pessoaNome   = '';
$funcionario_matricula = 0;
$quantidade_diarias = 0;
$valor_diarias = 0;
$tiket = 0;
$transporte = 0;
$valor_total = 0;

$arrayPessoa[] = 0;
$i      = 0;

/*while($linha = pg_fetch_assoc($rsConsulta))
{
    if($pessoaId == '')
    {
        $pessoaId   = $linha['pessoa_id'];
        $pessoaNome = $linha['pessoa_nm'];
        $funcionario_matricula = $linha['funcionario_matricula'];
        $quantidade_diarias    = $linha['quantidade_diarias'];
        $valor_diarias    = $linha['valor_diarias'];
        $tiket    = $linha['tiket'];
        $transporte    = $linha['transporte'];
        $valor_total    = $linha['valor_total'];
    }
    elseif($pessoaId == $linha['pessoa_id'])
    {
        $pessoaId   = $linha['pessoa_id'];
        $pessoaNome = $linha['pessoa_nm'];
        $funcionario_matricula = $linha['funcionario_matricula'];
        $quantidade_diarias    = $linha['quantidade_diarias'];
        $valor_diarias    = $linha['valor_diarias'];
        $tiket    = $linha['tiket'];
        $transporte    = $linha['transporte'];
        $valor_total    = $linha['valor_total'];
    }
    elseif($pessoaId != $linha['pessoa_id'])
    {
        $arrayPessoa[$i] = //array('valor_total' => $valor_total, 'pessoaNome' => $pessoaNome, 'funcionario_matricula' => $funcionario_matricula);

            [
                'pessoaNome' => $pessoaNome,
                'funcionario_matricula' => $funcionario_matricula,
                'quantidade_diarias' => $quantidade_diarias,
                'valor_total' => $valor_total
            ];

        $pessoaId   = $linha['pessoa_id'];
        $pessoaNome = $linha['pessoa_nm'];
        $funcionario_matricula = $linha['funcionario_matricula'];
        $quantidade_diarias    = $linha['quantidade_diarias'];
        $valor_total    = $linha['valor_total'];
        $i++;
    }


}*/
/*
$arrayPessoa[$i] =   [
    'pessoaNome' => $pessoaNome,
    'funcionario_matricula' => $funcionario_matricula,
    'quantidade_diarias' => $quantidade_diarias,
    'valor_total' => $valor_total
];
$posicoes = count($arrayPessoa);
$a = 0;*/

/*while($a < $posicoes)
{
    $pdf->Cell(71,5,utf8_decode(substr($arrayPessoa[$a]['pessoaNome'], 0, 42)),1,0,'L');
    $pdf->Cell(40,5,$arrayPessoa[$a]['funcionario_matricula'],1,0,'C');
    $pdf->Cell(39,5,$arrayPessoa[$a]['quantidade_diarias'],1,0,'C');

    $pdf->Cell(40,5,"R$ ".number_format($arrayPessoa[$a]['valor_total'],2,',','.'),1,1,'C');
    $a++;
}*/

$pdf->Close();
$pdf->Output();
?>