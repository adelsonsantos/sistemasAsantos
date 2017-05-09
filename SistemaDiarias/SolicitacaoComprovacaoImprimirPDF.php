<?php
include "Classe/ClasseDiariaImpressao.php";

require_once("../Fpdf/fpdf.php");
define('FPDF_FONTPATH','Fpdf/font/');


$pdf=new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();

//cabecalho
$pdf->Cell (55,24,"",1,0,"C");
$pdf->SETX (65);
$pdf->Cell (135,12,(utf8_decode("Comprovação de Diárias")),1,1,"C");
$pdf->SETXY (65, 22);
$pdf->SetFont ("Times", "B",9);
$pdf->write (5, utf8_decode("Área Beneficiária:"));
$pdf->SETX (65);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (90,12,"",1,0);
$pdf->SETXY (65, 26);
$pdf->MultiCell (90,4,$UnidadeCustoNome,0,1);
$pdf->SETXY (155, 22);
$pdf->SetFont ("Times", "B",9);
$pdf->write (5, utf8_decode("N° Diária:"));
$pdf->SetFont ("Times","",8);
$pdf->SETXY (155, 22);
$pdf->Cell (45,12,"",1,1);
$pdf->SETXY (172, 18.5);
$pdf->Cell (45,12,$Numero,0,1);

$pdf->image ("../imagens/logo.jpg",14,18,40);

//Nome Benefici�rio
$pdf->Rect (10, 35, 145, 10,"D");
$pdf->SETXY (10, 35);
$pdf->SetFont ("Times", "B",9);
$pdf->Cell (145,5,"Nome:",0,0);
$pdf->SETXY (10, 39);
$pdf->SetFont( "Times", "",8);
$pdf->Cell (145,5,$BeneficiarioNome,0,0);

 //Matrilula
$pdf->Rect (155, 35, 45, 10 , "D");
$pdf->SetFont ("Times", "B",9);
$pdf->SETXY (155, 35);
$pdf->Cell (35,5, utf8_decode("Matrícula:"),0,0);
$pdf->SETXY( 172, 35);
$pdf->SetFont ("Times", "",8);
$pdf->Cell (35,5,$Matricula,0,0);

//Lota��o
$pdf->Rect( 10, 46, 145, 5 , "D");
$pdf->SETXY (10, 46);
$pdf->SetFont( "Times", "B",9);
$pdf->Cell (145,5, utf8_decode("Lotação:"),0,0);
$pdf->SETXY (23, 46);
$pdf->SetFont ("Times", "",8);
$pdf->Cell (145,5,$EstruturaAtuacaoNome,0,0);

// Empenho
$pdf->Rect (155, 46, 45, 5 , "D");
$pdf->SetFont ("Times", "B",9);
$pdf->SETXY (155, 46);
$pdf->Cell (46,5,"Empenho:",0,0);
$pdf->SETXY (172, 46);
$pdf->SetFont ("Times", "",8);
$pdf->Cell (45,5,$Empenho,0,0);


//Cargo/Func�o
$pdf->Rect (10, 52, 145, 5 , "D");
$pdf->SETXY (10, 52);
$pdf->SetFont ("Times", "B",9);
$pdf->Cell (145,5, utf8_decode("Cargo/Função: "),0,0);
$pdf->SETXY (32, 52);
$pdf->SetFont ("Times", "",8);
$pdf->Cell (145,5,utf8_decode($CargoNome),0,0);

//Processo
$pdf->Rect (155, 52, 45, 5 , "D");
$pdf->SetFont ("Times", "B",9);
$pdf->SETXY (155, 52);
$pdf->Cell (52,5,"Processo:",0,0);
$pdf->SETXY (172, 52);
$pdf->SetFont ("Times", "",8);
$pdf->Cell (45,5,$Processo,0,0);


//CPF
$pdf->Rect (10, 58, 60, 5 , "D");
$pdf->SETXY (10, 58);
$pdf->SetFont( "Times", "B",9);
$pdf->Cell (60,5,"CPF:",0,0);
$pdf->SETXY (18, 58);
$pdf->SetFont ("Times", "",8);
$pdf->Cell (60,5,$CPF,0,0);


//Dados Banc�rios
$pdf->Rect (70, 58, 130, 5 , "D");
$pdf->SetFont( "Times", "B",9);
$pdf->SETXY (70, 58);
$pdf->Cell (130,5, utf8_decode("Dados Bancários:"),0,0);
$pdf->SETXY (95, 58);
$pdf->SetFont ("Times", "",8 );
$pdf->Cell (130,5,"Bco.".$Banco." - Ag. ".$Agencia." - CC.".$Conta,0,0);


//Dados ACP
$pdf->SETXY (10, 64);
$pdf->MultiCell( 190,5,"",1,0);
$pdf->SetFont ("Times", "B",9);
$pdf->SETXY (10, 64);
$pdf->Cell (190,5,"ACP:",0,0);
$pdf->SETXY (19, 64);
$pdf->SetFont ("Times", "",8);
$pdf->Cell (190,5,$UnidadeCustoNumero." - ".$UnidadeCustoNome,0,0);

if($qtdeRoteiros > 0)
{
    $pagina = 1;
    $pdf->SetFont ("Times", "B",8);
    $pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
    $pdf->Text (196, 285 , $pagina);
    //Projeto
    $pdf->Rect (10, 70, 190, 5 , "D");
    $pdf->SETXY (10, 70);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,5,"Projeto:",0,0);
    $pdf->SETXY (23, 70);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (190,5,utf8_decode("Projeto: ".$Projeto." / Produto: ".$Acao." / Território: ".$Territorio." / Fonte: ".$Fonte),0,0);
    //Motivo da Viagem

    $pdf->Rect (10, 76, 190, 13 , "D");
    $pdf->SETXY (10, 77);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,4,"Motivo da Viagem:",0,0);
    $pdf->SETXY (10, 82);
    $pdf->SetFont ("Times", "",7);
    $pdf->MultiCell (160,3,utf8_decode($Descricao),0,1);

    //Justificativa do Fim de Semana e Feriado

    $pdf->Rect (10, 90, 190, 13 , "D");
    $pdf->SETXY (10, 91);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,5,"Justificativa do Fim de Semana e Feriado:",0,0);
    $pdf->SETXY (10, 97);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (190,3,utf8_decode($JustificativaFimSemana.$JustificativaFeriado),0,1);
    
    $controle = 0;
    $posicao  = 0;
    $posicaoInicio = 0;
    
    while($controle < $qtdeRoteiros)
    {                
        $sqlConsultaMultiplo = " SELECT drm.diaria_dt_saida,drm.diaria_hr_saida,drm.diaria_dt_chegada,drm.diaria_hr_chegada,drm.diaria_qtde, drm.diaria_valor, drm.diaria_desconto,
                                        drmc.dados_roteiro_comprovacao_id, drmc.diaria_comprovacao_dt_saida,drmc.diaria_comprovacao_hr_saida,drmc.diaria_comprovacao_dt_chegada,drmc.diaria_comprovacao_hr_chegada,drmc.diaria_comprovacao_qtde,drmc.diaria_comprovacao_valor,drmc.diaria_resumo_comprovacao,drmc.dados_roteiro_comprovacao_id,drmc.diaria_comprovacao_desconto,drmc.diaria_comprovacao_saldo,drmc.diaria_comprovacao_saldo_tipo,diaria_roteiro_comprovacao_complemento,
                                        dc.diaria_comprovacao_qtde AS qtde_total, dc.diaria_comprovacao_valor AS valor_total, dc.diaria_comprovacao_saldo AS saldo_total ,dc.diaria_comprovacao_saldo_tipo AS saldo_tipo_total
                                 FROM diaria.dados_roteiro_multiplo drm
                                 JOIN diaria.dados_roteiro_multiplo_comprovacao drmc ON drm.diaria_id = drmc.diaria_id
                                 JOIN diaria.diaria_comprovacao dc ON dc.diaria_id = drmc.diaria_id
                                 WHERE dc.diaria_id = $Codigo
                                 AND controle_roteiro = $controle
                                 AND drmc.controle_roteiro_comprovacao = $controle
                                 AND dados_roteiro_status = 0"; 
        
        $rsConsultaMultiplo    = pg_query(abreConexao(),$sqlConsultaMultiplo);
        $linhaConsultaMultiplo = pg_fetch_assoc($rsConsultaMultiplo);
        $Resumo = $linhaConsultaMultiplo['diaria_resumo_comprovacao'];
        
        /*
        '******************************************************************************************
        'Partida Prevista
        '******************************************************************************************
         */
        $pdf->Rect (10, 104+$posicao, 45, 4 , "D");
        $pdf->SETXY (10, 105+$posicao);
        $pdf->SetFont( "Times", "B",9);
        $pdf->MultiCell (45,3,"Partida Prevista",0,"C",0);
        $pdf->SETXY (10, 108+$posicao);
        $pdf->Rect (10, 108+$posicao, 25, 10 , "D");
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (25,5,$linhaConsultaMultiplo['diaria_dt_saida'],0,"C",0);
        $pdf->SETXY (10, 112+$posicao);
        $pdf->MultiCell (25,5,utf8_decode(diasemana($linhaConsultaMultiplo['diaria_dt_saida'])),0,"C",0);
        
        //Horas
        $pdf->Rect (35, 108+$posicao, 20, 10 , "D");
        $pdf->SETXY (35, 112+$posicao);
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (20,5,$linhaConsultaMultiplo['diaria_hr_saida'],0,"C",0);
        
        /*
        'Partida Prevista
         */
        $pdf->Rect (55, 104+$posicao, 45, 4 , "C");
        $pdf->SetFont ("Times", "B",9);
        $pdf->SETXY (55, 105+$posicao);
        $pdf->MultiCell (45,3,"Chegada Prevista",0,"C",0);
        $pdf->SETXY (55, 108+$posicao);
        $pdf->Rect (55, 108+$posicao, 25, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (25,5,$linhaConsultaMultiplo['diaria_dt_chegada'],0,"C",0);
        $pdf->SETXY (55, 112+$posicao);
        $pdf->MultiCell (25,5,utf8_decode(diasemana($linhaConsultaMultiplo['diaria_dt_chegada'])),0,"C",0);

        //Horas
        $pdf->Rect(55, 108+$posicao, 45, 10 , "D");
        $pdf->SETXY (80, 112+$posicao);
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (20,5,$linhaConsultaMultiplo['diaria_hr_chegada'],0,"C",0);
        
        $pdf->SETXY (100, 104+$posicao);
        $pdf->Rect (100, 104+$posicao, 100, 4 , "D");
        $pdf->SETXY (100, 104+$posicao);
        $pdf->SetFont ("Times", "B",9);
        $pdf->MultiCell (95,5, utf8_decode("Diárias Rercebidas"),0,"C",0);
        
        //Diarias        
        $pdf->SetFont ("Times", "",9);
        $pdf->SETXY (87, 109+$posicao);
        $pdf->MultiCell (45,3,"Qtde",0,"C",0);
        $pdf->SETXY (55, 108+$posicao);
        $pdf->Rect (100, 108+$posicao, 20, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (100, 112+$posicao);
        $pdf->MultiCell (20,5,$linhaConsultaMultiplo['diaria_qtde'],0,"C",0);
        
        /*Redução 50%
        '******************************************************************************************
         */        
        $pdf->SetFont ("Times", "",9);
        $pdf->SETXY (105, 109+$posicao);
        $pdf->MultiCell (45,3,"Red.50%",0,"C",0);
        $pdf->SETXY (55, 108+$posicao);
        $pdf->Rect (120, 108+$posicao, 15, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (120, 112+$posicao);
        $pdf->MultiCell (15,5,utf8_decode($linhaConsultaMultiplo['diaria_desconto']),0,"C",0);
        /*
        '******************************************************************************************
        'Valor Ref.
         */        
        $pdf->SetFont ("Times", "",9);
        $pdf->SETXY (135, 109+$posicao);
        $pdf->MultiCell (20,3,"Valor Ref.",0,"C",0);
        $pdf->SETXY (55, 108+$posicao);
        $pdf->Rect (135, 108+$posicao, 20, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (135, 112+$posicao);
        $pdf->MultiCell( 20,5,$ValorRef,0,"C",0);
        
        //Total.        
        $pdf->SetFont ("Times", "",9);
        $pdf->SETXY (155, 109+$posicao);
        $pdf->MultiCell (45,3,"Valor Total",0,"C",0);
        $pdf->SETXY (55, 108+$posicao);
        $pdf->Rect (155, 108+$posicao, 45, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (155, 112+$posicao);
        $pdf->MultiCell (45,5,'R$ '.number_format($linhaConsultaMultiplo['diaria_valor'], 2, ',', '.'),0,"C",0);
        
        //EFETIVO                        
        /*
        '******************************************************************************************
        'Partida Efetivo  
        '******************************************************************************************
         */
        $pdf->Rect (10, 119+$posicao, 45, 4 , "D");
        $pdf->SETXY (10, 120+$posicao);
        $pdf->SetFont( "Times", "B",9);
        $pdf->MultiCell (45,3,"Partida Efetiva",0,"C",0);
        $pdf->SETXY (10, 123+$posicao);
        $pdf->Rect (10, 123+$posicao, 25, 10 , "D");
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (25,5,$linhaConsultaMultiplo['diaria_comprovacao_dt_saida'],0,"C",0);
        $pdf->SETXY (10, 127+$posicao);
        $pdf->MultiCell (25,5,utf8_decode(diasemana($linhaConsultaMultiplo['diaria_comprovacao_dt_saida'])),0,"C",0);
        
        //Horas
        $pdf->Rect (35, 123+$posicao, 20, 10 , "D");
        $pdf->SETXY (35, 127+$posicao);
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (20,5,$linhaConsultaMultiplo['diaria_comprovacao_hr_saida'],0,"C",0);
        
        /*
        'Chegada Efetiva
         */
        $pdf->Rect (55, 119+$posicao, 45, 4 , "C");
        $pdf->SetFont ("Times", "B",9);
        $pdf->SETXY (55, 120+$posicao);
        $pdf->MultiCell (45,3,"Chegada Efetiva",0,"C",0);
        $pdf->SETXY (55, 123+$posicao);
        $pdf->Rect (55, 123+$posicao, 25, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (25,5,$linhaConsultaMultiplo['diaria_comprovacao_dt_chegada'],0,"C",0);
        $pdf->SETXY (55, 127+$posicao);
        $pdf->MultiCell (25,5,utf8_decode(diasemana($linhaConsultaMultiplo['diaria_comprovacao_dt_chegada'])),0,"C",0);

        //Horas
        $pdf->Rect(55, 123+$posicao, 45, 10 , "D");
        $pdf->SETXY (80, 127+$posicao);
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (20,5,$linhaConsultaMultiplo['diaria_comprovacao_hr_chegada'],0,"C",0);
        
        $pdf->SETXY (100, 119+$posicao);
        $pdf->Rect (100, 119+$posicao, 62, 4 , "D");
        $pdf->SETXY (100, 119+$posicao);
        $pdf->SetFont ("Times", "B",9);
        $pdf->MultiCell (62,5, utf8_decode("Diárias Utilizadas"),0,"C",0);
        
        //Diarias        
        $pdf->SetFont ("Times", "",9);
        $pdf->SETXY (100, 124+$posicao);
        $pdf->MultiCell (10,5,"Qtde",0,"C",0);
        $pdf->SETXY (55, 123+$posicao);
        $pdf->Rect (100, 123+$posicao, 10, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (100, 127+$posicao);
        $pdf->MultiCell (10,5,$linhaConsultaMultiplo['diaria_comprovacao_qtde'],0,"C",0);
        
        /*Redução 50%
        '******************************************************************************************
         */        
        $pdf->SetFont ("Times", "",9);
        $pdf->SETXY (110, 124+$posicao);
        $pdf->MultiCell (15,5,"Red.50%",0,"C",0);
        $pdf->SETXY (55, 123+$posicao);
        $pdf->Rect (110, 123+$posicao, 15, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (110, 127+$posicao);
        $pdf->MultiCell (15,5,utf8_decode($linhaConsultaMultiplo['diaria_comprovacao_desconto']),0,"C",0);
        /*
        '******************************************************************************************
        'Valor Ref.
         */        
        $pdf->SetFont ("Times", "",9);
        $pdf->SETXY (125, 124+$posicao);
        $pdf->MultiCell (17,5,"Valor Ref.",0,"C",0);
        $pdf->SETXY (55, 123+$posicao);
        $pdf->Rect (125, 123+$posicao, 17, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (125, 127+$posicao);
        $pdf->MultiCell( 17,5,$ValorRef,0,"C",0);
        
        //Total.        
        $pdf->SetFont ("Times", "",9);
        $pdf->SETXY (142, 124+$posicao);
        $pdf->MultiCell (20,5,"Valor Total",0,"C",0);
        $pdf->SETXY (55, 123+$posicao);
        $pdf->Rect (142, 123+$posicao, 20, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (142, 127+$posicao);
        $pdf->MultiCell (20,5,'R$ '.number_format($linhaConsultaMultiplo['diaria_comprovacao_valor'], 2, ',', '.'),0,"C",0);
        
        //Di�ria Utilizadas
        $pdf->SETXY (162,119+$posicao);
        $pdf->Rect (162, 119+$posicao, 38, 4 , "D");
        $pdf->SETXY (162, 119+$posicao);
        $pdf->SetFont ("Times", "B",9);
        $pdf->MultiCell (38,5,"Saldo",0,"C",0);
        
        if($linhaConsultaMultiplo['diaria_comprovacao_saldo_tipo'] == "D")
        {
            $saldoReceber   = '0,00';
            $saldoRestituir = $linhaConsultaMultiplo['diaria_comprovacao_saldo'];
        }
        elseif($linhaConsultaMultiplo['diaria_comprovacao_saldo_tipo'] == "C")
        {
            $saldoReceber   = $linhaConsultaMultiplo['diaria_comprovacao_saldo'];
            $saldoRestituir = '0,00';
        }
        else
        {
            $saldoReceber   = '0,00';
            $saldoRestituir = '0,00';
        }
        
        //A Receber
        $pdf->SETXY (162, 124+$posicao);
        $pdf->Rect (162, 123+$posicao, 19, 10 , "D");
        $pdf->SetFont( "Times", "",9);
        $pdf->MultiCell (19,5,"A Receber",0,"C",0);
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (162, 128+$posicao);
        $pdf->MultiCell (19,5,'R$ '.$saldoReceber,0,"C",0);


        //A Restituir
        $pdf->SETXY (181, 124+$posicao);
        $pdf->Rect (181, 123+$posicao, 19, 10 , "D");
        $pdf->SetFont ("Times", "",9);
        $pdf->MultiCell (19,5,"A Restituir",0,"C",0);
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (181, 128+$posicao);
        $pdf->MultiCell (19,5,'R$ '.$saldoRestituir,0,"C",0);
        
        $sqlRoteiroMultiplo = "SELECT roteiro_comprovacao_origem, roteiro_comprovacao_destino FROM diaria.roteiro_comprovacao WHERE diaria_id = ".$Codigo." AND controle_roteiro_comprovacao = ".$controle;

        $rsRoteiroMultiplo = pg_query(abreConexao(),$sqlRoteiroMultiplo);

        $qtdDeRegistro = pg_num_rows($rsRoteiroMultiplo);
        $Contador = $qtdDeRegistro;
        $i = 1;
        $RoteiroComprovacao = "";
        $Meio = "";

        While($linharsRoteiro = pg_fetch_assoc($rsRoteiroMultiplo))
        {  
            $sqlRoteiroOrigem 		= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_comprovacao_origem'];
            $rsRoteiroOrigem 		= pg_query(abreConexao(),$sqlRoteiroOrigem);
            $linharsRoteiroOrigem	= pg_fetch_assoc($rsRoteiroOrigem);

            $sqlRoteiroDestino 		= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_comprovacao_destino'];
            $rsRoteiroDestino 		= pg_query(abreConexao(),$sqlRoteiroDestino);
            $linharsRoteiroDestino	= pg_fetch_assoc($rsRoteiroDestino);

            $RoteiroComprovacao.=  "  DE:  ".$linharsRoteiroOrigem['municipio_ds']." - ".$linharsRoteiroOrigem['estado_uf']."  PARA:  ".$linharsRoteiroDestino['municipio_ds']." - ".$linharsRoteiroDestino['estado_uf']."  /";
            $i++;

        }

        $pdf->Rect (10, 134+$posicao, 190, 11 , "D");
        $pdf->SETXY (10, 134+$posicao);
        $pdf->SetFont ("Times", "B",9);
        $pdf->Cell (60,4,"Destino:",0,0);
        $pdf->SETXY (23, 135+$posicao);
        $pdf->SetFont ("Times", "",7);
        $pdf->MultiCell (170,3,utf8_decode($RoteiroComprovacao),0,1);
        
        If ($Complemento == "1")
        {          
            $ComplementoJustificativa = $linhaConsultaMultiplo['diaria_roteiro_comprovacao_complemento'];
            //Justificativa do Fim de Semana e Feriado
            $pdf->Rect (10, 146+$posicao, 190, 9 , "D");
            $pdf->SETXY (10, 146+$posicao);
            $pdf->SetFont ("Times", "B",9);
            $pdf->Cell (190,5,utf8_decode("Justificativa do Complemento (Conforme Art. 4° parágrafo 2° do DECRETO N° 5.910 de Outubro de 1996.)"),0,0);
            $pdf->SETXY (10, 150+$posicao);
            $pdf->SetFont ("Times", "",8);
            $pdf->Cell (190,5,utf8_decode($ComplementoJustificativa),0,0);

            //Relat�rio

            $pdf->Rect (10, 166+$posicao, 190, 5 , "D");
            $pdf->SETXY (95, 166+$posicao);
            $pdf->SetFont( "Times", "B",9);
            $pdf->Cell (60,5, utf8_decode("Relatório de Atividades:"),0,0);
            $pdf->SETXY (10, 171+$posicao);
            $pdf->SetFont ("Times", "",7);
            
            //Quebra de linha 
            $Resumo = str_replace("\n", "*", "$Resumo");
            $SliptedResumo = preg_split('[\*]',  utf8_decode($Resumo), -1, PREG_SPLIT_OFFSET_CAPTURE);
            $tamanhoDaLinha = 50;
            foreach($SliptedResumo as $Res)
            {
                $pdf->MultiCell (190,5,$Res[0],0,1);
            }
            $pdf->Rect (10, 166+$posicao, 190, 50 , "D");		
        }
        else
        {
            //Relat�rio
            $pdf->Rect (10, 146+$posicao, 190, 5 , "D");
            $pdf->SETXY (90, 146+$posicao);
            $pdf->SetFont ("Times", "B",9);
            $pdf->Cell (60,5, utf8_decode("Relatório de Atividades:"),0,0);
            $pdf->SETXY (10, 152+$posicao);
            $pdf->SetFont ("Times", "",7);
            //Quebra de linha 
            $Resumo = str_replace("\n", "*", "$Resumo");
            $SliptedResumo = preg_split('[\*]', utf8_decode($Resumo), -1, PREG_SPLIT_OFFSET_CAPTURE);
            $tamanhoDaLinha = 50;
            foreach($SliptedResumo as $Res)
            {
                $pdf->MultiCell (190,3,$Res[0],0,1);
            }
                $pdf->Rect (10, 146+$posicao, 190, 50 , "D");
        }                
        
        if($controle == $posicaoInicio)
        {
            $pdf ->AddPage();
            $posicao = -188;
            
            $novaPagina = $pdf -> page;
            if($novaPagina > $pagina)
            {                                          
                $pdf->SetFont ("Times", "B",8);
                $pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
                $pdf->Text (196, 285 , $novaPagina);   
                $pagina = $novaPagina;
                $pdf->SetFont ("Times", "",8);
            }
            $posicaoInicio = $posicaoInicio + 2;
        }        
        
        $posicao = $posicao + 95;        
        $controle ++;
    }    
    
    if($linhaConsultaMultiplo['saldo_tipo_total'] == "D")
    {
        $saldoReceber   = '0,00';
        $saldoRestituir = $linhaConsultaMultiplo['saldo_total'];
    }
    elseif($linhaConsultaMultiplo['saldo_tipo_total'] == "C")
    {
        $saldoReceber   = $linhaConsultaMultiplo['saldo_total'];
        $saldoRestituir = '0,00';
    }
    else
    {
        $saldoReceber   = '0,00';
        $saldoRestituir = '0,00';
    }
    
    if($qtdeRoteiros % 2 == 0)
    {
        $posicao = $posicao - 80;
    }
    else
    {
        $posicao = $posicao + 30;
    }
    
    $pdf->SETXY (10,(-110+$posicao));
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (45,5,utf8_decode("Total de Diárias:"),1,1);
    $pdf->SETXY (36,(-109+$posicao));
    $pdf->MultiCell(45,3,$linhaConsultaMultiplo['qtde_total'],0,1);
    $pdf->SETXY (55,(-110+$posicao));
    $pdf->MultiCell (50,5,"Valor Total:",1,1);
    $pdf->SETXY (86,(-109+$posicao));
    $pdf->MultiCell(50,3,'R$ '.number_format($linhaConsultaMultiplo['valor_total'], 2, ',', '.'),0,1);
    $pdf->SETXY (105,(-110+$posicao));
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (45,5,utf8_decode("A Receber:"),1,1);
    $pdf->SETXY (136,(-109+$posicao));
    $pdf->MultiCell(45,3,'R$ '.number_format($saldoReceber, 2, ',', '.'),0,1);
    $pdf->SETXY (150,(-110+$posicao));
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (50,5,"A Restituir:",1,1);
    $pdf->SETXY (186,(-109+$posicao));
    $pdf->MultiCell(50,3,'R$ '.number_format($saldoRestituir, 2, ',', '.'),0,1);
    
    //Relatório

    $pdf->Rect (10, 232, 63, 5 , "D");
    $pdf->SETXY (30, 232);
    $pdf->SetFont( "Times", "B",9);
    $pdf->Cell (60,5, utf8_decode("Beneficiário"),0,0);
    $pdf->SETXY (10, 238);
    $pdf->Cell (63,26,"",1,0);


    //Relat�rio

    $pdf->Rect (73, 232, 63, 5 , "D");
    $pdf->SETXY (90, 232);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,5,"Dirigente da Unidade",0,0);
    $pdf->SETXY (73, 238);
    $pdf->Cell (63,26,"",1,0);


    //Relat�rio

    $pdf->Rect (136, 232, 64, 5 , "D");
    $pdf->SETXY (160, 232);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (61,5,"Diretor",0,0);
    $pdf->SETXY (136, 238);
    $pdf->Cell (64,26," ",1,1);

    // Datas
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (33,4,utf8_decode("Data da Solicitação       :"),0,0);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (33,4,  f_FormataData($DataCriacao). " - " . $HoraCriacao,0,1);
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (33,4,utf8_decode("Data da Comprovação :"),0,0);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (33,4,f_FormataData($DataDaComprovacao). " - " . $HoraDaComprovacao,0,1);
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (33,4,utf8_decode("Data da Impressão       :"),0,0);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (33,4,date("d/m/Y - H:i:s"),0,1);
}
else 
{
    //Partida Prevista
    $pdf->Rect (10, 70, 46, 4 , "D");
    $pdf->SETXY( 10, 71);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (46,3,"Partida Prevista",0,"C",0);
    $pdf->SETXY (10, 75);
    $pdf->Rect (10, 74, 26, 10 , "D");
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (25,5,$DataPartida,0,"C",0);
    $pdf->SETXY (10, 78);
    $pdf->MultiCell (25,5,utf8_decode($DiaSemanaPartida),0,"C",0);

    //Horas
    $pdf->Rect (36, 74, 20, 10 , "D");
    $pdf->SETXY( 36, 76);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (21,5,$HoraPartida,0,"C",0);



    //Chegada Prevista
    $pdf->Rect (56, 70, 46, 4 , "D");
    $pdf->SETXY (56, 71);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (46,3,"Chegada Prevista",0,"C",0);
    $pdf->SETXY (56, 75);
    $pdf->Rect (56, 74, 25, 10 , "D");
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (26,5,$DataChegada,0,"C",0);
    $pdf->SETXY (56, 78);
    $pdf->MultiCell (26,5,utf8_decode($DiaSemanaChegada),0,"C",0);

    //Horas
    $pdf->Rect (81, 74, 21, 10 , "D");
    $pdf->SETXY (81, 76);
    $pdf->SetFont( "Times", "",8);
    $pdf->MultiCell (21,5,$HoraChegada,0,"C",0);




    //Partida Efetiva
    $pdf->Rect (10, 85, 46, 4 , "D");
    $pdf->SETXY (10, 86);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (45,3,"Partida Efetiva",0,"C",0);

    $pdf->SETXY (10, 89);
    $pdf->Rect (10, 89, 26, 10 , "D");
    $pdf->SetFont( "Times", "",8);
    $pdf->MultiCell (25,7,$diaria_comprovacao_dt_saida,0,"C",0);

    $pdf->SETXY(10, 93);
    $pdf->MultiCell (25,5,utf8_decode(diasemana($diaria_comprovacao_dt_saida)),0,"C",0); 

    $pdf->Rect (36, 89, 20, 10 , "D");
    $pdf->SETXY (36, 91);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (22,5,$linharsComprovacao['diaria_comprovacao_hr_saida'],0,"C",0);

    //chegada Efetiva
    $pdf->Rect(56, 85, 46, 4 , "D");
    $pdf->SETXY (56, 85);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (45,5,"Chegada Efetiva",0,"C",0);

    $pdf->SETXY (56, 89);
    $pdf->Rect (56, 89, 25, 10 , "D");
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (25,7,$diaria_comprovacao_dt_chegada,0,"C",0);

    $pdf->SETXY (58, 93);
    $pdf->MultiCell (22,5,utf8_decode(diasemana($diaria_comprovacao_dt_chegada)),0,"C",0); 

    $pdf->Rect (81, 89, 21, 10 , "D");
    $pdf->SETXY (81, 91);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (22,5,$linharsComprovacao['diaria_comprovacao_hr_chegada'],0,"C",0);

    //Di�ria Rercebidas
    $pdf->SETXY (102, 70);
    $pdf->Rect (102, 70, 98, 4 , "D");
    $pdf->SETXY (102, 70);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (95,5, utf8_decode("Diárias Rercebidas"),0,"C",0);

    //Qtde
    $pdf->SETXY (102, 74);
    $pdf->Rect (102, 74, 20, 10 , "D");
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (20,5,"Qtde",0,"C",0);

    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (102, 78);
    $pdf->MultiCell (20,5,$Qtde,0,"C",0);

    //Valor Unit�rio
    $pdf->SETXY (122, 74);
    $pdf->Rect (122, 74, 27, 10 , "D");

    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell(27,5, "Valor Total",0,"C",0);

    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (122,78);
    $pdf->MultiCell (27,5,$Valor,0,"C",0);

    //Valor Total
    $pdf->SETXY (149, 74);
    $pdf->Rect (149, 74, 21, 10 , "D");

    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (21,5,utf8_decode("Unitário"),0,"C",0);

    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (149, 78);
    $pdf->MultiCell (21,5,$ValorRef,0,"C",0);

    //Novo
    $pdf->SETXY (170, 74);
    $pdf->Rect (170, 74, 30, 10 , "D");

    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (30,5,'',0,"C",0);

    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (170, 78);
    $pdf->MultiCell (30,5,'',0,"C",0);
    //utf8_decode("Unitário Comprovado")$valorComprovacaoRef
    //Di�ria Utilizadas
    $pdf->SETXY (102, 85);
    $pdf->Rect (102, 85, 60, 4 , "D");
    $pdf->SETXY (101, 86);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (60,3, utf8_decode("Diárias Utilizadas"),0,"C",0);

    //Qtde
    $pdf->SETXY (102, 89);
    $pdf->Rect (102, 89, 12, 10 , "D");
    $pdf->SetFont( "Times", "B",9);
    $pdf->MultiCell (12,5,"Qtde",0,"C",0);
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (102, 93);
    $pdf->MultiCell (12,5,$QtdeComprovacao,0,"C",0);


    //Valor Total
    $pdf->SETXY (114, 89);
    $pdf->Rect (114, 89, 28, 10 , "D");
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (28,5,"Valor Total",0,"C",0);
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (114, 93);
    $pdf->MultiCell (28,5,$ValorComprovacao,0,"C",0);


    //Valor Referência Comprovado
    $pdf->SETXY (142, 89);
    $pdf->Rect (142, 89, 20, 10, "D");
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (20,5, utf8_decode("Unitário"),0,"C",0);
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (142, 93);
    $pdf->MultiCell (20,5,$valorComprovacaoRef,0,"C",0);


    //Di�ria Utilizadas
    $pdf->SETXY (162,85);
    $pdf->Rect (162, 85, 38, 4 , "D");
    $pdf->SETXY (162, 86);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (38,3,"Saldo",0,"C",0);


    //A Receber
    $pdf->SETXY (162, 89);
    $pdf->Rect (162, 89, 19, 10 , "D");
    $pdf->SetFont( "Times", "B",9);
    $pdf->MultiCell (19,5,"A Receber",0,"C",0);
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (162, 93);
    $pdf->MultiCell (19,5,'R$ '.number_format($SaldoReceber, 2, ',', '.'),0,"C",0);


    //A Restituir
    $pdf->SETXY (181, 89);
    $pdf->Rect (181, 89, 19, 10 , "D");
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (19,5,"A Restituir",0,"C",0);
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (181, 93);
    $pdf->MultiCell (19,5,'R$ '.number_format($SaldoPagar, 2, ',', '.'),0,"C",0);


    //Projeto
    $pdf->Rect (10, 100, 190, 5 , "D");
    $pdf->SETXY (10, 100);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,5,"Projeto:",0,0);
    $pdf->SETXY (23, 100);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (190,5,utf8_decode("Projeto: ".$Projeto." / Produto: ".$Acao." / Território: ".$Territorio." / Fonte: ".$Fonte),0,0);


    $sqlRoteiro = "SELECT roteiro_comprovacao_origem, roteiro_comprovacao_destino FROM diaria.roteiro_comprovacao WHERE diaria_id = ".$Codigo;

    $rsRoteiro = pg_query(abreConexao(),$sqlRoteiro);

    $qtdDeRegistro= pg_num_rows($rsRoteiro);
    $Contador = $qtdDeRegistro;
    $i =1;
    $RoteiroComprovacao = "";
    $Meio = "";

    While($linharsRoteiro = pg_fetch_assoc($rsRoteiro))
    {  
        $sqlRoteiroOrigem 		= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_comprovacao_origem'];
        $rsRoteiroOrigem 		= pg_query(abreConexao(),$sqlRoteiroOrigem);
        $linharsRoteiroOrigem	= pg_fetch_assoc($rsRoteiroOrigem);

        $sqlRoteiroDestino 		= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_comprovacao_destino'];
        $rsRoteiroDestino 		= pg_query(abreConexao(),$sqlRoteiroDestino);
        $linharsRoteiroDestino	= pg_fetch_assoc($rsRoteiroDestino);

        $RoteiroComprovacao.=  "  DE:  ".$linharsRoteiroOrigem['municipio_ds']." - ".$linharsRoteiroOrigem['estado_uf']."  PARA:  ".$linharsRoteiroDestino['municipio_ds']." - ".$linharsRoteiroDestino['estado_uf']."  /";
        $i++;

    }
    //$RoteiroComprovacao = $Inicio.$Meio.$Final;
    //Roteiro

    $pdf->Rect (10, 105, 190, 11 , "D");
    $pdf->SETXY (10, 105);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,4,"Destino:",0,0);
    $pdf->SETXY (23, 105);
    $pdf->SetFont ("Times", "",7);
    $pdf->MultiCell (170,3,utf8_decode($RoteiroComprovacao),0,1);

    //Motivo da Viagem

    $pdf->Rect (10, 116, 190, 13 , "D");
    $pdf->SETXY (10, 116);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,4,"Motivo da Viagem:",0,0);
    $pdf->SETXY (10, 120);
    $pdf->SetFont ("Times", "",7);
    $pdf->MultiCell (160,3,utf8_decode($Descricao),0,1);

    //Justificativa do Fim de Semana e Feriado

    $pdf->Rect (10, 130, 190, 13 , "D");
    $pdf->SETXY (10, 130);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,5,"Justificativa do Fim de Semana e Feriado:",0,0);
    $pdf->SETXY (10, 134);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (190,3,utf8_decode($JustificativaFimSemana.$JustificativaFeriado),0,1);

    If ($Complemento == "1")
    {
        //Justificativa do Fim de Semana e Feriado
        $pdf->Rect (10, 143, 190, 9 , "D");
        $pdf->SETXY (10, 143);
        $pdf->SetFont ("Times", "B",9);
        $pdf->Cell (190,5,utf8_decode("Justificativa do Complemento (Conforme Art. 4° parágrafo 2° do DECRETO N° 5.910 de Outubro de 1996.)"),0,0);
        $pdf->SETXY (10, 147);
        $pdf->SetFont ("Times", "",8);
        $pdf->Cell (190,5,utf8_decode($ComplementoJustificativa),0,0);

        //Relat�rio

        $pdf->Rect (10, 153, 190, 5 , "D");
        $pdf->SETXY (95, 153);
        $pdf->SetFont( "Times", "B",9);
        $pdf->Cell (60,5, utf8_decode("Relatório de Atividades:"),0,0);
        $pdf->SETXY (10, 158);
        $pdf->SetFont ("Times", "",7);
        //Quebra de linha 
        $Resumo = str_replace("\n", "*", "$Resumo");
        $SliptedResumo = preg_split('[\*]',  utf8_decode($Resumo), -1, PREG_SPLIT_OFFSET_CAPTURE);
        $tamanhoDaLinha = 50;
        foreach($SliptedResumo as $Res)
        {
            $pdf->MultiCell (190,5,$Res[0],0,1);
        }
        $pdf->Rect (10, 153, 190, 80 , "D");		
    }
    else
    {
        //Relat�rio
        $pdf->Rect (10, 143, 190, 5 , "D");
        $pdf->SETXY (90, 143);
        $pdf->SetFont ("Times", "B",9);
        $pdf->Cell (60,5, utf8_decode("Relatório de Atividades:"),0,0);
        $pdf->SETXY (10, 149);
        $pdf->SetFont ("Times", "",7);
        //Quebra de linha 
        $Resumo = str_replace("\n", "*", "$Resumo");
        $SliptedResumo = preg_split('[\*]', utf8_decode($Resumo), -1, PREG_SPLIT_OFFSET_CAPTURE);
        $tamanhoDaLinha = 50;
        foreach($SliptedResumo as $Res)
        {
            $pdf->MultiCell (190,3,$Res[0],0,1);
        }
            $pdf->Rect (10, 143, 190, 88 , "D");
    }

    //Relat�rio

    $pdf->Rect (10, 232, 63, 5 , "D");
    $pdf->SETXY (30, 232);
    $pdf->SetFont( "Times", "B",9);
    $pdf->Cell (60,5, utf8_decode("Beneficiário"),0,0);
    $pdf->SETXY (10, 238);
    $pdf->Cell (63,26,"",1,0);


    //Relat�rio

    $pdf->Rect (73, 232, 63, 5 , "D");
    $pdf->SETXY (90, 232);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,5,"Dirigente da Unidade",0,0);
    $pdf->SETXY (73, 238);
    $pdf->Cell (63,26,"",1,0);


    //Relat�rio

    $pdf->Rect (136, 232, 64, 5 , "D");
    $pdf->SETXY (160, 232);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (61,5,"Diretor",0,0);
    $pdf->SETXY (136, 238);
    $pdf->Cell (64,26," ",1,1);

    // Datas
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (33,4,utf8_decode("Data da Solicitação       :"),0,0);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (33,4,  f_FormataData($DataCriacao). " - " . $HoraCriacao,0,1);
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (33,4,utf8_decode("Data da Comprovação :"),0,0);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (33,4,f_FormataData($DataDaComprovacao). " - " . $HoraDaComprovacao,0,1);
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (33,4,utf8_decode("Data da Impressão       :"),0,0);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (33,4,date("d/m/Y - H:i:s"),0,1);
}
$pdf->Close();
ob_start ();
$pdf->Output();
?>