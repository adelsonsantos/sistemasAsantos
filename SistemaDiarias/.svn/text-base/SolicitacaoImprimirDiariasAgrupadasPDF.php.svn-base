<?php
include "../Include/Inc_Configuracao.php";
include "../Include/Inc_DadosBancariosGER.PHP";
include "../Include/conecta.php";
include "fpdf.php";

$UsuarioCod  = $_SESSION['UsuarioCodigo'];
$UsuarioNome = $_SESSION["UsuarioNome"];

$ImpressaoMultipla = $_GET["Multiplos"];

$pdf= new FPDF();
$pdf->AliasNbPages();
$pdf->Open();
$pdf->AddPage();
				
$sqlConsulta = "SELECT Distinct d.diaria_id, d.diaria_numero, d.projeto_cd, d.acao_cd, d.territorio_cd,
		d.fonte_cd,d.diaria_valor, d.diaria_processo, d.diaria_qtde, d.diaria_valor_ref,
		d.diaria_unidade_custo, d.diaria_st, d.diaria_dt_saida, d.diaria_empenho, d.diaria_descricao,
		d.convenio_id, d.indenizacao, d.ger_id, pf.pessoa_fisica_cpf,
		p.pessoa_nm, f.funcionario_matricula, f.pessoa_id,diaria_hr_saida, diaria_dt_chegada, diaria_hr_chegada,funcionario_tipo_ds
		FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.funcionario_tipo ft, dados_unico.pessoa p,dados_unico.pessoa_fisica pf
		WHERE (d.diaria_beneficiario = f.pessoa_id) AND
		(d.diaria_beneficiario = pf.pessoa_id) AND
		(d.diaria_beneficiario = p.pessoa_id) AND
		(f.funcionario_tipo_id = ft.funcionario_tipo_id) AND
		(d.diaria_st = 2)
		AND d.diaria_id in (".$ImpressaoMultipla.")";
$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

/*  Gerando o Número de SD e Processo do Agrupamento e o valor total e o nome do setor */		
$sql = "SELECT max(diaria_id) as maior From diaria.diaria";
$consulta = pg_query(abreConexao(),$sql);
$tupla = pg_fetch_assoc($consulta);
$Numero = $tupla["maior"];
$Numero =  substr($Numero, 0, 2);
$Numero = $Numero.substr($ImpressaoMultipla, 0, 4);

$Super_SD = date("Y"). $Numero.date("d");
$Numero_processo = f_NumeroProcesso($Numero);
	
$Total_Diarias = 0.0;
$UnidadeCusto = "";	
$sql = "SELECT diaria_valor,diaria_unidade_custo  From diaria.diaria WHERE (diaria_st = 2) AND diaria_id in (".$ImpressaoMultipla.")";
$consulta = pg_query(abreConexao(),$sql);
  While($tupla = pg_fetch_assoc($consulta)){
		$dinheiro = $tupla["diaria_valor"];				
		$dinheiro = str_replace('R$', "",$dinheiro);
		$dinheiro = moedaBanco($dinheiro);		
		$Total_Diarias += $dinheiro;
		$UnidadeCusto = $tupla["diaria_unidade_custo"];	
	}

		$sql = "SELECT est_organizacional_sigla, est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = " .$UnidadeCusto;
        $Consulta = pg_query(abreConexao(),$sql);
        $linhaConsulta=pg_fetch_assoc($Consulta);

        If($linhaConsulta)
        {
            $UnidadeCustoNome = $linhaConsulta['est_organizacional_ds'];
        }

/* Fim ************************************************/	

function Roteiro ($Diaria_id)
{
    $sqlRoteiro     = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$Diaria_id;
    $rsRoteiro      = pg_query(abreConexao(),$sqlRoteiro);
    $qtdDeRegistro  = pg_num_rows($rsRoteiro);

    $Contador = $qtdDeRegistro;
    $i =1;
    $Roteiro = "";
    $Meio = "";

    While($linharsRoteiro = pg_fetch_assoc($rsRoteiro))
    {
        $sqlRoteiroOrigem 	= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_origem'];
        $rsRoteiroOrigem 	= pg_query(abreConexao(),$sqlRoteiroOrigem);
        $linharsRoteiroOrigem	= pg_fetch_assoc($rsRoteiroOrigem);

        $sqlRoteiroDestino 	= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_destino'];
        $rsRoteiroDestino 	= pg_query(abreConexao(),$sqlRoteiroDestino);
        $linharsRoteiroDestino	= pg_fetch_assoc($rsRoteiroDestino);

        If ($i == 1)
        {
            $Inicio = $linharsRoteiroOrigem['municipio_ds']." - (".$linharsRoteiroOrigem['estado_uf'].")" . " / ".$linharsRoteiroDestino['municipio_ds']." - (" .$linharsRoteiroDestino['estado_uf'].")";
        }
        Elseif ($i != 1)
        {  $Meio = $Meio." / ".$linharsRoteiroDestino['municipio_ds']. " - (".$linharsRoteiroDestino['estado_uf']. ")";

        }
        Elseif ($i == $Contador)
        {
            $Final = " / ".$linharsRoteiroDestino['municipio_ds']." - (".$linharsRoteiroDestino['estado_uf']. ")";
        }
        $i++;
}
$Roteiro = $Inicio.$Meio.$Final;
return $Roteiro;
}

// *************************** Fim das funções ***************************
	$pdf->Cell (55,15,"",1,0,"C");
    $pdf->image ("../Imagens/logo.jpg",14,13,40);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (135,7,"Solicitação de Diárias Administrativas",0,0,"C");
    $pdf->SetXY(65,10);
    $pdf->Cell (135,15,"",1,1,"C");
    $pdf->SetFont ("Times", "",7);
    $pdf->Text (112, 19 ,"EMITIDO: " .date("d/m/Y")." às ".date("H:i:s"),1,1,"C");
    $pdf->Text (103,22 ,"Matr.: " .f_MatriculaPessoa($UsuarioCod),0,0);
    $pdf->Text (121, 22 ,"  - ".$UsuarioNome,1,1,"C");
	$pdf->SetFont ("Times", "B",10);
	$pdf->Cell (130,25,"Número da Solicitação:",0,1); //Espaçamento entre uma tabela e a outra
	$pdf->Text (53,38.4,$Super_SD,0,1);
	$pdf->Text (11,43 ,"Número do Processo: " .$Numero_processo,0,0);		
	$pdf->Text (11,47 ,"Valor Total(R$): " .formatoMoeda($Total_Diarias),0,0);	
	$pdf->Text (11,51 ,"Área Beneficiária: " .$UnidadeCustoNome,0,0);		

//$num_servidor = 0;
$num_servidor = 1;
$numImpressao = 1;	
$num_servidor_temp = $a;
while ($linhars = pg_fetch_assoc($rsConsulta))
    {
        $VarEmpenho  = $linhars['diaria_st'];
        $Convenio    = $linhars['convenio_id'];
        $Indenizacao = $linhars['indenizacao'];
		//$num_servidor +=1;
		
        $CPF                = $linhars['pessoa_fisica_cpf'];
        $ProjetoCOD         = $linhars['projeto_cd'];
        $Diaria_id          = $linhars['diaria_id'];
        $DiariaValor        = $linhars['diaria_valor'];
        $DiariaProcessoNum  = $linhars['diaria_processo'];
        $DiariaDS           = $linhars['diaria_descricao'];
        $DiariaSD           = $linhars['diaria_numero'];
        $DiariaValorTotal   = $linhars['diaria_valor'];
        $DiariaQTDE         = $linhars['diaria_qtde'];
        $DiariaValorRef     = $linhars['diaria_valor_ref'];
        $DiariaDT_Saida     = $linhars['diaria_dt_saida'];
        $DiariaHR_Saida     = $linhars['diaria_hr_saida'];
        $DiariaDT_Retorno     = $linhars['diaria_dt_chegada'];
        $DiariaHR_Retorno     = $linhars['diaria_hr_chegada'];
        $DiariaNumEmpenho   = $linhars['diaria_empenho'];
        $Acao               = $linhars['acao_cd'];
        $Territorio         = $linhars['territorio_cd'];
        $Fonte              = $linhars['fonte_cd'];        
        $FuncionarioMat     = $linhars['funcionario_matricula'];
        $FuncionarioNM      = $linhars['pessoa_nm'];
        $PessoaID           = $linhars['pessoa_id'];
        $GerID              = $linhars['ger_id'];
        $DadosBancarios     = buscarDadosBancarios($PessoaID);
        $GERContaContabil   = buscarDadosGer($GerID, 1);
        $DadosGER           = buscarDadosGer($GerID, 0);
        $UnidadeExecutora   = $linhars['est_organizacional_unidade_executora'];
        $CentroCusto        = $linhars['est_organizacional_centro_custo_num'];
        $UnidadeCusto       = $linhars['diaria_unidade_custo'];
		$tipo_servidor        = $linhars['funcionario_tipo_ds'];		
		
		$sql_cargo = "SELECT cargo_temporario, cargo_permanente FROM dados_unico.funcionario WHERE pessoa_id = $PessoaID";
		$rs_cargo = pg_query(abreConexao(),$sql_cargo);
		$linha_cargo =pg_fetch_assoc($rs_cargo);
		
		if (($linha_cargo['cargo_temporario']!= 0) && ($linha_cargo['cargo_temporario']!= "")){
				$Cargo = $linha_cargo['cargo_temporario'];
		}else{
			   $Cargo = $linha_cargo['cargo_permanente'];
		}
		
		 $sql3 = "SELECT cargo_ds FROM dados_unico.cargo WHERE cargo_id = " .$Cargo;
		 $rs_Sql3 = pg_query(abreConexao(),$sql3);
         $linhaConsulta=pg_fetch_assoc($rs_Sql3);
		 $CargoNome = $linhaConsulta['cargo_ds'];	        

		$pdf->SetFont ("Times", "B",9);
		$pdf->Cell (190,1,"",0,1); //Espaçamento entre uma tabela e a outra
		$pdf->Cell (190,1,"",0,1); //Espaçamento entre uma tabela e a outra
		$pdf->Cell (190,10,"SERVIDOR: ".$num_servidor,0,1,"C"); //Espaçamento entre uma tabela e a outra
		$pdf->Cell (190,1,"-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------",0,1); //Espaçamento entre uma tabela e a outra		
		$pdf->Cell (190,1,"",0,1); //Espaçamento entre uma tabela e a outra
		$pdf->Cell (190,1,"",0,1); //Espaçamento entre uma tabela e a outra
		
        //$pdf->Cell (190,5,"DADOS ADICIONAIS, INFORMAÇÕES PARA OS SETORES: FINANCEIRO E ORÇAMENTARIO",1,1,"C");

        $pdf->Cell (35,5,"CPF/Matricula",1,0);       
        $pdf->Cell (50,5,"Nome",1,0,"C");
        $pdf->Cell (30,5,"Tipo Servidor",1,0,"C");
        //$pdf->Cell (30,5,"Cargo/Função",1,0);       
        $pdf->Cell (45,5,"Dados Bancários",1,1,"C");       
        
        $pdf->SetFont ("Times", "",8);        
        $pdf->Cell (35,5,$CPF."/".$FuncionarioMat,1,0);       
        $pdf->Cell (50,5,$FuncionarioNM,1,0);        
        $pdf->Cell (30,5,$tipo_servidor,1,0,"C");
       // $pdf->Cell (30,5,utf8_decode($CargoNome),1,0);
        $pdf->Cell (45,5,$DadosBancarios,1,1,"C");
		
		$pdf->SetFont ("Times", "B",9);
		$pdf->Cell (30,5,"Cargo/Função",1,0); 
		$pdf->SetFont ("Times", "",8);		
		$pdf->Cell (130,5,utf8_decode($CargoNome),1,0);		
		
		$pdf->SetFont ("Times", "B",9);        
		$pdf->SetX(9);
		$pdf->Cell(190,13,"MOTIVO DA VIAGEM : ",0,1);        
		$pdf->SetFont ("Times", "",8);        
        $pdf->MultiCell (190,6,utf8_decode($DiariaDS),0,1);
		
		$pdf->SetFont ("Times", "B",9);
        $pdf->Cell(190,5,"ROTEIRO : ",0,1);
        $pdf->SetFont ("Times", "",8);        
        $pdf->MultiCell (190,5,Roteiro ($Diaria_id),0,1);		
		
        $pdf->SetFont ("Times", "B",9);        
        $pdf->Cell (33,5,"Saída",1,0,"C");
        $pdf->Cell (33,5,"Retorno",1,0,"C");        
		$pdf->Cell (25,5,"Valor Unitário",1,0); 
		$pdf->Cell (15,5,"Qtde",1,0,"C");
		$pdf->Cell (20,5,"Valor Trecho",1,0);
		$pdf->Cell (65,5,"Projeto",1,1,"C");

        $pdf->SetFont ("Times", "",8);       
        $pdf->Cell (33,5,$DiariaDT_Saida."  ".$DiariaHR_Saida,1,0,"C");
        $pdf->Cell (33,5,$DiariaDT_Retorno."  ".$DiariaHR_Retorno,1,0,"C");
		$pdf->Cell (25,5,$DiariaValorRef,1,0,"C");
		$pdf->Cell (15,5,$DiariaQTDE,1,0,"C");
        $pdf->Cell (20,5,$DiariaValorTotal,1,0,"C");
        $Projeto = "Projeto: ".$ProjetoCOD .", Produto: ".$Acao.", Território: ".$Territorio.", Fonte: ".$Fonte;
		$pdf->Cell (65,5,$Projeto,1,1);

      //  $pdf->Cell (190,1,"",0,1); //Espaçamento entre uma tabela e a outra
	  if($numImpressao == 3 && $num_servidor == 3)
		{
			$pdf->Cell(5,20,"Página ".$pdf->PageNo()."/{nb}",0,0,"C"); // Número da página	
			$pdf->Cell (190,28.5,"Número da SD: ".$Super_SD,0,1,"C");	
			//$pdf->Cell (190,28.5,"",0,1,"C"); //Espaçamento entre uma tabela e a outra
			$numImpressao = 0;			
		}
		if(($num_servidor == $num_servidor_temp) && $numImpressao <= 4 && ($num_servidor_temp != 2))
		{ 			
			$pdf->Cell(5,6.9,"Página ".$pdf->PageNo()."/{nb}",0,0,"C"); // Número da página	
			$pdf->Cell (190,6.9,"Número da SD: ".$Super_SD,0,1,"C");				
			$numImpressao = 0;		
		}
		if($numImpressao == 4 && ($num_servidor != $num_servidor_temp))		
		{ 			
			$pdf->Cell(5,9.5,"Página ".$pdf->PageNo()."/{nb}",0,0,"C"); // Número da página	
			$pdf->Cell (190,9,"Número da SD: ".$Super_SD,0,1,"C");	
			//$pdf->Cell (190,9,"",0,1,"C"); //Espaçamento entre uma tabela e a outra
			$numImpressao = 0;		
		}	
		
		$num_servidor++;
		$numImpressao++;
		$a--;	
    }
	$numero_pagina = $pdf->PageNo();
/***********************************************************************************************************************/
/** Consulta do Autorizador ***/
        $sql3 ="SELECT diaria_autorizacao_dt,diaria_autorizacao_hr,pessoa_nm, funcionario_matricula FROM diaria.diaria_autorizacao A	JOIN diaria.diaria D ON A.diaria_id = D.diaria_id	JOIN dados_unico.funcionario F ON diaria_autorizacao_func = F.funcionario_id JOIN dados_unico.pessoa P ON F.pessoa_id = P.pessoa_id WHERE A.diaria_id in (".$ImpressaoMultipla.") order by diaria_autorizacao_dt, diaria_autorizacao_hr desc limit 1 ";		
        $Consulta = pg_query(abreConexao(),$sql3);
        $linhaConsulta=pg_fetch_assoc($Consulta);
        If($linhaConsulta)
        {
			$pessoa_nm_autorizador	= $linhaConsulta['pessoa_nm'];
			$matricula_autorizador	= $linhaConsulta['funcionario_matricula'];
            $diaria_autorizacao_dt 	= f_formatadata($linhaConsulta['diaria_autorizacao_dt']);
			$diaria_autorizacao_hr 	= $linhaConsulta['diaria_autorizacao_hr'];

        }
		/**  Fim da Consulta do Autorizador ***/
		
		/** Consulta do Aprovador ***/
		$sql3 ="SELECT diaria_aprovacao_dt, diaria_aprovacao_hr, pessoa_nm, funcionario_matricula, diaria_dt_criacao,diaria_hr_criacao FROM diaria.diaria_aprovacao A JOIN diaria.diaria D ON A.diaria_id = D.diaria_id JOIN dados_unico.funcionario F ON diaria_aprovacao_func = F.funcionario_id JOIN dados_unico.pessoa P ON F.pessoa_id = P.pessoa_id WHERE A.diaria_id in (".$ImpressaoMultipla.") order by diaria_aprovacao_dt, diaria_aprovacao_hr desc limit 1 ";
        $rsConsulta = pg_query(abreConexao(),$sql3);
        $linhaConsulta=pg_fetch_assoc($rsConsulta);
        If($linhaConsulta)
        {
			$pessoa_nm_aprovador	= $linhaConsulta['pessoa_nm'];
			$matricula_aprovador	= $linhaConsulta['funcionario_matricula'];
            $diaria_aprovacao_dt 	= f_formatadata($linhaConsulta['diaria_aprovacao_dt']);
			$diaria_aprovacao_hr 	= $linhaConsulta['diaria_aprovacao_hr'];
			$DataDaSolicitacao      = $linhaConsulta['diaria_dt_criacao'];
			$HoraDaSolicitacao      = $linhaConsulta['diaria_hr_criacao'];

        }
		/**  Fim da Consulta do Aprovador ***/ 		 
/****************************************************************************************************************************/	
if($num_servidor_temp <= 4 ){
		
		$pdf->Rect (10, 300, 95, 5 , "D");
		$pdf->SETXY (41, 210);
		$pdf->SetFont( "Times", "B",9);
		$pdf->Cell (60,5, utf8_decode("Coordenador da Unidade"),0,0);
		$pdf->SETXY (10, 195);
		$pdf->Cell (95,33,"",1,0);

		$Diaria_Matricula_Autorizacao	= "Matrícula: " .$matricula_autorizador;
		$Diaria_DT_Autorizacao			= "Data da Autorização: " .$diaria_autorizacao_dt.' '.$diaria_autorizacao_hr;

		$pessoa_nm_autorizador = "";
		$pdf->SetFont ("Times", "",9);
		$pdf->SETXY (10, 195);
		$pdf->MultiCell (93,33,$pessoa_nm_autorizador,0,"C",0);

		$Diaria_Matricula_Autorizacao = "";
		$pdf->SetFont ("Times", "",7);
		$pdf->SETXY (10, 259);
		$pdf->MultiCell (93,5,$Diaria_Matricula_Autorizacao,0,"C",0);
		$pdf->SETXY (10, 263);
		$pdf->MultiCell (93,-75,$Diaria_DT_Autorizacao,0,"C",0);

		//$pdf->Rect (105, 150, 95, 5 , "D");
		$pdf->SETXY (143, 210);
		$pdf->SetFont ("Times", "B",9);
		$pdf->Cell (10,5,"Diretor",0,0);

		/** Dados do Aprovador ***/ 
		$matricula_aprovador = ""; // Alteração Para Dr. Adolfo poder Assinar as Diárias
		$Diaria_Matricula_Aprovacao	= "Matrícula: " .$matricula_aprovador;
		$Diaria_DT_Aprovacao		= "Data da Aprovação: " .$diaria_aprovacao_dt.' '.$diaria_aprovacao_hr; // Data e Hora da Aprovação

		$pdf->SetFont ("Times", "",9);
		$pdf->SETXY (10, 15);
		$pessoa_nm_aprovador = ""; // Alteração Para Dr. Adolfo poder Assinar as Diárias
		//$pdf->MultiCell (93,5,$pessoa_nm_aprovador,0,"C",0);
		$pdf->SetFont ("Times", "",7);
		$pdf->SETXY (105, 195);
		$Diaria_Matricula_Aprovacao = "";// Alteração Para Dr. Adolfo poder Assinar as Diárias
		//$pdf->MultiCell (93,5,$Diaria_Matricula_Aprovacao,0,"C",0);
		$pdf->SETXY (105, 263);
		$pdf->MultiCell (93,-75,$Diaria_DT_Aprovacao,0,"C",0);
		/** Fim dos dados do Aprovador **/
		$pdf->SETXY (105, 195);
		$pdf->Cell (95,33,"",1,1);

		// Datas
		$pdf->SetFont ("Times", "B",8);
		$pdf->Cell (28,10,"Data da Solicitação:",0,0);
		$pdf->SetFont ("Times", "",8);
		$pdf->Cell (28,10,converte_data($DataDaSolicitacao) . " - " . $HoraDaSolicitacao,0,1);
		$pdf->SetFont ("Times", "B",8);
		$pdf->Cell (28,4,"Data da Impressão:",0,0);
		$pdf->SetFont ("Times", "",8);
		$pdf->Cell (28,4,date("d/m/Y - H:i:s"),0,1);	

		$pdf->Cell (28,6,"Número da SD: ".$Super_SD,0,1);	

		$pdf->Cell(5,15,"Página ".$pdf->PageNo()."/{nb}",0,0,"C"); // Número da página		
		
	}else{
  
		$pdf->AddPage();

		$pdf->Rect (10, 190, 95, 5 , "D");
		$pdf->SETXY (41, 190);
		$pdf->SetFont( "Times", "B",9);
		$pdf->Cell (60,5, utf8_decode("Coordenador da Unidade"),0,0);
		$pdf->SETXY (10, 195);
		$pdf->Cell (95,33,"",1,0);

		$Diaria_Matricula_Autorizacao	= "Matrícula: " .$matricula_autorizador;
		$Diaria_DT_Autorizacao			= "Data da Autorização: " .$diaria_autorizacao_dt.' '.$diaria_autorizacao_hr;

		$pessoa_nm_autorizador = "";
		$pdf->SetFont ("Times", "",9);
		$pdf->SETXY (10, 195);
		$pdf->MultiCell (93,33,$pessoa_nm_autorizador,0,"C",0);

		$Diaria_Matricula_Autorizacao = "";
		$pdf->SetFont ("Times", "",7);
		$pdf->SETXY (10, 259);
		$pdf->MultiCell (93,5,$Diaria_Matricula_Autorizacao,0,"C",0);
		$pdf->SETXY (10, 263);
		$pdf->MultiCell (93,-75,$Diaria_DT_Autorizacao,0,"C",0);

		$pdf->Rect (105, 190, 95, 5 , "D");
		$pdf->SETXY (143, 190);
		$pdf->SetFont ("Times", "B",9);
		$pdf->Cell (60,5,"Diretor",0,0);

		/** Dados do Aprovador ***/ 
		$matricula_aprovador = ""; // Alteração Para Dr. Adolfo poder Assinar as Diárias
		$Diaria_Matricula_Aprovacao	= "Matrícula: " .$matricula_aprovador;
		$Diaria_DT_Aprovacao		= "Data da Aprovação: " .$diaria_aprovacao_dt.' '.$diaria_aprovacao_hr; // Data e Hora da Aprovação

		$pdf->SetFont ("Times", "",9);
		$pdf->SETXY (10, 15);
		$pessoa_nm_aprovador = ""; // Alteração Para Dr. Adolfo poder Assinar as Diárias
		//$pdf->MultiCell (93,5,$pessoa_nm_aprovador,0,"C",0);
		$pdf->SetFont ("Times", "",7);
		$pdf->SETXY (105, 195);
		$Diaria_Matricula_Aprovacao = "";// Alteração Para Dr. Adolfo poder Assinar as Diárias
		//$pdf->MultiCell (93,5,$Diaria_Matricula_Aprovacao,0,"C",0);
		$pdf->SETXY (105, 263);
		$pdf->MultiCell (93,-75,$Diaria_DT_Aprovacao,0,"C",0);
		/** Fim dos dados do Aprovador **/
		$pdf->SETXY (105, 195);
		$pdf->Cell (95,33,"",1,1);

		// Datas
		$pdf->SetFont ("Times", "B",8);
		$pdf->Cell (28,10,"Data da Solicitação:",0,0);
		$pdf->SetFont ("Times", "",8);
		$pdf->Cell (28,10,converte_data($DataDaSolicitacao) . " - " . $HoraDaSolicitacao,0,1);
		$pdf->SetFont ("Times", "B",8);
		$pdf->Cell (28,4,"Data da Impressão:",0,0);
		$pdf->SetFont ("Times", "",8);
		$pdf->Cell (28,4,date("d/m/Y - H:i:s"),0,1);	

		$pdf->Cell (28,6,"Número da SD: ".$Super_SD,0,1);	

		$pdf->Cell(5,15,"Página ".($numero_pagina+1)."/{nb}",0,0,"C"); // Número da página			
	}
	
// Diaria Impressa 
$sqlAltera = "UPDATE diaria.diaria_aprovacao SET imp_processo_st = 1 WHERE diaria_id in (".$ImpressaoMultipla.")";
pg_query(abreConexao(),$sqlAltera);


/* Diária Agrupada */
$sql_altera = " UPDATE diaria.diaria
				SET super_sd = '$Super_SD', diaria_agrupada = 1, diaria_processo = '$Numero_processo'
				WHERE diaria_id in (".$ImpressaoMultipla.")";
$rsConsulta = pg_query(abreConexao(),$sql_altera);

$pdf->Close();
$pdf->Output();
?>
