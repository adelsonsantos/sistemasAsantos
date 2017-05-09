<?php
include "conecta.php";

		//define o nome da pagina local para facilitar nos links
		
		if ($_GET['pagina'] == "")
		{ 
			$PaginaLocal = "SolicitacaoPreAutorizacao";
		}
		else 
		{
			$PaginaLocal = $_GET['pagina'];		
		}	

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar'] = 0;
		$_SESSION['OrigemPagina']= "SolicitacaoPreAutorizacao";
		
		$Roteiro = $_GET['roteiro'];		
		$idCoordenadoria = $_SESSION['UsuarioCoordenadoria'];							

//	echo $AcaoSistema; EXIT();
		if ($AcaoSistema == "preautorizar"){
		    $Date=date("Y-m-d");
			$Codigo = $_GET['cod'];
            $Time=date("H:i:s");
			
			// Executa consulta de alteração na Tabela Diaria para mudar o status da Diaria
			$sqlAlterar = executar_SQL("UPDATE diaria.diaria SET diaria_st = 0 WHERE diaria_id = $Codigo AND id_coordenadoria = $idCoordenadoria");
			libera_consulta($sqlAlterar); // libera consulta de alteração na Tabela Diaria
			
			//Consulta feita para pegar o ID do funcionário que está logado
			$sqlConsulta = executar_SQL("SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " .$_SESSION['UsuarioCodigo']);
			$tupla = retorna_linha($sqlConsulta);	
			
			//Inserção de daods na tabela DIARIA_PRE_AUTORIZAÇÃO
			$sqlInsere = executar_SQL("INSERT INTO diaria.diaria_pre_autorizacao(diaria_id,diaria_pre_autorizacao_func,diaria_pre_autorizacao_func_exec,diaria_pre_autorizacao_dt,diaria_pre_autorizacao_hr) VALUES (" .$Codigo. ", " .$tupla['funcionario_id'].", 1, '" .$Date."', '" .$Time. "')");

			libera_consulta($sqlInsere); // libera a consulta de inserção na tabela DIARIA_PRE_AUTORIZAÇÃO
			libera_consulta($sqlConsulta); // libera a consulta feita para pegar o ID do funcionário que está logado
			// Fecha conexão com o banco de dados
			desconectar_BD();
            echo "<script>window.location = 'SolicitacaoPreAutorizacaoInicio.php ';</script>";
      } // Fim do IF

 echo "<script>window.location = 'SolicitacaoPreAutorizacaoInicio.php ';</script>";		
?>
