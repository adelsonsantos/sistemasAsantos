<?php
//@language=vbscript
include "../Include/Inc_Configuracao.php";

include "Classe/ClasseDiariaGestaoPdf.php";
include "Fpdf.php";

//if($impProcessoSt == '1')
//{
//    $documentoVia = '2° Via';
//}
//else if ($impProcessoSt == '0')
//{
//    $documentoVia = '';
//}

$pdf=new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();

/*Cabe�alho
******************************************************************************************
 */

//Imagem Logo
$pdf->image ("../Imagens/logo.jpg",14,18,40);

$pdf->Cell (55,24,"",1,0,"C"); //Logo

$pdf->SETX (65);
$pdf->Cell (135,12,utf8_decode("Solicitação de Diárias"),1,1,"C");

$pdf->SETXY (65, 22);
$pdf->SetFont ("Times", "B",9);
$pdf->write (5,utf8_decode("Área Beneficiária"));
$pdf->SETX (65);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (85,12,"",1,0); //�rea
$pdf->SETXY (65, 26);
$pdf->MultiCell (80,4,$UnidadeCustoNome,0,1);

$pagina = 1;
$pdf->SetFont ("Times", "B",8);
$pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
$pdf->Text (196, 285 , $pagina);

/* Processo */
$pdf->SETXY (150, 22);
$pdf->SetFont ("Times", "B",9);
$pdf->write (5, "Processo");
$pdf->SetFont ("Times","",8);
$pdf->SETXY (150, 22);
$pdf->Cell (25,12,$Processo,1,1);

/* N�mero da diaria */
$pdf->SETXY (175, 22);
$pdf->SetFont ("Times", "B",9);
$pdf->write (5, utf8_decode("N° Diária"));
$pdf->SetFont ("Times","",8);

$pdf->SETXY (175, 22);

$pdf->Cell (25,12,$Numero,1,1);

/* Nome Benefici�rio */

$pdf->Rect (10, 35, 140, 10 , "D");
$pdf->SETXY (10, 35);
$pdf->SetFont ("Times", "B",9);
$pdf->MultiCell (10,5,"Nome",0,0);
$pdf->SETXY (10, 39);
$pdf->SetFont ("Times", "",8);
$pdf->Cell (50,5,utf8_decode($BeneficiarioNome),0,0);

/* Tipo de Servidor */

$pdf->Rect (150, 35, 25, 10 , "D");
$pdf->SetFont ("Times", "B",9);
$pdf->SETXY (141, 35);
$pdf->MultiCell (30,5,"Tipo Servidor",0,0);
$pdf->SETXY (141, 39);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (29,5,utf8_decode($TipoUsuario),0,0);

/* Matr�cula */
$pdf->Rect (175, 35, 25, 10 , "D");
$pdf->SetFont ("Times", "B",9);
$pdf->SETXY (174, 35);
$pdf->MultiCell (16,5,utf8_decode("Matrícula"),0,0);
$pdf->SETXY (169, 39);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (21,5,$Matricula,0,0);

/*Lota��o
'******************************************************************************************
 */
$pdf->Rect (10, 46, 90, 15 , "D");
$pdf->SETXY (10, 46);
$pdf->SetFont ("Times", "B",9);
$pdf->MultiCell (90,5,utf8_decode("Lotação "),0,1);
$pdf->SETXY (10, 50);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (90,5,$EstruturaAtuacaoNome,0,1);

/*ACP
'******************************************************************************************
 */
$pdf->Rect (100, 46, 100, 15,"D");
$pdf->SetFont( "Times", "B",9);
$pdf->SETXY (20, 46);
$pdf->MultiCell (89,5,"ACP",0,0);
$pdf->SETXY (100, 50);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (100,5,$UnidadeCustoNumero."-".$UnidadeCustoNome,0,1);
/*
'******************************************************************************************

Cargo/Fun��o
******************************************************************************************
 */
$pdf->Rect (10, 62, 140, 10 , "D");
$pdf->SETXY (10, 62);
$pdf->SetFont ("Times", "B",9);
$pdf->MultiCell (90,5,utf8_decode("Cargo/Função "),0,1);
$pdf->SETXY (10, 66);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (90,5,utf8_decode($CargoNome),0,1);
/*
'******************************************************************************************
'Escolaridade
'******************************************************************************************
 */
$pdf->Rect (150, 62, 50, 10 , "D");
$pdf->SetFont ("Times", "B",9);
$pdf->SETXY (150, 62);
$pdf->MultiCell (90,5,"Escolaridade",0,1);
$pdf->SETXY (150, 66);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (50,5,utf8_decode($EscolaridadeNome),0,1);
/*
'******************************************************************************************
'Endere�o Benefici�rio
'******************************************************************************************
 */
$pdf->Rect (10, 73, 190, 10 , "D");
$pdf->SETXY (10, 73);
$pdf->SetFont("Times", "B",9);
$pdf->MultiCell (160,5,utf8_decode("Endereço Beneficiário"),0,1);
$pdf->SETXY (10, 77);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (160,5,utf8_decode($Endereco),0,1);
/*
'******************************************************************************************
'CPF
 */
$pdf->Rect (10, 84, 35, 10 , "D");
$pdf->SETXY (10, 84);
$pdf->SetFont ("Times", "B",9);
$pdf->MultiCell (35,5,"CPF",0,1);
$pdf->SETXY (10, 88);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (35,5,$CPF,0,1);
/*
'Dados Banc�rios
'******************************************************************************************
 */
$pdf->Rect (45, 84, 55, 10 , "D");
$pdf->SetFont ("Times", "B",9);
$pdf->SETXY (45, 84);
$pdf->MultiCell (55,5,utf8_decode("Dados Bancários"),0,1);
$pdf->SETXY (45, 88);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (55,5,"Bco.".$Banco." - Ag. ".$Agencia." - CC." .$Conta,0,1);
/*
'******************************************************************************************
'Projeto:
'******************************************************************************************
 */

$pdf->Rect (100, 84, 100, 10 , "D");
$pdf->SetFont ("Times", "B",9);
$pdf->SETXY (100, 84);
$pdf->MultiCell (35,5,"Projeto ",0,1);
$pdf->SETXY (100, 88);
$pdf->SetFont ("Times", "",8);
$pdf->MultiCell (100,5,utf8_decode("Projeto ".$Projeto.", Produto " .$Acao. ", Território " .$Territorio.", Fonte " .$Fonte),0,1);

/*
'Inicio Roteiro
'*****************************************************************************************
 * 
 */   
if($qtdeRoteiros > 0)
{
    /*
    '******************************************************************************************
    'Meio de Transporte
    '******************************************************************************************
     */
    $pdf->Rect (10, 95, 190, 10 , "D");
    $pdf->SETXY (10, 95);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (190,5,"Meio de Transporte",0,1);
    $pdf->SETXY (10, 99);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (190,5,utf8_decode($MeioTransporte),0,1);
    /*
    'Detalhe do Motivo
    '******************************************************************************************
     */
    $pdf->Rect (10, 106, 190, 53 , "D");
    $pdf->SETXY (10, 106);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (160,5,"Motivo da Viagem",0,1);
    $pdf->SETXY (10, 110);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (190,5,utf8_decode($Descricao),0,1);   
    
    /*
    'justificativa do Final de Semana e Feriado
    '******************************************************************************************
     */
    $pdf->Rect (10, 160, 190, 23 , "D");
    $pdf->SETXY (10, 160);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (160,5,"Justificativa do Fim de Semana e Feriado",0,1);
    $pdf->SETXY (10, 164);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (190,3,utf8_decode($JustificativaFimSemana.$JustificativaFeriado),0,1);  
    $posicao = 0;    
    
    for($i = 0; $i < $qtdeRoteiros; $i++)
    {        
        /*
        '******************************************************************************************
        'Partida Prevista
        '******************************************************************************************
         */
        $pdf->Rect (10, 184+$posicao, 45, 4 , "D");
        $pdf->SETXY (10, 185+$posicao);
        $pdf->SetFont( "Times", "B",9);
        $pdf->MultiCell (45,3,"Partida Prevista",0,"C",0);
        $pdf->SETXY (10, 188+$posicao);
        $pdf->Rect (10, 188+$posicao, 25, 10 , "D");
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (25,5,$dataPartida[$i],0,"C",0);
        $pdf->SETXY (10, 192+$posicao);
        $pdf->MultiCell (25,5,utf8_decode($diaSemanaPartida[$i]),0,"C",0);
        /*
        '******************************************************************************************
        'Horas
         */
        $pdf->Rect (35, 188+$posicao, 20, 10 , "D");
        $pdf->SETXY (35, 192+$posicao);
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (20,5,$horaPartida[$i],0,"C",0);

        /*
        'Partida Prevista
         */
        $pdf->Rect (55, 184+$posicao, 45, 4 , "C");
        $pdf->SetFont ("Times", "B",9);
        $pdf->SETXY (55, 185+$posicao);
        $pdf->MultiCell (45,3,"Chegada Prevista",0,"C",0);
        $pdf->SETXY (55, 188+$posicao);
        $pdf->Rect (55, 188+$posicao, 25, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (25,5,$dataChegada[$i],0,"C",0);
        $pdf->SETXY (55, 192+$posicao);
        $pdf->MultiCell (25,5,utf8_decode($diaSemanaChegada[$i]),0,"C",0);

        //Horas
        $pdf->Rect(55, 188+$posicao, 45, 10 , "D");
        $pdf->SETXY (80, 192+$posicao);
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (20,5,$horaChegada[$i],0,"C",0);

        //Diarias

        $pdf->Rect (100, 184+$posicao, 20, 4 , "C");
        $pdf->SetFont ("Times", "B",9);
        $pdf->SETXY (87, 185+$posicao);
        $pdf->MultiCell (45,3,utf8_decode("Diárias"),0,"C",0);
        $pdf->SETXY (55, 188+$posicao);
        $pdf->Rect (100, 188+$posicao, 20, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (100, 192+$posicao);
        $pdf->MultiCell (20,5,$qtde[$i],0,"C",0);

        /*Redu��o 50%
        '******************************************************************************************
         */
        $pdf->Rect (120, 184+$posicao, 15, 4 , "C");
        $pdf->SetFont ("Times", "B",9);
        $pdf->SETXY (105, 185+$posicao);
        $pdf->MultiCell (45,3,"Red.50%",0,"C",0);
        $pdf->SETXY (55, 188+$posicao);
        $pdf->Rect (120, 188+$posicao, 15, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (120, 192+$posicao);
        $pdf->MultiCell (15,5,utf8_decode($desconto[$i]),0,"C",0);
        /*
        '******************************************************************************************
        'Valor Ref.
         */
        $pdf->Rect (135, 184+$posicao, 20, 4 , "C");
        $pdf->SetFont ("Times", "B",9);
        $pdf->SETXY (135, 185+$posicao);
        $pdf->MultiCell (20,3,"Valor Ref.",0,"C",0);
        $pdf->SETXY (55, 188+$posicao);
        $pdf->Rect (135, 188+$posicao, 20, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (135, 192+$posicao);
        $pdf->MultiCell( 20,5,$ValorRef,0,"C",0);

        //Total.

        $pdf->Rect (155, 184+$posicao, 25, 4 , "C");
        $pdf->SetFont ("Times", "B",9);
        $pdf->SETXY (155, 185+$posicao);
        $pdf->MultiCell (25,3,"Total",0,"C",0);
        $pdf->SETXY (55, 188+$posicao);
        $pdf->Rect (155, 188+$posicao, 25, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (155, 192+$posicao);
        $pdf->MultiCell (25,5,$valor[$i],0,"C",0);

        //Empenho.

        $pdf->Rect (180, 184+$posicao, 20, 4 , "C");
        $pdf->SetFont ("Times", "B",9);
        $pdf->SETXY (180, 185+$posicao);
        $pdf->MultiCell (20,3,utf8_decode("N° Empenho"),0,"C",0);
        $pdf->SETXY (55, 188+$posicao);
        $pdf->Rect (180, 188+$posicao, 20, 10 , "C");
        $pdf->SetFont ("Times", "",8);
        $pdf->SETXY (180, 192+$posicao);
        $pdf->MultiCell (20,5,$Empenho,0,"C",0);
        
        //Roteiro.
        
        $pdf->Rect (10, 199+$posicao, 190, 19 , "D");
        $pdf->SETXY (10, 199+$posicao);
        $pdf->SetFont ("Times", "B",9);
        $pdf->MultiCell (160,5,"Destino",0,1);
        $pdf->SETXY (10, 203+$posicao);
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell(190,4,utf8_decode($roteiro[$i]),0,1);                
        
        $posicao = $posicao + 35;
        
        if($i == 1)
        {
            $pdf ->AddPage();
            $posicao = -174;
            
            $novaPagina = $pdf -> page;
            if($novaPagina > $pagina)
            {                                          
                $pdf->SetFont ("Times", "B",8);
                $pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
                $pdf->Text (196, 285 , $novaPagina);   
                $pagina = $novaPagina;
                $pdf->SetFont ("Times", "",8);
            }
        }
    }        
    /*
    '******************************************************************************************
    'Total de diárias
    '******************************************************************************************
     */       
    $pdf->Rect (10, (-110+$posicao), 190, 5 , "D");
    $pdf->SETXY (10,(-110+$posicao));
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (95,5,utf8_decode("Total de Diárias:"),1,1);
    $pdf->SETXY (36,(-109+$posicao));
    $pdf->MultiCell(70,3,$Qtde,0,1);
    $pdf->SETXY (105,(-110+$posicao));
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (95,5,"Valor Total:",1,1);
    $pdf->SETXY (125,(-109+$posicao));
    $pdf->MultiCell(70,3,$Valor,0,1);          
    /*
    '******************************************************************************************
     *
     */
     // Nome do Autorizador 
    $pdf->Rect (10, 229, 95, 5 , "D");
    $pdf->SETXY (41, 229);
    $pdf->SetFont( "Times", "B",9);
    $pdf->Cell (60,5, utf8_decode("Coordenador da Unidade"),0,0);
    $pdf->SETXY (10, 234);
    $pdf->Cell (95,33,"",1,0);
    
    $Diaria_DT_Autorizacao = "Data da Autorização: " .$diaria_autorizacao_dt.' '.$diaria_autorizacao_hr;

    $pdf->SetFont ("Times", "",9);
    $pdf->SETXY (10, 238);
    //$pdf->MultiCell (93,5,$pessoa_nm_autorizador,0,"C",0);

    $pdf->SetFont ("Times", "",7);
    $pdf->SETXY (10, 260);
    $pdf->MultiCell (93,5,utf8_decode($Diaria_Matricula_Autorizacao),0,"C",0);
    $pdf->SETXY (10, 264);
    $pdf->MultiCell (93,2,utf8_decode($Diaria_DT_Autorizacao),0,"C",0);

    $pdf->Rect (105, 229, 95, 5 , "D");
    $pdf->SETXY (143, 229);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,5,"Diretor",0,0);
    $pdf->SETXY (105, 234);
    $pdf->Cell (95,33,"",1,0);

    $matricula_aprovador = ""; // Altera��o Para Dr. Adolfo poder Assinar as Di�rias

    $Diaria_Matricula_Aprovacao	= utf8_decode("Matrícula: " .$matricula_aprovador);
    $Diaria_DT_Aprovacao	= utf8_decode("Data da Aprovação: " .$diaria_aprovacao_dt.' '.$diaria_aprovacao_hr);

    $pdf->SetFont ("Times", "",9);
    $pdf->SETXY (105, 234);

    $pessoa_nm_aprovador = ""; // Altera��o Para Dr. Adolfo poder Assinar as Di�rias
    $pdf->MultiCell (93,5,$pessoa_nm_aprovador,0,"C",0);

    $pdf->SetFont ("Times", "",7);
    $pdf->SETXY (105, 234);

    $Diaria_Matricula_Aprovacao = "";// Altera��o Para Dr. Adolfo poder Assinar as Di�rias
    $pdf->MultiCell (93,5,$Diaria_Matricula_Aprovacao,0,"C",0);

    $pdf->SETXY (105, 264);
    $pdf->MultiCell (93,2,$Diaria_DT_Aprovacao,0,"C",0);

    // Datas
    $pdf->SETXY (10, 268);
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (28,4,utf8_decode("Data da Solicitação:"),0,0);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (28,4,$DataDaSolicitacao . " - " . $HoraDaSolicitacao,0,1);
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (28,4,utf8_decode("Data da Impressão:"),0,0);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (28,4,date("d/m/Y - H:i:s"),0,1);
}
else
{
    $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$Codigo;

    $rsRoteiro = pg_query(abreConexao(),$sqlRoteiro);

    $qtdDeRegistro= pg_num_rows($rsRoteiro);
    $Contador = $qtdDeRegistro;
    $i =1;
    $Roteiro = "";
    $Meio = "";

    While($linharsRoteiro = pg_fetch_assoc($rsRoteiro))
    {
        $sqlRoteiroOrigem 		= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_origem'];
        $rsRoteiroOrigem 		= pg_query(abreConexao(),$sqlRoteiroOrigem);
        $linharsRoteiroOrigem	= pg_fetch_assoc($rsRoteiroOrigem);

        $sqlRoteiroDestino 		= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_destino'];
        $rsRoteiroDestino 		= pg_query(abreConexao(),$sqlRoteiroDestino);
        $linharsRoteiroDestino	= pg_fetch_assoc($rsRoteiroDestino);

        If ($i == 1)
        {
            $Inicio = $linharsRoteiroOrigem['municipio_ds']." - (".$linharsRoteiroOrigem['estado_uf'].")" . " / ".$linharsRoteiroDestino['municipio_ds']." - (" .$linharsRoteiroDestino['estado_uf'].")";
        }
        Elseif (($i != 1) && ($i < $Contador))
        {  
            $Meio = $Meio." / ".$linharsRoteiroDestino['municipio_ds']. " - (".$linharsRoteiroDestino['estado_uf']. ")";
        }
        Elseif ($i == $Contador)
        {
            $Final = " / ".$linharsRoteiroDestino['municipio_ds']." - (".$linharsRoteiroDestino['estado_uf']. ")";
        }
        $i++;
    }
    $Roteiro = $Inicio.$Meio.$Final;
    /*
    'Roteiro
    '*****************************************************************************************
     */
    $pdf->Rect (10, 95, 190, 19 , "D");
    $pdf->SETXY (10, 95);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (160,5,"Destino",0,1);
    $pdf->SETXY (10, 99);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell(190,4,utf8_decode($Roteiro),0,1);
    
    /*
    '******************************************************************************************
    'Meio de Transporte
    '******************************************************************************************
     */
    $pdf->Rect (10, 115, 190, 14 , "D");
    $pdf->SETXY (10, 115);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (190,5,"Meio de Transporte",0,1);
    $pdf->SETXY (10, 119);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (190,5,utf8_decode($MeioTransporte),0,1);
    /*
    'Detalhe do Motivo
    '******************************************************************************************
     */
    $pdf->Rect (10, 130, 190, 57 , "D");
    $pdf->SETXY (10, 130);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (160,5,"Motivo da Viagem",0,1);
    $pdf->SETXY (10, 135);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (190,3,utf8_decode($Descricao),0,1);
   
    /*
    '******************************************************************************************
    'Partida Prevista
    '******************************************************************************************
     */
    $pdf->Rect (10, 188, 45, 4 , "D");
    $pdf->SETXY (10, 189);
    $pdf->SetFont( "Times", "B",9);
    $pdf->MultiCell (45,3,"Partida Prevista",0,"C",0);
    $pdf->SETXY (10, 193);
    $pdf->Rect (10, 192, 25, 10 , "D");
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (25,5,$DataPartida,0,"C",0);
    $pdf->SETXY (10, 197);
    $pdf->MultiCell (25,5,$DiaSemanaPartida,0,"C",0);
    /*
    '******************************************************************************************
    'Horas
     */
    $pdf->Rect (35, 192, 20, 10 , "D");
    $pdf->SETXY (35, 194);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (20,5,$HoraPartida,0,"C",0);

    /*
    'Partida Prevista
     */
    $pdf->Rect (55, 188, 45, 4 , "C");
    $pdf->SetFont ("Times", "B",9);
    $pdf->SETXY (55, 189);
    $pdf->MultiCell (45,3,"Chegada Prevista",0,"C",0);
    $pdf->SETXY (55, 192);
    $pdf->Rect (55, 192, 25, 10 , "C");
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (40, 193);
    $pdf->MultiCell (55,5,$DataChegada,0,"C",0);
    $pdf->SETXY (55, 197);
    $pdf->MultiCell (25,5,$DiaSemanaChegada,0,"C",0);

    //Horas
    $pdf->Rect(55, 192, 45, 10 , "D");
    $pdf->SETXY (80, 194);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (20,5,$HoraChegada,0,"C",0);

    //Diarias

    $pdf->Rect (100, 188, 20, 4 , "C");
    $pdf->SetFont ("Times", "B",9);
    $pdf->SETXY (87, 189);
    $pdf->MultiCell (45,3,utf8_decode("Diárias"),0,"C",0);
    $pdf->SETXY (55, 194);
    $pdf->Rect (100, 192, 20, 10 , "C");
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (100, 194);
    $pdf->MultiCell (20,5,$Qtde,0,"C",0);

    /*Redu��o 50%
    '******************************************************************************************
     */
    $pdf->Rect (120, 188, 15, 4 , "C");
    $pdf->SetFont ("Times", "B",9);
    $pdf->SETXY (105, 189);
    $pdf->MultiCell (45,3,"Red.50%",0,"C",0);
    $pdf->SETXY (55, 194);
    $pdf->Rect (120, 192, 15, 10 , "C");
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (120, 194);
    $pdf->MultiCell (15,5,utf8_decode($Desconto),0,"C",0);
    /*
    '******************************************************************************************
    'Valor Ref.
     */
    $pdf->Rect (135, 188, 20, 4 , "C");
    $pdf->SetFont ("Times", "B",9);
    $pdf->SETXY (135, 189);
    $pdf->MultiCell (20,3,"Valor Ref.",0,"C",0);
    $pdf->SETXY (55, 193);
    $pdf->Rect (135, 192, 20, 10 , "C");
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (135, 194);
    $pdf->MultiCell( 20,5,$ValorRef,0,"C",0);

    //Total.

    $pdf->Rect (155, 188, 25, 4 , "C");
    $pdf->SetFont ("Times", "B",9);
    $pdf->SETXY (155, 189);
    $pdf->MultiCell (25,3,"Total",0,"C",0);
    $pdf->SETXY (55, 193);
    $pdf->Rect (155, 192, 25, 10 , "C");
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (155, 194);
    $pdf->MultiCell (25,5,$Valor,0,"C",0);

    //Empenho.

    $pdf->Rect (180, 188, 20, 4 , "C");
    $pdf->SetFont ("Times", "B",9);
    $pdf->SETXY (180, 189);
    $pdf->MultiCell (20,3,utf8_decode("N° Empenho"),0,"C",0);
    $pdf->SETXY (55, 193);
    $pdf->Rect (180, 192, 20, 10 , "C");
    $pdf->SetFont ("Times", "",8);
    $pdf->SETXY (180, 194);
    $pdf->MultiCell (20,5,$Empenho,0,"C",0);
    
    /*
    'justificativa do Final de Semana e Feriado
    '******************************************************************************************
     */
    $pdf->Rect (10, 203, 190, 23 , "D");
    $pdf->SETXY (10, 203);
    $pdf->SetFont ("Times", "B",9);
    $pdf->MultiCell (160,5,"Justificativa do Fim de Semana e Feriado",0,1);
    $pdf->SETXY (10, 208);
    $pdf->SetFont ("Times", "",8);
    $pdf->MultiCell (190,3,utf8_decode($JustificativaFimSemana.$JustificativaFeriado),0,1);
    /*
    ******************************************************************************************
    'DIRIGENTE DA UNIDADE
     *
     */
    /*$pdf->Rect (10, 227, 63, 60 , "D");
    $pdf->SetFont ("Times", "B",9);
    $pdf->SETXY (10, 227);
    $pdf->MultiCell (60,5,"DIRIGENTE DA UNIDADE",0,"C",0);*/

    /*
     *
    'DIRETOR
    '******************************************************************************************
     *
     */
    /*$pdf->Rect (73, 227, 64, 60 , "D");
    $pdf->SetFont ("Times", "B",9);
    $pdf->SETXY (75, 227);
    $pdf->MultiCell (60,5,"DIRETOR",0,"C",0);*/

    /*
    '******************************************************************************************
    'UTORIZA��O DO SECRET�RIO
    '******************************************************************************************
    */
    /*$pdf->Rect (137, 227, 63, 60 , "");
    $pdf->SetFont ("Times", "B",9);
    $pdf->SETXY (140, 227);
    $pdf->MultiCell (60,5,"AUTORIZA��O DO SECRET�RIO",0,"C",0);*/

    /*
    '******************************************************************************************
     *
     */
     // Nome do Autorizador 
    $pdf->Rect (10, 227, 95, 5 , "D");
    $pdf->SETXY (41, 227);
    $pdf->SetFont( "Times", "B",9);
    $pdf->Cell (60,5, utf8_decode("Coordenador da Unidade"),0,0);
    $pdf->SETXY (10, 233);
    $pdf->Cell (95,33,"",1,0);

    //$Diaria_Matricula_Autorizacao	= "Matr�cula: " .$matricula_autorizador;
    $Diaria_DT_Autorizacao			= "Data da Autorização: " .$diaria_autorizacao_dt.' '.$diaria_autorizacao_hr;

    $pdf->SetFont ("Times", "",9);
    $pdf->SETXY (10, 256);
    //$pdf->MultiCell (93,5,$pessoa_nm_autorizador,0,"C",0);

    $pdf->SetFont ("Times", "",7);
    $pdf->SETXY (10, 259);
    $pdf->MultiCell (93,5,utf8_decode($Diaria_Matricula_Autorizacao),0,"C",0);
    $pdf->SETXY (10, 263);
    $pdf->MultiCell (93,2,utf8_decode($Diaria_DT_Autorizacao),0,"C",0);

    $pdf->Rect (105, 227, 95, 5 , "D");
    $pdf->SETXY (143, 227);
    $pdf->SetFont ("Times", "B",9);
    $pdf->Cell (60,5,"Diretor",0,0);

    $matricula_aprovador = ""; // Altera��o Para Dr. Adolfo poder Assinar as Di�rias

    $Diaria_Matricula_Aprovacao	= utf8_decode("Matrícula: " .$matricula_aprovador);
    $Diaria_DT_Aprovacao		= utf8_decode("Data da Aprovação: " .$diaria_aprovacao_dt.' '.$diaria_aprovacao_hr);

    $pdf->SetFont ("Times", "",9);
    $pdf->SETXY (105, 256);

    $pessoa_nm_aprovador = ""; // Altera��o Para Dr. Adolfo poder Assinar as Di�rias
    $pdf->MultiCell (93,5,$pessoa_nm_aprovador,0,"C",0);

    $pdf->SetFont ("Times", "",7);
    $pdf->SETXY (105, 259);

    $Diaria_Matricula_Aprovacao = "";// Altera��o Para Dr. Adolfo poder Assinar as Di�rias
    $pdf->MultiCell (93,5,$Diaria_Matricula_Aprovacao,0,"C",0);

    $pdf->SETXY (105, 263);
    $pdf->MultiCell (93,2,$Diaria_DT_Aprovacao,0,"C",0);

    $pdf->SETXY (105, 233);
    $pdf->Cell (95,33,"",1,1);

    // Datas
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (28,4,utf8_decode("Data da Solicitação:"),0,0);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (28,4,$DataDaSolicitacao . " - " . $HoraDaSolicitacao,0,1);
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (28,4,utf8_decode("Data da Impressão:"),0,0);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (28,4,date("d/m/Y - H:i:s"),0,1);
}


$sqlAltera = "UPDATE diaria.diaria_aprovacao SET imp_processo_st = 1  WHERE diaria_id = $Codigo";
pg_query(abreConexao(),$sqlAltera);

$sqlAltera2 = "UPDATE diaria.diaria SET diaria_indvidual = 1  WHERE diaria_id = $Codigo";
pg_query(abreConexao(),$sqlAltera2);

$pdf->Close();

$pdf->Output();
?>
