<?php
include "Classe/ClasseRelatorioTicketRefeicao.php";

$mes          = $_GET['cmbMes'];
$Ano          = $_GET['cmbAno'];
$dataAtual    = date('d/m/Y');
$descricaoMes = $_GET['descricaoMes'];
$diasUteis    = 0;

if($mes < '10')
{
    $mes = '0'.$mes;
}
//Verifica Ticket
$sqlTicket   = "SELECT * FROM dados_unico.ticket_refeicao ORDER BY ticket_data_inclusao DESC";
$rsTicket    = pg_query(abreConexao(),$sqlTicket);
$linhaTicket = pg_fetch_assoc($rsTicket);

$valorTicket = $linhaTicket['ticket_valor'];

//RELATORIO ANUAL
if(($mes == NULL)||($mes == '0'))
{
    $where = " AND SUBSTRING(diaria_dt_saida,7) = '$Ano' ";
}
else
{
    $where = " AND SUBSTRING(diaria_dt_saida,4) = '$mes/$Ano' ";
}


$pdf = new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();

/*Cabeçalho
'***************************************************************************************
 */
function Cabecalho(FPDF $pdf,$Ano,$descricaoMes,$dataAtual)
{
    $pdf->Cell (55,22,"",1,0,"C");
    $pdf->SETX (65);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (135,11,  utf8_decode("RELATÓRIO TICKET REFEIÇÃO"),1,1,"C");
    $pdf->SetFont ("Times", "",8);
    $pdf->Text (114, 20 ,"EMITIDO : ".$dataAtual);
    $pdf->SetFont ("Times", "B",8);
    $pdf->SETX (65);
    $pdf->Cell (135,11,utf8_decode("Diárias Referente a o mês de ").utf8_decode($descricaoMes).' de '.$Ano,1,1,"C");
    $pdf->SetFont ("Times", "B",8);
    $pdf->image ("../Imagens/logo.jpg",14,16,40);   
    $pdf->Cell (130,5,"NOME",1,0,'L');
    $pdf->Cell (60,5,"DESCONTO DO TICKET",1,1,'L');
}

Cabecalho($pdf,$Ano,$descricaoMes,$dataAtual);

$contador = 1;
$pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
$pdf->Text (196, 285 , "1");
$PAGINA = 1;
$contatorReg = 0;   

$sqlConsulta = "  SELECT pessoa_id,
                         pessoa_nm,
                         diaria_qtde,
                         diaria_valor,
                         diaria_dt_saida,
                         diaria_hr_saida,
                         diaria_dt_chegada,
                         diaria_hr_chegada,
                         diaria_id,
                         SUBSTRING(diaria_dt_saida,7) AS ano
                    FROM diaria.diaria d
                    JOIN dados_unico.pessoa p
                      ON d.diaria_beneficiario = p.pessoa_id
                   WHERE diaria_excluida = 0                      
                    AND diaria_st > 2
                    AND diaria_st < 100
                  ".$where."      
                ORDER BY pessoa_nm, diaria_qtde DESC";

$rsConsulta = pg_query(abreConexao(),$sqlConsulta);							 

//Calculo por valor da Diaria
$pdf->SetFont ("Times", "",8);
$pessoaId   = ''; 
$qtdSoma    = 0;

$arrayPessoa[] = 0;
$i      = 0;

while($linha = pg_fetch_assoc($rsConsulta))
{        
    if($pessoaId == '')
    {
        $pessoaId   = $linha['pessoa_id'];
        $pessoaNome = $linha['pessoa_nm'];
        $qtdSoma    = $linha['diaria_qtde'];
        $diasUteis  = diasUteis($linha['diaria_dt_saida'],$linha['diaria_dt_chegada'],$linha['diaria_hr_saida'],$linha['diaria_hr_chegada']);             
    }
    elseif($pessoaId == $linha['pessoa_id'])
    {             
        $qtdSoma    = $qtdSoma + $linha['diaria_qtde'];
        $diasUteis  = $diasUteis + (diasUteis($linha['diaria_dt_saida'],$linha['diaria_dt_chegada'],$linha['diaria_hr_saida'],$linha['diaria_hr_chegada']));        
    }
    elseif($pessoaId != $linha['pessoa_id'])
    {   
        $valorDesconto = $diasUteis * $valorTicket;
        $arrayPessoa[$i] = array('qtdSoma' => $qtdSoma, 'pessoaNome' => $pessoaNome, 'valorDesconto' => $valorDesconto);

        $pessoaId   = $linha['pessoa_id'];
        $pessoaNome = $linha['pessoa_nm'];
        $qtdSoma    = $linha['diaria_qtde'];
        $diasUteis  = diasUteis($linha['diaria_dt_saida'],$linha['diaria_dt_chegada'],$linha['diaria_hr_saida'],$linha['diaria_hr_chegada']);
        $i++;
    }              
} 

$valorDesconto = $diasUteis * $valorTicket;
$arrayPessoa[$i] = array('qtdSoma' => $qtdSoma, 'pessoaNome' => $pessoaNome, 'valorDesconto' => $valorDesconto);
$posicoes = count($arrayPessoa); 
$a = 0;

$arrayPessoa = array_orderby($arrayPessoa, 'pessoaNome', SORT_ASC);

while($a < $posicoes)
{    
    $pdf->Cell(130,5,utf8_decode($arrayPessoa[$a]['pessoaNome']),1,0,'L');
    $pdf->Cell(60,5,"R$ ".number_format($arrayPessoa[$a]['valorDesconto'],2),1,1,'L');                    
    $a++;
}

$pdf->Close();
$pdf->Output();
?>