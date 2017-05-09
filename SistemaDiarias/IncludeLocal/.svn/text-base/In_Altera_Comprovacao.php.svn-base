<?php
/***************************** Botão Alterar Comprovação ******************************************/		
	elseIf ($AcaoSistema == "alterarComprovacao"){
		$Codigo= $linha['txtCodigo'];
		$Date=date("Y-m-d");
		$Valor = 0;

		$Comprovada                 = $_POST['txtComprovada'];
		$Codigo                     = $_POST['txtCodigo'];
		$DataPartida                = $_POST['txtDataPartida'];
		$HoraPartida                = $_POST['txtHoraPartida'];
		$DataChegada                = $_POST['txtDataChegada'];
		$HoraChegada                = $_POST['txtHoraChegada'];
		$ValorRef                   = $_POST['txtNovoValorRef'];
		$Qtde                       = $_POST['txtQtde'];
		$Valor                      = $_POST['txtValorTotal'];
		$JustificativaFeriado       = strtoupper(trim($_POST['txtJustificativaFeriado']));
		$JustificativaFimSemana 	  = strtoupper(trim($_POST['txtJustificativaFimSemana']));
		$NovoCalculo                =  $_POST['txtNovoCalculo'];
		$Resumo                     = strtoupper(trim($_POST['txtResumo']));

		if ($_POST['chkComplemento']== "on"){
			$Complemento = 1;
		}else{ 
			$Complemento = 0;
		}
		
		$ComplementoJustificativa = strtoupper(trim($_POST['txtComplemento']));
		
		if ($ValorRef == ""){
			$ValorRef = $_POST['txtValorRef'];
		}

		if ($Qtde == ""){
			$Qtde = $_POST['txtQtdeRef'];
		}

		if ($Valor == ""){
			$Valor = $_POST['txtTotalRef'];
		}
				
		$DiariaValor = str_replace("R$","",($_SESSION['DiariaValor'])); 
				
		if (($Valor != 0)||($Valor == 0 )){
					
			$Valor 			= str_replace(".","",$Valor);  
			$Valor 			= str_replace(",",".",$Valor);  
			$DiariaValor 	= str_replace(".","",$DiariaValor);
			$DiariaValor 	= str_replace(",",".",$DiariaValor);  	// Valor da solicitação  
			$Saldo 		= ($DiariaValor) -  ($Valor);  
			if ($Saldo == 0){
				$SaldoTipo = "";
			}elseif (substr($Saldo,0,1) == "-"){
				$Saldo = (-1)*$Saldo;
				$SaldoTipo = "C";
			}else{
				$Saldo = (-1)*$Saldo;
				$SaldoTipo = "D";
			}					
		}else{
			$Saldo = 0;
			$SaldoTipo = "";
		}

		if ($linha['chkDesconto']== "on"){
			$Desconto = "S";
		}else{
			$Desconto = "N";
		}
				
		if ($Comprovada == 1){
			$sqlInsert = "insert into diaria.diaria_comprovacao_historico(select * from diaria.diaria_comprovacao where diaria_id =  ".$Codigo.")";
			pg_query(abreConexao(),$sqlInsert);

			//delete comprovacao anterior
			$sqlDelete = "DELETE FROM diaria.diaria_comprovacao WHERE diaria_id = " .$Codigo;
			pg_query(abreConexao(),$sqlDelete);
			$sqlDelete = "DELETE FROM diaria.roteiro_comprovacao WHERE diaria_id = " .$Codigo;
			pg_query(abreConexao(),$sqlDelete);
		}
				
		$Time=date("H:i:s");
		// Para manter a compatibilidade com a aplicação em ASP. 
		$ValorRef	=str_replace("R$","",$ValorRef); 
		$ValorRef	="R$ ".$ValorRef;
		$Valor		=str_replace(".",",",$Valor); 
		$Valor		="R$ ".$Valor;				
			 
		$sqlInsere = "INSERT INTO diaria.diaria_comprovacao (diaria_id, diaria_comprovacao_comprovador, diaria_comprovacao_dt_saida, diaria_comprovacao_hr_saida, diaria_comprovacao_dt_chegada, diaria_comprovacao_hr_chegada, diaria_comprovacao_valor_ref, diaria_comprovacao_desconto, diaria_comprovacao_qtde, diaria_comprovacao_valor,diaria_comprovacao_justificativa_feriado, diaria_comprovacao_justificativa_fds, diaria_comprovacao_saldo, diaria_comprovacao_saldo_tipo,diaria_comprovacao_dt, diaria_comprovacao_hr, diaria_comprovacao_resumo, diaria_comprovacao_complemento, diaria_comprovacao_complemento_justificativa) VALUES (" .$Codigo.",".$_SESSION['UsuarioCodigo']. ",'" .$DataPartida. "','" .$HoraPartida. "','" .$DataChegada. "','" .$HoraChegada. "', '" .$ValorRef. "', '" .$Desconto. "', '" .$Qtde. "', '" .$Valor. "','" .$JustificativaFeriado. "', '" .$JustificativaFimSemana. "','" .$Saldo. "','" .$SaldoTipo. "','" .$Date. "', '" .$Time. "','" .$Resumo. "', " .$Complemento. ", '" .$ComplementoJustificativa. "')";
		pg_query(abreConexao(),$sqlInsere);
				
		$sql = "select diaria_st,diaria_comprovada from diaria.diaria  WHERE diaria_id = ".$Codigo;			
		$rs = pg_query(abreConexao(),$sql);
		$linhars = pg_fetch_assoc($rs);
				
		$StatusDiaria = $linhars['diaria_st'];
		$DiariaComprovada = $linhars['diaria_comprovada'];
								
		if($StatusDiaria == 3){
			$sqlAltera = "UPDATE diaria.diaria SET  diaria_comprovada = 1, diaria_devolvida = 0 WHERE diaria_id = " .$Codigo;
			pg_query(abreConexao(),$sqlAltera);
		}

		if($StatusDiaria == 4){
			$sqlAltera = "UPDATE diaria.diaria SET diaria_st = 5, diaria_comprovada = 1, diaria_devolvida = 0 WHERE diaria_id = " .$Codigo;
			pg_query(abreConexao(),$sqlAltera);
		}

		//'*****************************************************************************
		if($_SESSION['ContadorDestino']!= ""){
			for ($i = 1; $i<$_SESSION['ContadorDestino'];$i++){
				$sqlInsere = "INSERT INTO diaria.roteiro_comprovacao (diaria_id, roteiro_comprovacao_origem, roteiro_comprovacao_destino) VALUES (".$Codigo. ", ".$_SESSION['ViagemOrigem'][$i].", ".$_SESSION['ViagemDestino'][$i].")";						
				pg_query(abreConexao(),$sqlInsere);
			}
		}else{
			$sql = "SELECT * FROM diaria.roteiro WHERE diaria_id = " .$Codigo;
			$rs = pg_query(abreConexao(),$sql);

			while( $linha=pg_fetch_assoc($rs)){
				$sqlInsere = "INSERT INTO diaria.roteiro_comprovacao (diaria_id, roteiro_comprovacao_origem, roteiro_comprovacao_destino) VALUES (".$Codigo.", " .$linha['roteiro_origem'].", " .$linha['roteiro_destino']. ")";
				pg_query(abreConexao(),$sqlInsere);
			}
		}			
		
		echo "<script>alert(\" Comprovação de Diária Alterada com Sucesso.!!!\");</script>";			      
		echo "<script>(window.location ='SolicitacaoInicio.php?cod=".$Codigo."&imprimir=1');</script>";
	}
?>