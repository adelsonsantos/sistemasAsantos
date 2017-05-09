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
    $pdf->Cell (55,22,"",1,0,"C");
    $pdf->SETX (65);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (135,11,  utf8_decode("RELATÓRIO DIÁRIA ".utf8_decode($local)),1,1,"C");
    $pdf->SetFont ("Times", "",8);
    $pdf->Text (114, 20 ,"EMITIDO : ".date("d/m/Y")." ".date("H:i:s"));
    $pdf->SetFont ("Times", "B",8);
    $pdf->SETX (65);
    $pdf->Cell (135,11,utf8_decode("Diárias Referente a ").$Ano,1,1,"C");
    $pdf->SetFont ("Times", "B",8);
    $pdf->image ("../Imagens/logo.jpg",14,16,40);   
    $pdf->Cell (100,5,"NOME",1,0,'L');
    $pdf->Cell (30,5,"QUANTIDADE",1,0,'C');
    $pdf->Cell (60,5,"VALOR",1,0,'C');
}

Cabecalho($pdf,$Ano,$local);

$contador = 1;
$pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
$pdf->Text (196, 285 , "1");
$PAGINA = 1;
$contatorReg = 0;
$pdf->Cell (0,5,"",1,1);

if($_GET['cmbAno'] != '')
{
    $where = " AND SUBSTRING(diaria_dt_saida,7) = '$ano' ";    
}
else
{
    $where = " AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN '$dataInicio' AND '$dataFim') ";      
}

if($idServidor != '')
{
    $where .= " AND diaria_beneficiario = ".$idServidor." ";
}

if($tipoRelatorio != 'todas')
{
    $where .= " AND id_coordenadoria = ".$comboCoordenadoria;
}

$sqlConsulta = "  SELECT pessoa_id,
                         pessoa_nm,
                         diaria_qtde,
                         diaria_valor,
                         SUBSTRING(diaria_dt_saida,7) AS ano
                    FROM diaria.diaria d
                    JOIN dados_unico.pessoa p
                      ON d.diaria_beneficiario = p.pessoa_id
                   WHERE diaria_excluida = 0 
                     AND diaria_qtde <> ''
                  ".$where."      
                ORDER BY pessoa_nm, diaria_qtde DESC";

$rsConsulta = pg_query(abreConexao(),$sqlConsulta);							 

//Calculo por valor da Diaria
$pdf->SetFont ("Times", "",8);
$pessoaId   = ''; 
$qtdSoma    = 0;
$valorTotal = 0;

$arrayPessoa[] = 0;
$i      = 0;

while($linha = pg_fetch_assoc($rsConsulta))
{        
    if($pessoaId == '')
    {
        $pessoaId   = $linha['pessoa_id'];
        $pessoaNome = $linha['pessoa_nm'];
        $qtdSoma    = $linha['diaria_qtde'];
        $valorTotal = $linha['diaria_valor'];
    }
    elseif($pessoaId == $linha['pessoa_id'])
    {             
        $qtdSoma    = $qtdSoma + $linha['diaria_qtde'];
        $valorTotal = $valorTotal + $linha['diaria_valor'];
    }
    elseif($pessoaId != $linha['pessoa_id'])
    {   
        $arrayPessoa[$i] = array('qtdSoma' => $qtdSoma, 'pessoaNome' => $pessoaNome, 'valorTotal' => $valorTotal);
        
        $pessoaId   = $linha['pessoa_id'];
        $pessoaNome = $linha['pessoa_nm'];
        $qtdSoma    = $linha['diaria_qtde'];
        $valorTotal = $linha['diaria_valor']; 
        $i++;
    }              
}   
$arrayPessoa[$i] = array('qtdSoma' => $qtdSoma, 'pessoaNome' => $pessoaNome, 'valorTotal' => $valorTotal);
$posicoes = count($arrayPessoa); 
$a = 0;

$arrayPessoa = array_orderby($arrayPessoa, 'qtdSoma', SORT_DESC, 'pessoaNome', SORT_ASC);

while($a < $posicoes)
{    
    if(utf8_decode($arrayPessoa[$a]['pessoaNome'] == "MARCELO EDUARDO DE SOUZA MOREIRA"))
    {
        
    }
    else
    {                    
        $pdf->Cell(100,5,utf8_decode($arrayPessoa[$a]['pessoaNome']),1,0,'L');
        $pdf->Cell(30,5,$arrayPessoa[$a]['qtdSoma'],1,0,'C');
        $pdf->Cell(60,5,"R$ ".number_format($arrayPessoa[$a]['valorTotal'],2,',','.'),1,1,'C');             
    }
    $a++;
}

$pdf->Close();
$pdf->Output();
?>